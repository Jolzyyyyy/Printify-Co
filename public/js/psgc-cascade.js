(function () {
  'use strict';

  var cache = null;
  var loading = null;
  var regionNames = {
    '010000000': 'Region I - Ilocos Region',
    '020000000': 'Region II - Cagayan Valley',
    '030000000': 'Region III - Central Luzon',
    '040000000': 'Region IV-A - CALABARZON',
    '050000000': 'Region V - Bicol Region',
    '060000000': 'Region VI - Western Visayas',
    '070000000': 'Region VII - Central Visayas',
    '080000000': 'Region VIII - Eastern Visayas',
    '090000000': 'Region IX - Zamboanga Peninsula',
    '100000000': 'Region X - Northern Mindanao',
    '110000000': 'Region XI - Davao Region',
    '120000000': 'Region XII - SOCCSKSARGEN',
    '130000000': 'National Capital Region',
    '140000000': 'Cordillera Administrative Region',
    '160000000': 'Region XIII - Caraga',
    '170000000': 'MIMAROPA Region',
    '190000000': 'Bangsamoro Autonomous Region in Muslim Mindanao'
  };

  function normalize(value) {
    return String(value || '').trim().toLowerCase();
  }

  function sameName(a, b) {
    return normalize(a).replace(/\s*\(ncr\)\s*/g, '') === normalize(b).replace(/\s*\(ncr\)\s*/g, '');
  }

  function provinceAlias(value) {
    return ['ncr', 'national capital region', 'national capital region (ncr)'].includes(normalize(value))
      ? 'Metro Manila'
      : value;
  }

  function regionLabel(code) {
    return regionNames[code] || code || 'Other Region';
  }

  function readSource(source) {
    if (cache) return Promise.resolve(cache);
    if (loading) return loading;

    loading = fetch(source || '/data/ph-locations.json', { headers: { Accept: 'application/json' } })
      .then(function (response) {
        if (!response.ok) throw new Error('Unable to load Philippine location list.');
        return response.json();
      })
      .then(function (payload) {
        var regions = {};
        (payload.provinces || []).forEach(function (province) {
          var code = province.regionCode || 'other';
          if (!regions[code]) {
            regions[code] = { code: code, name: regionLabel(code), provinces: [] };
          }
          regions[code].provinces.push(province);
        });
        cache = {
          regions: Object.values(regions).sort(function (a, b) {
            return a.name.localeCompare(b.name);
          })
        };
        return cache;
      });

    return loading;
  }

  function option(value, label) {
    var node = document.createElement('option');
    node.value = value;
    node.textContent = label || value;
    return node;
  }

  function fill(select, placeholder, rows, current) {
    if (!select) return;
    select.innerHTML = '';
    select.appendChild(option('', placeholder));
    rows.forEach(function (row) {
      select.appendChild(option(row.name || row, row.name || row));
    });

    var wanted = String(current || '').trim();
    if (wanted) {
      var match = Array.from(select.options).find(function (item) {
        return sameName(item.value, wanted);
      });
      if (!match) {
        select.appendChild(option(wanted, wanted));
        select.value = wanted;
      } else {
        select.value = match.value;
      }
    } else {
      select.value = '';
    }
  }

  function findByName(rows, name) {
    return rows.find(function (row) {
      return sameName(row.name, name);
    }) || null;
  }

  function findRegion(data, currentRegion, currentProvince) {
    var byRegion = data.regions.find(function (region) {
      return sameName(region.name, currentRegion);
    });
    if (byRegion) return byRegion;

    if (currentProvince) {
      return data.regions.find(function (region) {
        return Boolean(findByName(region.provinces, currentProvince));
      }) || null;
    }

    if (sameName(currentRegion, 'Metro Manila') || sameName(currentRegion, 'NCR')) {
      return data.regions.find(function (region) {
        return region.code === '130000000';
      }) || null;
    }

    return null;
  }

  function bindCascade(config) {
    var nodes = {
      region: typeof config.region === 'string' ? document.querySelector(config.region) : config.region,
      province: typeof config.province === 'string' ? document.querySelector(config.province) : config.province,
      city: typeof config.city === 'string' ? document.querySelector(config.city) : config.city,
      barangay: typeof config.barangay === 'string' ? document.querySelector(config.barangay) : config.barangay
    };

    if (!nodes.region || !nodes.province || !nodes.city || !nodes.barangay) return Promise.resolve(null);
    var sharedRegionProvince = nodes.region === nodes.province;

    var current = Object.assign({
      region: nodes.region.dataset.current,
      province: nodes.province.dataset.current,
      city: nodes.city.dataset.current,
      barangay: nodes.barangay.dataset.current
    }, config.current || {});

    var placeholders = Object.assign({
      region: 'Select region',
      province: 'Select province',
      city: 'Select city / municipality',
      barangay: 'Select barangay'
    }, config.placeholders || {});

    return readSource(config.source).then(function (data) {
      function selectedRegion() {
        if (sharedRegionProvince) {
          return data.regions.find(function (region) {
            return Boolean(findByName(region.provinces, nodes.province.value));
          }) || null;
        }
        return findRegion(data, nodes.region.value, nodes.province.value);
      }

      function selectedProvince(region) {
        if (sharedRegionProvince) {
          for (var i = 0; i < data.regions.length; i += 1) {
            var province = findByName(data.regions[i].provinces, nodes.province.value);
            if (province) return province;
          }
          return null;
        }
        return region ? findByName(region.provinces, nodes.province.value) : null;
      }

      function selectedCity(province) {
        return province ? findByName(province.cities || [], nodes.city.value) : null;
      }

      function notify() {
        if (typeof config.onChange === 'function') config.onChange(nodes);
      }

      function populateBarangays(wantedBarangay) {
        var city = selectedCity(selectedProvince(selectedRegion()));
        var rows = city ? (city.barangays || []) : [];
        fill(nodes.barangay, placeholders.barangay, rows, wantedBarangay);
        nodes.barangay.disabled = !city;
        notify();
      }

      function populateCities(wantedCity, wantedBarangay) {
        var province = selectedProvince(selectedRegion());
        var rows = province ? (province.cities || []) : [];
        fill(nodes.city, placeholders.city, rows, wantedCity);
        nodes.city.disabled = !province;
        populateBarangays(wantedBarangay);
      }

      function populateProvinces(wantedProvince, wantedCity, wantedBarangay) {
        var region = selectedRegion();
        var rows = sharedRegionProvince
          ? data.regions.flatMap(function (item) { return item.provinces; }).sort(function (a, b) { return a.name.localeCompare(b.name); })
          : (region ? region.provinces : []);
        fill(nodes.province, placeholders.province, rows, wantedProvince);
        nodes.province.disabled = !region;
        if (sharedRegionProvince) nodes.province.disabled = false;
        populateCities(wantedCity, wantedBarangay);
      }

      var initialRegion = findRegion(data, current.region, current.province);
      if (sharedRegionProvince) {
        populateProvinces(provinceAlias(current.province || current.region), current.city, current.barangay);
      } else {
        fill(nodes.region, placeholders.region, data.regions, initialRegion ? initialRegion.name : current.region);
        populateProvinces(current.province, current.city, current.barangay);
      }

      if (!sharedRegionProvince) {
        nodes.region.addEventListener('change', function () {
          populateProvinces('', '', '');
        });
      }
      nodes.province.addEventListener('change', function () {
        populateCities('', '');
      });
      nodes.city.addEventListener('change', function () {
        populateBarangays('');
      });
      nodes.barangay.addEventListener('change', notify);

      notify();
      return nodes;
    });
  }

  window.PrintifyPsgc = {
    load: readSource,
    bindCascade: bindCascade
  };
})();

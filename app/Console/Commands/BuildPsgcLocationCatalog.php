<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class BuildPsgcLocationCatalog extends Command
{
    protected $signature = 'locations:build-psgc
        {--output=public/data/ph-locations.json : Output JSON path relative to the project root}
        {--source=https://psgc.gitlab.io/api : PSGC API base URL}';

    protected $description = 'Build the local Philippine province/city/barangay checkout catalog from PSGC data.';

    public function handle(): int
    {
        $baseUrl = rtrim((string) $this->option('source'), '/');

        $this->info('Downloading PSGC provinces...');
        $provinces = $this->fetchCollection($baseUrl . '/provinces');

        $this->info('Downloading PSGC cities and municipalities...');
        $cities = $this->fetchCollection($baseUrl . '/cities-municipalities');

        $this->info('Downloading PSGC barangays...');
        $barangays = $this->fetchCollection($baseUrl . '/barangays');

        $barangaysByLocation = [];
        foreach ($barangays as $barangay) {
            $locationCode = $barangay['cityCode'] ?: $barangay['municipalityCode'] ?: null;

            if (!$locationCode) {
                continue;
            }

            $barangaysByLocation[$locationCode][] = [
                'code' => (string) $barangay['code'],
                'name' => $this->displayName((string) $barangay['name']),
            ];
        }

        $catalog = [];
        $provinceIndexes = [];

        foreach ($provinces as $province) {
            $provinceName = $this->displayName((string) $province['name']);
            $catalog[] = [
                'code' => (string) $province['code'],
                'name' => $provinceName,
                'islandGroup' => (string) $province['islandGroupCode'],
                'regionCode' => (string) $province['regionCode'],
                'cities' => [],
            ];

            $provinceIndexes[(string) $province['code']] = count($catalog) - 1;
        }

        $metroManilaIndex = $this->addSyntheticProvince($catalog, '130000000', 'Metro Manila', 'luzon', '130000000');
        $provinceIndexes['metro-manila'] = $metroManilaIndex;

        foreach ($cities as $city) {
            $provinceCode = $city['provinceCode'] ?: null;
            $provinceIndex = $provinceCode ? ($provinceIndexes[(string) $provinceCode] ?? null) : null;

            if (!$provinceIndex && (string) $city['regionCode'] === '130000000') {
                $provinceIndex = $provinceIndexes['metro-manila'];
            }

            if (!$provinceIndex && Str::contains(Str::lower((string) $city['name']), 'zamboanga')) {
                $provinceIndex = $provinceIndexes['097300000'] ?? null;
            }

            if (!$provinceIndex && Str::contains(Str::lower((string) $city['name']), 'general santos')) {
                $provinceIndex = $provinceIndexes['126300000'] ?? null;
            }

            if ($provinceIndex === null) {
                continue;
            }

            $cityCode = (string) $city['code'];
            $catalog[$provinceIndex]['cities'][] = [
                'code' => $cityCode,
                'name' => $this->displayName((string) $city['name']),
                'type' => $city['isCity'] ? 'city' : 'municipality',
                'barangays' => $this->sortByName($barangaysByLocation[$cityCode] ?? []),
            ];
        }

        foreach ($catalog as &$province) {
            $province['cities'] = $this->sortByName($province['cities']);
        }
        unset($province);

        $catalog = $this->sortByName($catalog);

        $payload = [
            'source' => $baseUrl,
            'sourceName' => 'Philippine Standard Geographic Code (PSGC)',
            'generatedAt' => now()->toIso8601String(),
            'notes' => [
                'PSGC provides geographic province, city/municipality, and barangay names/codes.',
                'Postal ZIP codes are not part of PSGC and should remain user-entered unless a separate ZIP-code dataset is added.',
            ],
            'provinces' => $catalog,
        ];

        $outputPath = base_path((string) $this->option('output'));
        File::ensureDirectoryExists(dirname($outputPath));
        File::put($outputPath, json_encode($payload, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));

        $cityCount = collect($catalog)->sum(fn (array $province): int => count($province['cities']));
        $barangayCount = collect($catalog)->sum(
            fn (array $province): int => collect($province['cities'])->sum(fn (array $city): int => count($city['barangays']))
        );

        $this->info('Location catalog written to ' . $outputPath);
        $this->line(count($catalog) . ' province groups, ' . $cityCount . ' cities/municipalities, ' . $barangayCount . ' barangays.');

        return self::SUCCESS;
    }

    private function fetchCollection(string $url): array
    {
        $response = Http::timeout(180)->retry(3, 500)->get($url);
        $response->throw();

        return collect($response->json())->values()->all();
    }

    private function displayName(string $name): string
    {
        $name = Str::of($name)
            ->replaceMatches('/\s+/', ' ')
            ->trim()
            ->title()
            ->toString();

        if (Str::startsWith($name, 'City Of ')) {
            return Str::after($name, 'City Of ') . ' City';
        }

        return $name;
    }

    private function addSyntheticProvince(array &$catalog, string $code, string $name, string $islandGroup, string $regionCode): int
    {
        $catalog[] = [
            'code' => $code,
            'name' => $name,
            'islandGroup' => $islandGroup,
            'regionCode' => $regionCode,
            'cities' => [],
        ];

        return count($catalog) - 1;
    }

    private function sortByName(array $items): array
    {
        usort($items, fn (array $left, array $right): int => strcasecmp($left['name'], $right['name']));

        return $items;
    }
}

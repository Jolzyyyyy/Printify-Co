<?php

namespace Database\Seeders;

use App\Models\Service;
use App\Models\ServiceVariation;
use Illuminate\Database\Seeder;

class ServiceVariationSeeder extends Seeder
{
    public function run(): void
    {
        foreach (ServiceCatalogCsv::rows() as $row) {
            $serviceName = $row['service'];
            $service = Service::where('name', $serviceName)->first();

            if (!$service) {
                continue;
            }

            ServiceVariation::updateOrCreate(
                ['service_item_id' => $row['service_item_id']],
                [
                    'service_id' => $service->id,
                    'variation_image_path' => null,
                    'printing_category' => $row['printing_category'] ?: null,
                    'color_mode' => $row['color_mode'] ?: null,
                    'product_size' => $row['product_size'] ?: null,
                    'finish_type' => $row['finish_type'] ?: null,
                    'package_type' => $row['package_type'] ?: null,
                    'retail_price' => ServiceCatalogCsv::numericPrice($row['retail_price'] ?? null),
                    'bulk_price' => ServiceCatalogCsv::numericPrice($row['bulk_price'] ?? null),
                    'is_active' => true,
                ]
            );
        }
    }
}

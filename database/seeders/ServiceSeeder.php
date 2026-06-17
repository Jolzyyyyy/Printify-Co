<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Service;

class ServiceSeeder extends Seeder
{
    public function run(): void
    {
        foreach ($this->servicesFromCatalog() as $service) {
            Service::updateOrCreate(
                ['name' => $service['name']],
                $service
            );
        }
    }

    private function servicesFromCatalog(): array
    {
        $descriptions = [
            'Checkout Preview Printing' => 'Internal checkout preview item used to verify checkout pricing.',
            'Custom Special Printing' => 'Special custom printing services.',
            'Document Printing' => 'Professional document printing services.',
            'ID & Photo Services' => 'Professional ID and photo printing services.',
            'Lamination & Binding' => 'Document lamination and binding.',
            'Large Format Printing' => 'Tarpaulin and large format printing.',
            'Photocopy & Scanning' => 'High speed photocopy and scanning services.',
        ];

        $images = [
            'Checkout Preview Printing' => 'images/services/document-printing.jpg',
            'Custom Special Printing' => 'images/services/custom.jpg',
            'Document Printing' => 'images/services/document-printing.jpg',
            'ID & Photo Services' => 'images/services/id-photo.jpg',
            'Lamination & Binding' => 'images/services/lamination.jpg',
            'Large Format Printing' => 'images/services/tarpaulin.jpg',
            'Photocopy & Scanning' => 'images/services/photocopy.jpg',
        ];

        return collect(ServiceCatalogCsv::rows())
            ->groupBy('service')
            ->map(function ($rows, string $serviceName) use ($descriptions, $images) {
                $category = $rows->first()['category'] ?? null;
                $retailPrices = $rows
                    ->map(fn ($row) => ServiceCatalogCsv::numericPrice($row['retail_price'] ?? null))
                    ->filter(fn ($price) => $price > 0);
                $bulkPrices = $rows
                    ->map(fn ($row) => ServiceCatalogCsv::numericPrice($row['bulk_price'] ?? null))
                    ->filter(fn ($price) => $price > 0);

                return [
                    'name' => $serviceName,
                    'category' => $category,
                    'retail_price' => $retailPrices->min() ?? 0,
                    'bulk_price' => $bulkPrices->min() ?? 0,
                    'description' => $descriptions[$serviceName] ?? 'Printing service.',
                    'image_path' => $images[$serviceName] ?? null,
                    'is_active' => true,
                ];
            })
            ->sortKeys()
            ->values()
            ->all();
    }
}

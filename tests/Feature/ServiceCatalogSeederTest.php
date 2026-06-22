<?php

namespace Tests\Feature;

use App\Models\Service;
use App\Models\ServiceVariation;
use Database\Seeders\ServiceSeeder;
use Database\Seeders\ServiceVariationSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ServiceCatalogSeederTest extends TestCase
{
    use RefreshDatabase;

    public function test_service_catalog_seeders_import_the_full_csv_catalog(): void
    {
        $this->seed(ServiceSeeder::class);
        $this->seed(ServiceVariationSeeder::class);

        $this->assertSame(7, Service::count());
        $this->assertSame(647, ServiceVariation::count());

        $this->assertDatabaseHas('services', [
            'name' => 'Document Printing',
            'category' => 'Printing',
            'retail_price' => 5,
            'bulk_price' => 3,
            'is_active' => true,
        ]);

        $this->assertDatabaseHas('service_variations', [
            'service_item_id' => 'DOC-TX-BW-SHT-CS',
            'printing_category' => 'Text Only',
            'color_mode' => 'B&W',
            'product_size' => 'Short (8.5 x 11)',
            'finish_type' => 'Collated Set',
            'retail_price' => 5,
            'bulk_price' => 3,
            'is_active' => true,
        ]);

        $this->assertDatabaseHas('service_variations', [
            'service_item_id' => 'CSP-LYT-STD-A4-CQ',
            'printing_category' => 'Custom Layout',
            'color_mode' => 'Standard Production',
            'product_size' => 'A4',
            'finish_type' => 'Custom Quote',
            'retail_price' => 150,
            'bulk_price' => 140,
            'is_active' => true,
        ]);
    }
}

<?php

namespace Tests\Feature;

use App\Models\Service;
use App\Models\ServiceVariation;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CartFeatureTest extends TestCase
{
    use RefreshDatabase;

    public function test_homepage_cart_sync_maps_service_code_to_database_variation_and_merges_duplicates(): void
    {
        [$service, $variation] = $this->createServiceWithVariation([
            'name' => 'Document Printing',
            'category' => 'Printing',
            'image_path' => 'services/document-printing.jpg',
        ], [
            'service_item_id' => 'DOC-TXT-BW-SHT-001',
            'printing_category' => 'Text Only',
            'color_mode' => 'B&W',
            'product_size' => 'Short (8.5 x 11)',
            'retail_price' => 5,
            'bulk_price' => 4,
        ]);
        $customer = $this->verifiedCustomer();

        $this
            ->actingAs($customer)
            ->withSession(['customer_otp_passed' => true])
            ->postJson(route('cart.sync', absolute: false), [
                'items' => [
                    [
                        'name' => 'Browser label should not win',
                        'qty' => 2,
                        'unit_price' => 999,
                        'service_code' => 'DOC-TXT-BW-SHT-001',
                        'price_type' => 'retail',
                    ],
                    [
                        'name' => 'Same item again',
                        'qty' => 3,
                        'unit_price' => 999,
                        'service_item_id' => 'DOC-TXT-BW-SHT-001',
                        'price_type' => 'retail',
                    ],
                ],
            ])
            ->assertOk()
            ->assertJson(['ok' => true]);

        $cartKey = "{$service->id}_{$variation->id}_retail";
        $cart = session('cart');

        $this->assertArrayHasKey($cartKey, $cart);
        $this->assertCount(1, $cart);
        $this->assertSame(5, $cart[$cartKey]['qty']);
        $this->assertSame($service->id, $cart[$cartKey]['service_id']);
        $this->assertSame($variation->id, $cart[$cartKey]['variation_id']);
        $this->assertSame('DOC-TXT-BW-SHT-001', $cart[$cartKey]['service_item_id']);
        $this->assertSame('Document Printing', $cart[$cartKey]['name']);
        $this->assertSame('Text Only / B&W / Short (8.5 x 11)', $cart[$cartKey]['variation_label']);
        $this->assertSame(5.0, $cart[$cartKey]['price']);
    }

    public function test_homepage_cart_sync_uses_bulk_database_price_for_service_item_id(): void
    {
        [$service, $variation] = $this->createServiceWithVariation([
            'name' => 'Bulk Flyers',
        ], [
            'service_item_id' => 'DOC-IMG-FC-A4-001',
            'retail_price' => 20,
            'bulk_price' => 12,
        ]);
        $customer = $this->verifiedCustomer();

        $this
            ->actingAs($customer)
            ->withSession(['customer_otp_passed' => true])
            ->postJson(route('cart.sync', absolute: false), [
                'items' => [
                    [
                        'name' => 'Bulk Flyers',
                        'qty' => 4,
                        'unit_price' => 999,
                        'service_code' => 'DOC-IMG-FC-A4-001',
                        'price_type' => 'bulk',
                    ],
                ],
            ])
            ->assertOk();

        $cartKey = "{$service->id}_{$variation->id}_bulk";
        $cart = session('cart');

        $this->assertSame(12.0, $cart[$cartKey]['price']);
        $this->assertSame('bulk', $cart[$cartKey]['price_type']);
    }

    /**
     * @return array{0: \App\Models\Service, 1: \App\Models\ServiceVariation}
     */
    private function createServiceWithVariation(array $serviceAttributes = [], array $variationAttributes = []): array
    {
        $service = Service::create(array_merge([
            'name' => 'Test Printing',
            'category' => 'Printing',
            'retail_price' => 25,
            'bulk_price' => 20,
            'unit' => 'page',
            'description' => 'Test service',
            'is_active' => true,
        ], $serviceAttributes));

        $variation = ServiceVariation::create(array_merge([
            'service_id' => $service->id,
            'service_item_id' => 'TEST-A4-BW',
            'printing_category' => 'Text Only',
            'color_mode' => 'B&W',
            'product_size' => 'A4',
            'retail_price' => 25,
            'bulk_price' => 20,
            'is_active' => true,
        ], $variationAttributes));

        return [$service, $variation];
    }

    private function verifiedCustomer(): User
    {
        return User::factory()->create([
            'role' => User::ROLE_CUSTOMER,
            'email_verified_at' => now(),
        ]);
    }
}

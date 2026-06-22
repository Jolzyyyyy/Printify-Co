<?php

namespace Tests\Feature\Auth;

use App\Mail\OrderReceiptMail;
use App\Models\Order;
use App\Models\Service;
use App\Models\ServiceVariation;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ServiceOrderingAccessTest extends TestCase
{
    use RefreshDatabase;

    public function test_guests_can_browse_services_and_service_details(): void
    {
        $service = $this->serviceWithVariation();

        $this->get(route('services.index'))
            ->assertOk();

        $this->get(route('services.show', $service))
            ->assertOk()
            ->assertSee($service->name);

        $this->get(route('landing.service-details'))
            ->assertOk();
    }

    public function test_order_tracking_uses_the_original_customer_navigation_and_linked_breadcrumbs(): void
    {
        $customer = User::factory()->create([
            'role' => 'customer',
            'email_verified_at' => now(),
        ]);
        $order = Order::create([
            'user_id' => $customer->id,
            'order_reference' => 'PFY-NAV-TEST',
            'customer_name' => $customer->name,
            'customer_email' => $customer->email,
            'customer_phone' => '+639171234567',
            'status' => 'paid',
            'total_price' => 100,
        ]);

        $this
            ->actingAs($customer)
            ->withSession(['customer_otp_passed' => true])
            ->get(route('co.place-order.tracking', $order))
            ->assertOk()
            ->assertSee('id="customerOriginalHeader"', false)
            ->assertSeeInOrder(['HOME', 'ABOUT US', 'SERVICES', 'CONTACT US'])
            ->assertSeeInOrder(['Back to Home', 'Dashboard', 'My Orders', 'Order Tracking'])
            ->assertSee('href="'.route('dashboard').'"', false)
            ->assertSee('href="'.route('co.place-order').'"', false)
            ->assertDontSee('MY TEMPLATES');
    }

    public function test_guest_ordering_actions_redirect_to_customer_login(): void
    {
        $service = $this->serviceWithVariation();
        $variation = $service->activeVariations()->firstOrFail();

        $this->post(route('cart.add', $service), [
            'service_variation_id' => $variation->id,
            'qty' => 1,
            'price_type' => 'retail',
        ])->assertRedirect(route('login', absolute: false));

        $this->get(route('cart.index'))
            ->assertRedirect(route('login', absolute: false));

        $this->get(route('checkout.index'))
            ->assertRedirect(route('login', absolute: false));

        $this->post(route('payment.start'), [
            'payment_method' => 'gcash',
        ])->assertRedirect(route('login', absolute: false));
    }

    public function test_verified_customer_can_open_checkout(): void
    {
        $customer = User::factory()->create([
            'role' => 'customer',
            'email_verified_at' => now(),
            'first_name' => 'Julie',
            'last_name' => 'Anne Calusa',
            'email' => 'julieannecalusa@gmail.com',
            'phone' => '09272902721',
        ]);

        $this->actingAs($customer)
            ->withSession(['customer_otp_passed' => true])
            ->get(route('checkout.index'))
            ->assertOk()
            ->assertSee('value="Julie"', false)
            ->assertSee('value="Anne Calusa"', false)
            ->assertSee('value="julieannecalusa@gmail.com"', false)
            ->assertSee('value="+639272902721"', false)
            ->assertSee('<select id="province"', false)
            ->assertSee('<select id="city"', false)
            ->assertSee('<select id="barangay"', false)
            ->assertSee('Barangay')
            ->assertSee('data/ph-locations.json');
    }

    public function test_payment_start_requires_complete_customer_and_shipping_details(): void
    {
        $customer = User::factory()->create([
            'role' => 'customer',
            'email_verified_at' => now(),
        ]);

        $response = $this
            ->actingAs($customer)
            ->withSession([
                'customer_otp_passed' => true,
                'cart' => $this->checkoutCart(),
            ])
            ->postJson(route('payment.start'), [
                'payment_method' => 'gcash',
                'checkout' => [
                    'customer' => [
                        'firstName' => 'Julie',
                        'lastName' => 'Anne Calusa',
                        'email' => 'julieannecalusa@gmail.com',
                        'phone' => '+639272902721',
                    ],
                    'delivery' => [
                        'name' => 'Lalamove On-demand',
                        'type' => 'lalamove',
                    ],
                    'shippingAddress' => [
                        'street' => 'Blk 6 Lot 8',
                        'apartment' => '',
                        'province' => 'Metro Manila',
                        'city' => 'Quezon City',
                        'barangay' => 'Batasan Hills',
                        'postal' => '1126',
                        'country' => 'Philippines',
                    ],
                ],
            ]);

        $response->assertUnprocessable()
            ->assertJsonValidationErrors('checkout.shippingAddress.apartment');
    }

    public function test_payment_start_allows_pickup_without_shipping_address(): void
    {
        Http::fake([
            'api.paymongo.com/*' => Http::response([
                'data' => [
                    'id' => 'cs_test_pickup',
                    'attributes' => [
                        'checkout_url' => 'https://checkout.test/paymongo',
                    ],
                ],
            ]),
        ]);

        config()->set('services.paymongo.secret_key', 'sk_test_printify');
        $this->serviceWithVariation();

        $customer = User::factory()->create([
            'role' => 'customer',
            'email_verified_at' => now(),
        ]);

        $payload = $this->completeCheckoutPayload();
        $payload['delivery'] = [
            'name' => 'Store Pick-up',
            'type' => 'pickup',
        ];
        unset($payload['shippingAddress']);

        $response = $this
            ->actingAs($customer)
            ->withSession([
                'customer_otp_passed' => true,
                'cart' => $this->checkoutCart(),
            ])
            ->postJson(route('payment.start'), [
                'payment_method' => 'gcash',
                'checkout' => $payload,
            ]);

        $response->assertOk()
            ->assertJsonPath('redirect_url', 'https://checkout.test/paymongo');

        $this->assertSame('pickup', session('checkout_details.delivery.type'));
        $this->assertArrayNotHasKey('shippingAddress', session('checkout_details'));

        $this->assertSame('cs_test_pickup', session('checkout_provider_id'));
        $this->assertDatabaseCount('orders', 0);
    }

    public function test_payment_start_stores_complete_checkout_details_for_receipt_and_delivery(): void
    {
        Http::fake([
            'api.paymongo.com/*' => Http::response([
                'data' => [
                    'id' => 'cs_test_lalamove',
                    'attributes' => [
                        'checkout_url' => 'https://checkout.test/paymongo',
                    ],
                ],
            ]),
        ]);

        config()->set('services.paymongo.secret_key', 'sk_test_printify');
        $this->serviceWithVariation();

        $customer = User::factory()->create([
            'role' => 'customer',
            'email_verified_at' => now(),
        ]);

        $response = $this
            ->actingAs($customer)
            ->withSession([
                'customer_otp_passed' => true,
                'cart' => $this->checkoutCart(),
            ])
            ->postJson(route('payment.start'), [
                'payment_method' => 'gcash',
                'checkout' => $this->completeCheckoutPayload(),
            ]);

        $response->assertOk()
            ->assertJsonPath('redirect_url', 'https://checkout.test/paymongo');

        $this->assertSame(
            '+639272902721',
            session('checkout_details.customer.phone')
        );

        $this->assertSame(
            'Batasan Hills',
            session('checkout_details.shippingAddress.barangay')
        );

        $this->assertSame('cs_test_lalamove', session('checkout_provider_id'));
        $this->assertSame('lalamove', session('checkout_details.delivery.type'));
        $this->assertSame('Batasan Hills', session('checkout_details.shippingAddress.barangay'));
        $this->assertDatabaseCount('orders', 0);
    }

    public function test_paymongo_paid_webhook_sends_receipt_and_prepares_delivery_booking(): void
    {
        Mail::fake();
        Storage::fake('local');
        Http::fake([
            'api.paymongo.com/*' => Http::response([
                'data' => [
                    'id' => 'cs_test_paid',
                    'attributes' => [
                        'checkout_url' => 'https://checkout.test/paymongo',
                    ],
                ],
            ]),
        ]);

        config()->set('services.paymongo.secret_key', 'sk_test_printify');
        config()->set('services.lalamove.api_key', null);
        $service = $this->serviceWithVariation();
        $variation = $service->activeVariations()->firstOrFail();

        $customer = User::factory()->create([
            'role' => 'customer',
            'email_verified_at' => now(),
        ]);

        $order = Order::create([
            'user_id' => $customer->id,
            'order_reference' => 'PFY-WEBHOOK-TEST',
            'customer_name' => 'Julie Anne Calusa',
            'customer_email' => 'julieannecalusa@gmail.com',
            'customer_phone' => '+639272902721',
            'status' => 'pending_payment',
            'total_price' => 20,
            'checkout_details' => $this->completeCheckoutPayload(),
            'payment_method' => 'gcash',
            'payment_provider' => 'paymongo',
            'payment_checkout_id' => 'cs_test_paid',
            'delivery_method' => 'lalamove',
            'delivery_address' => 'Blk 6 Lot 8 Commonwealth Ave, Batasan Hills, Quezon City',
        ]);
        $order->items()->create([
            'service_id' => $service->id,
            'service_variation_id' => $variation->id,
            'service_item_id' => $variation->service_item_id,
            'service_name' => $service->name,
            'variation_label' => $variation->variation_label,
            'price_type' => 'retail',
            'unit_price' => 10,
            'quantity' => 2,
            'subtotal' => 20,
        ]);

        $this->postJson(route('payment.paymongo.webhook'), [
            'data' => [
                'attributes' => [
                    'type' => 'checkout_session.payment.paid',
                    'data' => [
                        'id' => 'cs_test_paid',
                        'attributes' => [
                            'payments' => [
                                ['id' => 'pay_test_123'],
                            ],
                        ],
                    ],
                ],
            ],
        ])->assertOk()
            ->assertJsonPath('ok', true);

        $order->refresh();
        $this->assertSame('paid', $order->status);
        $this->assertSame('pay_test_123', $order->payment_reference);
        $this->assertNotNull($order->paid_at);
        $this->assertNotNull($order->receipt_number);
        $this->assertNotNull($order->receipt_pdf_path);
        $this->assertNotNull($order->receipt_sent_at);
        $this->assertSame('pending_lalamove_configuration', $order->delivery_booking_status);
        Storage::disk('local')->assertExists($order->receipt_pdf_path);
        $this->assertStringStartsWith('%PDF', Storage::disk('local')->get($order->receipt_pdf_path));

        Mail::assertSent(OrderReceiptMail::class, function (OrderReceiptMail $mail) {
            return $mail->hasTo('julieannecalusa@gmail.com');
        });
    }

    public function test_paymongo_webhook_rejects_missing_signature_when_secret_is_configured(): void
    {
        config()->set('services.paymongo.webhook_secret', 'whsec_test_printify');

        $this->postJson(route('payment.paymongo.webhook'), [
            'data' => [
                'attributes' => [
                    'type' => 'checkout_session.payment.paid',
                ],
            ],
        ])->assertUnauthorized()
            ->assertJsonPath('ok', false);
    }

    public function test_psgc_location_catalog_contains_full_checkout_cascade_data(): void
    {
        $path = public_path('data/ph-locations.json');

        $this->assertFileExists($path);

        $catalog = json_decode((string) file_get_contents($path), true);
        $this->assertIsArray($catalog);
        $this->assertSame('Philippine Standard Geographic Code (PSGC)', $catalog['sourceName'] ?? null);
        $this->assertGreaterThan(80, count($catalog['provinces'] ?? []));

        $metroManila = collect($catalog['provinces'])->firstWhere('name', 'Metro Manila');
        $this->assertNotNull($metroManila);

        $quezonCity = collect($metroManila['cities'])->firstWhere('name', 'Quezon City');
        $this->assertNotNull($quezonCity);

        $this->assertNotNull(collect($quezonCity['barangays'])->firstWhere('name', 'Batasan Hills'));
    }

    private function serviceWithVariation(): Service
    {
        $service = Service::create([
            'name' => 'Document Printing',
            'category' => 'Printing',
            'retail_price' => 10,
            'bulk_price' => 8,
            'unit' => 'page',
            'description' => 'Print documents in store quality.',
            'is_active' => true,
        ]);

        ServiceVariation::create([
            'service_id' => $service->id,
            'service_item_id' => 'DOC-TXT-BW-A4-001',
            'printing_category' => 'Text Only',
            'color_mode' => 'B&W',
            'product_size' => 'A4',
            'finish_type' => 'Standard',
            'package_type' => 'Package A',
            'retail_price' => 10,
            'bulk_price' => 8,
            'is_active' => true,
        ]);

        return $service;
    }

    private function checkoutCart(): array
    {
        return [
            'DOC-TXT-BW-A4-001' => [
                'service_id' => 1,
                'variation_id' => 1,
                'service_item_id' => 'DOC-TXT-BW-A4-001',
                'name' => 'Document Printing',
                'category' => 'Printing',
                'variation_label' => 'B&W / A4',
                'unit' => 'page',
                'price' => 10,
                'price_type' => 'retail',
                'qty' => 2,
            ],
        ];
    }

    private function completeCheckoutPayload(): array
    {
        return [
            'customer' => [
                'firstName' => 'Julie',
                'lastName' => 'Anne Calusa',
                'email' => 'julieannecalusa@gmail.com',
                'phone' => '09272902721',
            ],
            'delivery' => [
                'name' => 'Lalamove On-demand',
                'type' => 'lalamove',
            ],
            'shippingAddress' => [
                'street' => 'Blk 6 Lot 8 Commonwealth Ave',
                'apartment' => 'Unit 2, near main gate',
                'province' => 'Metro Manila',
                'city' => 'Quezon City',
                'barangay' => 'Batasan Hills',
                'postal' => '1126',
                'country' => 'Philippines',
            ],
        ];
    }
}

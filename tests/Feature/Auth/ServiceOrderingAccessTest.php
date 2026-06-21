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

        $order = Order::firstOrFail();
        $this->assertSame('pending_payment', $order->status);
        $this->assertSame('pickup', $order->delivery_method);
        $this->assertSame('cs_test_pickup', $order->payment_checkout_id);
        $this->assertCount(1, $order->items);
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

        $order = Order::firstOrFail();
        $this->assertSame('pending_payment', $order->status);
        $this->assertSame('PFY-', substr((string) $order->order_reference, 0, 4));
        $this->assertSame('+639272902721', $order->customer_phone);
        $this->assertSame('lalamove', $order->delivery_method);
        $this->assertSame('cs_test_lalamove', $order->payment_checkout_id);
        $this->assertStringContainsString('Batasan Hills', (string) $order->delivery_address);
        $this->assertSame('DOC-TXT-BW-A4-001', $order->items()->first()?->service_item_id);
    }

    public function test_customer_order_tracking_uses_real_order_checkout_and_item_details(): void
    {
        $service = $this->serviceWithVariation();
        $variation = $service->activeVariations()->firstOrFail();
        $customer = User::factory()->create([
            'role' => 'customer',
            'email_verified_at' => now(),
            'name' => 'Sonny Quinton',
        ]);

        $order = Order::create([
            'user_id' => $customer->id,
            'order_reference' => 'PFY-TRACK-REAL',
            'customer_name' => 'Sonny Quinton',
            'customer_email' => 'sonny@example.com',
            'customer_phone' => '+639451751414',
            'status' => 'paid',
            'total_price' => 299,
            'checkout_details' => [
                'delivery' => [
                    'type' => 'lalamove',
                    'name' => 'Lalamove On-demand',
                ],
                'shippingAddress' => [
                    'street' => "Jenny's Ave",
                    'apartment' => '88',
                    'barangay' => 'Bagong Katipunan',
                    'city' => 'Pasig City',
                    'province' => 'Metro Manila',
                    'postal' => '1600',
                    'country' => 'Philippines',
                ],
            ],
            'payment_method' => 'gcash',
            'payment_reference' => 'pay_real_123',
            'paid_at' => now(),
            'delivery_method' => 'lalamove',
            'delivery_fee' => 284,
            'delivery_address' => "Jenny's Ave, 88, Bagong Katipunan, Pasig City, Metro Manila, 1600, Philippines",
            'delivery_notes' => 'Leave at front desk',
            'lalamove_status' => 'ASSIGNING_DRIVER',
        ]);

        $order->items()->create([
            'service_id' => $service->id,
            'service_variation_id' => $variation->id,
            'service_item_id' => 'DOC-TXT-BW-A4-001',
            'service_name' => 'Document Printing',
            'variation_label' => 'Text Only / B&W / A4 / Standard / Package A',
            'price_type' => 'retail',
            'unit_price' => 15,
            'quantity' => 1,
            'subtotal' => 15,
        ]);

        $order->files()->create([
            'original_name' => 'Shaping the Filipino to be heroes.docx',
            'path' => 'order-files/1/heroes.docx',
            'mime' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            'size' => 12345,
        ]);

        $this
            ->actingAs($customer)
            ->withSession(['customer_otp_passed' => true])
            ->get(route('co.place-order.tracking', $order))
            ->assertOk()
            ->assertSee('PFY-TRACK-REAL')
            ->assertSee('Document Printing')
            ->assertSee('DOC-TXT-BW-A4-001')
            ->assertSee('Text Only')
            ->assertSee('B&amp;W', false)
            ->assertSee('GCash')
            ->assertSee('pay_real_123')
            ->assertSee("Jenny&#039;s Ave", false)
            ->assertSee('Leave at front desk')
            ->assertSee('Shaping the Filipino to be heroes.docx')
            ->assertDontSee('Text Only Printing')
            ->assertDontSee('80gsm White')
            ->assertDontSee('Back to Order Details');

        $this
            ->actingAs($customer)
            ->withSession(['customer_otp_passed' => true])
            ->get(route('co.place-order.show', $order))
            ->assertRedirect(route('co.place-order.tracking', $order, absolute: false));
    }

    public function test_customer_can_retry_lalamove_booking_and_store_real_tracking_fields(): void
    {
        Http::fake([
            'rest.sandbox.lalamove.com/v3/quotations' => Http::response([
                'data' => [
                    'quotationId' => 'quote_real_123',
                    'stops' => [
                        ['stopId' => 'pickup-stop'],
                        ['stopId' => 'dropoff-stop'],
                    ],
                ],
            ]),
            'rest.sandbox.lalamove.com/v3/orders' => Http::response([
                'data' => [
                    'orderId' => 'LALA-ORDER-123',
                    'status' => 'ASSIGNING_DRIVER',
                    'driverId' => null,
                    'shareLink' => 'https://share.lalamove.test/LALA-ORDER-123',
                ],
            ]),
        ]);

        config()->set('services.lalamove.api_key', 'pk_test_lalamove');
        config()->set('services.lalamove.api_secret', 'sk_test_lalamove');

        $service = $this->serviceWithVariation();
        $variation = $service->activeVariations()->firstOrFail();
        $customer = User::factory()->create([
            'role' => 'customer',
            'email_verified_at' => now(),
        ]);

        $order = Order::create([
            'user_id' => $customer->id,
            'order_reference' => 'PFY-LALA-REAL',
            'customer_name' => 'Sonny Quinton',
            'customer_email' => 'sonny@example.com',
            'customer_phone' => '+639451751414',
            'status' => 'paid',
            'total_price' => 299,
            'payment_method' => 'gcash',
            'paid_at' => now(),
            'delivery_method' => 'lalamove',
            'delivery_fee' => 284,
            'delivery_address' => "Jenny's Ave, Pasig City, Metro Manila, Philippines",
            'delivery_latitude' => 14.5764,
            'delivery_longitude' => 121.0851,
            'delivery_booking_status' => 'lalamove_booking_failed',
            'lalamove_status' => 'BOOKING_FAILED',
        ]);

        $order->items()->create([
            'service_id' => $service->id,
            'service_variation_id' => $variation->id,
            'service_item_id' => 'DOC-TXT-BW-A4-001',
            'service_name' => 'Document Printing',
            'variation_label' => 'Text Only / B&W / A4 / Standard / Package A',
            'price_type' => 'retail',
            'unit_price' => 15,
            'quantity' => 1,
            'subtotal' => 15,
        ]);

        $this
            ->actingAs($customer)
            ->withSession(['customer_otp_passed' => true])
            ->from(route('co.place-order.tracking', $order))
            ->post(route('orders.delivery.book', $order))
            ->assertRedirect(route('co.place-order.tracking', $order, absolute: false));

        $order->refresh();

        $this->assertSame('booked_lalamove', $order->delivery_booking_status);
        $this->assertSame('LALA-ORDER-123', $order->delivery_tracking_number);
        $this->assertSame('https://share.lalamove.test/LALA-ORDER-123', $order->delivery_tracking_url);
        $this->assertSame('LALA-ORDER-123', $order->lalamove_order_id);
        $this->assertSame('ASSIGNING_DRIVER', $order->lalamove_status);
        $this->assertNotNull($order->delivery_booked_at);
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
        $this->serviceWithVariation();

        $customer = User::factory()->create([
            'role' => 'customer',
            'email_verified_at' => now(),
        ]);

        $this
            ->actingAs($customer)
            ->withSession([
                'customer_otp_passed' => true,
                'cart' => $this->checkoutCart(),
            ])
            ->postJson(route('payment.start'), [
                'payment_method' => 'gcash',
                'checkout' => $this->completeCheckoutPayload(),
            ])
            ->assertOk();

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

        $order = Order::firstOrFail();
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

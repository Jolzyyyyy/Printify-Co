<?php

namespace Tests\Feature;

use App\Models\EReceiptRequest;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class EReceiptCheckoutFlowTest extends TestCase
{
    use RefreshDatabase;

    private function customer(): User
    {
        return User::factory()->create(['role' => 'customer']);
    }

    public function test_submitting_invoice_request_marks_current_checkout_session_complete(): void
    {
        $user = $this->customer();

        $response = $this->actingAs($user)
            ->withSession(['customer_otp_passed' => true])
            ->postJson(route('e-receipt.store'), [
                'receipt_type' => 'personal',
                'full_name' => 'Juan Dela Cruz',
                'tin' => '123-456-789',
                'region' => 'NCR',
                'province' => 'Metro Manila',
                'city' => 'Quezon City',
                'barangay' => 'Commonwealth',
                'postal_code' => '1121',
                'street_address' => 'Blk 6 Lot 8 Ninada St.',
                'consent' => true,
            ]);

        $receipt = EReceiptRequest::firstOrFail();
        $response->assertCreated()
            ->assertJsonPath('ok', true)
            ->assertSessionHas('checkout_e_receipt_request_id', $receipt->id);

        $this->actingAs($user)
            ->withSession([
                'customer_otp_passed' => true,
                'checkout_e_receipt_request_id' => $receipt->id,
            ])
            ->getJson(route('e-receipt.show'))
            ->assertOk()
            ->assertJsonPath('request_complete', true)
            ->assertJsonPath('receipt.id', $receipt->id);
    }

    public function test_received_receipt_upload_requires_successful_payment_and_is_persisted(): void
    {
        Storage::fake('local');
        $user = $this->customer();
        $receipt = EReceiptRequest::create([
            'user_id' => $user->id,
            'receipt_type' => 'personal',
            'full_name' => 'Juan Dela Cruz',
            'region' => 'NCR',
            'province' => 'Metro Manila',
            'city' => 'Quezon City',
            'barangay' => 'Commonwealth',
            'postal_code' => '1121',
            'street_address' => 'Blk 6 Lot 8 Ninada St.',
            'status' => 'submitted',
        ]);

        $session = [
            'customer_otp_passed' => true,
            'checkout_e_receipt_request_id' => $receipt->id,
        ];

        $this->actingAs($user)->withSession($session)
            ->postJson(route('e-receipt.upload'), [
                'receipt_file' => UploadedFile::fake()->create('payment-receipt.pdf', 120, 'application/pdf'),
            ])
            ->assertUnprocessable();

        $response = $this->actingAs($user)->withSession($session + ['checkout_payment_verified' => true])
            ->postJson(route('e-receipt.upload'), [
                'receipt_file' => UploadedFile::fake()->create('payment-receipt.pdf', 120, 'application/pdf'),
            ]);

        $response->assertOk()
            ->assertJsonPath('ok', true)
            ->assertJsonPath('receipt.uploaded_receipt_name', 'payment-receipt.pdf');

        $receipt->refresh();
        $this->assertSame('receipt_uploaded', $receipt->status);
        $this->assertNotNull($receipt->uploaded_receipt_at);
        Storage::disk('local')->assertExists($receipt->uploaded_receipt_path);
    }

    public function test_service_detail_and_checkout_routes_do_not_render_public_page_or_footer(): void
    {
        $this->get(route('landing.service-details'))
            ->assertOk()
            ->assertDontSee('id="pageWrapper"', false)
            ->assertDontSee('class="printify-footer"', false)
            ->assertSee('id="serviceDetail"', false);

        $user = $this->customer();
        $this->actingAs($user)->withSession(['customer_otp_passed' => true])
            ->get(route('checkout.index'))
            ->assertOk()
            ->assertDontSee('id="pageWrapper"', false)
            ->assertDontSee('class="printify-footer"', false)
            ->assertSee('id="checkout"', false);
    }
}

<?php

namespace App\Services;

use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use RuntimeException;

class LalamoveClient
{
    public function quotation(array $dropoff, array $item = []): array
    {
        return $this->request('POST', '/v3/quotations', [
            'data' => [
                'serviceType' => config('services.lalamove.service_type', 'MOTORCYCLE'),
                'language' => config('services.lalamove.language', 'en_PH'),
                'stops' => [$this->pickupStop(), [
                    'coordinates' => ['lat' => (string) $dropoff['lat'], 'lng' => (string) $dropoff['lng']],
                    'address' => $dropoff['address'],
                ]],
                'item' => array_filter([
                    'quantity' => (string) ($item['quantity'] ?? 1),
                    'weight' => $item['weight'] ?? 'LESS_THAN_3KG',
                    'categories' => $item['categories'] ?? ['OFFICE_ITEM'],
                    'handlingInstructions' => $item['handlingInstructions'] ?? ['KEEP_DRY'],
                ]),
            ],
        ]);
    }

    public function placeOrder(array $quotation, array $contact): array
    {
        $stops = data_get($quotation, 'data.stops', []);
        if (count($stops) < 2) {
            throw new RuntimeException('Lalamove quotation does not contain valid stops.');
        }

        return $this->request('POST', '/v3/orders', ['data' => [
            'quotationId' => data_get($quotation, 'data.quotationId'),
            'sender' => [
                'stopId' => data_get($stops, '0.stopId'),
                'name' => config('services.lalamove.pickup_name', 'Printify & Co.'),
                'phone' => config('services.lalamove.pickup_phone'),
            ],
            'recipients' => [[
                'stopId' => data_get($stops, '1.stopId'),
                'name' => $contact['name'],
                'phone' => $contact['phone'],
                'remarks' => (string) ($contact['remarks'] ?? ''),
            ]],
            'isPODEnabled' => true,
        ]], ['Request-ID' => (string) Str::uuid()]);
    }

    public function order(string $orderId): array
    {
        return $this->request('GET', '/v3/orders/' . rawurlencode($orderId));
    }

    public function driver(string $orderId, string $driverId): array
    {
        return $this->request('GET', '/v3/orders/' . rawurlencode($orderId) . '/drivers/' . rawurlencode($driverId));
    }

    private function pickupStop(): array
    {
        return [
            'coordinates' => [
                'lat' => (string) config('services.lalamove.pickup_lat'),
                'lng' => (string) config('services.lalamove.pickup_lng'),
            ],
            'address' => config('services.lalamove.pickup_address'),
        ];
    }

    private function request(string $method, string $path, array $payload = [], array $headers = []): array
    {
        $apiKey = trim((string) config('services.lalamove.api_key'));
        $secret = trim((string) config('services.lalamove.api_secret'));
        if ($apiKey === '' || $secret === '') {
            throw new RuntimeException('Lalamove test credentials are not configured.');
        }

        $body = $payload === [] ? '' : json_encode($payload, JSON_UNESCAPED_SLASHES);
        $timestamp = (string) round(microtime(true) * 1000);
        $signature = hash_hmac('sha256', $timestamp . "\r\n" . strtoupper($method) . "\r\n" . $path . "\r\n\r\n" . $body, $secret);
        $request = $this->http()->withHeaders(array_merge([
            'Authorization' => "hmac {$apiKey}:{$timestamp}:{$signature}",
            'Market' => config('services.lalamove.market', 'PH'),
            'Request-ID' => (string) Str::uuid(),
        ], $headers));

        $response = $body === ''
            ? $request->send($method, $path)
            : $request->withBody($body, 'application/json')->send($method, $path);

        if (!$response->successful()) {
            $message = data_get($response->json(), 'message')
                ?: data_get($response->json(), 'errors.0.message')
                ?: data_get($response->json(), 'errors.message')
                ?: data_get($response->json(), 'errors.0.detail')
                ?: data_get($response->json(), 'errors.detail')
                ?: $response->body();
            throw new RuntimeException('Lalamove API error: ' . $message);
        }

        return $response->json();
    }

    private function http(): PendingRequest
    {
        return Http::baseUrl(rtrim((string) config('services.lalamove.base_url'), '/'))
            ->acceptJson()->timeout(30)->retry(2, 300);
    }
}

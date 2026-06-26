<?php

namespace App\Http\Controllers;

use App\Models\EReceiptRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class EReceiptController extends Controller
{
    public function show(Request $request): JsonResponse
    {
        $receiptId = (int) $request->session()->get('checkout_e_receipt_request_id', 0);
        $receipt = $receiptId > 0
            ? EReceiptRequest::where('user_id', $request->user()->id)->find($receiptId)
            : null;

        return response()->json([
            'ok' => true,
            'request_complete' => (bool) $receipt,
            'payment_verified' => $request->session()->get('checkout_payment_verified') === true,
            'receipt' => $receipt,
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'receipt_type' => ['required', 'in:personal,business'],
            'full_name' => ['required', 'string', 'max:160'],
            'business_name' => ['nullable', 'required_if:receipt_type,business', 'string', 'max:180'],
            'tin' => ['nullable', 'string', 'max:40'],
            'region' => ['required', 'string', 'max:120'],
            'province' => ['required', 'string', 'max:120'],
            'city' => ['required', 'string', 'max:120'],
            'barangay' => ['required', 'string', 'max:120'],
            'postal_code' => ['required', 'string', 'max:20'],
            'street_address' => ['required', 'string', 'max:255'],
            'is_default' => ['sometimes', 'boolean'],
            'consent' => ['accepted'],
        ]);

        $receipt = DB::transaction(function () use ($request, $data) {
            $isDefault = (bool) ($data['is_default'] ?? false);

            if ($isDefault) {
                EReceiptRequest::where('user_id', $request->user()->id)->update(['is_default' => false]);
            }

            $receipt = EReceiptRequest::create(array_merge(
                collect($data)->except('consent')->all(),
                ['user_id' => $request->user()->id, 'is_default' => $isDefault, 'status' => 'submitted']
            ));

            if ($isDefault) {
                $profileData = [
                    'name' => $data['full_name'],
                    'street' => $data['street_address'],
                    'postal_code' => $data['postal_code'],
                    'company' => $data['receipt_type'] === 'business' ? $data['business_name'] : $request->user()->company,
                    'barangay' => $data['barangay'],
                    'region' => $data['region'],
                    'province' => $data['province'],
                    'city' => $data['city'],
                ];

                $request->user()->forceFill($profileData)->save();
            }

            return $receipt;
        });

        $request->session()->put('checkout_e_receipt_request_id', $receipt->id);

        return response()->json([
            'ok' => true,
            'message' => 'Your e-receipt request has been submitted.',
            'receipt' => $receipt,
        ], 201);
    }

    public function upload(Request $request): JsonResponse
    {
        if ($request->session()->get('checkout_payment_verified') !== true) {
            return response()->json([
                'ok' => false,
                'message' => 'Complete payment before uploading the received receipt.',
            ], 422);
        }

        $data = $request->validate([
            'receipt_file' => ['required', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:10240'],
        ]);

        $receipt = EReceiptRequest::where('user_id', $request->user()->id)
            ->findOrFail((int) $request->session()->get('checkout_e_receipt_request_id', 0));

        if ($receipt->uploaded_receipt_path) {
            Storage::disk('local')->delete($receipt->uploaded_receipt_path);
        }

        $file = $data['receipt_file'];
        $path = $file->store('e-receipt-uploads/' . $request->user()->id, 'local');
        $receipt->forceFill([
            'uploaded_receipt_path' => $path,
            'uploaded_receipt_name' => $file->getClientOriginalName(),
            'uploaded_receipt_at' => now(),
            'status' => 'receipt_uploaded',
        ])->save();

        return response()->json([
            'ok' => true,
            'message' => 'Received receipt uploaded successfully.',
            'receipt' => $receipt->fresh(),
        ]);
    }
}

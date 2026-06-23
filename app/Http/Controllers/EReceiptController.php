<?php

namespace App\Http\Controllers;

use App\Models\EReceiptRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EReceiptController extends Controller
{
    public function show(Request $request): JsonResponse
    {
        return response()->json([
            'ok' => true,
            'receipt' => EReceiptRequest::where('user_id', $request->user()->id)->latest()->first(),
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
                $request->user()->forceFill([
                    'name' => $data['full_name'],
                    'street' => $data['street_address'],
                    'barangay' => $data['barangay'],
                    'region' => $data['region'],
                    'city' => $data['city'],
                    'postal_code' => $data['postal_code'],
                    'company' => $data['receipt_type'] === 'business' ? $data['business_name'] : $request->user()->company,
                ])->save();
            }

            return $receipt;
        });

        return response()->json([
            'ok' => true,
            'message' => 'Your e-receipt request has been submitted.',
            'receipt' => $receipt,
        ], 201);
    }
}

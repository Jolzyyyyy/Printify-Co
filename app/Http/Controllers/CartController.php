<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\ServiceVariation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CartController extends Controller
{
    public function state(Request $request)
    {
        $cart = session()->get('cart', []);
        $variations = ServiceVariation::query()
            ->whereIn('id', collect($cart)->pluck('variation_id')->filter()->unique()->values())
            ->get()
            ->keyBy('id');

        return response()->json([
            'ok' => true,
            'promo_code' => session()->get('cart_promo'),
            'items' => collect($cart)->map(function (array $row, $cartKey) use ($variations) {
                $variation = $variations->get($row['variation_id'] ?? null);

                return [
                    'id' => $row['cart_id'] ?? $cartKey,
                    'name' => $row['name'] ?? 'Print Item',
                    'qty' => (int) ($row['qty'] ?? 1),
                    'unitPrice' => (float) ($row['price'] ?? 0),
                    'price' => (float) ($row['price'] ?? 0),
                    'priceType' => $row['price_type'] ?? 'retail',
                    'selected' => (bool) ($row['selected'] ?? true),
                    'image' => $row['image_path'] ?? null,
                    'fileName' => $row['file_name'] ?? null,
                    'fileMeta' => $row['file_meta'] ?? null,
                    'meta' => $row['meta'] ?? [],
                    'raw' => array_merge($row['raw'] ?? [], [
                        'serviceName' => $row['name'] ?? 'Print Item',
                        'serviceId' => $row['service_item_id'] ?? null,
                        'serviceItemId' => $row['service_item_id'] ?? null,
                        'category' => $row['category'] ?? null,
                        'categoryTitle' => data_get($row, 'raw.categoryTitle') ?? ($row['category'] ?? null),
                        'printingCategory' => data_get($row, 'raw.printingCategory') ?? ($row['category'] ?? null),
                        'variationPrintingCategory' => data_get($row, 'raw.variationPrintingCategory') ?? $variation?->printing_category,
                        'productSize' => data_get($row, 'raw.productSize') ?? data_get($row, 'raw.paperSize') ?? $variation?->product_size,
                        'colorMode' => data_get($row, 'raw.colorMode') ?? data_get($row, 'raw.colorVariation') ?? $variation?->color_mode,
                        'finishType' => data_get($row, 'raw.finishType') ?? $variation?->finish_type,
                        'variationLabel' => $row['variation_label'] ?? null,
                        'serviceOption' => data_get($row, 'raw.serviceOption') ?? $variation?->finish_type ?? ($row['variation_label'] ?? null),
                        'quantity' => (int) ($row['qty'] ?? 1),
                        'unit' => $row['unit'] ?? 'pcs',
                        'fileName' => $row['file_name'] ?? null,
                        'fileMeta' => $row['file_meta'] ?? null,
                        'attachmentPath' => $row['attachment_path'] ?? null,
                        'priceMode' => ucfirst($row['price_type'] ?? 'retail'),
                    ]),
                ];
            })->values(),
        ]);
    }

    /**
     * View cart page.
     */
    public function index(Request $request)
    {
        $cart = session()->get('cart', []);

        $items = [];
        $total = 0;

        foreach ($cart as $cartKey => $row) {
            $lineTotal = $row['price'] * $row['qty'];
            $total += $lineTotal;

            $items[] = [
                'cart_key'         => $cartKey,
                'service_id'       => $row['service_id'],
                'variation_id'     => $row['variation_id'],
                'service_item_id'  => $row['service_item_id'],
                'name'             => $row['name'],
                'category'         => $row['category'],
                'variation_label'  => $row['variation_label'],
                'unit'             => $row['unit'],
                'price'            => $row['price'],
                'price_type'       => $row['price_type'],
                'qty'              => $row['qty'],
                'line_total'       => $lineTotal,
                'image_path'       => $row['image_path'] ?? null,
            ];
        }

        return view('cart.index', compact('items', 'total'));
    }

    /**
     * Add a variation to cart (or increase qty).
     * POST /cart/add/{service}
     */
    public function add(Request $request, Service $service)
    {
        abort_if(!$service->is_active, 404);

        $validated = $request->validate([
            'service_variation_id' => ['required', 'exists:service_variations,id'],
            'qty' => ['nullable', 'integer', 'min:1', 'max:999'],
            'price_type' => ['nullable', 'in:retail,bulk'],
        ]);

        $qty = (int) ($validated['qty'] ?? 1);
        $priceType = $validated['price_type'] ?? 'retail';

        $variation = ServiceVariation::where('id', $validated['service_variation_id'])
            ->where('service_id', $service->id)
            ->where('is_active', true)
            ->firstOrFail();

        $price = $priceType === 'bulk'
            ? (float) $variation->bulk_price
            : (float) $variation->retail_price;

        $cart = session()->get('cart', []);

        // unique cart key per service variation + price type
        $cartKey = $service->id . '_' . $variation->id . '_' . $priceType;

        if (isset($cart[$cartKey])) {
            $cart[$cartKey]['qty'] += $qty;
            $cart[$cartKey]['price'] = $price;
            $cart[$cartKey]['price_type'] = $priceType;
        } else {
            $cart[$cartKey] = [
                'service_id'      => $service->id,
                'variation_id'    => $variation->id,
                'service_item_id' => $variation->service_item_id,
                'name'            => $service->name,
                'category'        => $service->category,
                'variation_label' => $variation->variation_label,
                'unit'            => $service->unit,
                'price'           => $price,
                'price_type'      => $priceType,
                'qty'             => $qty,
                'image_path'      => $variation->variation_image_path ?: $service->image_path,
            ];
        }

        session()->put('cart', $cart);

        return redirect()->route('cart.index')->with('success', 'Added to cart.');
    }

    /**
     * Update qty/price_type of a cart item
     * POST /cart/update/{cartKey}
     */
    public function update(Request $request, string $cartKey)
    {
        $validated = $request->validate([
            'qty' => ['required', 'integer', 'min:1', 'max:999'],
            'price_type' => ['required', 'in:retail,bulk'],
        ]);

        $cart = session()->get('cart', []);

        if (!isset($cart[$cartKey])) {
            return redirect()->route('cart.index')->with('error', 'Item not found in cart.');
        }

        $variation = ServiceVariation::find($cart[$cartKey]['variation_id']);

        if (!$variation || !$variation->is_active) {
            return redirect()->route('cart.index')->with('error', 'Selected variation is no longer available.');
        }

        $newPriceType = $validated['price_type'];
        $newPrice = $newPriceType === 'bulk'
            ? (float) $variation->bulk_price
            : (float) $variation->retail_price;

        // if price type changes, key should also change
        $newCartKey = $cart[$cartKey]['service_id'] . '_' . $variation->id . '_' . $newPriceType;

        $updatedRow = $cart[$cartKey];
        $updatedRow['qty'] = (int) $validated['qty'];
        $updatedRow['price_type'] = $newPriceType;
        $updatedRow['price'] = $newPrice;

        unset($cart[$cartKey]);

        if (isset($cart[$newCartKey])) {
            $cart[$newCartKey]['qty'] += $updatedRow['qty'];
            $cart[$newCartKey]['price'] = $updatedRow['price'];
            $cart[$newCartKey]['price_type'] = $updatedRow['price_type'];
        } else {
            $cart[$newCartKey] = $updatedRow;
        }

        session()->put('cart', $cart);

        return redirect()->route('cart.index')->with('success', 'Cart updated.');
    }

    /**
     * Remove item from cart
     * POST /cart/remove/{cartKey}
     */
    public function remove(Request $request, string $cartKey)
    {
        $cart = session()->get('cart', []);

        if (!empty($cart[$cartKey]['attachment_path'])) {
            Storage::disk('local')->delete($cart[$cartKey]['attachment_path']);
        }

        unset($cart[$cartKey]);

        session()->put('cart', $cart);

        return redirect()->route('cart.index')->with('success', 'Item removed.');
    }

    /**
     * Clear all cart
     * POST /cart/clear
     */
    public function clear()
    {
        foreach (session()->get('cart', []) as $row) {
            if (!empty($row['attachment_path'])) {
                Storage::disk('local')->delete($row['attachment_path']);
            }
        }
        session()->forget('cart');
        session()->forget('cart_promo');

        return redirect()->route('cart.index')->with('success', 'Cart cleared.');
    }

    // ============================================================
    // ===================== ✅ OURS BELOW =========================
    // ========== (CHECKOUT/PAYMENT SUPPORT ONLY) ==================
    // ============================================================

    /**
     * ✅ SYNC CART (from LocalStorage -> Laravel Session 'cart')
     * POST /cart/sync
     *
     * Expects JSON:
     * { items: [{ name, qty, unit_price, service_code?, price_type? }] }
     */
    public function syncCart(Request $request)
    {
        $validated = $request->validate([
            'items' => ['present', 'array'],
            'items.*.id' => ['nullable', 'string', 'max:160'],
            'items.*.name' => ['required', 'string'],
            'items.*.qty' => ['required', 'integer', 'min:1', 'max:999'],
            'items.*.unit_price' => ['nullable', 'numeric', 'min:0'],
            'items.*.price' => ['nullable', 'numeric', 'min:0'],
            'items.*.service_id' => ['nullable'],
            'items.*.variation_id' => ['nullable'],
            'items.*.service_item_id' => ['nullable', 'string'],
            'items.*.category' => ['nullable', 'string'],
            'items.*.variation_label' => ['nullable', 'string'],
            'items.*.unit' => ['nullable', 'string'],
            'items.*.image_path' => ['nullable', 'string'],
            'items.*.service_code' => ['nullable', 'string'],
            'items.*.price_type' => ['nullable', 'in:retail,bulk'],
            'items.*.selected' => ['nullable', 'boolean'],
            'items.*.file_name' => ['nullable', 'string', 'max:255'],
            'items.*.file_meta' => ['nullable', 'array'],
            'items.*.meta' => ['nullable', 'array'],
            'items.*.raw' => ['nullable', 'array'],
        ]);

        $existing = session()->get('cart', []);
        $cart = [];

        foreach ($validated['items'] as $idx => $i) {
            $priceType = $i['price_type'] ?? 'retail';
            $serviceItemId = trim((string) ($i['service_item_id'] ?? $i['service_code'] ?? ''));
            $variation = $serviceItemId !== ''
                ? ServiceVariation::with('service')
                    ->where('service_item_id', $serviceItemId)
                    ->where('is_active', true)
                    ->first()
                : null;
            $service = $variation?->service;
            $key = $variation
                ? $service->id . '_' . $variation->id . '_' . $priceType
                : ($i['id'] ?? ($serviceItemId !== '' ? $serviceItemId : ('LS-' . $idx . '-' . uniqid())));
            $catalogPrice = $variation
                ? (float) ($priceType === 'bulk' ? $variation->bulk_price : $variation->retail_price)
                : null;
            $doubleSidedFee = !empty($i['raw']['addons']['doubleSided']) ? 0.50 : 0;
            $unitPrice = $catalogPrice !== null
                ? $catalogPrice + $doubleSidedFee
                : (float) ($i['unit_price'] ?? $i['price'] ?? 0);
            $old = $existing[$key] ?? ($existing[$i['id'] ?? ''] ?? []);
            $row = [
                'cart_id'         => $key,
                'service_id'      => (int) ($service?->id ?? $i['service_id'] ?? 0),
                'variation_id'    => (int) ($variation?->id ?? $i['variation_id'] ?? 0),
                'service_item_id' => $variation?->service_item_id ?? ($serviceItemId !== '' ? $serviceItemId : $key),
                'name'            => $service?->name ?? $i['name'],
                'category'        => $service?->category ?? $i['category'] ?? null,
                'variation_label' => $variation?->variation_label ?? $i['variation_label'] ?? null,
                'unit'            => $service?->unit ?? $i['unit'] ?? null,
                'price'           => $unitPrice,
                'price_type'      => $priceType,
                'qty'             => (int) $i['qty'],
                'image_path'      => $service?->image_path ?? $i['image_path'] ?? null,
                'selected'        => (bool) ($i['selected'] ?? true),
                'file_name'       => $i['file_name'] ?? ($old['file_name'] ?? null),
                'file_meta'       => $i['file_meta'] ?? ($old['file_meta'] ?? null),
                'attachment_path' => $old['attachment_path'] ?? null,
                'meta'            => $i['meta'] ?? [],
                'raw'             => $i['raw'] ?? [],
            ];

            if (isset($cart[$key])) {
                $cart[$key]['qty'] += $row['qty'];
                $cart[$key]['selected'] = $cart[$key]['selected'] || $row['selected'];
                $cart[$key]['file_name'] ??= $row['file_name'];
                $cart[$key]['file_meta'] ??= $row['file_meta'];
                $cart[$key]['attachment_path'] ??= $row['attachment_path'];
            } else {
                $cart[$key] = $row;
            }
        }

        foreach ($existing as $key => $row) {
            if (!isset($cart[$key]) && !empty($row['attachment_path'])) {
                Storage::disk('local')->delete($row['attachment_path']);
            }
        }

        session()->put('cart', $cart);
        session()->forget('buy_now');

        return response()->json(['ok' => true, 'count' => count($cart)]);
    }

    public function attach(Request $request)
    {
        $validated = $request->validate([
            'cart_id' => ['required', 'string', 'max:160'],
            'file' => ['required', 'file', 'max:51200', 'mimes:pdf,doc,docx,txt,jpg,jpeg,png'],
        ]);

        $cart = session()->get('cart', []);
        $cartId = $validated['cart_id'];
        abort_unless(isset($cart[$cartId]), 404, 'Cart item not found.');

        if (!empty($cart[$cartId]['attachment_path'])) {
            Storage::disk('local')->delete($cart[$cartId]['attachment_path']);
        }

        $file = $request->file('file');
        $path = $file->store('cart-uploads/' . $request->user()->id, 'local');
        $cart[$cartId]['file_name'] = $file->getClientOriginalName();
        $cart[$cartId]['file_meta'] = [
            'name' => $file->getClientOriginalName(),
            'size' => $file->getSize(),
            'type' => $file->getMimeType(),
        ];
        $cart[$cartId]['attachment_path'] = $path;
        session()->put('cart', $cart);

        return response()->json([
            'ok' => true,
            'file_name' => $cart[$cartId]['file_name'],
            'file_meta' => $cart[$cartId]['file_meta'],
        ]);
    }

    public function promo(Request $request)
    {
        $validated = $request->validate([
            'code' => ['required', 'string', 'max:40'],
        ]);

        $code = strtoupper(trim($validated['code']));
        abort_unless(in_array($code, ['SAVE10', 'PRINTIFY50'], true), 422, 'Invalid promo code.');
        session()->put('cart_promo', $code);

        return response()->json(['ok' => true, 'code' => $code]);
    }

    /**
     * BUY NOW (Product Detail -> Laravel Session 'buy_now')
     * POST /cart/buy-now
     *
     * Expects JSON:
     * { name, qty, unit_price, price_type, service_code? }
     */
    public function buyNow(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string'],
            'qty' => ['required', 'integer', 'min:1', 'max:999'],
            'unit_price' => ['required', 'numeric', 'min:0'],
            'price_type' => ['required', 'in:retail,bulk'],
            'service_code' => ['nullable', 'string'],
        ]);

        $key = $validated['service_code'] ?: ('BUY-' . uniqid());

        session()->put('buy_now', [
            $key => [
                'name'       => $validated['name'],
                'category'   => null,
                'unit'       => null,
                'price'      => (float) $validated['unit_price'], // ✅ unit price
                'price_type' => $validated['price_type'],
                'qty'        => (int) $validated['qty'],
                'image_path' => null,
            ]
        ]);

        // ✅ go to SAME checkout page
        return response()->json(['ok' => true]);
    }
}

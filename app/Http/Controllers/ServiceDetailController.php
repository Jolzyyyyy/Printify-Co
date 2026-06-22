<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ServiceDetailController extends Controller
{
    public function catalog()
    {
        return response()->json([
            'ok' => true,
            'services' => Service::query()
                ->where('is_active', true)
                ->with(['activeVariations' => fn ($query) => $query->orderBy('id')])
                ->orderBy('name')
                ->get(),
        ]);
    }

    public function state(Request $request)
    {
        return response()->json([
            'ok' => true,
            'draft' => $request->session()->get('service_detail_draft'),
        ]);
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'service_key' => ['required', 'string', 'max:100'],
            'service_id' => ['nullable', 'string', 'max:120'],
            'printing_category' => ['nullable', 'string', 'max:160'],
            'color_variation' => ['nullable', 'string', 'max:120'],
            'paper_size' => ['nullable', 'string', 'max:120'],
            'quantity' => ['nullable', 'integer', 'min:0', 'max:999'],
            'service_option' => ['nullable', 'string', 'max:160'],
            'file_type' => ['nullable', 'string', 'max:40'],
            'price_mode' => ['nullable', 'in:Retail,Bulk'],
            'unit_price' => ['nullable', 'numeric', 'min:0'],
            'total' => ['nullable', 'numeric', 'min:0'],
            'addons' => ['nullable', 'array'],
            'addons.double_sided' => ['nullable', 'boolean'],
            'addons.collated_stapled' => ['nullable', 'boolean'],
            'addons.document_envelope' => ['nullable', 'boolean'],
        ]);

        $current = $request->session()->get('service_detail_draft', []);
        $draft = array_merge($current, $validated, ['updated_at' => now()->toIso8601String()]);
        $request->session()->put('service_detail_draft', $draft);

        return response()->json(['ok' => true, 'draft' => $draft]);
    }

    public function upload(Request $request)
    {
        $validated = $request->validate([
            'file' => ['required', 'file', 'max:51200', 'mimes:pdf,doc,docx,txt,jpg,jpeg,png'],
        ]);

        $draft = $request->session()->get('service_detail_draft', []);
        if (!empty($draft['attachment_path'])) {
            Storage::disk('local')->delete($draft['attachment_path']);
        }

        $file = $validated['file'];
        $path = $file->store('service-detail-uploads/' . $request->user()->id, 'local');
        $draft['file'] = [
            'name' => $file->getClientOriginalName(),
            'size' => $file->getSize(),
            'type' => $file->getMimeType(),
        ];
        $draft['attachment_path'] = $path;
        $draft['updated_at'] = now()->toIso8601String();
        $request->session()->put('service_detail_draft', $draft);

        return response()->json(['ok' => true, 'file' => $draft['file']]);
    }

    public function removeUpload(Request $request)
    {
        $draft = $request->session()->get('service_detail_draft', []);
        if (!empty($draft['attachment_path'])) {
            Storage::disk('local')->delete($draft['attachment_path']);
        }
        unset($draft['file'], $draft['attachment_path']);
        $request->session()->put('service_detail_draft', $draft);

        return response()->json(['ok' => true]);
    }
}

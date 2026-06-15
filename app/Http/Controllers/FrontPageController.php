<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;

class FrontPageController extends Controller
{
    public function home()
    {
        return $this->page('home');
    }

    public function products()
    {
        return $this->page('products');
    }

    public function about()
    {
        return $this->page('about');
    }

    public function contact()
    {
        return $this->page('contact');
    }

    public function submitContact(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'email' => ['required', 'email', 'max:160'],
            'phone' => ['nullable', 'string', 'max:40'],
            'message' => ['required', 'string', 'max:3000'],
            'attachment' => ['nullable', 'file', 'mimes:pdf,ai,psd,jpg,jpeg,png', 'max:10240'],
        ]);

        $attachmentPath = null;
        if ($request->hasFile('attachment')) {
            $attachmentPath = $request->file('attachment')->store('contact-inquiries', 'public');
        }

        $record = [
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'] ?? null,
            'message' => $validated['message'],
            'attachment_path' => $attachmentPath,
            'submitted_at' => now()->toDateTimeString(),
            'ip' => $request->ip(),
        ];

        $file = 'contact-inquiries/inquiries.json';
        $existing = Storage::disk('local')->exists($file)
            ? json_decode(Storage::disk('local')->get($file), true)
            : [];

        if (!is_array($existing)) {
            $existing = [];
        }

        $existing[] = $record;
        Storage::disk('local')->put($file, json_encode($existing, JSON_PRETTY_PRINT));

        return back()->with('contact_status', 'success');
    }

    public function serviceDetail()
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Please sign in or create an account to continue to service details.');
        }

        return $this->page('service-details');
    }

    public function checkout()
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Please sign in or create an account to continue to checkout.');
        }

        return $this->page('checkout');
    }

    private function page(string $activeSection)
    {
        $services = Schema::hasTable('services')
            ? Service::where('is_active', 1)->with('activeVariations')->get()
            : collect();

        return view('welcome', compact('services', 'activeSection'));
    }
}

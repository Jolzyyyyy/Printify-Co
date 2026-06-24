<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\SupportTicket;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CustomerHeaderController extends Controller
{
    public function search(Request $request): RedirectResponse
    {
        $query = trim((string) $request->query('q', ''));

        if ($query === '') {
            return redirect()->route('myorders');
        }

        $order = Order::query()
            ->where('user_id', $request->user()->id)
            ->where(function ($scope) use ($query) {
                $scope->where('order_reference', 'like', "%{$query}%")
                    ->orWhere('status', 'like', "%{$query}%")
                    ->orWhere('delivery_method', 'like', "%{$query}%")
                    ->orWhereHas('items', function ($itemScope) use ($query) {
                        $itemScope->where('service_name', 'like', "%{$query}%")
                            ->orWhere('variation_label', 'like', "%{$query}%")
                            ->orWhere('price_type', 'like', "%{$query}%");
                    });
            })
            ->latest()
            ->first();

        if ($order) {
            return redirect()->route('myorders.show', $order);
        }

        return redirect()
            ->route('myorders', ['q' => $query])
            ->with('search_status', "No exact order match for \"{$query}\". Showing related order results.");
    }

    public function markNotificationRead(Request $request): JsonResponse
    {
        $data = $request->validate([
            'notification_id' => ['nullable', 'string', 'max:120'],
        ]);

        $read = session('customer_notifications_read', []);
        $id = $data['notification_id'] ?? Str::uuid()->toString();
        $read[$id] = now()->toISOString();
        session(['customer_notifications_read' => $read]);

        return response()->json([
            'ok' => true,
            'notification_id' => $id,
            'read_at' => $read[$id],
        ]);
    }

    public function markAllNotificationsRead(): JsonResponse
    {
        session(['customer_notifications_all_read_at' => now()->toISOString()]);

        return response()->json([
            'ok' => true,
            'read_all_at' => session('customer_notifications_all_read_at'),
        ]);
    }

    public function adminStatus(): JsonResponse
    {
        $online = User::query()
            ->whereIn('role', [User::ROLE_ADMIN_CLIENT, User::ROLE_DEVELOPER])
            ->whereNotNull('approved_at')
            ->exists();

        return response()->json([
            'online' => $online,
            'label' => $online ? 'Support available' : 'Support offline',
        ]);
    }

    public function storeThread(Request $request): JsonResponse
    {
        $data = $request->validate([
            'topic' => ['nullable', 'string', 'max:120'],
            'title' => ['nullable', 'string', 'max:160'],
            'customer_name' => ['nullable', 'string', 'max:160'],
            'customer_email' => ['nullable', 'email', 'max:160'],
        ]);

        $topic = $data['topic'] ?? $data['title'] ?? 'Customer Support';
        $ticket = SupportTicket::create([
            'user_id' => $request->user()->id,
            'reference' => $this->supportReference($request->user()->id),
            'topic' => $topic,
            'order_reference' => null,
            'message' => 'Support thread opened from the customer header chat box.',
            'status' => 'Open',
        ]);

        return response()->json([
            'ok' => true,
            'thread' => [
                'id' => $ticket->id,
                'reference' => $ticket->reference,
                'topic' => $ticket->topic,
                'status' => $ticket->status,
            ],
        ], 201);
    }

    public function messages(Request $request): JsonResponse
    {
        $topic = trim((string) $request->query('topic', 'Customer Support'));

        $messages = SupportTicket::query()
            ->where('user_id', $request->user()->id)
            ->when($topic !== '', fn ($scope) => $scope->where('topic', $topic))
            ->latest()
            ->limit(30)
            ->get()
            ->reverse()
            ->values()
            ->map(fn (SupportTicket $ticket) => [
                'id' => $ticket->id,
                'from' => 'customer',
                'sender' => 'customer',
                'is_customer' => true,
                'message' => $ticket->message,
                'created_at' => $ticket->created_at?->toISOString(),
                'reference' => $ticket->reference,
                'status' => $ticket->status,
            ]);

        return response()->json([
            'messages' => $messages,
        ]);
    }

    public function storeMessage(Request $request): JsonResponse
    {
        $data = $request->validate([
            'topic' => ['nullable', 'string', 'max:120'],
            'message' => ['nullable', 'string', 'max:2000'],
            'customer_name' => ['nullable', 'string', 'max:160'],
            'customer_email' => ['nullable', 'email', 'max:160'],
            'attachment' => ['nullable', 'file', 'max:10240'],
            'attachment_type' => ['nullable', 'string', 'max:60'],
        ]);

        $message = trim((string) ($data['message'] ?? ''));
        $attachment = null;

        if ($request->hasFile('attachment')) {
            $file = $request->file('attachment');
            $path = $file->store('support-attachments', 'public');
            $attachment = [
                'name' => $file->getClientOriginalName(),
                'path' => $path,
                'url' => asset('storage/' . $path),
                'type' => $data['attachment_type'] ?? $file->getMimeType(),
            ];
            $message = trim($message . "\n\nAttachment: " . $attachment['name']);
        }

        if ($message === '') {
            $message = 'Customer sent a support message.';
        }

        $ticket = SupportTicket::create([
            'user_id' => $request->user()->id,
            'reference' => $this->supportReference($request->user()->id),
            'topic' => $data['topic'] ?? 'Customer Support',
            'order_reference' => null,
            'message' => $message,
            'status' => 'Open',
        ]);

        return response()->json([
            'ok' => true,
            'message' => [
                'id' => $ticket->id,
                'from' => 'customer',
                'sender' => 'customer',
                'is_customer' => true,
                'message' => $ticket->message,
                'created_at' => $ticket->created_at?->toISOString(),
                'reference' => $ticket->reference,
                'status' => $ticket->status,
                'attachment' => $attachment,
            ],
        ], 201);
    }

    private function supportReference(int $userId): string
    {
        return 'TKT-' . now()->format('ymdHis') . '-' . $userId . '-' . Str::upper(Str::random(4));
    }
}

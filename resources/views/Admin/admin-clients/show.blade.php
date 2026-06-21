<x-app-layout>
<div class="max-w-7xl mx-auto py-10 px-4 sm:px-6 space-y-8">

    {{-- ── Breadcrumb ── --}}
    <div class="flex items-center gap-2 text-sm text-slate-500">
        <a href="{{ route('developer.admin-clients.index') }}" class="hover:text-slate-800">Admin Clients</a>
        <span>/</span>
        <span class="font-semibold text-slate-800">{{ $user->name }}</span>
    </div>

    {{-- ── Header ── --}}
    <div class="flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">
        <div>
            <p class="text-xs font-bold uppercase tracking-widest text-blue-600">Developer Portal — Admin Client</p>
            <h1 class="mt-1 text-3xl font-black text-slate-900 tracking-tight">{{ $user->name }}</h1>
            <p class="mt-1 text-sm text-slate-500">{{ $user->email }}</p>
            <span class="mt-2 inline-flex items-center rounded-full px-3 py-1 text-xs font-bold uppercase tracking-wider
                {{ $user->approved_at ? 'bg-emerald-100 text-emerald-700' : 'bg-amber-100 text-amber-700' }}">
                {{ $user->approved_at ? 'Approved' : 'Pending Approval' }}
            </span>
        </div>
        <div class="flex gap-2">
            @if ($user->approved_at)
                <form method="POST" action="{{ route('developer.admin-clients.suspend', $user) }}">
                    @csrf @method('PATCH')
                    <button class="rounded-lg border border-rose-200 bg-white px-4 py-2 text-sm font-bold text-rose-600 hover:bg-rose-50">
                        Suspend
                    </button>
                </form>
            @else
                <form method="POST" action="{{ route('developer.admin-clients.approve', $user) }}">
                    @csrf @method('PATCH')
                    <button class="rounded-lg bg-emerald-600 px-4 py-2 text-sm font-bold text-white hover:bg-emerald-700">
                        Approve
                    </button>
                </form>
            @endif
            <a href="{{ route('developer.admin-clients.index') }}"
               class="rounded-lg border border-slate-200 bg-white px-4 py-2 text-sm font-bold text-slate-700 hover:bg-slate-50">
                ← Back
            </a>
        </div>
    </div>

    {{-- ── Primary Credentials / Profile ── --}}
    <div class="grid gap-6 lg:grid-cols-2">
        <section class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm">
            <h2 class="text-xs font-black uppercase tracking-widest text-slate-500 mb-4">Account Credentials</h2>
            <dl class="space-y-3 text-sm">
                <div class="flex justify-between gap-4">
                    <dt class="font-semibold text-slate-600">Full Name</dt>
                    <dd class="text-slate-900 text-right">{{ $user->name }}</dd>
                </div>
                <div class="flex justify-between gap-4">
                    <dt class="font-semibold text-slate-600">Email</dt>
                    <dd class="text-slate-900 text-right break-all">{{ $user->email }}</dd>
                </div>
                <div class="flex justify-between gap-4">
                    <dt class="font-semibold text-slate-600">Role</dt>
                    <dd class="text-slate-900">Admin Client</dd>
                </div>
                <div class="flex justify-between gap-4">
                    <dt class="font-semibold text-slate-600">Email Verified</dt>
                    <dd class="text-slate-900">{{ $user->email_verified_at ? $user->email_verified_at->format('M d, Y') : '—' }}</dd>
                </div>
                <div class="flex justify-between gap-4">
                    <dt class="font-semibold text-slate-600">Approved At</dt>
                    <dd class="text-slate-900">{{ $user->approved_at ? \Carbon\Carbon::parse($user->approved_at)->format('M d, Y h:i A') : '—' }}</dd>
                </div>
                <div class="flex justify-between gap-4">
                    <dt class="font-semibold text-slate-600">Invite Accepted</dt>
                    <dd class="text-slate-900">{{ $user->invitation_accepted_at ? \Carbon\Carbon::parse($user->invitation_accepted_at)->format('M d, Y') : '—' }}</dd>
                </div>
                <div class="flex justify-between gap-4">
                    <dt class="font-semibold text-slate-600">Account Created</dt>
                    <dd class="text-slate-900">{{ $user->created_at->format('M d, Y') }}</dd>
                </div>
            </dl>
        </section>

        <section class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm">
            <h2 class="text-xs font-black uppercase tracking-widest text-slate-500 mb-4">Business Profile</h2>
            @if ($user->adminClientProfile)
                @php $profile = $user->adminClientProfile; @endphp
                <dl class="space-y-3 text-sm">
                    <div class="flex justify-between gap-4">
                        <dt class="font-semibold text-slate-600">Business Name</dt>
                        <dd class="text-slate-900 text-right">{{ $profile->business_name ?? '—' }}</dd>
                    </div>
                    <div class="flex justify-between gap-4">
                        <dt class="font-semibold text-slate-600">Contact Person</dt>
                        <dd class="text-slate-900">{{ $profile->contact_person ?? '—' }}</dd>
                    </div>
                    <div class="flex justify-between gap-4">
                        <dt class="font-semibold text-slate-600">Contact Number</dt>
                        <dd class="text-slate-900">{{ $profile->contact_number ?? '—' }}</dd>
                    </div>
                    <div class="flex justify-between gap-4">
                        <dt class="font-semibold text-slate-600">Business Address</dt>
                        <dd class="text-slate-900 text-right">{{ $profile->business_address ?? '—' }}</dd>
                    </div>
                    @if ($profile->reference_notes)
                        <div class="pt-2 border-t border-slate-100">
                            <dt class="font-semibold text-slate-600 mb-1">Notes</dt>
                            <dd class="text-slate-700 text-xs leading-relaxed">{{ $profile->reference_notes }}</dd>
                        </div>
                    @endif
                    <div class="flex justify-between gap-4 pt-2 border-t border-slate-100">
                        <dt class="font-semibold text-slate-600">Profile Status</dt>
                        <dd>
                            <span class="rounded-full px-2 py-0.5 text-xs font-bold
                                {{ $profile->isComplete() ? 'bg-emerald-100 text-emerald-700' : 'bg-amber-100 text-amber-700' }}">
                                {{ $profile->isComplete() ? 'Complete' : 'Incomplete' }}
                            </span>
                        </dd>
                    </div>
                </dl>
            @else
                <p class="text-sm text-slate-400 italic">No business profile submitted yet.</p>
            @endif
        </section>
    </div>

    {{-- ── Revenue Summary Cards ── --}}
    <div>
        <h2 class="text-xs font-black uppercase tracking-widest text-slate-500 mb-3">Revenue Overview</h2>
        <div class="grid gap-4 grid-cols-2 lg:grid-cols-5">
            @foreach ([
                ['label' => 'All Time',  'value' => $revenueTotal],
                ['label' => 'This Year', 'value' => $revenueYear],
                ['label' => 'This Month','value' => $revenueMonth],
                ['label' => 'This Week', 'value' => $revenueWeek],
                ['label' => 'Today',     'value' => $revenueDay],
            ] as $card)
                <div class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm">
                    <p class="text-xs font-bold uppercase tracking-wider text-slate-400">{{ $card['label'] }}</p>
                    <p class="mt-2 text-xl font-black text-slate-900">₱{{ number_format($card['value'], 2) }}</p>
                </div>
            @endforeach
        </div>
    </div>

    {{-- ── Period Filter + Orders ── --}}
    <div>
        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between mb-4">
            <h2 class="text-xs font-black uppercase tracking-widest text-slate-500">Orders</h2>
            <div class="flex gap-1 rounded-xl border border-slate-200 bg-slate-50 p-1 text-xs font-bold w-fit">
                @foreach (['day' => 'Today', 'week' => 'This Week', 'month' => 'This Month', 'year' => 'This Year'] as $key => $label)
                    <a href="?period={{ $key }}"
                       class="rounded-lg px-3 py-1.5 transition {{ $period === $key ? 'bg-white shadow text-slate-900' : 'text-slate-500 hover:text-slate-800' }}">
                        {{ $label }}
                    </a>
                @endforeach
            </div>
        </div>

        {{-- Order stats for selected period --}}
        <div class="grid gap-4 grid-cols-2 lg:grid-cols-4 mb-6">
            @php
                $periodStatuses = ['Pending','Processing','Ready','Completed'];
            @endphp
            <div class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm">
                <p class="text-xs font-bold uppercase tracking-wider text-slate-400">Period Orders</p>
                <p class="mt-2 text-2xl font-black text-slate-900">{{ $periodOrders->count() }}</p>
                <p class="text-xs text-slate-400 mt-1">{{ ucfirst($period) }}</p>
            </div>
            <div class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm">
                <p class="text-xs font-bold uppercase tracking-wider text-slate-400">Period Revenue</p>
                <p class="mt-2 text-2xl font-black text-slate-900">₱{{ number_format($periodOrders->sum('total_price'), 2) }}</p>
            </div>
            <div class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm">
                <p class="text-xs font-bold uppercase tracking-wider text-slate-400">Total Orders</p>
                <p class="mt-2 text-2xl font-black text-slate-900">{{ $allOrders->count() }}</p>
            </div>
            <div class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm">
                <p class="text-xs font-bold uppercase tracking-wider text-slate-400">Completed</p>
                <p class="mt-2 text-2xl font-black text-slate-900">{{ (int) ($orderStatusCounts['Completed'] ?? 0) }}</p>
            </div>
        </div>

        {{-- Order Pipeline --}}
        <div class="grid gap-2 grid-cols-3 sm:grid-cols-6 mb-6">
            @foreach (['Pending','For Verification','Processing','Ready','Completed','Cancelled'] as $status)
                <div class="rounded-xl border border-slate-200 bg-white px-3 py-3 text-center shadow-sm">
                    <p class="text-lg font-black text-slate-900">{{ (int) ($orderStatusCounts[$status] ?? 0) }}</p>
                    <p class="text-xs text-slate-500 mt-0.5 leading-tight">{{ $status }}</p>
                </div>
            @endforeach
        </div>

        {{-- Orders Table --}}
        <div class="rounded-xl border border-slate-200 bg-white shadow-sm overflow-hidden">
            <div class="px-5 py-4 border-b border-slate-100 flex items-center justify-between">
                <p class="text-sm font-bold text-slate-800">
                    {{ $periodOrders->count() }} order(s) — {{ ucfirst($period) }}
                </p>
                <p class="text-sm text-slate-400">All Time: {{ $allOrders->count() }}</p>
            </div>
            @if ($periodOrders->isEmpty())
                <p class="px-5 py-6 text-sm text-slate-400 italic">No orders in this period.</p>
            @else
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead class="bg-slate-50 text-xs uppercase tracking-wider text-slate-500">
                            <tr>
                                <th class="px-4 py-3 text-left">Order Ref</th>
                                <th class="px-4 py-3 text-left">Customer</th>
                                <th class="px-4 py-3 text-left">Status</th>
                                <th class="px-4 py-3 text-right">Total</th>
                                <th class="px-4 py-3 text-left">Date</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @foreach ($periodOrders as $order)
                                <tr class="hover:bg-slate-50">
                                    <td class="px-4 py-3 font-mono text-xs text-slate-700">{{ $order->order_reference ?? '#'.$order->id }}</td>
                                    <td class="px-4 py-3 text-slate-700">
                                        {{ $order->customer_name ?? $order->user?->name ?? '—' }}
                                        @if ($order->customer_email ?? $order->user?->email)
                                            <span class="block text-xs text-slate-400">{{ $order->customer_email ?? $order->user?->email }}</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3">
                                        <span class="rounded-full px-2 py-0.5 text-xs font-bold
                                            @if(in_array($order->status, ['Completed','paid'])) bg-emerald-100 text-emerald-700
                                            @elseif(in_array($order->status, ['Cancelled','payment_setup_failed'])) bg-rose-100 text-rose-700
                                            @elseif(in_array($order->status, ['Processing','Ready'])) bg-blue-100 text-blue-700
                                            @else bg-amber-100 text-amber-700 @endif">
                                            {{ $order->status }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3 text-right font-semibold text-slate-900">₱{{ number_format($order->total_price, 2) }}</td>
                                    <td class="px-4 py-3 text-xs text-slate-400">{{ $order->created_at->format('M d, Y') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot class="bg-slate-50 border-t border-slate-200">
                            <tr>
                                <td colspan="3" class="px-4 py-3 text-xs font-bold text-slate-600 uppercase">Period Total</td>
                                <td class="px-4 py-3 text-right font-black text-slate-900">₱{{ number_format($periodOrders->sum('total_price'), 2) }}</td>
                                <td></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            @endif
        </div>
    </div>

    {{-- ── Customers ── --}}
    <div>
        <h2 class="text-xs font-black uppercase tracking-widest text-slate-500 mb-3">Customers</h2>
        <div class="grid gap-4 grid-cols-3 mb-5">
            <div class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm text-center">
                <p class="text-2xl font-black text-slate-900">{{ $allCustomers->count() }}</p>
                <p class="text-xs font-bold text-slate-500 mt-1 uppercase tracking-wider">Total</p>
            </div>
            <div class="rounded-xl border border-emerald-100 bg-emerald-50 p-4 shadow-sm text-center">
                <p class="text-2xl font-black text-emerald-800">{{ $activeCustomers->count() }}</p>
                <p class="text-xs font-bold text-emerald-600 mt-1 uppercase tracking-wider">Active</p>
            </div>
            <div class="rounded-xl border border-amber-100 bg-amber-50 p-4 shadow-sm text-center">
                <p class="text-2xl font-black text-amber-800">{{ $inactiveCustomers->count() }}</p>
                <p class="text-xs font-bold text-amber-600 mt-1 uppercase tracking-wider">Inactive</p>
            </div>
        </div>

        {{-- Active Customers --}}
        <div class="rounded-xl border border-slate-200 bg-white shadow-sm overflow-hidden mb-4">
            <div class="px-5 py-4 border-b border-slate-100 bg-emerald-50">
                <p class="text-sm font-bold text-emerald-800">Active Customers ({{ $activeCustomers->count() }})</p>
                <p class="text-xs text-emerald-600">Email verified accounts</p>
            </div>
            @if ($activeCustomers->isEmpty())
                <p class="px-5 py-5 text-sm text-slate-400 italic">No active customers.</p>
            @else
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead class="bg-slate-50 text-xs uppercase tracking-wider text-slate-500">
                            <tr>
                                <th class="px-4 py-3 text-left">Name</th>
                                <th class="px-4 py-3 text-left">Email</th>
                                <th class="px-4 py-3 text-left">Verified</th>
                                <th class="px-4 py-3 text-left">Joined</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @foreach ($activeCustomers as $customer)
                                <tr class="hover:bg-slate-50">
                                    <td class="px-4 py-3 font-medium text-slate-900">{{ $customer->name }}</td>
                                    <td class="px-4 py-3 text-slate-600">{{ $customer->email }}</td>
                                    <td class="px-4 py-3 text-xs text-emerald-600">{{ $customer->email_verified_at->format('M d, Y') }}</td>
                                    <td class="px-4 py-3 text-xs text-slate-400">{{ $customer->created_at->format('M d, Y') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>

        {{-- Inactive Customers --}}
        <div class="rounded-xl border border-slate-200 bg-white shadow-sm overflow-hidden">
            <div class="px-5 py-4 border-b border-slate-100 bg-amber-50">
                <p class="text-sm font-bold text-amber-800">Inactive Customers ({{ $inactiveCustomers->count() }})</p>
                <p class="text-xs text-amber-600">Email not yet verified</p>
            </div>
            @if ($inactiveCustomers->isEmpty())
                <p class="px-5 py-5 text-sm text-slate-400 italic">No inactive customers.</p>
            @else
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead class="bg-slate-50 text-xs uppercase tracking-wider text-slate-500">
                            <tr>
                                <th class="px-4 py-3 text-left">Name</th>
                                <th class="px-4 py-3 text-left">Email</th>
                                <th class="px-4 py-3 text-left">Joined</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @foreach ($inactiveCustomers as $customer)
                                <tr class="hover:bg-slate-50">
                                    <td class="px-4 py-3 font-medium text-slate-900">{{ $customer->name }}</td>
                                    <td class="px-4 py-3 text-slate-600">{{ $customer->email }}</td>
                                    <td class="px-4 py-3 text-xs text-slate-400">{{ $customer->created_at->format('M d, Y') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>

    {{-- ── Services ── --}}
    <div>
        <h2 class="text-xs font-black uppercase tracking-widest text-slate-500 mb-3">Platform Services</h2>
        <div class="rounded-xl border border-slate-200 bg-white shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="bg-slate-50 text-xs uppercase tracking-wider text-slate-500">
                        <tr>
                            <th class="px-4 py-3 text-left">Service</th>
                            <th class="px-4 py-3 text-left">Category</th>
                            <th class="px-4 py-3 text-center">Status</th>
                            <th class="px-4 py-3 text-center">Active Variations</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse ($services as $service)
                            <tr class="hover:bg-slate-50">
                                <td class="px-4 py-3 font-medium text-slate-900">{{ $service->name }}</td>
                                <td class="px-4 py-3 text-slate-500">{{ $service->category ?? '—' }}</td>
                                <td class="px-4 py-3 text-center">
                                    <span class="rounded-full px-2 py-0.5 text-xs font-bold
                                        {{ $service->is_active ? 'bg-emerald-100 text-emerald-700' : 'bg-slate-100 text-slate-500' }}">
                                        {{ $service->is_active ? 'Active' : 'Inactive' }}
                                    </span>
                                </td>
                                <td class="px-4 py-3 text-center text-slate-700 font-semibold">{{ $service->active_variations_count }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="4" class="px-4 py-6 text-center text-slate-400 italic">No services found.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- ── Sales Report ── --}}
    <div>
        <h2 class="text-xs font-black uppercase tracking-widest text-slate-500 mb-3">Sales Report</h2>
        <div class="rounded-xl border border-slate-200 bg-white shadow-sm overflow-hidden">
            <table class="w-full text-sm">
                <thead class="bg-slate-50 text-xs uppercase tracking-wider text-slate-500">
                    <tr>
                        <th class="px-4 py-3 text-left">Period</th>
                        <th class="px-4 py-3 text-right">Orders</th>
                        <th class="px-4 py-3 text-right">Revenue</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @foreach ([
                        ['label' => 'Today',      'start' => now()->startOfDay()],
                        ['label' => 'This Week',   'start' => now()->startOfWeek()],
                        ['label' => 'This Month',  'start' => now()->startOfMonth()],
                        ['label' => 'This Year',   'start' => now()->startOfYear()],
                        ['label' => 'All Time',    'start' => null],
                    ] as $row)
                        @php
                            $q = \App\Models\Order::where('admin_client_id', $user->id);
                            if ($row['start']) $q->where('created_at', '>=', $row['start']);
                            $cnt = $q->count();
                            $rev = (float) $q->sum('total_price');
                        @endphp
                        <tr class="hover:bg-slate-50">
                            <td class="px-4 py-3 font-semibold text-slate-800">{{ $row['label'] }}</td>
                            <td class="px-4 py-3 text-right text-slate-700">{{ $cnt }}</td>
                            <td class="px-4 py-3 text-right font-bold text-slate-900">₱{{ number_format($rev, 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    {{-- ── Audit Log ── --}}
    <div>
        <h2 class="text-xs font-black uppercase tracking-widest text-slate-500 mb-3">Audit History</h2>
        <div class="rounded-xl border border-slate-200 bg-white shadow-sm">
            @if ($auditLogs->isEmpty())
                <p class="px-5 py-6 text-sm text-slate-400 italic">No audit records found.</p>
            @else
                <div class="divide-y divide-slate-100">
                    @foreach ($auditLogs as $log)
                        <div class="px-5 py-3">
                            <div class="flex items-start justify-between gap-4">
                                <div>
                                    <p class="text-sm font-bold text-slate-900">{{ str_replace('_', ' ', ucfirst($log->action)) }}</p>
                                    <p class="text-xs text-slate-500 mt-0.5">
                                        Actor: {{ optional($log->actor)->email ?? 'System' }}
                                        @if ($log->targetUser && $log->targetUser->id !== $user->id)
                                            · Target: {{ $log->targetUser->email }}
                                        @endif
                                    </p>
                                </div>
                                <p class="text-xs text-slate-400 whitespace-nowrap">{{ $log->created_at->format('M d, Y h:i A') }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>

</div>
</x-app-layout>

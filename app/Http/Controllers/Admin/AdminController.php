<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User; // Import para sa Database
use Illuminate\Support\Facades\Hash; // Import para sa Password

class AdminController extends Controller
{
    /**
     * Main Dashboard View
     */
    public function dashboard()
    {
        return view('Admin.dashboard', [
            'section' => 'dashboard'
        ]);
    }

    public function customers(Request $request) 
{
    $portalUser = $request->user();

    $usersQuery = User::query()
        ->when($portalUser->isDeveloper(), fn ($query) => $query
            ->where('role', User::ROLE_ADMIN_CLIENT)
            ->where('email', 'enchantingasha@gmail.com'))
        ->when($portalUser->isAdminClient(), fn ($query) => $query
            ->where('role', User::ROLE_CUSTOMER)
            ->where('email', 'julieannecalusa@gmail.com')
            ->where('admin_client_id', $portalUser->id))
        ->when(!$portalUser->isDeveloper() && !$portalUser->isAdminClient(), fn ($query) => $query
            ->where('role', User::ROLE_CUSTOMER));

    $scopedUsers = (clone $usersQuery)->latest()->get();
    $activeUsers = (clone $usersQuery)
        ->whereNotNull('email_verified_at')
        ->when($portalUser->isDeveloper(), fn ($query) => $query->whereNotNull('approved_at'))
        ->count();

    $pendingUsers = (clone $usersQuery)
        ->where(function ($query) use ($portalUser) {
            $query->whereNull('email_verified_at');

            if ($portalUser->isDeveloper()) {
                $query->orWhereNull('approved_at');
            }
        })
        ->count();

    $customerMetrics = [
        'totalLabel' => $portalUser->isDeveloper() ? 'Total Admin Clients' : 'Total Customers',
        'activeLabel' => $portalUser->isDeveloper() ? 'Active Admin Clients' : 'Active Customers',
        'pendingLabel' => $portalUser->isDeveloper() ? 'Pending Admin Clients' : 'Pending Customers',
        'total' => $scopedUsers->count(),
        'active' => $activeUsers,
        'pending' => $pendingUsers,
        'suspended' => 0,
    ];

    $customerUsers = $scopedUsers->map(function (User $user) use ($portalUser) {
        $status = $user->email_verified_at && (!$portalUser->isDeveloper() || $user->approved_at)
            ? 'ACTIVE'
            : 'INVITED';

        $roleLabel = $user->isAdminClient() ? 'Admin Client' : 'Customer User';

        return [
            'id' => ($user->isAdminClient() ? 'ADM-' : 'CUST-') . str_pad((string) $user->id, 4, '0', STR_PAD_LEFT),
            'name' => $user->name,
            'email' => $user->email,
            'phone' => $user->phone ?? 'N/A',
            'company' => $user->company ?? ($user->adminClientProfile?->business_name ?? 'N/A'),
            'status' => $status,
            'role' => $roleLabel,
            'roleShort' => $user->isAdminClient() ? 'Admin Client' : 'Customer',
            'scope' => $user->isAdminClient() ? 'Admin Client Account' : 'Linked to ' . ($user->assignedAdminClient?->name ?? 'admin client'),
            'permissions' => $user->isAdminClient() ? 'Approved portal access' : 'Customer account access',
            'joined' => optional($user->created_at)->format('M d, Y') ?? 'N/A',
            'since' => optional($user->created_at)->format('M d, Y h:i A') ?? 'N/A',
            'lastLogin' => $user->email_verified_at ? 'Verified ' . $user->email_verified_at->format('M d, Y h:i A') : 'Not verified yet',
            'photo' => $user->profile_photo ?? '',
            'orders' => [],
        ];
    })->values();

    return view('Admin.dashboard', [
        'section' => 'customers',
        'users' => $scopedUsers,
        'customerMetrics' => $customerMetrics,
        'customerUsersJson' => $customerUsers,
    ]); 
}

    /**
     * Store or Update Customer Record (CRUD)
     */
    public function saveCustomer(Request $request)
    {
        // Validation - sinisiguro na tama ang input
        $validated = $request->validate([
            'id'    => 'nullable|exists:users,id',
            'name'  => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $request->id,
            'role'  => 'required',
            'phone' => 'nullable',
            'address' => 'nullable',
        ]);

        // Logic para sa Add o Edit
        if ($request->id) {
            $user = User::find($request->id);
        } else {
            $user = new User();
            // Default password para sa mga bagong register
            $user->password = Hash::make('customer123'); 
        }

        $user->name = $request->name;
        $user->email = $request->email;
        $user->role = $request->role;
        $user->phone = $request->phone;
        $user->address = $request->address;
        $user->status = $request->status ?? 'ACTIVE';
        $user->save();

        return response()->json([
            'success' => true, 
            'message' => 'User record saved successfully!',
            'user' => $user
        ]);
    }

    /**
     * Delete Customer Record (CRUD)
     */
    public function deleteCustomer($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return response()->json([
            'success' => true, 
            'message' => 'User deleted successfully!'
        ]);
    }

    /**
     * Orders Management Section
     */
    public function orders() 
    {
        return view('Admin.dashboard', [
            'section' => 'orders'
        ]);
    }

    /**
     * Products Catalog Section
     */
    public function products() 
    {
        return view('Admin.dashboard', [
            'section' => 'products'
        ]);
    }

    /**
     * Rates & Pricing Section
     */
    public function rates() 
    {
        return view('Admin.dashboard', [
            'section' => 'rates'
        ]);
    }

    /**
     * Business Analytics Section
     */
    public function analytics() 
    {
        return view('Admin.dashboard', [
            'section' => 'analytics'
        ]);
    }

    /**
     * Generation of Reports Section
     */
    public function reports() 
    {
        return view('Admin.dashboard', [
            'section' => 'reports'
        ]);
    }

    /**
     * System Settings Section
     */
    public function settings() 
    {
        return view('Admin.dashboard', [
            'section' => 'settings'
        ]);
    }

    /**
     * Help Center Section
     */
    public function helpcenter() 
    {
        return view('Admin.dashboard', [
            'section' => 'help center'
        ]);
    }

    /**
     * Admin Logout Logic
     */
    public function logout(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}

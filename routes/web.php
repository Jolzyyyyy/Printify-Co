<?php

use App\Http\Controllers\Admin\AdminClientInvitationController;
use App\Http\Controllers\Admin\AdminClientProfileController;
use App\Http\Controllers\Admin\AdminController;
// --- CUSTOMER CONTROLLERS ---
use App\Http\Controllers\Admin\Auth\AdminAuthController;
use App\Http\Controllers\Admin\Auth\AdminPasswordResetLinkController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\DeveloperAdminClientController;
use App\Http\Controllers\Admin\SectionController as AdminSectionController;
use App\Http\Controllers\Admin\SecurityController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\EReceiptController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\ServiceDetailController;
// --- CUSTOMER AUTH CONTROLLERS ---
use App\Http\Controllers\FrontPageController;
// --- ADMIN CONTROLLERS ---
use App\Http\Controllers\GoogleController;
use App\Http\Controllers\LalamoveDeliveryController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaymongoCheckoutController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\SupportTicketController;
use App\Models\Order;
use Illuminate\Http\Request;
// --- THIRD PARTY AUTH CONTROLLERS ---
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| 1. PUBLIC ROUTES (STAY)
|--------------------------------------------------------------------------
*/
Route::get('/', fn () => redirect('/home'))->name('root');
Route::get('/home', [FrontPageController::class, 'home'])->name('home');
Route::get('/products', [FrontPageController::class, 'products'])->name('landing.products');
Route::get('/search', [FrontPageController::class, 'home'])->name('landing.search');
Route::get('/about', [FrontPageController::class, 'about'])->name('landing.about');
Route::get('/aboutus', [FrontPageController::class, 'about'])->name('landing.aboutus');
Route::get('/contact', [FrontPageController::class, 'contact'])->name('landing.contact');
Route::get('/contactus', [FrontPageController::class, 'contact'])->name('landing.contactus');
Route::post('/contact', [FrontPageController::class, 'submitContact'])->name('landing.contact.submit');
Route::post('/contactus', [FrontPageController::class, 'submitContact'])->name('landing.contactus.submit');
Route::view('/privacy-policy', 'legal.privacy-policy')->name('legal.privacy');
Route::view('/terms-of-service', 'legal.terms-of-service')->name('legal.terms');
Route::get('/support', fn () => redirect()->route('landing.contactus'))->name('support');
Route::get('/service-detail', [FrontPageController::class, 'serviceDetail'])->name('landing.service-detail');
Route::get('/service-details', [FrontPageController::class, 'serviceDetail'])->name('landing.service-details');
Route::middleware(['auth', 'role:customer', 'customer_otp'])->group(function () {
    Route::get('/checkout', [FrontPageController::class, 'checkout'])->name('checkout.index');
    Route::get('/e-receipt', [FrontPageController::class, 'eReceipt'])->name('e-receipt.index');
    Route::get('/e-receipt/details', [EReceiptController::class, 'show'])->name('e-receipt.show');
    Route::post('/e-receipt', [EReceiptController::class, 'store'])->name('e-receipt.store');
    Route::get('/service-details/catalog', [ServiceDetailController::class, 'catalog'])->name('service-details.catalog');
    Route::get('/service-details/state', [ServiceDetailController::class, 'state'])->name('service-details.state');
    Route::post('/service-details/state', [ServiceDetailController::class, 'update'])->name('service-details.update');
    Route::post('/service-details/upload', [ServiceDetailController::class, 'upload'])->name('service-details.upload');
    Route::delete('/service-details/upload', [ServiceDetailController::class, 'removeUpload'])->name('service-details.upload.remove');
});

Route::get('/services', [ServiceController::class, 'index'])->name('services.index');
Route::get('/services/{service}', [ServiceController::class, 'show'])->name('services.show');

Route::middleware(['auth', 'role:customer', 'customer_otp'])->prefix('cart')->name('cart.')->group(function () {
    Route::get('/', [CartController::class, 'index'])->name('index');
    Route::get('/state', [CartController::class, 'state'])->name('state');
    Route::post('/attachment', [CartController::class, 'attach'])->name('attachment');
    Route::post('/promo', [CartController::class, 'promo'])->name('promo');
    Route::post('/add/{service}', [CartController::class, 'add'])->name('add');
    Route::post('/update/{cartKey}', [CartController::class, 'update'])->name('update');
    Route::post('/remove/{cartKey}', [CartController::class, 'remove'])->name('remove');
    Route::post('/clear', [CartController::class, 'clear'])->name('clear');
    Route::post('/sync', [CartController::class, 'syncCart'])->name('sync');
});

Route::middleware(['auth', 'role:customer', 'customer_otp'])->group(function () {
    Route::get('/payment/checkout', [PaymongoCheckoutController::class, 'checkout'])->name('payment.checkout');
    Route::post('/payment/start', [PaymongoCheckoutController::class, 'start'])->name('payment.start');
    Route::post('/payment/pay', [PaymongoCheckoutController::class, 'pay'])->name('payment.pay');
    Route::get('/payment/success', [PaymongoCheckoutController::class, 'success'])->name('payment.success');
    Route::get('/payment/cancel', [PaymongoCheckoutController::class, 'cancel'])->name('payment.cancel');
});
Route::post('/paymongo/webhook', [PaymongoCheckoutController::class, 'webhook'])->name('payment.paymongo.webhook');
Route::get('/checkout.php', fn () => redirect('/checkout'));

/*
|--------------------------------------------------------------------------
| 2. PASSWORD SETUP (STAY)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {

    Route::get('/setup-password', [GoogleController::class, 'showSetupPassword'])->name('setup-password');
    Route::post('/setup-password-submit', [GoogleController::class, 'updateSetupPassword'])->name('password.setup.submit');
});

/*
|--------------------------------------------------------------------------
| 3. CUSTOMER SECURED SECTION (FIXED HOME REDIRECT)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:customer', 'customer_otp'])->group(function () {

    // FIXED: Ngayon, kapag kinlick ang HOME sa sidebar, babalik ito sa main landing page ('welcome')
    Route::get('/customer-home', function () {
        return redirect()->route('home');
    })->name('customer.home');

    Route::get('/dashboard', function (Request $request) {
        $orders = Order::query()
            ->where('user_id', $request->user()->id)
            ->with(['items.service', 'items.serviceVariation', 'files'])
            ->latest()
            ->get()
            ->map(function (Order $order) {
                $firstItem = $order->items->first();
                $status = strtolower((string) ($order->status ?: 'pending'));

                $order->order_number = $order->order_reference ?: 'ORD-'.str_pad((string) $order->id, 6, '0', STR_PAD_LEFT);
                $order->product_name = $firstItem?->service_name ?: $firstItem?->service?->name ?: 'Print Job';
                $order->project_name = $order->product_name;
                $order->total_amount = (float) ($order->total_price ?? 0);
                $order->total = $order->total_amount;
                $order->payment_status = $order->paid_at || in_array($status, ['paid', 'completed', 'delivered'], true) ? 'paid' : ($status === 'payment_setup_failed' ? 'failed' : 'pending');

                return $order;
            });

        $activeOrders = $orders->filter(fn ($order) => ! in_array(strtolower((string) $order->status), ['completed', 'delivered', 'cancelled'], true));
        $readyOrders = $orders->filter(fn ($order) => in_array(strtolower((string) ($order->lalamove_status ?: $order->status)), ['ready', 'ready_for_pickup', 'shipped', 'out_for_delivery', 'assigning_driver', 'on_going', 'picked_up'], true));

        return view('dashboard', compact('orders', 'activeOrders', 'readyOrders'));
    })->name('dashboard');

    // ROUTES PARA SA CUSTOMER PROFILE
    Route::prefix('profile')->name('profile.')->group(function () {
        Route::get('/', [ProfileController::class, 'edit'])->name('edit');
        Route::patch('/', [ProfileController::class, 'update'])->name('update');
        Route::patch('/backup-email', [ProfileController::class, 'updateBackupEmail'])->name('backup-email.update');
        Route::delete('/', [ProfileController::class, 'destroy'])->name('destroy');
    });

    // --- CUSTOMER ORDER FLOW ---
    Route::get('/co/place-order', [OrderController::class, 'myOrders'])->name('co.place-order');
    Route::get('/co/place-order/{order}', [OrderController::class, 'myShow'])->name('co.place-order.show');
    Route::get('/co/place-order/{order}/tracking', [OrderController::class, 'myTracking'])->name('co.place-order.tracking');

    Route::get('/my-orders', [OrderController::class, 'portalMyOrders'])->name('my-orders');
    Route::get('/my-orders/{order}', [OrderController::class, 'portalMyShow'])->name('my-orders.show');
    Route::get('/customer/orders', [OrderController::class, 'portalMyOrders'])->name('customer.orders.index');
    Route::get('/customer/orders/{order}', [OrderController::class, 'portalMyShow'])->name('customer.orders.show');
    Route::get('/orders', [OrderController::class, 'portalMyOrders'])->name('orders.index');
    Route::get('/orders/my', [OrderController::class, 'portalMyOrders'])->name('orders.my.index');
    Route::get('/orders/my/{order}', [OrderController::class, 'portalMyShow'])->name('orders.my.show');

    // 2. NOTIFICATIONS
    Route::get('/notifications', function () {
        return view('notifications');
    })->name('notifications');

    // 3. SETTINGS
    Route::get('/settings', function () {
        return view('settings');
    })->name('settings');
    Route::post('/settings/save', function (Request $request) {
        $data = $request->validate([
            'key' => ['required', 'string', 'max:120'],
            'value' => ['nullable'],
            'group' => ['nullable', 'string', 'max:60'],
        ]);

        $settings = session('customer_settings', []);
        $group = $data['group'] ?? 'general';
        $settings[$group][$data['key']] = $data['value'];
        session(['customer_settings' => $settings]);

        return response()->json([
            'ok' => true,
            'message' => 'Settings saved.',
            'settings' => $settings[$group],
        ]);
    })->name('settings.save');

    // 4. SECURITY
    Route::get('/security', function () {
        return view('security');
    })->name('security');

    // 5. HELP CENTER
    Route::get('/help-center', function () {
        return view('help-center');
    })->name('help-center');
    Route::post('/help-center/tickets', [SupportTicketController::class, 'store'])->name('help-center.tickets.store');

    Route::post('/checkout/place', [CheckoutController::class, 'place'])->name('checkout.place');
    Route::post('/delivery/lalamove/quote', [LalamoveDeliveryController::class, 'quote'])->name('delivery.lalamove.quote');
    Route::post('/orders/{order}/delivery/book', [LalamoveDeliveryController::class, 'book'])->name('orders.delivery.book');
    Route::post('/orders/{order}/delivery/refresh', [LalamoveDeliveryController::class, 'refresh'])->name('orders.delivery.refresh');
    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('customer.logout');
});

/*
|--------------------------------------------------------------------------
| 5. ADMIN SECTION (STAY)
|--------------------------------------------------------------------------
*/

// Admin Login Guest Routes
Route::get('/p-co-2026', function () {
    if (! auth()->check() || ! auth()->user()->canAccessAdminPortal()) {
        return redirect()->route('admin.login');
    }

    return session('staff_otp_passed') === true
        ? redirect()->route('admin.dashboard')
        : redirect()->route('admin.otp.verify');
})->name('admin.portal.entry');

Route::middleware('guest')->prefix('p-co-2026')->group(function () {
    Route::get('/login-7b5e93-adm-key', [AdminAuthController::class, 'showLoginForm'])->name('admin.login');
    Route::get('/register-7b5e93-adm-key', fn () => abort(404))->name('admin.register');
    Route::post('/login-7b5e93-adm-key', [AdminAuthController::class, 'login'])->name('admin.login.submit');
    Route::post('/register-7b5e93-adm-key', fn () => abort(404))->name('admin.register.submit');
    Route::get('/forgot-password-7b5e93-adm-key', [AdminPasswordResetLinkController::class, 'create'])->name('admin.password.request');
    Route::post('/forgot-password-7b5e93-adm-key', [AdminPasswordResetLinkController::class, 'store'])->name('admin.password.email');
    Route::get('/admin-client-invite/{token}', [AdminClientInvitationController::class, 'show'])->name('admin-client-invitations.show');
    Route::post('/admin-client-invite/{token}', [AdminClientInvitationController::class, 'store'])->name('admin-client-invitations.store');
});

// Admin Authenticated Routes
Route::middleware(['auth'])->prefix('p-co-2026/admin')->group(function () {

    // Phase 1: Email OTP
    Route::get('/verify-access', [AdminAuthController::class, 'showOtpForm'])->name('admin.otp.verify');
    Route::post('/verify-otp-submit', [AdminAuthController::class, 'verifyOtp'])->name('admin.otp.submit');
    Route::post('/resend-otp', [AdminAuthController::class, 'resendOtp'])->name('admin.otp.resend');

    // Admin Dashboard & Resources
    Route::middleware(['role:admin_client,developer', 'staff.portal', 'admin.client.profile'])->group(function () {

        // 1. DASHBOARD
        Route::get('/dashboard', AdminDashboardController::class)->name('admin.dashboard');

        // Phase 2: 2FA Security
        Route::get('/security-2fa', [SecurityController::class, 'show2faForm'])->name('admin.security.2fa');
        Route::post('/security-2fa-verify', [SecurityController::class, 'verify2fa'])->name('admin.security.2fa.activate');

        // 2. CUSTOMER/USER
        Route::get('/customers', [AdminController::class, 'customers'])->name('admin.customers');

        // 3. ORDERS
        Route::get('/orders', [AdminController::class, 'orders'])->name('admin.orders');
        Route::get('/orders-database', [OrderController::class, 'index'])->name('admin.orders.index');
        Route::get('/orders-database/{order}', [OrderController::class, 'show'])->name('admin.orders.show');
        Route::post('/orders-database/{order}/delivery/book', [LalamoveDeliveryController::class, 'book'])->name('admin.orders.delivery.book');
        Route::post('/orders-database/{order}/delivery/refresh', [LalamoveDeliveryController::class, 'refresh'])->name('admin.orders.delivery.refresh');
        Route::middleware('role:developer')->group(function () {
            Route::get('/orders-database/{order}/edit', [OrderController::class, 'edit'])->name('admin.orders.edit');
            Route::put('/orders-database/{order}', [OrderController::class, 'update'])->name('admin.orders.update');
            Route::delete('/orders-database/{order}', [OrderController::class, 'destroy'])->name('admin.orders.destroy');
        });

        // 4. PRODUCTS
        Route::get('/products', [AdminController::class, 'products'])->name('admin.products');
        Route::get('/services', [ServiceController::class, 'adminIndex'])->name('admin.services.index');
        Route::middleware('role:developer')->group(function () {
            Route::get('/services/create', [ServiceController::class, 'create'])->name('admin.services.create');
            Route::post('/services', [ServiceController::class, 'store'])->name('admin.services.store');
            Route::get('/services/{service}/edit', [ServiceController::class, 'edit'])->name('admin.services.edit');
            Route::put('/services/{service}', [ServiceController::class, 'update'])->name('admin.services.update');
            Route::delete('/services/{service}', [ServiceController::class, 'destroy'])->name('admin.services.destroy');
            Route::patch('/services/{service}/toggle', [ServiceController::class, 'toggleActive'])->name('admin.services.toggle');
        });

        // 5. RATES
        Route::get('/rates', [AdminController::class, 'rates'])->name('admin.rates');

        // 6. ANALYTICS
        Route::get('/analytics', [AdminController::class, 'analytics'])->name('admin.analytics');

        // 7. REPORTS
        Route::get('/reports', [AdminController::class, 'reports'])->name('admin.reports');

        // 8. SETTINGS
        Route::get('/settings', [AdminController::class, 'settings'])->name('admin.settings');

        // 9. HELP CENTER
        Route::get('/help-center', [AdminController::class, 'helpcenter'])->name('admin.helpcenter');
        Route::get('/section/customers', [AdminSectionController::class, 'customers'])->name('admin.customers.index');
        Route::get('/section/analytics', [AdminSectionController::class, 'analytics'])->name('admin.analytics.index');
        Route::get('/section/reports', [AdminSectionController::class, 'reports'])->name('admin.reports.index');
        Route::get('/section/settings', [AdminSectionController::class, 'settings'])->name('admin.settings.index');
        Route::get('/section/help-center', [AdminSectionController::class, 'help'])->name('admin.help.index');

        // PROFILE & LOGOUT
        Route::get('/profile', [ProfileController::class, 'adminEdit'])->name('admin.profile.edit');
        Route::patch('/profile', [ProfileController::class, 'adminUpdate'])->name('admin.profile.update');
        Route::get('/reference-profile', [AdminClientProfileController::class, 'edit'])->name('admin.admin-client-profile.edit');
        Route::put('/reference-profile', [AdminClientProfileController::class, 'update'])->name('admin.admin-client-profile.update');
        Route::post('/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');
    });
});

Route::middleware(['auth', 'staff.portal', 'role:developer'])->prefix('p-co-2026/developer')->name('developer.')->group(function () {
    Route::get('/orders', [AdminSectionController::class, 'orders'])->name('orders.index');
    Route::get('/services', [AdminSectionController::class, 'services'])->name('services.index');
    Route::get('/customers', [AdminSectionController::class, 'customers'])->name('customers.index');
    Route::get('/reports', [AdminSectionController::class, 'reports'])->name('reports.index');
    Route::get('/analytics', [AdminSectionController::class, 'analytics'])->name('analytics.index');
    Route::get('/settings', [AdminSectionController::class, 'settings'])->name('settings.index');
    Route::get('/admin-clients', [DeveloperAdminClientController::class, 'index'])->name('admin-clients.index');
    Route::post('/admin-clients', [DeveloperAdminClientController::class, 'store'])->name('admin-clients.store');
    Route::get('/admin-clients/{user}', [DeveloperAdminClientController::class, 'show'])->name('admin-clients.show');
    Route::patch('/admin-clients/{user}/approve', [DeveloperAdminClientController::class, 'approve'])->name('admin-clients.approve');
    Route::patch('/admin-clients/{user}/suspend', [DeveloperAdminClientController::class, 'suspend'])->name('admin-clients.suspend');
    Route::patch('/admin-clients/{user}/assign-customer', [DeveloperAdminClientController::class, 'assignCustomer'])->name('admin-clients.assign-customer');
});

if (file_exists(__DIR__.'/auth.php')) {
    require __DIR__.'/auth.php';
}

// Routes para sa CRUD operations ng Customers
Route::middleware(['auth', 'staff.portal', 'role:developer'])->prefix('admin/customers')->group(function () {
    Route::post('/save', [AdminController::class, 'saveCustomer'])->name('admin.customers.save');
    Route::delete('/delete/{id}', [AdminController::class, 'deleteCustomer'])->name('admin.customers.delete');
});

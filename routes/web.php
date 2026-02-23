<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\TourController;
use App\Http\Controllers\Public\TourController as PublicTourController;
use App\Http\Controllers\Public\BookingController as PublicBookingController;
use App\Http\Controllers\Admin\ExpenseController;
use App\Http\Controllers\Admin\SystemSettingsController;
use App\Http\Controllers\Admin\UserManagementController;
use App\Http\Controllers\Admin\RolePermissionController;
use App\Http\Controllers\Admin\ActivityLogController;
use App\Http\Controllers\Admin\SystemHealthController;

Route::get('/', [PublicTourController::class, 'home'])->name('home');

Route::get('/about', function () {
    return view('about');
})->name('about');

Route::get('/contact', function () {
    return view('contact');
})->name('contact');

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Password Recovery
Route::get('/password/reset', function () {
    return view('auth.forgot-password');
})->name('password.request');

Route::post('/password/reset', function (Illuminate\Http\Request $request) {
    return back()->with('status', 'A recovery link has been sent to your inbox.');
})->name('password.email');

Route::get('/kilimanjaro', function () {
    return view('kilimanjaro');
})->name('kilimanjaro');

Route::prefix('regions')->name('regions.')->group(function () {
    Route::get('/serengeti', function () { return view('regions.serengeti'); })->name('serengeti');
    Route::get('/ngorongoro', function () { return view('regions.ngorongoro'); })->name('ngorongoro');
    Route::get('/zanzibar', function () { return view('regions.zanzibar'); })->name('zanzibar');
    Route::get('/tarangire', function () { return view('regions.tarangire'); })->name('tarangire');
    Route::get('/lake-manyara', function () { return view('regions.lake-manyara'); })->name('lake-manyara');
    Route::get('/nyerere', function () { return view('regions.nyerere'); })->name('nyerere');
    Route::get('/ruaha', function () { return view('regions.ruaha'); })->name('ruaha');
    Route::get('/mafia', function () { return view('regions.mafia'); })->name('mafia');
    Route::get('/arusha-national-park', function () { return view('regions.arusha-national-park'); })->name('arusha-national-park');
});

Route::get('/group-departures', function () {
    return view('group-departures');
})->name('group-departures');

// Legal & Policies
Route::get('/terms', function () { return view('legal.terms'); })->name('terms');
Route::get('/privacy', function () { return view('legal.privacy'); })->name('privacy');
Route::get('/cookies', function () { return view('legal.cookies'); })->name('cookies');
Route::get('/refund-policy', function () { return view('legal.refund'); })->name('refund');
Route::get('/editorial-policy', function () { return view('legal.editorial'); })->name('editorial');
Route::get('/sustainability-policy', function () { return view('legal.sustainability'); })->name('sustainability');

Route::get('/tours', [PublicTourController::class, 'index'])->name('tours.index');
Route::get('/tours/{id}', [PublicTourController::class, 'show'])->name('tours.show');
Route::post('/bookings', [PublicBookingController::class, 'store'])->name('bookings.store');
Route::get('/bookings/{id}/checkout', [PublicBookingController::class, 'checkout'])->name('bookings.checkout');
Route::get('/bookings/{id}/invoice', [PublicBookingController::class, 'downloadInvoice'])->name('bookings.invoice');

Route::prefix('admin')->name('admin.')->middleware(['auth', 'activity.log'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('tours', TourController::class)->whereNumber('tour');

    // Tours & Packages Subpages
    Route::get('/tours/itinerary-builder', function () { return view('admin.tours.itinerary-builder'); })->name('tours.itinerary-builder');
    Route::get('/tours/availability-pricing', function () { return view('admin.tours.availability-pricing'); })->name('tours.availability-pricing');
    Route::get('/tours/destinations', function () { return view('admin.tours.destinations'); })->name('tours.destinations');
    
    // CRM & Sales
    Route::get('/bookings', [App\Http\Controllers\Admin\BookingController::class, 'index'])->name('bookings.index');
    Route::get('/bookings/pending', [App\Http\Controllers\Admin\BookingController::class, 'pending'])->name('bookings.pending');
    Route::get('/bookings/confirmed', [App\Http\Controllers\Admin\BookingController::class, 'confirmed'])->name('bookings.confirmed');
    Route::get('/bookings/calendar', [App\Http\Controllers\Admin\BookingController::class, 'calendar'])->name('bookings.calendar');
    Route::get('/bookings/create', [App\Http\Controllers\Admin\BookingController::class, 'create'])->name('bookings.create');
    Route::post('/bookings', [App\Http\Controllers\Admin\BookingController::class, 'store'])->name('bookings.store');
    Route::get('/bookings/{id}', [App\Http\Controllers\Admin\BookingController::class, 'show'])->name('bookings.show');
    Route::get('/bookings/{id}/edit', [App\Http\Controllers\Admin\BookingController::class, 'edit'])->name('bookings.edit');
    Route::put('/bookings/{id}', [App\Http\Controllers\Admin\BookingController::class, 'update'])->name('bookings.update');
    Route::get('/bookings/{id}/assignments', [App\Http\Controllers\Admin\BookingController::class, 'editAssignments'])->name('bookings.assignments.edit');
    Route::put('/bookings/{id}/assignments', [App\Http\Controllers\Admin\BookingController::class, 'updateAssignments'])->name('bookings.assignments.update');
    Route::post('/bookings/{id}/send-itinerary', [App\Http\Controllers\Admin\BookingController::class, 'sendItinerary'])->name('bookings.send-itinerary');
    Route::get('/bookings/{id}/receipt', [App\Http\Controllers\Admin\BookingController::class, 'downloadReceipt'])->name('bookings.receipt');
    Route::post('/bookings/{id}/verify-payment', [App\Http\Controllers\Admin\BookingController::class, 'verifyPayment'])->name('bookings.verify-payment');
    Route::get('/quotations', function() { return view('admin.quotations.index'); })->name('quotations.index');
    Route::get('/quotations/create', function() { return view('admin.quotations.create'); })->name('quotations.create');
    Route::get('/quotations/accepted', function() { return view('admin.quotations.accepted'); })->name('quotations.accepted');
    Route::get('/quotations/export-pdf', function () {
        $quotes = [
            ['id' => 'QT-2026-001', 'client' => 'Marcus Aurelius', 'brief' => '8 Days Northern Circuit Premium', 'val' => '$12,400', 'status' => 'Sent'],
            ['id' => 'QT-2026-002', 'client' => 'Lucius Vorenus', 'brief' => '3 Days Serengeti Balloon Safari', 'val' => '$4,200', 'status' => 'Converted'],
            ['id' => 'QT-2026-003', 'client' => 'Julius Caesar', 'brief' => '14 Days Luxury Tanzania & Zanzibar', 'val' => '$32,500', 'status' => 'Draft'],
            ['id' => 'QT-2026-004', 'client' => 'Cleopatra VII', 'brief' => '5 Days Kili Marangu Route', 'val' => '$2,800', 'status' => 'Expired'],
        ];

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('pdf.quotations', [
            'quotes' => $quotes,
            'generatedAt' => now(),
            'generatedBy' => auth()->user(),
        ]);

        return $pdf->download('Quotations_' . now()->format('Ymd_His') . '.pdf');
    })->name('quotations.export-pdf');
    Route::get('/customers', function() { return view('admin.customers.index'); })->name('customers.index');
    
    // Inventory & Logistics
    Route::get('/hotels', function() { return view('admin.hotels.index'); })->name('hotels.index');
    Route::get('/fleet', function() { return view('admin.fleet.index'); })->name('fleet.index');
    
    // Finance & Analytics
    Route::get('/finance', function() { return view('admin.finance.index'); })->name('finance.index');
    Route::get('/finance/payments-received', function() { return view('admin.finance.payments-received'); })->name('finance.payments-received');
    Route::get('/finance/generated-invoices', function() { return view('admin.finance.generated-invoices'); })->name('finance.generated-invoices');
    Route::get('/finance/expense-tracking', function() { return view('admin.finance.expense-tracking'); })->name('finance.expense-tracking');
    Route::get('/finance/expenses', [ExpenseController::class, 'index'])->name('finance.expenses.index');
    Route::get('/finance/expenses/create', [ExpenseController::class, 'create'])->name('finance.expenses.create');
    Route::post('/finance/expenses', [ExpenseController::class, 'store'])->name('finance.expenses.store');
    Route::get('/finance/expenses/{expense}/edit', [ExpenseController::class, 'edit'])->whereNumber('expense')->name('finance.expenses.edit');
    Route::put('/finance/expenses/{expense}', [ExpenseController::class, 'update'])->whereNumber('expense')->name('finance.expenses.update');
    Route::delete('/finance/expenses/{expense}', [ExpenseController::class, 'destroy'])->whereNumber('expense')->name('finance.expenses.destroy');
    Route::get('/finance/revenue-reports', function() { return view('admin.finance.revenue-reports'); })->name('finance.revenue-reports');
    Route::get('/statistics', function() { return view('admin.statistics.index'); })->name('statistics.index');
    
    // System & Content
    Route::get('/marketing', function() { return view('admin.marketing.index'); })->name('marketing.index');
    Route::get('/website', function() { return view('admin.website.index'); })->name('website.index');
    Route::get('/support', function() { return view('admin.support.index'); })->name('support.index');
    Route::get('/settings', [SystemSettingsController::class, 'edit'])->name('settings.index');
    Route::put('/settings', [SystemSettingsController::class, 'update'])->name('settings.update');
    Route::get('/settings/user-management', [UserManagementController::class, 'index'])->name('settings.users.index');
    Route::post('/settings/user-management', [UserManagementController::class, 'store'])->name('settings.users.store');
    Route::put('/settings/user-management/{user}', [UserManagementController::class, 'update'])->whereNumber('user')->name('settings.users.update');
    Route::get('/settings/role-permissions', [RolePermissionController::class, 'index'])->name('settings.roles.index');
    Route::post('/settings/role-permissions/roles', [RolePermissionController::class, 'storeRole'])->name('settings.roles.store');
    Route::put('/settings/role-permissions/roles/{role}', [RolePermissionController::class, 'updateRole'])->whereNumber('role')->name('settings.roles.update');
    Route::get('/settings/activity-logs', [ActivityLogController::class, 'index'])->name('settings.activity-logs.index');
    Route::get('/settings/activity-logs/{log}', [ActivityLogController::class, 'show'])->whereNumber('log')->name('settings.activity-logs.show');
    Route::get('/settings/system-health', [SystemHealthController::class, 'index'])->name('settings.system-health.index');
    
    // SMS Gateway Settings
    Route::prefix('settings/sms-gateway')->name('settings.sms-gateway.')->group(function() {
        Route::get('/', [App\Http\Controllers\Admin\SMSGatewayController::class, 'index'])->name('index');
        Route::get('/create', [App\Http\Controllers\Admin\SMSGatewayController::class, 'create'])->name('create');
        Route::post('/', [App\Http\Controllers\Admin\SMSGatewayController::class, 'store'])->name('store');
        Route::put('/{id}', [App\Http\Controllers\Admin\SMSGatewayController::class, 'update'])->name('update');
        Route::delete('/{id}', [App\Http\Controllers\Admin\SMSGatewayController::class, 'destroy'])->name('destroy');
        Route::post('/{id}/test-connection', [App\Http\Controllers\Admin\SMSGatewayController::class, 'testConnection'])->name('testConnection');
        Route::post('/{id}/toggle-active', [App\Http\Controllers\Admin\SMSGatewayController::class, 'toggleActive'])->name('toggleActive');
        Route::post('/{id}/set-primary', [App\Http\Controllers\Admin\SMSGatewayController::class, 'setPrimary'])->name('setPrimary');
        Route::post('/draft/test-connection', [App\Http\Controllers\Admin\SMSGatewayController::class, 'testDraftConnection'])->name('draft.testConnection');
        Route::post('/draft/test-sms', [App\Http\Controllers\Admin\SMSGatewayController::class, 'testDraftSms'])->name('draft.testSms');
        Route::post('/test', [App\Http\Controllers\Admin\SMSGatewayController::class, 'test'])->name('test');
    });

    // Account Management
    Route::get('/profile', function() { return view('admin.profile'); })->name('profile');
    Route::get('/settings/account', function() { return view('admin.account-settings'); })->name('account-settings');
    Route::post('/settings/account', function() { 
        return back()->with('success', 'Profile updated successfully!'); 
    })->name('account-settings.update');
});

// Stripe Payments
Route::get('/checkout/{id}', [App\Http\Controllers\PaymentController::class, 'checkout'])->name('checkout');
Route::post('/create-payment-intent', [App\Http\Controllers\PaymentController::class, 'createPaymentIntent'])->name('payment.intent');
Route::get('/payment/success', [App\Http\Controllers\PaymentController::class, 'success'])->name('payment.success');

// Flutterwave Payments
Route::get('/pay-with-flutterwave/{id}', [App\Http\Controllers\FlutterwaveController::class, 'initialize'])->name('flutterwave.pay');
Route::get('/flutterwave/get-link/{id}', [App\Http\Controllers\FlutterwaveController::class, 'getLink'])->name('flutterwave.get-link');
Route::get('/flutterwave/callback', [App\Http\Controllers\FlutterwaveController::class, 'callback'])->name('flutterwave.callback');

// Stripe Webhook
Route::post('/stripe/webhook', [App\Http\Controllers\WebhookController::class, 'handle']);
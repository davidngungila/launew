<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\TourController;
use App\Http\Controllers\Public\TourController as PublicTourController;
use App\Http\Controllers\Public\BookingController as PublicBookingController;

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

Route::get('/tours', [PublicTourController::class, 'index'])->name('tours.index');
Route::get('/tours/{id}', [PublicTourController::class, 'show'])->name('tours.show');
Route::post('/bookings', [PublicBookingController::class, 'store'])->name('bookings.store');
Route::get('/bookings/{id}/checkout', [PublicBookingController::class, 'checkout'])->name('bookings.checkout');
Route::get('/bookings/{id}/invoice', [PublicBookingController::class, 'downloadInvoice'])->name('bookings.invoice');

Route::prefix('admin')->name('admin.')->middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('tours', TourController::class);
    
    // CRM & Sales
    Route::get('/bookings', [App\Http\Controllers\Admin\BookingController::class, 'index'])->name('bookings.index');
    Route::get('/bookings/pending', [App\Http\Controllers\Admin\BookingController::class, 'pending'])->name('bookings.pending');
    Route::get('/bookings/confirmed', [App\Http\Controllers\Admin\BookingController::class, 'confirmed'])->name('bookings.confirmed');
    Route::get('/bookings/calendar', [App\Http\Controllers\Admin\BookingController::class, 'calendar'])->name('bookings.calendar');
    Route::get('/bookings/create', [App\Http\Controllers\Admin\BookingController::class, 'create'])->name('bookings.create');
    Route::post('/bookings', [App\Http\Controllers\Admin\BookingController::class, 'store'])->name('bookings.store');
    Route::get('/bookings/{id}', [App\Http\Controllers\Admin\BookingController::class, 'show'])->name('bookings.show');
    Route::post('/bookings/{id}/verify-payment', [App\Http\Controllers\Admin\BookingController::class, 'verifyPayment'])->name('bookings.verify-payment');
    Route::get('/quotations', function() { return view('admin.quotations.index'); })->name('quotations.index');
    Route::get('/customers', function() { return view('admin.customers.index'); })->name('customers.index');
    
    // Inventory & Logistics
    Route::get('/hotels', function() { return view('admin.hotels.index'); })->name('hotels.index');
    Route::get('/fleet', function() { return view('admin.fleet.index'); })->name('fleet.index');
    
    // Finance & Analytics
    Route::get('/finance', function() { return view('admin.finance.index'); })->name('finance.index');
    Route::get('/statistics', function() { return view('admin.statistics.index'); })->name('statistics.index');
    
    // System & Content
    Route::get('/marketing', function() { return view('admin.marketing.index'); })->name('marketing.index');
    Route::get('/website', function() { return view('admin.website.index'); })->name('website.index');
    Route::get('/support', function() { return view('admin.support.index'); })->name('support.index');
    Route::get('/settings', function() { return view('admin.settings.index'); })->name('settings.index');
    
    // SMS Gateway Settings
    Route::prefix('settings/sms-gateway')->name('settings.sms-gateway.')->group(function() {
        Route::get('/', [App\Http\Controllers\Admin\SMSGatewayController::class, 'index'])->name('index');
        Route::post('/', [App\Http\Controllers\Admin\SMSGatewayController::class, 'store'])->name('store');
        Route::put('/{id}', [App\Http\Controllers\Admin\SMSGatewayController::class, 'update'])->name('update');
        Route::delete('/{id}', [App\Http\Controllers\Admin\SMSGatewayController::class, 'destroy'])->name('destroy');
        Route::post('/{id}/test-connection', [App\Http\Controllers\Admin\SMSGatewayController::class, 'testConnection'])->name('testConnection');
        Route::post('/{id}/toggle-active', [App\Http\Controllers\Admin\SMSGatewayController::class, 'toggleActive'])->name('toggleActive');
        Route::post('/{id}/set-primary', [App\Http\Controllers\Admin\SMSGatewayController::class, 'setPrimary'])->name('setPrimary');
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
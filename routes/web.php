<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\OtpLoginController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\TourController;
use App\Http\Controllers\Public\TourController as PublicTourController;
use App\Http\Controllers\Public\BookingController as PublicBookingController;
use App\Http\Controllers\Admin\ItineraryBuilderController;
use App\Http\Controllers\Admin\ExpenseController;
use App\Http\Controllers\Admin\SystemSettingsController;
use App\Http\Controllers\Admin\UserManagementController;
use App\Http\Controllers\Admin\RolePermissionController;
use App\Http\Controllers\Admin\ActivityLogController;
use App\Http\Controllers\Admin\SystemHealthController;
use App\Http\Controllers\Admin\EmailGatewayController;
use App\Http\Controllers\Admin\AccountSettingsController;
use App\Http\Controllers\Client\DashboardController as ClientDashboardController;

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

Route::get('/login/otp', [OtpLoginController::class, 'show'])->name('login.otp');
Route::get('/login/otp/verify-link', [OtpLoginController::class, 'verifyLink'])->name('login.otp.verify_link');
Route::post('/login/otp', [OtpLoginController::class, 'verify'])->name('login.otp.verify');
Route::post('/login/otp/resend', [OtpLoginController::class, 'resend'])->name('login.otp.resend');
Route::get('/login/otp/splash', [OtpLoginController::class, 'splash'])->name('login.otp.splash');

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
Route::get('/bookings/{id}/invoice/preview', [PublicBookingController::class, 'previewInvoice'])->name('bookings.invoice.preview');

Route::prefix('client')->name('client.')->middleware(['auth'])->group(function () {
    Route::get('/dashboard', [ClientDashboardController::class, 'index'])->name('dashboard');
});

Route::prefix('admin')->name('admin.')->middleware(['auth', 'ensure.admin', 'activity.log'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/placeholder', function (Request $request) {
        return view('admin.page', ['title' => (string) $request->query('title', 'Page')]);
    })->name('placeholder');

    Route::post('/nav-role-view', function (Request $request) {
        $user = $request->user();

        if (!$user || !method_exists($user, 'hasAnyRole') || !$user->hasAnyRole(['System Administrator'])) {
            abort(403);
        }

        $role = (string) $request->input('role');

        $allowed = [
            'super-admin',
            'admin-manager',
            'accountant',
            'marketing',
            'sales',
            'operations',
            'driver-guide',
            'external-agent',
            'client-portal',
            'branch-manager',
            'it-support',
        ];

        if (!in_array($role, $allowed, true)) {
            abort(422);
        }

        $request->session()->put('nav_role_view', $role);

        return back();
    })->name('nav-role-view.set');

    Route::post('/nav-role-view/clear', function (Request $request) {
        $user = $request->user();

        if (!$user || !method_exists($user, 'hasAnyRole') || !$user->hasAnyRole(['System Administrator'])) {
            abort(403);
        }

        $request->session()->forget('nav_role_view');

        return back();
    })->name('nav-role-view.clear');

    Route::resource('tours', TourController::class)->whereNumber('tour');

    // Tours & Packages Subpages
    Route::get('/tours/itinerary-builder', [ItineraryBuilderController::class, 'index'])->name('tours.itinerary-builder');
    Route::get('/tours/itinerary-builder/{tour}', [ItineraryBuilderController::class, 'show'])->whereNumber('tour')->name('tours.itinerary-builder.show');
    Route::post('/tours/itinerary-builder/{tour}', [ItineraryBuilderController::class, 'save'])->whereNumber('tour')->name('tours.itinerary-builder.save');
    Route::get('/tours/availability-pricing', function () { return view('admin.tours.availability-pricing'); })->name('tours.availability-pricing');
    Route::get('/tours/destinations', function () { return view('admin.tours.destinations'); })->name('tours.destinations');

    // Operations
    Route::prefix('operations')->name('operations.')->group(function () {
        Route::get('/dashboard', [App\Http\Controllers\Admin\OperationsController::class, 'dashboard'])->name('dashboard');

        // Tour Planning
        Route::get('/calendar', [App\Http\Controllers\Admin\OperationsController::class, 'calendar'])->name('calendar');
        Route::get('/upcoming', [App\Http\Controllers\Admin\OperationsController::class, 'upcoming'])->name('upcoming');
        Route::get('/active-trips', [App\Http\Controllers\Admin\OperationsController::class, 'activeTrips'])->name('active-trips');

        // Assignments
        Route::get('/assign/guides', [App\Http\Controllers\Admin\OperationsController::class, 'assignGuides'])->name('assign.guides');
        Route::get('/assign/drivers', [App\Http\Controllers\Admin\OperationsController::class, 'assignDrivers'])->name('assign.drivers');

        // Logistics
        Route::view('/logistics/accommodation', 'admin.operations.page', [
            'title' => 'Accommodation Bookings',
            'subtitle' => 'Manage hotel/lodge bookings per itinerary',
        ])->name('logistics.accommodation');
        Route::view('/logistics/park-fees', 'admin.operations.page', [
            'title' => 'Park Fees',
            'subtitle' => 'Track park fees and permits by trip',
        ])->name('logistics.park-fees');
        Route::view('/logistics/flights', 'admin.operations.page', [
            'title' => 'Flight Details',
            'subtitle' => 'Capture flight details for arrivals/departures',
        ])->name('logistics.flights');

        // Suppliers
        Route::view('/suppliers/operators', 'admin.operations.page', [
            'title' => 'Operator List',
            'subtitle' => 'Registered tour operators and service providers',
        ])->name('suppliers.operators');
        Route::view('/suppliers/contracts', 'admin.operations.page', [
            'title' => 'Contracts',
            'subtitle' => 'Supplier agreements and contract renewals',
        ])->name('suppliers.contracts');

        // Monitoring
        Route::view('/monitoring/status', 'admin.operations.page', [
            'title' => 'Trip Status',
            'subtitle' => 'Track trip progress and checkpoints',
        ])->name('monitoring.status');
        Route::view('/monitoring/incidents', 'admin.operations.page', [
            'title' => 'Incident Reports',
            'subtitle' => 'Log and manage operational incidents',
        ])->name('monitoring.incidents');
        Route::view('/monitoring/feedback', 'admin.operations.page', [
            'title' => 'Customer Feedback',
            'subtitle' => 'Post-tour feedback and satisfaction follow-ups',
        ])->name('monitoring.feedback');

        // Reports
        Route::view('/reports/completion', 'admin.operations.page', [
            'title' => 'Tour Completion Report',
            'subtitle' => 'Completion summary per tour and booking',
        ])->name('reports.completion');
        Route::view('/reports/performance', 'admin.operations.page', [
            'title' => 'Operations Performance',
            'subtitle' => 'KPIs for operations execution, incidents, and readiness',
        ])->name('reports.performance');
    });
    
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
    Route::get('/bookings/{id}/receipt/preview', [App\Http\Controllers\Admin\BookingController::class, 'previewReceipt'])->name('bookings.receipt.preview');
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

    Route::get('/quotations/export-pdf/preview', function () {
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

        return $pdf->stream('Quotations_' . now()->format('Ymd_His') . '.pdf');
    })->name('quotations.export-pdf.preview');
    Route::get('/customers', function() { return view('admin.customers.index'); })->name('customers.index');
    
    // Inventory & Logistics
    Route::get('/hotels', function() { return view('admin.hotels.index'); })->name('hotels.index');
    Route::get('/fleet', function() { return view('admin.fleet.index'); })->name('fleet.index');
    
    // Finance & Analytics
    Route::get('/finance', function() { return view('admin.finance.index'); })->name('finance.index');
    Route::view('/finance/overview', 'admin.finance.page', ['title' => 'Finance Overview'])->name('finance.overview');
    Route::view('/finance/cash-position', 'admin.finance.page', ['title' => 'Cash Position'])->name('finance.cash-position');
    Route::view('/finance/monthly-summary', 'admin.finance.page', ['title' => 'Monthly Summary'])->name('finance.monthly-summary');

    Route::prefix('finance/revenue')->name('finance.revenue.')->group(function () {
        Route::view('/all-bookings', 'admin.finance.page', ['title' => 'All Bookings Revenue'])->name('all-bookings');
        Route::get('/payments-received', function() { return view('admin.finance.payments-received'); })->name('payments-received');
        Route::view('/deposits', 'admin.finance.page', ['title' => 'Deposits'])->name('deposits');
        Route::view('/outstanding-balances', 'admin.finance.page', ['title' => 'Outstanding Balances'])->name('outstanding-balances');
        Route::view('/multi-currency-tracker', 'admin.finance.page', ['title' => 'Multi-Currency Tracker'])->name('multi-currency-tracker');
    });

    Route::prefix('finance/invoices')->name('finance.invoices.')->group(function () {
        Route::get('/all', function() { return view('admin.finance.generated-invoices'); })->name('all');
        Route::view('/create', 'admin.finance.page', ['title' => 'Create Invoice'])->name('create');
        Route::view('/draft', 'admin.finance.page', ['title' => 'Draft Invoices'])->name('draft');
        Route::view('/overdue', 'admin.finance.page', ['title' => 'Overdue Invoices'])->name('overdue');
        Route::view('/credit-notes', 'admin.finance.page', ['title' => 'Credit Notes'])->name('credit-notes');
    });

    Route::prefix('finance/ar')->name('finance.ar.')->group(function () {
        Route::view('/customer-balances', 'admin.finance.page', ['title' => 'Customer Balances'])->name('customer-balances');
        Route::view('/aging-report', 'admin.finance.page', ['title' => 'Aging Report'])->name('aging-report');
        Route::view('/payment-reminders', 'admin.finance.page', ['title' => 'Payment Reminders'])->name('payment-reminders');
        Route::view('/installment-plans', 'admin.finance.page', ['title' => 'Installment Plans'])->name('installment-plans');
    });

    Route::prefix('finance/ap')->name('finance.ap.')->group(function () {
        Route::view('/supplier-bills', 'admin.finance.page', ['title' => 'Supplier Bills'])->name('supplier-bills');
        Route::view('/pending-payments', 'admin.finance.page', ['title' => 'Pending Payments'])->name('pending-payments');
        Route::view('/operator-payments', 'admin.finance.page', ['title' => 'Operator Payments'])->name('operator-payments');
        Route::view('/guide-payments', 'admin.finance.page', ['title' => 'Guide Payments'])->name('guide-payments');
        Route::view('/due-schedule', 'admin.finance.page', ['title' => 'Due Schedule'])->name('due-schedule');
    });

    Route::prefix('finance/transactions')->name('finance.transactions.')->group(function () {
        Route::view('/all', 'admin.finance.page', ['title' => 'All Transactions'])->name('all');
        Route::view('/bank-transfers', 'admin.finance.page', ['title' => 'Bank Transfers'])->name('bank-transfers');
        Route::view('/cash', 'admin.finance.page', ['title' => 'Cash Transactions'])->name('cash');
        Route::view('/mobile-money', 'admin.finance.page', ['title' => 'Mobile Money (M-Pesa, Airtel)'])->name('mobile-money');
        Route::view('/stripe-card', 'admin.finance.page', ['title' => 'Stripe / Card Payments'])->name('stripe-card');
    });

    Route::prefix('finance/expenses')->name('finance.expenses.')->group(function () {
        Route::get('/', [ExpenseController::class, 'index'])->name('index');
        Route::get('/create', [ExpenseController::class, 'create'])->name('create');
        Route::post('/', [ExpenseController::class, 'store'])->name('store');
        Route::get('/{expense}/edit', [ExpenseController::class, 'edit'])->whereNumber('expense')->name('edit');
        Route::put('/{expense}', [ExpenseController::class, 'update'])->whereNumber('expense')->name('update');
        Route::delete('/{expense}', [ExpenseController::class, 'destroy'])->whereNumber('expense')->name('destroy');
        Route::get('/tracking', function() { return view('admin.finance.expense-tracking'); })->name('tracking');
        Route::view('/categories', 'admin.finance.page', ['title' => 'Expense Categories'])->name('categories');
        Route::view('/vendors', 'admin.finance.page', ['title' => 'Vendor Management'])->name('vendors');
        Route::view('/recurring', 'admin.finance.page', ['title' => 'Recurring Expenses'])->name('recurring');
    });

    Route::prefix('finance/commissions')->name('finance.commissions.')->group(function () {
        Route::view('/overview', 'admin.finance.page', ['title' => 'Commission Overview'])->name('overview');
        Route::view('/per-booking', 'admin.finance.page', ['title' => 'Per Booking Commission'])->name('per-booking');
        Route::view('/operator', 'admin.finance.page', ['title' => 'Operator Commission'])->name('operator');
        Route::view('/agent', 'admin.finance.page', ['title' => 'Agent Commission'])->name('agent');
        Route::view('/reports', 'admin.finance.page', ['title' => 'Commission Reports'])->name('reports');
    });

    Route::prefix('finance/banking')->name('finance.banking.')->group(function () {
        Route::view('/bank-accounts', 'admin.finance.page', ['title' => 'Bank Accounts'])->name('bank-accounts');
        Route::view('/cash-accounts', 'admin.finance.page', ['title' => 'Cash Accounts'])->name('cash-accounts');
        Route::view('/transfers', 'admin.finance.page', ['title' => 'Transfers Between Accounts'])->name('transfers');
        Route::view('/reconciliation', 'admin.finance.page', ['title' => 'Reconciliation'])->name('reconciliation');
    });

    Route::prefix('finance/reports')->name('finance.reports.')->group(function () {
        Route::view('/profit-loss', 'admin.finance.page', ['title' => 'Profit & Loss'])->name('profit-loss');
        Route::view('/balance-sheet', 'admin.finance.page', ['title' => 'Balance Sheet'])->name('balance-sheet');
        Route::view('/cash-flow', 'admin.finance.page', ['title' => 'Cash Flow'])->name('cash-flow');
        Route::get('/revenue-report', function() { return view('admin.finance.revenue-reports'); })->name('revenue-report');
        Route::view('/expense-report', 'admin.finance.page', ['title' => 'Expense Report'])->name('expense-report');
        Route::view('/commission-report', 'admin.finance.page', ['title' => 'Commission Report'])->name('commission-report');
        Route::view('/tax-report', 'admin.finance.page', ['title' => 'Tax Report'])->name('tax-report');
        Route::view('/custom-builder', 'admin.finance.page', ['title' => 'Custom Report Builder'])->name('custom-builder');
    });

    Route::prefix('finance/tax')->name('finance.tax.')->group(function () {
        Route::view('/vat-settings', 'admin.finance.page', ['title' => 'VAT Settings'])->name('vat-settings');
        Route::view('/tax-summary', 'admin.finance.page', ['title' => 'Tax Summary'])->name('tax-summary');
        Route::view('/tax-payments', 'admin.finance.page', ['title' => 'Tax Payments'])->name('tax-payments');
        Route::view('/withholding-tax', 'admin.finance.page', ['title' => 'Withholding Tax'])->name('withholding-tax');
    });

    Route::prefix('finance/settings')->name('finance.settings.')->group(function () {
        Route::view('/chart-of-accounts', 'admin.finance.page', ['title' => 'Chart of Accounts'])->name('chart-of-accounts');
        Route::view('/currencies', 'admin.finance.page', ['title' => 'Currencies'])->name('currencies');
        Route::view('/exchange-rates', 'admin.finance.page', ['title' => 'Exchange Rates'])->name('exchange-rates');
        Route::view('/payment-methods', 'admin.finance.page', ['title' => 'Payment Methods'])->name('payment-methods');
        Route::view('/financial-year', 'admin.finance.page', ['title' => 'Financial Year Settings'])->name('financial-year');
        Route::view('/approval-rules', 'admin.finance.page', ['title' => 'Approval Rules'])->name('approval-rules');
    });
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
        Route::put('/{id}', [App\Http\Controllers\Admin\SMSGatewayController::class, 'update'])->whereNumber('id')->name('update');
        Route::delete('/{id}', [App\Http\Controllers\Admin\SMSGatewayController::class, 'destroy'])->whereNumber('id')->name('destroy');
        Route::post('/{id}/test-connection', [App\Http\Controllers\Admin\SMSGatewayController::class, 'testConnection'])->whereNumber('id')->name('testConnection');
        Route::post('/{id}/toggle-active', [App\Http\Controllers\Admin\SMSGatewayController::class, 'toggleActive'])->whereNumber('id')->name('toggleActive');
        Route::post('/{id}/set-primary', [App\Http\Controllers\Admin\SMSGatewayController::class, 'setPrimary'])->whereNumber('id')->name('setPrimary');
        Route::post('/draft/test-connection', [App\Http\Controllers\Admin\SMSGatewayController::class, 'testDraftConnection'])->name('draft.testConnection');
        Route::post('/draft/test-sms', [App\Http\Controllers\Admin\SMSGatewayController::class, 'testDraftSms'])->name('draft.testSms');
        Route::post('/test', [App\Http\Controllers\Admin\SMSGatewayController::class, 'test'])->name('test');
    });

    // Email Gateway Settings
    Route::prefix('settings/email-gateway')->name('settings.email-gateway.')->group(function() {
        Route::get('/', [EmailGatewayController::class, 'edit'])->name('edit');
        Route::post('/', [EmailGatewayController::class, 'update'])->name('update');
        Route::post('/activate/{gateway}', [EmailGatewayController::class, 'activate'])->whereNumber('gateway')->name('activate');
        Route::post('/test', [EmailGatewayController::class, 'test'])->name('test');
    });

    // Account Management
    Route::get('/profile', function() { return view('admin.profile'); })->name('profile');
    Route::get('/settings/account', [AccountSettingsController::class, 'edit'])->name('account-settings');
    Route::post('/settings/account', [AccountSettingsController::class, 'update'])->name('account-settings.update');
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
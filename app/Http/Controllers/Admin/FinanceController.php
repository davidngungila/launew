<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\FinancialTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Barryvdh\DomPDF\Facade\Pdf;

class FinanceController extends Controller
{
    private function estimateDepositPercent(): float
    {
        $depositPercent = 30;

        try {
            if (class_exists(\App\Models\SystemSetting::class)) {
                $rules = \App\Models\SystemSetting::getValue('booking_rules', []);
                if (!empty($rules['deposit_percent'])) {
                    $depositPercent = (float) $rules['deposit_percent'];
                }
            }
        } catch (\Throwable $e) {
        }

        return $depositPercent;
    }

    public function dashboard(Request $request)
    {
        $today = now();
        $monthStart = $today->copy()->startOfMonth();
        $monthEnd = $today->copy()->endOfMonth();

        $paidBookings = Booking::query()
            ->whereIn('payment_status', ['paid', 'partially_paid'])
            ->whereBetween('created_at', [$monthStart, $monthEnd]);

        $revenueMtd = (float) (clone $paidBookings)->sum('total_price');

        $expenseMtd = (float) FinancialTransaction::query()
            ->where('type', 'expense')
            ->whereBetween('transaction_date', [$monthStart->toDateString(), $monthEnd->toDateString()])
            ->sum('amount');

        $incomeMtd = (float) FinancialTransaction::query()
            ->where('type', 'income')
            ->whereBetween('transaction_date', [$monthStart->toDateString(), $monthEnd->toDateString()])
            ->sum('amount');

        if ($incomeMtd <= 0) {
            $incomeMtd = $revenueMtd;
        }

        $netCashflowMtd = $incomeMtd - $expenseMtd;

        $depositPercent = $this->estimateDepositPercent();

        $pendingBookings = Booking::query()->whereIn('payment_status', ['unpaid', 'partially_paid']);

        $estimatedDepositDue = (float) $pendingBookings->get()->sum(function ($b) use ($depositPercent) {
            $total = (float) ($b->total_price ?? 0);
            $deposit = (float) ($b->deposit_amount ?? (($depositPercent / 100) * $total));
            return max(0, $deposit);
        });

        $estimatedOutstanding = (float) Booking::query()->get()->sum(function ($b) use ($depositPercent) {
            $total = (float) ($b->total_price ?? 0);
            if (($b->payment_status ?? 'unpaid') === 'paid') {
                return 0;
            }

            $deposit = (float) ($b->deposit_amount ?? (($depositPercent / 100) * $total));
            if (($b->payment_status ?? 'unpaid') === 'partially_paid') {
                return max(0, $total - $deposit);
            }

            return max(0, $total);
        });

        $recentTransactions = FinancialTransaction::query()
            ->with('booking')
            ->latest('transaction_date')
            ->limit(20)
            ->get();

        $revenueByTour = Booking::query()
            ->with('tour')
            ->whereIn('payment_status', ['paid', 'partially_paid'])
            ->whereBetween('created_at', [$monthStart, $monthEnd])
            ->get()
            ->groupBy('tour_id')
            ->map(function ($items) {
                $tour = $items->first()?->tour;
                return [
                    'name' => $tour->name ?? 'Other',
                    'amount' => (float) $items->sum('total_price'),
                ];
            })
            ->values()
            ->sortByDesc('amount')
            ->values();

        $stats = [
            'income_mtd' => $incomeMtd,
            'expense_mtd' => $expenseMtd,
            'net_cashflow_mtd' => $netCashflowMtd,
            'revenue_mtd' => $revenueMtd,
            'deposit_estimate' => $estimatedDepositDue,
            'outstanding_estimate' => $estimatedOutstanding,
            'month_start' => $monthStart,
            'month_end' => $monthEnd,
        ];

        return view('admin.finance.dashboard', compact('stats', 'recentTransactions', 'revenueByTour'));
    }

    public function dashboardExportPdf(Request $request)
    {
        $view = $this->dashboard($request);
        $data = $view->getData();

        $pdf = Pdf::loadView('pdf.finance.dashboard', $data)->setPaper('a4', 'portrait');

        return $pdf->download('finance-dashboard.pdf');
    }

    public function revenueBookingRevenue(Request $request)
    {
        $start = $request->query('start');
        $end = $request->query('end');

        $query = Booking::query()->with(['tour', 'agent']);

        if (!empty($start)) {
            $query->whereDate('created_at', '>=', $start);
        }
        if (!empty($end)) {
            $query->whereDate('created_at', '<=', $end);
        }

        $rows = (clone $query)->latest()->paginate(20)->withQueryString();

        $paid = (clone $query)->whereIn('payment_status', ['paid', 'partially_paid'])->sum('total_price');
        $total = (clone $query)->sum('total_price');

        $stats = [
            'total' => (float) $total,
            'paid' => (float) $paid,
            'unpaid' => (float) max(0, $total - $paid),
        ];

        return view('admin.finance.revenue.booking-revenue', compact('rows', 'stats', 'start', 'end'));
    }

    public function revenueDeposits(Request $request)
    {
        $start = $request->query('start');
        $end = $request->query('end');

        $depositPercent = $this->estimateDepositPercent();

        $query = Booking::query()->with(['tour']);

        if (!empty($start)) {
            $query->whereDate('created_at', '>=', $start);
        }
        if (!empty($end)) {
            $query->whereDate('created_at', '<=', $end);
        }

        $rows = (clone $query)->latest()->paginate(20)->withQueryString();

        $expected = (float) (clone $query)->get()->sum(function ($b) use ($depositPercent) {
            $total = (float) ($b->total_price ?? 0);
            return (float) ($b->deposit_amount ?? (($depositPercent / 100) * $total));
        });

        $stats = [
            'expected' => $expected,
            'deposit_percent' => $depositPercent,
        ];

        return view('admin.finance.revenue.deposits', compact('rows', 'stats', 'start', 'end'));
    }

    public function revenueOutstanding(Request $request)
    {
        $start = $request->query('start');
        $end = $request->query('end');

        $depositPercent = $this->estimateDepositPercent();

        $query = Booking::query()->with(['tour'])
            ->whereIn('payment_status', ['unpaid', 'partially_paid']);

        if (!empty($start)) {
            $query->whereDate('created_at', '>=', $start);
        }
        if (!empty($end)) {
            $query->whereDate('created_at', '<=', $end);
        }

        $rows = (clone $query)->latest()->paginate(20)->withQueryString();

        $outstanding = (float) (clone $query)->get()->sum(function ($b) use ($depositPercent) {
            $total = (float) ($b->total_price ?? 0);
            if (($b->payment_status ?? 'unpaid') === 'partially_paid') {
                $deposit = (float) ($b->deposit_amount ?? (($depositPercent / 100) * $total));
                return max(0, $total - $deposit);
            }
            return max(0, $total);
        });

        $stats = [
            'outstanding' => $outstanding,
            'deposit_percent' => $depositPercent,
        ];

        return view('admin.finance.revenue.outstanding', compact('rows', 'stats', 'start', 'end'));
    }

    public function revenueMultiCurrency(Request $request)
    {
        $supported = [];
        $rows = collect();

        if (Schema::hasTable('transactions') && class_exists(\App\Models\Transaction::class)) {
            $rows = \App\Models\Transaction::query()
                ->selectRaw('currency, COUNT(*) as cnt, SUM(amount) as total')
                ->groupBy('currency')
                ->orderByDesc('total')
                ->get();

            $supported = $rows->pluck('currency')->filter()->values()->all();
        }

        return view('admin.finance.revenue.multi-currency', compact('rows', 'supported'));
    }

    public function invoicesAll(Request $request)
    {
        $status = $request->query('status');

        $query = Booking::query()->with('tour')->latest();

        if (!empty($status)) {
            $query->where('payment_status', $status);
        }

        $rows = $query->paginate(20)->withQueryString();

        $stats = [
            'total' => Booking::count(),
            'paid' => Booking::where('payment_status', 'paid')->count(),
            'unpaid' => Booking::where('payment_status', 'unpaid')->count(),
            'partial' => Booking::where('payment_status', 'partially_paid')->count(),
        ];

        return view('admin.finance.invoices.all', compact('rows', 'stats', 'status'));
    }

    public function invoicesExportPdf(Request $request)
    {
        $status = $request->query('status');

        $query = Booking::query()->with('tour')->latest();
        if (!empty($status)) {
            $query->where('payment_status', $status);
        }

        $rows = $query->limit(200)->get();

        $pdf = Pdf::loadView('pdf.finance.invoices', compact('rows', 'status'))->setPaper('a4', 'portrait');

        return $pdf->download('invoices.pdf');
    }

    public function invoicesCreate(Request $request)
    {
        $bookings = Booking::query()->latest()->limit(200)->get();

        return view('admin.finance.invoices.create', compact('bookings'));
    }

    public function invoicesDraft(Request $request)
    {
        $rows = Booking::query()
            ->with('tour')
            ->where('payment_status', 'unpaid')
            ->latest()
            ->paginate(20);

        $stats = [
            'draft_like' => (clone $rows)->total(),
        ];

        return view('admin.finance.invoices.draft', compact('rows', 'stats'));
    }

    public function invoicesOverdue(Request $request)
    {
        $cutoff = now()->subDays(14);

        $rows = Booking::query()
            ->with('tour')
            ->where('payment_status', 'unpaid')
            ->where('created_at', '<=', $cutoff)
            ->latest()
            ->paginate(20);

        $stats = [
            'overdue_count' => $rows->total(),
            'overdue_amount' => (float) Booking::query()
                ->where('payment_status', 'unpaid')
                ->where('created_at', '<=', $cutoff)
                ->sum('total_price'),
            'cutoff_days' => 14,
        ];

        return view('admin.finance.invoices.overdue', compact('rows', 'stats'));
    }

    public function invoicesCreditNotes(Request $request)
    {
        $rows = Booking::query()
            ->with('tour')
            ->whereIn('status', ['cancelled'])
            ->latest()
            ->paginate(20);

        $stats = [
            'cancelled' => $rows->total(),
        ];

        return view('admin.finance.invoices.credit-notes', compact('rows', 'stats'));
    }

    public function arCustomerBalances(Request $request)
    {
        $depositPercent = $this->estimateDepositPercent();

        $rows = Booking::query()
            ->select(['id', 'customer_name', 'customer_email', 'customer_phone', 'payment_status', 'total_price', 'deposit_amount', 'created_at', 'start_date'])
            ->latest()
            ->limit(1500)
            ->get();

        $customers = $rows->groupBy(function ($b) {
            return strtolower(trim((string) ($b->customer_email ?? 'unknown')));
        })->map(function ($items, $email) use ($depositPercent) {
            $name = $items->first()?->customer_name ?? 'Customer';
            $phone = $items->first()?->customer_phone;
            $booked = (float) $items->sum('total_price');

            $paidEstimate = (float) $items->sum(function ($b) use ($depositPercent) {
                $total = (float) ($b->total_price ?? 0);
                $deposit = (float) ($b->deposit_amount ?? (($depositPercent / 100) * $total));
                $status = $b->payment_status ?? 'unpaid';

                if ($status === 'paid') return $total;
                if ($status === 'partially_paid') return min($total, max(0, $deposit));
                return 0;
            });

            $outstanding = max(0, $booked - $paidEstimate);

            return [
                'email' => $email,
                'name' => $name,
                'phone' => $phone,
                'bookings' => $items->count(),
                'booked' => $booked,
                'paid_estimate' => $paidEstimate,
                'outstanding' => $outstanding,
            ];
        })->values()->sortByDesc('outstanding')->values();

        $stats = [
            'customers' => $customers->count(),
            'outstanding_total' => (float) $customers->sum('outstanding'),
            'paid_estimate_total' => (float) $customers->sum('paid_estimate'),
        ];

        return view('admin.finance.ar.customer-balances', compact('customers', 'stats'));
    }

    public function arCustomerBalancesExportPdf(Request $request)
    {
        $view = $this->arCustomerBalances($request);
        $data = $view->getData();

        $pdf = Pdf::loadView('pdf.finance.ar-customer-balances', $data)->setPaper('a4', 'portrait');

        return $pdf->download('ar-customer-balances.pdf');
    }

    public function arAgingReport(Request $request)
    {
        $depositPercent = $this->estimateDepositPercent();
        $basis = $request->query('basis', 'created_at');
        if (!in_array($basis, ['created_at', 'start_date'], true)) {
            $basis = 'created_at';
        }

        $rows = Booking::query()
            ->with('tour')
            ->whereIn('payment_status', ['unpaid', 'partially_paid'])
            ->latest()
            ->paginate(20)
            ->withQueryString();

        $all = Booking::query()
            ->whereIn('payment_status', ['unpaid', 'partially_paid'])
            ->select(['id', 'payment_status', 'total_price', 'deposit_amount', 'created_at', 'start_date'])
            ->get();

        $buckets = [
            '0_7' => 0,
            '8_14' => 0,
            '15_30' => 0,
            '31_plus' => 0,
        ];

        foreach ($all as $b) {
            $total = (float) ($b->total_price ?? 0);
            $deposit = (float) ($b->deposit_amount ?? (($depositPercent / 100) * $total));
            $outstanding = ($b->payment_status === 'partially_paid') ? max(0, $total - $deposit) : max(0, $total);

            $date = $basis === 'start_date' ? $b->start_date : $b->created_at;
            if (empty($date)) {
                continue;
            }

            $ageDays = now()->diffInDays(\Carbon\Carbon::parse($date));

            if ($ageDays <= 7) $buckets['0_7'] += $outstanding;
            elseif ($ageDays <= 14) $buckets['8_14'] += $outstanding;
            elseif ($ageDays <= 30) $buckets['15_30'] += $outstanding;
            else $buckets['31_plus'] += $outstanding;
        }

        $stats = [
            'basis' => $basis,
            'deposit_percent' => $depositPercent,
            'outstanding_total' => array_sum($buckets),
        ];

        return view('admin.finance.ar.aging-report', compact('rows', 'buckets', 'stats', 'basis'));
    }

    public function arAgingReportExportPdf(Request $request)
    {
        $view = $this->arAgingReport($request);
        $data = $view->getData();

        $pdf = Pdf::loadView('pdf.finance.ar-aging-report', $data)->setPaper('a4', 'portrait');

        return $pdf->download('ar-aging-report.pdf');
    }

    public function arPaymentReminders(Request $request)
    {
        $depositPercent = $this->estimateDepositPercent();

        $cutoffDays = (int) $request->query('cutoff_days', 7);
        if ($cutoffDays < 0) {
            $cutoffDays = 7;
        }

        $cutoff = now()->subDays($cutoffDays);

        $rows = Booking::query()
            ->with('tour')
            ->whereIn('payment_status', ['unpaid', 'partially_paid'])
            ->where('created_at', '<=', $cutoff)
            ->latest()
            ->paginate(20)
            ->withQueryString();

        $reminderTotal = (float) Booking::query()
            ->whereIn('payment_status', ['unpaid', 'partially_paid'])
            ->where('created_at', '<=', $cutoff)
            ->get()
            ->sum(function ($b) use ($depositPercent) {
                $total = (float) ($b->total_price ?? 0);
                $deposit = (float) ($b->deposit_amount ?? (($depositPercent / 100) * $total));
                if (($b->payment_status ?? 'unpaid') === 'partially_paid') {
                    return max(0, $total - $deposit);
                }
                return max(0, $total);
            });

        $stats = [
            'cutoff_days' => $cutoffDays,
            'count' => $rows->total(),
            'amount' => $reminderTotal,
        ];

        return view('admin.finance.ar.payment-reminders', compact('rows', 'stats'));
    }

    public function arPaymentRemindersExportPdf(Request $request)
    {
        $view = $this->arPaymentReminders($request);
        $data = $view->getData();

        $pdf = Pdf::loadView('pdf.finance.ar-payment-reminders', $data)->setPaper('a4', 'portrait');

        return $pdf->download('ar-payment-reminders.pdf');
    }
}

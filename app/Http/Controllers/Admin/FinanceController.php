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
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Agent;
use App\Models\Booking;
use App\Models\FinancialTransaction;
use Illuminate\Http\Request;

class FinanceAPController extends Controller
{
    public function supplierBills(Request $request)
    {
        $bills = FinancialTransaction::query()
            ->where('type', 'expense')
            ->whereIn('category', ['supplier_bill', 'supplier', 'operator', 'accommodation', 'park_fees', 'flight'])
            ->latest('transaction_date')
            ->paginate(20);

        $stats = [
            'total_bills' => FinancialTransaction::query()
                ->where('type', 'expense')
                ->whereIn('category', ['supplier_bill', 'supplier', 'operator', 'accommodation', 'park_fees', 'flight'])
                ->count(),
            'month_amount' => FinancialTransaction::query()
                ->where('type', 'expense')
                ->whereIn('category', ['supplier_bill', 'supplier', 'operator', 'accommodation', 'park_fees', 'flight'])
                ->whereMonth('transaction_date', now()->month)
                ->sum('amount'),
        ];

        return view('admin.finance.ap.supplier-bills', compact('bills', 'stats'));
    }

    public function pendingPayments(Request $request)
    {
        $pendingBills = FinancialTransaction::query()
            ->where('type', 'expense')
            ->whereIn('category', ['supplier_bill', 'supplier', 'operator', 'accommodation', 'park_fees', 'flight'])
            ->latest('transaction_date')
            ->paginate(20);

        $stats = [
            'pending_count' => FinancialTransaction::query()
                ->where('type', 'expense')
                ->whereIn('category', ['supplier_bill', 'supplier', 'operator', 'accommodation', 'park_fees', 'flight'])
                ->count(),
            'pending_amount' => FinancialTransaction::query()
                ->where('type', 'expense')
                ->whereIn('category', ['supplier_bill', 'supplier', 'operator', 'accommodation', 'park_fees', 'flight'])
                ->sum('amount'),
        ];

        return view('admin.finance.ap.pending-payments', compact('pendingBills', 'stats'));
    }

    public function operatorPayments(Request $request)
    {
        $start = $request->query('start');
        $end = $request->query('end');

        $bookingsQuery = Booking::query()->with(['tour', 'agent'])->whereNotNull('agent_id');

        if (!empty($start)) {
            $bookingsQuery->whereDate('start_date', '>=', $start);
        }

        if (!empty($end)) {
            $bookingsQuery->whereDate('start_date', '<=', $end);
        }

        $bookings = $bookingsQuery->latest('start_date')->limit(250)->get();

        $agents = Agent::query()->with('user')->orderBy('company_name')->get()->keyBy('id');

        $rows = $bookings->groupBy('agent_id')->map(function ($items, $agentId) use ($agents) {
            $agent = $agents->get($agentId);
            $rate = (float) ($agent->commission_rate ?? 0);
            $gross = (float) $items->sum('total_price');
            $commission = round($gross * ($rate / 100), 2);

            return [
                'agent' => $agent,
                'rate' => $rate,
                'gross' => $gross,
                'commission' => $commission,
                'count' => $items->count(),
            ];
        })->values()->sortByDesc('commission')->values();

        $stats = [
            'operators' => $rows->count(),
            'gross' => (float) $rows->sum('gross'),
            'commission' => (float) $rows->sum('commission'),
        ];

        return view('admin.finance.ap.operator-payments', compact('rows', 'stats', 'start', 'end'));
    }
}

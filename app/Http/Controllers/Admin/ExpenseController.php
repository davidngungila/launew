<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ExpenseCategory;
use App\Models\FinancialTransaction;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class ExpenseController extends Controller
{
    public function index()
    {
        $expenses = FinancialTransaction::query()
            ->where('type', 'expense')
            ->latest('transaction_date')
            ->paginate(20);

        return view('admin.finance.expenses.index', compact('expenses'));
    }

    public function create()
    {
        $categories = ExpenseCategory::query()
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get();

        return view('admin.finance.expenses.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'amount' => 'required|numeric|min:0',
            'category' => 'required|string|max:100',
            'description' => 'required|string|max:255',
            'transaction_date' => 'required|date',
        ]);

        $expense = FinancialTransaction::create([
            'booking_id' => null,
            'type' => 'expense',
            'amount' => $validated['amount'],
            'category' => $validated['category'],
            'description' => $validated['description'],
            'transaction_date' => $validated['transaction_date'],
        ]);

        return redirect()->route('admin.finance.expenses.edit', $expense)->with('success', 'Expense created successfully.');
    }

    public function edit(FinancialTransaction $expense)
    {
        abort_unless($expense->type === 'expense', 404);

        $categories = ExpenseCategory::query()
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get();

        return view('admin.finance.expenses.edit', compact('expense', 'categories'));
    }

    public function update(Request $request, FinancialTransaction $expense)
    {
        abort_unless($expense->type === 'expense', 404);

        $validated = $request->validate([
            'amount' => 'required|numeric|min:0',
            'category' => 'required|string|max:100',
            'description' => 'required|string|max:255',
            'transaction_date' => 'required|date',
        ]);

        $expense->update($validated);

        return redirect()->route('admin.finance.expenses.index')->with('success', 'Expense updated successfully.');
    }

    public function destroy(FinancialTransaction $expense)
    {
        abort_unless($expense->type === 'expense', 404);

        $expense->delete();

        return redirect()->route('admin.finance.expenses.index')->with('success', 'Expense deleted successfully.');
    }

    public function tracking(Request $request)
    {
        $fuel = (float) FinancialTransaction::where('type', 'expense')->where('category', 'fuel')->sum('amount');
        $accommodation = (float) FinancialTransaction::where('type', 'expense')->where('category', 'accommodation')->sum('amount');
        $parkFees = (float) FinancialTransaction::where('type', 'expense')->whereIn('category', ['park_fees', 'parkfees', 'park-fees'])->sum('amount');
        $totalExpenses = (float) FinancialTransaction::where('type', 'expense')->sum('amount');

        $recent = FinancialTransaction::query()
            ->where('type', 'expense')
            ->latest('transaction_date')
            ->limit(15)
            ->get();

        $stats = compact('fuel', 'accommodation', 'parkFees', 'totalExpenses');

        return view('admin.finance.expense-tracking', compact('stats', 'recent'));
    }

    public function trackingExportPdf(Request $request)
    {
        $fuel = (float) FinancialTransaction::where('type', 'expense')->where('category', 'fuel')->sum('amount');
        $accommodation = (float) FinancialTransaction::where('type', 'expense')->where('category', 'accommodation')->sum('amount');
        $parkFees = (float) FinancialTransaction::where('type', 'expense')->whereIn('category', ['park_fees', 'parkfees', 'park-fees'])->sum('amount');
        $totalExpenses = (float) FinancialTransaction::where('type', 'expense')->sum('amount');

        $recent = FinancialTransaction::query()
            ->where('type', 'expense')
            ->latest('transaction_date')
            ->limit(200)
            ->get();

        $stats = compact('fuel', 'accommodation', 'parkFees', 'totalExpenses');

        $pdf = Pdf::loadView('pdf.finance.expense-tracking', compact('stats', 'recent'))->setPaper('a4', 'portrait');

        return $pdf->download('expense-tracking.pdf');
    }
}

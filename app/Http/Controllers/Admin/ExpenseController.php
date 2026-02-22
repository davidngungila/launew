<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FinancialTransaction;
use Illuminate\Http\Request;

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
        return view('admin.finance.expenses.create');
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
        return view('admin.finance.expenses.edit', compact('expense'));
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
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ExpenseCategory;
use App\Models\RecurringExpense;
use Illuminate\Http\Request;

class RecurringExpenseController extends Controller
{
    public function index()
    {
        $recurring = RecurringExpense::query()
            ->latest()
            ->paginate(20);

        return view('admin.finance.expenses.recurring.index', compact('recurring'));
    }

    public function create()
    {
        $categories = ExpenseCategory::query()->where('is_active', true)->orderBy('sort_order')->orderBy('name')->get();

        return view('admin.finance.expenses.recurring.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
            'category' => 'required|string|max:100',
            'frequency' => 'required|in:daily,weekly,monthly',
            'starts_on' => 'nullable|date',
            'next_run_on' => 'nullable|date',
            'is_active' => 'nullable|boolean',
        ]);

        $validated['is_active'] = (bool) ($validated['is_active'] ?? true);

        $row = RecurringExpense::create($validated);

        return redirect()->route('admin.finance.expenses.recurring.edit', $row)->with('success', 'Recurring expense created successfully.');
    }

    public function edit(RecurringExpense $recurring)
    {
        $categories = ExpenseCategory::query()->where('is_active', true)->orderBy('sort_order')->orderBy('name')->get();

        return view('admin.finance.expenses.recurring.edit', compact('recurring', 'categories'));
    }

    public function update(Request $request, RecurringExpense $recurring)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
            'category' => 'required|string|max:100',
            'frequency' => 'required|in:daily,weekly,monthly',
            'starts_on' => 'nullable|date',
            'next_run_on' => 'nullable|date',
            'is_active' => 'nullable|boolean',
        ]);

        $validated['is_active'] = (bool) ($validated['is_active'] ?? false);

        $recurring->update($validated);

        return redirect()->route('admin.finance.expenses.recurring.index')->with('success', 'Recurring expense updated successfully.');
    }

    public function destroy(RecurringExpense $recurring)
    {
        $recurring->delete();

        return redirect()->route('admin.finance.expenses.recurring.index')->with('success', 'Recurring expense deleted successfully.');
    }
}

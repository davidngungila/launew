<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ExpenseCategory;
use Illuminate\Http\Request;

class ExpenseCategoryController extends Controller
{
    public function index()
    {
        $categories = ExpenseCategory::query()
            ->orderBy('sort_order')
            ->orderBy('name')
            ->paginate(20);

        return view('admin.finance.expenses.categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.finance.expenses.categories.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'key' => 'required|string|max:100|unique:expense_categories,key',
            'name' => 'required|string|max:255',
            'sort_order' => 'nullable|integer|min:0',
            'is_active' => 'nullable|boolean',
        ]);

        $validated['is_active'] = (bool) ($validated['is_active'] ?? true);
        $validated['sort_order'] = (int) ($validated['sort_order'] ?? 0);

        $row = ExpenseCategory::create($validated);

        return redirect()->route('admin.finance.expenses.categories.edit', $row)->with('success', 'Category created successfully.');
    }

    public function edit(ExpenseCategory $category)
    {
        return view('admin.finance.expenses.categories.edit', compact('category'));
    }

    public function update(Request $request, ExpenseCategory $category)
    {
        $validated = $request->validate([
            'key' => 'required|string|max:100|unique:expense_categories,key,' . $category->id,
            'name' => 'required|string|max:255',
            'sort_order' => 'nullable|integer|min:0',
            'is_active' => 'nullable|boolean',
        ]);

        $validated['is_active'] = (bool) ($validated['is_active'] ?? false);
        $validated['sort_order'] = (int) ($validated['sort_order'] ?? 0);

        $category->update($validated);

        return redirect()->route('admin.finance.expenses.categories.index')->with('success', 'Category updated successfully.');
    }

    public function destroy(ExpenseCategory $category)
    {
        $category->delete();

        return redirect()->route('admin.finance.expenses.categories.index')->with('success', 'Category deleted successfully.');
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FinanceAccount;
use App\Models\FinanceReconciliation;
use App\Models\FinanceTransfer;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class FinanceBankingController extends Controller
{
    private function calcAccountBalance(FinanceAccount $account): float
    {
        $incoming = (float) FinanceTransfer::query()->where('to_account_id', $account->id)->sum('amount');
        $outgoing = (float) FinanceTransfer::query()->where('from_account_id', $account->id)->sum('amount');

        return (float) $account->opening_balance + $incoming - $outgoing;
    }

    public function bankAccounts()
    {
        $accounts = FinanceAccount::query()
            ->where('type', 'bank')
            ->orderByDesc('is_active')
            ->orderBy('name')
            ->get();

        $accountsWithBalances = $accounts->map(function (FinanceAccount $a) {
            $a->calculated_balance = $this->calcAccountBalance($a);
            return $a;
        });

        $stats = [
            'count' => $accountsWithBalances->count(),
            'balance_total' => (float) $accountsWithBalances->sum('calculated_balance'),
        ];

        return view('admin.finance.banking.bank-accounts', [
            'accounts' => $accountsWithBalances,
            'stats' => $stats,
        ]);
    }

    public function cashAccounts()
    {
        $accounts = FinanceAccount::query()
            ->where('type', 'cash')
            ->orderByDesc('is_active')
            ->orderBy('name')
            ->get();

        $accountsWithBalances = $accounts->map(function (FinanceAccount $a) {
            $a->calculated_balance = $this->calcAccountBalance($a);
            return $a;
        });

        $stats = [
            'count' => $accountsWithBalances->count(),
            'balance_total' => (float) $accountsWithBalances->sum('calculated_balance'),
        ];

        return view('admin.finance.banking.cash-accounts', [
            'accounts' => $accountsWithBalances,
            'stats' => $stats,
        ]);
    }

    public function accountsCreate(Request $request)
    {
        $type = $request->query('type', 'bank');
        if (!in_array($type, ['bank', 'cash'], true)) {
            $type = 'bank';
        }

        return view('admin.finance.banking.accounts.create', compact('type'));
    }

    public function accountsStore(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:bank,cash',
            'currency' => 'required|string|max:10',
            'institution' => 'nullable|string|max:255',
            'account_number' => 'nullable|string|max:255',
            'opening_balance' => 'nullable|numeric',
            'is_active' => 'nullable|boolean',
        ]);

        $validated['opening_balance'] = (float) ($validated['opening_balance'] ?? 0);
        $validated['current_balance'] = (float) $validated['opening_balance'];
        $validated['is_active'] = (bool) ($validated['is_active'] ?? true);

        $row = FinanceAccount::create($validated);

        return redirect()->route($row->type === 'cash' ? 'admin.finance.banking.cash-accounts' : 'admin.finance.banking.bank-accounts')
            ->with('success', 'Account created successfully.');
    }

    public function accountsEdit(FinanceAccount $account)
    {
        return view('admin.finance.banking.accounts.edit', compact('account'));
    }

    public function accountsUpdate(Request $request, FinanceAccount $account)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'currency' => 'required|string|max:10',
            'institution' => 'nullable|string|max:255',
            'account_number' => 'nullable|string|max:255',
            'opening_balance' => 'nullable|numeric',
            'is_active' => 'nullable|boolean',
        ]);

        $validated['opening_balance'] = (float) ($validated['opening_balance'] ?? 0);
        $validated['is_active'] = (bool) ($validated['is_active'] ?? false);

        $account->update($validated);

        return redirect()->route($account->type === 'cash' ? 'admin.finance.banking.cash-accounts' : 'admin.finance.banking.bank-accounts')
            ->with('success', 'Account updated successfully.');
    }

    public function accountsDestroy(FinanceAccount $account)
    {
        $account->delete();

        return back()->with('success', 'Account deleted successfully.');
    }

    public function transfers()
    {
        $transfers = FinanceTransfer::query()
            ->with(['fromAccount', 'toAccount'])
            ->latest('transfer_date')
            ->paginate(20);

        $stats = [
            'count' => $transfers->total(),
            'total' => (float) FinanceTransfer::query()->sum('amount'),
        ];

        return view('admin.finance.banking.transfers', compact('transfers', 'stats'));
    }

    public function transfersCreate()
    {
        $accounts = FinanceAccount::query()
            ->where('is_active', true)
            ->orderBy('type')
            ->orderBy('name')
            ->get();

        return view('admin.finance.banking.transfers-create', compact('accounts'));
    }

    public function transfersStore(Request $request)
    {
        $validated = $request->validate([
            'from_account_id' => 'required|integer|exists:finance_accounts,id',
            'to_account_id' => 'required|integer|exists:finance_accounts,id|different:from_account_id',
            'amount' => 'required|numeric|min:0.01',
            'transfer_date' => 'required|date',
            'reference' => 'nullable|string|max:255',
            'notes' => 'nullable|string|max:255',
        ]);

        FinanceTransfer::create($validated);

        return redirect()->route('admin.finance.banking.transfers')->with('success', 'Transfer created successfully.');
    }

    public function reconciliation()
    {
        $reconciliations = FinanceReconciliation::query()
            ->with('account')
            ->latest('statement_date')
            ->paginate(20);

        $stats = [
            'count' => $reconciliations->total(),
        ];

        return view('admin.finance.banking.reconciliation', compact('reconciliations', 'stats'));
    }

    public function reconciliationCreate()
    {
        $accounts = FinanceAccount::query()
            ->where('is_active', true)
            ->orderBy('type')
            ->orderBy('name')
            ->get();

        return view('admin.finance.banking.reconciliation-create', compact('accounts'));
    }

    public function reconciliationStore(Request $request)
    {
        $validated = $request->validate([
            'finance_account_id' => 'required|integer|exists:finance_accounts,id',
            'statement_date' => 'required|date',
            'statement_balance' => 'required|numeric',
            'notes' => 'nullable|string|max:255',
        ]);

        $account = FinanceAccount::findOrFail($validated['finance_account_id']);
        $systemBalance = $this->calcAccountBalance($account);

        $row = FinanceReconciliation::create([
            'finance_account_id' => $account->id,
            'statement_date' => $validated['statement_date'],
            'statement_balance' => (float) $validated['statement_balance'],
            'system_balance' => (float) $systemBalance,
            'notes' => $validated['notes'] ?? null,
        ]);

        $account->update([
            'last_reconciled_at' => now(),
        ]);

        return redirect()->route('admin.finance.banking.reconciliation')->with('success', 'Reconciliation saved successfully.');
    }

    public function bankAccountsExportPdf()
    {
        $view = $this->bankAccounts();
        $data = $view->getData();
        $pdf = Pdf::loadView('pdf.finance.banking-bank-accounts', $data)->setPaper('a4', 'portrait');

        return $pdf->download('bank-accounts.pdf');
    }

    public function cashAccountsExportPdf()
    {
        $view = $this->cashAccounts();
        $data = $view->getData();
        $pdf = Pdf::loadView('pdf.finance.banking-cash-accounts', $data)->setPaper('a4', 'portrait');

        return $pdf->download('cash-accounts.pdf');
    }

    public function transfersExportPdf()
    {
        $transfers = FinanceTransfer::query()->with(['fromAccount', 'toAccount'])->latest('transfer_date')->limit(250)->get();
        $stats = [
            'count' => $transfers->count(),
            'total' => (float) $transfers->sum('amount'),
        ];

        $pdf = Pdf::loadView('pdf.finance.banking-transfers', compact('transfers', 'stats'))->setPaper('a4', 'portrait');

        return $pdf->download('bank-transfers.pdf');
    }

    public function reconciliationExportPdf()
    {
        $reconciliations = FinanceReconciliation::query()->with('account')->latest('statement_date')->limit(250)->get();
        $stats = [
            'count' => $reconciliations->count(),
        ];

        $pdf = Pdf::loadView('pdf.finance.banking-reconciliation', compact('reconciliations', 'stats'))->setPaper('a4', 'portrait');

        return $pdf->download('reconciliation.pdf');
    }
}

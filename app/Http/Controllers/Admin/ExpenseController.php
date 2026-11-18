<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Expense;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class ExpenseController extends Controller
{
    public function create(): View
    {
        return view('expenses.create-expenses', [
            'categories' => $this->categoryNames(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'category' => ['required', 'string', Rule::exists('categories', 'name')],
            'amount' => ['required', 'numeric', 'gt:0', 'max:9999999999'],
            'date' => ['required', 'date'],
            'payment_method' => ['nullable', Rule::in(['Cash', 'Bank Transfer', 'Credit Card', 'Debit Card', 'Mobile Banking'])],
            'merchant' => ['nullable', 'string', 'max:255'],
            'notes' => ['nullable', 'string', 'max:5000'],
            'receipt' => ['nullable', 'file', 'mimes:png,jpg,jpeg,pdf', 'max:5120'],
        ]);

        $receiptPath = $request->file('receipt')?->store('expense-receipts', 'public');

        $expense = Expense::create([
            'user_id' => $request->user()->id,
            'title' => $validated['title'],
            'category' => $validated['category'],
            'amount' => $validated['amount'],
            'expense_date' => $validated['date'],
            'payment_method' => $validated['payment_method'] ?? null,
            'merchant' => $validated['merchant'] ?? null,
            'notes' => $validated['notes'] ?? null,
            'receipt_path' => $receiptPath,
            'status' => 'pending',
        ]);

        return redirect()->route('admin.expenses.index')->with('popup', [
            'type' => 'added',
            'title' => 'Expense added successfully!',
            'message' => "\"{$expense->title}\" (৳ ".number_format((float) $expense->amount, 2).') was added and submitted for approval.',
        ]);
    }

    public function edit(Request $request, Expense $expense): View
    {
        Gate::authorize('update', $expense);

        return view('expenses.create-expenses', [
            'expense' => $expense->load('user'),
            'categories' => $this->categoryNames(),
            'returnTo' => $this->returnTo($request),
        ]);
    }

    public function update(Request $request, Expense $expense): RedirectResponse
    {
        Gate::authorize('update', $expense);

        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'category' => ['required', 'string', Rule::exists('categories', 'name')],
            'amount' => ['required', 'numeric', 'gt:0', 'max:9999999999'],
            'date' => ['required', 'date'],
            'payment_method' => ['nullable', Rule::in(['Cash', 'Bank Transfer', 'Credit Card', 'Debit Card', 'Mobile Banking'])],
            'merchant' => ['nullable', 'string', 'max:255'],
            'notes' => ['nullable', 'string', 'max:5000'],
            'receipt' => ['nullable', 'file', 'mimes:png,jpg,jpeg,pdf', 'max:5120'],
        ]);

        $receiptPath = $expense->receipt_path;
        if ($request->hasFile('receipt')) {
            if ($receiptPath) {
                Storage::disk('public')->delete($receiptPath);
            }
            $receiptPath = $request->file('receipt')->store('expense-receipts', 'public');
        }

        $expense->update([
            'title' => $validated['title'],
            'category' => $validated['category'],
            'amount' => $validated['amount'],
            'expense_date' => $validated['date'],
            'payment_method' => $validated['payment_method'] ?? null,
            'merchant' => $validated['merchant'] ?? null,
            'notes' => $validated['notes'] ?? null,
            'receipt_path' => $receiptPath,
        ]);

        return redirect()->route($this->returnTo($request))->with('success', 'Expense updated successfully.');
    }

    public function destroy(Request $request, Expense $expense): RedirectResponse
    {
        Gate::authorize('delete', $expense);

        if ($expense->receipt_path) {
            Storage::disk('public')->delete($expense->receipt_path);
        }
        $expense->delete();

        return redirect()->route($this->returnTo($request))->with('popup', [
            'type' => 'deleted',
            'title' => 'Expense Deleted',
            'message' => "\"{$expense->title}\" (৳ ".number_format((float) $expense->amount, 2).') has been removed.',
        ]);
    }

    /**
     * The expense list to go back to after editing or deleting (All Expenses or My Expenses).
     */
    private function returnTo(Request $request): string
    {
        return $request->input('from') === 'all' ? 'admin.expenses.all' : 'admin.expenses.index';
    }

    /**
     * Category names offered in the expense form.
     *
     * @return Collection<int, string>
     */
    private function categoryNames(): Collection
    {
        return Category::orderBy('name')->pluck('name');
    }
}

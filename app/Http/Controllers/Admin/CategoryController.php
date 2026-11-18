<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Expense;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class CategoryController extends Controller
{
    public function index(): View
    {
        $categories = Category::query()
            ->withCount('expenses')
            ->withSum('expenses', 'amount')
            ->orderBy('name')
            ->get();

        return view('categories.categories', [
            'categories' => $categories,
            'usedCategoryCount' => $categories->where('expenses_count', '>', 0)->count(),
            'totalExpenseAmount' => (float) $categories->sum('expenses_sum_amount'),
            'mostUsedCategory' => $categories->where('expenses_count', '>', 0)->sortByDesc('expenses_count')->first(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validateWithBag('category', $this->rules());

        Category::create($validated);

        return redirect()->route('admin.categories.index')
            ->with('success', "Category \"{$validated['name']}\" added. It is now available in the expense form.");
    }

    public function update(Request $request, Category $category): RedirectResponse
    {
        Gate::authorize('update', $category);

        $validated = $request->validateWithBag('category', $this->rules($category));
        $previousName = $category->name;

        DB::transaction(function () use ($category, $validated, $previousName): void {
            // Expenses store the category name, so keep them in step with a rename.
            if ($previousName !== $validated['name']) {
                Expense::where('category', $previousName)->update(['category' => $validated['name']]);
            }

            $category->update($validated);
        });

        return redirect()->route('admin.categories.index')
            ->with('success', "Category \"{$validated['name']}\" updated.");
    }

    public function destroy(Category $category): RedirectResponse
    {
        Gate::authorize('delete', $category);

        $expenseCount = $category->expenses()->count();

        if ($expenseCount > 0) {
            return redirect()->route('admin.categories.index')
                ->with('error', "\"{$category->name}\" is used by {$expenseCount} ".str('expense')->plural($expenseCount).' and cannot be deleted. Rename it instead, or move those expenses to another category first.');
        }

        $category->delete();

        return redirect()->route('admin.categories.index')
            ->with('success', "Category \"{$category->name}\" deleted.");
    }

    /**
     * @return array<string, array<int, mixed>>
     */
    private function rules(?Category $category = null): array
    {
        return [
            'name' => ['required', 'string', 'max:60', Rule::unique('categories', 'name')->ignore($category)],
            'description' => ['nullable', 'string', 'max:255'],
        ];
    }
}

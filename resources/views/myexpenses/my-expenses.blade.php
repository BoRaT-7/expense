@extends('admin.layouts.app')

@section('title', 'My Expenses')

@section('content')
    @php
        $totalAmount = (float) $expenses->sum('amount');
        $monthAmount = (float) $expenses->filter(fn ($expense) => $expense->expense_date->isCurrentMonth())->sum('amount');
        $averageAmount = $expenses->count() ? $totalAmount / $expenses->count() : 0;
    @endphp

    <div class="mx-auto max-w-7xl space-y-7">
        <div class="flex flex-col justify-between gap-4 sm:flex-row sm:items-center">
            <div>
                <div class="mb-3 flex items-center gap-2 text-sm text-slate-400">
                    <a href="{{ route('admin.dashboard') }}" class="hover:text-blue-600 dark:hover:text-blue-400">Dashboard</a>
                    <span>/</span><span class="font-semibold text-blue-600 dark:text-blue-400">My Expenses</span>
                </div>
                <h1 class="text-2xl font-extrabold tracking-tight text-slate-800 md:text-3xl dark:text-slate-100">My Expenses</h1>
                <p class="mt-2 text-sm text-slate-500 dark:text-slate-400">Manage expenses you added to your account.</p>
            </div>
            <a href="{{ route('admin.expenses.create') }}" class="inline-flex items-center justify-center gap-2 rounded-xl bg-blue-600 px-5 py-3 text-sm font-semibold text-white shadow-lg shadow-blue-600/20 transition hover:bg-blue-700">+ Add New Expense</a>
        </div>

        @if (session('success'))
            <div class="rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-700 dark:border-emerald-500/30 dark:bg-emerald-500/10 dark:text-emerald-300">{{ session('success') }}</div>
        @endif

        <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 xl:grid-cols-4">
            @foreach ([
                ['My Total Expenses', '৳ ' . number_format($totalAmount, 2), 'Overall spending', '৳', 'blue'],
                ['This Month', '৳ ' . number_format($monthAmount, 2), 'Current month spending', '▤', 'violet'],
                ['Total Records', number_format($expenses->count()), 'My expense records', '▣', 'emerald'],
                ['Average Expense', '৳ ' . number_format($averageAmount, 2), 'Average per record', '↗', 'amber'],
            ] as [$title, $value, $caption, $icon, $color])
                <div class="group relative overflow-hidden rounded-2xl border border-slate-200 bg-white p-5 shadow-sm transition-all duration-300 hover:-translate-y-1 hover:border-{{ $color }}-200 hover:shadow-lg dark:border-slate-700 dark:bg-slate-900 dark:hover:border-{{ $color }}-500/40">
                    <div class="flex items-start justify-between">
                        <div>
                            <p class="text-sm font-medium text-slate-500 dark:text-slate-400">{{ $title }}</p>
                            <h3 class="mt-3 text-2xl font-bold tracking-tight text-slate-800 dark:text-slate-100">{{ $value }}</h3>
                            <p class="mt-2 text-xs font-medium text-slate-400">{{ $caption }}</p>
                        </div>
                        <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-{{ $color }}-50 text-2xl font-semibold text-{{ $color }}-600 transition-colors duration-300 group-hover:bg-{{ $color }}-600 group-hover:text-white dark:bg-{{ $color }}-500/10 dark:text-{{ $color }}-400">
                            {{ $icon }}
                        </div>
                    </div>
                    <div class="absolute bottom-0 left-0 h-1 w-full bg-{{ $color }}-500"></div>
                </div>
            @endforeach
        </div>

        <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm dark:border-slate-700 dark:bg-slate-900">
            <div class="border-b border-slate-100 p-5 md:px-6 dark:border-slate-800">
                <h2 class="text-lg font-bold text-slate-800 dark:text-slate-100">My Expense History</h2>
                <p class="mt-1 text-xs text-slate-400">Only expenses submitted by your account are shown here.</p>
            </div>

            <div class="grid grid-cols-1 gap-4 border-b border-slate-100 p-5 sm:grid-cols-2 xl:grid-cols-4 dark:border-slate-800">
                <div><label for="myStartDate" class="mb-2 block text-xs font-semibold text-slate-500 dark:text-slate-400">From Date</label><input type="date" id="myStartDate" class="h-11 w-full rounded-xl border border-slate-200 bg-slate-50 px-3 text-sm dark:border-slate-700 dark:bg-slate-800"></div>
                <div><label for="myEndDate" class="mb-2 block text-xs font-semibold text-slate-500 dark:text-slate-400">To Date</label><input type="date" id="myEndDate" class="h-11 w-full rounded-xl border border-slate-200 bg-slate-50 px-3 text-sm dark:border-slate-700 dark:bg-slate-800"></div>
                <div><label for="myExpenseSearch" class="mb-2 block text-xs font-semibold text-slate-500 dark:text-slate-400">Search</label><input type="search" id="myExpenseSearch" placeholder="Search my expenses..." class="h-11 w-full rounded-xl border border-slate-200 bg-slate-50 px-3 text-sm dark:border-slate-700 dark:bg-slate-800"></div>
                <div><label for="myCategoryFilter" class="mb-2 block text-xs font-semibold text-slate-500 dark:text-slate-400">Category</label><select id="myCategoryFilter" class="h-11 w-full rounded-xl border border-slate-200 bg-slate-50 px-3 text-sm dark:border-slate-700 dark:bg-slate-800"><option value="">All Categories</option>@foreach ($expenses->pluck('category')->unique()->sort() as $category)<option value="{{ strtolower($category) }}">{{ $category }}</option>@endforeach</select></div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full min-w-[900px] text-left">
                    <thead class="border-b border-slate-200 bg-slate-50 dark:border-slate-700 dark:bg-slate-800"><tr class="text-xs font-bold uppercase tracking-wider text-slate-600 dark:text-slate-300"><th class="px-5 py-4">Expense</th><th class="px-5 py-4">Category</th><th class="px-5 py-4">Date</th><th class="px-5 py-4">Payment</th><th class="px-5 py-4 text-right">Amount</th><th class="px-5 py-4 text-center">Receipt</th><th class="px-5 py-4 text-center">Actions</th></tr></thead>
                    <tbody id="myExpenseTable" class="divide-y divide-slate-100 text-sm dark:divide-slate-800">
                        @forelse ($expenses as $expense)
                            @php
                                $searchText = strtolower(implode(' ', array_filter([$expense->title, $expense->merchant, $expense->category, $expense->payment_method, $expense->notes])));
                            @endphp
                            <tr class="my-expense-row hover:bg-slate-50/70 dark:hover:bg-slate-800/60" data-search="{{ $searchText }}" data-category="{{ strtolower($expense->category) }}" data-date="{{ $expense->expense_date->toDateString() }}">
                                <td class="px-5 py-4"><p class="font-semibold text-slate-900 dark:text-white">{{ $expense->title }}</p><p class="mt-1 text-xs text-slate-500 dark:text-slate-400">{{ $expense->merchant ?: '—' }} · {{ ucfirst($expense->status) }}</p></td>
                                <td class="px-5 py-4 text-slate-600 dark:text-slate-300">{{ $expense->category }}</td>
                                <td class="px-5 py-4 text-slate-600 dark:text-slate-300">{{ $expense->expense_date->format('d M Y') }}</td>
                                <td class="px-5 py-4 text-slate-600 dark:text-slate-300">{{ $expense->payment_method ?: '—' }}</td>
                                <td class="px-5 py-4 text-right font-semibold tabular-nums text-slate-900 dark:text-white">৳ {{ number_format((float) $expense->amount, 2) }}</td>
                                <td class="px-5 py-3 text-center">@include('components.admin.receipt-thumbnail')</td>
                                <td class="px-5 py-4">@include('components.admin.expense-actions', ['from' => 'mine'])</td>
                            </tr>
                        @empty
                            <tr><td colspan="7" class="px-5 py-12 text-center text-slate-500 dark:text-slate-400">You have not added any expenses yet.</td></tr>
                        @endforelse
                        <tr id="myNoResults" class="hidden"><td colspan="7" class="px-5 py-12 text-center text-slate-500 dark:text-slate-400">No matching expenses found.</td></tr>
                    </tbody>
                </table>
            </div>
            <div class="flex items-center justify-between border-t border-slate-100 px-5 py-4 dark:border-slate-800"><p id="myResultCount" class="text-xs text-slate-500 dark:text-slate-400"></p><nav id="myPagination" class="flex gap-1" aria-label="Expense pages"></nav></div>
        </div>
    </div>

    @include('components.admin.receipt-modal')

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const rows = [...document.querySelectorAll('.my-expense-row')];
            const search = document.getElementById('myExpenseSearch');
            const category = document.getElementById('myCategoryFilter');
            const start = document.getElementById('myStartDate');
            const end = document.getElementById('myEndDate');
            const empty = document.getElementById('myNoResults');
            const resultCount = document.getElementById('myResultCount');
            const pager = document.getElementById('myPagination');
            const pageSize = 10;
            let page = 1;

            function render() {
                const term = search.value.trim().toLowerCase();
                if (start.value && end.value && start.value > end.value) {
                    end.setCustomValidity('End date cannot be earlier than start date.');
                    end.reportValidity();
                    return;
                }
                end.setCustomValidity('');
                const filtered = rows.filter(row =>
                    (!term || row.dataset.search.includes(term)) &&
                    (!category.value || row.dataset.category === category.value) &&
                    (!start.value || row.dataset.date >= start.value) &&
                    (!end.value || row.dataset.date <= end.value)
                );
                const pages = Math.max(1, Math.ceil(filtered.length / pageSize));
                page = Math.min(page, pages);
                rows.forEach(row => row.classList.add('hidden'));
                filtered.slice((page - 1) * pageSize, page * pageSize).forEach(row => row.classList.remove('hidden'));
                if (empty) empty.classList.toggle('hidden', filtered.length > 0);
                resultCount.textContent = filtered.length ? `Showing ${(page - 1) * pageSize + 1}-${Math.min(page * pageSize, filtered.length)} of ${filtered.length} expenses` : 'No matching expenses';
                pager.replaceChildren();
                for (let number = 1; number <= pages; number++) {
                    const button = document.createElement('button');
                    button.type = 'button';
                    button.textContent = number;
                    button.className = `rounded-lg px-3 py-2 text-xs font-semibold ${number === page ? 'bg-blue-600 text-white' : 'text-slate-600 hover:bg-slate-100 dark:text-slate-300 dark:hover:bg-slate-800'}`;
                    button.addEventListener('click', () => { page = number; render(); });
                    pager.append(button);
                }
            }
            [search, category, start, end].forEach(input => input.addEventListener('input', () => { page = 1; render(); }));
            render();
        });
    </script>
@endsection

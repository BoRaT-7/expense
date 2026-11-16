@extends('admin.layouts.app')

@section('title', 'All Expenses')

@section('content')

    <div class="mx-auto max-w-7xl space-y-7">

        {{-- Page Header --}}
        <div class="flex flex-col justify-between gap-4 sm:flex-row sm:items-center">

            <div>
                <div class="mb-3 flex items-center gap-2 text-sm text-slate-400">
                    <a href="{{ route('admin.dashboard') }}" class="hover:text-blue-600 dark:hover:text-blue-400">
                        Dashboard
                    </a>
                    <span>/</span>
                    <span class="font-semibold text-blue-600 dark:text-blue-400">All Expenses</span>
                </div>

                <h1 class="text-2xl font-extrabold tracking-tight text-slate-800 md:text-3xl dark:text-slate-100">
                    All Expenses
                </h1>

                <p class="mt-2 text-sm text-slate-500 dark:text-slate-400">
                    Track, organize and manage all your business expenses.
                </p>
            </div>

            <a href="{{ route('admin.expenses.create') }}"
                class="inline-flex items-center justify-center gap-2 rounded-xl bg-blue-600 px-5 py-3 text-sm font-semibold text-white shadow-lg shadow-blue-600/20 transition hover:bg-blue-700">
                <span class="text-lg">+</span>
                Add New Expense
            </a>

        </div>



        {{-- Summary Cards --}}
        <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 xl:grid-cols-4">

            {{-- Total Expenses --}}
            <div
                class="group relative overflow-hidden rounded-2xl border border-slate-200 bg-white p-5 shadow-sm transition-all duration-300 hover:-translate-y-1 hover:border-blue-200 hover:shadow-lg dark:border-slate-700 dark:bg-slate-900 dark:hover:border-blue-500/40">
                <div class="flex items-start justify-between">
                    <div>
                        <p class="text-sm font-medium text-slate-500 dark:text-slate-400">
                            Total Expenses
                        </p>
                        <h3 class="mt-3 text-2xl font-bold tracking-tight text-slate-800 dark:text-slate-100">
                            ৳ {{ number_format((float) $expenses->sum('amount'), 2) }}
                        </h3>
                        <p class="mt-2 text-xs font-medium text-slate-400">
                            Total of saved expenses
                        </p>
                    </div>

                    <div
                        class="flex h-12 w-12 items-center justify-center rounded-xl bg-blue-50 text-2xl font-semibold text-blue-600 transition-colors duration-300 group-hover:bg-blue-600 group-hover:text-white dark:bg-blue-500/10 dark:text-blue-400">
                        ৳
                    </div>
                </div>

                <div class="absolute bottom-0 left-0 h-1 w-full bg-blue-500"></div>
            </div>

            {{-- This Month --}}
            <div
                class="group relative overflow-hidden rounded-2xl border border-slate-200 bg-white p-5 shadow-sm transition-all duration-300 hover:-translate-y-1 hover:border-violet-200 hover:shadow-lg dark:border-slate-700 dark:bg-slate-900 dark:hover:border-violet-500/40">
                <div class="flex items-start justify-between">
                    <div>
                        <p class="text-sm font-medium text-slate-500 dark:text-slate-400">
                            This Month
                        </p>
                        <h3 class="mt-3 text-2xl font-bold tracking-tight text-slate-800 dark:text-slate-100">
                            ৳ {{ number_format((float) $expenses->filter(fn ($expense) => $expense->expense_date->isCurrentMonth())->sum('amount'), 2) }}
                        </h3>
                        <p class="mt-2 text-xs font-medium text-slate-400">
                            Current month total
                        </p>
                    </div>

                    <div
                        class="flex h-12 w-12 items-center justify-center rounded-xl bg-violet-50 text-2xl text-violet-600 transition-colors duration-300 group-hover:bg-violet-600 group-hover:text-white dark:bg-violet-500/10 dark:text-violet-400">
                        ▤
                    </div>
                </div>

                <div class="absolute bottom-0 left-0 h-1 w-full bg-violet-500"></div>
            </div>

            {{-- Total Records --}}
            <div
                class="group relative overflow-hidden rounded-2xl border border-slate-200 bg-white p-5 shadow-sm transition-all duration-300 hover:-translate-y-1 hover:border-emerald-200 hover:shadow-lg dark:border-slate-700 dark:bg-slate-900 dark:hover:border-emerald-500/40">
                <div class="flex items-start justify-between">
                    <div>
                        <p class="text-sm font-medium text-slate-500 dark:text-slate-400">
                            Total Records
                        </p>
                        <h3 class="mt-3 text-2xl font-bold tracking-tight text-slate-800 dark:text-slate-100">
                            {{ $expenses->count() }}
                        </h3>
                        <p class="mt-2 text-xs font-medium text-slate-400">
                            Recorded expenses
                        </p>
                    </div>

                    <div
                        class="flex h-12 w-12 items-center justify-center rounded-xl bg-emerald-50 text-2xl text-emerald-600 transition-colors duration-300 group-hover:bg-emerald-600 group-hover:text-white dark:bg-emerald-500/10 dark:text-emerald-400">
                        ▣
                    </div>
                </div>

                <div class="absolute bottom-0 left-0 h-1 w-full bg-emerald-500"></div>
            </div>

            {{-- Average Expense --}}
            <div
                class="group relative overflow-hidden rounded-2xl border border-slate-200 bg-white p-5 shadow-sm transition-all duration-300 hover:-translate-y-1 hover:border-amber-200 hover:shadow-lg dark:border-slate-700 dark:bg-slate-900 dark:hover:border-amber-500/40">
                <div class="flex items-start justify-between">
                    <div>
                        <p class="text-sm font-medium text-slate-500 dark:text-slate-400">
                            Average Expense
                        </p>
                        <h3 class="mt-3 text-2xl font-bold tracking-tight text-slate-800 dark:text-slate-100">
                            ৳ {{ number_format((float) ($expenses->count() ? $expenses->sum('amount') / $expenses->count() : 0), 2) }}
                        </h3>
                        <p class="mt-2 text-xs font-medium text-slate-400">
                            Average saved expense
                        </p>
                    </div>

                    <div
                        class="flex h-12 w-12 items-center justify-center rounded-xl bg-amber-50 text-2xl text-amber-600 transition-colors duration-300 group-hover:bg-amber-500 group-hover:text-white dark:bg-amber-500/10 dark:text-amber-400">
                        ↗
                    </div>
                </div>

                <div class="absolute bottom-0 left-0 h-1 w-full bg-amber-500"></div>
            </div>

        </div>



        {{-- Expenses Table Card --}}
        <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm dark:border-slate-700 dark:bg-slate-900">

            {{-- Table Header --}}
            <div
                class="flex flex-col justify-between gap-4 border-b border-slate-100 p-5 md:flex-row md:items-center md:px-6 dark:border-slate-800">

                <div>
                    <h2 class="text-lg font-bold text-slate-800 dark:text-slate-100">
                        Expense Records
                    </h2>

                    <p class="mt-1 text-xs text-slate-400">
                        A list of all recorded expenses.
                    </p>
                </div>
                {{--
                <button type="button" onclick="alert('Export functionality will be added later.')"
                    class="inline-flex items-center justify-center gap-2 rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm font-semibold text-slate-600 transition hover:bg-slate-50 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-300 dark:hover:bg-slate-800">

                    <span>↓</span>
                    Export Report

                </button> --}}

            </div>




            {{-- Report Filters --}}
            <div class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm dark:border-slate-700 dark:bg-slate-900">




                <div class="grid grid-cols-1 items-end gap-4 sm:grid-cols-2 xl:grid-cols-5">

                    {{-- Start Date --}}
                    <div>
                        <label for="startDate" class="mb-2 block text-xs font-semibold text-slate-600 dark:text-slate-300">
                            Start Date
                        </label>

                        <input type="date" id="startDate"
                            class="h-[46px] w-full rounded-xl border border-slate-200 bg-slate-50 px-3 text-sm text-slate-600 outline-none transition focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-500/10 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-300 dark:focus:bg-slate-900">
                    </div>

                    {{-- End Date --}}
                    <div>
                        <label for="endDate" class="mb-2 block text-xs font-semibold text-slate-600 dark:text-slate-300">
                            End Date
                        </label>

                        <input type="date" id="endDate"
                            class="h-[46px] w-full rounded-xl border border-slate-200 bg-slate-50 px-3 text-sm text-slate-600 outline-none transition focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-500/10 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-300 dark:focus:bg-slate-900">
                    </div>

                    {{-- Category --}}
                    <div>
                        <label for="reportCategory" class="mb-2 block text-xs font-semibold text-slate-600 dark:text-slate-300">
                            Category
                        </label>

                        <select id="reportCategory"
                            class="h-[46px] w-full rounded-xl border border-slate-200 bg-slate-50 px-3 text-sm text-slate-600 outline-none transition focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-500/10 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-300 dark:focus:bg-slate-900">

                        <option value="">All Categories</option>
                        @foreach ($expenses->pluck('category')->unique()->sort() as $category)
                            <option value="{{ $category }}">{{ $category }}</option>
                        @endforeach

                        </select>
                    </div>

                    {{-- Search --}}
                    <div>
                        <label for="reportSearch" class="mb-2 block text-xs font-semibold text-slate-600 dark:text-slate-300">
                            Search Expense
                        </label>

                        <div class="relative">
                            <svg class="absolute left-3 top-1/2 h-5 w-5 -translate-y-1/2 text-slate-400"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                stroke-width="1.8">
                                <circle cx="11" cy="11" r="7"></circle>
                                <path stroke-linecap="round" d="m16 16 4 4"></path>
                            </svg>

                            <input type="search" id="reportSearch" placeholder="Search expense..."
                                class="h-[46px] w-full rounded-xl border border-slate-200 bg-slate-50 pl-10 pr-3 text-sm text-slate-700 outline-none transition focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-500/10 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-200 dark:focus:bg-slate-900">
                        </div>
                    </div>

                    {{-- Apply Filters --}}
                    <button type="button" onclick="applyReportFilters()"
                        class="h-[46px] rounded-xl bg-slate-900 px-4 text-sm font-semibold text-white transition duration-200 hover:bg-blue-600 hover:shadow-md hover:shadow-blue-500/20 active:scale-95 dark:bg-slate-700">
                        Apply Filters
                    </button>

                </div>

            </div>




            {{-- Responsive Table --}}
            <div class="overflow-x-auto">

                <table class="w-full min-w-[950px] text-left">

                    <thead class="bg-slate-50 dark:bg-slate-800">

                        <tr class="text-xs font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400">

                            <th class="px-6 py-4">Expense Details</th>
                            <th class="px-6 py-4">Category</th>
                            <th class="px-6 py-4">Date</th>
                            <th class="px-6 py-4">Payment</th>
                            <th class="px-6 py-4">Amount</th>
                            <th class="px-6 py-4 text-center">Receipt</th>
                            <th class="px-6 py-4 text-center">Actions</th>

                        </tr>

                    </thead>


                    <tbody id="expenseTableBody" class="divide-y divide-slate-100 text-sm dark:divide-slate-800">
                        @forelse ($expenses as $expense)
                            @php
                                $searchText = strtolower(implode(' ', array_filter([
                                    $expense->title,
                                    $expense->merchant,
                                    $expense->category,
                                    $expense->payment_method,
                                    $expense->user?->name,
                                ])));
                            @endphp
                            <tr class="expense-row transition hover:bg-slate-50 dark:hover:bg-slate-800"
                                data-search="{{ $searchText }}"
                                data-category="{{ strtolower($expense->category) }}"
                                data-date="{{ $expense->expense_date->toDateString() }}">
                                <td class="px-6 py-5">
                                    <p class="font-bold text-slate-800 dark:text-slate-100">{{ $expense->title }}</p>
                                    <p class="mt-1 text-xs text-slate-400">{{ $expense->merchant ?: '—' }}</p>
                                    <p class="mt-1 text-xs text-slate-500 dark:text-slate-400">By: {{ $expense->user?->name ?? 'Unknown' }}</p>
                                </td>
                                <td class="px-6 py-5"><span class="rounded-lg bg-blue-50 px-3 py-1.5 text-xs font-semibold text-blue-600 dark:bg-blue-500/10 dark:text-blue-400">{{ $expense->category }}</span></td>
                                <td class="px-6 py-5 text-slate-600 dark:text-slate-300">{{ $expense->expense_date->format('d M Y') }}</td>
                                <td class="px-6 py-5 text-slate-600 dark:text-slate-300">{{ $expense->payment_method ?: '—' }}</td>
                                <td class="px-6 py-5 font-bold text-slate-800 dark:text-slate-100">৳ {{ number_format((float) $expense->amount, 2) }}</td>
                                <td class="px-6 py-3 text-center">@include('components.admin.receipt-thumbnail')</td>
                                <td class="px-6 py-5 text-center text-xs font-semibold text-slate-500 dark:text-slate-400">{{ ucfirst($expense->status) }}</td>
                            </tr>
                        @empty
                            <tr id="noResults"><td colspan="7" class="px-6 py-12 text-center text-sm text-slate-400">No expenses have been added yet.</td></tr>
                        @endforelse
                        <tr id="noFilteredResults" class="hidden"><td colspan="7"class="px-6 py-12 text-center text-sm text-slate-400">No matching expenses found.</td></tr>

                    </tbody>

                </table>

            </div>


            {{-- Table Footer --}}
            <div class="flex flex-col items-center justify-between gap-3 border-t border-slate-100 px-6 py-5 sm:flex-row dark:border-slate-800">

                <p id="resultCount" class="text-xs font-medium text-slate-500 dark:text-slate-400">
                    Showing {{ $expenses->count() }} expenses
                </p>

                <span class="text-xs text-slate-400">
                    Saved expenses
                </span>

            </div>

        </div>

    </div>

    @include('components.admin.receipt-modal')


    {{-- Frontend Search and Filter --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            const searchInput = document.getElementById('reportSearch');
            const categoryFilter = document.getElementById('reportCategory');

            const startDate = document.getElementById('startDate');
            const endDate = document.getElementById('endDate');

            const rows = document.querySelectorAll('.expense-row');
            const noResults = document.getElementById('noFilteredResults');
            const resultCount = document.getElementById('resultCount');

            function filterExpenses() {

                const search = searchInput.value.toLowerCase().trim();
                const category = categoryFilter.value.toLowerCase();

                const fromDate = startDate.value;
                const toDate = endDate.value;

                // Check date range
                if (fromDate && toDate && fromDate > toDate) {
                    endDate.setCustomValidity('To Date cannot be earlier than From Date.');
                    endDate.reportValidity();
                    return;
                }

                endDate.setCustomValidity('');

                let visibleCount = 0;

                rows.forEach(function(row) {

                    const searchData = row.dataset.search.toLowerCase();
                    const rowCategory = row.dataset.category.toLowerCase();
                    const rowDate = row.dataset.date;

                    const matchesSearch = searchData.includes(search);
                    const matchesCategory = !category || rowCategory === category;

                    // Inclusive date range
                    const matchesStartDate = !fromDate || rowDate >= fromDate;
                    const matchesEndDate = !toDate || rowDate <= toDate;

                    const visible =
                        matchesSearch &&
                        matchesCategory &&
                        matchesStartDate &&
                        matchesEndDate;

                    row.classList.toggle('hidden', !visible);

                    if (visible) {
                        visibleCount++;
                    }

                });

                noResults.classList.toggle('hidden', visibleCount > 0);

                resultCount.textContent = `Showing ${visibleCount} expenses`;

            }

            searchInput.addEventListener('input', filterExpenses);
            categoryFilter.addEventListener('change', filterExpenses);

            startDate.addEventListener('change', filterExpenses);
            endDate.addEventListener('change', filterExpenses);

        });
    </script>

@endsection

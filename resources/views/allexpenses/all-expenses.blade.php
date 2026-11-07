@extends('admin.layouts.app')

@section('title', 'All Expenses')

@section('content')

    <div class="mx-auto max-w-7xl space-y-7">

        {{-- Page Header --}}
        <div class="flex flex-col justify-between gap-4 sm:flex-row sm:items-center">

            <div>
                <div class="mb-3 flex items-center gap-2 text-sm text-slate-400">
                    <a href="{{ route('admin.dashboard') }}" class="hover:text-blue-600">
                        Dashboard
                    </a>
                    <span>/</span>
                    <span class="font-semibold text-blue-600">All Expenses</span>
                </div>

                <h1 class="text-2xl font-extrabold tracking-tight text-slate-800 md:text-3xl">
                    All Expenses
                </h1>

                <p class="mt-2 text-sm text-slate-500">
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
                class="group relative overflow-hidden rounded-2xl border border-slate-200 bg-white p-5 shadow-sm transition-all duration-300 hover:-translate-y-1 hover:border-blue-200 hover:shadow-lg">
                <div class="flex items-start justify-between">
                    <div>
                        <p class="text-sm font-medium text-slate-500">
                            Total Expenses
                        </p>
                        <h3 class="mt-3 text-2xl font-bold tracking-tight text-slate-800">
                            ৳ 45,850
                        </h3>
                        <p class="mt-2 text-xs font-medium text-slate-400">
                            Sample overview
                        </p>
                    </div>

                    <div
                        class="flex h-12 w-12 items-center justify-center rounded-xl bg-blue-50 text-2xl font-semibold text-blue-600 transition-colors duration-300 group-hover:bg-blue-600 group-hover:text-white">
                        ৳
                    </div>
                </div>

                <div class="absolute bottom-0 left-0 h-1 w-full bg-blue-500"></div>
            </div>

            {{-- This Month --}}
            <div
                class="group relative overflow-hidden rounded-2xl border border-slate-200 bg-white p-5 shadow-sm transition-all duration-300 hover:-translate-y-1 hover:border-violet-200 hover:shadow-lg">
                <div class="flex items-start justify-between">
                    <div>
                        <p class="text-sm font-medium text-slate-500">
                            This Month
                        </p>
                        <h3 class="mt-3 text-2xl font-bold tracking-tight text-slate-800">
                            ৳ 18,500
                        </h3>
                        <p class="mt-2 text-xs font-medium text-slate-400">
                            Monthly overview
                        </p>
                    </div>

                    <div
                        class="flex h-12 w-12 items-center justify-center rounded-xl bg-violet-50 text-2xl text-violet-600 transition-colors duration-300 group-hover:bg-violet-600 group-hover:text-white">
                        ▤
                    </div>
                </div>

                <div class="absolute bottom-0 left-0 h-1 w-full bg-violet-500"></div>
            </div>

            {{-- Total Records --}}
            <div
                class="group relative overflow-hidden rounded-2xl border border-slate-200 bg-white p-5 shadow-sm transition-all duration-300 hover:-translate-y-1 hover:border-emerald-200 hover:shadow-lg">
                <div class="flex items-start justify-between">
                    <div>
                        <p class="text-sm font-medium text-slate-500">
                            Total Records
                        </p>
                        <h3 class="mt-3 text-2xl font-bold tracking-tight text-slate-800">
                            24
                        </h3>
                        <p class="mt-2 text-xs font-medium text-slate-400">
                            Recorded expenses
                        </p>
                    </div>

                    <div
                        class="flex h-12 w-12 items-center justify-center rounded-xl bg-emerald-50 text-2xl text-emerald-600 transition-colors duration-300 group-hover:bg-emerald-600 group-hover:text-white">
                        ▣
                    </div>
                </div>

                <div class="absolute bottom-0 left-0 h-1 w-full bg-emerald-500"></div>
            </div>

            {{-- Average Expense --}}
            <div
                class="group relative overflow-hidden rounded-2xl border border-slate-200 bg-white p-5 shadow-sm transition-all duration-300 hover:-translate-y-1 hover:border-amber-200 hover:shadow-lg">
                <div class="flex items-start justify-between">
                    <div>
                        <p class="text-sm font-medium text-slate-500">
                            Average Expense
                        </p>
                        <h3 class="mt-3 text-2xl font-bold tracking-tight text-slate-800">
                            ৳ 1,910
                        </h3>
                        <p class="mt-2 text-xs font-medium text-slate-400">
                            Per expense record
                        </p>
                    </div>

                    <div
                        class="flex h-12 w-12 items-center justify-center rounded-xl bg-amber-50 text-2xl text-amber-600 transition-colors duration-300 group-hover:bg-amber-500 group-hover:text-white">
                        ↗
                    </div>
                </div>

                <div class="absolute bottom-0 left-0 h-1 w-full bg-amber-500"></div>
            </div>

        </div>



        {{-- Expenses Table Card --}}
        <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">

            {{-- Table Header --}}
            <div
                class="flex flex-col justify-between gap-4 border-b border-slate-100 p-5 md:flex-row md:items-center md:px-6">

                <div>
                    <h2 class="text-lg font-bold text-slate-800">
                        Expense Records
                    </h2>

                    <p class="mt-1 text-xs text-slate-400">
                        A list of all recorded expenses.
                    </p>
                </div>
                {{--
                <button type="button" onclick="alert('Export functionality will be added later.')"
                    class="inline-flex items-center justify-center gap-2 rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm font-semibold text-slate-600 transition hover:bg-slate-50">

                    <span>↓</span>
                    Export Report

                </button> --}}

            </div>




            {{-- Report Filters --}}
            <div class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm">




                <div class="grid grid-cols-1 items-end gap-4 sm:grid-cols-2 xl:grid-cols-5">

                    {{-- Start Date --}}
                    <div>
                        <label for="startDate" class="mb-2 block text-xs font-semibold text-slate-600">
                            Start Date
                        </label>

                        <input type="date" id="startDate" value="2026-11-01"
                            class="h-[46px] w-full rounded-xl border border-slate-200 bg-slate-50 px-3 text-sm text-slate-600 outline-none transition focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-500/10">
                    </div>

                    {{-- End Date --}}
                    <div>
                        <label for="endDate" class="mb-2 block text-xs font-semibold text-slate-600">
                            End Date
                        </label>

                        <input type="date" id="endDate" value="2026-11-30"
                            class="h-[46px] w-full rounded-xl border border-slate-200 bg-slate-50 px-3 text-sm text-slate-600 outline-none transition focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-500/10">
                    </div>

                    {{-- Category --}}
                    <div>
                        <label for="reportCategory" class="mb-2 block text-xs font-semibold text-slate-600">
                            Category
                        </label>

                        <select id="reportCategory"
                            class="h-[46px] w-full rounded-xl border border-slate-200 bg-slate-50 px-3 text-sm text-slate-600 outline-none transition focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-500/10">

                            <option value="">All Categories</option>
                            <option value="Office Supplies">Office Supplies</option>
                            <option value="Food & Drinks">Food & Drinks</option>
                            <option value="Transportation">Transportation</option>
                            <option value="Internet & Hosting">Internet & Hosting</option>
                            <option value="Utilities">Utilities</option>

                        </select>
                    </div>

                    {{-- Search --}}
                    <div>
                        <label for="reportSearch" class="mb-2 block text-xs font-semibold text-slate-600">
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
                                class="h-[46px] w-full rounded-xl border border-slate-200 bg-slate-50 pl-10 pr-3 text-sm text-slate-700 outline-none transition focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-500/10">
                        </div>
                    </div>

                    {{-- Apply Filters --}}
                    <button type="button" onclick="applyReportFilters()"
                        class="h-[46px] rounded-xl bg-slate-900 px-4 text-sm font-semibold text-white transition duration-200 hover:bg-blue-600 hover:shadow-md hover:shadow-blue-500/20 active:scale-95">
                        Apply Filters
                    </button>

                </div>

            </div>




            {{-- Responsive Table --}}
            <div class="overflow-x-auto">

                <table class="w-full min-w-[850px] text-left">

                    <thead class="bg-slate-50">

                        <tr class="text-xs font-bold uppercase tracking-wider text-slate-500">

                            <th class="px-6 py-4">Expense Details</th>
                            <th class="px-6 py-4">Category</th>
                            <th class="px-6 py-4">Date</th>
                            <th class="px-6 py-4">Payment</th>
                            <th class="px-6 py-4">Amount</th>
                            <th class="px-6 py-4 text-center">Actions</th>

                        </tr>

                    </thead>


                    <tbody id="expenseTableBody" class="divide-y divide-slate-100 text-sm">

                        {{-- Expense 1 --}}
                        <tr class="expense-row transition hover:bg-slate-50" data-search="office supplies abc stationery"
                            data-category="office supplies" data-date="2026-11-03">

                            <td class="px-6 py-5">
                                <div class="flex items-center gap-3">


                                    <div>
                                        <p class="font-bold text-slate-800">
                                            Office Supplies
                                        </p>
                                        <p class="mt-1 text-xs text-slate-400">
                                            ABC Stationery Shop
                                        </p>
                                    </div>

                                </div>
                            </td>

                            <td class="px-6 py-5">
                                <span class="rounded-lg bg-blue-50 px-3 py-1.5 text-xs font-semibold text-blue-600">
                                    Office Supplies
                                </span>
                            </td>

                            <td class="px-6 py-5 text-slate-600">
                                03 Nov 2026
                            </td>

                            <td class="px-6 py-5 text-slate-600">
                                Cash
                            </td>

                            <td class="px-6 py-5 font-bold text-slate-800">
                                ৳ 2,500
                            </td>

                            <td class="px-6 py-5">

                                <div class="flex items-center justify-center gap-2">

                                    {{-- View Button --}}
                                    <button type="button" onclick="alert('View details will be available later.')"
                                        class="rounded-lg border border-blue-100 bg-blue-50 px-3 py-2 text-xs font-semibold text-blue-600 transition-all duration-200 hover:border-blue-200 hover:bg-blue-600 hover:text-white hover:shadow-md hover:shadow-blue-500/20 active:scale-95">
                                        View
                                    </button>

                                    {{-- Edit Button --}}
                                    <button type="button" onclick="alert('Edit functionality will be available later.')"
                                        class="rounded-lg border border-amber-100 bg-amber-50 px-3 py-2 text-xs font-semibold text-amber-600 transition-all duration-200 hover:border-amber-200 hover:bg-amber-500 hover:text-white hover:shadow-md hover:shadow-amber-500/20 active:scale-95">
                                        Edit
                                    </button>

                                    {{-- Delete Button --}}
                                    <button type="button"
                                        onclick="alert('Delete functionality will be available later.')"
                                        class="rounded-lg border border-red-100 bg-red-50 px-3 py-2 text-xs font-semibold text-red-600 transition-all duration-200 hover:border-red-200 hover:bg-red-500 hover:text-white hover:shadow-md hover:shadow-red-500/20 active:scale-95">
                                        Delete
                                    </button>

                                </div>

                            </td>

                        </tr>


                        {{-- Expense 2 --}}
                        <tr class="expense-row transition hover:bg-slate-50"
                            data-search="internet bill broadband provider" data-category="internet & hosting"
                            data-date="2026-11-02">

                            <td class="px-6 py-5">
                                <div class="flex items-center gap-3">



                                    <div>
                                        <p class="font-bold text-slate-800">
                                            Internet Bill
                                        </p>
                                        <p class="mt-1 text-xs text-slate-400">
                                            Broadband Provider
                                        </p>
                                    </div>

                                </div>
                            </td>

                            <td class="px-6 py-5">
                                <span class="rounded-lg bg-purple-50 px-3 py-1.5 text-xs font-semibold text-purple-600">
                                    Internet & Hosting
                                </span>
                            </td>

                            <td class="px-6 py-5 text-slate-600">
                                02 Nov 2026
                            </td>

                            <td class="px-6 py-5 text-slate-600">
                                Mobile Banking
                            </td>

                            <td class="px-6 py-5 font-bold text-slate-800">
                                ৳ 1,200
                            </td>

                            <td class="px-6 py-5">

                                <div class="flex items-center justify-center gap-2">

                                    {{-- View Button --}}
                                    <button type="button" onclick="alert('View details will be available later.')"
                                        class="rounded-lg border border-blue-100 bg-blue-50 px-3 py-2 text-xs font-semibold text-blue-600 transition-all duration-200 hover:border-blue-200 hover:bg-blue-600 hover:text-white hover:shadow-md hover:shadow-blue-500/20 active:scale-95">
                                        View
                                    </button>

                                    {{-- Edit Button --}}
                                    <button type="button" onclick="alert('Edit functionality will be available later.')"
                                        class="rounded-lg border border-amber-100 bg-amber-50 px-3 py-2 text-xs font-semibold text-amber-600 transition-all duration-200 hover:border-amber-200 hover:bg-amber-500 hover:text-white hover:shadow-md hover:shadow-amber-500/20 active:scale-95">
                                        Edit
                                    </button>

                                    {{-- Delete Button --}}
                                    <button type="button"
                                        onclick="alert('Delete functionality will be available later.')"
                                        class="rounded-lg border border-red-100 bg-red-50 px-3 py-2 text-xs font-semibold text-red-600 transition-all duration-200 hover:border-red-200 hover:bg-red-500 hover:text-white hover:shadow-md hover:shadow-red-500/20 active:scale-95">
                                        Delete
                                    </button>

                                </div>

                            </td>

                        </tr>


                        {{-- Expense 3 --}}
                        <tr class="expense-row transition hover:bg-slate-50" data-search="team lunch restaurant food"
                            data-category="food & drinks" data-date="2026-11-01">

                            <td class="px-6 py-5">
                                <div class="flex items-center gap-3">



                                    <div>
                                        <p class="font-bold text-slate-800">
                                            Team Lunch
                                        </p>
                                        <p class="mt-1 text-xs text-slate-400">
                                            Local Restaurant
                                        </p>
                                    </div>

                                </div>
                            </td>

                            <td class="px-6 py-5">
                                <span class="rounded-lg bg-orange-50 px-3 py-1.5 text-xs font-semibold text-orange-600">
                                    Food & Drinks
                                </span>
                            </td>

                            <td class="px-6 py-5 text-slate-600">
                                01 Nov 2026
                            </td>

                            <td class="px-6 py-5 text-slate-600">
                                Cash
                            </td>

                            <td class="px-6 py-5 font-bold text-slate-800">
                                ৳ 3,500
                            </td>

                            <td class="px-6 py-5">

                                <div class="flex items-center justify-center gap-2">

                                    {{-- View Button --}}
                                    <button type="button" onclick="alert('View details will be available later.')"
                                        class="rounded-lg border border-blue-100 bg-blue-50 px-3 py-2 text-xs font-semibold text-blue-600 transition-all duration-200 hover:border-blue-200 hover:bg-blue-600 hover:text-white hover:shadow-md hover:shadow-blue-500/20 active:scale-95">
                                        View
                                    </button>

                                    {{-- Edit Button --}}
                                    <button type="button" onclick="alert('Edit functionality will be available later.')"
                                        class="rounded-lg border border-amber-100 bg-amber-50 px-3 py-2 text-xs font-semibold text-amber-600 transition-all duration-200 hover:border-amber-200 hover:bg-amber-500 hover:text-white hover:shadow-md hover:shadow-amber-500/20 active:scale-95">
                                        Edit
                                    </button>

                                    {{-- Delete Button --}}
                                    <button type="button"
                                        onclick="alert('Delete functionality will be available later.')"
                                        class="rounded-lg border border-red-100 bg-red-50 px-3 py-2 text-xs font-semibold text-red-600 transition-all duration-200 hover:border-red-200 hover:bg-red-500 hover:text-white hover:shadow-md hover:shadow-red-500/20 active:scale-95">
                                        Delete
                                    </button>

                                </div>

                            </td>

                        </tr>


                        {{-- Expense 4 --}}
                        <tr class="expense-row transition hover:bg-slate-50" data-search="office electricity utility bill"
                            data-category="utilities" data-date="2026-10-29">

                            <td class="px-6 py-5">
                                <div class="flex items-center gap-3">



                                    <div>
                                        <p class="font-bold text-slate-800">
                                            Electricity Bill
                                        </p>
                                        <p class="mt-1 text-xs text-slate-400">
                                            Office Utility
                                        </p>
                                    </div>

                                </div>
                            </td>

                            <td class="px-6 py-5">
                                <span class="rounded-lg bg-emerald-50 px-3 py-1.5 text-xs font-semibold text-emerald-600">
                                    Utilities
                                </span>
                            </td>

                            <td class="px-6 py-5 text-slate-600">
                                29 Oct 2026
                            </td>

                            <td class="px-6 py-5 text-slate-600">
                                Bank Transfer
                            </td>

                            <td class="px-6 py-5 font-bold text-slate-800">
                                ৳ 4,800
                            </td>

                            <td class="px-6 py-5">

                                <div class="flex items-center justify-center gap-2">

                                    {{-- View Button --}}
                                    <button type="button" onclick="alert('View details will be available later.')"
                                        class="rounded-lg border border-blue-100 bg-blue-50 px-3 py-2 text-xs font-semibold text-blue-600 transition-all duration-200 hover:border-blue-200 hover:bg-blue-600 hover:text-white hover:shadow-md hover:shadow-blue-500/20 active:scale-95">
                                        View
                                    </button>

                                    {{-- Edit Button --}}
                                    <button type="button" onclick="alert('Edit functionality will be available later.')"
                                        class="rounded-lg border border-amber-100 bg-amber-50 px-3 py-2 text-xs font-semibold text-amber-600 transition-all duration-200 hover:border-amber-200 hover:bg-amber-500 hover:text-white hover:shadow-md hover:shadow-amber-500/20 active:scale-95">
                                        Edit
                                    </button>

                                    {{-- Delete Button --}}
                                    <button type="button"
                                        onclick="alert('Delete functionality will be available later.')"
                                        class="rounded-lg border border-red-100 bg-red-50 px-3 py-2 text-xs font-semibold text-red-600 transition-all duration-200 hover:border-red-200 hover:bg-red-500 hover:text-white hover:shadow-md hover:shadow-red-500/20 active:scale-95">
                                        Delete
                                    </button>

                                </div>

                            </td>

                        </tr>


                        {{-- No Results --}}
                        <tr id="noResults" class="hidden">
                            <td colspan="6" class="px-6 py-12 text-center text-sm text-slate-400">
                                No matching expenses found.
                            </td>
                        </tr>

                    </tbody>

                </table>

            </div>


            {{-- Table Footer --}}
            <div class="flex flex-col items-center justify-between gap-3 border-t border-slate-100 px-6 py-5 sm:flex-row">

                <p id="resultCount" class="text-xs font-medium text-slate-500">
                    Showing 4 sample records
                </p>

                <span class="text-xs text-slate-400">
                    Frontend demonstration data
                </span>

            </div>

        </div>

    </div>


    {{-- Frontend Search and Filter --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            const searchInput = document.getElementById('expenseSearch');
            const categoryFilter = document.getElementById('categoryFilter');

            const startDate = document.getElementById('startDate');
            const endDate = document.getElementById('endDate');

            const rows = document.querySelectorAll('.expense-row');
            const noResults = document.getElementById('noResults');
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

                resultCount.textContent = `Showing ${visibleCount} sample records`;

            }

            searchInput.addEventListener('input', filterExpenses);
            categoryFilter.addEventListener('change', filterExpenses);

            startDate.addEventListener('change', filterExpenses);
            endDate.addEventListener('change', filterExpenses);

        });
    </script>

@endsection

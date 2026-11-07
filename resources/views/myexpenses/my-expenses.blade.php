 @extends('admin.layouts.app')

 @section('title', 'My Expenses')

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
                     <span class="font-semibold text-blue-600">My Expenses</span>
                 </div>

                 <h1 class="text-2xl font-extrabold tracking-tight text-slate-800 md:text-3xl">
                     My Expenses
                 </h1>

                 <p class="mt-2 text-sm text-slate-500">
                     View and manage all the expenses recorded by you.
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
                         <p class="text-sm font-medium text-slate-500">My Total Expenses</p>
                         <h3 class="mt-3 text-2xl font-bold tracking-tight text-slate-800">
                             ৳ 32,450
                         </h3>
                         <p class="mt-2 text-xs font-medium text-slate-400">
                             Overall spending
                         </p>
                     </div>

                     <div
                         class="flex h-12 w-12 items-center justify-center rounded-xl bg-blue-50 text-blue-600 transition-colors group-hover:bg-blue-600 group-hover:text-white">
                         <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                             <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                 d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8V6m0 2v8m0 0v2m0-2c-1.2 0-2.266-.39-2.83-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                         </svg>
                     </div>
                 </div>
                 <div class="absolute bottom-0 left-0 h-1 w-full bg-blue-500"></div>
             </div>

             {{-- Monthly Expenses --}}
             <div
                 class="group relative overflow-hidden rounded-2xl border border-slate-200 bg-white p-5 shadow-sm transition-all duration-300 hover:-translate-y-1 hover:border-violet-200 hover:shadow-lg">
                 <div class="flex items-start justify-between">
                     <div>
                         <p class="text-sm font-medium text-slate-500">This Month</p>
                         <h3 class="mt-3 text-2xl font-bold tracking-tight text-slate-800">
                             ৳ 12,500
                         </h3>
                         <p class="mt-2 text-xs font-medium text-slate-400">
                             Current month spending
                         </p>
                     </div>

                     <div
                         class="flex h-12 w-12 items-center justify-center rounded-xl bg-violet-50 text-violet-600 transition-colors group-hover:bg-violet-600 group-hover:text-white">
                         <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                             <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                 d="M8 7V3m8 4V3M4 11h16M5 5h14a1 1 0 011 1v14H4V6a1 1 0 011-1z" />
                         </svg>
                     </div>
                 </div>
                 <div class="absolute bottom-0 left-0 h-1 w-full bg-violet-500"></div>
             </div>

             {{-- Total Records --}}
             <div
                 class="group relative overflow-hidden rounded-2xl border border-slate-200 bg-white p-5 shadow-sm transition-all duration-300 hover:-translate-y-1 hover:border-emerald-200 hover:shadow-lg">
                 <div class="flex items-start justify-between">
                     <div>
                         <p class="text-sm font-medium text-slate-500">Total Records</p>
                         <h3 class="mt-3 text-2xl font-bold tracking-tight text-slate-800">
                             18
                         </h3>
                         <p class="mt-2 text-xs font-medium text-slate-400">
                             My expense records
                         </p>
                     </div>

                     <div
                         class="flex h-12 w-12 items-center justify-center rounded-xl bg-emerald-50 text-emerald-600 transition-colors group-hover:bg-emerald-600 group-hover:text-white">
                         <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                             <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                 d="M8 6h13M8 12h13M8 18h13M3 6h.01M3 12h.01M3 18h.01" />
                         </svg>
                     </div>
                 </div>
                 <div class="absolute bottom-0 left-0 h-1 w-full bg-emerald-500"></div>
             </div>

             {{-- Average Expense --}}
             <div
                 class="group relative overflow-hidden rounded-2xl border border-slate-200 bg-white p-5 shadow-sm transition-all duration-300 hover:-translate-y-1 hover:border-amber-200 hover:shadow-lg">
                 <div class="flex items-start justify-between">
                     <div>
                         <p class="text-sm font-medium text-slate-500">Average Expense</p>
                         <h3 class="mt-3 text-2xl font-bold tracking-tight text-slate-800">
                             ৳ 1,803
                         </h3>
                         <p class="mt-2 text-xs font-medium text-slate-400">
                             Average per record
                         </p>
                     </div>

                     <div
                         class="flex h-12 w-12 items-center justify-center rounded-xl bg-amber-50 text-amber-600 transition-colors group-hover:bg-amber-500 group-hover:text-white">
                         <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                             <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                 d="M3 3v18h18M18 17V9m-5 8V5m-5 12v-4" />
                         </svg>
                     </div>
                 </div>
                 <div class="absolute bottom-0 left-0 h-1 w-full bg-amber-500"></div>
             </div>

         </div>







         {{-- Expense Records --}}
         <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">

             {{-- Table Header --}}
             <div
                 class="flex flex-col justify-between gap-4 border-b border-slate-100 p-5 md:flex-row md:items-center md:px-6">

                 <div>
                     <h2 class="text-lg font-bold text-slate-800">
                         My Expense History
                     </h2>
                     <p class="mt-1 text-xs text-slate-400">
                         Manage your personal expense records.
                     </p>
                 </div>

                 {{-- <button type="button" onclick="alert('Export functionality will be added later.')"
                     class="rounded-xl border border-slate-200 px-4 py-2.5 text-sm font-semibold text-slate-600 transition hover:bg-slate-50">
                     ↓ Export My Expenses
                 </button> --}}

             </div>


             {{-- Search and Filters --}}
             {{-- My Expenses: filters + table + pagination (single self-contained file) --}}
             <div class="overflow-hidden rounded-xl bg-white shadow-sm ring-1 ring-slate-200">

                 {{-- Filters --}}
                 <div class="border-b border-slate-100 bg-white p-5 md:px-6">
                     <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-4">

                         {{-- From Date --}}
                         <div>
                             <label for="myStartDate" class="mb-2 block text-xs font-semibold text-slate-500">
                                 From Date
                             </label>
                             <input type="date" id="myStartDate"
                                 class="h-12 w-full rounded-xl border border-slate-200 bg-slate-50 px-4 text-sm text-slate-600 outline-none transition hover:border-slate-300 focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-500/10">
                         </div>

                         {{-- To Date --}}
                         <div>
                             <label for="myEndDate" class="mb-2 block text-xs font-semibold text-slate-500">
                                 To Date
                             </label>
                             <input type="date" id="myEndDate"
                                 class="h-12 w-full rounded-xl border border-slate-200 bg-slate-50 px-4 text-sm text-slate-600 outline-none transition hover:border-slate-300 focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-500/10">
                         </div>

                         {{-- Search --}}
                         <div>
                             <label for="myExpenseSearch" class="mb-2 block text-xs font-semibold text-slate-500">
                                 Search Expenses
                             </label>

                             <div class="relative">
                                 <svg class="absolute left-4 top-1/2 h-5 w-5 -translate-y-1/2 text-slate-400" fill="none"
                                     stroke="currentColor" viewBox="0 0 24 24">
                                     <circle cx="11" cy="11" r="7" stroke-width="1.8" />
                                     <path stroke-linecap="round" stroke-width="1.8" d="m16 16 4 4" />
                                 </svg>

                                 <input type="search" id="myExpenseSearch" placeholder="Search my expenses..."
                                     class="h-12 w-full rounded-xl border border-slate-200 bg-slate-50 py-3 pl-11 pr-4 text-sm outline-none transition hover:border-slate-300 focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-500/10">
                             </div>
                         </div>

                         {{-- Category --}}
                         <div>
                             <label for="myCategoryFilter" class="mb-2 block text-xs font-semibold text-slate-500">
                                 Category
                             </label>

                             <select id="myCategoryFilter"
                                 class="h-12 w-full rounded-xl border border-slate-200 bg-slate-50 px-4 text-sm text-slate-600 outline-none transition hover:border-slate-300 focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-500/10">
                                 <option value="">All Categories</option>
                                 <option value="office supplies">Office Supplies</option>
                                 <option value="food & drinks">Food & Drinks</option>
                                 <option value="transportation">Transportation</option>
                                 <option value="internet & hosting">Internet & Hosting</option>
                                 <option value="utilities">Utilities</option>
                             </select>
                         </div>

                     </div>
                 </div>






                 {{-- Responsive Table --}}
                 <div class="overflow-x-auto">
                     <table class="w-full min-w-[850px] text-left">

                         {{-- Table Header --}}
                         {{-- Table Header --}}
                         <thead class="border-b border-slate-200 bg-slate-100">
                             <tr class="text-xs font-bold uppercase tracking-wider text-slate-600">

                                 {{-- Expense Details --}}
                                 <th class="px-6 py-4">
                                     <div class="flex items-center gap-2">

                                         <span>Expense Details</span>
                                     </div>
                                 </th>

                                 {{-- Category --}}
                                 <th class="px-6 py-4">
                                     <div class="flex items-center gap-2">

                                         <span>Category</span>
                                     </div>
                                 </th>

                                 {{-- Date --}}
                                 <th class="px-6 py-4">
                                     <div class="flex items-center gap-2">

                                         <span>Date</span>
                                     </div>
                                 </th>

                                 {{-- Payment Method --}}
                                 <th class="px-6 py-4">
                                     <div class="flex items-center gap-2">

                                         <span>Payment Method</span>
                                     </div>
                                 </th>

                                 {{-- Amount --}}
                                 <th class="px-6 py-4 text-right">
                                     <div class="flex items-center justify-end gap-2">

                                         <span>Amount</span>
                                     </div>
                                 </th>

                                 {{-- Actions --}}
                                 <th class="px-6 py-4 text-center">
                                     <div class="flex items-center justify-center gap-2">

                                         <span>Actions</span>
                                     </div>
                                 </th>

                             </tr>
                         </thead>

                         <tbody id="myExpenseTable" class="divide-y divide-slate-100 text-sm">

                             {{-- Expense 1 --}}
                             <tr class="my-expense-row transition-colors hover:bg-slate-50/70"
                                 data-search="office supplies stationery abc stationery shop"
                                 data-category="office supplies" data-date="2026-11-03">
                                 <td class="px-6 py-4">
                                     <p class="font-medium text-slate-900">Office Supplies</p>
                                     <p class="mt-0.5 text-xs text-slate-500">ABC Stationery Shop</p>
                                 </td>
                                 <td class="px-6 py-4">
                                     <span
                                         class="inline-flex items-center gap-1.5 rounded-full bg-blue-50 px-2.5 py-1 text-xs font-medium text-blue-700 ring-1 ring-inset ring-blue-600/15">
                                         <span class="h-1.5 w-1.5 rounded-full bg-blue-500"></span>Office Supplies
                                     </span>
                                 </td>
                                 <td class="px-6 py-4 text-slate-600">03 Nov 2026</td>
                                 <td class="px-6 py-4 text-slate-600">Cash</td>
                                 <td class="px-6 py-4 text-right font-semibold tabular-nums text-slate-900">৳ 2,500</td>
                                 <td class="px-6 py-4">
                                     <div class="flex items-center justify-center gap-1">
                                         <button type="button" onclick="alert('View details coming soon.')"
                                             title="View" aria-label="View"
                                             class="rounded-lg p-2 text-slate-400 transition hover:bg-blue-50 hover:text-blue-600">
                                             <svg class="h-4 w-4" fill="none" stroke="currentColor"
                                                 viewBox="0 0 24 24" aria-hidden="true">
                                                 <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                                     d="M2.5 12S6 5 12 5s9.5 7 9.5 7-3.5 7-9.5 7-9.5-7-9.5-7z" />
                                                 <circle cx="12" cy="12" r="2.8" stroke-width="1.8" />
                                             </svg>
                                         </button>
                                         <button type="button" onclick="alert('Edit functionality coming soon.')"
                                             title="Edit" aria-label="Edit"
                                             class="rounded-lg p-2 text-slate-400 transition hover:bg-amber-50 hover:text-amber-600">
                                             <svg class="h-4 w-4" fill="none" stroke="currentColor"
                                                 viewBox="0 0 24 24" aria-hidden="true">
                                                 <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                                     d="M16.9 4.1a2.1 2.1 0 113 3L8 19l-4 1 1-4L16.9 4.1z" />
                                             </svg>
                                         </button>
                                         <button type="button" onclick="alert('Delete functionality coming soon.')"
                                             title="Delete" aria-label="Delete"
                                             class="rounded-lg p-2 text-slate-400 transition hover:bg-red-50 hover:text-red-600">
                                             <svg class="h-4 w-4" fill="none" stroke="currentColor"
                                                 viewBox="0 0 24 24" aria-hidden="true">
                                                 <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                                     d="M4 7h16M10 11v6m4-6v6M6 7l1 12a2 2 0 002 2h6a2 2 0 002-2l1-12M9 7V4h6v3" />
                                             </svg>
                                         </button>
                                     </div>
                                 </td>
                             </tr>

                             {{-- Expense 2 --}}
                             <tr class="my-expense-row transition-colors hover:bg-slate-50/70"
                                 data-search="internet bill broadband provider" data-category="internet & hosting"
                                 data-date="2026-11-02">
                                 <td class="px-6 py-4">
                                     <p class="font-medium text-slate-900">Internet Bill</p>
                                     <p class="mt-0.5 text-xs text-slate-500">Broadband Provider</p>
                                 </td>
                                 <td class="px-6 py-4">
                                     <span
                                         class="inline-flex items-center gap-1.5 rounded-full bg-violet-50 px-2.5 py-1 text-xs font-medium text-violet-700 ring-1 ring-inset ring-violet-600/15">
                                         <span class="h-1.5 w-1.5 rounded-full bg-violet-500"></span>Internet &amp; Hosting
                                     </span>
                                 </td>
                                 <td class="px-6 py-4 text-slate-600">02 Nov 2026</td>
                                 <td class="px-6 py-4 text-slate-600">Mobile Banking</td>
                                 <td class="px-6 py-4 text-right font-semibold tabular-nums text-slate-900">৳ 1,200</td>
                                 <td class="px-6 py-4">
                                     <div class="flex items-center justify-center gap-1">
                                         <button type="button" onclick="alert('View details coming soon.')"
                                             title="View" aria-label="View"
                                             class="rounded-lg p-2 text-slate-400 transition hover:bg-blue-50 hover:text-blue-600">
                                             <svg class="h-4 w-4" fill="none" stroke="currentColor"
                                                 viewBox="0 0 24 24" aria-hidden="true">
                                                 <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                                     d="M2.5 12S6 5 12 5s9.5 7 9.5 7-3.5 7-9.5 7-9.5-7-9.5-7z" />
                                                 <circle cx="12" cy="12" r="2.8" stroke-width="1.8" />
                                             </svg>
                                         </button>
                                         <button type="button" onclick="alert('Edit functionality coming soon.')"
                                             title="Edit" aria-label="Edit"
                                             class="rounded-lg p-2 text-slate-400 transition hover:bg-amber-50 hover:text-amber-600">
                                             <svg class="h-4 w-4" fill="none" stroke="currentColor"
                                                 viewBox="0 0 24 24" aria-hidden="true">
                                                 <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                                     d="M16.9 4.1a2.1 2.1 0 113 3L8 19l-4 1 1-4L16.9 4.1z" />
                                             </svg>
                                         </button>
                                         <button type="button" onclick="alert('Delete functionality coming soon.')"
                                             title="Delete" aria-label="Delete"
                                             class="rounded-lg p-2 text-slate-400 transition hover:bg-red-50 hover:text-red-600">
                                             <svg class="h-4 w-4" fill="none" stroke="currentColor"
                                                 viewBox="0 0 24 24" aria-hidden="true">
                                                 <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                                     d="M4 7h16M10 11v6m4-6v6M6 7l1 12a2 2 0 002 2h6a2 2 0 002-2l1-12M9 7V4h6v3" />
                                             </svg>
                                         </button>
                                     </div>
                                 </td>
                             </tr>

                             {{-- Expense 3 --}}
                             <tr class="my-expense-row transition-colors hover:bg-slate-50/70"
                                 data-search="team lunch local restaurant food" data-category="food & drinks"
                                 data-date="2026-11-01">
                                 <td class="px-6 py-4">
                                     <p class="font-medium text-slate-900">Team Lunch</p>
                                     <p class="mt-0.5 text-xs text-slate-500">Local Restaurant</p>
                                 </td>
                                 <td class="px-6 py-4">
                                     <span
                                         class="inline-flex items-center gap-1.5 rounded-full bg-orange-50 px-2.5 py-1 text-xs font-medium text-orange-700 ring-1 ring-inset ring-orange-600/15">
                                         <span class="h-1.5 w-1.5 rounded-full bg-orange-500"></span>Food &amp; Drinks
                                     </span>
                                 </td>
                                 <td class="px-6 py-4 text-slate-600">01 Nov 2026</td>
                                 <td class="px-6 py-4 text-slate-600">Cash</td>
                                 <td class="px-6 py-4 text-right font-semibold tabular-nums text-slate-900">৳ 3,500</td>
                                 <td class="px-6 py-4">
                                     <div class="flex items-center justify-center gap-1">
                                         <button type="button" onclick="alert('View details coming soon.')"
                                             title="View" aria-label="View"
                                             class="rounded-lg p-2 text-slate-400 transition hover:bg-blue-50 hover:text-blue-600">
                                             <svg class="h-4 w-4" fill="none" stroke="currentColor"
                                                 viewBox="0 0 24 24" aria-hidden="true">
                                                 <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                                     d="M2.5 12S6 5 12 5s9.5 7 9.5 7-3.5 7-9.5 7-9.5-7-9.5-7z" />
                                                 <circle cx="12" cy="12" r="2.8" stroke-width="1.8" />
                                             </svg>
                                         </button>
                                         <button type="button" onclick="alert('Edit functionality coming soon.')"
                                             title="Edit" aria-label="Edit"
                                             class="rounded-lg p-2 text-slate-400 transition hover:bg-amber-50 hover:text-amber-600">
                                             <svg class="h-4 w-4" fill="none" stroke="currentColor"
                                                 viewBox="0 0 24 24" aria-hidden="true">
                                                 <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                                     d="M16.9 4.1a2.1 2.1 0 113 3L8 19l-4 1 1-4L16.9 4.1z" />
                                             </svg>
                                         </button>
                                         <button type="button" onclick="alert('Delete functionality coming soon.')"
                                             title="Delete" aria-label="Delete"
                                             class="rounded-lg p-2 text-slate-400 transition hover:bg-red-50 hover:text-red-600">
                                             <svg class="h-4 w-4" fill="none" stroke="currentColor"
                                                 viewBox="0 0 24 24" aria-hidden="true">
                                                 <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                                     d="M4 7h16M10 11v6m4-6v6M6 7l1 12a2 2 0 002 2h6a2 2 0 002-2l1-12M9 7V4h6v3" />
                                             </svg>
                                         </button>
                                     </div>
                                 </td>
                             </tr>

                             {{-- Expense 4 --}}
                             <tr class="my-expense-row transition-colors hover:bg-slate-50/70"
                                 data-search="electricity bill office utility" data-category="utilities"
                                 data-date="2026-10-29">
                                 <td class="px-6 py-4">
                                     <p class="font-medium text-slate-900">Electricity Bill</p>
                                     <p class="mt-0.5 text-xs text-slate-500">Office Utility</p>
                                 </td>
                                 <td class="px-6 py-4">
                                     <span
                                         class="inline-flex items-center gap-1.5 rounded-full bg-emerald-50 px-2.5 py-1 text-xs font-medium text-emerald-700 ring-1 ring-inset ring-emerald-600/15">
                                         <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>Utilities
                                     </span>
                                 </td>
                                 <td class="px-6 py-4 text-slate-600">29 Oct 2026</td>
                                 <td class="px-6 py-4 text-slate-600">Bank Transfer</td>
                                 <td class="px-6 py-4 text-right font-semibold tabular-nums text-slate-900">৳ 4,800</td>
                                 <td class="px-6 py-4">
                                     <div class="flex items-center justify-center gap-1">
                                         <button type="button" onclick="alert('View details coming soon.')"
                                             title="View" aria-label="View"
                                             class="rounded-lg p-2 text-slate-400 transition hover:bg-blue-50 hover:text-blue-600">
                                             <svg class="h-4 w-4" fill="none" stroke="currentColor"
                                                 viewBox="0 0 24 24" aria-hidden="true">
                                                 <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                                     d="M2.5 12S6 5 12 5s9.5 7 9.5 7-3.5 7-9.5 7-9.5-7-9.5-7z" />
                                                 <circle cx="12" cy="12" r="2.8" stroke-width="1.8" />
                                             </svg>
                                         </button>
                                         <button type="button" onclick="alert('Edit functionality coming soon.')"
                                             title="Edit" aria-label="Edit"
                                             class="rounded-lg p-2 text-slate-400 transition hover:bg-amber-50 hover:text-amber-600">
                                             <svg class="h-4 w-4" fill="none" stroke="currentColor"
                                                 viewBox="0 0 24 24" aria-hidden="true">
                                                 <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                                     d="M16.9 4.1a2.1 2.1 0 113 3L8 19l-4 1 1-4L16.9 4.1z" />
                                             </svg>
                                         </button>
                                         <button type="button" onclick="alert('Delete functionality coming soon.')"
                                             title="Delete" aria-label="Delete"
                                             class="rounded-lg p-2 text-slate-400 transition hover:bg-red-50 hover:text-red-600">
                                             <svg class="h-4 w-4" fill="none" stroke="currentColor"
                                                 viewBox="0 0 24 24" aria-hidden="true">
                                                 <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                                     d="M4 7h16M10 11v6m4-6v6M6 7l1 12a2 2 0 002 2h6a2 2 0 002-2l1-12M9 7V4h6v3" />
                                             </svg>
                                         </button>
                                     </div>
                                 </td>
                             </tr>

                             {{-- No Results --}}
                             <tr id="myNoResults" class="hidden">
                                 <td colspan="6" class="px-6 py-14 text-center">
                                     <p class="text-sm font-medium text-slate-700">No matching expenses found</p>
                                     <p class="mt-1 text-xs text-slate-400">Try changing your search or filters.</p>
                                 </td>
                             </tr>
                         </tbody>
                     </table>
                 </div>

                 {{-- Pagination --}}
                 <div
                     class="flex flex-col items-center justify-between gap-3 border-t border-slate-200 bg-white px-6 py-4 sm:flex-row">
                     <p id="myResultCount" class="text-sm text-slate-600"></p>
                     <nav id="myPagination" class="flex items-center gap-1" aria-label="Pagination"></nav>
                 </div>
             </div>

             <script>
                 (function() {
                     const PER_PAGE =
                         2; // rows per page (set to 2 so the page numbers show with 4 sample rows; use 10 for real data)
                     const rows = Array.from(document.querySelectorAll('.my-expense-row'));
                     const search = document.getElementById('myExpenseSearch');
                     const category = document.getElementById('myCategoryFilter');
                     const date = document.getElementById('myDateFilter');
                     const noResults = document.getElementById('myNoResults');
                     const count = document.getElementById('myResultCount');
                     const pager = document.getElementById('myPagination');
                     let page = 1;

                     const base =
                         'inline-flex h-9 min-w-[2.25rem] items-center justify-center rounded-lg px-3 text-sm font-medium transition ';
                     const idle = base + 'text-slate-600 hover:bg-slate-100';
                     const active = base + 'bg-blue-600 text-white shadow-sm';
                     const off = base + 'cursor-not-allowed text-slate-300';

                     function matches(row) {
                         const q = search.value.trim().toLowerCase();
                         return (!q || row.dataset.search.includes(q) || row.textContent.toLowerCase().includes(q)) &&
                             (!category.value || row.dataset.category === category.value) &&
                             (!date.value || row.dataset.date === date.value);
                     }

                     function render() {
                         const filtered = rows.filter(matches);
                         const pages = Math.max(1, Math.ceil(filtered.length / PER_PAGE));
                         page = Math.min(page, pages);
                         const start = (page - 1) * PER_PAGE;

                         rows.forEach(r => r.classList.add('hidden'));
                         filtered.slice(start, start + PER_PAGE).forEach(r => r.classList.remove('hidden'));
                         noResults.classList.toggle('hidden', filtered.length > 0);

                         count.textContent = filtered.length ?
                             `Showing ${start + 1} to ${Math.min(start + PER_PAGE, filtered.length)} of ${filtered.length} results` :
                             'No results';

                         pager.innerHTML = '';
                         const add = (label, target, cls, disabled) => {
                             const b = document.createElement('button');
                             b.type = 'button';
                             b.textContent = label;
                             b.className = cls;
                             if (disabled) b.disabled = true;
                             else b.addEventListener('click', () => {
                                 page = target;
                                 render();
                             });
                             pager.appendChild(b);
                         };
                         add('Previous', page - 1, page === 1 ? off : idle, page === 1);
                         for (let i = 1; i <= pages; i++) add(String(i), i, i === page ? active : idle, false);
                         add('Next', page + 1, page === pages ? off : idle, page === pages);
                     }

                     [search, category, date].forEach(el => el.addEventListener('input', () => {
                         page = 1;
                         render();
                     }));
                     render();
                 })();
             </script>



         </div>


         {{-- Search and Filter Functionality --}}
         <script>
             document.addEventListener('DOMContentLoaded', function() {

                 const searchInput = document.getElementById('myExpenseSearch');
                 const categoryFilter = document.getElementById('myCategoryFilter');
                 const dateFilter = document.getElementById('myDateFilter');

                 const rows = document.querySelectorAll('.my-expense-row');
                 const noResults = document.getElementById('myNoResults');
                 const resultCount = document.getElementById('myResultCount');

                 function filterExpenses() {

                     const search = searchInput.value.toLowerCase().trim();
                     const category = categoryFilter.value.toLowerCase();
                     const date = dateFilter.value;

                     let visibleCount = 0;

                     rows.forEach(function(row) {

                         const searchData = row.dataset.search.toLowerCase();
                         const rowCategory = row.dataset.category.toLowerCase();
                         const rowDate = row.dataset.date;

                         const matchesSearch = searchData.includes(search);
                         const matchesCategory = !category || rowCategory === category;
                         const matchesDate = !date || rowDate === date;

                         const isVisible = matchesSearch && matchesCategory && matchesDate;

                         row.classList.toggle('hidden', !isVisible);

                         if (isVisible) {
                             visibleCount++;
                         }
                     });

                     noResults.classList.toggle('hidden', visibleCount > 0);

                     resultCount.textContent = `Showing ${visibleCount} sample records`;
                 }

                 searchInput.addEventListener('input', filterExpenses);
                 categoryFilter.addEventListener('change', filterExpenses);
                 dateFilter.addEventListener('change', filterExpenses);

             });
         </script>

     @endsection

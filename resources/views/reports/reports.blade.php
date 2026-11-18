@extends('admin.layouts.app')

@section('title', 'Expense Reports')

@section('content')

    @php
        $expenseData = $expenses->map(function ($expense) {
            return [
                'title' => $expense->title,
                'id' => $expense->id,
                'category' => $expense->category,
                'date' => $expense->expense_date->toDateString(),
                'payment' => $expense->payment_method ?? '',
                'amount' => (float) $expense->amount,
                'receipt' => $expense->receiptUrl() ?? '',
            ];
        })->values();
    @endphp

    <div class="mx-auto max-w-7xl space-y-7">

        {{-- Page Header --}}
        <div class="flex flex-col justify-between gap-4 sm:flex-row sm:items-center">

            <div>
                <div class="mb-3 flex items-center gap-2 text-sm text-slate-400">
                    <a href="{{ route('admin.dashboard') }}" class="hover:text-blue-600 dark:hover:text-blue-400">
                        Dashboard
                    </a>
                    <span>/</span>
                    <span class="font-semibold text-blue-600 dark:text-blue-400">Reports</span>
                </div>

                <h1 class="text-2xl font-extrabold tracking-tight text-slate-800 md:text-3xl dark:text-slate-100">
                    Expense Reports
                </h1>

                <p class="mt-2 text-sm text-slate-500 dark:text-slate-400">
                    Analyze your expenses and monitor your financial activities.
                </p>
            </div>

            <div class="flex flex-wrap gap-3">

                {{-- <button type="button" onclick="window.print()"
                    class="inline-flex items-center justify-center gap-2 rounded-xl border border-slate-200 bg-white px-5 py-3 text-sm font-semibold text-slate-600 shadow-sm transition hover:bg-slate-50 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-300 dark:hover:bg-slate-800">
                    <span>⎙</span>
                    Print Report
                </button> --}}

                <button type="button" onclick="downloadExpenseReport()"
                    class="inline-flex items-center justify-center gap-2 rounded-xl bg-blue-600 px-5 py-3 text-sm font-semibold text-white shadow-lg shadow-blue-600/20 transition hover:bg-blue-700">
                    <span>↓</span>
                    Download Report
                </button>

            </div>

        </div>


        {{-- Summary Cards --}}
        <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 xl:grid-cols-4">

            {{-- Total Expense --}}
            <div
                class="group relative overflow-hidden rounded-2xl border border-slate-200 bg-white p-5 shadow-sm transition-all duration-300 hover:-translate-y-1 hover:border-blue-200 hover:shadow-lg dark:border-slate-700 dark:bg-slate-900 dark:hover:border-blue-500/40">

                <div class="flex items-start justify-between">
                    <div>
                        <p class="text-sm font-medium text-slate-500 dark:text-slate-400">
                            Total Expenses
                        </p>

                        <h3 id="totalExpense" class="mt-3 text-2xl font-bold tracking-tight text-slate-800 dark:text-slate-100">
                            ৳ 0
                        </h3>

                        <p class="mt-2 text-xs font-medium text-slate-400">
                            Selected period
                        </p>
                    </div>

                    <div
                        class="flex h-12 w-12 items-center justify-center rounded-xl bg-blue-50 text-2xl font-semibold text-blue-600 transition-colors duration-300 group-hover:bg-blue-600 group-hover:text-white dark:bg-blue-500/10 dark:text-blue-400">
                        ৳
                    </div>
                </div>

                <div class="absolute bottom-0 left-0 h-1 w-full bg-blue-500"></div>
            </div>


            {{-- Total Transactions --}}
            <div
                class="group relative overflow-hidden rounded-2xl border border-slate-200 bg-white p-5 shadow-sm transition-all duration-300 hover:-translate-y-1 hover:border-violet-200 hover:shadow-lg dark:border-slate-700 dark:bg-slate-900 dark:hover:border-violet-500/40">

                <div class="flex items-start justify-between">
                    <div>
                        <p class="text-sm font-medium text-slate-500 dark:text-slate-400">
                            Total Transactions
                        </p>

                        <h3 id="totalTransactions" class="mt-3 text-2xl font-bold tracking-tight text-slate-800 dark:text-slate-100">
                            0
                        </h3>

                        <p class="mt-2 text-xs font-medium text-slate-400">
                            Expense records
                        </p>
                    </div>

                    <div
                        class="flex h-12 w-12 items-center justify-center rounded-xl bg-violet-50 text-2xl text-violet-600 transition-colors duration-300 group-hover:bg-violet-600 group-hover:text-white dark:bg-violet-500/10 dark:text-violet-400">
                        ▤
                    </div>
                </div>

                <div class="absolute bottom-0 left-0 h-1 w-full bg-violet-500"></div>
            </div>


            {{-- Average Expense --}}
            <div
                class="group relative overflow-hidden rounded-2xl border border-slate-200 bg-white p-5 shadow-sm transition-all duration-300 hover:-translate-y-1 hover:border-amber-200 hover:shadow-lg dark:border-slate-700 dark:bg-slate-900 dark:hover:border-amber-500/40">

                <div class="flex items-start justify-between">
                    <div>
                        <p class="text-sm font-medium text-slate-500 dark:text-slate-400">
                            Average Expense
                        </p>

                        <h3 id="averageExpense" class="mt-3 text-2xl font-bold tracking-tight text-slate-800 dark:text-slate-100">
                            ৳ 0
                        </h3>

                        <p class="mt-2 text-xs font-medium text-slate-400">
                            Per transaction
                        </p>
                    </div>

                    <div
                        class="flex h-12 w-12 items-center justify-center rounded-xl bg-amber-50 text-2xl text-amber-600 transition-colors duration-300 group-hover:bg-amber-500 group-hover:text-white dark:bg-amber-500/10 dark:text-amber-400">
                        ↗
                    </div>
                </div>

                <div class="absolute bottom-0 left-0 h-1 w-full bg-amber-500"></div>
            </div>


            {{-- Highest Expense --}}
            <div
                class="group relative overflow-hidden rounded-2xl border border-slate-200 bg-white p-5 shadow-sm transition-all duration-300 hover:-translate-y-1 hover:border-red-200 hover:shadow-lg dark:border-slate-700 dark:bg-slate-900 dark:hover:border-red-500/40">

                <div class="flex items-start justify-between">
                    <div>
                        <p class="text-sm font-medium text-slate-500 dark:text-slate-400">
                            Highest Expense
                        </p>

                        <h3 id="highestExpense" class="mt-3 text-2xl font-bold tracking-tight text-slate-800 dark:text-slate-100">
                            ৳ 0
                        </h3>

                        <p class="mt-2 text-xs font-medium text-slate-400">
                            Single transaction
                        </p>
                    </div>

                    <div
                        class="flex h-12 w-12 items-center justify-center rounded-xl bg-red-50 text-2xl text-red-500 transition-colors duration-300 group-hover:bg-red-500 group-hover:text-white dark:bg-red-500/10">
                        ↑
                    </div>
                </div>

                <div class="absolute bottom-0 left-0 h-1 w-full bg-red-500"></div>
            </div>

        </div>


        {{-- Report Filters --}}
        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm dark:border-slate-700 dark:bg-slate-900">

            <div class="mb-4">
                <h2 class="font-bold text-slate-800 dark:text-slate-100">
                    Report Filters
                </h2>

                <p class="mt-1 text-xs text-slate-400">
                    Select a date range and category to filter report data.
                </p>
            </div>

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
                    class="h-[46px] rounded-xl border border-blue-200 bg-white px-4 text-sm font-semibold text-blue-700 shadow-sm transition duration-200 hover:border-blue-600 hover:bg-blue-600 hover:text-white hover:shadow-md hover:shadow-blue-600/20 active:scale-95 dark:border-slate-600 dark:bg-slate-900 dark:text-blue-300 dark:hover:border-blue-500 dark:hover:bg-blue-600 dark:hover:text-white">
                    Apply Filters
                </button>

            </div>

        </div>


        {{-- Expense Details Table --}}
        <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm dark:border-slate-700 dark:bg-slate-900">

            <div
                class="flex flex-col justify-between gap-3 border-b border-slate-100 p-5 sm:flex-row sm:items-center sm:px-6 dark:border-slate-800">

                <div>
                    <h2 class="font-bold text-slate-800 dark:text-slate-100">
                        Expense Report Details
                    </h2>

                    <p class="mt-1 text-xs text-slate-400">
                        Detailed transaction summary.
                    </p>
                </div>

            </div>


            <div class="overflow-x-auto">

                <table class="w-full min-w-[750px] text-left">

                    <thead class="bg-slate-50 dark:bg-slate-800">

                        <tr class="text-sm font-exbold uppercase tracking-wider text-black dark:text-slate-200">

                            <th class="px-6 py-4">Expense Title</th>
                            <th class="px-6 py-4">Category</th>
                            <th class="px-6 py-4">Date</th>
                            <th class="px-6 py-4">Payment Method</th>
                            <th class="px-6 py-4">Amount</th>
                            <th class="px-6 py-4 text-center">Receipt</th>

                        </tr>

                    </thead>

                    <tbody id="reportTableBody" class="divide-y divide-slate-100 text-sm dark:divide-slate-800">

                        @forelse ($expenses as $expense)
                            <tr class="report-row hover:bg-slate-50 dark:hover:bg-slate-800" data-expense-id="{{ $expense->id }}" data-title="{{ $expense->title }}"
                                data-category="{{ $expense->category }}" data-date="{{ $expense->expense_date->toDateString() }}"
                                data-payment="{{ $expense->payment_method ?? '' }}" data-amount="{{ $expense->amount }}">
                                <td class="px-6 py-5 font-semibold text-slate-800 dark:text-slate-100">{{ $expense->title }}</td>
                                <td class="px-6 py-5 text-slate-600 dark:text-slate-300">{{ $expense->category }}</td>
                                <td class="px-6 py-5 text-slate-600 dark:text-slate-300">{{ $expense->expense_date->format('d M Y') }}</td>
                                <td class="px-6 py-5 text-slate-600 dark:text-slate-300">{{ $expense->payment_method ?: '—' }}</td>
                                <td class="px-6 py-5 font-bold text-slate-800 dark:text-slate-100">৳ {{ number_format((float) $expense->amount, 2) }}</td>
                                <td class="px-6 py-3 text-center">@include('components.admin.receipt-thumbnail')</td>
                            </tr>
                        @empty
                            <tr><td colspan="6" class="px-6 py-12 text-center text-slate-400">No expenses have been added yet.</td></tr>
                        @endforelse


                        <tr id="noReportResults" class="hidden">
                            <td colspan="6" class="px-6 py-12 text-center text-slate-400">
                                No matching report records found.
                            </td>
                        </tr>

                    </tbody>

                </table>

            </div>

            {{-- Table Footer & Pagination --}}
            <div
                class="flex flex-col justify-between gap-4 border-t border-slate-100 px-6 py-4 sm:flex-row sm:items-center dark:border-slate-800">

                <p id="reportCount" class="text-xs text-slate-500 dark:text-slate-400">
                    Showing 0 of 0 records
                </p>

                <div id="reportPagination" class="flex items-center justify-end gap-2">

                    <button type="button" id="prevPage"
                        class="rounded-lg border border-slate-200 px-3 py-2 text-sm font-medium text-slate-600 transition hover:bg-slate-50 disabled:cursor-not-allowed disabled:opacity-40 dark:border-slate-700 dark:text-slate-300 dark:hover:bg-slate-800">
                        Previous
                    </button>

                    <div id="pageNumbers" class="flex items-center gap-1"></div>

                    <button type="button" id="nextPage"
                        class="rounded-lg border border-slate-200 px-3 py-2 text-sm font-medium text-slate-600 transition hover:bg-slate-50 disabled:cursor-not-allowed disabled:opacity-40 dark:border-slate-700 dark:text-slate-300 dark:hover:bg-slate-800">
                        Next
                    </button>

                </div>

            </div>

        </div>

    </div>

    @include('components.admin.receipt-modal')

@endsection


{{-- Report Scripts --}}
@push('scripts')
    <script>
        const expenseData = @json($expenseData);

        let filteredData = [...expenseData];

        // Pagination Settings
        let currentPage = 1;
        const recordsPerPage = 30;

        const money = amount =>
            '৳ ' + Number(amount).toLocaleString('en-BD');


        // Get filtered records
        function getFilteredData() {

            const start = document.getElementById('startDate').value;
            const end = document.getElementById('endDate').value;
            const category = document.getElementById('reportCategory').value;

            if (start && end && start > end) {
                alert('Start date cannot be later than end date.');
                return null;
            }

            return expenseData.filter(item => {

                const matchesStart = !start || item.date >= start;
                const matchesEnd = !end || item.date <= end;
                const matchesCategory = !category || item.category === category;

                return matchesStart && matchesEnd && matchesCategory;

            });

        }


        // Update Summary Cards
        function updateSummary(data) {

            const total = data.reduce((sum, item) => sum + item.amount, 0);

            const average = data.length ? total / data.length : 0;

            const highest = data.length ?
                Math.max(...data.map(item => item.amount)) :
                0;

            document.getElementById('totalExpense').textContent = money(total);

            document.getElementById('totalTransactions').textContent = data.length;

            document.getElementById('averageExpense').textContent = money(average);

            document.getElementById('highestExpense').textContent = money(highest);

        }


        // Update Expense Table with Pagination
        function updateTable(data) {

            const rows = document.querySelectorAll('.report-row');
            const noResults = document.getElementById('noReportResults');

            const search = document.getElementById('reportSearch').value
                .trim()
                .toLowerCase();

            // Apply search
            const searchedData = data.filter(item => {

                return (
                    item.title.toLowerCase().includes(search) ||
                    item.category.toLowerCase().includes(search) ||
                    item.date.includes(search) ||
                    item.payment.toLowerCase().includes(search) ||
                    String(item.amount).includes(search)
                );

            });

            const totalRecords = searchedData.length;
            const totalPages = Math.ceil(totalRecords / recordsPerPage);

            // Keep current page valid
            if (totalPages === 0) {
                currentPage = 1;
            } else if (currentPage > totalPages) {
                currentPage = totalPages;
            }

            const startIndex = (currentPage - 1) * recordsPerPage;
            const endIndex = startIndex + recordsPerPage;

            const currentRecords = searchedData.slice(startIndex, endIndex);

            // Show only current page records
            rows.forEach(row => {

                const exists = currentRecords.some(item => String(item.id) === row.dataset.expenseId);

                row.classList.toggle('hidden', !exists);

            });

            // No results message
            noResults.classList.toggle('hidden', totalRecords > 0);

            // Update record count
            const showingStart = totalRecords ? startIndex + 1 : 0;
            const showingEnd = Math.min(endIndex, totalRecords);

            document.getElementById('reportCount').textContent =
                `Showing ${showingStart}-${showingEnd} of ${totalRecords} records`;

            // Generate page numbers
            const pageNumbers = document.getElementById('pageNumbers');

            pageNumbers.innerHTML = '';

            for (let page = 1; page <= totalPages; page++) {

                const button = document.createElement('button');

                button.type = 'button';
                button.textContent = page;

                button.className = page === currentPage ?
                    'h-9 min-w-9 rounded-lg bg-blue-600 px-3 text-sm font-semibold text-white' :
                    'h-9 min-w-9 rounded-lg border border-slate-200 px-3 text-sm font-medium text-slate-600 transition hover:bg-slate-50 dark:border-slate-700 dark:text-slate-300 dark:hover:bg-slate-800';

                button.addEventListener('click', function() {

                    currentPage = page;
                    updateTable(filteredData);

                });

                pageNumbers.appendChild(button);

            }

            // Previous and Next buttons
            document.getElementById('prevPage').disabled =
                currentPage === 1;

            document.getElementById('nextPage').disabled =
                currentPage === totalPages || totalPages === 0;

        }


        // Apply Filters
        function applyReportFilters() {

            const data = getFilteredData();

            if (data === null) return;

            filteredData = data;

            // Reset pagination after applying filters
            currentPage = 1;

            updateSummary(data);
            updateTable(data);

        }


        // Table Search & Pagination Events
        document.addEventListener('DOMContentLoaded', function() {

            const reportSearch = document.getElementById('reportSearch');

            // Search records
            reportSearch.addEventListener('input', function() {

                currentPage = 1;
                updateTable(filteredData);

            });

            // Previous Page
            document.getElementById('prevPage').addEventListener('click', function() {

                if (currentPage > 1) {
                    currentPage--;
                    updateTable(filteredData);
                }

            });

            // Next Page
            document.getElementById('nextPage').addEventListener('click', function() {

                const search = reportSearch.value.trim().toLowerCase();

                const searchedData = filteredData.filter(item =>
                    item.title.toLowerCase().includes(search) ||
                    item.category.toLowerCase().includes(search) ||
                    item.date.includes(search) ||
                    item.payment.toLowerCase().includes(search) ||
                    String(item.amount).includes(search)
                );

                const totalPages = Math.ceil(searchedData.length / recordsPerPage);

                if (currentPage < totalPages) {
                    currentPage++;
                    updateTable(filteredData);
                }

            });

            // Load Initial Report Data
            applyReportFilters();

        });


        // Download an Excel-compatible workbook with up to 30 expenses per sheet.
        function downloadExpenseReport() {

            const search = document.getElementById('reportSearch').value
                .trim()
                .toLowerCase();

            const data = filteredData.filter(item => {

                const matchesSearch =
                    item.title.toLowerCase().includes(search) ||
                    item.category.toLowerCase().includes(search) ||
                    item.date.includes(search) ||
                    item.payment.toLowerCase().includes(search) ||
                    String(item.amount).includes(search);

                return matchesSearch;

            });

            if (!data.length) {
                alert('No expense records available to download.');
                return;
            }

            const headers = [
                'Expense Title',
                'Category',
                'Date',
                'Payment Method',
                'Amount (BDT)',
                'Receipt URL'
            ];

            const rows = data.map(item => [
                item.title,
                item.category,
                item.date,
                item.payment,
                item.amount,
                item.receipt
            ]);

            const escapeXml = value => String(value)
                .replace(/&/g, '&amp;')
                .replace(/</g, '&lt;')
                .replace(/>/g, '&gt;')
                .replace(/"/g, '&quot;')
                .replace(/'/g, '&apos;');

            const sheets = [];
            for (let index = 0; index < rows.length; index += 30) {
                const sheetRows = rows.slice(index, index + 30);
                const xmlRows = [headers, ...sheetRows].map((row, rowIndex) => {
                    const cells = row.map(value => {
                        const numeric = rowIndex > 0 && typeof value === 'number';
                        return numeric
                            ? `<Cell><Data ss:Type="Number">${value}</Data></Cell>`
                            : `<Cell><Data ss:Type="String">${escapeXml(value)}</Data></Cell>`;
                    }).join('');
                    return `<Row>${cells}</Row>`;
                }).join('');

                sheets.push(`<Worksheet ss:Name="Expenses ${sheets.length + 1}"><Table>${xmlRows}</Table></Worksheet>`);
            }

            const workbook = `<?xml version="1.0" encoding="UTF-8"?>\n` +
                `<?mso-application progid="Excel.Sheet"?>\n` +
                `<Workbook xmlns="urn:schemas-microsoft-com:office:spreadsheet" ` +
                `xmlns:o="urn:schemas-microsoft-com:office:office" ` +
                `xmlns:x="urn:schemas-microsoft-com:office:excel" ` +
                `xmlns:ss="urn:schemas-microsoft-com:office:spreadsheet" ` +
                `xmlns:html="http://www.w3.org/TR/REC-html40">${sheets.join('')}</Workbook>`;

            const blob = new Blob([workbook], {
                type: 'application/vnd.ms-excel;charset=utf-8;'
            });

            const url = URL.createObjectURL(blob);

            const link = document.createElement('a');

            link.href = url;
            link.download = 'expense-tracker-report.xls';

            document.body.appendChild(link);

            link.click();

            link.remove();

            URL.revokeObjectURL(url);

        }
    </script>
@endpush

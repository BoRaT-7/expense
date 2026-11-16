{{-- Receipt preview for an expense row. Requires components.admin.receipt-modal on the page. --}}
@if ($expense->receipt_path && $expense->hasImageReceipt())
    <button type="button"
        class="show-receipt group relative mx-auto block h-14 w-14 overflow-hidden rounded-xl border border-slate-200 bg-slate-100 shadow-sm transition hover:border-blue-400 hover:shadow-md focus:outline-none focus:ring-2 focus:ring-blue-500 dark:border-slate-700 dark:bg-slate-800"
        data-receipt-url="{{ $expense->receiptUrl() }}" data-receipt-title="{{ $expense->title }}"
        aria-label="View receipt for {{ $expense->title }}">
        <img src="{{ $expense->receiptUrl() }}" alt="Receipt for {{ $expense->title }}" loading="lazy"
            class="h-full w-full object-cover transition duration-300 group-hover:scale-110"
            onerror="this.remove()">
        <span class="absolute inset-0 flex items-center justify-center bg-slate-900/0 text-white opacity-0 transition group-hover:bg-slate-900/40 group-hover:opacity-100">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <circle cx="11" cy="11" r="7" />
                <path stroke-linecap="round" d="m16 16 4 4M11 8v6M8 11h6" />
            </svg>
        </span>
    </button>
@elseif ($expense->receipt_path)
    <a href="{{ $expense->receiptUrl() }}" target="_blank" rel="noopener"
        class="mx-auto flex h-14 w-14 flex-col items-center justify-center rounded-xl border border-red-100 bg-red-50 text-red-600 transition hover:border-red-300 hover:shadow-md dark:border-red-500/30 dark:bg-red-500/10 dark:text-red-400"
        aria-label="Open PDF receipt for {{ $expense->title }}">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
            <path stroke-linecap="round" stroke-linejoin="round" d="M7 3h7l5 5v13a1 1 0 01-1 1H7a1 1 0 01-1-1V4a1 1 0 011-1zm7 0v5h5" />
        </svg>
        <span class="mt-0.5 text-[10px] font-bold">PDF</span>
    </a>
@else
    <span class="text-xs text-slate-400">No receipt</span>
@endif

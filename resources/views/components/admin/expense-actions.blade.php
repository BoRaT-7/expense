{{--
    Edit / delete icon buttons for one expense row.
    Expects: $expense (App\Models\Expense) and $from ('all' or 'mine') — the list to return to afterwards.
--}}
@can('update', $expense)
    <div class="flex items-center justify-center gap-2">

        <a href="{{ route('admin.expenses.edit', ['expense' => $expense, 'from' => $from]) }}"
            title="Edit expense" aria-label="Edit {{ $expense->title }}"
            class="flex h-9 w-9 items-center justify-center rounded-lg bg-amber-50 text-amber-600 transition hover:-translate-y-0.5 hover:bg-amber-100 dark:bg-amber-500/10 dark:text-amber-300 dark:hover:bg-amber-500/20">
            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
            </svg>
        </a>

        <form action="{{ route('admin.expenses.destroy', $expense) }}" method="POST"
            onsubmit="return confirm('Delete this expense? This cannot be undone.');">
            @csrf
            @method('DELETE')
            <input type="hidden" name="from" value="{{ $from }}">

            <button type="submit" title="Delete expense" aria-label="Delete {{ $expense->title }}"
                class="flex h-9 w-9 items-center justify-center rounded-lg bg-red-50 text-red-600 transition hover:-translate-y-0.5 hover:bg-red-100 dark:bg-red-500/10 dark:text-red-300 dark:hover:bg-red-500/20">
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6M9 7V4a1 1 0 011-1h4a1 1 0 011 1v3M4 7h16" />
                </svg>
            </button>
        </form>

    </div>
@else
    <span title="Only the owner or the super admin can change this expense"
        class="inline-flex h-9 w-9 items-center justify-center rounded-lg bg-slate-100 text-slate-400 dark:bg-slate-800 dark:text-slate-500">
        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round"
                d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
        </svg>
        <span class="sr-only">View only</span>
    </span>
@endcan

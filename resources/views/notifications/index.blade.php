@extends('admin.layouts.app')

@section('title', 'Notifications')

@section('content')
    <div class="mx-auto max-w-5xl space-y-7">

        <!-- Page Header -->
        <div class="flex flex-col justify-between gap-4 sm:flex-row sm:items-center">
            <div>
                <div class="mb-3 flex items-center gap-2 text-sm text-slate-400">
                    <a href="{{ route('admin.dashboard') }}" class="hover:text-blue-600 dark:hover:text-blue-400">Dashboard</a>
                    <span>/</span><span class="font-semibold text-blue-600 dark:text-blue-400">Notifications</span>
                </div>
                <h1 class="text-2xl font-extrabold tracking-tight text-slate-800 md:text-3xl dark:text-slate-100">Notifications</h1>
                <p class="mt-2 text-sm text-slate-500 dark:text-slate-400">Every expense added in the last {{ $windowDays }} days, newest first.</p>
            </div>
            <a href="{{ route('admin.expenses.create') }}" class="inline-flex items-center justify-center gap-2 rounded-xl bg-blue-600 px-5 py-3 text-sm font-semibold text-white shadow-lg shadow-blue-600/20 transition hover:bg-blue-700">+ Add New Expense</a>
        </div>

        <!-- Summary -->
        <div class="grid grid-cols-1 gap-5 sm:grid-cols-3">
            @foreach ([
                ['Total Amount', '৳ ' . number_format($totalAmount, 2), "Added in the last {$windowDays} days", 'blue'],
                ['Expenses Added', number_format($totalCount), 'Across all users', 'violet'],
                ['Added by You', number_format($myCount), 'Your own submissions', 'emerald'],
            ] as [$label, $value, $caption, $color])
                <div class="relative overflow-hidden rounded-2xl border border-slate-200 bg-white p-5 shadow-sm dark:border-slate-700 dark:bg-slate-900">
                    <p class="text-sm font-medium text-slate-500 dark:text-slate-400">{{ $label }}</p>
                    <h3 class="mt-3 text-2xl font-bold tracking-tight text-slate-800 dark:text-slate-100">{{ $value }}</h3>
                    <p class="mt-2 text-xs font-medium text-slate-400">{{ $caption }}</p>
                    <div class="absolute bottom-0 left-0 h-1 w-full bg-{{ $color }}-500"></div>
                </div>
            @endforeach
        </div>

        <!-- Activity Timeline -->
        <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm dark:border-slate-700 dark:bg-slate-900">
            @forelse ($groupedNotifications as $date => $dayNotifications)
                @php
                    $day = \Illuminate\Support\Carbon::parse($date);
                    $dayLabel = $day->isToday() ? 'Today' : ($day->isYesterday() ? 'Yesterday' : $day->format('l'));
                @endphp

                <div class="flex items-center justify-between gap-4 border-b border-slate-100 bg-slate-50/80 px-5 py-3 md:px-6 dark:border-slate-800 dark:bg-slate-800/40">
                    <div>
                        <h2 class="text-sm font-bold text-slate-800 dark:text-slate-100">{{ $dayLabel }}</h2>
                        <p class="text-xs text-slate-400">{{ $day->format('d M Y') }}</p>
                    </div>
                    <div class="text-right">
                        <p class="text-sm font-bold tabular-nums text-slate-800 dark:text-slate-100">৳ {{ number_format((float) $dayNotifications->sum('amount'), 2) }}</p>
                        <p class="text-xs text-slate-400">{{ $dayNotifications->count() }} {{ Str::plural('expense', $dayNotifications->count()) }}</p>
                    </div>
                </div>

                <ul class="divide-y divide-slate-100 dark:divide-slate-800">
                    @foreach ($dayNotifications as $expense)
                        @php
                            $isOwnExpense = $expense->user_id === auth()->id();
                            $isUnread = in_array($expense->id, $unreadIds, true);
                        @endphp
                        <li class="flex items-center gap-4 px-5 py-4 md:px-6 {{ $isUnread ? 'bg-blue-50/50 dark:bg-blue-500/5' : '' }}">
                            <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-blue-50 text-sm font-bold text-blue-600 dark:bg-blue-500/10 dark:text-blue-400">
                                {{ strtoupper(mb_substr($expense->category, 0, 1)) }}
                            </div>

                            <div class="min-w-0 flex-1">
                                <div class="flex items-center gap-2">
                                    <p class="truncate text-sm font-semibold text-slate-800 dark:text-slate-100">{{ $expense->title }}</p>
                                    @if ($isUnread)
                                        <span class="shrink-0 rounded-full bg-blue-600 px-2 py-0.5 text-[10px] font-bold uppercase tracking-wide text-white">New</span>
                                    @endif
                                </div>
                                <p class="mt-1 truncate text-xs text-slate-500 dark:text-slate-400">
                                    <span class="font-medium text-slate-600 dark:text-slate-300">{{ $isOwnExpense ? 'You' : ($expense->user?->name ?? 'A user') }}</span>
                                    added · {{ $expense->category }}
                                    @if ($expense->merchant)
                                        · {{ $expense->merchant }}
                                    @endif
                                </p>
                            </div>

                            <div class="shrink-0 text-right">
                                <p class="text-sm font-bold tabular-nums text-slate-900 dark:text-white">৳ {{ number_format((float) $expense->amount, 2) }}</p>
                                <p class="mt-1 text-xs text-slate-400" title="{{ $expense->created_at->format('d M Y, h:i A') }}">{{ $expense->created_at->format('h:i A') }}</p>
                            </div>
                        </li>
                    @endforeach
                </ul>
            @empty
                <div class="px-6 py-16 text-center">
                    <h2 class="text-base font-semibold text-slate-800 dark:text-slate-100">No activity in the last {{ $windowDays }} days</h2>
                    <p class="mt-2 text-sm text-slate-500 dark:text-slate-400">New expenses will appear here as soon as they are added.</p>
                </div>
            @endforelse
        </div>

    </div>
@endsection

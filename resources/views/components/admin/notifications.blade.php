@php
    $notificationTones = [
        'bg-blue-50 text-blue-600 ring-blue-100 dark:bg-blue-500/10 dark:text-blue-400 dark:ring-blue-500/20',
        'bg-violet-50 text-violet-600 ring-violet-100 dark:bg-violet-500/10 dark:text-violet-400 dark:ring-violet-500/20',
        'bg-emerald-50 text-emerald-600 ring-emerald-100 dark:bg-emerald-500/10 dark:text-emerald-400 dark:ring-emerald-500/20',
        'bg-amber-50 text-amber-600 ring-amber-100 dark:bg-amber-500/10 dark:text-amber-400 dark:ring-amber-500/20',
        'bg-rose-50 text-rose-600 ring-rose-100 dark:bg-rose-500/10 dark:text-rose-400 dark:ring-rose-500/20',
        'bg-cyan-50 text-cyan-600 ring-cyan-100 dark:bg-cyan-500/10 dark:text-cyan-400 dark:ring-cyan-500/20',
    ];
    $currentUser = Auth::user();
    $groupedHeaderNotifications = $headerNotifications->groupBy(function ($expense) {
        $createdAt = $expense->created_at;

        return match (true) {
            $createdAt->isToday() => 'Today',
            $createdAt->isYesterday() => 'Yesterday',
            default => $createdAt->format('l, d M'),
        };
    });
@endphp

<div class="relative" id="notification-wrapper">

    <!-- Notification Button -->
    <button type="button" id="notification-button" aria-expanded="false" aria-controls="notification-dropdown"
        aria-label="Notifications{{ $unreadNotificationCount ? ' ('.$unreadNotificationCount.' new)' : '' }}"
        class="group relative flex h-10 w-10 items-center justify-center rounded-xl text-slate-600 transition duration-200 hover:-translate-y-0.5 hover:bg-slate-100 hover:text-slate-900 active:translate-y-0 active:scale-95 dark:text-slate-300 dark:hover:bg-slate-800 dark:hover:text-white">

        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"
            class="h-6 w-6 origin-top motion-safe:group-hover:animate-bell-ring {{ $unreadNotificationCount > 0 ? 'motion-safe:animate-bell-ring motion-safe:[animation-delay:800ms]' : '' }}">
            <path stroke-linecap="round" stroke-linejoin="round"
                d="M15 17h5l-1.4-1.4A2 2 0 0118 14.2V11a6 6 0 00-4.5-5.8V4a1.5 1.5 0 00-3 0v1.2A6 6 0 006 11v3.2a2 2 0 01-.6 1.4L4 17h5m6 0v1a3 3 0 01-6 0v-1m6 0H9" />
        </svg>

        @if ($unreadNotificationCount > 0)
            <span class="notification-ping absolute -right-0.5 -top-0.5 h-5 w-5 animate-ping rounded-full bg-red-400 opacity-60"></span>
            <span id="notification-count"
                class="absolute -right-0.5 -top-0.5 flex h-5 min-w-5 items-center justify-center rounded-full border-2 border-white bg-red-500 px-1 text-[10px] font-bold text-white dark:border-slate-900">
                {{ $unreadNotificationCount > 99 ? '99+' : $unreadNotificationCount }}
            </span>
        @endif

    </button>


    <!-- Notification Dropdown Panel -->
    <div id="notification-dropdown" role="dialog" aria-label="Notifications"
        class="fixed inset-x-3 top-[4.5rem] z-50 hidden origin-top-right overflow-hidden rounded-2xl motion-safe:animate-dropdown-in border border-slate-200 bg-white shadow-2xl shadow-slate-900/10 sm:absolute sm:inset-x-auto sm:right-0 sm:top-14 sm:w-[400px] dark:border-slate-700 dark:bg-slate-900 dark:shadow-black/40">

        <!-- Header -->
        <div class="flex items-start justify-between gap-3 px-5 pb-3 pt-4">
            <div>
                <h3 class="text-base font-bold text-slate-900 dark:text-white">Notifications</h3>
                <p id="notification-unread-label" class="mt-0.5 text-xs text-slate-500 dark:text-slate-400">
                    @if ($unreadNotificationCount > 0)
                        {{ $unreadNotificationCount }} new {{ Str::plural('expense', $unreadNotificationCount) }} since your last visit
                    @else
                        All caught up
                    @endif
                </p>
            </div>

            @if ($unreadNotificationCount > 0)
                <button type="button" id="mark-all-read" data-url="{{ route('admin.notifications.read') }}"
                    class="shrink-0 rounded-lg px-2.5 py-1.5 text-xs font-semibold text-blue-600 transition hover:bg-blue-50 disabled:opacity-50 dark:text-blue-400 dark:hover:bg-blue-500/10">
                    Mark all as read
                </button>
            @endif
        </div>

        <!-- Notification List -->
        @if ($headerNotifications->isNotEmpty())
            <div id="notification-list" class="max-h-[min(380px,60vh)] overflow-y-auto border-t border-slate-100 dark:border-slate-800">
                @foreach ($groupedHeaderNotifications as $dayLabel => $dayNotifications)
                    <p class="sticky top-0 z-10 bg-white/95 px-5 pb-1.5 pt-3 text-[11px] font-semibold uppercase tracking-wider text-slate-400 backdrop-blur dark:bg-slate-900/95">
                        {{ $dayLabel }}
                    </p>

                    @foreach ($dayNotifications as $expense)
                        @php
                            $isUnread = $currentUser->hasUnreadNotificationFor($expense);
                            $isOwnExpense = $expense->user_id === $currentUser->id;
                            $tone = $notificationTones[crc32($expense->category) % count($notificationTones)];
                        @endphp

                        <a href="{{ $isOwnExpense ? route('admin.expenses.index') : route('admin.expenses.all') }}"
                            class="notification-item group flex gap-3 px-5 py-3 transition hover:bg-slate-50 dark:hover:bg-slate-800/70"
                            data-unread="{{ $isUnread ? 'true' : 'false' }}">

                            <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl text-sm font-bold ring-1 {{ $tone }}">
                                {{ strtoupper(mb_substr($expense->category, 0, 1)) }}
                            </div>

                            <div class="min-w-0 flex-1">
                                <div class="flex items-start justify-between gap-3">
                                    <h4 class="truncate text-sm font-semibold text-slate-800 dark:text-slate-100" title="{{ $expense->title }}">
                                        {{ $expense->title }}
                                    </h4>
                                    <span class="shrink-0 text-sm font-bold tabular-nums text-slate-900 dark:text-white">
                                        ৳ {{ number_format((float) $expense->amount, 2) }}
                                    </span>
                                </div>

                                <div class="mt-1 flex items-center justify-between gap-3">
                                    <p class="truncate text-xs text-slate-500 dark:text-slate-400">
                                        <span class="font-medium text-slate-600 dark:text-slate-300">{{ $isOwnExpense ? 'You' : ($expense->user?->name ?? 'A user') }}</span>
                                        added · {{ $expense->category }}
                                    </p>
                                    <span class="flex shrink-0 items-center gap-1.5 text-[11px] text-slate-400" title="{{ $expense->created_at->format('d M Y, h:i A') }}">
                                        {{ $expense->created_at->diffForHumans(short: true) }}
                                        @if ($isUnread)
                                            <span class="notification-dot h-2 w-2 rounded-full bg-blue-600 dark:bg-blue-400"></span>
                                        @endif
                                    </span>
                                </div>
                            </div>

                        </a>
                    @endforeach
                @endforeach
            </div>
        @else
            <!-- Empty State -->
            <div class="border-t border-slate-100 px-5 py-10 text-center dark:border-slate-800">
                <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-full bg-slate-100 text-slate-400 dark:bg-slate-800">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.6">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M15 17h5l-1.4-1.4A2 2 0 0118 14.2V11a6 6 0 00-4.5-5.8V4a1.5 1.5 0 00-3 0v1.2A6 6 0 006 11v3.2a2 2 0 01-.6 1.4L4 17h5m6 0v1a3 3 0 01-6 0v-1m6 0H9" />
                    </svg>
                </div>
                <h4 class="mt-4 text-sm font-semibold text-slate-800 dark:text-white">No activity in the last 7 days</h4>
                <p class="mt-1 text-xs text-slate-500 dark:text-slate-400">New expenses will appear here as soon as they are added.</p>
                <a href="{{ route('admin.expenses.create') }}"
                    class="mt-4 inline-flex items-center rounded-lg bg-blue-600 px-3.5 py-2 text-xs font-semibold text-white transition hover:bg-blue-700">
                    + Add Expense
                </a>
            </div>
        @endif

        <!-- Footer -->
        <div class="border-t border-slate-100 p-2 dark:border-slate-800">
            <a href="{{ route('admin.notifications.index') }}"
                class="block rounded-xl py-2 text-center text-sm font-semibold text-blue-600 transition hover:bg-blue-50 dark:text-blue-400 dark:hover:bg-blue-500/10">
                View all notifications →
            </a>
        </div>

    </div>

</div>

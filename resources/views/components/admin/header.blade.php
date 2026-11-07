<header
    class="sticky top-0 z-30 flex h-[82px] shrink-0 items-center gap-4 border-b border-slate-200 bg-white/95 px-4 backdrop-blur-xl md:px-7">

    <!-- Sidebar Toggle -->
    <button onclick="toggleSidebar()"
        class="flex h-10 w-10 items-center justify-center rounded-xl text-slate-700 hover:bg-slate-100">

        <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M4 6h16M4 12h16M4 18h16" />
        </svg>

    </button>


    <!-- Search -->
    <div class="hidden w-full max-w-[560px] items-center gap-3 rounded-full bg-[#f1f3f9] px-5 py-3 md:flex">

        <svg class="h-5 w-5 text-slate-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <circle cx="11" cy="11" r="7" />
            <path d="m16 16 4 4" />
        </svg>

        <input type="search" placeholder="Search expenses, categories..."
            class="w-full bg-transparent text-sm outline-none">

    </div>


    <!-- Right Actions -->
    <div class="ml-auto flex items-center gap-4">

        <!-- Theme Toggle -->
        @include('components.theme-toggle')


        <!-- Notification Dropdown -->
        <div class="relative" id="notification-wrapper">

            <!-- Notification Button -->
            <button type="button" id="notification-button" aria-label="Notifications" aria-expanded="false"
                aria-controls="notification-dropdown"
                class="relative flex h-10 w-10 items-center justify-center rounded-xl text-slate-600 transition hover:bg-slate-100 dark:text-slate-300 dark:hover:bg-slate-800">

                <!-- Bell Icon -->
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor" stroke-width="1.8">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M15 17h5l-1.4-1.4A2 2 0 0118 14.2V11a6 6 0 00-4.5-5.8V4a1.5 1.5 0 00-3 0v1.2A6 6 0 006 11v3.2a2 2 0 01-.6 1.4L4 17h5m6 0v1a3 3 0 01-6 0v-1m6 0H9" />
                </svg>

                <!-- Notification Count -->
                <span id="notification-count"
                    class="absolute -right-0.5 -top-0.5 flex h-5 min-w-5 items-center justify-center rounded-full border-2 border-white bg-red-500 px-1 text-[10px] font-bold text-white dark:border-slate-900">
                    3
                </span>

            </button>


            <!-- Notification Dropdown Panel -->
            <div id="notification-dropdown"
                class="absolute right-0 top-14 z-50 hidden w-[340px] max-w-[calc(100vw-2rem)] overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-2xl dark:border-slate-700 dark:bg-slate-900 sm:w-[380px]">

                <!-- Header -->
                <div
                    class="flex items-center justify-between border-b border-slate-100 px-5 py-4 dark:border-slate-700">

                    <div>
                        <h3 class="text-base font-bold text-slate-900 dark:text-white">
                            Notifications
                        </h3>

                        <p class="mt-1 text-xs text-slate-500 dark:text-slate-400">
                            You have <span id="notification-total">3</span> unread notifications
                        </p>
                    </div>

                    <button type="button" id="mark-all-read"
                        class="text-xs font-semibold text-blue-600 hover:text-blue-700 dark:text-blue-400">
                        Mark all as read
                    </button>

                </div>


                <!-- Notification List -->
                <div id="notification-list" class="max-h-[360px] overflow-y-auto">

                    <!-- Notification 1 -->
                    <div class="notification-item flex gap-3 border-b border-slate-100 p-4 transition hover:bg-slate-50 dark:border-slate-700 dark:hover:bg-slate-800"
                        data-unread="true">

                        <div
                            class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-blue-100 text-blue-600 dark:bg-blue-500/20 dark:text-blue-400">

                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4l3 2m6-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>

                        </div>

                        <div class="min-w-0 flex-1">

                            <div class="flex items-start justify-between gap-2">

                                <h4 class="text-sm font-semibold text-slate-800 dark:text-slate-100">
                                    Welcome to DeshExpense
                                </h4>

                                <span class="notification-dot mt-1.5 h-2 w-2 shrink-0 rounded-full bg-blue-600"></span>

                            </div>

                            <p class="mt-1 text-xs leading-5 text-slate-500 dark:text-slate-400">
                                Your expense management dashboard is ready.
                            </p>

                            <span class="mt-2 block text-[11px] text-slate-400">
                                Just now
                            </span>

                        </div>

                    </div>


                    <!-- Notification 2 -->
                    <div class="notification-item flex gap-3 border-b border-slate-100 p-4 transition hover:bg-slate-50 dark:border-slate-700 dark:hover:bg-slate-800"
                        data-unread="true">

                        <div
                            class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-green-100 text-green-600 dark:bg-green-500/20 dark:text-green-400">

                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7" />
                            </svg>

                        </div>

                        <div class="min-w-0 flex-1">

                            <div class="flex items-start justify-between gap-2">

                                <h4 class="text-sm font-semibold text-slate-800 dark:text-slate-100">
                                    Expense Added
                                </h4>

                                <span class="notification-dot mt-1.5 h-2 w-2 shrink-0 rounded-full bg-blue-600"></span>

                            </div>

                            <p class="mt-1 text-xs leading-5 text-slate-500 dark:text-slate-400">
                                Your new expense has been recorded successfully.
                            </p>

                            <span class="mt-2 block text-[11px] text-slate-400">
                                10 minutes ago
                            </span>

                        </div>

                    </div>


                    <!-- Notification 3 -->
                    <div class="notification-item flex gap-3 border-b border-slate-100 p-4 transition hover:bg-slate-50 dark:border-slate-700 dark:hover:bg-slate-800"
                        data-unread="true">

                        <div
                            class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-amber-100 text-amber-600 dark:bg-amber-500/20 dark:text-amber-400">

                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>

                        </div>

                        <div class="min-w-0 flex-1">

                            <div class="flex items-start justify-between gap-2">

                                <h4 class="text-sm font-semibold text-slate-800 dark:text-slate-100">
                                    Budget Reminder
                                </h4>

                                <span class="notification-dot mt-1.5 h-2 w-2 shrink-0 rounded-full bg-blue-600"></span>

                            </div>

                            <p class="mt-1 text-xs leading-5 text-slate-500 dark:text-slate-400">
                                Remember to review your monthly budget.
                            </p>

                            <span class="mt-2 block text-[11px] text-slate-400">
                                1 hour ago
                            </span>

                        </div>

                    </div>

                </div>


                <!-- Empty State -->
                <div id="notification-empty" class="hidden px-5 py-10 text-center">

                    <div
                        class="mx-auto flex h-14 w-14 items-center justify-center rounded-full bg-slate-100 text-2xl dark:bg-slate-800">
                        🔔
                    </div>

                    <h4 class="mt-4 font-semibold text-slate-800 dark:text-white">
                        You're all caught up!
                    </h4>

                    <p class="mt-2 text-xs text-slate-500 dark:text-slate-400">
                        No unread notifications available.
                    </p>

                </div>


                <!-- Footer -->
                <div class="border-t border-slate-100 p-3 text-center dark:border-slate-700">

                    <a href="{{ url('/admin/notifications') }}"
                        class="text-sm font-semibold text-blue-600 hover:text-blue-700 dark:text-blue-400">
                        View All Notifications →
                    </a>

                </div>

            </div>

        </div>


        <!-- User Profile Dropdown -->
        <div class="relative" id="profile-wrapper">

            <!-- Profile Button -->
            <button type="button" id="profile-button" aria-label="User profile" aria-expanded="false"
                aria-controls="profile-dropdown"
                class="flex items-center gap-3 rounded-xl p-1.5 transition hover:bg-slate-50 dark:hover:bg-slate-800">

                <!-- User Avatar -->
                <div
                    class="flex h-10 w-10 items-center justify-center rounded-full
                    bg-gradient-to-br from-blue-100 to-violet-200
                    text-lg font-bold text-blue-700 dark:from-blue-500/20 dark:to-violet-500/20 dark:text-blue-300">

                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}

                </div>

                <!-- User Information -->
                <div class="hidden text-left sm:block">

                    <p class="text-sm font-bold text-slate-900 dark:text-white">
                        {{ Auth::user()->name }}
                    </p>

                    <p class="text-xs text-slate-500 dark:text-slate-400">
                        {{ Auth::user()->email }}
                    </p>

                </div>

                <span class="text-slate-500">⌄</span>

            </button>


            <!-- Profile Dropdown -->
            <div id="profile-dropdown"
                class="absolute right-0 top-14 z-50 hidden w-64 overflow-hidden
                rounded-2xl border border-slate-200 bg-white shadow-xl
                dark:border-slate-700 dark:bg-slate-900">

                <!-- Profile Details -->
                <div class="border-b border-slate-100 p-4 dark:border-slate-700">

                    <p class="font-bold text-slate-900 dark:text-white">
                        {{ Auth::user()->name }}
                    </p>

                    <p class="mt-1 text-xs text-slate-500 dark:text-slate-400">
                        {{ Auth::user()->email }}
                    </p>

                    <span
                        class="mt-3 inline-flex rounded-full bg-blue-50 px-3 py-1
                        text-xs font-semibold text-blue-600 dark:bg-blue-500/10 dark:text-blue-400">
                        Account Owner
                    </span>

                </div>


                <!-- Logout Button -->
                <div class="p-2">

                    <form action="{{ route('logout') }}" method="POST">
                        @csrf

                        <button type="submit"
                            class="flex w-full items-center gap-3 rounded-xl px-3 py-3
                            text-sm font-semibold text-red-600 transition
                            hover:bg-red-50 dark:hover:bg-red-500/10">

                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                stroke-width="1.8">

                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M15 12H3m0 0l4-4m-4 4l4 4m4-12h5a2 2 0 012 2v2m0 8v2a2 2 0 01-2 2h-5" />

                            </svg>

                            Logout

                        </button>

                    </form>

                </div>

            </div>

        </div>

    </div>

</header>


<!-- Header JavaScript -->
<script>
    document.addEventListener('DOMContentLoaded', function() {

        // Notification Elements
        const notificationButton = document.getElementById('notification-button');
        const notificationDropdown = document.getElementById('notification-dropdown');
        const notificationCount = document.getElementById('notification-count');
        const notificationTotal = document.getElementById('notification-total');
        const markAllButton = document.getElementById('mark-all-read');
        const emptyState = document.getElementById('notification-empty');
        const notificationList = document.getElementById('notification-list');
        const notificationWrapper = document.getElementById('notification-wrapper');

        // Profile Elements
        const profileButton = document.getElementById('profile-button');
        const profileDropdown = document.getElementById('profile-dropdown');
        const profileWrapper = document.getElementById('profile-wrapper');


        // Toggle Notification Dropdown
        if (notificationButton && notificationDropdown) {

            notificationButton.addEventListener('click', function(event) {
                event.stopPropagation();

                const isOpen = !notificationDropdown.classList.contains('hidden');

                notificationDropdown.classList.toggle('hidden', isOpen);
                notificationButton.setAttribute('aria-expanded', String(!isOpen));

                // Close profile dropdown
                profileDropdown?.classList.add('hidden');
                profileButton?.setAttribute('aria-expanded', 'false');
            });


            // Update Notification Count
            function updateNotificationCount() {

                if (!notificationList) return;

                const unreadItems = notificationList.querySelectorAll(
                    '.notification-item[data-unread="true"]'
                );

                const unreadCount = unreadItems.length;

                notificationCount.textContent = unreadCount;
                notificationTotal.textContent = unreadCount;

                notificationCount.classList.toggle('hidden', unreadCount === 0);

                emptyState.classList.toggle('hidden', unreadCount > 0);

                if (unreadCount === 0) {
                    notificationList.classList.add('hidden');
                    markAllButton.classList.add('hidden');
                } else {
                    notificationList.classList.remove('hidden');
                    markAllButton.classList.remove('hidden');
                }
            }


            // Mark Individual Notification as Read
            if (notificationList) {

                notificationList.querySelectorAll('.notification-item').forEach(item => {

                    item.addEventListener('click', function() {

                        item.dataset.unread = 'false';

                        const dot = item.querySelector('.notification-dot');

                        if (dot) {
                            dot.classList.add('hidden');
                        }

                        item.classList.remove('bg-blue-50', 'dark:bg-slate-800');

                        updateNotificationCount();

                    });

                });

            }


            // Mark All Notifications as Read
            if (markAllButton) {

                markAllButton.addEventListener('click', function() {

                    notificationList.querySelectorAll('.notification-item').forEach(item => {

                        item.dataset.unread = 'false';

                        const dot = item.querySelector('.notification-dot');

                        if (dot) {
                            dot.classList.add('hidden');
                        }

                    });

                    updateNotificationCount();

                });

            }

            updateNotificationCount();

        }


        // Toggle Profile Dropdown
        if (profileButton && profileDropdown) {

            profileButton.addEventListener('click', function(event) {

                event.stopPropagation();

                const isOpen = !profileDropdown.classList.contains('hidden');

                profileDropdown.classList.toggle('hidden', isOpen);

                profileButton.setAttribute('aria-expanded', String(!isOpen));

                // Close notification dropdown
                notificationDropdown?.classList.add('hidden');
                notificationButton?.setAttribute('aria-expanded', 'false');

            });

        }


        // Close Both Dropdowns When Clicking Outside
        document.addEventListener('click', function(event) {

            if (notificationWrapper && !notificationWrapper.contains(event.target)) {

                notificationDropdown?.classList.add('hidden');
                notificationButton?.setAttribute('aria-expanded', 'false');

            }

            if (profileWrapper && !profileWrapper.contains(event.target)) {

                profileDropdown?.classList.add('hidden');
                profileButton?.setAttribute('aria-expanded', 'false');

            }

        });


        // Close Dropdowns Using Escape Key
        document.addEventListener('keydown', function(event) {

            if (event.key === 'Escape') {

                notificationDropdown?.classList.add('hidden');
                notificationButton?.setAttribute('aria-expanded', 'false');

                profileDropdown?.classList.add('hidden');
                profileButton?.setAttribute('aria-expanded', 'false');

            }

        });

    });
</script>

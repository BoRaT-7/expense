<header
    class="sticky top-0 z-30 flex h-16 shrink-0 items-center gap-2 border-b border-slate-200 bg-white/90 px-3 shadow-sm shadow-slate-900/[0.03] backdrop-blur-xl sm:gap-4 sm:px-4 md:h-[82px] md:px-7 lg:shadow-none dark:border-slate-800 dark:bg-slate-900/90">

    <!-- Sidebar Toggle: Mobile & Tablet Only (sidebar is always visible on desktop) -->
    <button type="button" onclick="toggleSidebar()" aria-controls="admin-sidebar"
        aria-label="Open menu{{ $unreadNotificationCount ? ' ('.$unreadNotificationCount.' new notifications)' : '' }}"
        class="group relative z-10 flex h-10 w-10 shrink-0 flex-col items-start justify-center gap-[5px] rounded-xl px-2.5 text-slate-700 transition hover:bg-slate-100 focus:outline-none focus:ring-2 focus:ring-blue-500 active:scale-90 lg:hidden dark:text-slate-200 dark:hover:bg-slate-800">

        <span class="h-0.5 w-5 rounded-full bg-current transition-all duration-300"></span>
        <span class="h-0.5 w-3 rounded-full bg-current transition-all duration-300 group-hover:w-5 group-active:w-5"></span>
        <span class="h-0.5 w-4 rounded-full bg-current transition-all duration-300 group-hover:w-5 group-active:w-5"></span>

        <!-- Unread indicator: Small devices only (notifications live in the menu there) -->
        @if ($unreadNotificationCount > 0)
            <span class="absolute right-1.5 top-1.5 flex h-2.5 w-2.5 md:hidden">
                <span class="absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75 motion-safe:animate-ping"></span>
                <span class="relative inline-flex h-2.5 w-2.5 rounded-full border-2 border-white bg-red-500 dark:border-slate-900"></span>
            </span>
        @endif

    </button>


    <!-- Brand Name: Centered on Small Devices -->
    @php
        [$brandFirstWord, $brandRest] = array_pad(explode(' ', config('app.name'), 2), 2, '');
    @endphp
    <a href="{{ route('admin.dashboard') }}"
        class="absolute left-1/2 top-1/2 -translate-x-1/2 -translate-y-1/2 whitespace-nowrap md:hidden">
        <span class="block text-lg font-extrabold motion-safe:animate-header-title-in">
            <span class="bg-gradient-to-r from-orange-600 via-amber-500 to-orange-600 bg-[length:200%_auto] bg-clip-text text-transparent motion-safe:animate-gradient-pan dark:from-orange-400 dark:via-amber-300 dark:to-orange-400">{{ $brandFirstWord }}</span>
            @if ($brandRest !== '')
                <span class="text-[#1e3a6e] dark:text-blue-200">{{ $brandRest }}</span>
            @endif
        </span>
    </a>


    <!-- Greeting: Tablet and up (based on Bangladesh time) -->
    @php
        $displayTimezone = config('app.display_timezone');
        $localNow = now($displayTimezone);
        [$greetingText, $greetingIcon] = match (true) {
            $localNow->hour >= 5 && $localNow->hour < 12 => ['Good morning', '☀️'],
            $localNow->hour >= 12 && $localNow->hour < 17 => ['Good afternoon', '🌤️'],
            $localNow->hour >= 17 && $localNow->hour < 21 => ['Good evening', '🌇'],
            default => ['Good night', '🌙'],
        };
    @endphp
    <div id="header-greeting" data-timezone="{{ $displayTimezone }}" class="hidden min-w-0 md:block">
        <p class="flex items-center gap-2 truncate text-lg font-bold tracking-tight text-slate-900 motion-safe:animate-header-title-in dark:text-white">
            <span id="greeting-icon" aria-hidden="true" class="inline-block motion-safe:animate-float">{{ $greetingIcon }}</span>
            <span><span id="greeting-text">{{ $greetingText }}</span>, <span class="text-blue-600 dark:text-blue-400">{{ Auth::user()->firstName() }}</span></span>
        </p>
        <p class="mt-0.5 flex items-center gap-1.5 truncate text-xs font-medium text-slate-500 motion-safe:animate-header-title-in motion-safe:[animation-delay:120ms] dark:text-slate-400">
            <span class="relative flex h-2 w-2 shrink-0" aria-hidden="true">
                <span class="absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-60 motion-safe:animate-ping"></span>
                <span class="relative inline-flex h-2 w-2 rounded-full bg-emerald-500"></span>
            </span>
            <time id="greeting-clock" datetime="{{ $localNow->toIso8601String() }}">{{ $localNow->format('l, d M Y · h:i A') }}</time>
            <span class="text-slate-400 dark:text-slate-500">· {{ str_replace('_', ' ', Str::afterLast($displayTimezone, '/')) }}</span>
        </p>
    </div>


    <!-- Right Actions -->
    <div class="ml-auto flex shrink-0 items-center gap-1 sm:gap-2 md:gap-3">

        <!-- Theme Toggle & Notifications: Tablet and up (inside the menu on small devices) -->
        <div class="hidden items-center gap-2 md:flex md:gap-3">
            @include('components.theme-toggle')

            @include('components.admin.notifications')
        </div>


        <!-- User Profile Dropdown -->
        <div class="relative" id="profile-wrapper">

            <!-- Profile Button -->
            <button type="button" id="profile-button" aria-label="User profile" aria-expanded="false"
                aria-controls="profile-dropdown"
                class="flex items-center gap-2 rounded-xl p-1 transition hover:bg-slate-50 focus:outline-none focus:ring-2 focus:ring-blue-500 sm:gap-3 sm:p-1.5 dark:hover:bg-slate-800">

                <!-- User Avatar -->
                <div
                    class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full
                    bg-gradient-to-br from-blue-100 to-violet-200 ring-2 ring-white
                    text-base font-bold text-blue-700 sm:h-10 sm:w-10 sm:text-lg dark:from-blue-500/20 dark:to-violet-500/20 dark:text-blue-300 dark:ring-slate-900">

                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}

                </div>

                <!-- User Information -->
                <div class="hidden max-w-[180px] text-left md:block">

                    <p class="truncate text-sm font-bold text-slate-900 dark:text-white">
                        {{ Auth::user()->name }}
                    </p>

                    <p class="truncate text-xs text-slate-500 dark:text-slate-400">
                        {{ Auth::user()->email }}
                    </p>

                </div>

                <svg class="hidden h-4 w-4 text-slate-400 sm:block" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <path d="m6 9 6 6 6-6" />
                </svg>

            </button>


            <!-- Profile Dropdown -->
            <div id="profile-dropdown"
                class="fixed inset-x-3 top-[4.5rem] z-50 hidden origin-top-right overflow-hidden motion-safe:animate-dropdown-in
                rounded-2xl border border-slate-200 bg-white shadow-xl
                sm:absolute sm:inset-x-auto sm:right-0 sm:top-14 sm:w-64
                dark:border-slate-700 dark:bg-slate-900">

                <!-- Profile Details -->
                <div class="border-b border-slate-100 p-4 dark:border-slate-700">

                    <p class="truncate font-bold text-slate-900 dark:text-white">
                        {{ Auth::user()->name }}
                    </p>

                    <p class="mt-1 truncate text-xs text-slate-500 dark:text-slate-400">
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
                            hover:bg-red-50 dark:hover:bg-red-500/10 dark:text-red-400">

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

        // Live Greeting & Clock (Bangladesh time, independent of the visitor's device timezone)
        const greeting = document.getElementById('header-greeting');

        if (greeting) {
            const timeZone = greeting.dataset.timezone;
            const greetingText = document.getElementById('greeting-text');
            const greetingIcon = document.getElementById('greeting-icon');
            const greetingClock = document.getElementById('greeting-clock');

            const formatter = new Intl.DateTimeFormat('en-US', {
                timeZone, weekday: 'long', day: '2-digit', month: 'short', year: 'numeric',
                hour: '2-digit', minute: '2-digit', hourCycle: 'h23',
            });
            const partsOf = date => Object.fromEntries(
                formatter.formatToParts(date).map(part => [part.type, part.value])
            );

            const periodFor = hour => {
                if (hour >= 5 && hour < 12) return ['Good morning', '☀️'];
                if (hour >= 12 && hour < 17) return ['Good afternoon', '🌤️'];
                if (hour >= 17 && hour < 21) return ['Good evening', '🌇'];
                return ['Good night', '🌙'];
            };

            const updateGreeting = () => {
                const now = new Date();
                const parts = partsOf(now);
                const hour = Number(parts.hour) % 24;
                const hour12 = String(hour % 12 || 12).padStart(2, '0');
                const [text, icon] = periodFor(hour);

                greetingText.textContent = text;
                greetingIcon.textContent = icon;
                greetingClock.textContent =
                    `${parts.weekday}, ${parts.day} ${parts.month} ${parts.year} · ${hour12}:${parts.minute} ${hour < 12 ? 'AM' : 'PM'}`;
                greetingClock.setAttribute('datetime', now.toISOString());
            };

            updateGreeting();
            setInterval(updateGreeting, 30000);
        }

        // Notification Elements
        const notificationButton = document.getElementById('notification-button');
        const notificationDropdown = document.getElementById('notification-dropdown');
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


            // Mark All Notifications as Read (persisted on the server)
            const markAllButton = document.getElementById('mark-all-read');
            const notificationCount = document.getElementById('notification-count');
            const notificationUnreadLabel = document.getElementById('notification-unread-label');

            markAllButton?.addEventListener('click', async function() {
                markAllButton.disabled = true;

                try {
                    const response = await fetch(markAllButton.dataset.url, {
                        method: 'POST',
                        headers: {
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'X-Requested-With': 'XMLHttpRequest',
                        },
                    });

                    if (!response.ok) {
                        throw new Error('Request failed');
                    }

                    notificationDropdown.querySelectorAll('.notification-item[data-unread="true"]').forEach(item => {
                        item.dataset.unread = 'false';
                        item.querySelector('.notification-dot')?.remove();
                    });

                    notificationCount?.remove();
                    notificationButton.querySelector('.notification-ping')?.remove();
                    notificationUnreadLabel.textContent = 'All caught up';
                    markAllButton.remove();
                } catch (error) {
                    markAllButton.disabled = false;
                }
            });

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

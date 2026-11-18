@php
    /** @var array<int, array{section: string, items: array<int, array{name: string, route: string, icon: string}>}> $menus */
    $menus = [
        [
            'section' => 'WORKSPACE',
            'items' => [
                ['name' => 'Dashboard', 'route' => 'admin.dashboard', 'icon' => 'M4 5a1 1 0 011-1h4a1 1 0 011 1v5a1 1 0 01-1 1H5a1 1 0 01-1-1V5zm10 0a1 1 0 011-1h4a1 1 0 011 1v2a1 1 0 01-1 1h-4a1 1 0 01-1-1V5zM4 16a1 1 0 011-1h4a1 1 0 011 1v3a1 1 0 01-1 1H5a1 1 0 01-1-1v-3zm10-3a1 1 0 011-1h4a1 1 0 011 1v6a1 1 0 01-1 1h-4a1 1 0 01-1-1v-6z'],
                ['name' => 'Add Expense', 'route' => 'admin.expenses.create', 'icon' => 'M12 9v6m3-3H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z'],
                ['name' => 'My Expenses', 'route' => 'admin.expenses.index', 'icon' => 'M9 14l2 2 4-4M7 3h10a2 2 0 012 2v16l-3-2-2 2-2-2-2 2-2-2-3 2V5a2 2 0 012-2z'],
                ['name' => 'All Expenses', 'route' => 'admin.expenses.all', 'icon' => 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z'],
                ['name' => 'Categories', 'route' => 'admin.categories.index', 'icon' => 'M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z'],
                ['name' => 'Reports', 'route' => 'admin.reports.index', 'icon' => 'M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z'],
            ],
        ],
    ];

    if (auth()->user()?->isSuperAdmin()) {
        $menus[] = [
            'section' => 'ADMINISTRATION',
            'items' => [
                ['name' => 'Users', 'route' => 'admin.users.index', 'icon' => 'M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z'],
            ],
        ];
    }
@endphp

<aside id="admin-sidebar"
    class="fixed inset-y-0 left-0 z-50 flex w-[250px] -translate-x-full flex-col border-r border-white/[0.06] bg-gradient-to-b from-sidebar via-[#152846] to-sidebar-deep text-white shadow-2xl shadow-slate-950/25 transition-transform duration-300 lg:static lg:translate-x-0 lg:shadow-none dark:from-slate-900 dark:via-slate-900 dark:to-slate-950">

    <!-- Brand Header -->
    <div class="relative flex h-16 shrink-0 items-center justify-center border-b border-white/[0.08] px-5 md:h-[82px] lg:justify-start">

        <!-- Brand Logo: Mobile Center / Desktop Left -->
        <a href="{{ route('admin.dashboard') }}" aria-label="{{ config('app.name') }} dashboard"
            class="group block transition duration-300 hover:-translate-y-0.5 motion-safe:animate-header-title-in">

            <img src="{{ asset('logo/logo-light.png') }}" alt="{{ config('app.name') }}"
                class="h-11 w-auto max-w-[180px] object-contain drop-shadow-[0_4px_12px_rgba(0,0,0,0.35)] transition duration-300 group-hover:scale-[1.03] group-hover:drop-shadow-[0_6px_16px_rgba(249,115,22,0.35)] md:h-14 md:max-w-[205px]">

        </a>

        <!-- Close Button: Mobile Only -->
        <button type="button" onclick="toggleSidebar()" aria-label="Close menu"
            class="absolute right-3 z-10 flex h-9 w-9 items-center justify-center rounded-lg text-slate-400 transition hover:bg-white/10 hover:text-white lg:hidden">
            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" aria-hidden="true">
                <path d="M6 6l12 12M18 6L6 18" />
            </svg>
        </button>

    </div>

    <!-- Navigation -->
    <nav class="flex-1 space-y-7 overflow-y-auto px-4 py-6">

        @foreach ($menus as $menu)
            <div>

                <p class="mb-3 px-3.5 text-[10px] font-semibold tracking-[0.16em] text-slate-400/75">
                    {{ $menu['section'] }}
                </p>

                <div class="space-y-1">

                    @foreach ($menu['items'] as $item)
                        @php
                            $active = request()->routeIs($item['route']);
                        @endphp

                        <a href="{{ route($item['route']) }}" @if ($active) aria-current="page" @endif
                            style="animation-delay: {{ 80 + $loop->index * 60 }}ms"
                            class="sidebar-link group motion-safe:animate-nav-item-in {{ $active ? 'sidebar-link-active' : '' }}">

                            <svg class="h-5 w-5 shrink-0 transition-transform duration-300 group-hover:scale-110 {{ $active ? '' : 'group-hover:translate-x-0.5' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="{{ $item['icon'] }}" />
                            </svg>

                            <span>{{ $item['name'] }}</span>

                        </a>
                    @endforeach

                </div>

            </div>
        @endforeach

        <!-- Quick Actions: Small devices only (shown in the header on larger screens) -->
        <div class="md:hidden">

            <p class="mb-3 px-3.5 text-[10px] font-semibold tracking-[0.16em] text-slate-400/75">
                QUICK ACTIONS
            </p>

            <div class="space-y-1">

                <!-- Notifications -->
                <a href="{{ route('admin.notifications.index') }}"
                    @if (request()->routeIs('admin.notifications.*')) aria-current="page" @endif
                    class="sidebar-link {{ request()->routeIs('admin.notifications.*') ? 'sidebar-link-active' : '' }}">

                    <svg class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M15 17h5l-1.4-1.4A2 2 0 0118 14.2V11a6 6 0 00-4.5-5.8V4a1.5 1.5 0 00-3 0v1.2A6 6 0 006 11v3.2a2 2 0 01-.6 1.4L4 17h5m6 0v1a3 3 0 01-6 0v-1m6 0H9" />
                    </svg>

                    <span class="flex-1">Notifications</span>

                    @if ($unreadNotificationCount > 0)
                        <span class="flex h-5 min-w-5 items-center justify-center rounded-full bg-red-500 px-1.5 text-[10px] font-bold text-white motion-safe:animate-pulse">
                            {{ $unreadNotificationCount > 99 ? '99+' : $unreadNotificationCount }}
                        </span>
                    @endif

                </a>

                <!-- Dark Mode Switch -->
                <button type="button" id="sidebar-theme-toggle" role="switch" aria-checked="false"
                    class="sidebar-link w-full text-left">

                    <svg class="h-5 w-5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M20.3 15.3A8.5 8.5 0 018.7 3.7 8.5 8.5 0 1020.3 15.3z" />
                    </svg>

                    <span class="flex-1">Dark Mode</span>

                    <span class="sidebar-theme-track relative inline-flex h-6 w-11 shrink-0 items-center rounded-full bg-slate-600 transition-colors duration-300">
                        <span class="sidebar-theme-thumb inline-block h-5 w-5 translate-x-0.5 rounded-full bg-white shadow transition-transform duration-300"></span>
                    </span>

                </button>

            </div>

        </div>

    </nav>

</aside>

<script>
    (() => {
        const toggle = document.getElementById('sidebar-theme-toggle');

        if (!toggle) {
            return;
        }

        const track = toggle.querySelector('.sidebar-theme-track');
        const thumb = toggle.querySelector('.sidebar-theme-thumb');

        const render = () => {
            const isDark = document.documentElement.classList.contains('dark');
            toggle.setAttribute('aria-checked', String(isDark));
            track.classList.toggle('bg-blue-500', isDark);
            track.classList.toggle('bg-slate-600', !isDark);
            thumb.classList.toggle('translate-x-[22px]', isDark);
            thumb.classList.toggle('translate-x-0.5', !isDark);
        };

        toggle.addEventListener('click', () => {
            const isDark = document.documentElement.classList.toggle('dark');

            try {
                localStorage.setItem('deshexpense-theme', isDark ? 'dark' : 'light');
            } catch (error) {}

            window.dispatchEvent(new CustomEvent('themechange', { detail: { dark: isDark } }));
        });

        window.addEventListener('themechange', render);
        render();
    })();
</script>

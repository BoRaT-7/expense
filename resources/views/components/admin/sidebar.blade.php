@php
    $menus = [
        [
            'section' => 'WORKSPACE',
            'items' => [
                ['name' => 'Dashboard', 'icon' => '▦', 'route' => 'admin.dashboard'],
                ['name' => 'Add Expense', 'icon' => '+', 'route' => 'admin.expenses.create'],
                ['name' => 'My Expenses', 'icon' => '▤', 'route' => 'admin.expenses.index'],
                ['name' => 'All Expenses', 'icon' => '▣', 'route' => 'admin.expenses.all'],
                ['name' => 'Categories', 'icon' => '◆', 'route' => 'admin.categories.index'],
                ['name' => 'Reports', 'icon' => '▥', 'route' => 'admin.reports.index'],
            ],
        ],
    ];
@endphp

<aside id="admin-sidebar"
    class="fixed inset-y-0 left-0 z-50 flex w-[250px] -translate-x-full flex-col bg-[#111a35] text-white transition-transform duration-300 lg:static lg:translate-x-0">

    <!-- Logo Header -->
    <div class="relative flex h-[82px] shrink-0 items-center justify-center border-b border-white/10 px-6">

        <!-- Logo Icon: Desktop Only -->
        <div
            class="hidden h-11 w-11 items-center justify-center rounded-xl bg-gradient-to-br from-blue-400 to-blue-700 text-2xl font-bold shadow-lg lg:flex">
            ↗
        </div>

        <!-- Project Name: Mobile Center / Desktop Left -->
        <div
            class="absolute left-0 flex w-full items-center justify-center lg:static lg:ml-3 lg:w-auto lg:justify-start">
            <h2 class="text-xl font-extrabold whitespace-nowrap">
                DeshExpense
            </h2>
        </div>

        <!-- Close Button: Mobile Only -->
        <button onclick="toggleSidebar()"
            class="absolute right-4 z-10 text-xl text-slate-400 transition hover:text-white lg:hidden">
            ✕
        </button>

    </div>

    <!-- Navigation -->
    <nav class="flex-1 space-y-7 overflow-y-auto px-3 py-6">

        @foreach ($menus as $menu)
            <div>

                <p class="mb-3 px-4 text-[10px] font-bold tracking-[2px] text-slate-500">
                    {{ $menu['section'] }}
                </p>

                <div class="space-y-1">

                    @foreach ($menu['items'] as $item)
                        @php
                            $active = request()->routeIs($item['route']);

                            $url = \Illuminate\Support\Facades\Route::has($item['route']) ? route($item['route']) : '#';
                        @endphp

                        <a href="{{ $url }}"
                            class="flex items-center gap-4 rounded-xl px-4 py-3 text-sm font-medium transition
                            {{ $active
                                ? 'bg-gradient-to-r from-blue-500 to-blue-600 text-white shadow-lg'
                                : 'text-slate-300 hover:bg-white/10 hover:text-white' }}">

                            <span class="flex h-6 w-6 items-center justify-center text-xl">
                                {{ $item['icon'] }}
                            </span>

                            <span>{{ $item['name'] }}</span>

                        </a>
                    @endforeach

                </div>

            </div>
        @endforeach

    </nav>

</aside>

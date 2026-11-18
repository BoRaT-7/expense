<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Dashboard') | {{ config('app.name') }}</title>
    <link rel="icon" type="image/png" href="{{ asset('logo/logo-icon.png') }}">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    @stack('styles')
    @include('components.theme-script')
</head>

<body class="min-h-screen bg-page font-sans text-slate-800 antialiased
             transition-colors duration-300
             dark:bg-slate-950 dark:text-slate-100">

    <div class="min-h-screen lg:flex">

        <!-- Mobile Overlay -->
        <div id="sidebar-overlay" class="fixed inset-0 z-40 hidden bg-slate-950/50 lg:hidden" onclick="toggleSidebar()">
        </div>

        <!-- Sidebar -->
        @include('components.admin.sidebar')

        <!-- Main Content -->
        <div class="flex min-w-0 flex-1 flex-col">

            <!-- Header -->
            @include('components.admin.header')

            <!-- Page Content -->
            <main class="flex-1 p-4 md:p-6 xl:p-7">
                @yield('content')
            </main>

        </div>
    </div>

    @include('components.admin.success-popup')

    @stack('scripts')

</body>

</html>


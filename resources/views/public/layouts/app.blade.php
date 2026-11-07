<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'DeshExpense - Smart Expense Management')</title>

    <meta name="description" content="@yield('meta_description', 'Manage your expenses, track your budget and understand your spending with DeshExpense.')">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        html {
            scroll-behavior: smooth;
            scroll-padding-top: 85px;
        }
    </style>

    @stack('styles')
</head>

<body class="bg-white text-slate-800 antialiased">

    @include('public.components.navbar')

    <main>
        @yield('content')
    </main>

    @include('public.components.footer')

    @stack('scripts')

</body>

</html>

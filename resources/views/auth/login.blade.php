
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Login | DeshExpense</title>

    @vite('resources/css/app.css')
</head>

<body class="flex min-h-screen items-center justify-center bg-slate-950 px-4">

    <!-- Background -->
    <div class="fixed inset-0 bg-gradient-to-br from-blue-950 via-slate-900 to-violet-950"></div>

    <!-- Login Card -->
    <div class="relative z-10 w-full max-w-md rounded-3xl border border-white/20
        bg-white/95 p-8 shadow-2xl backdrop-blur-xl">

        <!-- Brand -->
        <div class="mb-8 text-center">

            <div class="mx-auto mb-4 flex h-14 w-14 items-center justify-center
                rounded-2xl bg-blue-600 text-2xl font-bold text-white">
                D
            </div>

            <h1 class="text-3xl font-bold text-slate-900">
                Welcome Back!
            </h1>

            <p class="mt-2 text-sm text-slate-500">
                Login to manage your expenses.
            </p>

        </div>


        <!-- Success Message -->
        @if(session('success'))
            <div class="mb-4 rounded-xl bg-green-50 p-3 text-sm text-green-700">
                {{ session('success') }}
            </div>
        @endif


        <!-- Validation Errors -->
        @if($errors->any())
            <div class="mb-4 rounded-xl bg-red-50 p-3 text-sm text-red-600">
                {{ $errors->first() }}
            </div>
        @endif


        <!-- Login Form -->
        <form action="{{ route('login.submit') }}" method="POST">

            @csrf

            <!-- Email -->
            <div class="mb-5">

                <label class="mb-2 block text-sm font-semibold text-slate-700">
                    Email Address
                </label>

                <input
                    type="email"
                    name="email"
                    value="{{ old('email') }}"
                    placeholder="Enter your email"
                    required
                    autofocus
                    autocomplete="email"
                    class="w-full rounded-xl border border-slate-200 px-4 py-3
                    outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100">

            </div>


            <!-- Password -->
            <div class="mb-4">

                <label class="mb-2 block text-sm font-semibold text-slate-700">
                    Password
                </label>

                <input
                    type="password"
                    name="password"
                    placeholder="Enter your password"
                    required
                    autocomplete="current-password"
                    class="w-full rounded-xl border border-slate-200 px-4 py-3
                    outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100">

            </div>


            <!-- Remember Me -->
            <div class="mb-6 flex items-center gap-2">

                <input
                    type="checkbox"
                    name="remember"
                    value="1"
                    class="h-4 w-4 rounded border-slate-300 text-blue-600">

                <label class="text-sm text-slate-600">
                    Remember me
                </label>

            </div>


            <!-- Submit -->
            <button
                type="submit"
                class="w-full rounded-xl bg-blue-600 py-3 font-semibold text-white
                shadow-lg shadow-blue-500/20 transition hover:bg-blue-700">

                Login to Dashboard

            </button>

        </form>


        <!-- Register Link -->
        <p class="mt-7 text-center text-sm text-slate-500">

            Don't have an account?

            <a href="{{ route('register') }}"
                class="font-bold text-blue-600 hover:underline">
                Create Account
            </a>

        </p>

    </div>

</body>
</html>

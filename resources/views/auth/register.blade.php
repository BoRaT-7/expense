<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Register | {{ config('app.name') }}</title>
    <link rel="icon" type="image/png" href="{{ asset('logo/logo-icon.png') }}">

    @vite('resources/css/app.css')
    @include('components.theme-script')
</head>

<body class="flex min-h-screen items-center justify-center bg-slate-950 px-4 py-8">

    <!-- Background -->
    <div class="fixed inset-0 bg-gradient-to-br from-blue-950 via-slate-900 to-violet-950"></div>

    <!-- Registration Card -->
    <div
        class="relative z-10 w-full max-w-md rounded-3xl border border-white/20
        bg-white/95 p-8 shadow-2xl backdrop-blur-xl dark:border-slate-700 dark:bg-slate-900/95">

        <!-- Brand -->
        <div class="mb-7 text-center">

            <img src="{{ asset('logo/logo-transparent.png') }}" alt="{{ config('app.name') }} logo"
                class="mx-auto mb-5 h-20 w-auto max-w-full object-contain dark:hidden">
            <img src="{{ asset('logo/logo-light.png') }}" alt="{{ config('app.name') }} logo"
                class="mx-auto mb-5 hidden h-20 w-auto max-w-full object-contain dark:block">

            <h1 class="text-3xl font-bold text-slate-900 dark:text-white">
                Create Account
            </h1>

            <p class="mt-2 text-sm text-slate-500 dark:text-slate-400">
                Start managing your expenses with {{ config('app.name') }}.
            </p>

        </div>


        <!-- Validation Errors -->
        @if ($errors->any())
            <div class="mb-4 rounded-xl border border-red-200 bg-red-50 p-4 text-sm text-red-600 dark:border-red-500/30 dark:bg-red-500/10 dark:text-red-400">

                @foreach ($errors->all() as $error)
                    <p class="mb-1">{{ $error }}</p>
                @endforeach

            </div>
        @endif


        <!-- Registration Form -->
        <form action="{{ route('register.submit') }}" method="POST">

            @csrf


            <!-- Name -->
            <div class="mb-4">

                <label class="mb-2 block text-sm font-semibold text-slate-700 dark:text-slate-200">
                    Full Name
                </label>

                <input type="text" name="name" value="{{ old('name') }}" placeholder="Enter your full name"
                    required autocomplete="name"
                    class="w-full rounded-xl border border-slate-200 px-4 py-3
                    outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100 dark:border-slate-700 dark:focus:ring-blue-500/20">

            </div>


            <!-- Email -->
            <div class="mb-4">

                <label class="mb-2 block text-sm font-semibold text-slate-700 dark:text-slate-200">
                    Email Address
                </label>

                <input type="email" name="email" value="{{ old('email') }}" placeholder="Enter your email address"
                    required autocomplete="email"
                    class="w-full rounded-xl border border-slate-200 px-4 py-3
    outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100 dark:border-slate-700 dark:focus:ring-blue-500/20">

            </div>



            <!-- Password -->
            <div class="mb-4">

                <label class="mb-2 block text-sm font-semibold text-slate-700 dark:text-slate-200">
                    Password
                </label>

                <div class="relative">
                    <input type="password" id="password" name="password"
                        placeholder="Minimum 8 characters (letters and number)" required autocomplete="new-password"
                        class="w-full rounded-xl border border-slate-200 px-4 py-3 pr-12
            outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100 dark:border-slate-700 dark:focus:ring-blue-500/20">

                    <button type="button" onclick="togglePassword('password', 'passwordEye')"
                        class="absolute inset-y-0 right-4 flex items-center text-slate-400 hover:text-blue-600 transition dark:hover:text-blue-400"
                        aria-label="Show password">
                        <svg id="passwordEye" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5
                    c4.478 0 8.268 2.943 9.542 7
                    -1.274 4.057-5.064 7-9.542 7
                    -4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                    </button>
                </div>

            </div>


            <!-- Confirm Password -->
            <div class="mb-6">

                <label class="mb-2 block text-sm font-semibold text-slate-700 dark:text-slate-200">
                    Confirm Password
                </label>

                <div class="relative">
                    <input type="password" id="password_confirmation" name="password_confirmation"
                        placeholder="Confirm your password" required autocomplete="new-password"
                        class="w-full rounded-xl border border-slate-200 px-4 py-3 pr-12
            outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100 dark:border-slate-700 dark:focus:ring-blue-500/20">

                    <button type="button" onclick="togglePassword('password_confirmation', 'confirmPasswordEye')"
                        class="absolute inset-y-0 right-4 flex items-center text-slate-400 hover:text-blue-600 transition dark:hover:text-blue-400"
                        aria-label="Show confirm password">
                        <svg id="confirmPasswordEye" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5
                    c4.478 0 8.268 2.943 9.542 7
                    -1.274 4.057-5.064 7-9.542 7
                    -4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                    </button>
                </div>

            </div>


            <!-- Password Visibility Script -->
            <script>
                function togglePassword(inputId, iconId) {
                    const passwordInput = document.getElementById(inputId);
                    const eyeIcon = document.getElementById(iconId);

                    if (passwordInput.type === 'password') {
                        passwordInput.type = 'text';
                        eyeIcon.innerHTML = `
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M3 3l18 18M10.584 10.587a2 2 0 002.829 2.829" />
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M9.88 5.09A10.94 10.94 0 0112 4.9
                    c4.48 0 8.27 2.94 9.54 7
                    a11.96 11.96 0 01-4.12 5.55M6.61 6.61
                    A11.96 11.96 0 002.46 12
                    c1.27 4.06 5.06 7 9.54 7
                    1.03 0 2.02-.16 2.94-.45" />
            `;
                    } else {
                        passwordInput.type = 'password';
                        eyeIcon.innerHTML = `
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M2.458 12C3.732 7.943 7.523 5 12 5
                    c4.478 0 8.268 2.943 9.542 7
                    -1.274 4.057-5.064 7-9.542 7
                    -4.477 0-8.268-2.943-9.542-7z" />
            `;
                    }
                }
            </script>



            <!-- Submit -->
            <button type="submit"
                class="w-full rounded-xl bg-blue-600 py-3 font-semibold text-white
                shadow-lg shadow-blue-500/20 transition hover:bg-blue-700">

                Create My Account

            </button>

        </form>


        <!-- Login Link -->
        <p class="mt-7 text-center text-sm text-slate-500 dark:text-slate-400">

            Already have an account?

            <a href="{{ route('login') }}" class="font-bold text-blue-600 hover:underline dark:text-blue-400">
                Login Now
            </a>

        </p>

    </div>

</body>

</html>

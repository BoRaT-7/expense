@extends('admin.layouts.app')

@section('title', 'Users')

@php
    $userTones = [
        'bg-blue-50 text-blue-600 ring-blue-100 dark:bg-blue-500/10 dark:text-blue-400 dark:ring-blue-500/20',
        'bg-violet-50 text-violet-600 ring-violet-100 dark:bg-violet-500/10 dark:text-violet-400 dark:ring-violet-500/20',
        'bg-emerald-50 text-emerald-600 ring-emerald-100 dark:bg-emerald-500/10 dark:text-emerald-400 dark:ring-emerald-500/20',
        'bg-amber-50 text-amber-600 ring-amber-100 dark:bg-amber-500/10 dark:text-amber-400 dark:ring-amber-500/20',
        'bg-rose-50 text-rose-600 ring-rose-100 dark:bg-rose-500/10 dark:text-rose-400 dark:ring-rose-500/20',
        'bg-cyan-50 text-cyan-600 ring-cyan-100 dark:bg-cyan-500/10 dark:text-cyan-400 dark:ring-cyan-500/20',
    ];
    $userErrors = $errors->getBag('user');
    $editingUserId = old('user_id');
    $field = 'w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-800 outline-none transition focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-100';
@endphp

@section('content')

    <div class="mx-auto max-w-7xl space-y-7">

        {{-- Page Header --}}
        <div class="flex flex-col justify-between gap-4 sm:flex-row sm:items-center">

            <div>
                <div class="mb-3 flex items-center gap-2 text-sm text-slate-400">
                    <a href="{{ route('admin.dashboard') }}" class="hover:text-blue-600 dark:hover:text-blue-400">Dashboard</a>
                    <span>/</span>
                    <span class="font-semibold text-blue-600 dark:text-blue-400">Users</span>
                </div>

                <h1 class="text-2xl font-extrabold tracking-tight text-slate-800 md:text-3xl dark:text-slate-100">
                    User Accounts
                </h1>

                <p class="mt-2 text-sm text-slate-500 dark:text-slate-400">
                    Create login accounts here. Users sign in with the email and password you set.
                </p>
            </div>

            <button type="button" id="openUserModal"
                class="inline-flex items-center justify-center gap-2 rounded-xl bg-blue-600 px-5 py-3 text-sm font-semibold text-white shadow-lg shadow-blue-600/20 transition hover:-translate-y-0.5 hover:bg-blue-700">
                <span class="text-xl leading-none">+</span>
                Create New User
            </button>

        </div>

        {{-- Flash Messages --}}
        @if (session('success'))
            <div class="rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-700 dark:border-emerald-500/30 dark:bg-emerald-500/10 dark:text-emerald-300">{{ session('success') }}</div>
        @endif

        @if (session('error'))
            <div class="rounded-xl border border-rose-200 bg-rose-50 px-4 py-3 text-sm font-medium text-rose-700 dark:border-rose-500/30 dark:bg-rose-500/10 dark:text-rose-300">{{ session('error') }}</div>
        @endif

        {{-- Summary Cards --}}
        <div class="grid grid-cols-1 gap-5 sm:grid-cols-3">

            @foreach ([
                ['label' => 'Total Users', 'value' => $users->count(), 'hint' => 'Accounts that can log in', 'icon' => '👥', 'tone' => 'blue'],
                ['label' => 'Active Users', 'value' => $activeUserCount, 'hint' => 'Have recorded an expense', 'icon' => '✓', 'tone' => 'emerald'],
                ['label' => 'New This Month', 'value' => $newThisMonthCount, 'hint' => 'Created since '.now()->startOfMonth()->format('d M'), 'icon' => '★', 'tone' => 'violet'],
            ] as $card)
                @php
                    $toneClasses = [
                        'blue' => ['hover:border-blue-200 dark:hover:border-blue-500/40', 'bg-blue-50 text-blue-600 group-hover:bg-blue-600 dark:bg-blue-500/10 dark:text-blue-400', 'bg-blue-500'],
                        'emerald' => ['hover:border-emerald-200 dark:hover:border-emerald-500/40', 'bg-emerald-50 text-emerald-600 group-hover:bg-emerald-600 dark:bg-emerald-500/10 dark:text-emerald-400', 'bg-emerald-500'],
                        'violet' => ['hover:border-violet-200 dark:hover:border-violet-500/40', 'bg-violet-50 text-violet-600 group-hover:bg-violet-600 dark:bg-violet-500/10 dark:text-violet-400', 'bg-violet-500'],
                    ][$card['tone']];
                @endphp
                <div class="group relative overflow-hidden rounded-2xl border border-slate-200 bg-white p-5 shadow-sm transition-all duration-300 hover:-translate-y-1 hover:shadow-lg dark:border-slate-700 dark:bg-slate-900 {{ $toneClasses[0] }}">
                    <div class="flex items-start justify-between gap-3">
                        <div class="min-w-0">
                            <p class="text-sm font-medium text-slate-500 dark:text-slate-400">{{ $card['label'] }}</p>
                            <h3 class="mt-3 truncate text-2xl font-bold tracking-tight text-slate-800 dark:text-slate-100">{{ $card['value'] }}</h3>
                            <p class="mt-2 text-xs font-medium text-slate-400">{{ $card['hint'] }}</p>
                        </div>
                        <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl text-2xl transition-colors duration-300 group-hover:text-white {{ $toneClasses[1] }}">
                            {{ $card['icon'] }}
                        </div>
                    </div>
                    <div class="absolute bottom-0 left-0 h-1 w-full {{ $toneClasses[2] }}"></div>
                </div>
            @endforeach

        </div>

        {{-- Search --}}
        <div class="flex flex-col justify-between gap-4 sm:flex-row sm:items-center">

            <div>
                <h2 class="text-lg font-bold text-slate-800 dark:text-slate-100">All Users</h2>
                <p class="mt-1 text-xs text-slate-400">Deleting a user also deletes their expenses.</p>
            </div>

            <div class="relative w-full sm:max-w-sm">
                <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400">⌕</span>
                <input type="search" id="userSearch" placeholder="Search by name or email..."
                    class="w-full rounded-xl border border-slate-200 bg-white py-3 pl-11 pr-4 text-sm outline-none transition focus:border-blue-500 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-100">
            </div>

        </div>

        {{-- User Table --}}
        <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm dark:border-slate-700 dark:bg-slate-900">
            <div class="overflow-x-auto">
                <table class="w-full min-w-[820px] text-left text-sm">

                    <thead class="border-b border-slate-200 bg-slate-50 dark:border-slate-700 dark:bg-slate-800">
                        <tr class="text-xs font-bold uppercase tracking-wider text-slate-600 dark:text-slate-300">
                            <th class="w-12 px-5 py-4">#</th>
                            <th class="px-5 py-4">User</th>
                            <th class="px-5 py-4">Role</th>
                            <th class="px-5 py-4 text-center">Expenses</th>
                            <th class="px-5 py-4 text-right">Total Amount</th>
                            <th class="px-5 py-4">Created</th>
                            <th class="px-5 py-4 text-center">Actions</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                        @foreach ($users as $user)
                            <tr class="user-row transition hover:bg-slate-50/70 dark:hover:bg-slate-800/60"
                                data-search="{{ Str::lower($user->name.' '.$user->email) }}">

                                <td class="user-index px-5 py-4 text-xs font-semibold tabular-nums text-slate-400">{{ $loop->iteration }}</td>

                                <td class="px-5 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl text-sm font-bold ring-1 {{ $userTones[crc32($user->email) % count($userTones)] }}">
                                            {{ Str::upper(mb_substr($user->name, 0, 1)) }}
                                        </div>
                                        <div class="min-w-0">
                                            <p class="max-w-[220px] truncate font-semibold text-slate-800 dark:text-slate-100" title="{{ $user->name }}">{{ $user->name }}</p>
                                            <p class="max-w-[260px] truncate text-xs text-slate-400" title="{{ $user->email }}">{{ $user->email }}</p>
                                        </div>
                                    </div>
                                </td>

                                <td class="px-5 py-4">
                                    @if ($user->isSuperAdmin())
                                        <span class="inline-flex items-center gap-1.5 rounded-full bg-violet-50 px-2.5 py-1 text-xs font-semibold text-violet-600 dark:bg-violet-500/10 dark:text-violet-400">
                                            <span class="h-1.5 w-1.5 rounded-full bg-violet-500"></span>Super Admin
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1.5 rounded-full bg-blue-50 px-2.5 py-1 text-xs font-semibold text-blue-600 dark:bg-blue-500/10 dark:text-blue-400">
                                            <span class="h-1.5 w-1.5 rounded-full bg-blue-500"></span>User
                                        </span>
                                    @endif
                                </td>

                                <td class="px-5 py-4 text-center font-semibold tabular-nums text-slate-700 dark:text-slate-200">{{ $user->expenses_count }}</td>

                                <td class="whitespace-nowrap px-5 py-4 text-right font-bold tabular-nums text-slate-800 dark:text-slate-100">৳ {{ number_format((float) $user->expenses_sum_amount, 2) }}</td>

                                <td class="whitespace-nowrap px-5 py-4 text-xs text-slate-500 dark:text-slate-400">{{ $user->created_at?->format('d M Y') }}</td>

                                <td class="px-5 py-4">
                                    <div class="flex items-center justify-center gap-2">
                                        <button type="button"
                                            class="edit-user rounded-lg border border-slate-200 px-3 py-1.5 text-xs font-semibold text-slate-600 transition hover:border-blue-200 hover:bg-blue-50 hover:text-blue-600 dark:border-slate-700 dark:text-slate-300 dark:hover:bg-blue-500/10 dark:hover:text-blue-400"
                                            data-id="{{ $user->id }}"
                                            data-name="{{ $user->name }}"
                                            data-email="{{ $user->email }}"
                                            data-url="{{ route('admin.users.update', $user) }}">
                                            Edit
                                        </button>

                                        @if ($user->isSuperAdmin())
                                            <button type="button" disabled title="The super admin account cannot be deleted"
                                                class="cursor-not-allowed rounded-lg border border-slate-100 px-3 py-1.5 text-xs font-semibold text-slate-300 dark:border-slate-800 dark:text-slate-600">
                                                Delete
                                            </button>
                                        @else
                                            <button type="button"
                                                class="delete-user rounded-lg border border-red-100 px-3 py-1.5 text-xs font-semibold text-red-500 transition hover:bg-red-50 dark:border-red-500/30 dark:hover:bg-red-500/10"
                                                data-name="{{ $user->name }}"
                                                data-expenses="{{ $user->expenses_count }}"
                                                data-url="{{ route('admin.users.destroy', $user) }}">
                                                Delete
                                            </button>
                                        @endif
                                    </div>
                                </td>

                            </tr>
                        @endforeach
                    </tbody>

                </table>
            </div>
        </div>

        {{-- Empty Search State --}}
        <div id="emptyUsers"
            class="hidden rounded-2xl border border-dashed border-slate-300 bg-white px-6 py-16 text-center dark:border-slate-600 dark:bg-slate-900">
            <div class="text-4xl">🔎</div>
            <h3 class="mt-4 font-bold text-slate-800 dark:text-slate-100">No users found</h3>
            <p class="mt-2 text-sm text-slate-400">Try searching with another name or email.</p>
        </div>

    </div>


    {{-- Create / Edit User Modal --}}
    <div id="userModal" class="fixed inset-0 z-[100] {{ $userErrors->any() ? 'flex' : 'hidden' }} items-center justify-center bg-slate-950/50 p-4 backdrop-blur-sm">

        <div class="w-full max-w-md rounded-2xl bg-white p-6 shadow-2xl motion-safe:animate-dropdown-in dark:bg-slate-900">

            <div class="mb-6 flex items-center justify-between">
                <div>
                    <h2 id="userModalTitle" class="text-xl font-extrabold text-slate-800 dark:text-slate-100">{{ $editingUserId ? 'Edit User' : 'Create New User' }}</h2>
                    <p id="userModalHint" class="mt-1 text-xs text-slate-400">{{ $editingUserId ? 'Leave the password empty to keep the current one.' : 'Share these login details with the user.' }}</p>
                </div>

                <button type="button" data-close-modal aria-label="Close"
                    class="flex h-9 w-9 items-center justify-center rounded-lg text-slate-500 hover:bg-slate-100 dark:text-slate-400 dark:hover:bg-slate-800">✕</button>
            </div>

            <form id="userForm" method="POST" autocomplete="off"
                action="{{ $editingUserId ? route('admin.users.update', $editingUserId) : route('admin.users.store') }}"
                data-store-url="{{ route('admin.users.store') }}" class="space-y-4">
                @csrf
                <input type="hidden" name="_method" id="userMethod" value="{{ $editingUserId ? 'PUT' : 'POST' }}">
                <input type="hidden" name="user_id" id="userId" value="{{ $editingUserId }}">

                <div>
                    <label for="userName" class="mb-2 block text-sm font-semibold text-slate-600 dark:text-slate-300">
                        Full Name <span class="text-rose-500">*</span>
                    </label>
                    <input type="text" id="userName" name="name" required maxlength="255" placeholder="e.g. Rahim Uddin"
                        value="{{ old('name') }}" class="{{ $field }}">
                    @if ($userErrors->has('name'))
                        <p class="mt-1 text-xs text-rose-600 dark:text-rose-400">{{ $userErrors->first('name') }}</p>
                    @endif
                </div>

                <div>
                    <label for="userEmail" class="mb-2 block text-sm font-semibold text-slate-600 dark:text-slate-300">
                        Email Address <span class="text-rose-500">*</span>
                    </label>
                    <input type="email" id="userEmail" name="email" required maxlength="255" placeholder="e.g. rahim@example.com"
                        value="{{ old('email') }}" autocomplete="off" class="{{ $field }}">
                    @if ($userErrors->has('email'))
                        <p class="mt-1 text-xs text-rose-600 dark:text-rose-400">{{ $userErrors->first('email') }}</p>
                    @endif
                </div>

                <div>
                    <label for="userPassword" class="mb-2 block text-sm font-semibold text-slate-600 dark:text-slate-300">
                        Password <span id="passwordRequired" class="text-rose-500 {{ $editingUserId ? 'hidden' : '' }}">*</span>
                    </label>
                    <div class="flex gap-2">
                        <div class="relative flex-1">
                            <input type="password" id="userPassword" name="password" minlength="8" autocomplete="new-password"
                                placeholder="{{ $editingUserId ? 'Leave empty to keep current' : 'At least 8 characters' }}"
                                @unless ($editingUserId) required @endunless
                                class="{{ $field }} pr-16">
                            <button type="button" id="togglePassword"
                                class="absolute right-3 top-1/2 -translate-y-1/2 text-xs font-semibold text-slate-500 hover:text-blue-600 dark:text-slate-400 dark:hover:text-blue-400">
                                Show
                            </button>
                        </div>
                        <button type="button" id="generatePassword"
                            class="shrink-0 rounded-xl border border-slate-200 px-3 text-xs font-semibold text-slate-600 transition hover:border-blue-200 hover:bg-blue-50 hover:text-blue-600 dark:border-slate-700 dark:text-slate-300 dark:hover:bg-blue-500/10 dark:hover:text-blue-400">
                            Generate
                        </button>
                    </div>
                    @if ($userErrors->has('password'))
                        <p class="mt-1 text-xs text-rose-600 dark:text-rose-400">{{ $userErrors->first('password') }}</p>
                    @endif
                </div>

                <div class="flex gap-3 pt-2">
                    <button type="button" data-close-modal
                        class="flex-1 rounded-xl border border-slate-200 px-4 py-3 text-sm font-semibold text-slate-600 hover:bg-slate-50 dark:border-slate-700 dark:text-slate-300 dark:hover:bg-slate-800">
                        Cancel
                    </button>

                    <button type="submit" id="userSubmit"
                        class="flex-1 rounded-xl bg-blue-600 px-4 py-3 text-sm font-semibold text-white hover:bg-blue-700">
                        {{ $editingUserId ? 'Save Changes' : 'Create Account' }}
                    </button>
                </div>

            </form>

        </div>

    </div>


    {{-- Delete Confirmation Modal --}}
    <div id="deleteUserModal" role="alertdialog" aria-modal="true" aria-labelledby="deleteUserTitle"
        class="fixed inset-0 z-[100] hidden items-center justify-center bg-slate-950/50 p-4 backdrop-blur-sm">

        <div class="w-full max-w-sm rounded-2xl bg-white p-6 text-center shadow-2xl motion-safe:animate-dropdown-in dark:bg-slate-900">

            <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-full bg-red-50 text-red-500 ring-8 ring-red-50/50 dark:bg-red-500/10 dark:text-red-400 dark:ring-red-500/5">
                <svg class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6M9 7V4a1 1 0 011-1h4a1 1 0 011 1v3M4 7h16" />
                </svg>
            </div>

            <h2 id="deleteUserTitle" class="mt-5 text-lg font-extrabold text-slate-800 dark:text-slate-100">Delete user?</h2>
            <p class="mt-2 text-sm text-slate-500 dark:text-slate-400">
                You are about to delete
                <span id="deleteUserName" class="font-semibold text-slate-800 dark:text-slate-100"></span>
                and <span id="deleteUserExpenses" class="font-semibold text-slate-800 dark:text-slate-100"></span>.
                They will no longer be able to log in. This cannot be undone.
            </p>

            <form id="deleteUserForm" method="POST" class="mt-6 flex gap-3">
                @csrf
                @method('DELETE')

                <button type="button" data-close-delete-modal
                    class="flex-1 rounded-xl border border-slate-200 px-4 py-3 text-sm font-semibold text-slate-600 transition hover:bg-slate-50 dark:border-slate-700 dark:text-slate-300 dark:hover:bg-slate-800">
                    Cancel
                </button>

                <button type="submit" id="confirmDeleteUser"
                    class="flex-1 rounded-xl bg-red-600 px-4 py-3 text-sm font-semibold text-white shadow-lg shadow-red-600/20 transition hover:bg-red-700 disabled:cursor-wait disabled:opacity-70">
                    Yes, delete
                </button>
            </form>

        </div>

    </div>


    @push('scripts')
        <script>
            (() => {
                const modal = document.getElementById('userModal');
                const form = document.getElementById('userForm');
                const title = document.getElementById('userModalTitle');
                const hint = document.getElementById('userModalHint');
                const submit = document.getElementById('userSubmit');
                const method = document.getElementById('userMethod');
                const userId = document.getElementById('userId');
                const nameInput = document.getElementById('userName');
                const emailInput = document.getElementById('userEmail');
                const passwordInput = document.getElementById('userPassword');
                const passwordRequired = document.getElementById('passwordRequired');
                const togglePassword = document.getElementById('togglePassword');
                const search = document.getElementById('userSearch');

                const openModal = () => {
                    modal.classList.remove('hidden');
                    modal.classList.add('flex');
                    nameInput.focus();
                };

                const closeModal = () => {
                    modal.classList.add('hidden');
                    modal.classList.remove('flex');
                    modal.querySelectorAll('.text-rose-600').forEach(error => error.remove());
                };

                const setPasswordVisible = visible => {
                    passwordInput.type = visible ? 'text' : 'password';
                    togglePassword.textContent = visible ? 'Hide' : 'Show';
                };

                const setMode = isEditing => {
                    method.value = isEditing ? 'PUT' : 'POST';
                    title.textContent = isEditing ? 'Edit User' : 'Create New User';
                    hint.textContent = isEditing ? 'Leave the password empty to keep the current one.' : 'Share these login details with the user.';
                    submit.textContent = isEditing ? 'Save Changes' : 'Create Account';
                    passwordInput.required = !isEditing;
                    passwordInput.placeholder = isEditing ? 'Leave empty to keep current' : 'At least 8 characters';
                    passwordRequired.classList.toggle('hidden', isEditing);
                    passwordInput.value = '';
                    setPasswordVisible(false);
                };

                // Create
                document.getElementById('openUserModal').addEventListener('click', () => {
                    form.action = form.dataset.storeUrl;
                    userId.value = '';
                    nameInput.value = '';
                    emailInput.value = '';
                    setMode(false);
                    openModal();
                });

                // Edit
                document.querySelectorAll('.edit-user').forEach(button => {
                    button.addEventListener('click', () => {
                        form.action = button.dataset.url;
                        userId.value = button.dataset.id;
                        nameInput.value = button.dataset.name;
                        emailInput.value = button.dataset.email;
                        setMode(true);
                        openModal();
                    });
                });

                // Show / hide and generate password
                togglePassword.addEventListener('click', () => setPasswordVisible(passwordInput.type === 'password'));

                document.getElementById('generatePassword').addEventListener('click', () => {
                    const characters = 'ABCDEFGHJKLMNPQRSTUVWXYZabcdefghijkmnpqrstuvwxyz23456789';
                    const values = crypto.getRandomValues(new Uint32Array(10));
                    passwordInput.value = Array.from(values, value => characters[value % characters.length]).join('');
                    setPasswordVisible(true);
                });

                // Close
                modal.querySelectorAll('[data-close-modal]').forEach(button => button.addEventListener('click', closeModal));
                modal.addEventListener('click', event => {
                    if (event.target === modal) {
                        closeModal();
                    }
                });
                document.addEventListener('keydown', event => {
                    if (event.key === 'Escape' && !modal.classList.contains('hidden')) {
                        closeModal();
                    }
                });

                // Delete confirmation
                const deleteModal = document.getElementById('deleteUserModal');
                const deleteForm = document.getElementById('deleteUserForm');
                const confirmDelete = document.getElementById('confirmDeleteUser');

                const closeDeleteModal = () => {
                    deleteModal.classList.add('hidden');
                    deleteModal.classList.remove('flex');
                };

                document.querySelectorAll('.delete-user').forEach(button => {
                    button.addEventListener('click', () => {
                        const expenseCount = Number(button.dataset.expenses);
                        deleteForm.action = button.dataset.url;
                        document.getElementById('deleteUserName').textContent = `“${button.dataset.name}”`;
                        document.getElementById('deleteUserExpenses').textContent = `${expenseCount} ${expenseCount === 1 ? 'expense' : 'expenses'}`;
                        deleteModal.classList.remove('hidden');
                        deleteModal.classList.add('flex');
                        confirmDelete.focus();
                    });
                });

                deleteForm.addEventListener('submit', () => {
                    confirmDelete.disabled = true;
                    confirmDelete.textContent = 'Deleting…';
                });

                deleteModal.querySelectorAll('[data-close-delete-modal]').forEach(button => button.addEventListener('click', closeDeleteModal));
                deleteModal.addEventListener('click', event => {
                    if (event.target === deleteModal) {
                        closeDeleteModal();
                    }
                });
                document.addEventListener('keydown', event => {
                    if (event.key === 'Escape' && !deleteModal.classList.contains('hidden')) {
                        closeDeleteModal();
                    }
                });

                // Search
                search.addEventListener('input', () => {
                    const term = search.value.toLowerCase().trim();
                    const rows = document.querySelectorAll('.user-row');
                    let visibleCount = 0;

                    rows.forEach(row => {
                        const visible = row.dataset.search.includes(term);
                        row.classList.toggle('hidden', !visible);

                        if (visible) {
                            visibleCount++;
                            row.querySelector('.user-index').textContent = visibleCount;
                        }
                    });

                    document.getElementById('emptyUsers').classList.toggle('hidden', visibleCount > 0);
                });
            })();
        </script>
    @endpush

@endsection

@extends('admin.layouts.app')

@section('title', 'Categories')

@php
    $categoryTones = [
        'bg-blue-50 text-blue-600 ring-blue-100 dark:bg-blue-500/10 dark:text-blue-400 dark:ring-blue-500/20',
        'bg-violet-50 text-violet-600 ring-violet-100 dark:bg-violet-500/10 dark:text-violet-400 dark:ring-violet-500/20',
        'bg-emerald-50 text-emerald-600 ring-emerald-100 dark:bg-emerald-500/10 dark:text-emerald-400 dark:ring-emerald-500/20',
        'bg-amber-50 text-amber-600 ring-amber-100 dark:bg-amber-500/10 dark:text-amber-400 dark:ring-amber-500/20',
        'bg-rose-50 text-rose-600 ring-rose-100 dark:bg-rose-500/10 dark:text-rose-400 dark:ring-rose-500/20',
        'bg-cyan-50 text-cyan-600 ring-cyan-100 dark:bg-cyan-500/10 dark:text-cyan-400 dark:ring-cyan-500/20',
    ];
    $categoryErrors = $errors->getBag('category');
    $editingCategoryId = old('category_id');
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
                    <span class="font-semibold text-blue-600 dark:text-blue-400">Categories</span>
                </div>

                <h1 class="text-2xl font-extrabold tracking-tight text-slate-800 md:text-3xl dark:text-slate-100">
                    Expense Categories
                </h1>

                <p class="mt-2 text-sm text-slate-500 dark:text-slate-400">
                    Categories you add here appear in the Add Expense form.
                </p>
            </div>

            <button type="button" id="openCategoryModal"
                class="inline-flex items-center justify-center gap-2 rounded-xl bg-blue-600 px-5 py-3 text-sm font-semibold text-white shadow-lg shadow-blue-600/20 transition hover:-translate-y-0.5 hover:bg-blue-700">
                <span class="text-xl leading-none">+</span>
                Add New Category
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
        <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 xl:grid-cols-4">

            @foreach ([
                ['label' => 'Total Categories', 'value' => $categories->count(), 'hint' => 'Available in the expense form', 'icon' => '◆', 'tone' => 'blue'],
                ['label' => 'Categories In Use', 'value' => $usedCategoryCount, 'hint' => 'Have at least one expense', 'icon' => '✓', 'tone' => 'emerald'],
                ['label' => 'Total Expenses', 'value' => '৳ '.number_format($totalExpenseAmount, 2), 'hint' => 'Across all categories', 'icon' => '৳', 'tone' => 'violet'],
                ['label' => 'Most Used Category', 'value' => $mostUsedCategory?->name ?? '—', 'hint' => $mostUsedCategory ? $mostUsedCategory->expenses_count.' '.Str::plural('transaction', $mostUsedCategory->expenses_count) : 'No expenses yet', 'icon' => '★', 'tone' => 'amber'],
            ] as $card)
                @php
                    $toneClasses = [
                        'blue' => ['hover:border-blue-200 dark:hover:border-blue-500/40', 'bg-blue-50 text-blue-600 group-hover:bg-blue-600 dark:bg-blue-500/10 dark:text-blue-400', 'bg-blue-500'],
                        'emerald' => ['hover:border-emerald-200 dark:hover:border-emerald-500/40', 'bg-emerald-50 text-emerald-600 group-hover:bg-emerald-600 dark:bg-emerald-500/10 dark:text-emerald-400', 'bg-emerald-500'],
                        'violet' => ['hover:border-violet-200 dark:hover:border-violet-500/40', 'bg-violet-50 text-violet-600 group-hover:bg-violet-600 dark:bg-violet-500/10 dark:text-violet-400', 'bg-violet-500'],
                        'amber' => ['hover:border-amber-200 dark:hover:border-amber-500/40', 'bg-amber-50 text-amber-600 group-hover:bg-amber-500 dark:bg-amber-500/10 dark:text-amber-400', 'bg-amber-500'],
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
                <h2 class="text-lg font-bold text-slate-800 dark:text-slate-100">All Categories</h2>
                <p class="mt-1 text-xs text-slate-400">Rename a category and its existing expenses update too.</p>
            </div>

            <div class="relative w-full sm:max-w-sm">
                <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400">⌕</span>
                <input type="search" id="categorySearch" placeholder="Search categories..."
                    class="w-full rounded-xl border border-slate-200 bg-white py-3 pl-11 pr-4 text-sm outline-none transition focus:border-blue-500 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-100">
            </div>

        </div>

        {{-- Category Table --}}
        @if ($categories->isNotEmpty())
            <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm dark:border-slate-700 dark:bg-slate-900">
                <div class="overflow-x-auto">
                    <table class="w-full min-w-[820px] text-left text-sm">

                        <thead class="border-b border-slate-200 bg-slate-50 dark:border-slate-700 dark:bg-slate-800">
                            <tr class="text-xs font-bold uppercase tracking-wider text-slate-600 dark:text-slate-300">
                                <th class="w-12 px-5 py-4">#</th>
                                <th class="px-5 py-4">Category</th>
                                <th class="px-5 py-4">Status</th>
                                <th class="px-5 py-4 text-center">Transactions</th>
                                <th class="px-5 py-4 text-right">Total Amount</th>
                                <th class="w-44 px-5 py-4">Share</th>
                                <th class="px-5 py-4">Created</th>
                                <th class="px-5 py-4 text-center">Actions</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                            @foreach ($categories as $category)
                                @php
                                    $categoryAmount = (float) $category->expenses_sum_amount;
                                    $categoryShare = $totalExpenseAmount > 0 ? round($categoryAmount / $totalExpenseAmount * 100, 1) : 0;
                                @endphp

                                <tr class="category-row transition hover:bg-slate-50/70 dark:hover:bg-slate-800/60"
                                    data-name="{{ Str::lower($category->name.' '.$category->description) }}">

                                    <td class="category-index px-5 py-4 text-xs font-semibold tabular-nums text-slate-400">{{ $loop->iteration }}</td>

                                    <td class="px-5 py-4">
                                        <div class="flex items-center gap-3">
                                            <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl text-sm font-bold ring-1 {{ $categoryTones[crc32($category->name) % count($categoryTones)] }}">
                                                {{ Str::upper(mb_substr($category->name, 0, 1)) }}
                                            </div>
                                            <div class="min-w-0">
                                                <p class="max-w-[220px] truncate font-semibold text-slate-800 dark:text-slate-100" title="{{ $category->name }}">{{ $category->name }}</p>
                                                <p class="max-w-[260px] truncate text-xs text-slate-400" title="{{ $category->description }}">{{ $category->description ?: 'No description' }}</p>
                                            </div>
                                        </div>
                                    </td>

                                    <td class="px-5 py-4">
                                        @if ($category->expenses_count > 0)
                                            <span class="inline-flex items-center gap-1.5 rounded-full bg-emerald-50 px-2.5 py-1 text-xs font-semibold text-emerald-600 dark:bg-emerald-500/10 dark:text-emerald-400">
                                                <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>In use
                                            </span>
                                        @else
                                            <span class="inline-flex items-center gap-1.5 rounded-full bg-slate-100 px-2.5 py-1 text-xs font-semibold text-slate-500 dark:bg-slate-800 dark:text-slate-400">
                                                <span class="h-1.5 w-1.5 rounded-full bg-slate-400"></span>Unused
                                            </span>
                                        @endif
                                    </td>

                                    <td class="px-5 py-4 text-center font-semibold tabular-nums text-slate-700 dark:text-slate-200">{{ $category->expenses_count }}</td>

                                    <td class="whitespace-nowrap px-5 py-4 text-right font-bold tabular-nums text-slate-800 dark:text-slate-100">৳ {{ number_format($categoryAmount, 2) }}</td>

                                    <td class="px-5 py-4">
                                        <div class="flex items-center gap-2">
                                            <div class="h-1.5 flex-1 overflow-hidden rounded-full bg-slate-100 dark:bg-slate-800">
                                                <div class="h-full rounded-full bg-blue-500" style="width: {{ $categoryShare }}%"></div>
                                            </div>
                                            <span class="w-11 text-right text-xs font-semibold tabular-nums text-slate-500 dark:text-slate-400">{{ $categoryShare }}%</span>
                                        </div>
                                    </td>

                                    <td class="whitespace-nowrap px-5 py-4 text-xs text-slate-500 dark:text-slate-400">{{ $category->created_at?->format('d M Y') }}</td>

                                    <td class="px-5 py-4">
                                        <div class="flex items-center justify-center gap-2">
                                            <button type="button"
                                                class="edit-category rounded-lg border border-slate-200 px-3 py-1.5 text-xs font-semibold text-slate-600 transition hover:border-blue-200 hover:bg-blue-50 hover:text-blue-600 dark:border-slate-700 dark:text-slate-300 dark:hover:bg-blue-500/10 dark:hover:text-blue-400"
                                                data-id="{{ $category->id }}"
                                                data-name="{{ $category->name }}"
                                                data-description="{{ $category->description }}"
                                                data-url="{{ route('admin.categories.update', $category) }}">
                                                Edit
                                            </button>

                                            @if ($category->expenses_count > 0)
                                                <button type="button" disabled
                                                    title="Used by {{ $category->expenses_count }} {{ Str::plural('expense', $category->expenses_count) }} — cannot be deleted"
                                                    class="cursor-not-allowed rounded-lg border border-slate-100 px-3 py-1.5 text-xs font-semibold text-slate-300 dark:border-slate-800 dark:text-slate-600">
                                                    Delete
                                                </button>
                                            @else
                                                <button type="button"
                                                    class="delete-category rounded-lg border border-red-100 px-3 py-1.5 text-xs font-semibold text-red-500 transition hover:bg-red-50 dark:border-red-500/30 dark:hover:bg-red-500/10"
                                                    data-name="{{ $category->name }}"
                                                    data-url="{{ route('admin.categories.destroy', $category) }}">
                                                    Delete
                                                </button>
                                            @endif
                                        </div>
                                    </td>

                                </tr>
                            @endforeach
                        </tbody>

                        <tfoot class="border-t border-slate-200 bg-slate-50 dark:border-slate-700 dark:bg-slate-800">
                            <tr class="font-bold text-slate-800 dark:text-slate-100">
                                <td class="px-5 py-4" colspan="3">Total ({{ $categories->count() }} {{ Str::plural('category', $categories->count()) }})</td>
                                <td class="px-5 py-4 text-center tabular-nums">{{ $categories->sum('expenses_count') }}</td>
                                <td class="whitespace-nowrap px-5 py-4 text-right tabular-nums">৳ {{ number_format($totalExpenseAmount, 2) }}</td>
                                <td class="px-5 py-4" colspan="3"></td>
                            </tr>
                        </tfoot>

                    </table>
                </div>
            </div>

            {{-- Empty Search State --}}
            <div id="emptyCategories"
                class="hidden rounded-2xl border border-dashed border-slate-300 bg-white px-6 py-16 text-center dark:border-slate-600 dark:bg-slate-900">
                <div class="text-4xl">🔎</div>
                <h3 class="mt-4 font-bold text-slate-800 dark:text-slate-100">No categories found</h3>
                <p class="mt-2 text-sm text-slate-400">Try searching with another category name.</p>
            </div>
        @else
            {{-- No Categories Yet --}}
            <div class="rounded-2xl border border-dashed border-slate-300 bg-white px-6 py-16 text-center dark:border-slate-600 dark:bg-slate-900">
                <div class="text-4xl">🗂️</div>
                <h3 class="mt-4 font-bold text-slate-800 dark:text-slate-100">No categories yet</h3>
                <p class="mt-2 text-sm text-slate-400">Add your first category to start recording expenses.</p>
            </div>
        @endif

    </div>


    {{-- Add / Edit Category Modal --}}
    <div id="categoryModal" class="fixed inset-0 z-[100] {{ $categoryErrors->any() ? 'flex' : 'hidden' }} items-center justify-center bg-slate-950/50 p-4 backdrop-blur-sm">

        <div class="w-full max-w-md rounded-2xl bg-white p-6 shadow-2xl motion-safe:animate-dropdown-in dark:bg-slate-900">

            <div class="mb-6 flex items-center justify-between">
                <div>
                    <h2 id="modalTitle" class="text-xl font-extrabold text-slate-800 dark:text-slate-100">{{ $editingCategoryId ? 'Edit Category' : 'Add New Category' }}</h2>
                    <p class="mt-1 text-xs text-slate-400">It will be available in the Add Expense form.</p>
                </div>

                <button type="button" data-close-modal aria-label="Close"
                    class="flex h-9 w-9 items-center justify-center rounded-lg text-slate-500 hover:bg-slate-100 dark:text-slate-400 dark:hover:bg-slate-800">✕</button>
            </div>

            <form id="categoryForm" method="POST"
                action="{{ $editingCategoryId ? route('admin.categories.update', $editingCategoryId) : route('admin.categories.store') }}"
                data-store-url="{{ route('admin.categories.store') }}" class="space-y-4">
                @csrf
                <input type="hidden" name="_method" id="categoryMethod" value="{{ $editingCategoryId ? 'PUT' : 'POST' }}">
                <input type="hidden" name="category_id" id="categoryId" value="{{ $editingCategoryId }}">

                <div>
                    <label for="categoryName" class="mb-2 block text-sm font-semibold text-slate-600 dark:text-slate-300">
                        Category Name <span class="text-rose-500">*</span>
                    </label>
                    <input type="text" id="categoryName" name="name" required maxlength="60" placeholder="e.g. Office Supplies"
                        value="{{ old('name') }}" class="{{ $field }}">
                    @if ($categoryErrors->has('name'))
                        <p class="mt-1 text-xs text-rose-600 dark:text-rose-400">{{ $categoryErrors->first('name') }}</p>
                    @endif
                </div>

                <div>
                    <label for="categoryDescription" class="mb-2 block text-sm font-semibold text-slate-600 dark:text-slate-300">Description</label>
                    <textarea id="categoryDescription" name="description" rows="3" maxlength="255" placeholder="Write a short description..."
                        class="{{ $field }}">{{ old('description') }}</textarea>
                    @if ($categoryErrors->has('description'))
                        <p class="mt-1 text-xs text-rose-600 dark:text-rose-400">{{ $categoryErrors->first('description') }}</p>
                    @endif
                </div>

                <div class="flex gap-3 pt-2">
                    <button type="button" data-close-modal
                        class="flex-1 rounded-xl border border-slate-200 px-4 py-3 text-sm font-semibold text-slate-600 hover:bg-slate-50 dark:border-slate-700 dark:text-slate-300 dark:hover:bg-slate-800">
                        Cancel
                    </button>

                    <button type="submit"
                        class="flex-1 rounded-xl bg-blue-600 px-4 py-3 text-sm font-semibold text-white hover:bg-blue-700">
                        Save Category
                    </button>
                </div>

            </form>

        </div>

    </div>


    {{-- Delete Confirmation Modal --}}
    <div id="deleteCategoryModal" role="alertdialog" aria-modal="true" aria-labelledby="deleteCategoryTitle"
        class="fixed inset-0 z-[100] hidden items-center justify-center bg-slate-950/50 p-4 backdrop-blur-sm">

        <div class="w-full max-w-sm rounded-2xl bg-white p-6 text-center shadow-2xl motion-safe:animate-dropdown-in dark:bg-slate-900">

            <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-full bg-red-50 text-red-500 ring-8 ring-red-50/50 dark:bg-red-500/10 dark:text-red-400 dark:ring-red-500/5">
                <svg class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6M9 7V4a1 1 0 011-1h4a1 1 0 011 1v3M4 7h16" />
                </svg>
            </div>

            <h2 id="deleteCategoryTitle" class="mt-5 text-lg font-extrabold text-slate-800 dark:text-slate-100">Delete category?</h2>
            <p class="mt-2 text-sm text-slate-500 dark:text-slate-400">
                You are about to delete
                <span id="deleteCategoryName" class="font-semibold text-slate-800 dark:text-slate-100"></span>.
                It will no longer appear in the Add Expense form. This cannot be undone.
            </p>

            <form id="deleteCategoryForm" method="POST" class="mt-6 flex gap-3">
                @csrf
                @method('DELETE')

                <button type="button" data-close-delete-modal
                    class="flex-1 rounded-xl border border-slate-200 px-4 py-3 text-sm font-semibold text-slate-600 transition hover:bg-slate-50 dark:border-slate-700 dark:text-slate-300 dark:hover:bg-slate-800">
                    Cancel
                </button>

                <button type="submit" id="confirmDeleteCategory"
                    class="flex-1 rounded-xl bg-red-600 px-4 py-3 text-sm font-semibold text-white shadow-lg shadow-red-600/20 transition hover:bg-red-700 disabled:cursor-wait disabled:opacity-70">
                    Yes, delete
                </button>
            </form>

        </div>

    </div>


    @push('scripts')
        <script>
            (() => {
                const modal = document.getElementById('categoryModal');
                const form = document.getElementById('categoryForm');
                const title = document.getElementById('modalTitle');
                const method = document.getElementById('categoryMethod');
                const categoryId = document.getElementById('categoryId');
                const nameInput = document.getElementById('categoryName');
                const descriptionInput = document.getElementById('categoryDescription');
                const search = document.getElementById('categorySearch');

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

                // Add
                document.getElementById('openCategoryModal').addEventListener('click', () => {
                    form.action = form.dataset.storeUrl;
                    method.value = 'POST';
                    categoryId.value = '';
                    nameInput.value = '';
                    descriptionInput.value = '';
                    title.textContent = 'Add New Category';
                    openModal();
                });

                // Edit
                document.querySelectorAll('.edit-category').forEach(button => {
                    button.addEventListener('click', () => {
                        form.action = button.dataset.url;
                        method.value = 'PUT';
                        categoryId.value = button.dataset.id;
                        nameInput.value = button.dataset.name;
                        descriptionInput.value = button.dataset.description;
                        title.textContent = 'Edit Category';
                        openModal();
                    });
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
                const deleteModal = document.getElementById('deleteCategoryModal');
                const deleteForm = document.getElementById('deleteCategoryForm');
                const confirmDelete = document.getElementById('confirmDeleteCategory');

                const closeDeleteModal = () => {
                    deleteModal.classList.add('hidden');
                    deleteModal.classList.remove('flex');
                };

                document.querySelectorAll('.delete-category').forEach(button => {
                    button.addEventListener('click', () => {
                        deleteForm.action = button.dataset.url;
                        document.getElementById('deleteCategoryName').textContent = `“${button.dataset.name}”`;
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
                    const rows = document.querySelectorAll('.category-row');
                    let visibleCount = 0;

                    rows.forEach(row => {
                        const visible = row.dataset.name.includes(term);
                        row.classList.toggle('hidden', !visible);

                        if (visible) {
                            visibleCount++;
                            row.querySelector('.category-index').textContent = visibleCount;
                        }
                    });

                    document.getElementById('emptyCategories')?.classList.toggle('hidden', visibleCount > 0 || rows.length === 0);
                });
            })();
        </script>
    @endpush

@endsection

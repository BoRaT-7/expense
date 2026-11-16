@extends('admin.layouts.app')

    @section('title', isset($expense) ? 'Edit Expense' : 'Add Expense')

@php
    $input =
        'h-12 w-full rounded-xl border border-slate-400 bg-slate-50/60 px-4 text-sm text-slate-800 outline-none transition duration-200 placeholder:text-slate-400 hover:border-slate-300 hover:bg-white focus:border-indigo-500 focus:bg-white focus:ring-4 focus:ring-indigo-500/10 dark:border-slate-600 dark:bg-slate-800/60 dark:text-slate-100 dark:placeholder:text-slate-500 dark:hover:border-slate-500 dark:hover:bg-slate-800 dark:focus:bg-slate-900 dark:focus:ring-indigo-500/20';
    $label = 'mb-2 block text-md font-semibold text-slate-700 dark:text-slate-200';
@endphp

@section('content')

    <div class="mx-auto max-w-4xl space-y-6">

        {{-- Page Header --}}
        <div class="flex flex-col justify-between gap-4 sm:flex-row sm:items-end">

            <div>
                <nav class="mb-3 flex items-center gap-2 text-sm">
                    <a href="{{ route('admin.dashboard') }}"
                        class="font-medium text-slate-400 transition hover:text-indigo-600 dark:hover:text-indigo-400">Dashboard</a>
                    <span class="text-slate-300 dark:text-slate-600">/</span>
                    <span class="font-semibold text-indigo-600 dark:text-indigo-400">Add Expense</span>
                </nav>

                <h1 class="text-2xl font-bold tracking-tight text-slate-900 md:text-3xl dark:text-white">{{ isset($expense) ? 'Edit Expense' : 'Add New Expense' }}</h1>
                <p class="mt-1.5 text-sm text-slate-500 dark:text-slate-400">Record and organize your business expenses in one place.</p>
            </div>

            <a href="{{ route('admin.dashboard') }}"
                class="inline-flex items-center justify-center gap-2 rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm font-semibold text-slate-600 shadow-sm transition hover:border-indigo-200 hover:bg-indigo-50 hover:text-indigo-600 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-300 dark:hover:border-indigo-500/40 dark:hover:bg-indigo-500/10 dark:hover:text-indigo-400">
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                </svg>
                Back to Dashboard
            </a>
        </div>

        {{-- Single Form Card --}}
        @if (session('success'))
            <div class="rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-700 dark:border-emerald-500/30 dark:bg-emerald-500/10 dark:text-emerald-300">{{ session('success') }}</div>
        @endif

        @if ($errors->any())
            <div class="rounded-xl border border-rose-200 bg-rose-50 px-4 py-3 text-sm text-rose-700 dark:border-rose-500/30 dark:bg-rose-500/10 dark:text-rose-300">Please correct the highlighted expense details.</div>
        @endif

        <form id="expenseForm" action="{{ isset($expense) ? route('admin.expenses.update', $expense->id) : route('admin.expenses.store') }}" method="POST" enctype="multipart/form-data" class="rounded-2xl border border-slate-200 bg-white shadow-sm dark:border-slate-700 dark:bg-slate-900">
            @csrf
            @if (isset($expense)) @method('PUT') @endif

            {{-- Card Header --}}
            <header class="flex items-center gap-3 border-b border-slate-100 px-6 py-5 dark:border-slate-800">
                <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-indigo-50 text-indigo-600 dark:bg-indigo-500/10 dark:text-indigo-400">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M9 12h6m-6 4h6M7 4h10a2 2 0 012 2v14l-3-2-2 2-2-2-2 2-2-2-3 2V6a2 2 0 012-2z" />
                    </svg>
                </span>
                <div>
                    <h2 class="text-base font-semibold text-slate-800 dark:text-slate-100">Expense Details</h2>
                    <p class="text-xs text-slate-500 dark:text-slate-400">Fill in the information about this expense</p>
                </div>
            </header>

            {{-- Fields --}}
            <div class="grid grid-cols-1 gap-5 p-6 md:grid-cols-2">

                {{-- Title --}}
                <div class="md:col-span-2">
                    <label for="title" class="{{ $label }}">
                        Expense Title <span class="text-rose-500">*</span>
                    </label>
                    <input id="title" name="title" type="text" value="{{ old('title', $expense->title ?? '') }}" required placeholder="e.g. Office Rent, Electricity Bill" class="{{ $input }}">
                    @error('title') <p class="mt-1 text-xs text-rose-600 dark:text-rose-400">{{ $message }}</p> @enderror
                </div>

                {{-- Category --}}
                <div>
                    <div class="mb-2 flex items-center justify-between gap-3">
                        <label for="category" class="{{ $label }} !mb-0">
                            Category <span class="text-rose-500">*</span>
                        </label>
                        <a href="{{ route('admin.categories.index') }}"
                            class="text-xs font-semibold text-indigo-600 transition hover:text-indigo-700 hover:underline dark:text-indigo-400">
                            + Manage categories
                        </a>
                    </div>
                    <div class="relative">
                        <select id="category" name="category" required class="{{ $input }} appearance-none pr-10">
                            <option value="">{{ $categories->isEmpty() ? 'No categories yet — add one first' : 'Select a category' }}</option>
                            @foreach ($categories as $categoryOption)
                                <option value="{{ $categoryOption }}" @selected(old('category', $expense->category ?? '') === $categoryOption)>{{ $categoryOption }}</option>
                            @endforeach
                        </select>
                        <svg class="pointer-events-none absolute right-4 top-1/2 h-4 w-4 -translate-y-1/2 text-slate-400"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m6 9 6 6 6-6" />
                        </svg>
                    </div>
                    @error('category') <p class="mt-1 text-xs text-rose-600 dark:text-rose-400">{{ $message }}</p> @enderror
                </div>

                {{-- Amount --}}
                <div>
                    <label for="amount" class="{{ $label }}">
                        Amount <span class="text-rose-500">*</span>
                    </label>
                    <div class="relative">
                        <span
                            class="pointer-events-none absolute left-0 top-0 flex h-12 w-11 items-center justify-center rounded-l-xl border-r border-slate-200 text-sm font-bold text-slate-500 dark:border-slate-700 dark:text-slate-400">৳</span>
                        <input id="amount" name="amount" type="number" min="0.01" step="0.01" value="{{ old('amount', $expense->amount ?? '') }}" required placeholder="0.00"
                            class="{{ $input }} pl-14">
                    </div>
                </div>

                {{-- Date --}}
                <div>
                    <label for="date" class="{{ $label }}">
                        Expense Date <span class="text-rose-500">*</span>
                    </label>
                    <input id="date" name="date" type="date" value="{{ old('date', isset($expense) ? $expense->expense_date->toDateString() : now()->toDateString()) }}" required class="{{ $input }}">
                </div>

                {{-- Payment Method --}}
                <div>
                    <label for="payment" class="{{ $label }}">Payment Method</label>
                    <div class="relative">
                        <select id="payment" name="payment_method" class="{{ $input }} appearance-none pr-10">
                            <option value="">Select payment method</option>
                            @foreach (['Cash', 'Bank Transfer', 'Credit Card', 'Debit Card', 'Mobile Banking'] as $paymentOption)
                                <option value="{{ $paymentOption }}" @selected(old('payment_method', $expense->payment_method ?? '') === $paymentOption)>{{ $paymentOption }}</option>
                            @endforeach
                        </select>
                        <svg class="pointer-events-none absolute right-4 top-1/2 h-4 w-4 -translate-y-1/2 text-slate-400"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m6 9 6 6 6-6" />
                        </svg>
                    </div>
                </div>

                {{-- Merchant --}}
                <div class="md:col-span-2">
                    <label for="merchant" class="{{ $label }}">Merchant / Paid To</label>
                    <input id="merchant" name="merchant" type="text" value="{{ old('merchant', $expense->merchant ?? '') }}" placeholder="Shop, company or person's name"
                        class="{{ $input }}">
                </div>

                {{-- Notes + Receipt (combined) --}}
                <div class="md:col-span-2">
                    <div class="rounded-xl border border-slate-200 bg-slate-50/40 p-5 dark:border-slate-700 dark:bg-slate-800/40">

                        <div class="mb-5">
                            <label for="notes" class="{{ $label }}">
                                Description / Notes
                                <span class="ml-1 font-normal text-slate-400">(Optional)</span>
                            </label>
                            <textarea id="notes" name="notes" rows="4"
                                placeholder="Write additional information about this expense..."
                                class="w-full resize-none rounded-xl border border-slate-200 bg-white px-4 py-3.5 text-sm text-slate-800 outline-none transition duration-200 placeholder:text-slate-400 hover:border-slate-300 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-100 dark:hover:border-slate-500">{{ old('notes', $expense->notes ?? '') }}</textarea>
                        </div>

                        <div>
                            <span class="{{ $label }}">
                                Receipt
                                <span class="ml-1 font-normal text-slate-400">(Optional)</span>
                            </span>

                            <label for="receipt"
                                class="flex cursor-pointer flex-col items-center justify-center rounded-xl border-2 border-dashed border-slate-200 bg-white px-6 py-8 text-center transition hover:border-indigo-300 hover:bg-indigo-50/40 dark:border-slate-700 dark:bg-slate-900 dark:hover:border-indigo-400/60 dark:hover:bg-indigo-500/10">
                                <span
                                    class="mb-3 flex h-11 w-11 items-center justify-center rounded-full bg-indigo-50 text-indigo-600 dark:bg-indigo-500/10 dark:text-indigo-400">
                                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                        stroke-width="1.8">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M12 16V4m0 0L8 8m4-4l4 4M4 16v2a2 2 0 002 2h12a2 2 0 002-2v-2" />
                                    </svg>
                                </span>
                                <p class="text-sm font-semibold text-slate-700 dark:text-slate-200">
                                    <span class="text-indigo-600 dark:text-indigo-400">Click to upload</span> or drag and drop
                                </p>
                                <p class="mt-1 text-xs text-slate-400">PNG, JPG or PDF (max. 5MB)</p>
                                <p id="fileName" class="mt-3 hidden text-xs font-semibold text-emerald-600 dark:text-emerald-400"></p>
                                <input id="receipt" name="receipt" type="file" accept=".png,.jpg,.jpeg,.pdf"
                                    class="hidden">
                            </label>
                        </div>
                    </div>
                </div>

            </div>

            {{-- Form Footer --}}
            <div
                class="flex flex-col-reverse items-stretch justify-between gap-4 border-t border-slate-100 px-6 py-4 sm:flex-row sm:items-center dark:border-slate-800">

                <p class="text-xs text-slate-400">Please review your expense details before submitting.</p>

                <div class="flex flex-col-reverse gap-3 sm:flex-row">

                    <button type="button" id="resetBtn"
                        class="inline-flex items-center justify-center gap-2 rounded-xl border border-slate-200 bg-white px-5 py-2.5 text-sm font-semibold text-slate-600 transition hover:border-slate-300 hover:bg-slate-50 active:scale-[0.98] dark:border-slate-700 dark:bg-slate-900 dark:text-slate-300 dark:hover:border-slate-500 dark:hover:bg-slate-800">
                       
                        Reset Form
                    </button>

                    <button type="submit"
                        class="inline-flex items-center justify-center gap-2 rounded-xl bg-indigo-600 px-6 py-2.5 text-sm font-semibold text-white shadow-lg shadow-indigo-600/25 transition hover:-translate-y-0.5 hover:bg-indigo-700 hover:shadow-xl hover:shadow-indigo-600/30 active:translate-y-0 active:scale-[0.98]">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                        </svg>
                        {{ isset($expense) ? 'Save Changes' : 'Add Expense' }}
                    </button>

                </div>
            </div>

        </form>
    </div>

@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('expenseForm');
            const receipt = document.getElementById('receipt');
            const fileName = document.getElementById('fileName');

            // Show the selected receipt file name
            receipt.addEventListener('change', function() {
                if (this.files.length) {
                    fileName.textContent = '✓ ' + this.files[0].name;
                    fileName.classList.remove('hidden');
                } else {
                    fileName.classList.add('hidden');
                }
            });

            // Reset the form and the file name
            document.getElementById('resetBtn').addEventListener('click', function() {
                form.reset();
                fileName.classList.add('hidden');
            });
        });
    </script>
@endpush

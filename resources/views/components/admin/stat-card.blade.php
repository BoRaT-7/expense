@props(['title', 'value', 'icon', 'tone' => 'blue', 'change' => null, 'caption' => 'from last month'])

@php
    // Full class names are written out so Tailwind does not purge them.
    $tones = [
        'blue' => [
            'border' => 'from-cyan-400 via-blue-500 to-indigo-600',
            'iconBg' => 'from-blue-50 to-cyan-100',
            'iconText' => 'text-blue-600',
            'glow' => 'bg-blue-500/30',
            'cardBg' => 'to-blue-50/60 dark:to-blue-500/10',
            'stroke' => '#2563eb',
            'link' => 'bg-blue-50 text-blue-600 dark:bg-blue-500/10 dark:text-blue-400',
            'hover' => 'hover:shadow-blue-500/20',
        ],
        'green' => [
            'border' => 'from-lime-400 via-emerald-500 to-teal-600',
            'iconBg' => 'from-emerald-50 to-lime-100',
            'iconText' => 'text-emerald-600',
            'glow' => 'bg-emerald-500/30',
            'cardBg' => 'to-emerald-50/60 dark:to-emerald-500/10',
            'stroke' => '#059669',
            'link' => 'bg-emerald-50 text-emerald-600 dark:bg-emerald-500/10 dark:text-emerald-400',
            'hover' => 'hover:shadow-emerald-500/20',
        ],
        'orange' => [
            'border' => 'from-yellow-400 via-orange-500 to-rose-500',
            'iconBg' => 'from-orange-50 to-amber-100',
            'iconText' => 'text-orange-600',
            'glow' => 'bg-orange-500/30',
            'cardBg' => 'to-orange-50/60 dark:to-orange-500/10',
            'stroke' => '#ea580c',
            'link' => 'bg-orange-50 text-orange-600 dark:bg-orange-500/10 dark:text-orange-400',
            'hover' => 'hover:shadow-orange-500/20',
        ],
        'purple' => [
            'border' => 'from-fuchsia-400 via-violet-500 to-indigo-600',
            'iconBg' => 'from-violet-50 to-fuchsia-100',
            'iconText' => 'text-violet-600',
            'glow' => 'bg-violet-500/30',
            'cardBg' => 'to-violet-50/60 dark:to-violet-500/10',
            'stroke' => '#7c3aed',
            'link' => 'bg-violet-50 text-violet-600 dark:bg-violet-500/10 dark:text-violet-400',
            'hover' => 'hover:shadow-violet-500/20',
        ],
    ];

    $t = $tones[$tone] ?? $tones['blue'];
    $gradId = 'spark-' . uniqid();

    $isNegative = is_numeric($change) && $change < 0;
    $changeValue = is_numeric($change) ? abs($change) : $change;
@endphp

<div
    class="group relative min-h-[80px] overflow-hidden rounded-3xl border border-white bg-gradient-to-br from-white dark:border-slate-800 dark:from-slate-900 {{ $t['cardBg'] }} p-5 shadow-[0_10px_30px_-12px_rgba(16,26,64,0.18)] ring-1 ring-slate-200/70 dark:shadow-black/40 dark:ring-slate-700/70 transition-all duration-300 hover:-translate-y-1 hover:shadow-2xl {{ $t['hover'] }}">

    {{-- Soft corner glow --}}
    <div class="pointer-events-none absolute -right-12 -top-12 h-40 w-40 rounded-full blur-3xl {{ $t['glow'] }}">
    </div>

    <div class="relative z-10 flex items-center gap-4">

        {{-- Icon: gradient border + soft tinted tile + colored icon --}}
        <div class="relative shrink-0">
            <div class="absolute inset-0 rounded-2xl blur-md opacity-60 bg-gradient-to-br {{ $t['border'] }}"></div>

            {{-- <div class="relative rounded-2xl bg-gradient-to-br p-[2px] {{ $t['border'] }}">
                <div
                    class="flex h-[56px] w-[56px] items-center justify-center rounded-[14px] bg-gradient-to-br text-2xl transition-transform duration-300 group-hover:scale-105 group-hover:rotate-3 {{ $t['iconBg'] }} {{ $t['iconText'] }}">
                    {{ $icon }}
                </div>
            </div> --}}
        </div>

        <div class="min-w-0">
            <p class="truncate text-[12px] font-bold uppercase tracking-[0.12em] text-slate-500 dark:text-slate-400">
                {{ $title }}
            </p>

            <h3 class="mt-1.5 truncate text-[28px] font-extrabold leading-none tracking-tight text-[#101a40] dark:text-white">
                {{ $value }}
            </h3>
        </div>

    </div>

    <div class="relative z-10 mt-5 flex items-center gap-2 text-xs">

        @if ($change !== null)
            <span
                class="inline-flex items-center gap-1 rounded-full px-2.5 py-1 font-bold {{ $isNegative ? 'bg-rose-50 text-rose-600 dark:bg-rose-500/10 dark:text-rose-400' : 'bg-emerald-50 text-emerald-600 dark:bg-emerald-500/10 dark:text-emerald-400' }}">
                {{ $isNegative ? '↓' : '↑' }} {{ $changeValue }}%
            </span>

            <span class="text-slate-500 dark:text-slate-400">{{ $caption }}</span>
        @else
            <span class="inline-flex items-center gap-1 rounded-full px-3 py-1 font-semibold {{ $t['link'] }}">
                View Requests
                <span class="transition-transform duration-300 group-hover:translate-x-1">→</span>
            </span>
        @endif

    </div>

    {{-- Decorative mini chart --}}
    <svg class="pointer-events-none absolute bottom-0 right-0 h-[64px] w-[130px] opacity-80" viewBox="0 0 130 65"
        fill="none" aria-hidden="true">
        <defs>
            <linearGradient id="{{ $gradId }}" x1="0" y1="0" x2="0" y2="1">
                <stop offset="0%" stop-color="{{ $t['stroke'] }}" stop-opacity="0.25" />
                <stop offset="100%" stop-color="{{ $t['stroke'] }}" stop-opacity="0" />
            </linearGradient>
        </defs>
        <path d="M0 57 20 43 35 47 55 29 70 33 87 19 105 23 123 5 130 5 130 65 0 65Z"
            fill="url(#{{ $gradId }})" />
        <path d="M0 57 20 43 35 47 55 29 70 33 87 19 105 23 123 5" stroke="{{ $t['stroke'] }}" stroke-width="2.2"
            stroke-linecap="round" stroke-linejoin="round" />
    </svg>

</div>

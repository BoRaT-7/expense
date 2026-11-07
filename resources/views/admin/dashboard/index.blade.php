@extends('admin.layouts.app')

@section('title', 'Dashboard')

@section('content')

    <div class="space-y-5">

        <!-- Page Heading -->
        <div class="flex flex-wrap items-end justify-between gap-4">

            <div>

                <p class="mb-1 text-sm font-medium text-blue-600">
                    OVERVIEW
                </p>

                <h1 class="text-3xl font-extrabold tracking-tight text-[#101a40] md:text-[34px]">
                    Dashboard
                </h1>

                <p class="mt-1 text-sm text-slate-600">
                    Welcome back, Admin! Here's your company expense overview.
                </p>

            </div>



            <div class="relative inline-block">
                <button type="button" id="datePickerButton"
                    class="rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm font-semibold shadow-sm hover:bg-blue-50">
                    📅 <span id="selectedDateText">This Month</span> ⌄
                </button>

                <!-- Calendar Dropdown -->
                <div id="calendarDropdown"
                    class="absolute right-0 top-full z-50 mt-2 hidden w-[320px] rounded-2xl border border-slate-200 bg-white p-4 shadow-xl">

                    <label for="dashboardDate" class="mb-2 block text-sm font-semibold text-slate-700">
                        Type a date (DD/MM/YY)
                    </label>

                    <input type="text" id="dashboardDate" inputmode="numeric" autocomplete="off" placeholder="12/05/24"
                        class="w-full rounded-xl border border-slate-200 px-3 py-3 text-sm outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100">
                    <p id="dateError" class="mt-1 hidden text-xs text-red-600">Invalid date. Use DD/MM/YY or DD/MM/YYYY.</p>

                    <!-- Month header -->
                    <div class="mt-4 flex items-center justify-between">
                        <button type="button" id="prevMonth" aria-label="Previous month"
                            class="rounded-lg px-3 py-1.5 text-lg hover:bg-slate-100">‹</button>
                        <div id="calendarTitle" class="text-sm font-semibold text-slate-800"></div>
                        <button type="button" id="nextMonth" aria-label="Next month"
                            class="rounded-lg px-3 py-1.5 text-lg hover:bg-slate-100">›</button>
                    </div>

                    <!-- Weekdays -->
                    <div class="mt-3 grid grid-cols-7 text-center text-xs font-semibold text-slate-400">
                        <div>Su</div>
                        <div>Mo</div>
                        <div>Tu</div>
                        <div>We</div>
                        <div>Th</div>
                        <div>Fr</div>
                        <div>Sa</div>
                    </div>

                    <!-- Days (filled by JS) -->
                    <div id="calendarGrid" class="mt-1 grid grid-cols-7 gap-1 text-center text-sm"></div>

                    <!-- Buttons under the calendar -->
                    <div class="mt-4 flex justify-between gap-2">
                        <button type="button" id="resetDate"
                            class="rounded-lg border border-slate-200 px-3 py-2 text-sm font-medium hover:bg-slate-50">
                            This Month
                        </button>

                        <button type="button" id="applyDate"
                            class="rounded-lg bg-blue-600 px-4 py-2 text-sm font-semibold text-white hover:bg-blue-700">
                            Apply
                        </button>
                    </div>
                </div>
            </div>

        </div>


        <!-- Statistics Cards -->
        <section class="grid grid-cols-1 gap-4 sm:grid-cols-2 2xl:grid-cols-4">

            @foreach ($stats as $stat)
                <x-admin.stat-card :title="$stat['title']" :value="$stat['value']" :icon="$stat['icon']" :tone="$stat['tone']" :change="$stat['change'] ?? null"
                    :caption="$stat['caption'] ?? 'from last month'" />
            @endforeach

        </section>

         <!--  Expense by Category Chart -->
            <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm 2xl:col-span-4">

                <h2 class="text-lg font-bold">
                    Expense by Category
                </h2>

                <div class="mt-5 flex flex-wrap items-center justify-center gap-5">

                    <div class="relative h-[190px] w-[190px]">

                        <canvas id="categoryChart"></canvas>

                        <div class="pointer-events-none absolute inset-0 flex flex-col items-center justify-center">

                            <strong class="text-xl font-extrabold">
                                ৳85,500
                            </strong>

                            <span class="text-xs text-slate-500">
                                Total
                            </span>

                        </div>

                    </div>


                    <div class="min-w-[165px] flex-1 space-y-3">

                        @foreach ($categories as $category)
                            <div class="flex items-center justify-between gap-2 text-xs">

                                <span class="flex items-center gap-2 text-slate-600">

                                    <i class="h-2.5 w-2.5 rounded-full" style="background: {{ $category['color'] }}">
                                    </i>

                                    {{ $category['name'] }}

                                </span>

                                <strong>
                                    {{ $category['percent'] }}%
                                </strong>

                            </div>
                        @endforeach

                    </div>

                </div>

            </div>


        <!-- Charts Section -->
        <section class="grid grid-cols-1 gap-4 2xl:grid-cols-12">


            <!-- Expense Trend -->

            <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm 2xl:col-span-5">

                <div class="flex flex-wrap items-start justify-between gap-3">
                    <div>
                        <h2 class="text-lg font-bold">Expense Trend</h2>
                        <p class="mt-1 text-xs text-slate-500">Total this month</p>
                        <p id="trendTotalThis" class="text-2xl font-extrabold text-[#101a40]">৳ 0</p>
                    </div>

                    <div class="text-right">
                        <p class="text-xs text-slate-500">Total last month</p>
                        <p id="trendTotalLast" class="text-lg font-bold text-slate-500">৳ 0</p>
                        <p id="trendDiff" class="mt-1 text-xs font-bold"></p>
                    </div>
                </div>

                <div class="mt-5 h-[260px]">
                    <canvas id="expenseTrend"></canvas>
                </div>

            </div>





        </section>





        <!-- Quick Actions -->
        <div class="space-y-4 2xl:col-span-4">

            <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">

                <h2 class="text-lg font-bold">
                    Quick Actions
                </h2>

                <div class="mt-4 grid grid-cols-2 gap-3">

                    <a href="{{ route('admin.expenses.create') }}"
                        class="flex min-h-[105px] flex-col items-center justify-center gap-3 rounded-2xl bg-blue-50 p-3 transition hover:-translate-y-1">

                        <span
                            class="flex h-11 w-11 items-center justify-center rounded-xl bg-blue-500 text-2xl font-bold text-white">
                            +
                        </span>

                        <span class="text-xs font-semibold">
                            Add Expense
                        </span>

                    </a>


                    <a href="{{ route('admin.reports.index') }}"
                        class="flex min-h-[105px] flex-col items-center justify-center gap-3 rounded-2xl bg-violet-50 p-3 transition hover:-translate-y-1">

                        <span
                            class="flex h-11 w-11 items-center justify-center rounded-xl bg-violet-600 text-2xl text-white">
                            ▤
                        </span>

                        <span class="text-xs font-semibold">
                            View Reports
                        </span>

                    </a>


                </div>

            </div>

        </div>



    @endsection

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {

                /* ---------------- Expense Trend Chart ---------------- */
                const trend = document.getElementById('expenseTrend');

                if (trend) {
                    // Values are in thousands (k). Labels must have the same count as the data.
                    const labels = ['Day 3', 'Day 6', 'Day 9', 'Day 12', 'Day 15', 'Day 18', 'Day 21', 'Day 24',
                        'Day 27', 'Day 30'
                    ];
                    const thisMonth = [12, 23, 22, 29, 28, 32, 25, 31, 35, 43];
                    const lastMonth = [5, 10, 11, 17, 16, 21, 19, 23, 26, 30];

                    // Totals
                    const sum = arr => arr.reduce((a, b) => a + b, 0);
                    const totalThis = sum(thisMonth);
                    const totalLast = sum(lastMonth);
                    const fmt = n => '৳ ' + n.toLocaleString('en-US') + 'k';

                    const totalThisEl = document.getElementById('trendTotalThis');
                    const totalLastEl = document.getElementById('trendTotalLast');
                    const diffEl = document.getElementById('trendDiff');

                    if (totalThisEl) totalThisEl.textContent = fmt(totalThis);
                    if (totalLastEl) totalLastEl.textContent = fmt(totalLast);

                    if (diffEl && totalLast > 0) {
                        const diff = ((totalThis - totalLast) / totalLast) * 100;
                        const up = diff >= 0;
                        diffEl.textContent = (up ? '↑ ' : '↓ ') + Math.abs(diff).toFixed(1) + '% vs last month';
                        diffEl.className = 'mt-1 text-xs font-bold ' + (up ? 'text-rose-600' : 'text-emerald-600');
                    }

                    // Plugin: draws the amount above every point of "This Month"
                    const valueLabels = {
                        id: 'valueLabels',
                        afterDatasetsDraw(chart) {
                            const {
                                ctx
                            } = chart;
                            const meta = chart.getDatasetMeta(0);
                            const data = chart.data.datasets[0].data;

                            ctx.save();
                            ctx.font = '600 11px sans-serif';
                            ctx.fillStyle = '#101a40';
                            ctx.textAlign = 'center';
                            ctx.textBaseline = 'bottom';

                            meta.data.forEach((point, i) => {
                                ctx.fillText(data[i] + 'k', point.x, point.y - 8);
                            });

                            ctx.restore();
                        }
                    };

                    new Chart(trend, {
                        type: 'line',
                        data: {
                            labels: labels,
                            datasets: [{
                                    label: 'This Month',
                                    data: thisMonth,
                                    borderColor: '#2878f5',
                                    backgroundColor: 'rgba(40,120,245,.12)',
                                    fill: true,
                                    tension: 0.4,
                                    pointRadius: 4,
                                    pointBackgroundColor: '#fff',
                                    pointBorderColor: '#2878f5',
                                    pointBorderWidth: 2
                                },
                                {
                                    label: 'Last Month',
                                    data: lastMonth,
                                    borderColor: '#c5d8fa',
                                    backgroundColor: 'rgba(197,216,250,.15)',
                                    fill: true,
                                    tension: 0.4,
                                    pointRadius: 2
                                }
                            ]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            layout: {
                                padding: {
                                    top: 22
                                }
                            },
                            interaction: {
                                mode: 'index',
                                intersect: false
                            },
                            plugins: {
                                legend: {
                                    display: false
                                },
                                tooltip: {
                                    callbacks: {
                                        label: ctx => ctx.dataset.label + ': ৳ ' + ctx.parsed.y + 'k'
                                    }
                                }
                            },
                            scales: {
                                x: {
                                    grid: {
                                        display: false
                                    }
                                },
                                y: {
                                    beginAtZero: true,
                                    grace: '10%',
                                    grid: {
                                        color: '#edf1f7'
                                    },
                                    ticks: {
                                        callback: value => value + 'k'
                                    }
                                }
                            }
                        },
                        plugins: [valueLabels]
                    });
                }

                /* ---------------- Category Doughnut Chart ---------------- */
                const category = document.getElementById('categoryChart');

                if (category) {
                    new Chart(category, {
                        type: 'doughnut',
                        data: {
                            labels: @json(collect($categories)->pluck('name')),
                            datasets: [{
                                data: @json(collect($categories)->pluck('percent')),
                                backgroundColor: @json(collect($categories)->pluck('color')),
                                borderWidth: 0,
                                hoverOffset: 5
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            cutout: '68%',
                            plugins: {
                                legend: {
                                    display: false
                                }
                            }
                        }
                    });
                }

            });
        </script>
    @endpush

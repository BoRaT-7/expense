<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Expense;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Dashboard is shared: statistics cover all users' expenses.
        $userExpenses = Expense::query();

        // Date ranges.
        $today = now()->toDateString();

        $thisMonthStart = now()->startOfMonth()->toDateString();
        $thisMonthEnd = now()->endOfMonth()->toDateString();

        $lastMonth = now()->subMonthNoOverflow();

        $lastMonthStart = $lastMonth->copy()->startOfMonth()->toDateString();
        $lastMonthEnd = $lastMonth->copy()->endOfMonth()->toDateString();

        // Dashboard statistics.
        $stats = [
            [
                'title' => 'Total Expenses',
                'value' => '৳'.number_format((float) (clone $userExpenses)->sum('amount'), 2),
                'icon' => '▣',
                'tone' => 'blue',
            ],
            [
                'title' => "Today's Expenses",
                'value' => '৳'.number_format(
                    (float) (clone $userExpenses)->whereDate('expense_date', $today)->sum('amount'),
                    2
                ),
                'icon' => '☕',
                'tone' => 'green',
            ],
            [
                'title' => 'Pending Approvals',
                'value' => (string) (clone $userExpenses)->where('status', 'pending')->count(),
                'icon' => '◷',
                'tone' => 'orange',
            ],
            [
                'title' => 'Total Transactions',
                'value' => (string) (clone $userExpenses)->count(),
                'icon' => '♟',
                'tone' => 'purple',
            ],
        ];

        // Latest five transactions.
        $transactions = (clone $userExpenses)
            ->latest('expense_date')
            ->latest('id')
            ->limit(5)
            ->get()
            ->map(fn (Expense $expense) => [
                'date' => $expense->expense_date?->format('M j, Y') ?? 'N/A',
                'description' => $expense->title,
                'category' => $expense->category,
                'amount' => '৳'.number_format((float) $expense->amount, 2),
                'status' => ucfirst($expense->status),
                'icon' => '▣',
            ]);

        // Category chart data for the current month.
        $colors = [
            '#4F7DF3',
            '#8B6CE8',
            '#20B8A5',
            '#F2B84B',
            '#E8798B',
            '#38A879',
            '#F97316',
            '#06B6D4',
        ];

        $categoryTotals = (clone $userExpenses)
            ->whereBetween('expense_date', [$thisMonthStart, $thisMonthEnd])
            ->select('category', DB::raw('SUM(amount) as total'))
            ->groupBy('category')
            ->orderByDesc('total')
            ->get();

        $categorySum = (float) $categoryTotals->sum('total');

        $categories = $categoryTotals->values()->map(fn ($row, $index) => [
            'name' => $row->category,
            'amount' => (float) $row->total,
            'percent' => $categorySum > 0
                ? round(((float) $row->total / $categorySum) * 100, 1)
                : 0,
            'color' => $colors[$index % count($colors)],
        ]);

        // Daily expense trends.
        $currentMonthDays = now()->daysInMonth;
        $lastMonthDays = $lastMonth->daysInMonth;

        $trendThisMonth = (clone $userExpenses)
            ->whereBetween('expense_date', [$thisMonthStart, $thisMonthEnd])
            ->selectRaw('DAY(expense_date) as day, SUM(amount) as total')
            ->groupBy('day')
            ->pluck('total', 'day');

        $trendLastMonth = (clone $userExpenses)
            ->whereBetween('expense_date', [$lastMonthStart, $lastMonthEnd])
            ->selectRaw('DAY(expense_date) as day, SUM(amount) as total')
            ->groupBy('day')
            ->pluck('total', 'day');

        $trendTotalThis = (float) $trendThisMonth->sum();
        $trendTotalLast = (float) $trendLastMonth->sum();

        $trendThisMonth = collect(range(1, $currentMonthDays))
            ->map(fn ($day) => (float) ($trendThisMonth[$day] ?? 0));

        $trendLastMonth = collect(range(1, $lastMonthDays))
            ->map(fn ($day) => (float) ($trendLastMonth[$day] ?? 0));

        $trendLabels = collect(range(1, $currentMonthDays))
            ->map(fn ($day) => (string) $day);

        // Return dashboard data.
        return view('admin.dashboard.index', compact(
            'stats',
            'transactions',
            'categories',
            'trendLabels',
            'trendThisMonth',
            'trendLastMonth',
            'trendTotalThis',
            'trendTotalLast'
        ));
    }
}

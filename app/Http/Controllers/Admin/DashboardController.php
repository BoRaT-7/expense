<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [

            [
                'title' => 'Total Expenses',
                'value' => '৳85,500',
                'icon' => '▣',
                'tone' => 'blue',
                'change' => 12,
            ],

            [
                'title' => "Today's Expenses",
                'value' => '৳2,350',
                'icon' => '☕',
                'tone' => 'green',
                'change' => 8,
                'caption' => 'from yesterday',
            ],

            [
                'title' => 'Pending Approvals',
                'value' => '8',
                'icon' => '◷',
                'tone' => 'orange',
            ],

            [
                'title' => 'Total Transactions',
                'value' => '245',
                'icon' => '♟',
                'tone' => 'purple',
                'change' => 15,
            ],

        ];

        $transactions = [

            [
                'date' => 'Nov 2, 2026',
                'description' => 'Tea and Coffee',
                'category' => 'Food & Refreshments',
                'amount' => '৳350',
                'status' => 'Approved',
                'icon' => '☕',
            ],

            [
                'date' => 'Nov 1, 2026',
                'description' => 'Web Hosting Renewal',
                'category' => 'IT & Hosting',
                'amount' => '৳4,000',
                'status' => 'Approved',
                'icon' => '▤',
            ],

            [
                'date' => 'Oct 31, 2026',
                'description' => 'Office Rent',
                'category' => 'Rent',
                'amount' => '৳25,000',
                'status' => 'Approved',
                'icon' => '⌂',
            ],

            [
                'date' => 'Oct 30, 2026',
                'description' => 'Travel to Client',
                'category' => 'Travel',
                'amount' => '৳3,500',
                'status' => 'Pending',
                'icon' => '✈',
            ],

            [
                'date' => 'Oct 29, 2026',
                'description' => 'Printer Ink',
                'category' => 'Office Supplies',
                'amount' => '৳1,200',
                'status' => 'Approved',
                'icon' => '▣',
            ],

        ];

        $categories = [
            [
                'name' => 'Office Supplies',
                'percent' => 30,
                'color' => '#4F7DF3',
            ],
            [
                'name' => 'Food & Drinks',
                'percent' => 22,
                'color' => '#8B6CE8',
            ],
            [
                'name' => 'Transportation',
                'percent' => 18,
                'color' => '#20B8A5',
            ],
            [
                'name' => 'Internet & Hosting',
                'percent' => 15,
                'color' => '#F2B84B',
            ],
            [
                'name' => 'Utilities',
                'percent' => 10,
                'color' => '#E8798B',
            ],
            [
                'name' => 'Marketing',
                'percent' => 5,
                'color' => '#38A879',
            ],
        ];

        $departments = [

            ['name' => 'Development', 'percent' => 35, 'color' => '#2878f5'],
            ['name' => 'Marketing', 'percent' => 28, 'color' => '#10b981'],
            ['name' => 'HR', 'percent' => 20, 'color' => '#f9a825'],
            ['name' => 'Admin', 'percent' => 17, 'color' => '#8b5cf6'],

        ];

        return view('admin.dashboard.index', compact(
            'stats',
            'transactions',
            'categories',
            'departments'
        ));
    }
}

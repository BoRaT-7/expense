<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ExpenseController;
use App\Http\Controllers\Admin\NotificationController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Auth\AuthController;
use App\Models\Expense;
use Illuminate\Support\Facades\Route;

// Root URL
Route::get('/', function () {
    return redirect()->route('login');
});

// Guest Routes
// Only visitors who are not logged in can access these routes.
Route::middleware('guest')->group(function () {

    // Login
    Route::get('/login', [AuthController::class, 'showLogin'])
        ->name('login');

    Route::post('/login', [AuthController::class, 'login'])
        ->middleware('throttle:5,1')
        ->name('login.submit');

    // Public registration is disabled: accounts are created by the super admin.
});

// Authenticated Routes
// Only logged-in users can access these pages.
Route::middleware('auth')->group(function () {

    // Logout
    Route::post('/logout', [AuthController::class, 'logout'])
        ->name('logout');

    // Admin Dashboard
    Route::prefix('admin')
        ->name('admin.')
        ->group(function () {

            // Dashboard
            Route::get('/dashboard', [
                DashboardController::class,
                'index',
            ])->name('dashboard');

            // Add Expense
            Route::get('/expenses/create', [ExpenseController::class, 'create'])->name('expenses.create');
            Route::post('/expenses', [ExpenseController::class, 'store'])->name('expenses.store');
            Route::get('/expenses/{expense}/edit', [ExpenseController::class, 'edit'])->name('expenses.edit');
            Route::put('/expenses/{expense}', [ExpenseController::class, 'update'])->name('expenses.update');
            Route::delete('/expenses/{expense}', [ExpenseController::class, 'destroy'])->name('expenses.destroy');

            // All Expenses (shared: every user sees all users' expenses)
            Route::get('/expenses/all', function () {
                return view('allexpenses.all-expenses', [
                    'expenses' => Expense::with('user')
                        ->latest('expense_date')->latest('id')->get(),
                ]);
            })->name('expenses.all');

            // My Expenses (only the logged-in user's own expenses)
            Route::get('/expenses', function () {
                $expenses = Expense::where('user_id', request()->user()->id)
                    ->latest('expense_date')->latest('id')->get();

                return view('myexpenses.my-expenses', compact('expenses'));
            })->name('expenses.index');

            // Notifications (expenses added during the last 7 days)
            Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
            Route::post('/notifications/read', [NotificationController::class, 'markAllRead'])->name('notifications.read');

            // Categories
            Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
            Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');
            Route::put('/categories/{category}', [CategoryController::class, 'update'])->name('categories.update');
            Route::delete('/categories/{category}', [CategoryController::class, 'destroy'])->name('categories.destroy');

            // User Accounts (super admin only)
            Route::middleware('super-admin')->group(function () {
                Route::get('/users', [UserController::class, 'index'])->name('users.index');
                Route::post('/users', [UserController::class, 'store'])->name('users.store');
                Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
                Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
            });

            // Reports (shared: based on all users' expenses)
            Route::get('/reports', function () {
                return view('reports.reports', [
                    'expenses' => Expense::with('user')
                        ->latest('expense_date')->get(),
                ]);
            })->name('reports.index');
        });
});

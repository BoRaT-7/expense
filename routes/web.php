
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Auth\AuthController;


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


    // Registration
    Route::get('/register', [AuthController::class, 'showRegister'])
        ->name('register');

    Route::post('/register', [AuthController::class, 'register'])
        ->middleware('throttle:3,1')
        ->name('register.submit');
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
                'index'
            ])->name('dashboard');


            // Add Expense
            Route::get('/expenses/create', function () {
                return view('expenses.create-expenses');
            })->name('expenses.create');


            // All Expenses
            Route::get('/expenses/all', function () {
                return view('allexpenses.all-expenses');
            })->name('expenses.all');


            // My Expenses
            Route::get('/expenses', function () {
                return view('myexpenses.my-expenses');
            })->name('expenses.index');


            // Categories
            Route::get('/categories', function () {
                return view('categories.categories');
            })->name('categories.index');


            // Reports
            Route::get('/reports', function () {
                return view('reports.reports');
            })->name('reports.index');
        });
});

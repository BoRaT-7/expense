<?php

namespace App\Providers;

use App\Models\Expense;
use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Maximum number of notifications rendered in the header dropdown.
     */
    private const HEADER_NOTIFICATION_LIMIT = 15;

    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer([
            'components.admin.header',
            'components.admin.sidebar',
            'components.admin.notifications',
        ], function (\Illuminate\View\View $view): void {
            $user = Auth::user();

            if (! $user) {
                return;
            }

            $view->with(once(fn (): array => $this->notificationViewData($user)));
        });
    }

    /**
     * Build the notification data shared by the admin header, sidebar and dropdown.
     *
     * @return array{headerNotifications: Collection<int, Expense>, unreadNotificationCount: int}
     */
    private function notificationViewData(User $user): array
    {
        $recentExpenses = Expense::with('user:id,name')->recentActivity()->get();

        return [
            'headerNotifications' => $recentExpenses->take(self::HEADER_NOTIFICATION_LIMIT),
            'unreadNotificationCount' => $recentExpenses
                ->filter(fn (Expense $expense): bool => $user->hasUnreadNotificationFor($expense))
                ->count(),
        ];
    }
}

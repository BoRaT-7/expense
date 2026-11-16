<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Expense;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class NotificationController extends Controller
{
    /**
     * Show every expense added during the notification window, grouped by day.
     */
    public function index(Request $request): View
    {
        $user = $request->user();

        $notifications = Expense::with('user:id,name')->recentActivity()->get();

        $unreadIds = $notifications
            ->filter(fn (Expense $expense): bool => $user->hasUnreadNotificationFor($expense))
            ->pluck('id')
            ->all();

        $groupedNotifications = $notifications->groupBy(
            fn (Expense $expense): string => $expense->created_at->toDateString()
        );

        $user->markNotificationsAsRead();

        return view('notifications.index', [
            'groupedNotifications' => $groupedNotifications,
            'unreadIds' => $unreadIds,
            'totalAmount' => (float) $notifications->sum('amount'),
            'totalCount' => $notifications->count(),
            'myCount' => $notifications->where('user_id', $user->id)->count(),
            'windowDays' => Expense::NOTIFICATION_WINDOW_DAYS,
        ]);
    }

    /**
     * Mark all expense notifications as read for the current user.
     */
    public function markAllRead(Request $request): JsonResponse|RedirectResponse
    {
        $request->user()->markNotificationsAsRead();

        if ($request->expectsJson()) {
            return response()->json(['unread' => 0]);
        }

        return back();
    }
}

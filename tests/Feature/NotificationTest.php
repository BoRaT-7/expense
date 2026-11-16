<?php

namespace Tests\Feature;

use App\Models\Expense;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class NotificationTest extends TestCase
{
    use RefreshDatabase;

    public function test_header_shows_expenses_added_in_the_last_seven_days_with_title_and_amount(): void
    {
        $user = User::factory()->create();
        $otherUser = User::factory()->create(['name' => 'Rahim Uddin']);

        Expense::factory()->for($user)->create(['title' => 'Team Lunch', 'amount' => 1250]);
        Expense::factory()->for($otherUser)->create(['title' => 'Office Chair', 'amount' => 8400.5]);
        Expense::factory()->for($user)->create([
            'title' => 'Old Printer Ink',
            'created_at' => now()->subDays(8)->startOfDay(),
        ]);

        $response = $this->actingAs($user)->get(route('admin.notifications.index'));

        $response->assertOk()
            ->assertSee('Team Lunch')
            ->assertSee('1,250.00')
            ->assertSee('Office Chair')
            ->assertSee('8,400.50')
            ->assertSee('Rahim Uddin')
            ->assertDontSee('Old Printer Ink');
    }

    public function test_unread_count_only_includes_expenses_added_after_last_read(): void
    {
        $user = User::factory()->create(['notifications_read_at' => now()->subHour()]);

        Expense::factory()->create(['created_at' => now()->subHours(2)]);
        Expense::factory()->count(2)->create(['created_at' => now()->subMinutes(5)]);

        $response = $this->actingAs($user)->get(route('admin.expenses.index'));

        $response->assertOk()->assertSee('2 new expenses since your last visit');
    }

    public function test_mark_all_read_persists_and_clears_unread_count(): void
    {
        $user = User::factory()->create();
        Expense::factory()->create();

        $this->actingAs($user)
            ->postJson(route('admin.notifications.read'))
            ->assertOk()
            ->assertJson(['unread' => 0]);

        $this->assertNotNull($user->fresh()->notifications_read_at);

        $this->actingAs($user->fresh())
            ->get(route('admin.expenses.index'))
            ->assertSee('All caught up');
    }

    public function test_sidebar_menu_shows_notifications_and_dark_mode_for_small_devices(): void
    {
        $user = User::factory()->create();
        Expense::factory()->count(3)->create();

        $this->actingAs($user)
            ->get(route('admin.expenses.index'))
            ->assertOk()
            ->assertSee('QUICK ACTIONS')
            ->assertSee('id="sidebar-theme-toggle"', false)
            ->assertSee('Open menu (3 new notifications)');
    }

    public function test_notification_query_runs_once_per_page(): void
    {
        $user = User::factory()->create();
        Expense::factory()->create();

        DB::enableQueryLog();

        $this->actingAs($user)->get(route('admin.categories.index'))->assertOk();

        $notificationQueries = collect(DB::getQueryLog())
            ->filter(fn (array $query): bool => str_contains($query['query'], 'from "expenses" where "created_at" >='));

        $this->assertCount(1, $notificationQueries);
    }

    public function test_guests_cannot_access_notifications(): void
    {
        $this->get(route('admin.notifications.index'))->assertRedirect(route('login'));
        $this->post(route('admin.notifications.read'))->assertRedirect(route('login'));
    }
}

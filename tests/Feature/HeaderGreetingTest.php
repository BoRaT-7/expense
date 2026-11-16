<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class HeaderGreetingTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Dhaka is UTC+6, so each UTC time maps to the Bangladesh hour in the comment.
     *
     * @return array<string, array{string, string}>
     */
    public static function greetingTimes(): array
    {
        return [
            'morning at 08:00 Dhaka' => ['2026-11-14 02:00:00', 'Good morning'],
            'afternoon at 14:00 Dhaka' => ['2026-11-14 08:00:00', 'Good afternoon'],
            'evening at 18:00 Dhaka' => ['2026-11-14 12:00:00', 'Good evening'],
            'night at 23:00 Dhaka' => ['2026-11-14 17:00:00', 'Good night'],
            'night at 04:59 Dhaka' => ['2026-11-13 22:59:00', 'Good night'],
        ];
    }

    #[DataProvider('greetingTimes')]
    public function test_header_greets_user_by_first_name_using_bangladesh_time(string $utcTime, string $expectedGreeting): void
    {
        $this->travelTo(Carbon::parse($utcTime, 'UTC'));

        $user = User::factory()->create(['name' => 'Moulin Talukder']);

        $this->actingAs($user)
            ->get(route('admin.expenses.index'))
            ->assertOk()
            ->assertSee('<span id="greeting-text">'.$expectedGreeting.'</span>', false)
            ->assertSee('Moulin')
            ->assertDontSee('placeholder="Search expenses, categories..."', false);
    }

    public function test_header_clock_shows_dhaka_date_and_time(): void
    {
        $this->travelTo(Carbon::parse('2026-11-14 20:30:00', 'UTC'));

        $user = User::factory()->create();

        $this->actingAs($user)
            ->get(route('admin.expenses.index'))
            ->assertSee('Sunday, 15 Nov 2026 · 02:30 AM')
            ->assertSee('· Dhaka');
    }
}

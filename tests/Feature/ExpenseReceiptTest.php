<?php

namespace Tests\Feature;

use App\Models\Expense;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExpenseReceiptTest extends TestCase
{
    use RefreshDatabase;

    public function test_my_expenses_shows_image_receipt_thumbnail(): void
    {
        $user = User::factory()->create();
        Expense::factory()->for($user)->create(['receipt_path' => 'expense-receipts/lunch.jpg']);

        $this->actingAs($user)
            ->get(route('admin.expenses.index'))
            ->assertOk()
            ->assertSee('<img src="'.asset('storage/expense-receipts/lunch.jpg').'"', false)
            ->assertSee('id="receiptModal"', false);
    }

    public function test_all_expenses_shows_receipts_from_every_user(): void
    {
        $user = User::factory()->create();
        Expense::factory()->create(['receipt_path' => 'expense-receipts/chair.png']);
        Expense::factory()->create(['receipt_path' => 'expense-receipts/invoice.pdf']);

        $this->actingAs($user)
            ->get(route('admin.expenses.all'))
            ->assertOk()
            ->assertSee('<img src="'.asset('storage/expense-receipts/chair.png').'"', false)
            ->assertSee(asset('storage/expense-receipts/invoice.pdf'))
            ->assertSee('PDF');
    }

    public function test_reports_shows_image_receipt_thumbnail(): void
    {
        $user = User::factory()->create();
        Expense::factory()->create(['receipt_path' => 'expense-receipts/taxi.jpg']);

        $this->actingAs($user)
            ->get(route('admin.reports.index'))
            ->assertOk()
            ->assertSee('<img src="'.asset('storage/expense-receipts/taxi.jpg').'"', false)
            ->assertSee('id="receiptModal"', false);
    }

    public function test_expense_without_receipt_shows_placeholder(): void
    {
        $user = User::factory()->create();
        Expense::factory()->for($user)->create(['receipt_path' => null]);

        $this->actingAs($user)
            ->get(route('admin.expenses.all'))
            ->assertOk()
            ->assertSee('No receipt');
    }
}

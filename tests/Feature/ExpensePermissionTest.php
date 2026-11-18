<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Expense;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExpensePermissionTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @return array<string, mixed>
     */
    private function validExpenseData(array $overrides = []): array
    {
        Category::firstOrCreate(['name' => 'Office Supplies']);

        return array_merge([
            'title' => 'Updated title',
            'category' => 'Office Supplies',
            'amount' => 250,
            'date' => now()->toDateString(),
        ], $overrides);
    }

    public function test_adding_an_expense_shows_a_success_popup(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->followingRedirects()
            ->post(route('admin.expenses.store'), $this->validExpenseData(['title' => 'Printer Ink', 'amount' => 450]))
            ->assertOk()
            ->assertSee('id="successPopup"', false)
            ->assertSee('Expense Added')
            ->assertSee('Printer Ink');
    }

    public function test_deleting_an_expense_shows_a_success_popup_on_the_page_it_came_from(): void
    {
        $superAdmin = User::factory()->superAdmin()->create();
        $expense = Expense::factory()->create(['title' => 'Old Chair']);

        $this->actingAs($superAdmin)
            ->followingRedirects()
            ->delete(route('admin.expenses.destroy', $expense), ['from' => 'all'])
            ->assertOk()
            ->assertSee('id="successPopup"', false)
            ->assertSee('Expense Deleted')
            ->assertSee('Old Chair');

        $this->actingAs($superAdmin)
            ->get(route('admin.expenses.all'))
            ->assertDontSee('id="successPopup"', false);
    }

    public function test_all_expenses_shows_edit_and_delete_only_on_the_users_own_expenses(): void
    {
        $user = User::factory()->create();
        $ownExpense = Expense::factory()->for($user)->create();
        $otherExpense = Expense::factory()->create();

        $this->actingAs($user)
            ->get(route('admin.expenses.all'))
            ->assertOk()
            ->assertSee(route('admin.expenses.edit', ['expense' => $ownExpense, 'from' => 'all']), false)
            ->assertSee(route('admin.expenses.destroy', $ownExpense))
            ->assertDontSee(route('admin.expenses.edit', ['expense' => $otherExpense, 'from' => 'all']), false)
            ->assertDontSee(route('admin.expenses.destroy', $otherExpense));
    }

    public function test_all_expenses_shows_edit_and_delete_on_every_expense_for_the_super_admin(): void
    {
        $superAdmin = User::factory()->superAdmin()->create();
        $expenses = Expense::factory()->count(2)->create();

        $response = $this->actingAs($superAdmin)->get(route('admin.expenses.all'))->assertOk();

        foreach ($expenses as $expense) {
            $response->assertSee(route('admin.expenses.edit', ['expense' => $expense, 'from' => 'all']), false)
                ->assertSee(route('admin.expenses.destroy', $expense));
        }
    }

    public function test_my_expenses_shows_edit_and_delete_icon_buttons(): void
    {
        $user = User::factory()->create();
        $expense = Expense::factory()->for($user)->create();

        $this->actingAs($user)
            ->get(route('admin.expenses.index'))
            ->assertOk()
            ->assertSee('title="Edit expense"', false)
            ->assertSee('title="Delete expense"', false)
            ->assertSee(route('admin.expenses.destroy', $expense));
    }

    public function test_users_cannot_edit_or_delete_someone_elses_expense(): void
    {
        $user = User::factory()->create();
        $otherExpense = Expense::factory()->create(['title' => 'Not yours']);

        $this->actingAs($user)->get(route('admin.expenses.edit', $otherExpense))->assertForbidden();
        $this->actingAs($user)->put(route('admin.expenses.update', $otherExpense), $this->validExpenseData())->assertForbidden();
        $this->actingAs($user)->delete(route('admin.expenses.destroy', $otherExpense))->assertForbidden();

        $this->assertSame('Not yours', $otherExpense->refresh()->title);
    }

    public function test_users_can_edit_and_delete_their_own_expense(): void
    {
        $user = User::factory()->create();
        $expense = Expense::factory()->for($user)->create();

        $this->actingAs($user)
            ->put(route('admin.expenses.update', $expense), $this->validExpenseData())
            ->assertRedirect(route('admin.expenses.index'));
        $this->assertSame('Updated title', $expense->refresh()->title);

        $this->actingAs($user)
            ->delete(route('admin.expenses.destroy', $expense))
            ->assertRedirect(route('admin.expenses.index'));
        $this->assertModelMissing($expense);
    }

    public function test_super_admin_can_edit_and_delete_any_users_expense_and_returns_to_all_expenses(): void
    {
        $superAdmin = User::factory()->superAdmin()->create();
        $expense = Expense::factory()->create();
        $ownerId = $expense->user_id;

        $this->actingAs($superAdmin)
            ->get(route('admin.expenses.edit', ['expense' => $expense, 'from' => 'all']))
            ->assertOk()
            ->assertSee('Editing as super admin');

        $this->actingAs($superAdmin)
            ->put(route('admin.expenses.update', $expense), $this->validExpenseData(['from' => 'all']))
            ->assertRedirect(route('admin.expenses.all'));

        $expense->refresh();
        $this->assertSame('Updated title', $expense->title);
        $this->assertSame($ownerId, $expense->user_id);

        $this->actingAs($superAdmin)
            ->delete(route('admin.expenses.destroy', $expense), ['from' => 'all'])
            ->assertRedirect(route('admin.expenses.all'));
        $this->assertModelMissing($expense);
    }
}

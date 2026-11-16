<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Expense;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CategoryTest extends TestCase
{
    use RefreshDatabase;

    public function test_categories_page_lists_categories_with_their_expense_totals(): void
    {
        $user = User::factory()->create();
        Category::factory()->create(['name' => 'Travel Costs']);
        Expense::factory()->count(2)->create(['category' => 'Travel Costs', 'amount' => 150]);

        $this->actingAs($user)
            ->get(route('admin.categories.index'))
            ->assertOk()
            ->assertSee('Travel Costs')
            ->assertSee('৳ 300.00');
    }

    public function test_added_category_appears_in_the_expense_form(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->post(route('admin.categories.store'), ['name' => 'Team Lunch', 'description' => 'Friday lunches'])
            ->assertRedirect(route('admin.categories.index'));

        $this->assertDatabaseHas('categories', ['name' => 'Team Lunch', 'description' => 'Friday lunches']);

        $this->actingAs($user)
            ->get(route('admin.expenses.create'))
            ->assertOk()
            ->assertSee('<option value="Team Lunch"', false);
    }

    public function test_category_names_must_be_unique(): void
    {
        $user = User::factory()->create();
        Category::factory()->create(['name' => 'Utilities Extra']);

        $this->actingAs($user)
            ->post(route('admin.categories.store'), ['name' => 'Utilities Extra'])
            ->assertSessionHasErrorsIn('category', 'name');
    }

    public function test_renaming_a_category_updates_its_expenses(): void
    {
        $user = User::factory()->create();
        $category = Category::factory()->create(['name' => 'Snacks']);
        $expense = Expense::factory()->create(['category' => 'Snacks']);

        $this->actingAs($user)
            ->put(route('admin.categories.update', $category), ['name' => 'Food & Snacks'])
            ->assertRedirect(route('admin.categories.index'));

        $this->assertSame('Food & Snacks', $category->fresh()->name);
        $this->assertSame('Food & Snacks', $expense->fresh()->category);
    }

    public function test_unused_category_can_be_deleted(): void
    {
        $user = User::factory()->create();
        $category = Category::factory()->create();

        $this->actingAs($user)
            ->delete(route('admin.categories.destroy', $category))
            ->assertRedirect(route('admin.categories.index'));

        $this->assertModelMissing($category);
    }

    public function test_category_used_by_expenses_cannot_be_deleted(): void
    {
        $user = User::factory()->create();
        $category = Category::factory()->create(['name' => 'Rent Plus']);
        Expense::factory()->create(['category' => 'Rent Plus']);

        $this->actingAs($user)
            ->delete(route('admin.categories.destroy', $category))
            ->assertSessionHas('error');

        $this->assertModelExists($category);
    }

    public function test_expense_must_use_an_existing_category(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->post(route('admin.expenses.store'), [
                'title' => 'Printer ink',
                'category' => 'Not A Real Category',
                'amount' => 500,
                'date' => '2026-11-14',
            ])
            ->assertSessionHasErrors('category');

        $this->assertDatabaseCount('expenses', 0);
    }
}

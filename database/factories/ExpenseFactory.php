<?php

namespace Database\Factories;

use App\Models\Expense;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Expense>
 */
class ExpenseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'title' => fake()->words(3, true),
            'category' => fake()->randomElement(['Food', 'Transport', 'Office', 'Utilities', 'Travel']),
            'amount' => fake()->randomFloat(2, 50, 5000),
            'expense_date' => fake()->dateTimeBetween('-1 month'),
            'payment_method' => fake()->randomElement(['Cash', 'Bank Transfer', 'Mobile Banking']),
            'merchant' => fake()->company(),
            'notes' => null,
            'receipt_path' => null,
            'status' => 'pending',
        ];
    }
}

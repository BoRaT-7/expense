<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Categories offered by the expense form before categories became manageable.
     *
     * @var array<int, string>
     */
    private array $defaultCategories = [
        'Office Supplies',
        'Food & Drinks',
        'Transportation',
        'Internet & Hosting',
        'Office Rent',
        'Utilities',
        'Others',
    ];

    public function up(): void
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name', 60)->unique();
            $table->string('description', 255)->nullable();
            $table->timestamps();
        });

        // Start with the previous fixed list plus any category already used by an expense.
        $names = collect($this->defaultCategories)
            ->merge(DB::table('expenses')->distinct()->pluck('category'))
            ->map(fn (string $name): string => trim($name))
            ->filter()
            ->unique(fn (string $name): string => mb_strtolower($name))
            ->values();

        $now = now();

        DB::table('categories')->insert($names->map(fn (string $name): array => [
            'name' => $name,
            'description' => null,
            'created_at' => $now,
            'updated_at' => $now,
        ])->all());
    }

    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};

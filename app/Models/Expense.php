<?php

namespace App\Models;

use Database\Factories\ExpenseFactory;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Expense extends Model
{
    /** @use HasFactory<ExpenseFactory> */
    use HasFactory;

    /**
     * Number of days of expense activity shown as notifications.
     */
    public const NOTIFICATION_WINDOW_DAYS = 7;

    protected $fillable = [
        'user_id',
        'title',
        'category',
        'amount',
        'expense_date',
        'payment_method',
        'merchant',
        'notes',
        'receipt_path',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'amount' => 'decimal:2',
            'expense_date' => 'date',
        ];
    }

    /**
     * Receipt file extensions that can be previewed as images.
     */
    public const IMAGE_RECEIPT_EXTENSIONS = ['jpg', 'jpeg', 'png', 'gif', 'webp'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Public URL of the uploaded receipt, relative to the current host.
     */
    public function receiptUrl(): ?string
    {
        return $this->receipt_path ? asset('storage/'.$this->receipt_path) : null;
    }

    /**
     * Determine whether the uploaded receipt is an image that can be previewed.
     */
    public function hasImageReceipt(): bool
    {
        $extension = strtolower(pathinfo($this->receipt_path ?? '', PATHINFO_EXTENSION));

        return in_array($extension, self::IMAGE_RECEIPT_EXTENSIONS, true);
    }

    /**
     * Expenses added within the notification window, newest first.
     */
    #[Scope]
    protected function recentActivity(Builder $query): void
    {
        $query->where('created_at', '>=', now()->subDays(self::NOTIFICATION_WINDOW_DAYS)->startOfDay())
            ->latest()
            ->latest('id');
    }
}

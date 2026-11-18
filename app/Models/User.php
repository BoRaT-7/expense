<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'notifications_read_at' => 'datetime',
            'password' => 'hashed',
            'is_super_admin' => 'boolean',
        ];
    }

    /**
     * Determine whether the user is the super admin who manages user accounts.
     */
    public function isSuperAdmin(): bool
    {
        return (bool) $this->is_super_admin;
    }

    public function expenses(): HasMany
    {
        return $this->hasMany(Expense::class);
    }

    /**
     * The user's first name, used for short, friendly greetings.
     */
    public function firstName(): string
    {
        return Str::before(trim($this->name), ' ') ?: $this->name;
    }

    /**
     * Determine whether the given expense was added after the user last read notifications.
     */
    public function hasUnreadNotificationFor(Expense $expense): bool
    {
        return $this->notifications_read_at === null
            || $expense->created_at->greaterThan($this->notifications_read_at);
    }

    /**
     * Mark every expense notification up to now as read.
     */
    public function markNotificationsAsRead(): void
    {
        $this->forceFill(['notifications_read_at' => now()])->save();
    }
}

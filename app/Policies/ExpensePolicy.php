<?php

namespace App\Policies;

use App\Models\Expense;
use App\Models\User;

class ExpensePolicy
{
    /**
     * Owners can edit their own expenses; the super admin can edit anyone's.
     */
    public function update(User $user, Expense $expense): bool
    {
        return $user->isSuperAdmin() || $expense->user_id === $user->id;
    }

    /**
     * Owners can delete their own expenses; the super admin can delete anyone's.
     */
    public function delete(User $user, Expense $expense): bool
    {
        return $this->update($user, $expense);
    }
}

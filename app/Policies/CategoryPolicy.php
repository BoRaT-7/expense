<?php

namespace App\Policies;

use App\Models\Category;
use App\Models\User;

class CategoryPolicy
{
    /**
     * Only the super admin can rename or edit a category.
     */
    public function update(User $user, Category $category): bool
    {
        return $user->isSuperAdmin();
    }

    /**
     * Only the super admin can delete a category.
     */
    public function delete(User $user, Category $category): bool
    {
        return $user->isSuperAdmin();
    }
}

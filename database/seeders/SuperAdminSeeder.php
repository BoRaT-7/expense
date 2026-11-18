<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class SuperAdminSeeder extends Seeder
{
    /**
     * Create (or restore) the super admin account that manages user accounts.
     */
    public function run(): void
    {
        $superAdminEmail = config('superadmin.super_admin_email');
        $superAdminPassword = config('superadmin.super_admin_password');
        $superAdminOldEmail = config('superadmin.super_admin_old_email');

        if (! is_string($superAdminEmail) || trim($superAdminEmail) === ''
            || ! is_string($superAdminPassword) || $superAdminPassword === '') {
            throw new \RuntimeException(
                'Super Admin credentials are missing. Set SUPER_ADMIN_EMAIL and SUPER_ADMIN_PASSWORD in the environment.'
            );
        }

        $superAdmin = User::query()->where('email', trim($superAdminEmail))->first();

        if (! $superAdmin && is_string($superAdminOldEmail) && trim($superAdminOldEmail) !== '') {
            $superAdmin = User::query()->where('email', trim($superAdminOldEmail))->first();
        }

        $superAdmin ??= new User();

        $superAdmin->forceFill([
            'name' => $superAdmin->name ?: 'Super Admin',
            'email' => trim($superAdminEmail),
            'password' => Hash::make($superAdminPassword),
            'is_super_admin' => true,
            'email_verified_at' => $superAdmin->email_verified_at ?? now(),
        ])->save();
    }
}




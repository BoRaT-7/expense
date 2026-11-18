<?php

namespace Tests\Feature;

use App\Models\Expense;
use App\Models\User;
use Database\Seeders\SuperAdminSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class UserManagementTest extends TestCase
{
    use RefreshDatabase;

    public function test_seeded_super_admin_can_log_in_and_open_the_users_page(): void
    {
        $this->seed(SuperAdminSeeder::class);

        $this->post(route('login.submit'), ['email' => 'super@gmail.com', 'password' => '221-15-6006'])
            ->assertRedirect(route('admin.dashboard'));

        $this->assertAuthenticated();
        $this->assertTrue(auth()->user()->isSuperAdmin());

        $this->get(route('admin.users.index'))
            ->assertOk()
            ->assertSee('super@gmail.com');
    }

    public function test_super_admin_sees_the_users_link_but_regular_users_do_not(): void
    {
        $this->actingAs(User::factory()->superAdmin()->create())
            ->get(route('admin.categories.index'))
            ->assertSee(route('admin.users.index'));

        $this->actingAs(User::factory()->create())
            ->get(route('admin.categories.index'))
            ->assertDontSee(route('admin.users.index'));
    }

    public function test_regular_users_cannot_manage_accounts(): void
    {
        $user = User::factory()->create();
        $otherUser = User::factory()->create();

        $this->actingAs($user)->get(route('admin.users.index'))->assertForbidden();
        $this->actingAs($user)->post(route('admin.users.store'), [
            'name' => 'Sneaky', 'email' => 'sneaky@example.com', 'password' => 'secret-pass',
        ])->assertForbidden();
        $this->actingAs($user)->put(route('admin.users.update', $otherUser), [
            'name' => 'Changed', 'email' => $otherUser->email,
        ])->assertForbidden();
        $this->actingAs($user)->delete(route('admin.users.destroy', $otherUser))->assertForbidden();

        $this->assertDatabaseMissing('users', ['email' => 'sneaky@example.com']);
        $this->assertModelExists($otherUser);
    }

    public function test_guests_are_redirected_to_login(): void
    {
        $this->get(route('admin.users.index'))->assertRedirect(route('login'));
    }

    public function test_super_admin_creates_an_account_the_user_can_log_in_with(): void
    {
        $superAdmin = User::factory()->superAdmin()->create();

        $this->actingAs($superAdmin)
            ->post(route('admin.users.store'), [
                'name' => 'Rahim Uddin',
                'email' => 'rahim@example.com',
                'password' => 'rahim-pass-1',
            ])
            ->assertRedirect(route('admin.users.index'))
            ->assertSessionHas('success');

        $createdUser = User::where('email', 'rahim@example.com')->firstOrFail();
        $this->assertSame('Rahim Uddin', $createdUser->name);
        $this->assertFalse($createdUser->isSuperAdmin());

        $this->post(route('logout'));

        $this->post(route('login.submit'), ['email' => 'rahim@example.com', 'password' => 'rahim-pass-1'])
            ->assertRedirect(route('admin.dashboard'));

        $this->assertAuthenticatedAs($createdUser);
    }

    public function test_super_admin_cannot_be_granted_through_the_create_form(): void
    {
        $this->actingAs(User::factory()->superAdmin()->create())
            ->post(route('admin.users.store'), [
                'name' => 'Escalator',
                'email' => 'escalator@example.com',
                'password' => 'escalate-pass',
                'is_super_admin' => true,
            ]);

        $this->assertFalse(User::where('email', 'escalator@example.com')->firstOrFail()->isSuperAdmin());
    }

    public function test_creating_an_account_requires_a_unique_email_and_a_password(): void
    {
        $existingUser = User::factory()->create();

        $this->actingAs(User::factory()->superAdmin()->create())
            ->post(route('admin.users.store'), ['name' => 'Copy', 'email' => $existingUser->email, 'password' => 'short'])
            ->assertSessionHasErrorsIn('user', ['email', 'password']);

        $this->actingAs(User::factory()->superAdmin()->create())
            ->post(route('admin.users.store'), ['name' => 'No Password', 'email' => 'nopass@example.com'])
            ->assertSessionHasErrorsIn('user', ['password']);
    }

    public function test_super_admin_updates_a_user_and_keeps_the_password_when_left_blank(): void
    {
        $user = User::factory()->create(['password' => 'original-pass']);

        $this->actingAs(User::factory()->superAdmin()->create())
            ->put(route('admin.users.update', $user), ['name' => 'Renamed', 'email' => 'renamed@example.com', 'password' => ''])
            ->assertRedirect(route('admin.users.index'));

        $user->refresh();
        $this->assertSame('Renamed', $user->name);
        $this->assertSame('renamed@example.com', $user->email);
        $this->assertTrue(Hash::check('original-pass', $user->password));
    }

    public function test_super_admin_can_reset_a_users_password(): void
    {
        $user = User::factory()->create();

        $this->actingAs(User::factory()->superAdmin()->create())
            ->put(route('admin.users.update', $user), ['name' => $user->name, 'email' => $user->email, 'password' => 'brand-new-pass']);

        $this->assertTrue(Hash::check('brand-new-pass', $user->refresh()->password));
    }

    public function test_super_admin_deletes_a_user_and_their_expenses(): void
    {
        $user = User::factory()->create();
        $expense = Expense::factory()->create(['user_id' => $user->id]);

        $this->actingAs(User::factory()->superAdmin()->create())
            ->delete(route('admin.users.destroy', $user))
            ->assertRedirect(route('admin.users.index'));

        $this->assertModelMissing($user);
        $this->assertModelMissing($expense);
    }

    public function test_super_admin_account_cannot_be_deleted(): void
    {
        $superAdmin = User::factory()->superAdmin()->create();

        $this->actingAs($superAdmin)
            ->delete(route('admin.users.destroy', $superAdmin))
            ->assertSessionHas('error');

        $this->assertModelExists($superAdmin);
    }

    public function test_public_registration_is_disabled(): void
    {
        $this->get('/register')->assertNotFound();
        $this->post('/register', [
            'name' => 'Walk In', 'email' => 'walkin@example.com', 'password' => 'walkin-pass1', 'password_confirmation' => 'walkin-pass1',
        ])->assertNotFound();

        $this->assertDatabaseMissing('users', ['email' => 'walkin@example.com']);
        $this->get(route('login'))->assertDontSee('Create Account');
    }
}

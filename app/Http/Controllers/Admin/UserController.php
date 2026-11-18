<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use Illuminate\View\View;

class UserController extends Controller
{
    /**
     * List every user account so the super admin can manage them.
     */
    public function index(): View
    {
        $users = User::query()
            ->withCount('expenses')
            ->withSum('expenses', 'amount')
            ->orderByDesc('is_super_admin')
            ->orderBy('name')
            ->get();

        return view('users.users', [
            'users' => $users,
            'newThisMonthCount' => $users->where('created_at', '>=', now()->startOfMonth())->count(),
            'activeUserCount' => $users->where('expenses_count', '>', 0)->count(),
        ]);
    }

    /**
     * Create a login account. The user signs in with exactly these credentials.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validateWithBag('user', $this->rules());

        $user = User::create($validated);
        $user->forceFill(['email_verified_at' => now()])->save();

        return redirect()->route('admin.users.index')
            ->with('success', "Account for \"{$user->name}\" created. They can now log in with {$user->email}.");
    }

    /**
     * Update a user's name, email, and (optionally) password.
     */
    public function update(Request $request, User $user): RedirectResponse
    {
        $validated = $request->validateWithBag('user', $this->rules($user));

        if (blank($validated['password'] ?? null)) {
            unset($validated['password']);
        }

        $user->update($validated);

        return redirect()->route('admin.users.index')
            ->with('success', "Account for \"{$user->name}\" updated.");
    }

    /**
     * Delete a user account along with its expenses.
     */
    public function destroy(Request $request, User $user): RedirectResponse
    {
        if ($user->isSuperAdmin() || $user->is($request->user())) {
            return redirect()->route('admin.users.index')
                ->with('error', 'The super admin account cannot be deleted.');
        }

        $user->delete();

        return redirect()->route('admin.users.index')
            ->with('success', "Account for \"{$user->name}\" deleted.");
    }

    /**
     * @return array<string, array<int, mixed>>
     */
    private function rules(?User $user = null): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email:rfc', 'max:255', Rule::unique('users', 'email')->ignore($user)],
            'password' => [$user ? 'nullable' : 'required', 'string', Password::min(8)],
        ];
    }
}

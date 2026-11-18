<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // Display login page
    public function showLogin()
    {
        return view('auth.login');
    }

    // Process login
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => [
                'required',
                'email:rfc',
            ],
            'password' => [
                'required',
                'string',
            ],
        ]);

        if (Auth::attempt(
            $credentials,
            $request->boolean('remember')
        )) {

            // Regenerate session ID for security
            $request->session()->regenerate();

            return redirect()->intended(
                route('admin.dashboard')
            );
        }

        return back()
            ->withErrors([
                'email' => 'Invalid email address or password.',
            ])
            ->onlyInput('email');
    }

    // Logout authenticated user
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')
            ->with('success', 'You have logged out successfully.');
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLoginForm() {
        return view('auth.login');
    }

    public function login(Request $request) {
        // 1. Validation
        $credentials = $request->validate([
            'username' => ['required', 'string'],
            'password' => ['required'],
        ]);

        // 2. Attempt Login 
        // We use 'username' as the key. Laravel handles the password hashing check automatically.
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            // 3. Check if user actually has a role assigned to avoid "orphaned" logins
            if (!Auth::user()->role) {
                Auth::logout();
                return back()->withErrors([
                    'username' => 'Your account does not have a role assigned. Contact Admin.',
                ]);
            }

            return redirect()->intended('dashboard');
        }

        // 4. Fail Login
        return back()->withErrors([
            'username' => 'The provided credentials do not match our records.',
        ])->onlyInput('username');
    }

    public function logout(Request $request) {
    Auth::logout();

    // These two lines prevent the 419 error on the NEXT login attempt
    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect('/login');
}
}
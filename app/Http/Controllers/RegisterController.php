<?php

namespace App\Http\Controllers;

use App\Models\Users;
use App\Models\UserRoles;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function showRegistrationForm() {
        $roles = UserRoles::all(); // Fetches roles for the dropdown
        return view('auth.register', compact('roles'));
    }

    public function register(Request $request) {
        $request->validate([
            'username' => 'required|string|max:255|unique:users',
            'password' => 'required|string|min:6',
            'role_id'  => 'required|exists:user_roles,id',
        ]);

        Users::create([
            'username' => $request->username,
            'password' => Hash::make($request->password), // Encryption is mandatory
            'role_id'  => $request->role_id,
        ]);

        return redirect()->route('login')->with('success', 'Account created! Please sign in.');
    }
}
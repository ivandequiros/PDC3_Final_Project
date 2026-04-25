<?php

namespace App\Http\Controllers;

use App\Models\Users;
use App\Models\UserRoles;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
{
    // 1. Show the list of users
    public function index()
    {
        $users = Users::with('role')->get();
        return view('users.index', compact('users'));
    }

    // 2. Show the "Create Account" Form
    public function create()
    {
        $roles = UserRoles::all();
        return view('users.create', compact('roles'));
    }

    // 3. Save the Account
    public function store(Request $request)
{
    $validated = $request->validate([
        'username' => 'required|string|max:255|unique:users,username',
        'email'    => 'required|email|unique:users,email',
        'password' => 'required|string|min:8',
        'role_id'  => 'required|exists:user_roles,id',
    ]);

    \App\Models\Users::create([
        'username' => $validated['username'],
        'email'    => $validated['email'],
        'password' => \Illuminate\Support\Facades\Hash::make($validated['password']),
        'role_id'  => $validated['role_id'],
    ]);

    return redirect()->route('users.index')->with('success', 'Staff account deployed successfully!');
}

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Users $user)
    {
        $validated = $request->validate([
            'username' => 'required|string|max:255|unique:users,username,' . $user->id,
            'email'    => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8',
            'role_id'  => 'required|exists:user_roles,id',
        ]);

        // Only update password if a new one was provided
        if (!empty($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        $user->update($validated);

        return redirect()->route('users.index')
                         ->with('success', 'User updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Users $user)
    {
        // Security check: Prevent deleting your own logged-in account
        if (auth()->id() === $user->id) {
            return back()->with('error', 'Critical Error: You cannot delete your own administrative account.');
        }

        $user->delete();

        return redirect()->route('users.index')
                         ->with('success', 'Staff account has been deactivated.');
    }
}
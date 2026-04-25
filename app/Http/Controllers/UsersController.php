<?php

namespace App\Http\Controllers;

use App\Models\Users;
use App\Models\UserRoles;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\View;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Eager load the role relationship
        $users = Users::with('role')->orderBy('username', 'asc')->get();
        return view('users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = UserRoles::all();
        return view('users.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'username' => 'required|string|max:255|unique:users,username',
            'email'    => 'required|email|unique:users,email', // Added email back
            'password' => 'required|string|min:8',
            'role_id'  => 'required|exists:user_roles,id',
        ]);

        $validated['password'] = Hash::make($validated['password']);

        Users::create($validated);

        return redirect()->route('users.index')
                         ->with('success', 'Staff account created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Users $user)
    {
        $user->load('role');
        return View::make('users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Users $user)
{
    $roles = \App\Models\UserRoles::all();
    return view('users.edit', compact('user', 'roles'));
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
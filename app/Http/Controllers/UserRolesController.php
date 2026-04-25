<?php

namespace App\Http\Controllers;

use App\Models\UserRoles;
use Illuminate\Http\Request;

class UserRolesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Eager load users so we can count how many people have each role
        $roles = UserRoles::with('users')->get();
        return view('roles.index', compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('roles.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'role_name'   => 'required|string|max:100|unique:user_roles,role_name',
            'permissions' => 'required|string|max:255',
        ]);

        UserRoles::create($validated);

        return redirect()->route('roles.index')
                         ->with('success', 'New access level has been successfully established.');
    }

    /**
     * Display the specified resource.
     */
    public function show(UserRoles $userRole)
    {
        return view('roles.show', compact('userRole'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
{
    // Find the specific role or fail with a 404 error
    $role = UserRoles::findOrFail($id);
    return view('roles.edit', compact('role'));
}

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
{
    $role = UserRoles::findOrFail($id);

    $validated = $request->validate([
        'role_name'   => 'required|string|max:100|unique:user_roles,role_name,' . $role->id,
        'permissions' => 'required|string|max:255',
    ]);

    $role->update($validated);

    return redirect()->route('roles.index')
                     ->with('success', 'Access level permissions updated successfully.');
}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(UserRoles $userRole)
    {
        // Optional security check: prevent deleting roles with active users
        if ($userRole->users()->count() > 0) {
            return back()->with('error', 'Cannot delete a role that is currently assigned to staff.');
        }

        $userRole->delete();

        return redirect()->route('roles.index')
                         ->with('success', 'User role deleted successfully.');
    }
}
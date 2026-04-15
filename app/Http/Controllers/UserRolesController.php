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
        $roles = UserRoles::all();
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
            'role_name' => 'required|string|max:100|unique:user_roles,role_name',
            'permissions' => 'required|string|max:255',
        ]);

        UserRoles::create($validated);

        return redirect()->route('roles.index')
                         ->with('success', 'User role created successfully.');
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
    public function edit(UserRoles $userRole)
    {
        return view('roles.edit', compact('userRole'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, UserRoles $userRole)
    {
        $validated = $request->validate([
            'role_name' => 'required|string|max:100|unique:user_roles,role_name,' . $userRole->id,
            'permissions' => 'required|string|max:255',
        ]);

        $userRole->update($validated);

        return redirect()->route('roles.index')
                         ->with('success', 'User role updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(UserRoles $userRole)
    {
        // Optional: Check if users are assigned to this role before deleting
        // if ($userRole->users()->count() > 0) {
        //     return back()->withErrors('Cannot delete a role currently assigned to users.');
        // }

        $userRole->delete();

        return redirect()->route('roles.index')
                         ->with('success', 'User role deleted successfully.');
    }
}
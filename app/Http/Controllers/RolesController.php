<?php

namespace App\Http\Controllers;

use App\Models\Role; // Ensure this matches your Model name (might be UserRole)
use Illuminate\Http\Request;

class RolesController extends Controller
{
    public function index()
    {
        $roles = Role::withCount('users')->get();
        return view('roles.index', compact('roles'));
    }

    public function destroy($id)
    {
        $role = Role::findOrFail($id);

        // Safety check: Don't delete if users are still assigned
        if ($role->users_count > 0) {
            return redirect()->back()->with('error', 'Cannot delete role: Personnel are still assigned.');
        }

        $role->delete();

        return redirect()->route('roles.index')->with('success', 'Role removed successfully.');
    }
}
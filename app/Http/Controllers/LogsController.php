<?php

namespace App\Http\Controllers;

use App\Models\Logs;
use App\Models\Users;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class LogsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Eager load the user and order by the most recent logs first
        $logs = Logs::with('user')->orderBy('timestamp', 'desc')->get();
        return View::make('logs.index', compact('logs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Typically, logs are auto-generated behind the scenes, 
        // but if manual entry is required, we need the users list.
        $users = Users::all();
        return View::make('logs.create', compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id'   => 'required|exists:users,id',
            'action'    => 'required|string|max:255',
            // If you are relying on Laravel's created_at, you can remove 'timestamp'
            // Otherwise, validate it if it's a custom column from your ERD
            'timestamp' => 'required|date', 
        ]);

        Logs::create($validated);

        return redirect()->route('logs.index')
                         ->with('success', 'Log entry created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Logs $log)
    {
        $log->load('user');
        return View::make('logs.show', compact('log'));
    }

    /**
     * Show the form for editing the specified resource.
     * WARNING: Editing logs violates audit trail integrity.
     */
    public function edit(Logs $log)
    {
        $users = Users::all();
        return View::make('logs.edit', compact('log', 'users'));
    }

    /**
     * Update the specified resource in storage.
     * WARNING: Editing logs violates audit trail integrity.
     */
    public function update(Request $request, Logs $log)
    {
        $validated = $request->validate([
            'user_id'   => 'required|exists:users,id',
            'action'    => 'required|string|max:255',
            'timestamp' => 'required|date',
        ]);

        $log->update($validated);

        return redirect()->route('logs.index')
                         ->with('success', 'Log entry updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     * WARNING: Deleting logs violates audit trail integrity.
     */
    public function destroy(Logs $log)
    {
        $log->delete();

        return redirect()->route('logs.index')
                         ->with('success', 'Log entry deleted successfully.');
    }
}
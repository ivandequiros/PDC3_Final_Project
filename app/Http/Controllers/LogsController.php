<?php

namespace App\Http\Controllers;

use App\Models\Logs;
use Illuminate\Http\Request;

class LogsController extends Controller
{
    /**
     * Display a listing of the system audit logs.
     */
    public function index()
    {
        // Eager load 'user' to show who performed the action
        // We use latest() to show the most recent actions at the top
        $logs = Logs::with('user')->latest()->get();

        return view('logs.index', compact('logs'));
    }

    /**
     * Optional: Clear logs (Only for Admin)
     */
    public function destroyAll()
    {
        Logs::truncate();
        return redirect()->route('logs.index')->with('success', 'System audit trail has been cleared.');
    }
}
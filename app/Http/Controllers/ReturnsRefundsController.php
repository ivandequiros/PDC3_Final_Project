<?php

namespace App\Http\Controllers;

use App\Models\ReturnsRefunds;
use App\Models\Transactions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class ReturnsRefundsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Eager load the transaction to prevent N+1 queries
        $returns = ReturnsRefunds::with('transaction')->latest()->get();
        return View::make('returns_refunds.index', compact('returns'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Fetching transactions so the user can select which one is being refunded
        $transactions = Transactions::orderBy('date', 'desc')->get();
        return View::make('returns_refunds.create', compact('transactions'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'transaction_id' => 'required|exists:transactions,id',
            'reason'         => 'required|string|max:255',
            'refund_amount'  => 'required|numeric|min:0',
        ]);

        ReturnsRefunds::create($validated);

        return redirect()->route('returns_refunds.index')
                         ->with('success', 'Return/Refund recorded successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(ReturnsRefunds $returnsRefunds)
    {
        $returnsRefunds->load('transaction');
        return View::make('returns_refunds.show', compact('returnsRefunds'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ReturnsRefunds $returnsRefunds)
    {
        $transactions = Transactions::orderBy('date', 'desc')->get();
        return View::make('returns_refunds.edit', compact('returnsRefunds', 'transactions'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ReturnsRefunds $returnsRefunds)
    {
        $validated = $request->validate([
            'transaction_id' => 'required|exists:transactions,id',
            'reason'         => 'required|string|max:255',
            'refund_amount'  => 'required|numeric|min:0',
        ]);

        $returnsRefunds->update($validated);

        return redirect()->route('returns_refunds.index')
                         ->with('success', 'Return/Refund updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ReturnsRefunds $returnsRefunds)
    {
        $returnsRefunds->delete();

        return redirect()->route('returns_refunds.index')
                         ->with('success', 'Return/Refund deleted successfully.');
    }
}
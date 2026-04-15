<?php

namespace App\Http\Controllers;

use App\Models\Transactions;
use App\Models\Users;
use App\Models\DiscountsPromos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class TransactionsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $transactions = Transactions::with(['user', 'promo'])->orderBy('date', 'desc')->get();
        return View::make('transactions.index', compact('transactions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = Users::all();
        $promos = DiscountsPromos::all();
        
        return View::make('transactions.create', compact('users', 'promos'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'date'         => 'required|date',
            'user_id'      => 'required|exists:users,id',
            'total_amount' => 'required|numeric|min:0',
            'promo_id'     => 'nullable|exists:discount_promos,id',
        ]);

        Transactions::create($validated);

        return redirect()->route('transactions.index')
                         ->with('success', 'Transaction recorded successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Transactions $transactions)
    {
        $transactions->load(['user', 'promo']);
        return View::make('transactions.show', compact('transactions'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Transactions $transactions)
    {
        $users = Users::all();
        $promos = DiscountsPromos::all();
        
        return View::make('transactions.edit', compact('transactions', 'users', 'promos'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Transactions $transactions)
    {
        $validated = $request->validate([
            'date'         => 'required|date',
            'user_id'      => 'required|exists:users,id',
            'total_amount' => 'required|numeric|min:0',
            'promo_id'     => 'nullable|exists:discount_promos,id',
        ]);

        $transactions->update($validated);

        return redirect()->route('transactions.index')
                         ->with('success', 'Transaction updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Transactions $transactions)
    {
        $transactions->delete();

        return redirect()->route('transactions.index')
                         ->with('success', 'Transaction deleted successfully.');
    }
}
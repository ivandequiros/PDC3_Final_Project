<?php

namespace App\Http\Controllers;

use App\Models\TransactionDetails;
use App\Models\Transactions;
use App\Models\Products;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class TransactionDetailsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Eager load the transaction and product to prevent N+1 issues
        $transactionDetails = TransactionDetails::with(['transaction', 'product'])->get();
        return View::make('transaction_details.index', compact('transactionDetails'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $transactions = Transactions::orderBy('date', 'desc')->get();
        $products = Products::orderBy('name', 'asc')->get();
        
        return View::make('transaction_details.create', compact('transactions', 'products'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'transaction_id' => 'required|exists:transactions,id',
            'product_id'     => 'required|exists:products,id',
            'quantity'       => 'required|integer|min:1',
            'unit_price'     => 'required|numeric|min:0',
        ]);

        TransactionDetails::create($validated);

        return redirect()->route('transaction_details.index')
                         ->with('success', 'Transaction detail added successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(TransactionDetails $transactionDetails)
    {
        $transactionDetails->load(['transaction', 'product']);
        return View::make('transaction_details.show', compact('transactionDetails'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TransactionDetails $transactionDetails)
    {
        $transactions = Transactions::orderBy('date', 'desc')->get();
        $products = Products::orderBy('name', 'asc')->get();
        
        return View::make('transaction_details.edit', compact('transactionDetails', 'transactions', 'products'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TransactionDetails $transactionDetails)
    {
        $validated = $request->validate([
            'transaction_id' => 'required|exists:transactions,id',
            'product_id'     => 'required|exists:products,id',
            'quantity'       => 'required|integer|min:1',
            'unit_price'     => 'required|numeric|min:0',
        ]);

        $transactionDetails->update($validated);

        return redirect()->route('transaction_details.index')
                         ->with('success', 'Transaction detail updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TransactionDetails $transactionDetails)
    {
        $transactionDetails->delete();

        return redirect()->route('transaction_details.index')
                         ->with('success', 'Transaction detail deleted successfully.');
    }
}
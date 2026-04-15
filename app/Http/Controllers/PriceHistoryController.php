<?php

namespace App\Http\Controllers;

use App\Models\PriceHistory;
use App\Models\Products;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class PriceHistoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Eager load the product and sort by the most recent price changes
        $priceHistories = PriceHistory::with('product')->orderBy('change_date', 'desc')->get();
        return View::make('price_history.index', compact('priceHistories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $products = Products::orderBy('name', 'asc')->get();
        return View::make('price_history.create', compact('products'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_id'  => 'required|exists:products,id',
            'old_price'   => 'required|numeric|min:0',
            'new_price'   => 'required|numeric|min:0',
            'change_date' => 'required|date',
        ]);

        PriceHistory::create($validated);

        return redirect()->route('price_history.index')
                         ->with('success', 'Price history recorded successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(PriceHistory $priceHistory)
    {
        $priceHistory->load('product');
        return View::make('price_history.show', compact('priceHistory'));
    }

    /**
     * Show the form for editing the specified resource.
     * WARNING: Editing price history can compromise the audit trail.
     */
    public function edit(PriceHistory $priceHistory)
    {
        $products = Products::orderBy('name', 'asc')->get();
        return View::make('price_history.edit', compact('priceHistory', 'products'));
    }

    /**
     * Update the specified resource in storage.
     * WARNING: Editing price history can compromise the audit trail.
     */
    public function update(Request $request, PriceHistory $priceHistory)
    {
        $validated = $request->validate([
            'product_id'  => 'required|exists:products,id',
            'old_price'   => 'required|numeric|min:0',
            'new_price'   => 'required|numeric|min:0',
            'change_date' => 'required|date',
        ]);

        $priceHistory->update($validated);

        return redirect()->route('price_history.index')
                         ->with('success', 'Price history updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     * WARNING: Deleting price history can compromise the audit trail.
     */
    public function destroy(PriceHistory $priceHistory)
    {
        $priceHistory->delete();

        return redirect()->route('price_history.index')
                         ->with('success', 'Price history deleted successfully.');
    }
}
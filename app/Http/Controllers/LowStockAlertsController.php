<?php

namespace App\Http\Controllers;

use App\Models\LowStockAlerts;
use App\Models\Products;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class LowStockAlertsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Eager load the product and sort so active alerts are at the top
        $alerts = LowStockAlerts::with('product')->orderBy('is_active', 'desc')->get();
        return View::make('low_stock_alerts.index', compact('alerts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $products = Products::orderBy('name', 'asc')->get();
        return View::make('low_stock_alerts.create', compact('products'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Ensure checkbox is handled correctly (true if checked, false if not)
        $request->merge([
            'is_active' => $request->has('is_active'),
        ]);

        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'threshold'  => 'required|integer|min:0',
            'is_active'  => 'required|boolean',
        ]);

        LowStockAlerts::create($validated);

        return redirect()->route('low_stock_alerts.index')
                         ->with('success', 'Low stock alert configured successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(LowStockAlerts $lowStockAlerts)
    {
        $lowStockAlerts->load('product');
        return View::make('low_stock_alerts.show', compact('lowStockAlerts'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(LowStockAlerts $lowStockAlerts)
    {
        $products = Products::orderBy('name', 'asc')->get();
        return View::make('low_stock_alerts.edit', compact('lowStockAlerts', 'products'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, LowStockAlerts $lowStockAlerts)
    {
        $request->merge([
            'is_active' => $request->has('is_active'),
        ]);

        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'threshold'  => 'required|integer|min:0',
            'is_active'  => 'required|boolean',
        ]);

        $lowStockAlerts->update($validated);

        return redirect()->route('low_stock_alerts.index')
                         ->with('success', 'Low stock alert updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(LowStockAlerts $lowStockAlerts)
    {
        $lowStockAlerts->delete();

        return redirect()->route('low_stock_alerts.index')
                         ->with('success', 'Low stock alert deleted successfully.');
    }
}
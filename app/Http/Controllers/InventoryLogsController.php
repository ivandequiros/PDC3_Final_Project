<?php

namespace App\Http\Controllers;

use App\Models\InventoryLogs;
use App\Models\Products;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class InventoryLogsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Eager load the product and sort by newest logs first
        $inventoryLogs = InventoryLogs::with('product')->orderBy('timestamp', 'desc')->get();
        return View::make('inventory_logs.index', compact('inventoryLogs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $products = Products::orderBy('name', 'asc')->get();
        return View::make('inventory_logs.create', compact('products'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_id'    => 'required|exists:products,id',
            'change_amount' => 'required|integer', // Can be positive (restock) or negative (sale/loss)
            'reason'        => 'required|string|max:255',
            'timestamp'     => 'required|date',
        ]);

        InventoryLogs::create($validated);

        return redirect()->route('inventory_logs.index')
                         ->with('success', 'Inventory log recorded successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(InventoryLogs $inventoryLogs)
    {
        $inventoryLogs->load('product');
        return View::make('inventory_logs.show', compact('inventoryLogs'));
    }

    /**
     * Show the form for editing the specified resource.
     * WARNING: Editing inventory logs can compromise stock audit trails.
     */
    public function edit(InventoryLogs $inventoryLogs)
    {
        $products = Products::orderBy('name', 'asc')->get();
        return View::make('inventory_logs.edit', compact('inventoryLogs', 'products'));
    }

    /**
     * Update the specified resource in storage.
     * WARNING: Editing inventory logs can compromise stock audit trails.
     */
    public function update(Request $request, InventoryLogs $inventoryLogs)
    {
        $validated = $request->validate([
            'product_id'    => 'required|exists:products,id',
            'change_amount' => 'required|integer',
            'reason'        => 'required|string|max:255',
            'timestamp'     => 'required|date',
        ]);

        $inventoryLogs->update($validated);

        return redirect()->route('inventory_logs.index')
                         ->with('success', 'Inventory log updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     * WARNING: Deleting inventory logs can compromise stock audit trails.
     */
    public function destroy(InventoryLogs $inventoryLogs)
    {
        $inventoryLogs->delete();

        return redirect()->route('inventory_logs.index')
                         ->with('success', 'Inventory log deleted successfully.');
    }
}
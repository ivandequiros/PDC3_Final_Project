<?php

namespace App\Http\Controllers;

use App\Models\PurchaseOrders;
use App\Models\Suppliers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class PurchaseOrdersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Eager load the supplier and order by the most recent orders first
        $purchaseOrders = PurchaseOrders::with('supplier')->orderBy('order_date', 'desc')->get();
        return View::make('purchase_orders.index', compact('purchaseOrders'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $suppliers = Suppliers::orderBy('company_name', 'asc')->get();
        return View::make('purchase_orders.create', compact('suppliers'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'supplier_id' => 'required|exists:suppliers,id',
            'order_date'  => 'required|date',
            'status'      => 'required|string|max:100', // e.g., 'Pending', 'Received', 'Cancelled'
        ]);

        PurchaseOrders::create($validated);

        return redirect()->route('purchase_orders.index')
                         ->with('success', 'Purchase order created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(PurchaseOrders $purchaseOrders)
    {
        $purchaseOrders->load('supplier');
        return View::make('purchase_orders.show', compact('purchaseOrders'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PurchaseOrders $purchaseOrders)
    {
        $suppliers = Suppliers::orderBy('company_name', 'asc')->get();
        return View::make('purchase_orders.edit', compact('purchaseOrders', 'suppliers'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PurchaseOrders $purchaseOrders)
    {
        $validated = $request->validate([
            'supplier_id' => 'required|exists:suppliers,id',
            'order_date'  => 'required|date',
            'status'      => 'required|string|max:100',
        ]);

        $purchaseOrders->update($validated);

        return redirect()->route('purchase_orders.index')
                         ->with('success', 'Purchase order updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PurchaseOrders $purchaseOrders)
    {
        $purchaseOrders->delete();

        return redirect()->route('purchase_orders.index')
                         ->with('success', 'Purchase order deleted successfully.');
    }
}
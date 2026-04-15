<?php

namespace App\Http\Controllers;

use App\Models\Suppliers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class SuppliersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Alphabetical order makes finding suppliers easier
        $suppliers = Suppliers::orderBy('company_name', 'asc')->get();
        return View::make('suppliers.index', compact('suppliers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return View::make('suppliers.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'company_name'   => 'required|string|max:255|unique:suppliers,company_name',
            'contact_person' => 'required|string|max:255',
            'phone'          => 'required|string|max:50',
        ]);

        Suppliers::create($validated);

        return redirect()->route('suppliers.index')
                         ->with('success', 'Supplier added successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Suppliers $suppliers)
    {
        // Load related products and purchase orders if you want to display them on the show page
        $suppliers->load(['products', 'purchaseOrders']);
        return View::make('suppliers.show', compact('suppliers'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Suppliers $suppliers)
    {
        return View::make('suppliers.edit', compact('suppliers'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Suppliers $suppliers)
    {
        $validated = $request->validate([
            'company_name'   => 'required|string|max:255|unique:suppliers,company_name,' . $suppliers->id,
            'contact_person' => 'required|string|max:255',
            'phone'          => 'required|string|max:50',
        ]);

        $suppliers->update($validated);

        return redirect()->route('suppliers.index')
                         ->with('success', 'Supplier updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Suppliers $suppliers)
    {
        // Optional: Prevent deletion if the supplier is tied to existing products or orders
        // if ($suppliers->products()->count() > 0 || $suppliers->purchaseOrders()->count() > 0) {
        //     return back()->withErrors('Cannot delete a supplier that has associated products or purchase orders.');
        // }

        $suppliers->delete();

        return redirect()->route('suppliers.index')
                         ->with('success', 'Supplier deleted successfully.');
    }
}
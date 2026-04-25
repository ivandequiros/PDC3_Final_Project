<?php

namespace App\Http\Controllers;

use App\Models\Suppliers;
use Illuminate\Http\Request;

class SuppliersController extends Controller
{
    public function index()
    {
        $suppliers = Suppliers::orderBy('company_name', 'asc')->get();
        return view('suppliers.index', compact('suppliers'));
    }

    public function create()
    {
        return view('suppliers.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'company_name'   => 'required|string|max:255|unique:suppliers,company_name',
            'contact_person' => 'required|string|max:255',
            'phone'          => 'required|string|max:20',
            'email'          => 'required|email|max:255',
        ]);

        Suppliers::create($validated);

        return redirect()->route('suppliers.index')
                         ->with('success', 'Supplier partner registered successfully.');
    }

    public function edit(Suppliers $supplier)
{
    // Laravel automatically finds the supplier based on the ID in the URL
    return view('suppliers.edit', compact('supplier'));
}

/**
 * Update the supplier in the database.
 */
public function update(Request $request, Suppliers $supplier)
{
    $validated = $request->validate([
        // 'unique' rule ensures we don't duplicate names, but ignores the current supplier's ID
        'company_name'   => 'required|string|max:255|unique:suppliers,company_name,' . $supplier->id,
        'contact_person' => 'required|string|max:255',
        'phone'          => 'required|string|max:20',
        'email'          => 'required|email|max:255',
    ]);

    $supplier->update($validated);

    return redirect()->route('suppliers.index')
                     ->with('success', 'Changes to ' . $supplier->company_name . ' have been saved.');
}
}
<?php

namespace App\Http\Controllers;

use App\Models\Products;
use App\Models\Categories;
use App\Models\Suppliers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Eager load category and supplier to avoid slow page loads
        $products = Products::with(['category', 'supplier'])->orderBy('name', 'asc')->get();
        return view('products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Categories::orderBy('category_name', 'asc')->get();
        $suppliers = Suppliers::orderBy('company_name', 'asc')->get();
        return view('products.create', compact('categories', 'suppliers'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) {
    // ... your current save logic ...
    
    // Add this line to record the action
    \App\Models\Logs::create([
        'user_id' => auth()->id(),
        'action'  => 'Added new product: ' . $request->name,
    ]);
}

    /**
     * Display the specified resource.
     */
    public function show(Products $products)
    {
        // Load the upstream relationships for the detail view
        $products->load(['category', 'supplier']);
        return View::make('products.show', compact('products'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Products $product) 
{
    $categories = Categories::orderBy('category_name', 'asc')->get();
    $suppliers = Suppliers::orderBy('company_name', 'asc')->get();
    
    // Change variable name here too
    return view('products.edit', compact('product', 'categories', 'suppliers'));
}

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Products $product) // Must be singular $product
{
    $validated = $request->validate([
        'name'          => 'required|string|max:255|unique:products,name,' . $product->id,
        'category_id'   => 'required|exists:categories,id',
        'supplier_id'   => 'required|exists:suppliers,id',
        'stock_level'   => 'required|integer|min:0',
        'current_price' => 'required|numeric|min:0',
    ]);

    $product->update($validated);

    // Logging the action for your System Logs
    \App\Models\Logs::create([
        'user_id' => auth()->id(),
        'action'  => 'Updated product details for: ' . $product->name,
    ]);

    return redirect()->route('products.index')
                     ->with('success', 'Product information updated successfully.');
}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Products $products)
    {
        $products->delete();

        return redirect()->route('products.index')
                         ->with('success', 'Product deleted successfully.');
    }
}
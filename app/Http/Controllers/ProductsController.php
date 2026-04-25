<?php

namespace App\Http\Controllers;

use App\Models\Products;
use App\Models\Categories;
use App\Models\Suppliers;
use App\Models\Logs;
use Illuminate\Http\Request;

class ProductsController extends Controller
{
    public function index()
    {
        $products = Products::with(['category', 'supplier'])->get();
        $categories = Categories::orderBy('category_name', 'asc')->get();
        $suppliers = Suppliers::orderBy('company_name', 'asc')->get();

        return view('products.index', compact('products', 'categories', 'suppliers'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_name'  => 'required|string|max:255',
            'category_id'   => 'required|exists:categories,id',
            'supplier_id'   => 'required|exists:suppliers,id',
            'current_price' => 'required|numeric|min:0',
            'stock_level'   => 'required|integer|min:0',
        ]);

        $product = Products::create([
            'name'          => $validated['product_name'], // Maps form to DB 'name'
            'category_id'   => $validated['category_id'],
            'supplier_id'   => $validated['supplier_id'],
            'current_price' => $validated['current_price'],
            'stock_level'   => $validated['stock_level'],
        ]);

        Logs::create([
            'user_id' => auth()->id(),
            'action'  => "Added product: " . $product->name,
        ]);

        return redirect()->route('products.index')->with('success', 'Product added successfully!');
    }

    public function update(Request $request, Products $product)
    {
        $validated = $request->validate([
            'product_name'  => 'required|string|max:255',
            'category_id'   => 'required|exists:categories,id',
            'supplier_id'   => 'required|exists:suppliers,id',
            'current_price' => 'required|numeric|min:0',
            'stock_level'   => 'required|integer|min:0',
        ]);

        $product->update([
            'name'          => $validated['product_name'],
            'category_id'   => $validated['category_id'],
            'supplier_id'   => $validated['supplier_id'],
            'current_price' => $validated['current_price'],
            'stock_level'   => $validated['stock_level'],
        ]);

        return redirect()->route('products.index')->with('success', 'Product updated!');
    }

    public function destroy(Products $product)
    {
        $name = $product->name;
        $product->delete();
        Logs::create(['user_id' => auth()->id(), 'action' => "Deleted product: $name"]);
        return redirect()->route('products.index')->with('success', 'Product removed.');
    }
}
<?php

namespace App\Http\Controllers;

use App\Models\Categories;
use Illuminate\Http\Request;

class CategoriesController extends Controller
{
    public function index()
    {
        // Eager load products to show a count of items in each category
        $categories = Categories::withCount('products')->orderBy('category_name', 'asc')->get();
        return view('categories.index', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_name' => 'required|string|max:100|unique:categories,category_name',
        ]);

        Categories::create($validated);

        return redirect()->route('categories.index')
                         ->with('success', 'New category successfully added.');
    }

    public function update(Request $request, Categories $category)
    {
        $validated = $request->validate([
            'category_name' => 'required|string|max:100|unique:categories,category_name,' . $category->id,
        ]);

        $category->update($validated);

        return redirect()->route('categories.index')
                         ->with('success', 'Category name updated.');
    }

    public function destroy(Categories $category)
    {
        if ($category->products()->count() > 0) {
            return back()->with('error', 'Cannot delete: This category still contains active products.');
        }

        $category->delete();
        return redirect()->route('categories.index')->with('success', 'Category removed.');
    }
}
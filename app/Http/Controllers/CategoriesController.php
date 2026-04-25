<?php

namespace App\Http\Controllers;

// We alias the model as CategoryModel to prevent PHP from getting confused
use App\Models\Categories as CategoryModel; 
use Illuminate\Http\Request;

class CategoriesController extends Controller
{
    public function index()
    {
        // Use the alias 'CategoryModel' here
        $categories = CategoryModel::withCount('products')
            ->orderBy('category_name', 'asc')
            ->get();

        return view('categories.index', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_name' => 'required|string|max:100|unique:categories,category_name',
        ]);

        CategoryModel::create($validated);

        return redirect()->route('categories.index')->with('success', 'New category added!');
    }

    public function destroy($id)
    {
        $category = CategoryModel::findOrFail($id);

        if ($category->products()->count() > 0) {
            return back()->with('error', 'Integrity Error: This category still contains items.');
        }

        $category->delete();
        return redirect()->route('categories.index')->with('success', 'Category deleted.');
    }
}
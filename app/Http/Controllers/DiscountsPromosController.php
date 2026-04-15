<?php

namespace App\Http\Controllers;

use App\Models\DiscountsPromos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class DiscountsPromosController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Order by expiry date so upcoming expirations are at the top
        $promos = DiscountsPromos::orderBy('expiry_date', 'asc')->get();
        return View::make('promos.index', compact('promos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return View::make('promos.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'promo_name'       => 'required|string|max:255|unique:discount_promos,promo_name',
            'discount_percent' => 'required|numeric|min:0|max:100',
            'expiry_date'      => 'required|date',
        ]);

        DiscountsPromos::create($validated);

        return redirect()->route('promos.index')
                         ->with('success', 'Discount promo created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(DiscountsPromos $discountsPromos)
    {
        return View::make('promos.show', compact('discountsPromos'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(DiscountsPromos $discountsPromos)
    {
        return View::make('promos.edit', compact('discountsPromos'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, DiscountsPromos $discountsPromos)
    {
        $validated = $request->validate([
            'promo_name'       => 'required|string|max:255|unique:discount_promos,promo_name,' . $discountsPromos->id,
            'discount_percent' => 'required|numeric|min:0|max:100',
            'expiry_date'      => 'required|date',
        ]);

        $discountsPromos->update($validated);

        return redirect()->route('promos.index')
                         ->with('success', 'Discount promo updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DiscountsPromos $discountsPromos)
    {
        $discountsPromos->delete();

        return redirect()->route('promos.index')
                         ->with('success', 'Discount promo deleted successfully.');
    }
}
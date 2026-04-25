<?php

namespace App\Http\Controllers;

use App\Models\Transactions;
use App\Models\Users;
use App\Models\DiscountsPromos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
namespace App\Http\Controllers;

use App\Models\Transactions;
use Illuminate\Http\Request;

class TransactionsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Fetch transactions with the cashier (user) who performed them
        $transactions = Transactions::with('user')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('transactions.index', compact('transactions'));
    }

    /**
     * Show the form for creating a new resource.
     */
   public function create()
{
    // Fetch only items that are actually in stock
    $products = \App\Models\Products::where('stock_level', '>', 0)
        ->orderBy('name', 'asc')
        ->get();

    return view('pos.index', compact('products'));
}

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    // 1. Validate that the cart isn't empty and items exist
    $request->validate([
        'items' => 'required|array',
        'items.*.id' => 'required|exists:products,id',
        'items.*.qty' => 'required|integer|min:1',
    ]);

    // 2. Create the parent Transaction record
    $transaction = \App\Models\Transactions::create([
    'user_id'      => auth()->id(),
    'total_amount' => 0,
    'date'         => now()->toDateString(), // Add this line to satisfy the DB requirement
]);

    $grandTotal = 0;

    // 3. Process each item in the cart
    foreach ($request->items as $item) {
        $product = \App\Models\Products::find($item['id']);
        
        // Security Check: Ensure stock is still available
        if ($product->stock_level < $item['qty']) {
            return back()->with('error', "Insufficient stock for {$product->name}.");
        }

        $subtotal = $product->current_price * $item['qty'];

        // Save to transaction_details table
        $transaction->details()->create([
            'product_id' => $product->id,
            'quantity' => $item['qty'],
            'unit_price' => $product->current_price,
            'subtotal' => $subtotal
        ]);

        // 4. Update Inventory: Deduct stock
        $product->decrement('stock_level', $item['qty']);
        
        $grandTotal += $subtotal;
    }

    // 5. Update the final total amount
    $transaction->update(['total_amount' => $grandTotal]);

    // 6. Log the activity
    \App\Models\Logs::create([
        'user_id' => auth()->id(),
        'action'  => "Processed Sale TRX-{$transaction->id} (₱" . number_format($grandTotal, 2) . ")",
    ]);

    return redirect()->route('pos.index')
                     ->with('success', "Sale Complete! Transaction ID: TRX-{$transaction->id}");
}
    /**
     * Display the specified resource.
     */
    public function show(Transactions $transaction)
    {
        // Load the items (details) and the related products for those items
        $transaction->load(['user', 'details.product']);
        
        return view('transactions.show', compact('transaction'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Transactions $transactions)
    {
        $users = Users::all();
        $promos = DiscountsPromos::all();
        
        return View::make('transactions.edit', compact('transactions', 'users', 'promos'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Transactions $transactions)
    {
        $validated = $request->validate([
            'date'         => 'required|date',
            'user_id'      => 'required|exists:users,id',
            'total_amount' => 'required|numeric|min:0',
            'promo_id'     => 'nullable|exists:discount_promos,id',
        ]);

        $transactions->update($validated);

        return redirect()->route('transactions.index')
                         ->with('success', 'Transaction updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Transactions $transactions)
    {
        $transactions->delete();

        return redirect()->route('transactions.index')
                         ->with('success', 'Transaction deleted successfully.');
    }
}
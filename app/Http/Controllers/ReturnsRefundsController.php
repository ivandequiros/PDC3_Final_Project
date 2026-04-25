<?php

namespace App\Http\Controllers;

use App\Models\Transactions;
use App\Models\TransactionDetails;
use App\Models\ReturnsRefunds;
use Illuminate\Http\Request;

class ReturnsRefundsController extends Controller
{
    public function index()
    {
        $returns = ReturnsRefunds::with(['transaction', 'product'])->latest()->get();
        return view('returns.index', compact('returns'));
    }

    public function create(Request $request)
    {
        $transaction = null;
        if ($request->has('transaction_id')) {
            $transaction = Transactions::with('details.product')->find($request->transaction_id);
        }
        return view('returns.create', compact('transaction'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'transaction_id' => 'required|exists:transactions,id',
            'product_id'     => 'required|exists:products,id',
            'quantity'       => 'required|integer|min:1',
            'reason'         => 'required|string|max:255',
        ]);

        // 1. Record the Return
        ReturnsRefunds::create([
            'transaction_id' => $request->transaction_id,
            'product_id'     => $request->product_id,
            'quantity'       => $request->quantity,
            'reason'         => $request->reason,
            'processed_by'   => auth()->id(),
        ]);

        // 2. Restock the Product
        $product = \App\Models\Products::find($request->product_id);
        $product->increment('stock_level', $request->quantity);

        // 3. Log the action
        \App\Models\Logs::create([
            'user_id' => auth()->id(),
            'action'  => "Processed Return for TRX-{$request->transaction_id} (Item: {$product->name})",
        ]);

        return redirect()->route('returns.index')->with('success', 'Refund processed and stock updated.');
    }
}
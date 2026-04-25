@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="mb-8">
        <h1 class="text-3xl font-black text-[#1e3a8a]">Process Refund</h1>
        <p class="text-gray-500">Enter the Reference Number to begin a return.</p>
    </div>

    <div class="bg-white p-8 rounded-[2.5rem] shadow-sm border border-gray-100 mb-8">
        <form action="{{ route('returns.create') }}" method="GET" class="flex gap-4">
            <input type="text" name="transaction_id" placeholder="Enter TRX ID (e.g. 5)" 
                class="flex-1 px-5 py-4 rounded-2xl bg-gray-50 border-none focus:ring-4 focus:ring-blue-100 transition font-mono">
            <button type="submit" class="bg-[#1e3a8a] text-white px-8 py-4 rounded-2xl font-black">SEARCH</button>
        </form>
    </div>

    @if($transaction)
    <div class="bg-white rounded-[2.5rem] shadow-xl border border-gray-100 overflow-hidden">
        <div class="p-8 border-b border-gray-50 bg-gray-50/50">
            <h3 class="font-black text-gray-800">Transaction TRX-{{ $transaction->id }}</h3>
            <p class="text-xs text-gray-400">Date: {{ $transaction->created_at->format('M d, Y') }}</p>
        </div>
        
        <div class="p-8">
            <table class="w-full text-left mb-8">
                <thead class="text-[10px] uppercase font-black text-gray-400">
                    <tr>
                        <th class="pb-4">Product</th>
                        <th class="pb-4">Qty Purchased</th>
                        <th class="pb-4 text-right">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @foreach($transaction->details as $item)
                    <tr>
                        <td class="py-4 font-bold">{{ $item->product->name }}</td>
                        <td class="py-4">{{ $item->quantity }}</td>
                        <td class="py-4 text-right">
                            <form action="{{ route('returns.store') }}" method="POST" class="inline-block bg-red-50 p-6 rounded-3xl border border-red-100">
                                @csrf
                                <input type="hidden" name="transaction_id" value="{{ $transaction->id }}">
                                <input type="hidden" name="product_id" value="{{ $item->product_id }}">
                                
                                <div class="flex items-center gap-4">
                                    <input type="number" name="quantity" max="{{ $item->quantity }}" min="1" value="1" 
                                        class="w-20 px-3 py-2 rounded-xl border-gray-200 text-sm">
                                    <input type="text" name="reason" placeholder="Reason for return" required
                                        class="px-3 py-2 rounded-xl border-gray-200 text-sm">
                                    <button class="bg-red-600 text-white px-4 py-2 rounded-xl font-bold text-xs">REFUND</button>
                                </div>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endif
</div>
@endsection
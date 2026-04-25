@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="mb-8">
        <a href="{{ route('transactions.index') }}" class="text-blue-600 font-bold text-sm hover:underline">← Back to History</a>
        <h1 class="text-3xl font-black text-[#1e3a8a] mt-2">Transaction Receipt</h1>
    </div>

    <div class="bg-white rounded-[2.5rem] shadow-xl border border-gray-100 overflow-hidden">
        <div class="p-10 bg-gray-50 border-b border-dashed border-gray-200 text-center">
            <div class="text-4xl mb-2 text-blue-900 font-black">₱{{ number_format($transaction->total_amount, 2) }}</div>
            <div class="text-xs font-bold text-gray-400 uppercase tracking-widest">Transaction Reference: TRX-{{ $transaction->id }}</div>
        </div>

        <div class="p-10">
            <h3 class="text-xs font-black uppercase text-gray-400 tracking-widest mb-6">Purchased Items</h3>
            <div class="space-y-4">
                @foreach($transaction->details as $item)
                <div class="flex justify-between items-center pb-4 border-b border-gray-50">
                    <div>
                        <div class="font-bold text-gray-800">{{ $item->product->name ?? 'Deleted Item' }}</div>
                        <div class="text-xs text-gray-400">{{ $item->quantity }} unit(s) x ₱{{ number_format($item->unit_price, 2) }}</div>
                    </div>
                    <div class="font-black text-gray-700">₱{{ number_format($item->subtotal, 2) }}</div>
                </div>
                @endforeach
            </div>

            <div class="mt-10 pt-6 border-t border-gray-100 grid grid-cols-2 gap-6 text-sm">
                <div>
                    <span class="block text-gray-400 font-bold uppercase text-[10px]">Date</span>
                    <span class="font-bold text-gray-800">{{ $transaction->created_at->toDayDateTimeString() }}</span>
                </div>
                <div class="text-right">
                    <span class="block text-gray-400 font-bold uppercase text-[10px]">Processed By</span>
                    <span class="font-bold text-gray-800">{{ $transaction->user->username ?? 'Unknown' }}</span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

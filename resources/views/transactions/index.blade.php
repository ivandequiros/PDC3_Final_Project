@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto">
    <div class="mb-8">
        <h1 class="text-3xl font-black text-[#1e3a8a]">Sales History</h1>
        <p class="text-gray-500">Review all completed transactions and revenue streams.</p>
    </div>

    <div class="bg-white rounded-[2rem] shadow-sm border border-gray-100 overflow-hidden">
        <table class="w-full text-left">
            <thead class="bg-gray-50 border-b border-gray-100">
                <tr>
                    <th class="px-8 py-5 text-[10px] uppercase font-black text-gray-400 tracking-widest">Ref #</th>
                    <th class="px-8 py-5 text-[10px] uppercase font-black text-gray-400 tracking-widest">Date & Time</th>
                    <th class="px-8 py-5 text-[10px] uppercase font-black text-gray-400 tracking-widest">Cashier</th>
                    <th class="px-8 py-5 text-[10px] uppercase font-black text-gray-400 tracking-widest">Total Amount</th>
                    <th class="px-8 py-5 text-[10px] uppercase font-black text-gray-400 tracking-widest text-right">Details</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse($transactions as $trx)
                <tr class="hover:bg-gray-50/50 transition">
                    <td class="px-8 py-5 font-mono text-sm text-blue-600 font-bold">
                        TRX-{{ str_pad($trx->id, 5, '0', STR_PAD_LEFT) }}
                    </td>
                    <td class="px-8 py-5 text-gray-500 text-sm">
                        {{ $trx->created_at->format('M d, Y • h:i A') }}
                    </td>
                    <td class="px-8 py-5">
                        <span class="font-bold text-gray-800">{{ $trx->user->username ?? 'System' }}</span>
                    </td>
                    <td class="px-8 py-5 font-black text-gray-900">
                        ₱{{ number_format($trx->total_amount, 2) }}
                    </td>
                    <td class="px-8 py-5 text-right">
                        <a href="{{ route('transactions.show', $trx) }}" class="bg-blue-50 text-blue-600 px-4 py-2 rounded-xl font-bold text-xs hover:bg-blue-600 hover:text-white transition">
                            View Receipt
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-8 py-20 text-center text-gray-400 italic">No sales transactions found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
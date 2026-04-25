@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto">
    <div class="flex justify-between items-end mb-10">
        <div>
            <h1 class="text-4xl font-black text-[#1e3a8a] tracking-tight">Stock Alerts</h1>
            <p class="text-gray-400 font-bold uppercase text-[10px] tracking-widest mt-1">Critical Inventory Notifications</p>
        </div>
        <div class="bg-red-50 px-6 py-3 rounded-2xl border border-red-100">
            <span class="text-red-600 font-black text-xs uppercase tracking-widest">Active Alerts: {{ $alerts->where('is_active', true)->count() }}</span>
        </div>
    </div>

    <div class="bg-white rounded-[3rem] shadow-sm border border-gray-100 overflow-hidden">
        <table class="w-full text-left">
            <thead class="bg-gray-50 border-b border-gray-100">
                <tr>
                    <th class="px-10 py-6 text-[10px] uppercase font-black text-gray-400 tracking-widest">Status</th>
                    <th class="px-10 py-6 text-[10px] uppercase font-black text-gray-400 tracking-widest">Product Item</th>
                    <th class="px-10 py-6 text-[10px] uppercase font-black text-gray-400 tracking-widest">Current Stock</th>
                    <th class="px-10 py-6 text-[10px] uppercase font-black text-gray-400 tracking-widest">Threshold</th>
                    <th class="px-10 py-6 text-[10px] uppercase font-black text-gray-400 tracking-widest text-right">Action</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse($alerts as $alert)
                <tr class="hover:bg-gray-50/50 transition {{ $alert->is_active ? 'bg-red-50/20' : '' }}">
                    <td class="px-10 py-6">
                        @if($alert->is_active)
                            <span class="flex h-3 w-3">
                                <span class="animate-ping absolute inline-flex h-3 w-3 rounded-full bg-red-400 opacity-75"></span>
                                <span class="relative inline-flex rounded-full h-3 w-3 bg-red-500"></span>
                            </span>
                        @else
                            <span class="inline-flex rounded-full h-3 w-3 bg-gray-300"></span>
                        @endif
                    </td>
                    <td class="px-10 py-6">
                        <p class="font-black text-gray-800">{{ $alert->product->name }}</p>
                        <p class="text-[9px] text-gray-400 font-bold uppercase tracking-tighter">SKU: {{ str_pad($alert->product_id, 5, '0', STR_PAD_LEFT) }}</p>
                    </td>
                    <td class="px-10 py-6">
                        <span class="text-lg font-black {{ $alert->product->stock_level <= $alert->threshold ? 'text-red-600' : 'text-gray-800' }}">
                            {{ $alert->product->stock_level }}
                        </span>
                    </td>
                    <td class="px-10 py-6 font-bold text-gray-400">
                        {{ $alert->threshold }}
                    </td>
                    <td class="px-10 py-6 text-right">
                        <a href="{{ route('products.edit', $alert->product_id) }}" class="inline-block bg-[#1e3a8a] text-white px-5 py-2 rounded-xl text-[10px] font-black uppercase tracking-widest hover:bg-blue-800 transition shadow-md">
                            Restock
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-10 py-32 text-center">
                        <div class="flex flex-col items-center">
                            <span class="text-6xl mb-4">✅</span>
                            <p class="text-gray-400 font-bold italic">All stock levels are within safe parameters.</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto">
    {{-- Header --}}
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-3xl font-black text-[#1e3a8a] tracking-tight uppercase italic">Stock <span class="text-blue-500">Alerts</span></h1>
            <p class="text-gray-400 font-black uppercase text-[10px] tracking-[0.2em] mt-1">Critical Inventory Notifications</p>
        </div>
        
        <div class="bg-red-50 text-red-600 px-6 py-3 rounded-2xl font-black uppercase text-[10px] tracking-widest border border-red-100">
            Active Alerts: {{ $lowStockProducts->count() }}
        </div>
    </div>

    <div class="bg-white rounded-[3rem] shadow-sm border border-gray-100 overflow-hidden min-h-[400px] flex flex-col">
        @if($lowStockProducts->count() > 0)
            <table class="w-full text-left">
                <thead class="bg-gray-50 border-b border-gray-100">
                    <tr>
                        <th class="px-8 py-5 text-[10px] uppercase font-black text-gray-400 tracking-widest">Status</th>
                        <th class="px-8 py-5 text-[10px] uppercase font-black text-gray-400 tracking-widest">Product Item</th>
                        <th class="px-8 py-5 text-[10px] uppercase font-black text-gray-400 tracking-widest">Current Stock</th>
                        <th class="px-8 py-5 text-[10px] uppercase font-black text-gray-400 tracking-widest">Threshold</th>
                        <th class="px-8 py-5 text-center text-[10px] uppercase font-black text-gray-400 tracking-widest">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @foreach($lowStockProducts as $product)
                    <tr class="hover:bg-red-50/30 transition">
                        <td class="px-8 py-5">
                            <span class="flex h-3 w-3 rounded-full bg-red-500 animate-pulse"></span>
                        </td>
                        <td class="px-8 py-5">
                            <div class="font-black text-gray-800 tracking-tight">{{ $product->name }}</div>
                            <div class="text-[9px] text-gray-400 font-black uppercase italic">{{ $product->category->category_name ?? 'N/A' }}</div>
                        </td>
                        <td class="px-8 py-5 font-black text-red-600">
                            {{ $product->stock_level }} Units
                        </td>
                        <td class="px-8 py-5 font-bold text-gray-400 italic">
                            {{ $threshold }}
                        </td>
                        <td class="px-8 py-5 text-center">
                            <a href="{{ route('products.edit', $product) }}" class="bg-[#1e3a8a] text-white px-4 py-2 rounded-xl text-[9px] font-black uppercase tracking-widest hover:bg-blue-800 transition">
                                Restock
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            {{-- EMPTY STATE (Matches your screenshot) --}}
            <div class="flex-1 flex flex-col items-center justify-center p-20 text-center">
                <div class="bg-green-500 text-white p-4 rounded-2xl shadow-lg mb-6">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" />
                    </svg>
                </div>
                <h3 class="text-gray-400 font-black italic uppercase text-sm tracking-widest">
                    All stock levels are within safe parameters.
                </h3>
            </div>
        @endif
    </div>
</div>
@endsection
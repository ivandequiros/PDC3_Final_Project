@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto">
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-3xl font-black text-[#1e3a8a]">Product Inventory</h1>
            <p class="text-gray-500">Manage school supplies, pricing, and stock levels.</p>
        </div>
        <a href="{{ route('products.create') }}" class="bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded-2xl font-bold transition shadow-lg transform active:scale-95 flex items-center">
            <span class="mr-2">➕</span> Add New Supply
        </a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-white p-6 rounded-3xl border border-gray-100 shadow-sm">
            <p class="text-xs font-bold text-gray-400 uppercase tracking-widest">Total SKU Count</p>
            <p class="text-2xl font-black text-gray-800">{{ $products->count() }} Items</p>
        </div>
        <div class="bg-white p-6 rounded-3xl border border-gray-100 shadow-sm">
            <p class="text-xs font-bold text-gray-400 uppercase tracking-widest">Low Stock Alerts</p>
            <p class="text-2xl font-black text-red-600">{{ $products->where('stock_level', '<', 10)->count() }} Items</p>
        </div>
        <div class="bg-white p-6 rounded-3xl border border-gray-100 shadow-sm">
            <p class="text-xs font-bold text-gray-400 uppercase tracking-widest">Inventory Value</p>
            <p class="text-2xl font-black text-blue-600">₱{{ number_format($products->sum(fn($p) => $p->current_price * $p->stock_level), 2) }}</p>
        </div>
    </div>

    <div class="bg-white rounded-[2rem] shadow-sm border border-gray-100 overflow-hidden">
        <table class="w-full text-left">
            <thead class="bg-gray-50 border-b border-gray-100">
                <tr>
                    <th class="px-8 py-5 text-[10px] uppercase font-black text-gray-400">Product Details</th>
                    <th class="px-8 py-5 text-[10px] uppercase font-black text-gray-400">Category</th>
                    <th class="px-8 py-5 text-[10px] uppercase font-black text-gray-400">Price</th>
                    <th class="px-8 py-5 text-[10px] uppercase font-black text-gray-400">Stock</th>
                    <th class="px-8 py-5 text-center text-[10px] uppercase font-black text-gray-400">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @foreach($products as $product)
                <tr class="hover:bg-blue-50/30 transition">
                    <td class="px-8 py-5">
                        <div class="font-bold text-gray-800">{{ $product->name }}</div>
                        <div class="text-[10px] text-gray-400 font-medium uppercase tracking-tighter">Supplier: {{ $product->supplier->company_name ?? 'N/A' }}</div>
                    </td>
                    <td class="px-8 py-5">
                        <span class="bg-slate-100 text-slate-600 px-3 py-1 rounded-lg text-xs font-bold">
                            {{ $product->category->category_name ?? 'Uncategorized' }}
                        </span>
                    </td>
                    <td class="px-8 py-5 font-black text-blue-700">
                        ₱{{ number_format($product->current_price, 2) }}
                    </td>
                    <td class="px-8 py-5">
                        <div class="flex items-center">
                            <span class="font-bold {{ $product->stock_level < 10 ? 'text-red-600' : 'text-gray-700' }}">
                                {{ $product->stock_level }}
                            </span>
                            @if($product->stock_level < 10)
                                <span class="ml-2 text-[9px] bg-red-100 text-red-600 px-2 py-0.5 rounded-full font-black uppercase italic animate-pulse">Critical</span>
                            @endif
                        </div>
                    </td>
                    <td class="px-8 py-5">
                        <div class="flex justify-center space-x-2">
                            <a href="{{ route('products.edit', $product) }}" class="p-2 text-blue-600 hover:bg-blue-50 rounded-xl transition">✏️</a>
                            <form action="{{ route('products.destroy', $product) }}" method="POST" class="inline">
                                @csrf @method('DELETE')
                                <button class="p-2 text-red-500 hover:bg-red-50 rounded-xl transition" onclick="return confirm('Delete item?')">🗑️</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<div class="bg-white p-6 rounded-3xl border border-gray-100 shadow-sm">
    <p class="text-xs font-bold text-gray-400 uppercase tracking-widest">Inventory Value</p>
    <p class="text-2xl font-black text-blue-600">
        {{-- This multiplies price by stock for every item and sums them up --}}
        ₱{{ number_format($products->sum(fn($p) => $p->current_price * $p->stock_level), 2) }}
    </p>
</div>
@endsection
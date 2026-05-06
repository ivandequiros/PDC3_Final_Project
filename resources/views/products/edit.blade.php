@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="mb-10">
        <a href="{{ route('products.index') }}" class="text-blue-600 font-black text-[10px] uppercase tracking-widest hover:underline">← Back to Inventory</a>
        <h1 class="text-3xl font-black text-[#1e3a8a] mt-3 tracking-tight uppercase italic">Edit <span class="text-blue-500">Product</span></h1>
        <p class="text-gray-400 font-black uppercase text-[10px] tracking-[0.2em]">Updating ID: #{{ $product->id }}</p>
    </div>

    <form action="{{ route('products.update', $product) }}" method="POST" class="bg-white p-10 rounded-[3rem] shadow-sm border border-gray-100 space-y-6">
        @csrf
        @method('PUT') {{-- This tells Laravel to treat this as an UPDATE request --}}

        <div>
            <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest block mb-2">Product Name</label>
            <input type="text" name="product_name" value="{{ $product->name }}" required class="w-full bg-gray-50 border-none rounded-2xl p-4 font-bold text-gray-800 focus:ring-2 focus:ring-blue-500">
        </div>

        <div class="grid grid-cols-2 gap-6">
            <div>
                <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest block mb-2">Category</label>
                <select name="category_id" class="w-full bg-gray-50 border-none rounded-2xl p-4 font-bold text-gray-800">
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ $product->category_id == $category->id ? 'selected' : '' }}>
                            {{ $category->category_name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest block mb-2">Supplier</label>
                <select name="supplier_id" class="w-full bg-gray-50 border-none rounded-2xl p-4 font-bold text-gray-800">
                    @foreach($suppliers as $supplier)
                        <option value="{{ $supplier->id }}" {{ $product->supplier_id == $supplier->id ? 'selected' : '' }}>
                            {{ $supplier->company_name }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="grid grid-cols-2 gap-6">
            <div>
                <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest block mb-2">Price (₱)</label>
                <input type="number" step="0.01" name="current_price" value="{{ $product->current_price }}" required class="w-full bg-gray-50 border-none rounded-2xl p-4 font-bold text-blue-600">
            </div>
            <div>
                <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest block mb-2">Stock Level</label>
                <input type="number" name="stock_level" value="{{ $product->stock_level }}" required class="w-full bg-gray-50 border-none rounded-2xl p-4 font-bold text-gray-800">
            </div>
        </div>

        <button type="submit" class="w-full bg-[#1e3a8a] text-white p-5 rounded-2xl font-black uppercase tracking-widest shadow-xl hover:bg-blue-800 transition transform active:scale-95">
            Update Inventory Item
        </button>
    </form>
</div>
@endsection
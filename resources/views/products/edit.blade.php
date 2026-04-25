@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="mb-10">
        <h1 class="text-3xl font-black text-[#1e3a8a] tracking-tight uppercase italic">Edit <span class="text-blue-500">Product</span></h1>
        <p class="text-gray-400 font-black uppercase text-[10px] tracking-[0.2em] mt-1">Modify inventory details for #{{ $product->id }}</p>
    </div>

    <form action="{{ route('products.update', $product) }}" method="POST" class="bg-white p-10 rounded-[3rem] shadow-sm border border-gray-100">
        @csrf
        @method('PUT') {{-- This is critical for Update routes --}}
        
        <div class="space-y-6">
            <div>
                <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest block mb-2">Product Name</label>
                <input type="text" name="product_name" value="{{ $product->product_name }}" class="w-full bg-gray-50 border-none rounded-2xl p-4 font-bold text-gray-800 focus:ring-2 focus:ring-blue-500" required>
            </div>

            <div>
                <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest block mb-2">Category</label>
                <select name="category_id" class="w-full bg-gray-50 border-none rounded-2xl p-4 font-bold text-gray-800 focus:ring-2 focus:ring-blue-500">
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ $product->category_id == $category->id ? 'selected' : '' }}>
                            {{ $category->category_name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="grid grid-cols-2 gap-6">
                <div>
                    <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest block mb-2">Price (₱)</label>
                    <input type="number" step="0.01" name="current_price" value="{{ $product->current_price }}" class="w-full bg-gray-50 border-none rounded-2xl p-4 font-bold text-gray-800 focus:ring-2 focus:ring-blue-500" required>
                </div>
                <div>
                    <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest block mb-2">Stock Level</label>
                    <input type="number" name="stock_level" value="{{ $product->stock_level }}" class="w-full bg-gray-50 border-none rounded-2xl p-4 font-bold text-gray-800 focus:ring-2 focus:ring-blue-500" required>
                </div>
            </div>

            <button type="submit" class="w-full bg-[#1e3a8a] text-white p-5 rounded-2xl font-black uppercase tracking-widest shadow-xl hover:bg-blue-800 transition">
                Update Inventory Item
            </button>
        </div>
    </form>
</div>
@endsection
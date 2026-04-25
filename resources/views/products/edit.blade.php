@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="mb-8">
        <a href="{{ route('products.index') }}" class="text-blue-600 font-black text-[10px] uppercase tracking-widest hover:underline flex items-center gap-2">
            ← Back to Inventory
        </a>
        <h1 class="text-4xl font-black text-[#1e3a8a] mt-3 tracking-tight">Edit Product</h1>
        <p class="text-gray-400 font-bold uppercase text-[10px] tracking-widest mt-1">Modifying: {{ $product->name }}</p>
    </div>

    <div class="bg-white p-10 rounded-[3rem] shadow-xl border border-gray-100">
        <form action="{{ route('products.update', $product->id) }}" method="POST" class="space-y-8">
            @csrf
            @method('PUT') 
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="md:col-span-2">
                    <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Item Name / Description</label>
                    <input type="text" name="name" value="{{ old('name', $product->name) }}" required 
                        class="w-full px-6 py-5 rounded-2xl border-none bg-gray-50 focus:ring-4 focus:ring-blue-100 transition shadow-inner font-bold text-gray-700">
                    @error('name') <p class="text-red-500 text-[10px] font-bold mt-2 uppercase tracking-tighter">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Category</label>
                    <div class="relative">
                        <select name="category_id" required class="w-full px-6 py-5 rounded-2xl border-none bg-gray-50 focus:ring-4 focus:ring-blue-100 transition shadow-inner font-bold text-gray-700 appearance-none">
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ $product->category_id == $category->id ? 'selected' : '' }}>
                                    {{ $category->category_name }}
                                </option>
                            @endforeach
                        </select>
                        <div class="absolute inset-y-0 right-5 flex items-center pointer-events-none text-gray-400">▼</div>
                    </div>
                </div>

                <div>
                    <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Primary Supplier</label>
                    <div class="relative">
                        <select name="supplier_id" required class="w-full px-6 py-5 rounded-2xl border-none bg-gray-50 focus:ring-4 focus:ring-blue-100 transition shadow-inner font-bold text-gray-700 appearance-none">
                            @foreach($suppliers as $supplier)
                                <option value="{{ $supplier->id }}" {{ $product->supplier_id == $supplier->id ? 'selected' : '' }}>
                                    {{ $supplier->company_name }}
                                </option>
                            @endforeach
                        </select>
                        <div class="absolute inset-y-0 right-5 flex items-center pointer-events-none text-gray-400">▼</div>
                    </div>
                </div>

                <div>
                    <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Unit Selling Price (₱)</label>
                    <input type="number" name="current_price" step="0.01" value="{{ old('current_price', $product->current_price) }}" required 
                        class="w-full px-6 py-5 rounded-2xl border-none bg-gray-50 focus:ring-4 focus:ring-blue-100 transition shadow-inner font-black text-blue-600 text-lg">
                </div>

                <div>
                    <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Current Stock Level</label>
                    <input type="number" name="stock_level" value="{{ old('stock_level', $product->stock_level) }}" required 
                        class="w-full px-6 py-5 rounded-2xl border-none bg-gray-50 focus:ring-4 focus:ring-blue-100 transition shadow-inner font-bold text-gray-700 text-lg">
                </div>
            </div>

            <div class="pt-8 border-t border-gray-50 flex gap-4 justify-end">
                <a href="{{ route('products.index') }}" class="sc-btn-secondary px-8 py-4 bg-gray-100 text-gray-500 rounded-2xl font-bold hover:bg-gray-200 transition text-xs uppercase tracking-widest flex items-center">
                    Cancel
                </a>
                <button type="submit" class="sc-btn-primary bg-[#1e3a8a] text-white px-8 py-4 rounded-2xl font-black shadow-lg hover:scale-105 transition transform active:scale-95 text-xs uppercase tracking-widest flex items-center gap-2">
                    💾 Save Changes
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
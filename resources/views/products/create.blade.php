@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto">
    {{-- Validation Error Alert --}}
    @if ($errors->any())
        <div class="bg-red-100 text-red-600 p-6 rounded-[2rem] mb-8 border border-red-200 shadow-sm animate-bounce">
            <h3 class="font-black uppercase text-[10px] tracking-widest mb-3 flex items-center gap-2">
                <span>🚫</span> Submission Errors detected
            </h3>
            <ul class="space-y-1">
                @foreach ($errors->all() as $error)
                    <li class="text-xs font-bold flex items-center gap-2 italic underline decoration-red-300">
                        {{ $error }}
                    </li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="mb-8">
        <a href="{{ route('products.index') }}" class="text-blue-600 font-black text-[10px] uppercase tracking-widest hover:underline flex items-center gap-2 transition hover:-translate-x-1">
            ← Back to Inventory
        </a>
        <h1 class="text-4xl font-black text-[#1e3a8a] mt-3 tracking-tight uppercase italic">Register New <span class="text-blue-500">Supply</span></h1>
        <p class="text-gray-400 font-bold uppercase text-[10px] tracking-widest mt-1">Add new items to the warehouse catalog</p>
    </div>

    <div class="bg-white p-10 rounded-[3rem] shadow-xl border border-gray-100 relative overflow-hidden">
        <form action="{{ route('products.store') }}" method="POST" class="space-y-8 relative z-10">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="md:col-span-2">
                    <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Item Name / Description</label>
                    {{-- FIXED: Changed name="name" to name="product_name" --}}
                    <input type="text" name="product_name" value="{{ old('product_name') }}" placeholder="e.g. Mongol Pencil #2 (12pcs)" required 
                        class="w-full px-6 py-5 rounded-2xl border-none bg-gray-50 focus:ring-4 focus:ring-blue-100 transition shadow-inner font-bold text-gray-700">
                </div>

                <div>
                    <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Category</label>
                    <div class="relative">
                        <select name="category_id" required class="w-full px-6 py-5 rounded-2xl border-none bg-gray-50 focus:ring-4 focus:ring-blue-100 transition shadow-inner font-bold text-gray-700 appearance-none">
                            <option value="" disabled selected>Select Classification</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
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
                            <option value="" disabled selected>Select Supplier</option>
                            @foreach($suppliers as $supplier)
                                <option value="{{ $supplier->id }}" {{ old('supplier_id') == $supplier->id ? 'selected' : '' }}>
                                    {{ $supplier->company_name }}
                                </option>
                            @endforeach
                        </select>
                        <div class="absolute inset-y-0 right-5 flex items-center pointer-events-none text-gray-400">▼</div>
                    </div>
                </div>

                <div>
                    <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Unit Selling Price (₱)</label>
                    <input type="number" name="current_price" step="0.01" value="{{ old('current_price') }}" placeholder="0.00" required 
                        class="w-full px-6 py-5 rounded-2xl border-none bg-gray-50 focus:ring-4 focus:ring-blue-100 transition shadow-inner font-black text-blue-600 text-lg">
                </div>

                <div>
                    <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Initial Stock Level</label>
                    <input type="number" name="stock_level" value="{{ old('stock_level') }}" placeholder="0" required 
                        class="w-full px-6 py-5 rounded-2xl border-none bg-gray-50 focus:ring-4 focus:ring-blue-100 transition shadow-inner font-bold text-gray-700 text-lg">
                </div>
                
                {{-- Added Alert Level for Managers to set low-stock thresholds --}}
                <div class="md:col-span-2">
                    <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Low Stock Threshold</label>
                    <input type="number" name="alert_level" value="{{ old('alert_level', 10) }}" required 
                        class="w-full px-6 py-5 rounded-2xl border-none bg-gray-50 focus:ring-4 focus:ring-blue-100 transition shadow-inner font-bold text-gray-400 italic">
                </div>
            </div>

            <div class="pt-8 border-t border-gray-50 flex gap-4 justify-end">
                <a href="{{ route('products.index') }}" class="px-8 py-4 bg-gray-100 text-gray-500 rounded-2xl font-bold hover:bg-gray-200 transition text-xs uppercase tracking-widest">
                    Cancel
                </a>
                <button type="submit" class="bg-[#1e3a8a] text-white px-8 py-4 rounded-2xl font-black shadow-lg hover:bg-blue-800 hover:scale-105 transition transform active:scale-95 text-xs uppercase tracking-widest flex items-center gap-2">
                    💾 Deploy Product
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto">
    {{-- Success Message --}}
    @if(session('success'))
        <div class="bg-green-600 text-white p-4 rounded-2xl mb-6 font-black uppercase text-[10px] tracking-widest shadow-lg">
            ✅ {{ session('success') }}
        </div>
    @endif

    {{-- Error Alert --}}
    @if ($errors->any())
        <div class="bg-red-600 text-white p-5 rounded-2xl mb-8 font-black uppercase text-[10px] tracking-widest shadow-2xl">
            <p class="mb-2 underline">🚨 Submission Rejected:</p>
            <ul class="list-disc pl-5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Header --}}
    <div class="bg-white rounded-[3rem] shadow-sm border border-gray-100 overflow-hidden">
    <table class="w-full text-left">
        {{-- Table Labels (Headers) --}}
        <thead class="bg-gray-50 border-b border-gray-100">
            <tr>
                <th class="px-8 py-5 text-[10px] uppercase font-black text-gray-400 tracking-widest">Product Details</th>
                <th class="px-8 py-5 text-[10px] uppercase font-black text-gray-400 tracking-widest text-right">Price</th>
                <th class="px-8 py-5 text-[10px] uppercase font-black text-gray-400 tracking-widest text-center">Stock</th>
                <th class="px-8 py-5 text-center text-[10px] uppercase font-black text-gray-400 tracking-widest">Actions</th>
            </tr>
        </thead>

        <tbody class="divide-y divide-gray-50 text-sm">
            @foreach($products as $product)
            <tr class="hover:bg-blue-50/30 transition">
                <td class="px-8 py-5">
                    <div class="font-black text-gray-800 tracking-tight">{{ $product->name }}</div>
                    <div class="text-[9px] text-gray-400 font-black uppercase italic">ID: #{{ $product->id }}</div>
                </td>
                <td class="px-8 py-5 text-right font-black text-blue-700">
                    ₱{{ number_format($product->current_price, 2) }}
                </td>
                <td class="px-8 py-5 text-center font-black text-gray-700">
                    {{ $product->stock_level }}
                </td>
                <td class="px-8 py-5">
                    <div class="flex justify-center items-center space-x-3">
                        {{-- Edit Button --}}
                        <a href="{{ route('products.edit', $product) }}" class="p-2 text-blue-600 hover:bg-blue-50 rounded-xl transition" title="Edit">
                            ✏️
                        </a>

                        {{-- Delete Button --}}
                        <form action="{{ route('products.destroy', $product) }}" method="POST" class="inline">
                            @csrf 
                            @method('DELETE')
                            <button type="submit" class="p-2 text-red-500 hover:bg-red-50 rounded-xl transition" onclick="return confirm('Are you sure you want to delete this item?')" title="Delete">
                                🗑️
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

{{-- Add Modal --}}
<div id="addModal" class="fixed inset-0 bg-[#1e3a8a]/40 backdrop-blur-sm items-center justify-center z-50 hidden flex px-4">
    <div class="bg-white rounded-[3rem] p-10 w-full max-w-md shadow-2xl relative">
        <button onclick="toggleModal('addModal', false)" class="absolute top-8 right-8 text-gray-400 font-black">✕</button>
        <h2 class="text-2xl font-black text-[#1e3a8a] mb-8 uppercase italic">New <span class="text-blue-500">Supply</span></h2>

        <form action="{{ route('products.store') }}" method="POST">
            @csrf 
            <div class="space-y-4">
                <div>
                    <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest block mb-1">Product Name</label>
                    <input type="text" name="product_name" required class="w-full px-5 py-4 bg-gray-50 rounded-2xl border-none font-bold">
                </div>
                <div>
                    <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest block mb-1">Category</label>
                    <select name="category_id" required class="w-full px-5 py-4 bg-gray-50 rounded-2xl border-none font-bold">
                        <option value="">Select Category</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->category_name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest block mb-1">Supplier</label>
                    <select name="supplier_id" required class="w-full px-5 py-4 bg-gray-50 rounded-2xl border-none font-bold">
                        <option value="">Select Supplier</option>
                        @foreach($suppliers as $supplier)
                            <option value="{{ $supplier->id }}">{{ $supplier->company_name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest block mb-1">Price</label>
                        <input type="number" step="0.01" name="current_price" required class="w-full px-5 py-4 bg-gray-50 rounded-2xl border-none font-bold">
                    </div>
                    <div>
                        <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest block mb-1">Qty</label>
                        <input type="number" name="stock_level" required class="w-full px-5 py-4 bg-gray-50 rounded-2xl border-none font-bold">
                    </div>
                </div>
            </div>
            <button type="submit" class="w-full mt-8 bg-[#1e3a8a] text-white font-black py-5 rounded-2xl shadow-xl hover:bg-blue-800 uppercase text-[10px] tracking-widest">
                🚀 Save to Inventory
            </button>
        </form>
    </div>
</div>

<script>
    function toggleModal(modalId, show) {
        document.getElementById(modalId).classList.toggle('hidden', !show);
    }
</script>
@endsection
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
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-3xl font-black text-[#1e3a8a] tracking-tight uppercase italic">Inventory</h1>
        <button type="button" onclick="toggleModal('addModal', true)" class="bg-green-600 text-white px-8 py-4 rounded-2xl font-black uppercase text-[10px] tracking-widest shadow-xl transform active:scale-95">
            ➕ Add New Supply
        </button>
    </div>

    {{-- Table (Briefly) --}}
    <div class="bg-white rounded-[3rem] shadow-sm border border-gray-100 overflow-hidden">
        <table class="w-full text-left">
            <tbody class="divide-y divide-gray-50">
                @foreach($products as $product)
                <tr>
                    <td class="px-8 py-5 font-black text-gray-800">{{ $product->name }}</td>
                    <td class="px-8 py-5">₱{{ number_format($product->current_price, 2) }}</td>
                    <td class="px-8 py-5 font-bold">{{ $product->stock_level }}</td>
                    <td class="px-8 py-5">
                        <form action="{{ route('products.destroy', $product) }}" method="POST">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-red-500">🗑️</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
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
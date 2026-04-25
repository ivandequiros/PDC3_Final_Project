@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto">
    <div class="mb-10">
        <h1 class="text-4xl font-black text-[#1e3a8a] tracking-tight">Inventory Categories</h1>
        <p class="text-gray-400 font-bold uppercase text-[10px] tracking-widest mt-1">Classification Management</p>
    </div>

    @if(session('success'))
        <div class="mb-6 p-4 bg-green-100 border-l-4 border-green-500 text-green-700 font-bold rounded-r-xl shadow-sm">
            ✅ {{ session('success') }}
        </div>
    @endif

    <div class="flex flex-col lg:flex-row gap-10">
        <div class="w-full lg:w-1/3">
            <div class="bg-white p-10 rounded-[3rem] shadow-sm border border-gray-100 sticky top-10">
                <h2 class="text-xl font-black text-gray-800 mb-6 italic">New Category</h2>
                <form action="{{ route('categories.store') }}" method="POST" class="space-y-6">
                    @csrf
                    <div>
                        <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Category Name</label>
                        <input type="text" name="category_name" placeholder="e.g. Sensors" required 
                            class="w-full px-6 py-5 rounded-2xl bg-gray-50 border-none focus:ring-4 focus:ring-blue-100 transition shadow-inner font-bold text-gray-700">
                    </div>

                    <div class="flex gap-4 justify-end">
                        <button type="reset" class="sc-btn-secondary px-8 py-4 bg-gray-100 text-gray-500 rounded-2xl font-bold hover:bg-gray-200 transition text-xs uppercase tracking-widest">
                            Cancel
                        </button>
                        <button type="submit" class="sc-btn-primary bg-[#1e3a8a] text-white px-8 py-4 rounded-2xl font-black shadow-lg hover:scale-105 transition transform active:scale-95 text-xs uppercase tracking-widest">
                            ADD TO SYSTEM
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <div class="flex-1">
            <div class="bg-white rounded-[3rem] shadow-sm border border-gray-100 overflow-hidden">
                <table class="w-full text-left">
                    <thead class="bg-gray-50 border-b border-gray-100">
                        <tr>
                            <th class="px-10 py-6 text-[10px] uppercase font-black text-gray-400 tracking-widest">Classification</th>
                            <th class="px-10 py-6 text-[10px] uppercase font-black text-gray-400 tracking-widest">Linked Items</th>
                            <th class="px-10 py-6 text-[10px] uppercase font-black text-gray-400 tracking-widest text-right">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @forelse($categories as $cat)
                        <tr class="hover:bg-gray-50/50 transition group">
                            <td class="px-10 py-6 font-black text-gray-800 text-lg tracking-tight">
                                {{ $cat->category_name }}
                            </td>
                            <td class="px-10 py-6">
                                <span class="bg-blue-50 text-blue-600 px-4 py-2 rounded-full text-[10px] font-black uppercase tracking-tighter">
                                    {{ $cat->products_count }} Products
                                </span>
                            </td>
                            <td class="px-10 py-6 text-right">
                                <form action="{{ route('categories.destroy', $cat->id) }}" method="POST" onsubmit="return confirm('Deleting this category will affect linked products. Proceed?')">
                                    @csrf @method('DELETE')
                                    <button class="text-gray-300 hover:text-red-500 transition-colors transform hover:scale-110 duration-200 p-2">
                                        <span class="text-xl">🗑️</span>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="px-10 py-24 text-center">
                                <div class="flex flex-col items-center opacity-30">
                                    <span class="text-5xl mb-4">🏷️</span>
                                    <p class="text-gray-400 font-bold italic tracking-tight">No categories defined yet.</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
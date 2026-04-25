@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto">
    <div class="flex justify-between items-center mb-10">
        <div>
            <h1 class="text-3xl font-black text-[#1e3a8a] tracking-tight uppercase italic">Product <span class="text-blue-500">Categories</span></h1>
            <p class="text-gray-400 font-black uppercase text-[10px] tracking-[0.2em] mt-1">Organize your inventory groups</p>
        </div>
        
        {{-- Quick Add Form --}}
        <form action="{{ route('categories.store') }}" method="POST" class="flex gap-4">
            @csrf
            <input type="text" name="category_name" placeholder="New Category Name..." class="bg-white border-none rounded-2xl px-6 py-4 shadow-sm font-bold text-sm focus:ring-2 focus:ring-blue-500" required>
            <button type="submit" class="bg-[#1e3a8a] text-white px-8 py-4 rounded-2xl font-black uppercase text-[10px] tracking-widest shadow-xl hover:bg-blue-800 transition">
                ➕ Add Category
            </button>
        </form>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-6">
        @foreach($categories as $category)
        <div class="bg-white p-8 rounded-[2.5rem] border border-gray-100 shadow-sm hover:shadow-md transition group">
            <div class="flex justify-between items-start mb-4">
                <div class="bg-blue-50 p-3 rounded-2xl">
                    <span class="text-xl">🏷️</span>
                </div>
                <form action="{{ route('categories.destroy', $category) }}" method="POST">
                    @csrf @method('DELETE')
                    <button type="submit" class="text-gray-300 hover:text-red-500 transition" onclick="return confirm('Delete category?')">🗑️</button>
                </form>
            </div>
            <h3 class="font-black text-gray-800 text-lg tracking-tight mb-1">{{ $category->category_name }}</h3>
            <p class="text-[10px] font-black text-blue-500 uppercase tracking-widest">
                {{ $category->products_count }} Linked Products
            </p>
        </div>
        @endforeach
    </div>
</div>
@endsection
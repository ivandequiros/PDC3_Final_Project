@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto">
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-3xl font-black text-[#1e3a8a]">Supply Partners</h1>
            <p class="text-gray-500">Manage your external vendors and contact information.</p>
        </div>
        <a href="{{ route('suppliers.create') }}" class="bg-[#1e3a8a] text-white px-6 py-3 rounded-2xl font-bold transition shadow-lg hover:bg-blue-800">
            + Register Supplier
        </a>
    </div>

    @if(session('success'))
        <div class="mb-6 p-4 bg-green-100 border-l-4 border-green-500 text-green-700 font-bold rounded-r-xl shadow-sm">
            ✅ {{ session('success') }}
        </div>
    @endif

    <div class="bg-white rounded-[2rem] shadow-sm border border-gray-100 overflow-hidden">
        <table class="w-full text-left">
            <thead class="bg-gray-50 border-b border-gray-100">
                <tr>
                    <th class="px-8 py-5 text-[10px] uppercase font-black text-gray-400 tracking-widest">Company</th>
                    <th class="px-8 py-5 text-[10px] uppercase font-black text-gray-400 tracking-widest">Contact Person</th>
                    <th class="px-8 py-5 text-[10px] uppercase font-black text-gray-400 tracking-widest">Contact Info</th>
                    <th class="px-8 py-5 text-[10px] uppercase font-black text-gray-400 tracking-widest text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse($suppliers as $supplier)
                <tr class="hover:bg-gray-50/50 transition">
                    <td class="px-8 py-5">
                        <div class="font-black text-gray-800">{{ $supplier->company_name }}</div>
                        <div class="text-[10px] text-blue-500 font-bold uppercase tracking-tighter">Verified Partner</div>
                    </td>
                    <td class="px-8 py-5 text-gray-600 font-medium">{{ $supplier->contact_person }}</td>
                    <td class="px-8 py-5">
                        <div class="text-sm text-gray-800 font-bold">{{ $supplier->phone }}</div>
                        <div class="text-xs text-gray-400">{{ $supplier->email }}</div>
                    </td>
                    <td class="px-8 py-5 text-right">
                        <a href="{{ route('suppliers.edit', $supplier) }}" class="text-blue-600 font-bold hover:underline mr-4">Edit</a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="px-8 py-20 text-center text-gray-400 italic">No suppliers registered in the database.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
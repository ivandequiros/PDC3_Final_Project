@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="mb-8">
        <a href="{{ route('suppliers.index') }}" class="text-blue-600 font-bold text-sm hover:underline">← Back to Partners</a>
        <h1 class="text-3xl font-black text-[#1e3a8a] mt-2">Edit Supplier: {{ $supplier->company_name }}</h1>
    </div>

    <div class="bg-white p-10 rounded-[2.5rem] shadow-xl border border-gray-100">
        <form action="{{ route('suppliers.update', $supplier) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">Company Name</label>
                <input type="text" name="company_name" value="{{ old('company_name', $supplier->company_name) }}" required 
                    class="w-full px-5 py-4 rounded-2xl border-gray-200 bg-gray-50 focus:ring-4 focus:ring-blue-100 transition shadow-sm">
                @error('company_name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">Primary Contact Person</label>
                <input type="text" name="contact_person" value="{{ old('contact_person', $supplier->contact_person) }}" required 
                    class="w-full px-5 py-4 rounded-2xl border-gray-200 bg-gray-50 focus:ring-4 focus:ring-blue-100 transition shadow-sm">
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Phone Number</label>
                    <input type="text" name="phone" value="{{ old('phone', $supplier->phone) }}" required 
                        class="w-full px-5 py-4 rounded-2xl border-gray-200 bg-gray-50 focus:ring-4 focus:ring-blue-100 transition shadow-sm font-bold text-gray-800">
                </div>
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Email Address</label>
                    <input type="email" name="email" value="{{ old('email', $supplier->email) }}" required 
                        class="w-full px-5 py-4 rounded-2xl border-gray-200 bg-gray-50 focus:ring-4 focus:ring-blue-100 transition shadow-sm">
                </div>
            </div>

            <div class="pt-4">
                <button type="submit" class="w-full bg-[#1e3a8a] text-white font-black py-5 rounded-2xl shadow-lg hover:bg-blue-800 transition transform active:scale-[0.98]">
                    💾 Update Supplier Details
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
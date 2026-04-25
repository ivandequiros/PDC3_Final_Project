@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="mb-8">
        <a href="{{ route('suppliers.index') }}" class="text-blue-600 font-bold text-sm">← Back to Suppliers</a>
        <h1 class="text-3xl font-black text-[#1e3a8a] mt-2">New Supplier</h1>
    </div>

    <div class="bg-white p-10 rounded-[2.5rem] shadow-xl border border-gray-100">
        <form action="{{ route('suppliers.store') }}" method="POST" class="space-y-6">
            @csrf
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">Company Name</label>
                <input type="text" name="company_name" required class="w-full px-5 py-4 rounded-2xl border-gray-200 bg-gray-50 focus:ring-4 focus:ring-blue-100 transition shadow-sm">
            </div>

            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">Primary Contact Person</label>
                <input type="text" name="contact_person" required class="w-full px-5 py-4 rounded-2xl border-gray-200 bg-gray-50 focus:ring-4 focus:ring-blue-100 transition shadow-sm">
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Phone Number</label>
                    <input type="text" name="phone" required class="w-full px-5 py-4 rounded-2xl border-gray-200 bg-gray-50 focus:ring-4 focus:ring-blue-100 transition shadow-sm">
                </div>
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Email Address</label>
                    <input type="email" name="email" required class="w-full px-5 py-4 rounded-2xl border-gray-200 bg-gray-50 focus:ring-4 focus:ring-blue-100 transition shadow-sm">
                </div>
            </div>

            <button type="submit" class="w-full bg-[#1e3a8a] text-white font-black py-5 rounded-2xl shadow-lg hover:bg-blue-800 transition transform active:scale-[0.98]">
                Save Supplier Profile
            </button>
        </form>
    </div>
</div>
@endsection
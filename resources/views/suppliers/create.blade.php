@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto">
    {{-- Validation Error Alert --}}
    @if ($errors->any())
        <div class="bg-red-100 text-red-600 p-6 rounded-[2rem] mb-8 border border-red-200 shadow-sm">
            <h3 class="font-black uppercase text-[10px] tracking-widest mb-3 flex items-center gap-2">
                <span>⚠️</span> Supplier Validation Error
            </h3>
            <ul class="space-y-1">
                @foreach ($errors->all() as $error)
                    <li class="text-xs font-bold italic underline decoration-red-300">
                        {{ $error }}
                    </li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="mb-8">
        <a href="{{ route('suppliers.index') }}" class="text-blue-600 font-black text-[10px] uppercase tracking-widest flex items-center gap-2 hover:underline transition hover:-translate-x-1">
            ← Back to Suppliers
        </a>
        <h1 class="text-4xl font-black text-[#1e3a8a] mt-3 tracking-tight uppercase italic">New <span class="text-blue-500">Supplier</span></h1>
        <p class="text-gray-400 font-bold uppercase text-[10px] tracking-widest mt-1">Register corporate partners and distribution contacts</p>
    </div>

    <div class="bg-white p-10 rounded-[3rem] shadow-xl border border-gray-100 relative overflow-hidden">
        <form action="{{ route('suppliers.store') }}" method="POST" class="space-y-6 relative z-10">
            @csrf
            <div>
                <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2 ml-1">Company Name</label>
                <input type="text" name="company_name" value="{{ old('company_name') }}" placeholder="e.g. National Book Store" required 
                    class="w-full px-6 py-5 rounded-2xl border-none bg-gray-50 focus:ring-4 focus:ring-blue-100 transition shadow-inner font-bold text-gray-800">
            </div>

            <div>
                <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2 ml-1">Primary Contact Person</label>
                <input type="text" name="contact_person" value="{{ old('contact_person') }}" placeholder="Full Name" required 
                    class="w-full px-6 py-5 rounded-2xl border-none bg-gray-50 focus:ring-4 focus:ring-blue-100 transition shadow-inner font-bold text-gray-800">
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2 ml-1">Phone Number</label>
                    <input type="text" name="phone" value="{{ old('phone') }}" placeholder="+63..." required 
                        class="w-full px-6 py-5 rounded-2xl border-none bg-gray-50 focus:ring-4 focus:ring-blue-100 transition shadow-inner font-bold text-gray-800">
                </div>
                <div>
                    <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2 ml-1">Email Address</label>
                    <input type="email" name="email" value="{{ old('email') }}" placeholder="contact@company.com" required 
                        class="w-full px-6 py-5 rounded-2xl border-none bg-gray-50 focus:ring-4 focus:ring-blue-100 transition shadow-inner font-bold text-gray-800">
                </div>
            </div>

            <button type="submit" class="w-full bg-[#1e3a8a] text-white font-black py-5 rounded-2xl shadow-xl hover:bg-blue-800 hover:scale-[1.02] transition transform active:scale-[0.98] uppercase text-[10px] tracking-widest mt-4">
                🚀 Deploy Supplier Profile
            </button>
        </form>
    </div>
</div>
@endsection
@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="mb-8">
        <a href="{{ route('users.index') }}" class="text-blue-600 font-black text-[10px] uppercase tracking-widest hover:underline flex items-center gap-2">
            ← Back to Staff List
        </a>
        <h1 class="text-4xl font-black text-[#1e3a8a] mt-3 tracking-tight">New Staff Member</h1>
        <p class="text-gray-400 font-bold uppercase text-[10px] tracking-widest mt-1">Provision a new user account for the system</p>
    </div>

    <div class="bg-white p-10 rounded-[3rem] shadow-xl border border-gray-100">
        <form action="{{ route('users.store') }}" method="POST" class="space-y-8">
            @csrf
            
            <div class="grid grid-cols-1 gap-8">
                <div>
                    <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Username</label>
                    <input type="text" name="username" placeholder="e.g. jdoe_cashier" required 
                        class="w-full px-6 py-5 rounded-2xl border-none bg-gray-50 focus:ring-4 focus:ring-blue-100 transition shadow-inner font-bold text-gray-700">
                </div>

                <div>
                    <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Email Address</label>
                    <input type="email" name="email" placeholder="e.g. employee@supplycore.com" required 
                        class="w-full px-6 py-5 rounded-2xl border-none bg-gray-50 focus:ring-4 focus:ring-blue-100 transition shadow-inner font-bold text-gray-700">
                </div>

                <div>
                    <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Temporary Password</label>
                    <input type="password" name="password" placeholder="••••••••" required 
                        class="w-full px-6 py-5 rounded-2xl border-none bg-gray-50 focus:ring-4 focus:ring-blue-100 transition shadow-inner font-bold text-gray-700">
                </div>

                <div>
                    <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Assign Access Role</label>
                    <div class="relative">
                        <select name="role_id" required class="w-full px-6 py-5 rounded-2xl border-none bg-gray-50 focus:ring-4 focus:ring-blue-100 transition shadow-inner font-bold text-gray-700 appearance-none">
                            <option value="" disabled selected>Select an access level...</option>
                            @foreach($roles as $role)
                                <option value="{{ $role->id }}">{{ $role->role_name }}</option>
                            @endforeach
                        </select>
                        <div class="absolute inset-y-0 right-5 flex items-center pointer-events-none text-gray-400">▼</div>
                    </div>
                </div>
            </div>

            <div class="pt-8 border-t border-gray-50 flex gap-4 justify-end">
                <a href="{{ route('users.index') }}" class="sc-btn-secondary px-8 py-4 bg-gray-100 text-gray-500 rounded-2xl font-bold hover:bg-gray-200 transition text-xs uppercase tracking-widest flex items-center">
                    Cancel
                </a>
                <button type="submit" class="sc-btn-primary bg-[#1e3a8a] text-white px-8 py-4 rounded-2xl font-black shadow-lg hover:scale-105 transition transform active:scale-95 text-xs uppercase tracking-widest flex items-center gap-2">
                    👤 Create Account
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="mb-10 text-center">
        <h1 class="text-3xl font-black text-[#1e3a8a] tracking-tight uppercase italic">Create <span class="text-blue-500">Account</span></h1>
        <p class="text-gray-400 font-black uppercase text-[10px] tracking-[0.2em] mt-1">Assign Credentials & Permissions</p>
    </div>

    <form action="{{ route('users.store') }}" method="POST" class="bg-white p-10 rounded-[3rem] shadow-sm border border-gray-100">
        @csrf
        <div class="space-y-6">
            <div>
                <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest block mb-2">Username</label>
                <input type="text" name="username" class="w-full bg-gray-50 border-none rounded-2xl p-4 font-bold text-gray-800 focus:ring-2 focus:ring-blue-500" required>
            </div>
            <div>
                <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest block mb-2">Email Address</label>
                <input type="email" name="email" class="w-full bg-gray-50 border-none rounded-2xl p-4 font-bold text-gray-800 focus:ring-2 focus:ring-blue-500" required>
            </div>
            <div>
                <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest block mb-2">Temporary Password</label>
                <input type="password" name="password" class="w-full bg-gray-50 border-none rounded-2xl p-4 font-bold text-gray-800 focus:ring-2 focus:ring-blue-500" required>
            </div>
            <div>
                <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest block mb-2">Assigned Role</label>
                <select name="role_id" class="w-full bg-gray-50 border-none rounded-2xl p-4 font-bold text-gray-800 focus:ring-2 focus:ring-blue-500">
                    @foreach($roles as $role)
                        <option value="{{ $role->id }}">{{ $role->role_name }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="w-full bg-[#1e3a8a] text-white p-5 rounded-2xl font-black uppercase tracking-widest shadow-xl hover:bg-blue-800 transition">
                🚀 Deploy User Account
            </button>
        </div>
    </form>
</div>
@endsection
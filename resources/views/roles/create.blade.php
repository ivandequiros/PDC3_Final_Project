@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="mb-8">
        <a href="{{ route('roles.index') }}" class="text-blue-600 font-bold text-sm">← Back to Roles</a>
        <h1 class="text-3xl font-black text-[#1e3a8a] mt-2">Create New Role Level</h1>
        <p class="text-gray-500">Define a new set of permissions for system access.</p>
    </div>

    <div class="bg-white p-10 rounded-[2.5rem] shadow-xl border border-gray-100">
        <form action="{{ route('roles.store') }}" method="POST" class="space-y-6">
            @csrf
            
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">Role Name</label>
                <input type="text" name="role_name" placeholder="e.g. Supervisor" required 
                    class="w-full px-5 py-4 rounded-2xl border-gray-200 bg-gray-50 focus:ring-4 focus:ring-blue-100 transition shadow-sm">
                @error('role_name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">Permissions List</label>
                <textarea name="permissions" rows="3" placeholder="e.g. inventory,sales,reports" required 
                    class="w-full px-5 py-4 rounded-2xl border-gray-200 bg-gray-50 focus:ring-4 focus:ring-blue-100 transition shadow-sm font-mono text-sm"></textarea>
                <div class="flex flex-wrap gap-2 mt-3">
                    <span class="text-[10px] bg-slate-100 text-slate-500 px-2 py-1 rounded font-bold">inventory</span>
                    <span class="text-[10px] bg-slate-100 text-slate-500 px-2 py-1 rounded font-bold">sales</span>
                    <span class="text-[10px] bg-slate-100 text-slate-500 px-2 py-1 rounded font-bold">reports</span>
                    <span class="text-[10px] bg-slate-100 text-slate-500 px-2 py-1 rounded font-bold">users</span>
                    <span class="text-[10px] bg-slate-100 text-slate-500 px-2 py-1 rounded font-bold">all</span>
                </div>
            </div>

            <button type="submit" class="w-full bg-green-600 text-white font-black py-5 rounded-2xl shadow-lg hover:bg-green-700 transition transform active:scale-[0.98]">
                ➕ Save New Role
            </button>
        </form>
    </div>
</div>
@endsection
@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="mb-8">
        <a href="{{ route('roles.index') }}" class="text-blue-600 font-bold text-sm">← Back to Roles</a>
        <h1 class="text-3xl font-black text-[#1e3a8a] mt-2">Edit Role: {{ $role->role_name }}</h1>
    </div>

    <div class="bg-white p-10 rounded-[2.5rem] shadow-xl border border-gray-100">
        <form action="{{ route('roles.update', $role) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')
            
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">Role Title</label>
                <input type="text" name="role_name" value="{{ $role->role_name }}" required 
                    class="w-full px-5 py-4 rounded-2xl border-gray-200 bg-gray-50 focus:ring-4 focus:ring-blue-100 transition shadow-sm">
            </div>

            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">Permission Keys (Comma separated)</label>
                <textarea name="permissions" rows="3" required 
                    class="w-full px-5 py-4 rounded-2xl border-gray-200 bg-gray-50 focus:ring-4 focus:ring-blue-100 transition shadow-sm font-mono text-sm">{{ $role->permissions }}</textarea>
                <p class="text-[10px] text-gray-400 mt-3 uppercase font-bold tracking-tighter">
                    Available Keys: inventory, sales, reports, users, logs, all
                </p>
            </div>

            <div class="bg-blue-50 p-6 rounded-2xl border border-blue-100">
                <p class="text-xs text-blue-700 leading-relaxed">
                    <strong>Note:</strong> Changes to these permissions will affect all personnel assigned to the <strong>{{ $role->role_name }}</strong> role immediately.
                </p>
            </div>

            <button type="submit" class="w-full bg-[#1e3a8a] text-white font-black py-5 rounded-2xl shadow-lg hover:bg-blue-800 transition transform active:scale-[0.98]">
                Update Access Level
            </button>
        </form>
    </div>
</div>
@endsection
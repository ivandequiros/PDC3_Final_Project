@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto">
    <div class="flex justify-between items-center mb-10">
        <div>
            <h1 class="text-3xl font-black text-[#1e3a8a] tracking-tight uppercase italic">Staff <span class="text-blue-500">Registry</span></h1>
            <p class="text-gray-400 font-black uppercase text-[10px] tracking-[0.2em] mt-1">Authorized System Personnel</p>
        </div>
        {{-- CRITICAL: This link must match your route name --}}
        <a href="{{ route('users.create') }}" class="bg-[#1e3a8a] text-white px-8 py-4 rounded-2xl font-black shadow-xl hover:bg-blue-800 transition text-[10px] uppercase tracking-widest">
            ➕ Add New Staff
        </a>
    </div>

    <div class="bg-white rounded-[3rem] shadow-sm border border-gray-100 overflow-hidden">
        <table class="w-full text-left">
            <thead class="bg-gray-50 border-b border-gray-100">
                <tr>
                    <th class="px-8 py-5 text-[10px] uppercase font-black text-gray-400 tracking-widest">Username</th>
                    <th class="px-8 py-5 text-[10px] uppercase font-black text-gray-400 tracking-widest">Role</th>
                    <th class="px-8 py-5 text-center text-[10px] uppercase font-black text-gray-400 tracking-widest">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @foreach($users as $user)
                <tr class="hover:bg-blue-50/30 transition">
                    <td class="px-8 py-5 font-bold text-gray-800">{{ $user->username }}</td>
                    <td class="px-8 py-5">
                        <span class="px-3 py-1 rounded-lg text-[10px] font-black uppercase bg-blue-50 text-blue-600">
                            {{ $user->role->role_name }}
                        </span>
                    </td>
                    <td class="px-8 py-5 text-center">
                        <form action="{{ route('users.destroy', $user) }}" method="POST" onsubmit="return confirm('Delete user?')">
                            @csrf @method('DELETE')
                            <button class="text-red-500 hover:scale-110 transition">🗑️</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
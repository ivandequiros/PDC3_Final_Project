@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto">
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-3xl font-black text-[#1e3a8a]">Staff Accounts</h1>
            <p class="text-gray-500">Manage internal personnel and their system access.</p>
        </div>
        <a href="{{ route('users.create') }}" class="bg-[#1e3a8a] text-white px-6 py-3 rounded-2xl font-bold transition shadow-lg hover:bg-blue-800">
            + Add Staff Member
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
                    <th class="px-8 py-5 text-[10px] uppercase font-black text-gray-400 tracking-widest">User Details</th>
                    <th class="px-8 py-5 text-[10px] uppercase font-black text-gray-400 tracking-widest">Email</th>
                    <th class="px-8 py-5 text-[10px] uppercase font-black text-gray-400 tracking-widest">Role</th>
                    <th class="px-8 py-5 text-[10px] uppercase font-black text-gray-400 tracking-widest text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @foreach($users as $user)
                <tr class="hover:bg-gray-50/50 transition">
                    <td class="px-8 py-5">
                        <div class="flex items-center">
                            <div class="w-10 h-10 rounded-full bg-gradient-to-tr from-blue-600 to-blue-400 text-white flex items-center justify-center font-bold mr-4">
                                {{ strtoupper(substr($user->username, 0, 1)) }}
                            </div>
                            <span class="font-black text-gray-800">{{ $user->username }}</span>
                        </div>
                    </td>
                    <td class="px-8 py-5 text-gray-500 text-sm">{{ $user->email }}</td>
                    <td class="px-8 py-5">
                        <span class="px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-widest 
                            {{ $user->role->role_name == 'Admin' ? 'bg-purple-100 text-purple-700' : 
                               ($user->role->role_name == 'Manager' ? 'bg-blue-100 text-blue-700' : 'bg-gray-100 text-gray-600') }}">
                            {{ $user->role->role_name }}
                        </span>
                    </td>
                    <td class="px-8 py-5 text-right">
    <a href="{{ route('users.edit', $user->id) }}" class="bg-gray-50 text-gray-600 hover:bg-blue-50 hover:text-blue-600 px-4 py-2 rounded-xl transition font-bold text-sm shadow-sm border border-gray-100">
        Manage
    </a>
</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
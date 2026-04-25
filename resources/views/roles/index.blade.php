@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto">
    <div class="flex justify-between items-center mb-10">
        <div>
            <h1 class="text-4xl font-black text-[#1e3a8a] tracking-tight">Access Permissions</h1>
            <p class="text-gray-400 font-bold uppercase text-[10px] tracking-widest mt-1">Define security levels and personnel capabilities</p>
        </div>
        <a href="{{ route('roles.create') }}" class="sc-btn-primary bg-[#1e3a8a] text-white px-8 py-4 rounded-2xl font-black shadow-lg hover:bg-blue-800 transition">
            + New Role Level
        </a>
    </div>

    @if(session('success'))
        <div class="mb-8 p-4 bg-green-100 border-l-4 border-green-500 text-green-700 font-bold rounded-r-xl shadow-sm">
            ✅ {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="mb-8 p-4 bg-red-100 border-l-4 border-red-500 text-red-700 font-bold rounded-r-xl shadow-sm">
            ❌ {{ session('error') }}
        </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        @foreach($roles as $role)
        <div class="bg-white rounded-[3rem] p-10 shadow-sm border border-gray-100 flex flex-col justify-between hover:shadow-xl transition-all group">
            <div>
                <div class="flex items-center justify-between mb-6">
                    <span class="w-14 h-14 bg-blue-50 rounded-2xl flex items-center justify-center text-2xl shadow-inner">🔐</span>
                    <span class="text-[10px] font-black uppercase tracking-widest text-blue-400">Security Level {{ $role->id }}</span>
                </div>
                
                <h3 class="text-2xl font-black text-gray-800 mb-2">{{ $role->role_name }}</h3>
                
                <div class="mb-8">
                    <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-3">Capabilities</p>
                    <div class="bg-gray-50 p-4 rounded-2xl border border-gray-50">
                        <p class="text-xs text-blue-600 font-mono italic leading-relaxed">
                            {{ str_replace(',', ' • ', $role->permissions ?? 'No special permissions') }}
                        </p>
                    </div>
                </div>
            </div>

            <div class="space-y-6">
                <div class="pt-6 border-t border-gray-50 flex items-center justify-between">
                    <div>
                        <p class="text-[10px] font-black text-gray-400 uppercase mb-1">Active Users</p>
                        <p class="font-bold text-gray-700 text-sm">{{ $role->users_count }} Personnel</p>
                    </div>
                    <div class="flex -space-x-2">
                        @for($i = 0; $i < min($role->users_count, 3); $i++)
                            <div class="w-8 h-8 rounded-full border-2 border-white bg-blue-100 flex items-center justify-center text-[10px] font-black text-blue-600">
                                {{ strtoupper(substr($role->role_name, 0, 1)) }}
                            </div>
                        @endfor
                    </div>
                </div>

                <div class="flex gap-3">
                    <a href="{{ route('roles.edit', $role->id) }}" class="flex-1 text-center py-4 bg-gray-100 text-gray-500 rounded-2xl font-bold hover:bg-gray-200 transition text-xs uppercase tracking-widest">
                        Edit
                    </a>
                    
                    {{-- ONLY show delete for non-system roles like 'Customer' --}}
                    @if(!in_array(strtolower($role->role_name), ['admin', 'manager', 'cashier']))
                        <form action="{{ route('roles.destroy', $role->id) }}" method="POST" onsubmit="return confirm('Permanently delete this role? This cannot be undone.')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="p-4 bg-red-50 text-red-500 rounded-2xl hover:bg-red-100 transition shadow-sm">
                                🗑️
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection
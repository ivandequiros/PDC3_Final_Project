@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="mb-8 flex justify-between items-end">
        <div>
            <a href="{{ route('users.index') }}" class="text-blue-600 font-bold text-sm hover:underline">← Back to Staff List</a>
            <h1 class="text-3xl font-black text-[#1e3a8a] mt-2">Edit Staff Profile</h1>
            <p class="text-gray-500">Updating account for: <strong>{{ $user->username }}</strong></p>
        </div>
        
        @if(auth()->id() !== $user->id)
        <form action="{{ route('users.destroy', $user) }}" method="POST" onsubmit="return confirm('Are you sure you want to deactivate this staff account?')">
            @csrf @method('DELETE')
            <button class="text-red-500 font-bold text-xs hover:bg-red-50 px-4 py-2 rounded-xl transition border border-red-100">
                Deactivate Account
            </button>
        </form>
        @endif
    </div>

    <div class="bg-white p-10 rounded-[2.5rem] shadow-xl border border-gray-100">
        <form action="{{ route('users.update', $user) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')
            
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">Username</label>
                <input type="text" name="username" value="{{ old('username', $user->username) }}" required 
                    class="w-full px-5 py-4 rounded-2xl border-gray-200 bg-gray-50 focus:ring-4 focus:ring-blue-100 transition shadow-sm">
                @error('username') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">Email Address</label>
                <input type="email" name="email" value="{{ old('email', $user->email) }}" required 
                    class="w-full px-5 py-4 rounded-2xl border-gray-200 bg-gray-50 focus:ring-4 focus:ring-blue-100 transition shadow-sm">
                @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">Reset Password</label>
                <input type="password" name="password" placeholder="Leave blank to keep current password"
                    class="w-full px-5 py-4 rounded-2xl border-gray-200 bg-gray-50 focus:ring-4 focus:ring-blue-100 transition shadow-sm">
                <p class="text-[10px] text-gray-400 mt-2 italic">Only fill this out if the staff member forgot their password.</p>
            </div>

            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">System Access Level</label>
                <select name="role_id" required class="w-full px-5 py-4 rounded-2xl border-gray-200 bg-gray-50 focus:ring-4 focus:ring-blue-100 transition shadow-sm appearance-none">
                    @foreach($roles as $role)
                        <option value="{{ $role->id }}" {{ $user->role_id == $role->id ? 'selected' : '' }}>
                            {{ $role->role_name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="pt-4">
                <button type="submit" class="w-full bg-[#1e3a8a] text-white font-black py-5 rounded-2xl shadow-lg hover:bg-blue-800 transition transform active:scale-[0.98]">
                    💾 Save Staff Changes
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
@extends('layouts.guest')

@section('content')

    <div class="flex justify-center mb-6">
        <div
            class="h-16 w-16 bg-[#1e3a8a] rounded-2xl flex items-center justify-center shadow-lg transform -rotate-6 text-3xl">
            🎒
        </div>
    </div>
    <div class="text-center mb-8">
        <h2 class="text-3xl font-extrabold text-[#1e3a8a]">Registration</h2>
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-5">
        @csrf
        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-1">Username</label>
            <input type="text" name="username" required
                class="w-full px-4 py-3 rounded-xl border border-gray-200 shadow-sm">
        </div>

        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-1">Password</label>
            <input type="password" name="password" required
                class="w-full px-4 py-3 rounded-xl border border-gray-200 shadow-sm">
        </div>

        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-1">Access Level / Role</label>
            <select name="role_id" class="w-full px-4 py-3 rounded-xl border border-gray-200 shadow-sm bg-white">
                @foreach($roles as $role)
                    <option value="{{ $role->id }}">{{ $role->role_name }}</option>
                @endforeach
            </select>
        </div>

        <button type="submit"
            class="w-full bg-green-600 text-white font-bold py-3.5 rounded-xl hover:bg-green-700 shadow-lg transition active:scale-95">
            Register User
        </button>

        <div class="text-center mt-6">
            <a href="{{ route('login') }}" class="text-sm font-medium text-gray-400 hover:text-blue-600">Back to Sign In</a>
        </div>
    </form>
@endsection
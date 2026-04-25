@extends('layouts.guest')

@section('content')
    <div class="flex justify-center mb-6">
       <div class="w-20 h-20 bg-blue-50 rounded-[2rem] flex items-center justify-center shadow-inner ">
        <img src="{{ asset('images/logo.png') }}" alt="SupplyCore" class="w-12 h-12 object-contain">
    </div>
    </div>

    <div class="text-center mb-8">
        <h2 class="text-3xl font-extrabold text-[#1e3a8a]">System Login</h2>
        <p class="text-gray-500 mt-2">Enter credentials to access inventory</p>
    </div>

    <form method="POST" action="{{ route('login') }}" class="space-y-6">
        @csrf
        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-1">Username</label>
            <input type="text" name="username" required
                class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-blue-500 shadow-sm">
        </div>

        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-1">Password</label>
            <input type="password" name="password" required
                class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-blue-500 shadow-sm">
        </div>

        <button type="submit"
            class="w-full bg-[#1e3a8a] text-white font-bold py-3.5 rounded-xl hover:bg-blue-800 shadow-lg transform transition active:scale-95">
            Login
        </button>

        <div class="text-center mt-6">
            <a href="{{ route('register') }}" class="text-blue-600 font-bold hover:underline">Request Account</a>
        </div>
    </form>
@endsection
@extends('layouts.app')

@section('content')
    <div class="space-y-6">
        <div class="bg-white p-8 rounded-3xl shadow-sm border border-gray-100 flex justify-between items-center">
            <div>
                <h1 class="text-3xl font-extrabold text-[#1e3a8a]">Welcome, {{ auth()->user()->username }}!</h1>
                <p class="text-gray-500 mt-1">Here's what's happening with the school supplies today.</p>
            </div>
            <div class="bg-blue-50 px-4 py-2 rounded-xl border border-blue-100 text-blue-700 font-bold text-sm">
                Role: {{ auth()->user()->role->role_name ?? 'Staff' }}
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
            <div class="bg-white p-6 rounded-3xl shadow-sm border border-gray-100 hover:shadow-md transition">
                <div class="text-blue-600 mb-4 bg-blue-50 w-12 h-12 flex items-center justify-center rounded-2xl text-2xl">
                    📦</div>
                <h3 class="text-gray-400 text-sm font-bold uppercase tracking-wider">Total Products</h3>
                <p class="text-3xl font-black text-gray-800">2,401</p>
            </div>

            <div class="bg-white p-6 rounded-3xl shadow-sm border border-gray-100 hover:shadow-md transition">
                <div class="text-red-600 mb-4 bg-red-50 w-12 h-12 flex items-center justify-center rounded-2xl text-2xl">⚠️
                </div>
                <h3 class="text-gray-400 text-sm font-bold uppercase tracking-wider">Low Stock</h3>
                <p class="text-3xl font-black text-red-600">14</p>
            </div>

            <div class="bg-white p-6 rounded-3xl shadow-sm border border-gray-100 hover:shadow-md transition">
                <div
                    class="text-green-600 mb-4 bg-green-50 w-12 h-12 flex items-center justify-center rounded-2xl text-2xl">
                    💰</div>
                <h3 class="text-gray-400 text-sm font-bold uppercase tracking-wider">Today's Sales</h3>
                <p class="text-3xl font-black text-gray-800">₱4,250</p>
            </div>

            <div class="bg-white p-6 rounded-3xl shadow-sm border border-gray-100 hover:shadow-md transition">
                <div
                    class="text-purple-600 mb-4 bg-purple-50 w-12 h-12 flex items-center justify-center rounded-2xl text-2xl">
                    👥</div>
                <h3 class="text-gray-400 text-sm font-bold uppercase tracking-wider">Active Users</h3>
                <p class="text-3xl font-black text-gray-800">5</p>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="bg-[#1e3a8a] p-8 rounded-3xl text-white shadow-xl flex flex-col justify-between">
                <div>
                    <h3 class="text-xl font-bold mb-2 text-blue-200">New Transaction</h3>
                    <p class="text-blue-100 opacity-80 mb-6">Quickly process a new sale for school supplies.</p>
                </div>
                <a href="{{ route('transactions.index') }}"
                    class="inline-block bg-white text-[#1e3a8a] text-center font-bold py-3 px-6 rounded-2xl hover:bg-blue-50 transition">
                    Start Selling
                </a>
            </div>

            <div class="bg-white p-8 rounded-3xl border border-gray-100 shadow-sm">
                <h3 class="text-xl font-bold mb-4 text-gray-800">System Activity</h3>
                <ul class="space-y-4">
                    <li class="flex items-center text-sm">
                        <span class="w-2 h-2 bg-green-500 rounded-full mr-3"></span>
                        <span class="text-gray-600 font-medium">New product "Mongol Pencil #2" added.</span>
                    </li>
                    <li class="flex items-center text-sm">
                        <span class="w-2 h-2 bg-blue-500 rounded-full mr-3"></span>
                        <span class="text-gray-600 font-medium font-bold italic">Admin processed a large inventory
                            update.</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>
@endsection
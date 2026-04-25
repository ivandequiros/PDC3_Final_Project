@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto">

    {{-- 1. ADMIN VIEW --}}
    @if(auth()->user()->role->role_name === 'Admin')
        <div class="mb-10">
            <h1 class="text-4xl font-black text-[#1e3a8a] tracking-tight">System Overview</h1>
            <p class="text-gray-400 font-bold uppercase text-[10px] tracking-widest mt-1">Global Analytics Control</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-10">
            <div class="bg-white p-8 rounded-[2.5rem] shadow-sm border border-gray-100">
                <p class="text-[10px] font-black text-gray-400 uppercase mb-2">Total Revenue</p>
                <p class="text-3xl font-black text-gray-800">₱{{ number_format($stats['total_revenue'], 2) }}</p>
            </div>
            <div class="bg-white p-8 rounded-[2.5rem] shadow-sm border border-gray-100">
                <p class="text-[10px] font-black text-gray-400 uppercase mb-2">Staff Members</p>
                <p class="text-3xl font-black text-blue-600">{{ $stats['staff_count'] }}</p>
            </div>
            <div class="bg-white p-8 rounded-[2.5rem] shadow-sm border border-gray-100">
                <p class="text-[10px] font-black text-gray-400 uppercase mb-2">Total Products</p>
                <p class="text-3xl font-black text-gray-800">{{ $stats['total_products'] }}</p>
            </div>
            <div class="bg-white p-8 rounded-[2.5rem] shadow-sm border border-gray-100 {{ $stats['low_stock'] > 0 ? 'border-red-100' : '' }}">
                <p class="text-[10px] font-black text-gray-400 uppercase mb-2">Stock Alerts</p>
                <p class="text-3xl font-black {{ $stats['low_stock'] > 0 ? 'text-red-500' : 'text-green-500' }}">{{ $stats['low_stock'] }}</p>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <div class="lg:col-span-2 bg-white p-10 rounded-[3rem] shadow-sm border border-gray-100 min-h-[400px]">
                <canvas id="revenueChart"></canvas>
            </div>
            <div class="bg-[#1e3a8a] p-10 rounded-[3rem] shadow-2xl text-white relative overflow-hidden">
                <h3 class="font-black uppercase text-xs tracking-widest mb-8">Recent Activity</h3>
                <div class="space-y-6">
                    @foreach($stats['recent_logs'] as $log)
                    <div class="flex gap-4 border-l-2 border-blue-400/30 pl-4 py-1">
                        <div class="flex-1">
                            <p class="text-xs font-bold">{{ $log->action }}</p>
                            <p class="text-[9px] text-blue-300 uppercase mt-1">{{ $log->created_at->diffForHumans() }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

    {{-- 2. MANAGER VIEW --}}
    @elseif(auth()->user()->role->role_name === 'Manager')
        <div class="mb-10">
            <h1 class="text-4xl font-black text-[#1e3a8a] tracking-tight">Warehouse Logistics</h1>
            <p class="text-gray-400 font-bold uppercase text-[10px] tracking-widest mt-1">Inventory Management & Supply Chain</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-10">
            <div class="bg-white p-8 rounded-[2.5rem] shadow-sm border border-gray-100">
                <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Total Stock Value</p>
                <p class="text-3xl font-black text-gray-800">₱{{ number_format($stats['total_inventory_value'], 2) }}</p>
            </div>
            <div class="bg-red-50 p-8 rounded-[2.5rem] border border-red-100">
                <p class="text-[10px] font-black text-red-600 uppercase tracking-widest mb-2">Out of Stock</p>
                <p class="text-3xl font-black text-red-700">{{ $stats['out_of_stock_count'] }}</p>
            </div>
            <div class="bg-amber-50 p-8 rounded-[2.5rem] border border-amber-100">
                <p class="text-[10px] font-black text-amber-600 uppercase tracking-widest mb-2">Low Stock Alerts</p>
                <p class="text-3xl font-black text-amber-700">{{ $stats['low_stock_count'] }}</p>
            </div>
            <div class="bg-white p-8 rounded-[2.5rem] shadow-sm border border-gray-100">
                <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Active Suppliers</p>
                <p class="text-3xl font-black text-blue-600">{{ $stats['total_suppliers'] }}</p>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <div class="lg:col-span-1 space-y-6">
                <div class="bg-[#1e3a8a] p-8 rounded-[3rem] text-white shadow-xl">
                    <h3 class="font-black uppercase text-xs tracking-[0.2em] mb-6">Manager Tools</h3>
                    <div class="space-y-4">
                        <a href="{{ route('products.create') }}" class="flex items-center justify-between bg-white/10 p-4 rounded-2xl hover:bg-white/20 transition">
                            <span class="font-bold text-sm">Add New Product</span>
                            <span>📦</span>
                        </a>
                        <a href="{{ route('categories.index') }}" class="flex items-center justify-between bg-white/10 p-4 rounded-2xl hover:bg-white/20 transition">
                            <span class="font-bold text-sm">Manage Categories</span>
                            <span>🏷️</span>
                        </a>
                    </div>
                </div>
            </div>

            <div class="lg:col-span-2 bg-white p-10 rounded-[3rem] shadow-sm border border-gray-100">
                <h3 class="font-black text-gray-800 uppercase text-xs tracking-widest mb-8">Stock Movement History</h3>
                <div class="space-y-6">
                    @forelse($stats['recent_stock_changes'] as $log)
                    <div class="flex items-center justify-between py-4 border-b border-gray-50 last:border-0">
                        <div class="flex items-center gap-4">
                            <div class="w-2 h-2 rounded-full bg-blue-500"></div>
                            <div>
                                <p class="text-sm font-bold text-gray-800">{{ $log->action }}</p>
                                <p class="text-[10px] text-gray-400 uppercase font-black">{{ $log->created_at->diffForHumans() }}</p>
                            </div>
                        </div>
                    </div>
                    @empty
                    <p class="text-gray-400 italic text-sm">No recent stock movements recorded.</p>
                    @endforelse
                </div>
            </div>
        </div>

    {{-- ---------------- CASHIER DASHBOARD VIEW ---------------- --}}
@else
    <div class="mb-10">
        <h1 class="text-4xl font-black text-[#1e3a8a] tracking-tight">Daily Shift</h1>
        <p class="text-gray-400 font-bold uppercase text-[10px] tracking-widest mt-1">Terminal Session: {{ auth()->user()->username }}</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">
        
        <div class="lg:col-span-2 space-y-8">
            
            <div class="bg-gradient-to-br from-[#1e3a8a] to-blue-700 p-12 rounded-[3.5rem] text-white shadow-2xl relative overflow-hidden h-80 flex flex-col justify-center">
                <div class="relative z-10">
                    <h2 class="text-5xl font-black mb-4 tracking-tighter">Start Selling!</h2>
                    <p class="text-blue-100 mb-8 max-w-sm opacity-80 font-medium">Quickly process transactions, manage carts, and generate customer receipts.</p>
                    <a href="{{ route('pos.index') }}" class="inline-block bg-white text-[#1e3a8a] px-10 py-5 rounded-[2rem] font-black shadow-xl hover:scale-105 transition transform active:scale-95 text-xs uppercase tracking-widest">
                        OPEN POS TERMINAL ➔
                    </a>
                </div>
                <span class="absolute -right-10 -bottom-10 text-[18rem] opacity-10 rotate-12 pointer-events-none">🛍️</span>
            </div>

            <div class="grid grid-cols-2 gap-8">
                <div class="bg-white p-10 rounded-[3rem] border border-gray-100 shadow-sm transition hover:shadow-md">
                    <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-3">My Sales Today</p>
                    <p class="text-4xl font-black text-[#1e3a8a]">₱{{ number_format($stats['my_sales_today'], 2) }}</p>
                </div>
                <div class="bg-white p-10 rounded-[3rem] border border-gray-100 shadow-sm transition hover:shadow-md">
                    <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-3">Transactions Made</p>
                    <p class="text-4xl font-black text-blue-600">{{ $stats['my_transaction_count'] }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white p-10 rounded-[3.5rem] border border-gray-100 shadow-sm min-h-[600px] flex flex-col">
            <h3 class="font-black text-gray-800 uppercase text-xs tracking-widest mb-8 border-b border-gray-50 pb-4">My Recent Sales</h3>
            
            <div class="space-y-4 flex-1">
                @forelse($stats['my_recent_transactions'] as $trx)
                <div class="flex items-center justify-between p-5 bg-gray-50 rounded-[2rem] border border-transparent hover:border-blue-100 hover:bg-white transition group">
                    <div class="flex items-center gap-4">
                        <div class="w-10 h-10 bg-white rounded-xl flex items-center justify-center shadow-sm text-lg group-hover:scale-110 transition">🧾</div>
                        <div>
                            <p class="font-black text-gray-800 text-xs tracking-tight">TRX-{{ str_pad($trx->id, 5, '0', STR_PAD_LEFT) }}</p>
                            <p class="text-[9px] text-gray-400 uppercase font-black tracking-tighter">{{ $trx->created_at->format('h:i A') }}</p>
                        </div>
                    </div>
                    <p class="font-black text-blue-600 text-sm">₱{{ number_format($trx->total_amount, 2) }}</p>
                </div>
                @empty
                <div class="h-full flex flex-col items-center justify-center opacity-20">
                    <span class="text-6xl mb-4">📭</span>
                    <p class="font-bold italic text-sm text-gray-500">No sales yet</p>
                </div>
                @endforelse
            </div>

            <div class="mt-8 pt-6 border-t border-gray-50">
                <a href="{{ route('transactions.index') }}" class="flex items-center justify-between group">
                    <span class="text-[10px] font-black text-blue-600 uppercase tracking-widest">Full History</span>
                    <span class="group-hover:translate-x-2 transition">➔</span>
                </a>
            </div>
        </div>
    </div>
@endif
</div>

{{-- Admin Chart Script --}}
@if(auth()->user()->role->role_name === 'Admin')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('revenueChart');
            if (ctx) {
                new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
                        datasets: [{
                            label: 'Revenue',
                            data: [1200, 1900, 3000, 2500, 2000, 2300, 3500],
                            borderColor: '#2563eb',
                            backgroundColor: 'rgba(37, 99, 235, 0.1)',
                            borderWidth: 4,
                            tension: 0.4,
                            fill: true
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: { legend: { display: false } }
                    }
                });
            }
        });
    </script>
@endif
@endsection
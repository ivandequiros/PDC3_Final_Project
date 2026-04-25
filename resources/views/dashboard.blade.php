@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto">

    {{-- ---------------- 1. ADMIN DASHBOARD VIEW ---------------- --}}
    @if(auth()->user()->role->role_name === 'Admin')
        <div class="mb-10 text-center md:text-left">
            <h1 class="text-4xl font-black text-[#1e3a8a] tracking-tight uppercase italic">System <span class="text-blue-500">Overview</span></h1>
            <p class="text-gray-400 font-bold uppercase text-[10px] tracking-[0.2em] mt-1">Global Analytics Control Center</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-10">
            <div class="bg-white p-8 rounded-[2.5rem] shadow-sm border border-gray-100">
                <p class="text-[10px] font-black text-gray-400 uppercase mb-2 tracking-widest">Total Revenue</p>
                <p class="text-3xl font-black text-gray-800 tracking-tighter">₱{{ number_format($stats['total_revenue'], 2) }}</p>
            </div>
            <div class="bg-white p-8 rounded-[2.5rem] shadow-sm border border-gray-100">
                <p class="text-[10px] font-black text-gray-400 uppercase mb-2 tracking-widest">Staff Members</p>
                <p class="text-3xl font-black text-blue-600 tracking-tighter">{{ $stats['staff_count'] }}</p>
            </div>
            <div class="bg-white p-8 rounded-[2.5rem] shadow-sm border border-gray-100">
                <p class="text-[10px] font-black text-gray-400 uppercase mb-2 tracking-widest">Total Products</p>
                <p class="text-3xl font-black text-gray-800 tracking-tighter">{{ $stats['total_products'] }}</p>
            </div>
            <div class="bg-white p-8 rounded-[2.5rem] shadow-sm border border-gray-100 {{ $stats['low_stock'] > 0 ? 'border-red-100 ring-2 ring-red-50' : '' }}">
                <p class="text-[10px] font-black text-gray-400 uppercase mb-2 tracking-widest">Stock Alerts</p>
                <p class="text-3xl font-black {{ $stats['low_stock'] > 0 ? 'text-red-500' : 'text-green-500' }} tracking-tighter">{{ $stats['low_stock'] }}</p>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <div class="lg:col-span-2 bg-white p-10 rounded-[3rem] shadow-sm border border-gray-100">
                <canvas id="revenueChart" height="150"></canvas>
            </div>
            <div class="bg-[#1e3a8a] p-10 rounded-[3rem] shadow-2xl text-white relative overflow-hidden">
                <h3 class="font-black uppercase text-xs tracking-widest mb-8">System Audit Logs</h3>
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

    {{-- ---------------- 2. MANAGER DASHBOARD VIEW ---------------- --}}
    @elseif(auth()->user()->role->role_name === 'Manager')
        <div class="mb-10 text-center md:text-left">
            <h1 class="text-4xl font-black text-[#1e3a8a] tracking-tight uppercase italic">Warehouse <span class="text-blue-500">Logistics</span></h1>
            <p class="text-gray-400 font-bold uppercase text-[10px] tracking-[0.2em] mt-1">Supply Chain & Inventory Status</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-10 text-center md:text-left">
            <div class="bg-white p-8 rounded-[2.5rem] border border-gray-100 shadow-sm">
                <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Inventory Value</p>
                <p class="text-3xl font-black text-gray-800">₱{{ number_format($stats['total_inventory_value'], 2) }}</p>
            </div>
            <div class="bg-red-50 p-8 rounded-[2.5rem] border border-red-100">
                <p class="text-[10px] font-black text-red-600 uppercase mb-2 tracking-widest">Critical Out</p>
                <p class="text-3xl font-black text-red-700">{{ $stats['out_of_stock_count'] }}</p>
            </div>
            <div class="bg-amber-50 p-8 rounded-[2.5rem] border border-amber-100">
                <p class="text-[10px] font-black text-amber-600 uppercase mb-2 tracking-widest">Low Stock</p>
                <p class="text-3xl font-black text-amber-700">{{ $stats['low_stock_count'] }}</p>
            </div>
            <div class="bg-white p-8 rounded-[2.5rem] border border-gray-100 shadow-sm">
                <p class="text-[10px] font-black text-gray-400 uppercase mb-2 tracking-widest">Total Suppliers</p>
                <p class="text-3xl font-black text-blue-600">{{ $stats['total_suppliers'] }}</p>
            </div>
        </div>

        {{-- POS Button for Managers --}}
        <div class="bg-gradient-to-r from-[#1e3a8a] to-blue-800 p-10 rounded-[3rem] text-white flex flex-col md:flex-row justify-between items-center shadow-2xl">
            <div class="mb-6 md:mb-0">
                <h2 class="text-2xl font-black uppercase italic tracking-tight">Need to process a sale?</h2>
                <p class="text-blue-200 text-xs font-bold uppercase tracking-widest mt-1">Terminal access is authorized for Manager roles.</p>
            </div>
            <a href="{{ route('pos.index') }}" class="bg-white text-[#1e3a8a] px-10 py-5 rounded-2xl font-black shadow-xl hover:scale-105 transition transform text-[10px] uppercase tracking-widest">
                Open POS Terminal ➔
            </a>
        </div>

    {{-- ---------------- 3. CASHIER DASHBOARD VIEW ---------------- --}}
    @else
        <div class="mb-10 text-center md:text-left">
            <h1 class="text-4xl font-black text-[#1e3a8a] tracking-tight uppercase italic">Daily <span class="text-blue-500">Shift</span></h1>
            <p class="text-gray-400 font-bold uppercase text-[10px] tracking-[0.2em] mt-1">Session: {{ auth()->user()->username }}</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <div class="lg:col-span-2 space-y-8">
                <div class="bg-gradient-to-br from-[#1e3a8a] to-blue-700 p-12 rounded-[3.5rem] text-white shadow-2xl relative overflow-hidden group">
                    <div class="relative z-10">
                        <h2 class="text-4xl font-black mb-4 uppercase italic">Start Selling!</h2>
                        <p class="text-blue-100 mb-8 max-w-sm opacity-80 font-bold uppercase text-[10px] tracking-widest">Process school supplies and generate customer receipts instantly.</p>
                        <a href="{{ route('pos.index') }}" class="inline-block bg-white text-[#1e3a8a] px-10 py-5 rounded-[2rem] font-black shadow-xl hover:scale-105 transition transform text-[10px] uppercase tracking-widest">
                            OPEN POS TERMINAL ➔
                        </a>
                    </div>
                    <span class="absolute -right-10 -bottom-10 text-[15rem] opacity-10 rotate-12 transition group-hover:rotate-0 duration-700">🏬</span>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="bg-white p-10 rounded-[3rem] border border-gray-100 shadow-sm text-center">
                        <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">My Sales Today</p>
                        <p class="text-4xl font-black text-[#1e3a8a]">₱{{ number_format($stats['my_sales_today'], 2) }}</p>
                    </div>
                    <div class="bg-white p-10 rounded-[3rem] border border-gray-100 shadow-sm text-center">
                        <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Transaction Count</p>
                        <p class="text-4xl font-black text-blue-600">{{ $stats['my_transaction_count'] }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white p-10 rounded-[3.5rem] border border-gray-100 shadow-sm">
                <h3 class="font-black text-gray-800 uppercase text-xs tracking-widest mb-8 text-center">Recent History</h3>
                <div class="space-y-6">
                    @forelse($stats['my_recent_transactions'] as $trx)
                    <div class="flex items-center justify-between p-4 bg-gray-50 rounded-2xl">
                        <div>
                            <p class="font-black text-gray-800 text-xs tracking-tight">TRX-{{ $trx->id }}</p>
                            <p class="text-[9px] text-gray-400 uppercase font-black">{{ $trx->created_at->format('h:i A') }}</p>
                        </div>
                        <p class="font-black text-blue-600 text-sm">₱{{ number_format($trx->total_amount, 2) }}</p>
                    </div>
                    @empty
                    <p class="text-center text-gray-300 py-10 italic text-sm font-bold uppercase tracking-widest">No Sales Found</p>
                    @endforelse
                </div>
            </div>
        </div>
    @endif

    {{-- CHART SCRIPT FOR ADMIN --}}
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
                            label: 'Daily Revenue',
                            data: [1200, 1900, 3000, 2500, 2000, 2300, 3500],
                            borderColor: '#1e3a8a',
                            backgroundColor: 'rgba(30, 58, 138, 0.05)',
                            borderWidth: 5,
                            pointBackgroundColor: '#1e3a8a',
                            tension: 0.45,
                            fill: true
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: { 
                            legend: { display: false },
                            title: {
                                display: true,
                                text: 'WEEKLY PERFORMANCE',
                                color: '#94a3b8',
                                font: { size: 10, weight: '900' }
                            }
                        }
                    }
                });
            }
        });
    </script>
    @endif
</div>
@endsection
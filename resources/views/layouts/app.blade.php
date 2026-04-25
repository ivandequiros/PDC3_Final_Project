<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>SupplyCore — Inventory Management</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Instrument+Sans:ital,wght@0,400..700;1,400..700&display=swap" rel="stylesheet">
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 font-sans flex min-h-screen">

    <aside class="w-72 bg-[#1e3a8a] text-white flex-shrink-0 shadow-2xl flex flex-col sticky top-0 h-screen">
        {{-- Updated Logo Section: items-center and gap-3 for perfect alignment --}}
        <div class="p-8 flex items-center gap-3">
            {{-- 
                h-9: Adjusted to be slightly larger than text-2xl for better balance.
                w-auto: Maintains aspect ratio.
                flex-shrink-0: Prevents the image from being squished.
            --}}
            <img src="{{ asset('images/logo.png') }}" 
                 alt="SupplyCore Logo" 
                 class="h-9 w-auto object-contain bg-transparent flex-shrink-0">
            
            <h1 class="text-2xl font-black tracking-tighter italic text-white uppercase select-none leading-none">
                SUPPLY<span class="text-blue-400">CORE</span>
            </h1>
        </div>
        <nav class="flex-1 px-6 space-y-2 overflow-y-auto custom-scrollbar">
            <a href="{{ route('dashboard') }}" class="flex items-center p-4 rounded-2xl hover:bg-white/10 transition {{ request()->routeIs('dashboard') ? 'bg-white/10 font-bold' : '' }}">
                <span class="mr-3 text-lg">📊</span> Dashboard
            </a>

            {{-- 1. ADMINISTRATION SECTION --}}
            @if(auth()->user()->role->role_name === 'Admin')
                <div class="pt-6 pb-2 px-4">
                    <p class="text-[10px] font-black text-blue-300 uppercase tracking-widest opacity-50">Administration</p>
                </div>
                <a href="{{ route('users.index') }}" class="flex items-center p-4 rounded-2xl hover:bg-white/10 transition {{ request()->is('users*') ? 'bg-white/10 font-bold' : '' }}">
                    <span class="mr-3 text-lg">👥</span> Staff Accounts
                </a>
                <a href="{{ route('roles.index') }}" class="flex items-center p-4 rounded-2xl hover:bg-white/10 transition {{ request()->is('roles*') ? 'bg-white/10 font-bold' : '' }}">
                    <span class="mr-3 text-lg">🔐</span> Permissions
                </a>
                <a href="{{ route('logs.index') }}" class="flex items-center p-4 rounded-2xl hover:bg-white/10 transition {{ request()->is('logs*') ? 'bg-white/10 font-bold' : '' }}">
                    <span class="mr-3 text-lg">📜</span> System Logs
                </a>
            @endif

            {{-- 2. SUPPLY CHAIN SECTION --}}
            @if(in_array(auth()->user()->role->role_name, ['Admin', 'Manager']))
                <div class="pt-6 pb-2 px-4">
                    <p class="text-[10px] font-black text-blue-300 uppercase tracking-widest opacity-50">Supply Chain</p>
                </div>
                <a href="{{ route('products.index') }}" class="flex items-center p-4 rounded-2xl hover:bg-white/10 transition {{ request()->is('products*') ? 'bg-white/10 font-bold' : '' }}">
                    <span class="mr-3 text-lg">📦</span> All Products
                </a>
                <a href="{{ route('categories.index') }}" class="flex items-center p-4 rounded-2xl hover:bg-white/10 transition {{ request()->is('categories*') ? 'bg-white/10 font-bold' : '' }}">
                    <span class="mr-3 text-lg">🏷️</span> Categories
                </a>
                <a href="{{ route('low_stock_alerts.index') }}" class="flex items-center p-4 rounded-2xl hover:bg-white/10 transition {{ request()->is('low_stock_alerts*') ? 'bg-white/10 font-bold' : '' }}">
                    <span class="mr-3 text-lg">⚠️</span> Stock Alerts
                </a>
            @endif

            {{-- 3. FINANCE SECTION --}}
            <div class="pt-6 pb-2 px-4">
                <p class="text-[10px] font-black text-blue-300 uppercase tracking-widest opacity-50">Finance</p>
            </div>
            @if(in_array(auth()->user()->role->role_name, ['Admin', 'Cashier']))
                <a href="{{ route('pos.index') }}" class="flex items-center p-4 rounded-2xl bg-blue-500/20 border border-blue-400/30 hover:bg-blue-500/40 transition {{ request()->is('pos*') ? 'bg-blue-500/40 font-bold' : '' }}">
                    <span class="mr-3 text-lg">🏪</span> POS Terminal
                </a>
            @endif
            <a href="{{ route('transactions.index') }}" class="flex items-center p-4 rounded-2xl hover:bg-white/10 transition {{ request()->is('transactions*') ? 'bg-white/10 font-bold' : '' }}">
                <span class="mr-3 text-lg">🧾</span> Sales History
            </a>
        </nav>

       <div class="p-6 border-t border-white/10 bg-[#1a337a]">
    <div class="flex items-center mb-4">
        <div class="w-10 h-10 rounded-full bg-blue-400 flex items-center justify-center font-bold mr-3 shadow-inner text-white">
            {{ strtoupper(substr(auth()->user()->username, 0, 1)) }}
        </div>
        <div class="overflow-hidden">
            <p class="text-xs font-bold truncate text-white">{{ auth()->user()->username }}</p>
            <p class="text-[9px] text-blue-300 uppercase font-black tracking-widest">{{ auth()->user()->role->role_name }}</p>
        </div>
    </div>

    <form action="{{ route('logout') }}" method="POST" id="logout-form">
        @csrf {{-- CRITICAL: Without this, you get the 419 error --}}
        <button type="submit" class="w-full text-left text-[10px] text-red-300 hover:text-red-100 font-black uppercase tracking-widest transition flex items-center group">
            <span class="mr-2 group-hover:scale-125 transition">🚪</span> 
            Logout Account
        </button>
    </form>
</div>
    </aside>

    <main class="flex-1 p-10 h-screen overflow-y-auto custom-scrollbar">
        @yield('content')
    </main>

</body>
</html>
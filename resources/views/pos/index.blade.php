@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto h-[calc(100vh-120px)] flex flex-col">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-3xl font-black text-[#1e3a8a]">Point of Sale</h1>
            <p class="text-gray-500 text-sm">Select products to build a customer transaction.</p>
        </div>
        <div id="clock" class="text-right font-mono font-bold text-gray-400 text-xl"></div>
    </div>

    <div class="flex flex-1 gap-6 overflow-hidden pb-4">
        <div class="flex-1 bg-white rounded-[2.5rem] border border-gray-100 shadow-sm flex flex-col overflow-hidden">
            <div class="p-6 border-b border-gray-50">
                <input type="text" id="productSearch" placeholder="Search product name..." 
                    class="w-full px-5 py-4 rounded-2xl bg-gray-50 border-none focus:ring-4 focus:ring-blue-100 transition">
            </div>
            
            <div class="flex-1 overflow-y-auto p-6 grid grid-cols-2 lg:grid-cols-3 gap-4" id="productGrid">
                @foreach($products as $product)
                <button onclick="addToCart({{ $product->id }}, '{{ $product->name }}', {{ $product->current_price }}, {{ $product->stock_level }})"
                    class="group p-4 bg-gray-50 rounded-3xl border border-transparent hover:border-blue-300 hover:bg-white hover:shadow-md transition text-left relative overflow-hidden">
                    <div class="mb-3 text-2xl">📦</div>
                    <h3 class="font-bold text-gray-800 text-sm leading-tight mb-1">{{ $product->name }}</h3>
                    <p class="text-blue-600 font-black">₱{{ number_format($product->current_price, 2) }}</p>
                    <span class="text-[10px] uppercase font-bold text-gray-400 mt-2 block">Stock: {{ $product->stock_level }}</span>
                    
                    <div class="absolute bottom-0 right-0 p-2 bg-blue-600 text-white rounded-tl-2xl opacity-0 group-hover:opacity-100 transition">
                        <span class="text-xs font-bold">+ ADD</span>
                    </div>
                </button>
                @endforeach
            </div>
        </div>

        <div class="w-96 bg-white rounded-[2.5rem] border border-gray-100 shadow-xl flex flex-col overflow-hidden">
            <div class="p-6 bg-[#1e3a8a] text-white">
                <h2 class="text-lg font-black uppercase tracking-widest text-center">Checkout Cart</h2>
            </div>

            <div class="flex-1 overflow-y-auto p-6 space-y-4" id="cartItems">
                <div id="emptyCart" class="h-full flex flex-col items-center justify-center text-gray-300 italic py-20">
                    <span class="text-5xl mb-4">🛒</span>
                    <p>Ready to sell!</p>
                </div>
            </div>

            <div class="p-8 bg-gray-50 border-t border-gray-100 space-y-4">
                <div class="flex justify-between text-gray-500 font-bold uppercase text-xs">
                    <span>Subtotal</span>
                    <span id="subtotal">₱0.00</span>
                </div>
                <div class="flex justify-between text-[#1e3a8a] font-black text-2xl">
                    <span>Total</span>
                    <span id="totalDisplay">₱0.00</span>
                </div>

                <form action="{{ route('pos.checkout') }}" method="POST" id="checkoutForm">
                    @csrf
                    <div id="hiddenInputs"></div>
                    <button type="button" onclick="submitCheckout()" id="checkoutBtn" disabled
                        class="w-full py-5 bg-blue-600 text-white rounded-2xl font-black shadow-lg hover:bg-blue-700 disabled:bg-gray-200 disabled:cursor-not-allowed transition transform active:scale-95 mt-4">
                        COMPLETE SALE
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    let cart = [];

    function addToCart(id, name, price, stock) {
        const existing = cart.find(item => item.id === id);
        if (existing) {
            if (existing.qty < stock) {
                existing.qty++;
            } else {
                alert('Out of stock!');
            }
        } else {
            cart.push({ id, name, price, qty: 1, stock });
        }
        renderCart();
    }

    function updateQty(id, delta) {
        const item = cart.find(i => i.id === id);
        if (item) {
            item.qty += delta;
            if (item.qty <= 0) {
                cart = cart.filter(i => i.id !== id);
            } else if (item.qty > item.stock) {
                item.qty = item.stock;
                alert('Stock limit reached');
            }
        }
        renderCart();
    }

    function renderCart() {
        const container = document.getElementById('cartItems');
        const emptyMsg = document.getElementById('emptyCart');
        const hiddenInputs = document.getElementById('hiddenInputs');
        const checkoutBtn = document.getElementById('checkoutBtn');
        
        container.innerHTML = '';
        hiddenInputs.innerHTML = '';
        
        if (cart.length === 0) {
            container.appendChild(emptyMsg);
            checkoutBtn.disabled = true;
            document.getElementById('subtotal').innerText = `₱0.00`;
            document.getElementById('totalDisplay').innerText = `₱0.00`;
        } else {
            checkoutBtn.disabled = false;
            let total = 0;
            
            cart.forEach((item, index) => {
                total += item.price * item.qty;
                
                const row = document.createElement('div');
                row.className = 'flex justify-between items-center bg-gray-50 p-4 rounded-2xl animate-fade-in';
                row.innerHTML = `
                    <div class="flex-1 pr-2">
                        <h4 class="font-bold text-gray-800 text-xs truncate">${item.name}</h4>
                        <p class="text-[10px] text-blue-600 font-black">₱${(item.price * item.qty).toFixed(2)}</p>
                    </div>
                    <div class="flex items-center gap-2">
                        <button onclick="updateQty(${item.id}, -1)" class="w-6 h-6 rounded-lg bg-white shadow-sm flex items-center justify-center font-bold text-red-500 hover:bg-red-50">-</button>
                        <span class="font-black text-xs w-4 text-center">${item.qty}</span>
                        <button onclick="updateQty(${item.id}, 1)" class="w-6 h-6 rounded-lg bg-white shadow-sm flex items-center justify-center font-bold text-green-500 hover:bg-green-50">+</button>
                    </div>
                `;
                container.appendChild(row);

                hiddenInputs.innerHTML += `
                    <input type="hidden" name="items[${index}][id]" value="${item.id}">
                    <input type="hidden" name="items[${index}][qty]" value="${item.qty}">
                `;
            });

            document.getElementById('subtotal').innerText = `₱${total.toFixed(2)}`;
            document.getElementById('totalDisplay').innerText = `₱${total.toFixed(2)}`;
        }
    }

    function submitCheckout() {
        if(confirm('Proceed with this sale?')) {
            document.getElementById('checkoutForm').submit();
        }
    }

    setInterval(() => {
        const now = new Date();
        document.getElementById('clock').innerText = now.toLocaleTimeString();
    }, 1000);

    document.getElementById('productSearch').addEventListener('input', function(e) {
        const term = e.target.value.toLowerCase();
        document.querySelectorAll('#productGrid button').forEach(btn => {
            const name = btn.querySelector('h3').innerText.toLowerCase();
            btn.style.display = name.includes(term) ? 'block' : 'none';
        });
    });
</script>
@endsection
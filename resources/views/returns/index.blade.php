@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto">
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-3xl font-black text-[#1e3a8a]">Return Logs</h1>
            <p class="text-gray-500">Track all items returned to inventory.</p>
        </div>
        <a href="{{ route('returns.create') }}" class="bg-[#1e3a8a] text-white px-6 py-3 rounded-2xl font-bold transition shadow-lg hover:bg-blue-800">
            + New Return
        </a>
    </div>

    <div class="bg-white rounded-[2rem] shadow-sm border border-gray-100 overflow-hidden">
        <table class="w-full text-left">
            <thead class="bg-gray-50 border-b border-gray-100">
                <tr>
                    <th class="px-8 py-5 text-[10px] uppercase font-black text-gray-400">Date</th>
                    <th class="px-8 py-5 text-[10px] uppercase font-black text-gray-400">Original TRX</th>
                    <th class="px-8 py-5 text-[10px] uppercase font-black text-gray-400">Item</th>
                    <th class="px-8 py-5 text-[10px] uppercase font-black text-gray-400">Qty</th>
                    <th class="px-8 py-5 text-[10px] uppercase font-black text-gray-400">Reason</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @foreach($returns as $ret)
                <tr>
                    <td class="px-8 py-5 text-sm text-gray-500">{{ $ret->created_at->format('M d, Y') }}</td>
                    <td class="px-8 py-5 font-mono text-blue-600">TRX-{{ $ret->transaction_id }}</td>
                    <td class="px-8 py-5 font-bold">{{ $ret->product->name }}</td>
                    <td class="px-8 py-5 text-red-600 font-bold">+{{ $ret->quantity }}</td>
                    <td class="px-8 py-5 italic text-gray-400 text-sm">{{ $ret->reason }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
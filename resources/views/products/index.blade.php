@extends('layouts.app')

@section('content')
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-gray-800">Product List</h2>
        <button class="bg-green-600 text-white px-4 py-2 rounded font-bold">+ Add Product</button>
    </div>

    <table class="w-full bg-white shadow rounded-lg overflow-hidden">
        <thead class="bg-gray-50 border-b">
            <tr>
                <th class="p-4 text-left">Item Name</th>
                <th class="p-4 text-left">Stock</th>
                <th class="p-4 text-left">Price</th>
            </tr>
        </thead>
        <tbody>
            <tr class="border-b">
                <td class="p-4 font-medium italic text-gray-400 text-sm">(UI Preview: Mongol Pencil)</td>
                <td class="p-4 text-gray-400">100</td>
                <td class="p-4 text-gray-400">₱8.00</td>
            </tr>
        </tbody>
    </table>
@endsection
@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto">
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-3xl font-black text-[#1e3a8a]">System Audit Logs</h1>
            <p class="text-gray-500">A permanent chronological record of all staff activities.</p>
        </div>
        
        <form action="{{ route('logs.index') }}" method="POST" onsubmit="return confirm('Security Warning: This will permanently delete all audit trails. Proceed?')">
            @csrf
            @method('DELETE')
            <button class="text-red-500 font-bold text-sm hover:bg-red-50 px-4 py-2 rounded-xl transition">
                🗑️ Clear History
            </button>
        </form>
    </div>

    <div class="bg-white rounded-[2rem] shadow-sm border border-gray-100 overflow-hidden">
        <table class="w-full text-left">
            <thead class="bg-gray-50 border-b border-gray-100">
                <tr>
                    <th class="px-8 py-5 text-[10px] uppercase font-black text-gray-400 tracking-widest">Timestamp</th>
                    <th class="px-8 py-5 text-[10px] uppercase font-black text-gray-400 tracking-widest">Personnel</th>
                    <th class="px-8 py-5 text-[10px] uppercase font-black text-gray-400 tracking-widest">Action Performed</th>
                    <th class="px-8 py-5 text-[10px] uppercase font-black text-gray-400 tracking-widest">Status</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse($logs as $log)
                <tr class="hover:bg-gray-50/50 transition">
                    <td class="px-8 py-5 text-gray-400 font-mono text-xs">
                        {{ $log->created_at->format('M d, Y • h:i A') }}
                    </td>
                    <td class="px-8 py-5">
                        <div class="flex items-center">
                            <div class="w-8 h-8 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center font-bold text-xs mr-3">
                                {{ strtoupper(substr($log->user->username ?? 'S', 0, 1)) }}
                            </div>
                            <span class="font-bold text-gray-800">{{ $log->user->username ?? 'System' }}</span>
                        </div>
                    </td>
                    <td class="px-8 py-5 text-sm text-gray-600 italic">
                        "{{ $log->action }}"
                    </td>
                    <td class="px-8 py-5">
                        <span class="bg-green-100 text-green-700 text-[10px] font-black uppercase px-2 py-1 rounded">
                            Verified
                        </span>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="px-8 py-20 text-center text-gray-400 italic">
                        No activity recorded yet. Start using the system to generate logs.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
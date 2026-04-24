<div class="p-4 border-t border-blue-900">
    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit"
            class="w-full flex items-center py-2 px-4 text-sm text-blue-300 hover:text-white transition">
            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-6 0v-1m6-10V7a3 3 0 00-6 0v1"></path>
            </svg>
            Logout Session
        </button>
    </form>
</div>

<div class="p-4 border-t border-blue-900 mt-auto">
    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" class="w-full text-left py-2 px-4 text-sm text-blue-300 hover:text-white transition">
            Logout ({{ auth()->user()->username }})
        </button>
    </form>
</div>
<header>
    <div class="flex items-center justify-between border-b border-gray-200 bg-white px-6 py-4 shadow">
        <!-- Brand Logo -->
        <div class="flex items-center">
            {{-- <img src="{{ asset('images/logo.png') }}" alt="Brand Logo" class="h-8 w-auto"> --}}
            <span class="ml-2 text-xl font-bold text-gray-800">Dika POS</span>
        </div>

        <!-- Mobile Menu Button -->
        <div class="block lg:hidden" x-data="{ open: false }">
            <button @click="open = !open" class="flex items-center px-3 py-2 text-gray-700 hover:text-blue-600">
                <i class="fas fa-bars text-xl"></i>
            </button>

            <!-- Mobile Menu -->
            <div x-show="open" @click.away="open = false"
                class="absolute left-0 right-0 top-16 z-50 mt-2 bg-white py-2 shadow-lg lg:hidden">
                <a href="{{ route('dashboard') }}" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">
                    <i class="fas fa-border-all mr-2"></i>Dashboard
                </a>
                <a href="{{ route('order') }}" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">
                    <i class="fas fa-clipboard-list mr-2"></i>Order List
                </a>
                <a href="@{{ route('history') }}" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">
                    <i class="fas fa-history mr-2"></i>History
                </a>
                <a href="{{ route('kitchen') }}" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">
                    <i class="fas fa-utensils mr-2"></i>Kitchen
                </a>
            </div>
        </div>

        <!-- Navigation Links (Desktop) -->
        <div class="hidden items-center space-x-6 lg:flex">
            <a href="{{ route('dashboard') }}" class="flex items-center font-medium text-gray-700 hover:text-blue-600">
                <i class="fas fa-border-all mr-2"></i>Dashboard
            </a>
            <a href="{{ route('order') }}" class="flex items-center font-medium text-gray-700 hover:text-blue-600">
                <i class="fas fa-clipboard-list mr-2"></i>Order List
            </a>
            <a href="{{ route('history') }}" class="flex items-center font-medium text-gray-700 hover:text-blue-600">
                <i class="fas fa-history mr-2"></i>History
            </a>
            <a href="{{ route('kitchen') }}" class="flex items-center font-medium text-gray-700 hover:text-blue-600">
                <i class="fas fa-utensils mr-2"></i>Kitchen
            </a>
        </div>

        <!-- User Profile -->
        <div class="flex items-center space-x-4">
            <!-- Current Date and Time (hidden on mobile) -->
            <div class="hidden gap-4 text-gray-600 md:flex">
                <div class="flex items-center text-sm">
                    {{ \Carbon\Carbon::now()->locale('id')->isoFormat('dddd, D MMMM Y') }}</div>
                <div class="w-16" id="current-time" x-data x-init="setInterval(() => $el.textContent = new Date().toLocaleTimeString('id-ID', { hour12: false }), 1000)">
                    {{ \Carbon\Carbon::now()->locale('id')->format('H:i:s') }}
                </div>
            </div>

            <div class="z-10 flex items-center space-x-4">
                <div x-data="{ open: false }" class="relative">
                    <button @click="open = !open" class="flex items-center">
                        <img src="{{ auth()->user()->image ? asset('storage/' . auth()->user()->image) : asset('storage/profile-photos/default.png') }}"
                            alt="User Profile" class="h-8 w-8 rounded-full object-cover">
                    </button>
                    <div x-show="open" @click.away="open = false"
                        class="absolute right-0 mt-2 w-48 rounded-md bg-white py-1 shadow-lg">
                        <a href="{{ route('profile') }}"
                            class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Profile</a>
                        <form action="{{ route('profile.logout') }}" method="POST">
                            @csrf
                            <button type="submit"
                                class="block w-full px-4 py-2 text-left text-sm text-gray-700 hover:bg-gray-100">Sign
                                out</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>

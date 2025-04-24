<header>
    <div class="flex items-center justify-between border-b border-gray-200 bg-white px-6 py-4 shadow">
        <!-- Brand Logo -->
        <div class="flex items-center">
            <img src="{{ asset('images/logo.png') }}" alt="Brand Logo" class="h-8 w-auto">
            <span class="ml-2 text-xl font-bold text-gray-800">Dika POS</span>
        </div>

        <!-- Navigation Links -->
        <div class="flex items-center space-x-6">
            <a href="{{ route('dashboard') }}" class="flex items-center font-medium text-gray-700 hover:text-blue-600">
                <i class="fas fa-border-all mr-2"></i>Dashboard
            </a>
            <a href="{{ route('order') }}" class="flex items-center font-medium text-gray-700 hover:text-blue-600">
                <i class="fas fa-clipboard-list mr-2"></i>Order List
            </a>
            <a href="@{{ route('history') }}" class="flex items-center font-medium text-gray-700 hover:text-blue-600">
                <i class="fas fa-history mr-2"></i>History
            </a>
            <a href="@{{ route('bills') }}" class="flex items-center font-medium text-gray-700 hover:text-blue-600">
                <i class="fas fa-file-invoice-dollar mr-2"></i>Bills
            </a>
        </div>


        <!-- User Profile -->
        <div class="flex items-center space-x-4">
            <!-- Current Date and Time -->
            <div class="w-64 text-right text-gray-600" id="current-datetime">
                {{ \Carbon\Carbon::now()->isoFormat('dddd, D MMMM Y') }}
            </div>

            <div class="z-50 flex items-center space-x-4">
                <div x-data="{ open: false }" class="relative">
                    <button @click="open = !open"
                        class="flex h-8 w-8 items-center justify-center rounded-full text-gray-600 hover:text-blue-600">
                        <i class="fas fa-bell"></i>
                        <span
                            class="absolute -right-1 -top-1 flex h-4 w-4 items-center justify-center rounded-full bg-red-500 text-xs text-white">3</span>
                    </button>
                    <div x-show="open" @click.away="open = false"
                        class="absolute right-0 mt-2 w-48 rounded-md bg-white py-1 shadow-lg">
                        <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Notification
                            1</a>
                        <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Notification
                            2</a>
                        <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Notification
                            3</a>
                    </div>
                </div>
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

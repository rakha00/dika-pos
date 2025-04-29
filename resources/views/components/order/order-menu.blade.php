<div>
    <h2 class="m-6 text-2xl font-bold text-gray-800">Menu</h2>
    <!-- Food Category Navigation -->
    <div class="m-6 rounded-lg bg-white shadow">
        <div class="flex justify-between overflow-x-auto px-4 py-3">
            <div class="{{ $selectedCategory === 'makanan' ? 'bg-blue-500 text-white' : 'text-gray-700' }} mx-1 cursor-pointer whitespace-nowrap rounded-md px-4 py-2 text-center transition-colors hover:bg-blue-500 hover:text-white"
                wire:click="$set('selectedCategory', 'makanan')">
                Makanan
            </div>
            <div class="{{ $selectedCategory === 'snacks' ? 'bg-blue-500 text-white' : 'text-gray-700' }} mx-1 cursor-pointer whitespace-nowrap rounded-md px-4 py-2 text-center transition-colors hover:bg-blue-500 hover:text-white"
                wire:click="$set('selectedCategory', 'snacks')">
                Snacks
            </div>
            <div class="{{ $selectedCategory === 'minuman' ? 'bg-blue-500 text-white' : 'text-gray-700' }} mx-1 cursor-pointer whitespace-nowrap rounded-md px-4 py-2 text-center transition-colors hover:bg-blue-500 hover:text-white"
                wire:click="$set('selectedCategory', 'minuman')">
                Minuman
            </div>
            <div class="{{ $selectedCategory === 'dessert' ? 'bg-blue-500 text-white' : 'text-gray-700' }} mx-1 cursor-pointer whitespace-nowrap rounded-md px-4 py-2 text-center transition-colors hover:bg-blue-500 hover:text-white"
                wire:click="$set('selectedCategory', 'dessert')">
                Dessert
            </div>
        </div>
    </div>

    <!-- Menu Section -->
    <div class="mx-6 grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3">
        @foreach ($menuItems as $item)
        <!-- Food Card Item -->
        <div class="flex h-full flex-col rounded-lg bg-white p-3 shadow-md sm:p-4" wire:key="{{ $item->id }}">
            <div class="flex flex-col gap-2 sm:flex-row">
                <div class="overflow-hidden rounded-lg sm:w-1/3">
                    <img src="{{ $item->image }}" alt="{{ $item->name }}"
                        class="h-40 w-full object-cover object-center sm:h-full">
                </div>
                <div class="sm:w-2/3">
                    <h3 class="line-clamp-1 text-lg font-semibold text-gray-800 sm:text-xl">
                        {{ $item->name }}
                    </h3>
                    <p class="mt-1 line-clamp-2 text-xs text-gray-600 sm:text-sm">
                        {{ $item->description }}
                    </p>
                    <p class="mt-2 text-xs text-gray-500 sm:text-sm">Stok: {{ $item->stock }}</p>
                </div>
            </div>
            <div class="mt-auto flex items-center justify-between pt-3">
                <p class="flex-shrink-0 text-base font-bold text-blue-600 sm:text-lg md:text-xl">Rp
                    {{ number_format($item->price, 0, ',', '.') }}
                </p>
                <!-- Quantity Control -->
                <div class="flex flex-shrink-0 items-center justify-end">
                    <button wire:click="$dispatch('decrement-quantity', { itemId: {{ $item->id }} })"
                        class="flex h-6 w-6 items-center justify-center rounded-full bg-gray-200 text-gray-700 transition-colors hover:bg-blue-500 hover:text-white md:h-8 md:w-8">
                        <i class="fas fa-minus text-xs md:text-sm"></i>
                    </button>
                    <span
                        class="mx-1 w-4 text-center text-xs font-medium sm:mx-2 sm:w-5 md:mx-2 md:w-6 md:text-sm">{{ $quantities[$item->id] ?? 0 }}</span>
                    <button wire:click="$dispatch('increment-quantity', { itemId: {{ $item->id }} })"
                        class="flex h-6 w-6 items-center justify-center rounded-full bg-gray-200 text-gray-700 transition-colors hover:bg-blue-500 hover:text-white md:h-8 md:w-8">
                        <i class="fas fa-plus text-xs md:text-sm"></i>
                    </button>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
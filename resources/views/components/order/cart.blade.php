<aside>
    <div class="sticky top-0 h-screen w-96 flex-shrink-0 overflow-y-auto border-l border-gray-200 bg-white p-6">
        <!-- Customer Information -->
        <h1 class="text-lg font-bold text-gray-800">Customer Information</h1>
        <div class="my-4">
            <div class="mb-4">
                <input wire:model="customerName" type="text" id="name" placeholder="Customer name"
                    class="mt-1 block h-10 w-full rounded-md border-gray-300 p-2 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
            </div>
        </div>
        <div class="w-full border-b border-gray-200"></div>

        <!-- Order Details -->
        <h2 class="mt-4 text-lg font-bold text-gray-800">Order Details</h2>
        <div class="my-4">
            @foreach ($orderItems as $item)
                <div class="mb-4 rounded-lg bg-white p-4 shadow" wire:key="{{ $item['id'] }}">
                    <div class="flex items-center gap-3">
                        <!-- Item Image & Info -->
                        <div class="h-16 w-16 overflow-hidden rounded-md">
                            <img src="{{ asset($item['image']) }}" alt="{{ $item['name'] }}"
                                class="h-full w-full object-cover">
                        </div>
                        <div class="flex-1">
                            <h3 class="text-sm font-medium text-gray-800">{{ $item['name'] }}</h3>
                            <p class="text-xs text-gray-600">
                                Rp{{ number_format($item['price'] * $item['quantity'], 0, ',', '.') }}
                            </p>
                            @if (isset($item['customOptions']) && count($item['customOptions']) > 0)
                                <div class="relative" x-data="{ showList: false }">
                                    <button
                                        class="flex w-full items-center justify-between py-1 text-xs font-medium text-gray-600 hover:text-blue-600"
                                        x-on:click="showList = ! showList">
                                        Details
                                        <i class="fas fa-chevron-down ml-2"></i>
                                    </button>
                                    <ul class="absolute z-10 list-disc rounded-md border border-gray-200 bg-white pl-4 text-xs text-gray-600 shadow-md"
                                        x-show="showList">
                                        @foreach ($customOptions as $option => $price)
                                            <li wire:key="{{ $option }}">{{ $option }}
                                                ({{ number_format($price, 0, ',', '.') }})
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <!-- Quantity controls -->
                            <div class="mt-3 flex items-center">
                                <div class="flex items-center">
                                    <button
                                        wire:click="$dispatch('decrement-quantity', { itemId: {{ $item['id'] }} })"
                                        class="flex h-6 w-6 items-center justify-center rounded-full bg-gray-200 text-gray-700 hover:bg-blue-500 hover:text-white">
                                        <i class="fas fa-minus text-xs"></i>
                                    </button>
                                    <span class="mx-2 w-4 text-center text-sm">{{ $item['quantity'] }}</span>
                                    <button wire:click="$dispatch('increment-quantity', {itemId: {{ $item['id'] }}})"
                                        class="flex h-6 w-6 items-center justify-center rounded-full bg-gray-200 text-gray-700 hover:bg-blue-500 hover:text-white">
                                        <i class="fas fa-plus text-xs"></i>
                                    </button>
                                </div>
                                <div class="ml-auto">
                                    @if ($menu->find($item['id'])->customOptions->isNotEmpty())
                                        <button wire:click="showCustomizeModal({{ $item['id'] }})"
                                            class="text-sm text-blue-500 hover:text-blue-700">Customize</button>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach

            @if ($isModalOpen)
                <x-order.modal-custom :listItemCustom="$listItemCustom" :listCustomOptions="$listCustomOptions" :selectedItemIndex="$selectedItemIndex" :selectedOptions="$selectedOptions" />
            @endif

            @if (empty($orderItems))
                <p class="text-sm text-gray-600">No items in cart</p>
            @endif
        </div>

        <!-- Order Summary -->
        <div class="my-6">
            <div class="space-y-2">
                <div class="flex justify-between">
                    <p class="text-sm text-gray-600">Subtotal Menu:</p>
                    <p class="text-sm text-gray-800">Rp {{ number_format($totalPrice, 0, ',', '.') }}</p>
                </div>
                <div class="flex justify-between">
                    <p class="text-sm text-gray-600">Tax (10%):</p>
                    <p class="text-sm text-gray-800">Rp {{ number_format($totalPrice * 0.1, 0, ',', '.') }}</p>
                </div>
                <div class="flex justify-between border-t border-gray-200 pt-2">
                    <p class="text-sm font-bold text-gray-800">Total:</p>
                    <p class="text-sm font-bold text-blue-600">Rp {{ number_format($totalPrice * 1.1, 0, ',', '.') }}
                    </p>
                </div>
            </div>
        </div>


        <!-- Process Transaction Button -->
        <button wire:click="processTransaction"
            class="w-full rounded-md bg-blue-500 py-2 text-white transition-colors hover:bg-blue-600">
            Process Transaction
        </button>
    </div>

    <div x-data="{ show: false }" x-show="show"
        x-on:transaction-success.window="show = true; setTimeout(() => show = false, 3000)"
        class="fixed right-5 top-5 z-50 rounded-lg bg-green-500 px-4 py-3 text-white shadow-lg">
        Transaksi berhasil disimpan!
    </div>

    <div x-data="{ show: false }" x-show="show"
        x-on:transaction-failed.window="show = true; setTimeout(() => show = false, 3000)"
        class="fixed right-5 top-5 z-50 rounded-lg bg-red-500 px-4 py-3 text-white shadow-lg">
        Transaksi gagal disimpan!
    </div>

</aside>

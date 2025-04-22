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
            <div class="mb-4 rounded-lg bg-white p-4 shadow">
                <div class="flex items-center gap-3">
                    <!-- Item Image & Info -->
                    <div class="h-16 w-16 overflow-hidden rounded-md">
                        <img src="{{ asset('images/' . $item['image']) }}" alt="{{ $item['name'] }}" class="h-full w-full object-cover">
                    </div>
                    <div class="flex-1">
                        <h3 class="text-sm font-medium text-gray-800">{{ $item['name'] }}</h3>
                        <p class="text-xs text-gray-600">Rp {{ number_format($item['price'], 0, ',', '.') }}</p>
                        <!-- Quantity controls -->
                        <div class="mt-3 flex items-center justify-between">
                            <button wire:click="$dispatch('decrement-quantity', { itemId: {{ $item['id'] }} })" class="h-6 w-6 rounded-full bg-gray-200 text-gray-700">
                                <i class="fas fa-minus text-xs"></i>
                            </button>
                            <span class="w-4 text-center text-sm">{{ $item['quantity'] }}</span>
                            <button wire:click="$dispatch('increment-quantity', { itemId: {{ $item['id'] }} })" class="h-6 w-6 rounded-full bg-gray-200 text-gray-700">
                                <i class="fas fa-plus text-xs"></i>
                            </button>
                            <!-- Customize button for customizable menu items -->
                            @if ($item['is_customizable'])
                            <button wire:click="showCustomizeModal({{ $item['id'] }})" class="ml-2 text-blue-500 text-sm">Customize</button>
                            @endif

                        </div>
                    </div>
                </div>
            </div>

            @endforeach
            <!-- Global Modal -->
            @if ($isModalOpen)
            <div class="fixed inset-0 flex items-center justify-center z-50">
                <div class="modal-overlay fixed inset-0 bg-gray-500 opacity-75 cursor-pointer" wire:click="closeModal"></div>
                <div class="modal-content bg-white p-6 rounded-md shadow-lg">
                    <div class="modal-header flex justify-between">
                        <h2 class="text-lg font-semibold">Customize {{ $currentItemName }}</h2>
                        <button wire:click="closeModal" class="text-gray-500">X</button>
                    </div>
                    <div class="modal-body">
                        @foreach ($customOptions as $option)
                        <div class="mb-4">
                            <label class="font-semibold">{{ $option->name }}</label>
                            <div class="mt-2">
                                @foreach ($option->customOptionValues ?? [] as $value)
                                <label class="inline-flex items-center mr-4">
                                    <input type="radio" name="custom_option_{{ $option->id }}"
                                        value="{{ $value->id }}"
                                        wire:model="selectedOption.{{ $option->id }}"
                                        class="form-radio">
                                    <span class="ml-2">{{ $value->value }} @if($value->price > 0) (+Rp{{ number_format($value->price, 0, ',', '.') }}) @endif</span>
                                </label>
                                @endforeach
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <div class="modal-footer mt-4 text-right">
                        <button wire:click="addCustomOptions({{ $currentItemId }})" class="px-4 py-2 bg-blue-500 text-white rounded">Save Customization</button>
                    </div>
                </div>
            </div>
            @endif

            @if (empty($orderItems))
            <p class="text-sm text-gray-600">No items in cart</p>
            @endif
        </div>

        <!-- Order Summary -->
        <div class="my-6">
            <div class="space-y-2">
                <div class="flex justify-between">
                    <p class="text-sm text-gray-600">Subtotal:</p>
                    <p class="text-sm text-gray-800">Rp
                        {{ number_format(array_sum(array_map(fn($item) => $item['price'] * $item['quantity'], $orderItems)), 0, ',', '.') }}
                    </p>
                </div>
                @if(isset($item['customOptions']) && count($item['customOptions']) > 0)
                <div class="text-sm text-gray-500">
                    + Custom tambahan: Rp{{ number_format($item['price'] - \App\Models\Menu::find($item['id'])->price, 0, ',', '.') }}
                </div>
                @endif
                <div class="flex justify-between">
                    <p class="text-sm text-gray-600">Tax (10%):</p>
                    <p class="text-sm text-gray-800">Rp
                        {{ number_format(array_sum(array_map(fn($item) => $item['price'] * $item['quantity'], $orderItems)) * 0.1, 0, ',', '.') }}
                    </p>
                </div>
                <div class="flex justify-between border-t border-gray-200 pt-2">
                    <p class="text-sm font-bold text-gray-800">Total:</p>
                    <p class="text-sm font-bold text-blue-600">Rp
                        {{ number_format(array_sum(array_map(fn($item) => $item['price'] * $item['quantity'], $orderItems)) * 1.1, 0, ',', '.') }}
                    </p>
                </div>
            </div>
        </div>

        <!-- Process Transaction Button -->
        <button wire:click="processTransaction"
            class="w-full rounded-md bg-blue-500 py-2 text-white transition-colors hover:bg-blue-600">Process
            Transaction</button>
    </div>
</aside>
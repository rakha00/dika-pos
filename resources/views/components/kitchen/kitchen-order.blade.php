<div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
    <h1 class="mb-6 text-2xl font-bold text-gray-800">Kitchen Orders</h1>

    <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
        @foreach ($orders as $order)
            <div class="flex h-full flex-col overflow-hidden rounded-lg bg-white shadow-md"
                wire:key="order-{{ $order->id }}">
                <div class="border-b border-gray-200 bg-gray-50 px-4 py-3">
                    <div class="flex items-center justify-between">
                        <h2 class="font-semibold text-gray-800">Order #{{ $order->id_transaction }}</h2>
                    </div>
                </div>
                <div class="flex h-full flex-col p-4">
                    <div class="mb-4">
                        <p class="text-sm text-gray-600">
                            Customer: <span class="font-medium text-gray-800">{{ $order->customer_name }}</span>
                        </p>
                        <p class="text-sm text-gray-600">
                            Time:
                            <span class="font-medium text-gray-800">{{ $order->created_at->format('H:i') }}
                            </span>
                        </p>
                    </div>

                    <div class="mb-4">
                        <h3 class="mb-2 text-lg font-medium text-gray-800">Items:</h3>
                        <ul class="ml-4 list-disc text-base text-gray-600">
                            @foreach ($order->detailTransactions as $detail)
                                <li>
                                    {{ $detail->menu->name }} x {{ $detail->quantity }}
                                    @if ($detail->detailCustomOptions->isNotEmpty())
                                        <ul class="ml-4 text-sm text-gray-500">
                                            @foreach($detail->detailCustomOptions as $customOption)
                                            <li>{{ $customOption->customOptionValue->customOption->name }}: Rp{{ number_format($customOption->customOptionValue->additional_price, 0, ',', '.') }}</li>
                                            @endforeach
                                        </ul>
                                    @endif
                                </li>
                            @endforeach
                        </ul>
                    </div>

                    <div class="mt-auto">
                        <div class="flex justify-end">
                            <button wire:click="completeOrder({{ $order->id }})"
                                class="rounded-md bg-blue-600 px-4 py-2 text-sm text-white transition-colors hover:bg-blue-700">
                                Mark as Ready
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
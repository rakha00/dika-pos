<div class="mx-auto px-4 sm:px-6 lg:px-8">
    <h1 class="mb-6 text-2xl font-bold text-gray-800">Antrian Kitchen</h1>

    <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
        @foreach ($orders as $order)
            <div class="flex h-full flex-col overflow-hidden rounded-lg bg-white shadow-md"
                wire:key="order-{{ $order->id }}">
                <div class="border-b border-gray-200 bg-gray-50 px-4 py-3">
                    <div class="flex items-center justify-between">
                        <h2 class="font-semibold text-gray-800">Order #{{ $order->transaction_id }}</h2>
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
                                    @if ($detail->detailTransactionCustomOptions->isNotEmpty())
                                        <ul class="ml-4 text-sm text-gray-500">
                                            @foreach ($detail->grouped_custom_options_by_item_index as $itemIndex => $options)
                                                <li>Item #{{ $itemIndex + 1 }}
                                                    <ul class="ml-2">
                                                        @foreach ($options as $option)
                                                            <li>- {{ $option->customOption->category }}:
                                                                {{ $option->customOption->value }}</li>
                                                        @endforeach
                                                    </ul>
                                                </li>
                                            @endforeach
                                        </ul>
                                    @endif
                                </li>
                            @endforeach
                        </ul>
                    </div>

                    <div class="flex w-full justify-end gap-2">
                        <div class="mt-auto">
                            <div class="flex justify-end">
                                <button wire:click="showCancelModal({{ $order->id }})"
                                    class="rounded-md bg-red-600 px-4 py-2 text-sm text-white transition-colors hover:bg-red-700">
                                    Cancel Order
                                </button>
                            </div>
                        </div>
                        <div class="mt-auto">
                            <div class="flex justify-end">
                                <button wire:click="showConfirmModal({{ $order->id }})"
                                    class="rounded-md bg-blue-600 px-4 py-2 text-sm text-white transition-colors hover:bg-blue-700">
                                    Mark as Ready
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @if ($isCancelModalOpen)
                <x-kitchen.modal-cancel :selectedOrderId="$selectedOrderId" :selectedTransactionId="$selectedTransactionId" />
            @endif

            @if ($isConfirmModalOpen)
                <x-kitchen.modal-confirm :selectedOrderId="$selectedOrderId" :selectedTransactionId="$selectedTransactionId" />
            @endif
        @endforeach
        @empty($order)
            <li>Tidak ada antrian di kitchen.</li>
        @endempty
    </div>
</div>

<div>

    <h2 class="m-6 text-2xl font-bold text-gray-800">Order List</h2>

    <div class="ml-6 flex flex-row space-x-4 overflow-x-auto pb-4">
        @foreach ($orderList as $order)
            <div class="w-64 flex-shrink-0 rounded-lg bg-white shadow-md">
                <!-- Main Card Content -->
                <div class="p-4">
                    <!-- Customer Info -->
                    <div class="mb-2">
                        <h3 class="text-lg font-bold text-gray-800">{{ $order->customer_name }}</h3>
                        <p class="text-sm text-gray-600">{{ $order->id_transaction }}</p>
                    </div>

                    <!-- Order Details -->
                    <div class="flex flex-row justify-between gap-4">
                        <div class="flex flex-col">
                            <span class="text-xs text-gray-500">Items</span>
                            <p class="font-medium text-gray-700">{{ $order->total_items }}</p>
                        </div>
                        <div class="flex flex-col">
                            <span class="text-xs text-gray-500">Status</span>
                            <span
                                class="{{ $order->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : '' }} {{ $order->status === 'completed' ? 'bg-green-100 text-green-800' : '' }} {{ $order->status === 'cancelled' ? 'bg-red-100 text-red-800' : '' }} inline-block rounded-full px-2 py-1 text-xs">
                                {{ $order->status }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>

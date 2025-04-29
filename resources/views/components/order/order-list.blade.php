<h2 class="m-6 text-2xl font-bold text-gray-800">Order List - Pending</h2>

<div class="ml-6 flex flex-row space-x-4 overflow-x-auto pb-4">
    @forelse ($transactions->where('status', 'pending') as $order)
        <div class="w-64 flex-shrink-0 rounded-lg bg-white shadow-md hover:shadow-lg transition">
            <div class="p-4">
                <!-- Customer Info -->
                <div class="mb-2">
                    <h3 class="text-lg font-bold text-gray-800">{{ $order->customer_name }}</h3>
                    <p class="text-sm text-gray-600">#{{ $order->id_transaction }}</p>
                </div>

                <!-- Order Details -->
                <div class="flex flex-row justify-between gap-4">
                    <div class="flex flex-col">
                        <span class="text-xs text-gray-500">Items</span>
                        <p class="font-medium text-gray-700">{{ $order->details->count() }}</p>
                    </div>
                    <div class="flex flex-col">
                        <span class="text-xs text-gray-500">Status</span>
                        <span
                            class="bg-yellow-100 text-yellow-800 inline-block rounded-full px-2 py-1 text-xs capitalize">
                            {{ $order->status }}
                        </span>
                    </div>
                </div>
            </div>
        </div>
    @empty
        <p class="text-gray-500">Tidak ada transaksi pending.</p>
    @endforelse
</div>

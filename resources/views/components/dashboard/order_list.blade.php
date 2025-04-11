@php
    $dummyOrders = [
        [
            'customer_name' => 'John Doe',
            'transaction_id' => 'TRX001',
            'items_count' => 3,
            'table_number' => 'A1',
            'status' => 'pending',
        ],
        [
            'customer_name' => 'Jane Smith',
            'transaction_id' => 'TRX002',
            'items_count' => 2,
            'table_number' => 'B2',
            'status' => 'completed',
        ],
        [
            'customer_name' => 'Mike Johnson',
            'transaction_id' => 'TRX003',
            'items_count' => 4,
            'table_number' => 'C3',
            'status' => 'pending',
        ],
        [
            'customer_name' => 'Sarah Wilson',
            'transaction_id' => 'TRX004',
            'items_count' => 1,
            'table_number' => 'D4',
            'status' => 'cancelled',
        ],
        [
            'customer_name' => 'Tom Brown',
            'transaction_id' => 'TRX005',
            'items_count' => 5,
            'table_number' => 'E5',
            'status' => 'completed',
        ],
        [
            'customer_name' => 'Lisa Anderson',
            'transaction_id' => 'TRX006',
            'items_count' => 2,
            'table_number' => 'F6',
            'status' => 'pending',
        ],
        [
            'customer_name' => 'David Clark',
            'transaction_id' => 'TRX007',
            'items_count' => 3,
            'table_number' => 'G7',
            'status' => 'completed',
        ],
        [
            'customer_name' => 'Emma Davis',
            'transaction_id' => 'TRX008',
            'items_count' => 4,
            'table_number' => 'H8',
            'status' => 'pending',
        ],
        [
            'customer_name' => 'James Wilson',
            'transaction_id' => 'TRX009',
            'items_count' => 2,
            'table_number' => 'I9',
            'status' => 'cancelled',
        ],
        [
            'customer_name' => 'Mary Roberts',
            'transaction_id' => 'TRX010',
            'items_count' => 6,
            'table_number' => 'J10',
            'status' => 'completed',
        ],
    ];
@endphp

<div class="ml-6 flex flex-row space-x-4 overflow-x-auto pb-4">
    @foreach ($dummyOrders as $order)
        <div class="w-64 flex-shrink-0 rounded-lg bg-white shadow-md">
            <!-- Main Card Content -->
            <div class="p-4">
                <!-- Customer Info -->
                <div class="mb-2">
                    <h3 class="text-lg font-bold text-gray-800">{{ $order['customer_name'] }}</h3>
                    <p class="text-sm text-gray-600">#{{ $order['transaction_id'] }}</p>
                </div>

                <!-- Order Details -->
                <div class="flex flex-row justify-between gap-4">
                    <div class="flex flex-col">
                        <span class="text-xs text-gray-500">Items</span>
                        <p class="font-medium text-gray-700">{{ $order['items_count'] }}</p>
                    </div>
                    <div class="flex flex-col">
                        <span class="text-xs text-gray-500">Status</span>
                        <span
                            class="{{ $order['status'] === 'pending' ? 'bg-yellow-100 text-yellow-800' : '' }} {{ $order['status'] === 'completed' ? 'bg-green-100 text-green-800' : '' }} {{ $order['status'] === 'cancelled' ? 'bg-red-100 text-red-800' : '' }} inline-block rounded-full px-2 py-1 text-xs">
                            {{ $order['status'] }}
                        </span>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</div>

<div class="mx-auto px-4 sm:px-6 lg:px-8">
    <h1 class="mb-6 text-2xl font-bold text-gray-800">Riwayat Transaksi</h1>

    <!-- Card Container -->
    <div class="ml-6 flex flex-row flex-wrap space-x-4 overflow-x-auto pb-4">
        @foreach ($transactions as $trx)
            <div class="mb-4 w-64 flex-shrink-0 rounded-lg bg-white shadow-md">
                <!-- Main Card Content -->
                <div class="p-4">
                    <!-- Customer Info -->
                    <div class="mb-2">
                        <h3 class="text-lg font-bold text-gray-800">{{ $trx->customer_name }}</h3>
                        <p class="text-sm text-gray-600">ID TRANSAKSI: #{{ $trx->transaction_id }}</p>
                    </div>

                    <!-- Order Details -->
                    <div class="flex flex-row justify-between gap-4">
                        <div class="flex flex-col">
                            <span class="text-xs text-gray-500">Items</span>
                            <p class="font-medium text-gray-700">{{ $trx->detailTransactions->sum('quantity') }} Menu
                            </p>
                        </div>
                        <div class="flex flex-col">
                            <span class="text-xs text-gray-500">Status</span>
                            <span
                                class="{{ $trx->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : '' }} {{ $trx->status === 'completed' ? 'bg-green-100 text-green-800' : '' }} {{ $trx->status === 'cancelled' ? 'bg-red-100 text-red-800' : '' }} inline-block rounded-full px-2 py-1 text-xs">
                                {{ $trx->status }}
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Tanggal Transaksi dan Detail Button -->
                <div class="flex items-center justify-between p-4">
                    <!-- Tanggal Transaksi -->
                    <div class="text-xs text-gray-500">
                        {{ $trx->created_at->format('d M Y, H:i') }}
                    </div>

                    <!-- Detail Button -->
                    <button wire:click="showDetail({{ $trx->id }})"
                        class="rounded bg-blue-600 px-3 py-1 text-sm text-white hover:bg-blue-700">
                        Detail
                    </button>
                </div>
            </div>
        @endforeach
        @empty($transactions)
            <li>Tidak ada transaksi.</li>
        @endempty
    </div>

    <!-- Modal untuk Detail Transaksi -->
    @if ($showModal)
        <div class="fixed inset-0 z-50 flex items-center justify-center">
            <div class="fixed inset-0 z-50 cursor-pointer bg-black opacity-50" wire:click="closeModal">
            </div>
            <div class="z-100 relative w-full max-w-2xl rounded-lg bg-white p-8 shadow-xl">
                <div class="mb-2 flex items-center justify-between">
                    <h3 class="text-xl font-semibold text-gray-800">
                        Detail Transaksi #{{ $transaction->transaction_id }}
                    </h3>
                    <button wire:click="closeModal" class="text-2xl font-bold text-gray-500 hover:text-gray-700">
                        &times;
                    </button>
                </div>

                <div class="space-y-4 text-gray-700">
                    <!-- Customer Info -->
                    <div class="space-y-1">
                        <div class="flex text-sm">
                            <p class="w-32 font-medium"><strong>Nama Pelanggan</strong></p>
                            <p class="font-medium">: {{ $transaction->customer_name }}</p>
                        </div>
                        <div class="flex text-sm">
                            <p class="w-32 font-medium"><strong>Total Harga</strong></p>
                            <p class="font-medium">: Rp{{ number_format($transaction->total_price, 0, ',', '.') }}
                            </p>
                        </div>
                        <div class="flex text-sm">
                            <p class="w-32 font-medium"><strong>Tanggal Transaksi</strong></p>
                            <p class="font-medium">: {{ $transaction->created_at->format('d M Y, H:i') }}</p>
                        </div>
                    </div>

                    <!-- Order Details -->
                    <div>
                        <h4 class="mb-2 mt-4 text-lg font-semibold">Detail Menu:</h4>
                        <div class="rounded-lg border p-1">
                            <!-- Table Header -->
                            <div class="grid grid-cols-12 gap-4 border-b bg-gray-50 p-2 font-semibold text-gray-700">
                                <div class="col-span-5">Menu</div>
                                <div class="col-span-3 text-right">Qty</div>
                                <div class="col-span-4 text-right">Subtotal</div>
                            </div>

                            <!-- Table Body -->
                            <div class="max-h-60 overflow-y-auto">
                                @foreach ($transaction->detailTransactions as $detail)
                                    <div class="border-b p-2">
                                        <div class="grid grid-cols-12 gap-4">
                                            <div class="col-span-5">
                                                <p class="font-medium text-gray-800">{{ $detail->menu->name }}
                                                    (Rp{{ number_format($detail->menu->price, 0, ',', '.') }})
                                                </p>
                                                @if ($detail->grouped_custom_options_by_item_index->isNotEmpty())
                                                    @foreach ($detail->grouped_custom_options_by_item_index as $itemIndex => $optionsInGroup)
                                                        <p class="text-xs text-gray-400 mt-1"># {{ $itemIndex + 1 }}
                                                        </p>
                                                        <div class="mt-0.5 space-y-0.5">
                                                            @foreach ($optionsInGroup as $customOptionEntry)
                                                                <p class="text-sm text-gray-600">
                                                                    + {{ $customOptionEntry->customOption->value }}
                                                                    <span
                                                                        class="text-gray-500">(Rp{{ number_format($customOptionEntry->customOption->additional_price, 0, ',', '.') }})</span>
                                                                </p>
                                                            @endforeach
                                                        </div>
                                                    @endforeach
                                                @endif
                                            </div>
                                            <div class="col-span-3 text-right">
                                                {{ $detail->quantity }}x
                                            </div>
                                            <div class="col-span-4 text-right font-medium">
                                                Rp{{ number_format($detail->subtotal, 0, ',', '.') }}
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <!-- Summary -->
                            <div class="space-y-1">
                                <div class="flex justify-between px-2 text-gray-600">
                                    <span>Subtotal</span>
                                    <span>Rp{{ number_format($transaction->total_price / 1.1, 0, ',', '.') }}</span>
                                </div>
                                <div class="flex justify-between px-2 text-gray-600">
                                    <span>PPN (10%)</span>
                                    <span>Rp{{ number_format($transaction->total_price - $transaction->total_price / 1.1, 0, ',', '.') }}</span>
                                </div>
                                <div class="flex justify-between border-t px-2 pt-1 text-lg font-bold">
                                    <span>Total</span>
                                    <span>Rp{{ number_format($transaction->total_price, 0, ',', '.') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

</div>

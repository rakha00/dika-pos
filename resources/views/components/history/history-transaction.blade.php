<div class="mx-auto px-4 sm:px-6 lg:px-8">
    <h1 class="mb-6 text-2xl font-bold text-gray-800">Riwayat Transaksi</h1>

    <!-- Card Container -->
    <div class="flex flex-row space-x-4 overflow-x-auto pb-4 flex-wrap">
        @forelse ($transactions as $trx)
            <div class="w-64 flex-shrink-0 rounded-lg bg-white shadow-md mb-4">
                <!-- Main Card Content -->
                <div class="p-4">
                    <!-- Customer Info -->
                    <div class="mb-2">
                        <h3 class="text-lg font-bold text-gray-800">{{ $trx->customer_name }}</h3>
                        <p class="text-sm text-gray-600">ID TRANSAKSI: {{ $trx->id_transaction }}</p>
                    </div>

                    <!-- Order Details -->
                    <div class="flex flex-row justify-between gap-4">
                        <div class="flex flex-col">
                            <span class="text-xs text-gray-500">Items</span>
                            <p class="font-medium text-gray-700">{{ $trx->details->sum('quantity') }} Menu</p>
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
                <div class="p-4 flex justify-between items-center">
                    <!-- Tanggal Transaksi -->
                    <div class="text-xs text-gray-500">
                        {{ $trx->created_at->format('d M Y, H:i') }}
                    </div>

                    <!-- Detail Button -->
                    <button wire:click="showDetail({{ $trx->id }})"
                        class="px-3 py-1 text-sm bg-blue-600 text-white rounded hover:bg-blue-700">
                        Detail
                    </button>
                </div>
            </div>
        @empty
            <p class="text-gray-500">Tidak ada riwayat transaksi.</p>
        @endforelse
    </div>


    <!-- Modal untuk Detail Transaksi -->
    @if ($showModal)
        <div class="fixed inset-0 z-50 flex items-center justify-center">
            <div class="fixed inset-0 z-50 cursor-pointer bg-black opacity-50" wire:click="closeModal">
            </div>
            <div class="z-100 relative w-full max-w-2xl rounded-lg bg-white p-8 shadow-xl">
                <div class="mb-2 flex items-center justify-between">
                    <h3 class="text-xl font-semibold text-gray-800">
                        Detail Transaksi {{ $transaction->id_transaction }}
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
                                                @if ($detail->detailCustomOptions->isNotEmpty())
                                                    <div class="mt-0.5 space-y-0.5">
                                                        @if ($detail->detailCustomOptions->isNotEmpty())
                                                            <ul class="ml-4 space-y-1 text-sm text-gray-600">
                                                                @foreach ($detail->detailCustomOptions as $customOption)
                                                                    <li>{{ $customOption->customOptionValue->customOption->name }}:
                                                                        Rp{{ number_format($customOption->customOptionValue->additional_price, 0, ',', '.') }}
                                                                    </li>
                                                                @endforeach
                                                            </ul>
                                                        @endif
                                                    </div>
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
                            <div class="space-y-1 bg-gray-50">
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

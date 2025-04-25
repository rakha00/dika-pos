<div class="p-4">
    <h2 class="text-xl font-bold mb-4">Riwayat Transaksi</h2>

    <!-- Card Container -->
    <div class="ml-6 flex flex-row space-x-4 overflow-x-auto pb-4 flex-wrap">
        @foreach($transactions as $trx)
        <div class="w-64 flex-shrink-0 rounded-lg bg-white shadow-md mb-4">
            <!-- Main Card Content -->
            <div class="p-4">
                <!-- Customer Info -->
                <div class="mb-2">
                    <h3 class="text-lg font-bold text-gray-800">{{ $trx->customer_name }}</h3>
                    <p class="text-sm text-gray-600">ID TRANSAKSI: #{{ $trx->id_transaction }}</p>
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
        @endforeach
    </div>


    <!-- Modal untuk Detail Transaksi -->
    @if($showModal)
    <div class="fixed inset-0 flex justify-center items-center bg-gray-500 bg-opacity-50 z-50">
        <div class="bg-white p-8 rounded-lg shadow-xl w-full max-w-2xl">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-2xl font-semibold text-gray-800">Detail Transaksi #{{ $transaction->id_transaction }}</h3>
                <button wire:click="closeModal" class="text-gray-500 hover:text-gray-700 text-2xl font-bold">
                    &times;
                </button>
            </div>

            <div class="space-y-4 text-gray-700">
                <!-- Customer Info -->
                <div>
                    <p class="font-medium"><strong>Nama Pelanggan:</strong> {{ $transaction->customer_name }}</p>
                    <p class="font-medium"><strong>Total Harga:</strong> Rp{{ number_format($transaction->total_price, 0, ',', '.') }}</p>
                    <p class="font-medium"><strong>Tanggal Transaksi:</strong> {{ $transaction->created_at->format('d M Y, H:i') }}</p>
                </div>

                <!-- Order Details -->
                <div>
                    <h4 class="font-semibold text-lg mt-6 mb-2">Detail Menu:</h4>
                    <ul class="space-y-2">
                        @foreach($transaction->details as $detail)
                        <li class="flex justify-between items-center border-b py-2">
                            <div>
                                <strong class="text-gray-800">{{ $detail->menu->name }}</strong>
                                <span class="text-gray-600">- Rp{{ number_format($detail->subtotal, 0, ',', '.') }}</span>
                            </div>
                            @if($detail->detailCustomOptions->isNotEmpty())
                            <ul class="ml-4 space-y-1 text-sm text-gray-600">
                                @foreach($detail->detailCustomOptions as $customOption)
                                <li>{{ $customOption->customOptionValue->customOption->name }}: Rp{{ number_format($customOption->customOptionValue->additional_price, 0, ',', '.') }}</li>
                                @endforeach
                            </ul>
                            @endif
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>

            <div class="mt-6 flex justify-end">
                <button wire:click="closeModal" class="px-6 py-3 bg-red-600 text-white rounded-full hover:bg-red-700 transition duration-300 ease-in-out">
                    Tutup
                </button>
            </div>
        </div>
    </div>
    @endif

</div>
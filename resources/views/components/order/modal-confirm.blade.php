<div class="fixed inset-0 z-50 flex items-center justify-center">
    <div class="fixed inset-0 z-50 cursor-pointer bg-black opacity-50" wire:click="hideConfirmModal">
    </div>
    <div class="z-100 relative max-h-[80vh] w-[500px] overflow-y-auto rounded-md bg-white p-6 shadow-lg">
        <div class="flex justify-end">
            <button wire:click="hideConfirmModal" class="text-gray-500 transition-colors hover:text-red-500">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div>
            <p class="text-lg font-semibold text-gray-800">Konfirmasi Pembayaran</p>
            <p class="text-sm text-gray-600">Silahkan pilih metode pembayaran:</p>
            <div class="mt-4 flex space-x-2">
                <button type="button" wire:click="$set('paymentMethod', 'cash')"
                    class="flex-1 rounded-md px-4 py-2 text-sm transition-colors {{ $paymentMethod === 'cash' ? 'bg-blue-800' : 'bg-blue-600' }} text-white">
                    Tunai
                </button>
                <button type="button" wire:click="$set('paymentMethod', 'non-cash')"
                    class="flex-1 rounded-md px-4 py-2 text-sm transition-colors {{ $paymentMethod === 'non-cash' ? 'bg-blue-800' : 'bg-blue-600' }} text-white">
                    Non Tunai
                </button>
            </div>

            @if ($paymentMethod === 'cash' && !$changeAmount)
                <div class="mt-4">
                    <label class="block text-sm font-medium text-gray-700">Jumlah Tunai</label>
                    <input type="text" wire:model="cashAmount" inputmode="numeric"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-lg py-1 px-2"
                        placeholder="Masukkan Jumlah Tunai">
                </div>
            @endif

            @if ($paymentMethod === 'non-cash')
                <div class="mt-4">
                    <p class="text-sm text-gray-600">Apakah transaksi berhasil?</p>
                </div>
            @endif

            @if ($changeAmount && $paymentMethod === 'cash')
                <div class="mt-4">
                    <label class="block text-sm font-medium text-gray-700">Uang Kembalian</label>
                    <div class="mt-1 text-lg font-semibold text-green-600">
                        Rp {{ number_format($changeAmount, 0, ',', '.') }}
                    </div>
                </div>
            @endif

            @if ($paymentMethod && !$changeAmount)
                <div class="mt-4">
                    <button wire:click="processTransaction"
                        class="w-full rounded-md bg-green-600 px-4 py-2 text-white transition-colors hover:bg-green-700">
                        Konfirmasi Pembayaran
                    </button>
                </div>
            @endif

            @if ($changeAmount)
                <div class="mt-4 flex justify-end">
                    <a href="{{ route('printReceipt', $transactionId) }}" target="_blank"
                        class="flex items-center gap-2 rounded-lg bg-green-600 px-4 py-2 text-white hover:bg-green-700">
                        <i class="fas fa-print h-5 w-5"></i>
                        Cetak Struk
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>

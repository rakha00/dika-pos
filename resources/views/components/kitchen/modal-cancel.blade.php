<div class="fixed inset-0 z-50 flex items-center justify-center">
    <div class="fixed inset-0 z-50 cursor-pointer bg-black opacity-30" wire:click="hideModal">
    </div>
    <div class="z-100 relative max-h-[80vh] w-[500px] overflow-y-auto rounded-md bg-white p-6 shadow-lg">
        <div class="flex justify-end">
            <button wire:click="hideModal" class="text-gray-500 transition-colors hover:text-red-500">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div>
            <p class="text-lg font-semibold text-gray-800">Konfirmasi Pembatalan</p>
            <p class="text-sm text-gray-600">Apakah Anda yakin ingin membatalkan pesanan ini?</p>

            <div class="mt-4">
                <p class="text-sm text-gray-700">
                    Pembatalan pesanan akan menghapus pesanan ini dari riwayat transaksi.
                    Tindakan ini tidak dapat dibatalkan.
                </p>
            </div>

            <div class="mt-6 flex space-x-3">
                <button wire:click="hideModal"
                    class="flex-1 rounded-md bg-gray-200 px-4 py-2 text-sm text-gray-700 transition-colors hover:bg-gray-300">
                    Batal
                </button>
                <button wire:click="cancelOrder({{ $selectedOrderId }})"
                    class="flex-1 rounded-md bg-red-600 px-4 py-2 text-sm text-white transition-colors hover:bg-red-700">
                    Ya, Batalkan Pesanan
                </button>
            </div>
        </div>
    </div>
</div>

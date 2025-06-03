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
            <p class="text-lg font-semibold text-gray-800">Konfirmasi Pesanan</p>
            <p class="text-sm text-gray-600">Apakah pesanan ini sudah siap untuk diantar?</p>

            <div class="mt-6">
                <div class="rounded-lg bg-gray-50 p-4">
                    <div class="flex items-center">
                        <i class="fas fa-utensils text-2xl text-gray-600 mr-3"></i>
                        <div>
                            <p class="font-medium text-gray-800">Pesanan #{{ $selectedTransactionId ?? 'N/A' }}</p>
                            <p class="text-sm text-gray-600">Pastikan semua item pesanan sudah lengkap dan sesuai</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-6 flex space-x-3">
                <button wire:click="hideModal"
                    class="flex-1 rounded-md px-4 py-2 text-sm border border-gray-300 text-gray-700 hover:bg-gray-50 transition-colors">
                    Belum Siap
                </button>
                <button wire:click="completeOrder({{ $selectedOrderId }})"
                    class="flex-1 rounded-md px-4 py-2 text-sm bg-green-600 text-white hover:bg-green-700 transition-colors">
                    Siap Antar
                </button>
            </div>
        </div>
    </div>
</div>

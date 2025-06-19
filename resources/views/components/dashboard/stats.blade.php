<div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3 px-6">
    <div class="rounded-lg bg-white p-6 shadow">
        <h3 class="text-sm font-medium text-gray-500">Pendapatan Hari Ini</h3>
        <p class="mt-2 text-3xl font-bold text-gray-800">
            {{ 'Rp ' . number_format($revenueToday, 0, ',', '.') }}
        </p>
    </div>
    <div class="rounded-lg bg-white p-6 shadow">
        <h3 class="text-sm font-medium text-gray-500">Transaksi Berhasil</h3>
        <p class="mt-2 text-3xl font-bold text-gray-800">
            {{ $transactionsToday }}
        </p>
    </div>
    <div class="rounded-lg bg-white p-6 shadow">
        <h3 class="text-sm font-medium text-gray-500">Item Terjual</h3>
        <p class="mt-2 text-3xl font-bold text-gray-800">
            {{ $itemsSoldToday }}
        </p>
    </div>
</div>

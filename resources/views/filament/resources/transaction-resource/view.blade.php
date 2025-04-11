<x-filament::page>
    <div class="space-y-6">
        <div class="text-xl font-bold">Detail Transaksi</div>

        <div>
            <p><strong>Nama Kasir:</strong> {{ $record->user->name ?? '-' }}</p>
            <p><strong>Waktu Transaksi:</strong>
                {{ \Carbon\Carbon::parse($record->waktu_transaksi)->format('d M Y H:i') }}
            </p>
            <p><strong>Total Harga:</strong> Rp{{ number_format($record->total_harga, 0, ',', '.') }}</p>
        </div>

        <div class="mt-6">
            <h2 class="text-md font-semibold">Menu yang Dibeli:</h2>

            <table class="mt-2 w-full border text-sm dark:border-gray-700">
                <thead class="bg-gray-100 dark:bg-gray-800">
                    <tr>
                        <th class="border px-3 py-2 dark:border-gray-700">Nama Menu</th>
                        <th class="border px-3 py-2 dark:border-gray-700">Harga</th>
                        <th class="border px-3 py-2 dark:border-gray-700">Jumlah</th>
                        <th class="border px-3 py-2 dark:border-gray-700">Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($record->detail_transactions as $detail)
                        <tr>
                            <td class="border px-3 py-2 dark:border-gray-700">{{ $detail->menu->name }}</td>
                            <td class="border px-3 py-2 dark:border-gray-700">
                                Rp{{ number_format($detail->unit_price, 0, ',', '.') }}</td>
                            <td class="border px-3 py-2 dark:border-gray-700">{{ $detail->quantity }}</td>
                            <td class="border px-3 py-2 dark:border-gray-700">
                                Rp{{ number_format($detail->subtotal, 0, ',', '.') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-filament::page>

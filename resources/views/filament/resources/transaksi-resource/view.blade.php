<x-filament::page>
    <div class="space-y-6">
        <div class="text-xl font-bold">Detail Transaksi</div>

        <div>
            <p><strong>Nama Kasir:</strong> {{ $record->user->name ?? '-' }}</p>
            <p><strong>Waktu Transaksi:</strong>
                {{ \Carbon\Carbon::parse($record->waktu_transaksi)->format('d M Y H:i') }}
            </p>
            <p><strong>Total Hargaaa:</strong> Rp{{ number_format($record->total_harga, 0, ',', '.') }}</p>
        </div>

        <div class="mt-6">
            <h2 class="text-md font-semibold">Menu yang Dibeli:</h2>

            <table class="w-full mt-2 text-sm border">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="border px-3 py-2">Nama Menu</th>
                        <th class="border px-3 py-2">Harga</th>
                        <th class="border px-3 py-2">Jumlah</th>
                        <th class="border px-3 py-2">Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($record->detail_transaksis as $detail)
                    <tr>
                        <td class="border px-3 py-2">{{ $detail->menu->nama_menu }}</td>
                        <td class="border px-3 py-2">Rp{{ number_format($detail->menu->harga, 0, ',', '.') }}</td>
                        <td class="border px-3 py-2">{{ $detail->jumlah }}</td>
                        <td class="border px-3 py-2">Rp{{ number_format($detail->subtotal, 0, ',', '.') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-filament::page>
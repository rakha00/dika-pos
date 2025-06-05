<x-layouts.app>
    <div class="w-[80mm] mx-auto p-2 border border-gray-300 text-xs font-sans">
        <div class="text-center font-bold text-lg mb-2">Struk Pembelian</div>
        <div class="text-center text-sm">Tanggal: {{ $transaction->created_at->format('d M Y, H:i') }}</div>
        <div class="text-center text-sm">Transaksi ID: {{ $transaction->transaction_id }}</div>

        <div class="border-t border-dashed border-gray-400 my-2"></div>

        @foreach ($transaction->detailTransactions as $detail)
            <div class="flex justify-between text-sm mb-1">
                <span class="font-semibold">{{ $detail->menu->name }} ({{ $detail->quantity }}x)</span>
                <span>Rp{{ number_format($detail->subtotal, 0, ',', '.') }}</span>
            </div>
            @if ($detail->grouped_custom_options_by_item_index->isNotEmpty())
                @foreach ($detail->grouped_custom_options_by_item_index as $itemIndex => $optionsInGroup)
                    <div class="ml-4 text-gray-600 text-xs">
                        <p>#{{ $itemIndex + 1 }}</p>
                        @foreach ($optionsInGroup as $customOptionEntry)
                            <p>+ {{ $customOptionEntry->customOption->value }}
                                (Rp{{ number_format($customOptionEntry->customOption->additional_price, 0, ',', '.') }})
                            </p>
                        @endforeach
                    </div>
                @endforeach
            @endif
        @endforeach

        <div class="border-t border-dashed border-gray-400 my-2"></div>

        <div class="flex justify-between font-bold text-sm">
            <span>Subtotal:</span>
            <span>Rp{{ number_format($transaction->total_price / 1.1, 0, ',', '.') }}</span>
        </div>
        <div class="flex justify-between text-sm">
            <span>PPN (10%):</span>
            <span>Rp{{ number_format($transaction->total_price - $transaction->total_price / 1.1, 0, ',', '.') }}</span>
        </div>

        <div class="border-t border-dashed border-gray-400 my-2"></div>

        <div class="flex justify-between font-bold text-sm">
            <span>Total:</span>
            <span>Rp{{ number_format($transaction->total_price, 0, ',', '.') }}</span>
        </div>
        <div class="flex justify-between text-sm">
            <span>Tunai:</span>
            <span>Rp{{ number_format($transaction->cash_amount, 0, ',', '.') }}</span>
        </div>
        <div class="flex justify-between text-sm">
            <span>Kembalian:</span>
            <span>Rp{{ number_format($transaction->cash_amount - $transaction->total_price, 0, ',', '.') }}</span>
        </div>

        <div class="border-t border-dashed border-gray-400 my-2"></div>
        <p class="text-center font-medium">Terima Kasih!</p>
    </div>

    <script>
        window.onload = function() {
            window.print();
            window.onafterprint = function() {
                window.close();
            };
        };
    </script>
</x-layouts.app>

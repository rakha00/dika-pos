<table>
    <tr>
        <td colspan="4" style="font-size: 16px; font-weight: bold;"><strong>Laporan Penjualan Bulanan</strong></td>
    </tr>
    <tr>
        <td colspan="4"></td>
    </tr>
    <tr>
        <td><strong>Periode</strong></td>
        <td colspan="3">: {{ $month_name }} {{ $year }}</td>
    </tr>
    <tr>
        <td><strong>Total Pendapatan</strong></td>
        <td colspan="3">: Rp {{ number_format($total_revenue, 0, ',', '.') }}</td>
    </tr>
    <tr>
        <td><strong>Jumlah Transaksi</strong></td>
        <td colspan="3">: {{ $total_transactions }} Transaksi</td>
    </tr>
    <tr>
        <td colspan="4"></td>
    </tr>
</table>

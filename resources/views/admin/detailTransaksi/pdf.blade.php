<!DOCTYPE html>
<html>

<head>
    <title>Laporan Transaksi</title>
</head>

<body>
    <h2>Laporan Transaksi</h2>
    <h5>{{ $startDate }} hingga {{ $endDate }}</h5>
    <table width="100%" border="1" cellpadding="5" cellspacing="0">
        <thead>
            <tr>
                <th>ID</th>
                <th>Tanggal</th>
                <th>Nama Barang</th>
                <th>Jumlah</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($transactions as $transaksi)
                <tr>
                    <td>{{ $transaksi->detail_id }}</td>
                    <td>{{ $transaksi->transaksi->tanggal ?? 'N/A' }}</td>
                    <td>{{ $transaksi->barang->nama_barang ?? 'N/A' }}</td>
                    <td>{{ $transaksi->jumlah }}</td>
                    <td>{{ number_format($transaksi->subtotal, 2) }}</td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <th colspan="4" style="text-align:left">Total</th>
                <th>{{ number_format($totalSubtotal, 2) }}</th>
            </tr>
        </tfoot>
    </table>
</body>

</html>

<!-- resources/views/kasir/nota.blade.php -->
@extends('layouts.notaMaster')

@section('title', 'Nota Transaksi')

@section('nota-header')
    <div class="text-center">
        <h4>HappyMart</h4>
        <p>Jl. Mastrip No.123, Tulungagung, Indonesia</p>
        <hr>
    </div>
@endsection

@section('nota-content')
    <div>
        <p><strong>Tanggal: </strong>{{ $transaksi->tanggal->format('d-m-Y H:i') }}</p>
        <p><strong>Kode Transaksi: </strong>{{ $transaksi->transaksi_id }}</p>
        <p><strong>Kasir: </strong>{{ $transaksi->pengguna->name }}</p>
    </div>

    <hr>

    <table class="table table-sm">
        <thead>
            <tr>
                <th>Nama Barang</th>
                <th>Jumlah</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($transaksi->detailTransaksi as $detail)
                <tr>
                    <td>{{ $detail->barang->nama_barang }}</td>
                    <td>{{ $detail->jumlah }}</td>
                    <td>Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <hr>

    <div>
        <p><strong>Subtotal: </strong>Rp {{ number_format($transaksi->total_harga, 0, ',', '.') }}</p>
        <p><strong>Diskon: </strong>Rp {{ number_format($transaksi->diskon, 0, ',', '.') }}</p>
        <p><strong>Total Bayar: </strong>Rp {{ number_format($transaksi->total_harga - $transaksi->diskon, 0, ',', '.') }}
        </p>
        <p><strong>Metode Pembayaran: </strong>{{ ucfirst($transaksi->metode_pembayaran) }}</p>
    </div>
@endsection

@section('nota-footer')
    <div class="nota-footer">
        <p>Terima kasih telah berbelanja di HappyMart!</p>
    </div>
@endsection

@push('scripts')
    <script>
        window.onload = function() {
            window.print();
        }
    </script>
@endpush

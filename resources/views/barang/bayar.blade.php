@extends('layouts.master')

@section('title', 'Pembayaran')

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="d-flex justify-content-between">
            <!-- Pindahkan Transaksi # ke sebelah kiri -->
            <h2>Transaksi #: 123</h2>
        </div>
        <p><strong>Waktu: </strong> <span id="waktu">10.00 WIB</span></p>
        
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Daftar Barang</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body table-responsive p-0">
                <table class="table table-hover text-nowrap">
                    <thead>
                        <tr>
                            <th>Barang</th>
                            <th>Harga</th>
                            <th>Jumlah</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Astor</td>
                            <td>Rp 10,000</td>
                            <td>1</td>
                            <td>Rp 10,000</td>
                        </tr>
                        <tr>
                            <td>Beng Beng</td>
                            <td>Rp 8,000</td>
                            <td>2</td>
                            <td>Rp 16,000</td>
                        </tr>
                        <!-- Tambahkan data lainnya di sini -->
                        <tr>
                            <td colspan="4" class="text-center">
                                <div class="tambah-barang">
                                    <i class="fas fa-plus fa-2x"></i>
                                    <p>Tambah Barang</p>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->

        <div class="d-flex justify-content-center mt-3">
            <button class="btn btn-danger btn-lg">Batalkan Transaksi</button>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card">
            <div class="card-body">
                <h4><strong>Jumlah Uang Harus Dibayar</strong></h4>
                <p class="text-left"><strong>Rp 26,000</strong></p>

                <hr>
                <p class="member-status">KARTU MEMBER VALID</p>

                <hr>
                
                <div class="payment-methods d-flex justify-content-around">
                    <div class="payment-option ">
                        <img src="{{ asset('img/cash.png') }}" alt="Cash" class="img-fluid">
                        <p>CASH</p>
                    </div>
                    <div class="payment-option">
                        <img src="{{ asset('img/card.png') }}" alt="Card" class="img-fluid">
                        <p>CARD</p>
                    </div>
                    <div class="payment-option">
                        <img src="{{ asset('img/e-wallet.png') }}" alt="E-Wallet" class="img-fluid">
                        <p>E-WALLET</p>
                    </div>
                </div>

                <hr>

                <div class="form-group">
                    <label for="uang-diberikan">Uang yang diberikan:</label>
                    <input type="text" id="uang-diberikan" class="form-control" placeholder="Rp .....">
                </div>
                
                <hr>
                
                <div class="d-flex justify-content-between mt-3">
                    <p><strong>Subtotal:</strong></p>
                    <p>Rp 26,000</p>
                </div>
                <div class="d-flex justify-content-between">
                    <p><strong>Diskon Member:</strong></p>
                    <p>Rp 1,000</p>
                </div>
                <div class="d-flex justify-content-between">
                    <p><strong>Pajak:</strong></p>
                    <p>Rp 0</p>
                </div>

                <hr>
                <div class="d-flex justify-content-between">
                    <h5><strong>Total:</strong></h5>
                    <h5>Rp 25,000</h5>
                </div>

                <button class="btn btn-success btn-block mt-3">KONFIRMASI</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    /* Menambahkan margin atau gap antara sidebar dan elemen utama */
    .content-wrapper {
        margin-left: 250px;
        padding: 15px;
    }
    /* Styling untuk layout pembayaran */
    .table {
        margin-top: 20px;
    }

    .btn-block {
        width: 100%;
        margin-bottom: 10px;
    }
    .member-status {
    text-align: center; /* Untuk membuat teks berada di tengah */
    color: rgb(10, 203, 10);      /* Mengubah warna teks menjadi hijau */
    font-weight: bold; /* Membuat teks tebal */
}

    #waktu {
        font-weight: bold;
        margin-bottom: 10px;
        font-size: 16px;
    }

    .card {
        margin-top: 20px;
    }

    .d-flex {
        margin-top: 20px;
    }

    /* Styling untuk tombol tambah barang */
    .tambah-barang {
        display: inline-flex;
        flex-direction: column;
        align-items: center;
        cursor: pointer;
    }

    .tambah-barang i {
        color: #007bff;
    }

    .tambah-barang p {
        margin-top: 10px;
        color: #007bff;
    }

    /* Sesuaikan warna dan padding */
    .btn-warning {
        background-color: #ffcc00;
        color: black;
        width: 48%;
    }

    .btn-danger {
        width: 48%;
    }
    .payment-methods {
    margin-top: 20px;
}

.payment-option {
    width: 100px;
    height: 100px;
    border-radius: 10px;
    border: 2px solid #ddd;
    text-align: center;
    padding: 10px;
    background-color: #f8f9fa;
    transition: background-color 0.3s ease;
}

.payment-option img {
    width: 50px;
    height: 50px;
}

.payment-option p {
    margin-top: 10px;
    font-size: 14px;
    font-weight: bold;
    color: #666;
}

.payment-option.active {
    background-color: #e9f5fc;
    border-color: #007bff;
    color: #007bff;
}

.payment-option:hover {
    background-color: #e9f5fc;
    border-color: #007bff;
    cursor: pointer;
}

</style>
@endpush

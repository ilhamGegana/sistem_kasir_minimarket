@extends('layouts.master')

@section('title', 'Pembayaran')

@section('content')
    <div class="row">
        <div class="col-md-8">
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @elseif (session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            <div class="d-flex justify-content-between">
                <h2>Transaksi oleh: {{ auth()->check() ? auth()->user()->nama : 'Pengguna Tidak Diketahui' }}</h2>
            </div>
            <p><strong>Waktu: </strong><span id="transaction-time"></span></p>

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
                            @if (!empty($keranjang) && count($keranjang) > 0)
                                @foreach ($keranjang as $item)
                                    <tr>
                                        <td>{{ $item['nama'] }}</td>
                                        <td>Rp {{ number_format($item['harga'], 0, ',', '.') }}</td>
                                        <td>{{ $item['jumlah'] }}</td>
                                        <td>Rp {{ number_format($item['harga'] * $item['jumlah'], 0, ',', '.') }}</td>
                                    </tr>
                                @endforeach
                                <tr>
                                    <td colspan="4" class="text-center">
                                        <a href="{{ route('kasir.index') }}" class="btn btn-lg btn-outline-primary">
                                            <i class="fas fa-plus fa-2x"></i>
                                            <p>Tambah Barang</p>
                                        </a>
                                    </td>
                                </tr>
                            @else
                                <tr>
                                    <td colspan="4" class="text-center">Keranjang kosong</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->

            <div class="d-flex justify-content-center mt-3">
                <form action="{{ route('keranjang.clear') }}" method="POST" style="width: 100%;">
                    @csrf
                    <button type="submit" class="btn btn-danger btn-lg tombol-custom">Batalkan Transaksi</button>
                </form>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <div class="form-group">
                        <label for="nomor-member"><strong>Masukkan Nomor Kartu Member (Jika ada)</strong></label>
                        <input type="text" name="nomor_member" id="nomor_member" class="form-control mb-2"
                            placeholder="........." value="{{ session('nomor_member') }}">
                        <button type="button" class="btn btn-primary" id="cek-member">Cek Member</button>
                        <hr>
                        <!-- Status Kartu Member -->
                        <p class="member-status {{ session('member_status_class', 'text-muted') }}" id="member-status">
                            {{ session('member_status', 'STATUS') }}</p>
                    </div>

                    <hr>

                    <div class="payment-methods d-flex justify-content-around">
                        <div class="payment-option" id="cash">
                            <img src="{{ asset('img/cash.png') }}" alt="Cash" class="img-fluid">
                            <p>CASH</p>
                        </div>
                        <div class="payment-option" id="card">
                            <img src="{{ asset('img/card.png') }}" alt="Card" class="img-fluid">
                            <p>CARD</p>
                        </div>
                        <div class="payment-option" id="e_wallet">
                            <img src="{{ asset('img/e-wallet.png') }}" alt="E-Wallet" class="img-fluid">
                            <p>E-WALLET</p>
                        </div>
                    </div>

                    <hr>

                    <div class="form-group" id="uang-diberikan-container" style="display: none;">
                        <label for="uang-diberikan">Uang yang diberikan:</label>
                        <input type="text" id="uang-diberikan" class="form-control" placeholder="Rp ....">
                    </div>

                    <div class="form-group" id="kembalian-container" style="display: none;">
                        <label for="kembalian">Kembalian:</label>
                        <input type="text" id="kembalian" class="form-control" readonly>
                    </div>

                    <hr>

                    <div class="d-flex justify-content-between mt-3">
                        <p><strong>Subtotal:</strong></p>
                        <p>Rp {{ number_format($subtotal, 0, ',', '.') }}</p>
                    </div>
                    <div class="d-flex justify-content-between">
                        <p><strong>Diskon Member:</strong></p>
                        <p id="diskon-member">
                            Rp {{ session('discount') ? number_format(session('discount'), 0, ',', '.') : '0' }}
                        </p>
                    </div>
                    <div class="d-flex justify-content-between">
                        <h5><strong>Total:</strong></h5>
                        <h5 id="total-harga">Rp {{ number_format($subtotal - session('discount', 0), 0, ',', '.') }}</h5>
                    </div>


                    <button class="btn btn-success btn-block mt-3" id="btn-konfirmasi">KONFIRMASI</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/bayar.css') }}">
@endpush
@push('scripts')
    <script>
        $(document).ready(function() {
            $('#cek-member').click(function() {
                // Ambil nomor member dan subtotal dari halaman
                var nomor_member = $('#nomor_member').val();
                var subtotal = {{ $subtotal }};

                // Kirim request AJAX ke server
                $.ajax({
                    url: "{{ route('check.member') }}",
                    method: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        nomor_member: nomor_member,
                        subtotal: subtotal
                    },
                    success: function(response) {
                        // Update status kartu member
                        $('#member-status').text(response.member_status);
                        $('#member-status').removeClass('text-muted text-danger text-success')
                            .addClass(response.member_status_class);

                        // Update diskon dan total harga
                        $('#diskon-member').text('Rp ' + response.diskon);
                        $('#total-harga').text('Rp ' + response.total);
                    },
                    error: function(xhr) {
                        console.error(xhr.responseText);
                    }
                });
            });

            // Event ketika metode pembayaran dipilih
            function storePaymentMethod(method, uangDiberikan = 0) {
                var subtotal = {{ $subtotal }};

                $.ajax({
                    url: "{{ route('kasir.storePaymentMethod') }}",
                    method: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        metode_pembayaran: method,
                        subtotal: subtotal,
                        uang_diberikan: uangDiberikan
                    },
                    success: function(response) {
                        // Update tampilan metode pembayaran yang dipilih
                        $('.payment-option').removeClass('active');
                        $('#' + response.metode_pembayaran).addClass('active');

                        // Jika metode "cash", update kembalian
                        if (response.metode_pembayaran === 'cash') {
                            $('#kembalian').val('Rp ' + response.kembalian);
                            $('#uang-diberikan-container').show();
                            $('#kembalian-container').show();
                        } else {
                            $('#uang-diberikan-container').hide();
                            $('#kembalian-container').hide();
                        }
                    },
                    error: function(xhr) {
                        console.error(xhr.responseText);
                    }
                });
            }

            // Event listener ketika metode pembayaran dipilih
            $('.payment-option').click(function() {
                var method = $(this).attr('id');
                storePaymentMethod(method);
            });

            // Event listener untuk input uang yang diberikan jika metode "CASH"
            $('#uang-diberikan').on('input', function() {
                var uangDiberikan = parseFloat($(this).val().replace(/[^0-9]/g, '')) || 0;
                storePaymentMethod('cash', uangDiberikan);
            });

            // Cek apakah ada metode pembayaran yang disimpan di session saat reload
            var metode_pembayaran = "{{ session('metode_pembayaran') }}";
            if (metode_pembayaran) {
                storePaymentMethod(metode_pembayaran);
            }
        });
        $('#btn-konfirmasi').click(function() {
            $.ajax({
                url: "{{ route('kasir.prosesTransaksi') }}",
                method: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                },
                success: function(response) {
                    // Jika transaksi berhasil, redirect atau tampilkan pesan sukses
                    window.location.href = "{{ route('kasir.index') }}";
                },
                error: function(xhr) {
                    console.error(xhr.responseText);
                    alert("Terjadi kesalahan saat menyimpan transaksi.");
                }
            });
        });

        function updateTransactionTime() {
            var now = new Date();
            var formattedTime = now.toLocaleTimeString('id-ID', {
                hour: '2-digit',
                minute: '2-digit'
            }) + " WIB";
            document.getElementById('transaction-time').innerText = formattedTime;
        }
        setInterval(updateTransactionTime, 1000);
        updateTransactionTime(); // Panggil langsung untuk memulai saat halaman dimuat
    </script>
@endpush

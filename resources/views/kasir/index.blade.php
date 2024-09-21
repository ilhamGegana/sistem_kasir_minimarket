@extends('layouts.master')

@section('title', 'Pilih Barang')

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


            <h2>Pilih Barang Yang Dibeli</h2>
            <form method="GET" action="{{ route('kasir.index') }}">
                <div class="mb-3">
                    <label for="filter-kategori" class="form-label">Filter Kategori:</label>
                    <select id="filter-kategori" class="form-control" name="kategori_id" onchange="this.form.submit()">
                        <option value="">Semua Kategori</option>
                        @foreach ($kategori as $k)
                            <option value="{{ $k->kategori_id }}"
                                {{ request('kategori_id') == $k->kategori_id ? 'selected' : '' }}>
                                {{ $k->nama_kategori }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </form>
            <table id="example1" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Barang</th>
                        <th>Kategori</th>
                        <th>Stok</th>
                        <th>Harga</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($barang as $b)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $b->nama_barang }}</td>
                            <td>{{ $b->kategori->nama_kategori }}</td>
                            <td>{{ $b->stok }}</td>
                            <td>Rp {{ number_format($b->harga, 0, ',', '.') }}</td>
                            <td>
                                <form action="{{ route('kasir.tambahKeKeranjang') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="barang_id" value="{{ $b->barang_id }}">
                                    <button type="submit" class="btn btn-primary">Tambah</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="col-md-4">
            <div class="card" id="keranjang-belanja">
                <div class="card-body">
                    @if (session('nomor_member'))
                        <p><strong>Nomor Member : {{ session('nomor_member') }}</strong></p>
                    @endif

                    <hr>
                    <!-- List Barang -->
                    @if (session('keranjang'))
                        <div id="daftar-keranjang">
                            @php $subtotal = 0; @endphp
                            @foreach (session('keranjang') as $id => $item)
                                <div class="d-flex justify-content-between">
                                    <span>{{ $item['nama'] }}</span>
                                    <span>
                                        Rp {{ number_format($item['harga'], 0, ',', '.') }} x {{ $item['jumlah'] }}
                                        <button class="btn btn-sm btn-outline-secondary"
                                            onclick="updateKeranjang({{ $id }}, 'minus')">-</button>
                                        <button class="btn btn-sm btn-outline-secondary"
                                            onclick="updateKeranjang({{ $id }}, 'plus')">+</button>
                                    </span>
                                </div>
                                @php $subtotal += $item['harga'] * $item['jumlah']; @endphp
                            @endforeach
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between">
                            <p><strong>Subtotal:</strong></p>
                            <p id="subtotal">Rp {{ number_format($subtotal, 0, ',', '.') }}</p>
                        </div>
                        <div class="d-flex justify-content-between">
                            <h5><strong>Total:</strong></h5>
                            <h5 id="total">Rp {{ number_format($subtotal, 0, ',', '.') }}</h5>
                        </div>
                    @else
                        <div class="card-body text-center">
                            <p>BELUM ADA BARANG DIPILIH</p>
                            <i class="fas fa-shopping-cart fa-3x"></i>
                        </div>
                    @endif

                    <div class="mt-3 d-flex justify-content-between">
                        <form action="{{ route('keranjang.clear') }}" method="POST" style="width: 100%;">
                            @csrf
                            <button type="submit" class="btn tombol-custom tombol-batalkan">Batalkan</button>
                        </form>
                        <form action="{{ route('kasir.checkout') }}" method="GET" style="width: 100%;">
                            <button type="submit" class="btn tombol-custom tombol-konfirmasi">Konfirmasi</button>
                        </form>
                    </div>

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
            padding: 20px;
        }

        /* Pastikan elemen-elemen lain memiliki jarak yang konsisten */

        /* Custom styling for the cart */
        #daftar-keranjang {
            background-color: #f8f9fa;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 15px;
        }

        #daftar-keranjang .barang-item {
            display: flex;
            justify-content: space-between;
            padding: 8px 0;
            border-bottom: 1px solid #ddd;
        }

        #daftar-keranjang .barang-item:last-child {
            border-bottom: none;
        }

        /* Styling untuk tombol dengan lebar yang sama dan tampilan yang proporsional */
        .tombol-custom {
            width: 100%;
            /* Tetap membuat tombol memiliki lebar penuh */
            padding: 12px 0;
            /* Menambahkan padding atas dan bawah */
            font-size: 16px;
            /* Ukuran teks agar mudah dibaca */
            font-weight: bold;
            /* Membuat teks tebal */
            border-radius: 5px;
            /* Membuat sudut tombol melengkung */
            text-align: center;
            /* Pastikan teks berada di tengah */
            cursor: pointer;
            /* Gaya kursor menjadi pointer */
        }

        /* Warna tombol Batalkan dengan latar merah */
        .tombol-batalkan {
            background-color: #dc3545;
            color: white;
            border: none;
        }

        /* Warna tombol Konfirmasi dengan latar hijau */
        .tombol-konfirmasi {
            background-color: #28a745;
            color: white;
            border: none;
        }

        /* Hover effect untuk memberikan feedback saat tombol dihover */
        .tombol-batalkan:hover {
            background-color: #c82333;
        }

        .tombol-konfirmasi:hover {
            background-color: #218838;
        }

        /* Menambahkan jarak antara tombol */
        .d-flex {
            gap: 10px;
            /* Menambahkan jarak antar tombol */
        }
    </style>
@endpush

@push('scripts')
    <script>
        $(document).ready(function() {
            // Inisialisasi DataTables
            $('#example1').DataTable({
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
                "language": {
                    "paginate": {
                        "previous": "Previous",
                        "next": "Next"
                    },
                    "search": "Search:",
                    "lengthMenu": "Show _MENU_ entries",
                    "info": "Showing _START_ to _END_ of _TOTAL_ entries",
                }
            });
        });
        // Fungsi updateKeranjang
        function updateKeranjang(id, action) {
            $.ajax({
                url: '/kasir/update-keranjang/' + id,
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    action: action
                },
                success: function(response) {
                    location.reload();
                }
            });
        }
    </script>
@endpush

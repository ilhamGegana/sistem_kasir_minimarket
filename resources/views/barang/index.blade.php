@extends('layouts.master')

@section('title', 'Pilih Barang')

@section('content')
    <div class="row">
        <div class="col-md-8">
            <h2>Pilih Barang Yang Dibeli</h2>
            <form method="GET" action="{{ route('barang.index') }}">
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
                                <form action="{{ route('barang.tambahKeKeranjang') }}" method="POST">
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
                    <p><strong>Masukkan Nomor Kartu Member (Jika ada)</strong></p>
                    <input type="text" class="form-control mb-2" placeholder="123456AB">

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
                            <p><strong>Pajak:</strong></p>
                            <p id="pajak">Rp 0</p>
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
                        <button class="btn btn-danger btn-lg">Batalkan</button>
                        <button class="btn btn-success btn-lg">Konfirmasi</button>
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

        .btn-lg {
            width: 48%;
        }

        .tombol-batalkan {
            background-color: #ff5c5c;
            border-color: #ff5c5c;
        }

        .tombol-konfirmasi {
            background-color: #28a745;
            border-color: #28a745;
        }
    </style>
@endpush

@push('scripts')
    <script>
        // Fungsi updateKeranjang
        function updateKeranjang(id, action) {
            $.ajax({
                url: '/update-keranjang/' + id,
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

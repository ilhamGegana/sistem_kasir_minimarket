@extends('layouts.master')

@section('title', 'Pilih Barang')

@section('content')
<div class="row">
    <div class="col-md-8">
        <h2>Pilih Barang Yang Dibeli</h2>
        <div class="mb-3">
            <label for="filter-kategori" class="form-label">Filter Kategori:</label>
            <select id="filter-kategori" class="form-control">
                <option value="snack">Snack</option>
                <!-- Tambah kategori lainnya -->
            </select>
        </div>

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
                <tr>
                    <td>1</td>
                    <td>Astor</td>
                    <td>Snack</td>
                    <td>20</td>
                    <td>Rp 10,000</td>
                    <td><button class="btn btn-primary tambah-barang" data-nama="Astor" data-harga="10000">Tambah</button></td>
                </tr>
                <tr>
                    <td>2</td>
                    <td>Beng Beng</td>
                    <td>Snack</td>
                    <td>30</td>
                    <td>Rp 8,000</td>
                    <td><button class="btn btn-primary tambah-barang" data-nama="Beng Beng" data-harga="8000">Tambah</button></td>
                </tr>
                <!-- Tambah baris lainnya sesuai kebutuhan -->
            </tbody>
        </table>
    </div>

    <div class="col-md-4">
        <div class="card" id="keranjang-awal">
            <div class="card-body text-center">
                <p><strong>Masukkan Nomor Kartu Member (Jika ada)</strong></p>
                <input type="text" class="form-control mb-2" placeholder="123456AB">
                <p><strong>BELUM ADA BARANG DIPILIH</strong></p>
                <i class="fas fa-shopping-cart fa-3x"></i>
            </div>
        </div>

        <div class="card d-none" id="keranjang-belanja">
            <div class="card-body">
                <p><strong>Masukkan Nomor Kartu Member (Jika ada)</strong></p>
                <input type="text" class="form-control mb-2" placeholder="123456AB">
                
                <!-- List Barang -->
                <div id="daftar-keranjang">
                    <!-- Barang yang ditambahkan akan muncul di sini -->
                </div>
                
                <hr>
                <div class="d-flex justify-content-between">
                    <p><strong>Subtotal:</strong></p>
                    <p id="subtotal">Rp 0</p>
                </div>
                <div class="d-flex justify-content-between">
                    <p><strong>Pajak:</strong></p>
                    <p id="pajak">Rp 0</p>
                </div>
                <div class="d-flex justify-content-between">
                    <h5><strong>Total:</strong></h5>
                    <h5 id="total">Rp 0</h5>
                </div>

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
    /* Mengatur lebar sidebar */

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
    $(document).ready(function() {
        // Aktifkan DataTable
        $('#example1').DataTable();

        let subtotal = 0;
        let total = 0;

        // Event listener untuk setiap tombol tambah
        document.querySelectorAll('.tambah-barang').forEach(function(button) {
            button.addEventListener('click', function() {
                const namaBarang = this.getAttribute('data-nama');
                const hargaBarang = parseInt(this.getAttribute('data-harga'));

                // Ubah tampilan dari "BELUM ADA BARANG DIPILIH" ke tampilan keranjang
                document.getElementById('keranjang-awal').classList.add('d-none');
                document.getElementById('keranjang-belanja').classList.remove('d-none');

                // Tambahkan barang ke keranjang
                const itemKeranjang = document.createElement('div');
                itemKeranjang.classList.add('barang-item');
                itemKeranjang.innerHTML = `<span>${namaBarang}</span> <span>Rp ${hargaBarang.toLocaleString()}</span>`;
                document.getElementById('daftar-keranjang').appendChild(itemKeranjang);

                // Update subtotal dan total
                subtotal += hargaBarang;
                document.getElementById('subtotal').innerText = `Rp ${subtotal.toLocaleString()}`;
                total = subtotal;  // Untuk contoh ini, kita tidak menambahkan pajak atau biaya lainnya
                document.getElementById('total').innerText = `Rp ${total.toLocaleString()}`;
            });
        });
    });
</script>
@endpush

@extends('layouts.master')

@section('title', 'Kategori Barang')

@section('content')
<div class="row">
    <div class="col-md-12">
        <h2>Kategori Barang</h2>

        <!-- Input Kategori Baru -->
        <div class="mb-3">
            <label for="kode-kategori" class="form-label">Masukkan Kode Kategori Barang Baru</label>
            <div class="input-group mb-2">
                <input type="text" id="kode-kategori" class="form-control" placeholder="Masukkan Kode Kategori Barang Baru">
            </div>

            <label for="kategori-baru" class="form-label">Masukkan Kategori Barang Baru</label>
            <div class="input-group">
                <input type="text" id="kategori-baru" class="form-control" placeholder="Masukkan Kategori Barang Baru">
                <button class="btn btn-primary" id="insert-data">
                    <i class="fas fa-plus"></i> Insert Data
                </button>
            </div>
        </div>

        <!-- Tabel Kategori -->
        <div class="card">
            <div class="card-body table-responsive">
                <table id="kategori-table" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Kode Kategori</th>
                            <th>Kategori</th>
                            <th>Tanggal Input</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>ATK001</td>
                            <td>ATK</td>
                            <td>1 September 2024, 11:30</td>
                            <td>
                                <button class="btn btn-warning btn-sm">Edit</button>
                                <button class="btn btn-danger btn-sm">Hapus</button>
                            </td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>SBN002</td>
                            <td>Sabun</td>
                            <td>4 September 2024, 20:30</td>
                            <td>
                                <button class="btn btn-warning btn-sm">Edit</button>
                                <button class="btn btn-danger btn-sm">Hapus</button>
                            </td>
                        </tr>
                        <tr>
                            <td>3</td>
                            <td>SNK003</td>
                            <td>Snack</td>
                            <td>6 September 2024, 12:30</td>
                            <td>
                                <button class="btn btn-warning btn-sm">Edit</button>
                                <button class="btn btn-danger btn-sm">Hapus</button>
                            </td>
                        </tr>
                        <tr>
                            <td>4</td>
                            <td>MNM004</td>
                            <td>Minuman</td>
                            <td>10 September 2024, 06:30</td>
                            <td>
                                <button class="btn btn-warning btn-sm">Edit</button>
                                <button class="btn btn-danger btn-sm">Hapus</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    /* Styling untuk input data kategori */
    #insert-data {
        margin-left: 10px;
    }

    /* Ukuran kecil untuk tombol aksi Edit dan Hapus */
    .btn-sm {
        padding: 5px 10px;
        font-size: 14px;
    }

    /* Mengatur agar tabel tetap terlihat baik dalam mode responsif */
    .table {
        margin-top: 20px;
    }
</style>
@endpush

@push('scripts')
<script>
    $(document).ready(function() {
        // Fungsi untuk Insert Data (dummy action)
        $('#insert-data').on('click', function() {
            var kodeKategori = $('#kode-kategori').val();
            var kategoriBaru = $('#kategori-baru').val();
            
            if(kodeKategori !== '' && kategoriBaru !== '') {
                alert('Kategori ' + kategoriBaru + ' dengan kode ' + kodeKategori + ' berhasil ditambahkan!');
                $('#kode-kategori').val(''); // Mengosongkan input kode setelah tambah
                $('#kategori-baru').val(''); // Mengosongkan input kategori setelah tambah
            } else {
                alert('Kode Kategori dan Nama Kategori tidak boleh kosong!');
            }
        });
    });
</script>
@endpush

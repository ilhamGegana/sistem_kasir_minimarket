@extends('layouts.masteradmin')
@section('content')
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title">{{ $page->title }}</h3>
            <div class="card-tools"></div>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ url('admin/barang') }}">
                @csrf
                <div class="form-group">
                    <label>Kode Barang</label>
                    <input type="text" class="form-control" name="kode_barang" required>
                    @error('kode_barang')
                        <small class="form-text text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="form-group">
                    <label>Nama Barang</label>
                    <input type="text" class="form-control" name="nama_barang" required>
                    @error('nama_barang')
                        <small class="form-text text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="form-group">
                    <label>Kategori</label>
                    <select class="form-control" name="kategori_id" required>
                        @foreach($kategori as $k)
                            <option value="{{ $k->kategori_id }}">{{ $k->nama_kategori }}</option>
                        @endforeach
                    </select>
                    @error('kategori_id')
                        <small class="form-text text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="form-group">
                    <label>Harga</label>
                    <input type="number" class="form-control" name="harga" step="0.01" required>
                    @error('harga')
                        <small class="form-text text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="form-group">
                    <label>Stok</label>
                    <input type="number" class="form-control" name="stok" required>
                    @error('stok')
                        <small class="form-text text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </form>
                   
    </div>
</div>
@endsection
@push('css')
@endpush
@push('js')
@endpush

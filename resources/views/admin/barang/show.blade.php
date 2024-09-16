@extends('layouts.masteradmin')
@section('content')
    <div class="card card-outline card-primary">
        <div class="card-header"> 
            <h3 class="card-title">{{ $page->title }}</h3>
            <div class="card-tools">
                <a class="btn btn-sm btn-primary mt-1" href="{{ url('admin/barang') }}">Kembali</a>
            </div>
        </div>
        <div class="card-body">
            <div class="row mb-2">
                <div class="col-md-3">
                    <strong>Kode Barang</strong>
                </div>
                <div class="col-md-9">
                    {{ $databarang->kode_barang }}
                </div>
            </div>
            <div class="row mb-2">
                <div class="col-md-3">
                    <strong>Nama Barang</strong>
                </div>
                <div class="col-md-9">
                    {{ $databarang->nama_barang }}
                </div>
            </div>
            <div class="row mb-2">
                <div class="col-md-3">
                    <strong>Harga</strong>
                </div>
                <div class="col-md-9">
                    {{ $databarang->harga }}
                </div>
            </div>
            <div class="row mb-2">
                <div class="col-md-3">
                    <strong>Stok</strong>
                </div>
                <div class="col-md-9">
                    {{ $databarang->stok }}
                </div>
            </div>
        </div>
    </div>
@endsection

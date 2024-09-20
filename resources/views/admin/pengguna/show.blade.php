@extends('layouts.masteradmin')
@section('content')
    <div class="card card-outline card-primary">
        <div class="card-header"> 
            <h3 class="card-title">{{ $page->title }}</h3>
            <div class="card-tools">
                <a class="btn btn-sm btn-primary mt-1" href="{{ url('admin/pengguna') }}">Kembali</a>
            </div>
        </div>
        <div class="card-body">
            <div class="row mb-2">
                <div class="col-md-3">
                    <strong>Username</strong>
                </div>
                <div class="col-md-9">
                    {{ $pengguna->username }}
                </div>
            </div>
            <div class="row mb-2">
                <div class="col-md-3">
                    <strong>Nama</strong>
                </div>
                <div class="col-md-9">
                    {{ $pengguna->nama }}
                </div>
            </div>
            <div class="row mb-2">
                <div class="col-md-3">
                    <strong>Role</strong>
                </div>
                <div class="col-md-9">
                    {{ $pengguna->role }}
                </div>
            </div>
        </div>
    </div>
@endsection

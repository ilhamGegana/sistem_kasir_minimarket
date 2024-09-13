@extends('layouts.masteradmin')
@section('content')
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title">{{ $page->title }}</h3>
            <div class="card-tools"></div>
        </div>
        <div class="card-body">
            @empty($member)
                <div class="alert alert-danger alert-dismissible">
                    <h5><i class="icon fas fa-ban"></i> Kesalahan!</h5>
                    Data yang Anda cari tidak ditemukan.
                </div>
            @else
                <table class="table table-bordered table-striped table-hover tablesm">
                    <tr>
                        <th>ID</th>
                        <td>{{ $member->member_id }}</td>
                    </tr>
                    <tr>
                        <th>Nomor Member</th>
                        <td>{{ $member->nomor_member }}</td>
                    </tr>
                    <tr>
                        <th>Nama Member</th>
                        <td>{{ $member->nama_member }}</td>
                    </tr>
                    <tr>
                        <th>Nomor Telepon</th>
                        <td>{{ $member->no_telepon }}</td>
                    </tr>
                    <tr>
                        <th>Tanggal Daftar</th>
                        <td>{{ $member->tanggal_daftar }}</td>
                    </tr>
                    <tr>
                        <th>Tanggal Expired</th>
                        <td>{{ $member->tanggal_expired }}</td>
                    </tr>
                    <tr>
                        <th>Status</th>
                        <td>{{ $member->status }}</td>
                    </tr>
                </table>
            @endempty
            <a href="{{ url('admin/member') }}" class="btn btn-sm btn-default mt2">Kembali</a>
        </div>
    </div>
@endsection
@push('styles')
@endpush
@push('scripts')
@endpush

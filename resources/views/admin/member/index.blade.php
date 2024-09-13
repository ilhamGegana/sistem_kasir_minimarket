@extends('layouts.masteradmin')
@section('content')
<div class="card card-outline card-primary">
    <div class="card-header">
        <h3 class="card-title">{{ $page->title }}</h3>
        <div class="card-tools">
            <a class="btn btn-sm btn-primary mt-1" href="{{ url('admin/member/create') }}">Tambah</a>
        </div>
    </div>
        <div class="card-body">
            <table class="table table-bordered table-striped table-hover table-sm" id="table_member">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nomor Member</th>
                        <th>Nama Member</th>
                        <th>No Telepon</th>
                        <th>Tanggal Daftar</th>
                        <th>Tanggal Expired</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
@endsection
@push('styles')
@endpush
@push('scripts')
    <script>
        $(document).ready(function() {
            var dataUser = $('#table_member').DataTable({
                // serverSide: true, jika ingin menggunakan server side processing
                serverSide: true,
                ajax: {
                    "url": "{{ url('admin/member/list') }}",
                    "dataType": "json",
                    "type": "POST"
                },
                columns: [{
                    // nomor urut dari laravel datatable addIndexColumn()
                    data: "DT_RowIndex",
                    className: "text-center",
                    orderable: false,
                    searchable: false
                }, {
                    data: "nomor_member",
                    className: "",
                    // orderable: true, jika ingin kolom ini bisa diurutkan
                    orderable: true,
                    // searchable: true, jika ingin kolom ini bisa dicari
                    searchable: true
                }, {
                    data: "nama_member",
                    className: "",
                    orderable: true,
                    searchable: true
                },{
                    data: "no_telepon",
                    className: "",
                    orderable: true,
                    searchable: true
                },{
                    data: "tanggal_daftar",
                    className: "",
                    orderable: true,
                    searchable: true
                },{
                    data: "tanggal_expired",
                    className: "",
                    orderable: true,
                    searchable: true
                },{
                    data: "status",
                    className: "",
                    orderable: true,
                    searchable: true
                },{
                    data: "aksi",
                    className: "",
                    orderable: false,
                    searchable: false
                }]
            });

        });
    </script>
@endpush

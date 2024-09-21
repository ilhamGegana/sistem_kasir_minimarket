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
                <a href="{{ url('admin/member') }}" class="btn btn-sm btn-default mt2">Kembali</a>
            @else
                <form method="POST" action="{{ url('/admin/member/' . $member->member_id) }}" class="form-horizontal">
                    @csrf
                    {!! method_field('PUT') !!} <!-- tambahkan baris ini untuk proses edit
        yang butuh method PUT -->
                    <div class="form-group row">
                        <label class="col-1 control-label col-form-label">Nomor Member</label>
                    <div class="col-11">
                        <input type="text" class="form-control" id="nomor_member" name="nomor_member"
                            value="{{ old('nomor_member') }}" required>
                        @error('nomor_member')
                            <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-1 control-label col-form-label">Nama Member</label>
                    <div class="col-11">
                        <input type="text" class="form-control" id="nama_member" name="nama_member"
                            value="{{ old('nama_member') }}" required>
                        @error('nama_member')
                            <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-1 control-label col-form-label">No Telepon</label>
                    <div class="col-11">
                        <input type="text" class="form-control" id="no_telepon" name="no_telepon"
                            value="{{ old('no_telepon') }}" required>
                        @error('no_telepon')
                            <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-1 control-label col-form-label">Tanggal Expired</label>
                    <div class="col-11">
                        <input type="date" class="form-control" id="tanggal_expired" name="tanggal_expired"
                            value="{{ old('tanggal_expired') }}" required>
                        @error('tanggal_expired')
                            <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>                
                <div class="form-group row">
                    <label class="col-1 control-label col-form-label">Status</label>
                    <div class="col-11">
                        <input type="text" class="form-control" id="status" name="status"
                            value="{{ old('status') }}" required>
                        @error('status')
                            <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-1 control-label col-form-label"></label>
                    <div class="col-11">
                        <button type="submit" class="btn btn-primary btn-sm">Simpan</button>
                        <a class="btn btn-sm btn-default ml-1" href="{{ url('admin/member') }}">Kembali</a>
                    </div>
                </div>
                </form>
            @endempty
        </div>
    </div>
@endsection
@push('styles')
@endpush
@push('scripts')
@endpush

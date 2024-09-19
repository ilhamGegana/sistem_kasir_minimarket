<!-- resources/views/auth/login.blade.php -->
@extends('layouts.authMaster')

@section('title', 'Login | HappyMart')

@section('login-image')
    <!-- Bagian gambar pada halaman login -->
    <img src="{{ asset('img/store-login.png') }}" alt="Store Image">
@endsection

@section('login-form')
    <div class="login-box">
        <div class="card card-outline card-primary">
            <div class="card-header text-center">
                <a href="#" class="h1"><b>Happy</b>Mart</a>
            </div>
            <div class="card-body">
                <p class="login-box-msg">Login untuk masuk ke sistem</p>
                <form action="{{ route('login') }}" method="post">
                    @csrf
                    <div class="input-group mb-3">
                        <input type="text" name="username" class="form-control" placeholder="Masukkan Username" required>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-user"></span>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <input type="password" name="password" class="form-control" placeholder="Masukkan Password"
                            required>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-8">
                            <div class="icheck-primary">
                                <input type="checkbox" id="remember" name="remember">
                                <label for="remember">Ingat Saya</label>
                            </div>
                        </div>
                        <div class="col-4">
                            <button type="submit" class="btn btn-primary btn-block">Log In</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    
@endpush

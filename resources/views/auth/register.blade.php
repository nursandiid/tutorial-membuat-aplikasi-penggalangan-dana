@extends('layouts.guest')

@section('title', 'Register')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="d-none d-md-flex col-md-4 col-lg-6 bg-image"></div>

        <div class="col-md-8 col-lg-6">
            <div class="login d-flex align-items-center py-5">
                <div class="container">
                    <div class="row">
                        <div class="col-md-9 col-lg-8 mx-auto">
                            <a href="{{ url('/') }}">
                                <img src="{{ asset('/img/logo.png') }}" alt="" class="w-50 mb-4">
                            </a>
                            <h4 class="login-heading mb-4">Silahkan Lengkapi Form Registrasi!</h4>

                            {{-- Form --}}
                            <form action="{{ route('register') }}" method="post">
                                @csrf

                                <div class="form-group mb-3">
                                    <label for="name">Nama</label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}">

                                    @error('name')
                                    <span class="invalid-feedback">
                                        {{ $message }}
                                    </span>
                                    @enderror
                                </div>
                                <div class="form-group mb-3">
                                    <label for="email">Email</label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}">

                                    @error('email')
                                    <span class="invalid-feedback">
                                        {{ $message }}
                                    </span>
                                    @enderror
                                </div>
                                <div class="form-group mb-3">
                                    <label for="password">Password</label>
                                    <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password">

                                    @error('password')
                                    <span class="invalid-feedback">
                                        {{ $message }}
                                    </span>
                                    @enderror
                                </div>
                                <div class="form-group mb-3">
                                    <label for="password_confirmation">Konfirmasi Password</label>
                                    <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror" id="password_confirmation" name="password_confirmation">

                                    @error('password_confirmation')
                                    <span class="invalid-feedback">
                                        {{ $message }}
                                    </span>
                                    @enderror
                                </div>

                                <div>
                                    <button class="btn btn-lg btn-primary btn-login mb-2">
                                        <i class="fas fa-sign-in-alt"></i> Daftar
                                    </button>
                                </div>

                                <div class="text-center mt-3">
                                    <div class="text-muted">
                                        Sudah punya akun silahkan login
                                        <a href="{{ route('login') }}" class="text-muted">disini</a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
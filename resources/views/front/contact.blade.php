@extends('layouts.front')

@section('title', 'Kontak')

@push('css')
<style>
    @media (max-width: 575.98px) {
        .text-lg {
            font-size: 18px;
        }
    }
</style>
@endpush

@section('content')
{{-- Banner --}}
<div class="banner bg-charity2">
    <div class="container">
        <h2 class="fa-2x text-white">Kontak</h2>
    </div>
</div>

{{-- Punya Pertanyaan --}}
<div class="punya-pertanyaan bg-white">
    <div class="container py-5">
        <div class="row">
            <div class="col-lg-12 text-center">
                <h2 class="display-5 mb-4">Punya Pertanyaan?</h2>
                <p class="mb-5 text-lg">
                    Lorem ipsum dolor sit amet consectetur adipisicing elit. Doloribus, sunt.
                    <br>
                    amet consectetur adipisicing elit. Quibusdam, neque!
                </p>
            </div>
            <div class="col-lg-4 text-center">
                <p class="icon">
                    <i class="fas fa-phone fa-2x"></i>
                </p>
                <p class="font-weight-bold mb-1">Hubungi Kami</p>
                <p class="text mb-0">{{ $setting->phone }}</p>
            </div>
            <div class="col-lg-4 text-center">
                <p class="icon">
                    <i class="fas fa-map-marker-alt fa-2x"></i>
                </p>
                <p class="font-weight-bold mb-1">Alamat</p>
                <p class="text mb-0">{{ $setting->address }} <br>{{ $setting->city }}, {{ $setting->province }}</p>
            </div>
            <div class="col-lg-4 text-center">
                <p class="icon">
                    <i class="fas fa-envelope fa-2x"></i>
                </p>
                <p class="font-weight-bold mb-1">Email</p>
                <p class="text mb-0">{{ $setting->email }}</p>
            </div>
        </div>
    </div>
</div>

{{-- Form Kontak --}}
<div class="form-kontak">
    <div class="container py-5">
        <div class="row">
            <div class="col-lg-12 text-center">
                <h2 class="display-5 mb-4">Kontak Kami</h2>
                <p class="mb-5 text-lg">
                    Lorem ipsum dolor sit amet consectetur adipisicing elit. Doloribus, sunt.
                    <br>
                    amet consectetur adipisicing elit. Quibusdam, neque!
                </p>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-lg-8">
                <form action="{{ url('/contact') }}" method="post">
                    @csrf

                    <div class="form-group">
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" placeholder="Masukan nama" value="{{ old('name') }}">
                        @error('name')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror" placeholder="Masukan no telepon" value="{{ old('phone') }}">
                        @error('phone')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" placeholder="Masukan email" value="{{ old('email') }}">
                                @error('email')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <input type="text" name="subject" class="form-control @error('subject') is-invalid @enderror" placeholder="Masukan subjek" value="{{ old('subject') }}">
                                @error('subject')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <textarea rows="5" name="message" class="form-control @error('message') is-invalid @enderror" placeholder="Masukan pesan">{{ old('message') }}</textarea>
                        @error('message')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="form-group text-right">
                        <button class="btn btn-primary">
                            <i class="fas fa-paper-plane"></i>
                            Kirim Pesan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
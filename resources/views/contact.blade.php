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
                <p class="text mb-0">0813-3243-3434</p>
            </div>
            <div class="col-lg-4 text-center">
                <p class="icon">
                    <i class="fas fa-map-marker-alt fa-2x"></i>
                </p>
                <p class="font-weight-bold mb-1">Alamat</p>
                <p class="text mb-0">Jl. Kibandang Samaran <br>Cirebon, Jawa Barat</p>
            </div>
            <div class="col-lg-4 text-center">
                <p class="icon">
                    <i class="fas fa-envelope fa-2x"></i>
                </p>
                <p class="font-weight-bold mb-1">Email</p>
                <p class="text mb-0">support@w2charity.com</p>
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
                <form action="">
                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="Masukan nama">
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="Masukan no telepon">
                    </div>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <input type="text" class="form-control" placeholder="Masukan email">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <input type="text" class="form-control" placeholder="Masukan subjek">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <textarea rows="5" class="form-control" placeholder="Masukan pesan"></textarea>
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
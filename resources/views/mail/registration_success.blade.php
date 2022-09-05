@extends('layouts.mail')
@section('title', 'Registrasi Sukses')

@section('content')
<div class="container py-3">
    <div class="row justify-content-center h-100 align-items-center">
        <div class="col-lg-7 col-md-8 col-12">
            <div class="card shadow-none mt-3 mx-2 mt-lg-0">
                <div class="card-body">
                    <div class="text-center">
                        <h1>Hi, {{ $user->name }}</h1>
                        <div class="logo my-4">
                            <img src="{{ url($setting->path_image ?? '#') }}" alt="logo" height="120">
                        </div>
                        <p>Sebelum Anda dapat login ke aplikasi silahkan konfirmasi terlebih dahulu akun Anda. Cukup klik tombol dibawah ini.</p>
                        <a href="{{ url("/user/$user->id/$token") }}" class="btn btn-primary my-4">Konfirmasi Akun</a>
                    </div>

                    <p class="mt-3">Jika itu tidak berhasil, salin dan tempel tautan berikut di browser Anda:</p>
                    <p><a href="{{ url("/user/$user->id/$token") }}">{{ url("/user/$user->id/$token") }}</a></p>
                    <p>Jika ada pertanyaan, cukup balas email ini, kami dengan senang hati membantu Anda.</p>
                    <p class="mb-0">
                        Hormat, <br>
                        {{ $setting->company_name }} Team
                    </p>
                </div>
            </div>

            <div class="card shadow-none bg-light-primary mx-2">
                <div class="card-body">
                    <p class="mb-0">
                        Butuh bantuan? <br>
                        <a href="{{ url('/contact') }}">Kami disini membantu Anda</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
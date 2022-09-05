@extends('layouts.mail')
@section('title', 'Terimakasih, '. $donation->user->name)

@section('content')
<div class="container py-3">
    <div class="row justify-content-center h-100 align-items-center">
        <div class="col-lg-7 col-md-8 col-12">
            <div class="card shadow-none mt-3 mx-2 mt-lg-0">
                <div class="card-body">
                    <div class="text-center">
                        <h1>Terimakasih, {{ $donation->user->name }}</h1>
                        <div class="logo my-4">
                            <img src="{{ url($setting->path_image ?? '#') }}" alt="logo" height="120">
                        </div>

                        <div class="detail d-flex justify-content-around align-items-center text-center mt-3 mt-lg-4">
                            <p>ID Transaksi #{{ $donation->order_number }}</p>
                            <p>Total Tagihan <strong>Rp. {{ format_uang($donation->nominal) }}</strong></p>
                        </div>

                        <div class="row justify-content-between mt-3 mt-lg-4">
                            @foreach ($bank as $item)
                            <div class="col-lg-4 text-center">
                                <img src="{{ asset($item->path_image) }}" alt="" class="w-100">
                                <p class="mt-3 text-muted">{{ $item->code }}</p>
                            </div>
                            @endforeach
                        </div>
            
                        <p class="text-center mt-3 mt-lg-4">
                            Harap transfer sesuai dengan nominal "<strong>TOTAL TAGIHAN</strong>" ke bank yang tertera di atas! Setelah transfer lakukan konfirmasi! perbedaan nilai transfer akan menghambat proses verfikasi.
                        </p>
            
                        <div class="text-center mt-3 mt-lg-4">
                            <a href="{{ url('/donation/'. $campaign->id .'/payment-confirmation/'. $donation->order_number) }}" class="btn btn-primary">Konfirmasi Pembayaran</a>
                        </div>
                    </div>

                    <p class="mt-3">Jika itu tidak berhasil, salin dan tempel tautan berikut di browser Anda:</p>
                    <p><a href="{{ url('/donation/'. $campaign->id .'/payment-confirmation/'. $donation->order_number) }}">{{ url('/donation/'. $campaign->id .'/payment-confirmation/'. $donation->order_number) }}</a></p>
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
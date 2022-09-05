@extends('layouts.front')

@section('title', $donation->user->name)

@push('css')
<style>
    .informasi {
        height: 120px;
    }
    @media (max-width: 575.98px) {
        .info {
            border-radius: .25rem;
        }
        .informasi {
            height: 150px;
        }
    }
</style>
@endpush

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <h5 class="text-center">Terimakasih {{ $donation->user->name }}</h5>
            <div class="detail d-flex justify-content-around align-items-center text-center mt-3 mt-lg-4">
                <p>ID Transaksi #{{ $donation->order_number }}</p>
                <p>Total Tagihan <strong>Rp. {{ format_uang($donation->nominal) }}</strong></p>
            </div>

            <div class="row justify-content-between mt-3 mt-lg-4">
                @foreach ($bank as $item)
                <div class="col-lg-3 col-md-4 text-center">
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

            <div class="informasi d-flex justify-content-center align-items-center mt-3 mt-lg-4">
                <div class="bg-info rounded-left d-none d-lg-block w-25 pt-4 text-center text-white h-100">
                    <i class="fas fa-info fa-4x m-auto"></i>
                </div>
                <div class="bg-white rounded-right info text-center w-100 p-4 h-100">
                    <p>Kami sudah membuatkan akun {{ $setting->company_name }} untuk Anda, silakan cek email Anda.</p>
                    <strong>({{ $setting->email }})</strong>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
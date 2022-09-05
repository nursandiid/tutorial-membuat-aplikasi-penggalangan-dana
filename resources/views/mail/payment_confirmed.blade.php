@extends('layouts.mail')
@section('title', 'Registrasi Sukses')

@section('content')
<div class="container py-3">
    <div class="row justify-content-center h-100 align-items-center">
        <div class="col-lg-7 col-md-8 col-12">
            <div class="card shadow-none mt-3 mx-2 mt-lg-0">
                <div class="card-body">
                    <div class="text-center">
                        <h1>Pembayaran Diterima</h1>
                        <div class="logo my-4">
                            <img src="{{ url($setting->path_image ?? '#') }}" alt="logo" height="120">
                        </div>
                    </div>

                    <div>
                        <p class="text-center mt-3 mt-lg-4">
                            Terimakasih {{ $donation->user->name }}, Admin telah mengkonfirmasi pembayaran Anda.
                        </p>

                        <strong class="d-block mt-3 mb-2">Pembayaran</strong>
                        @if ($donation->payment)
                        <table class="table table-sm table-bordered">
                            <tbody>
                                <tr>
                                    <td width="35%">Pengirim</td>
                                    <td>: {{ $donation->payment->name }}</td>
                                </tr>
                                <tr>
                                    <td>Jumlah</td>
                                    <td>: {{ format_uang($donation->payment->nominal) }}</td>
                                </tr>
                                <tr>
                                    <td>Tanggal Transfer</td>
                                    <td>: {{ tanggal_indonesia($donation->payment->created_at) }}</td>
                                </tr>
                                <tr>
                                    <td>Bukti Transfer</td>
                                    <td>: 
                                        @if (Storage::disk('public')->exists($donation->payment->path_image))
                                        <a href="{{ Storage::disk('public')->url($donation->payment->path_image) }}" class="badge badge-success ml-1" download="">Download</a>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td>Status</td>
                                    <td>: <span class="badge badge-{{ $donation->statusColor() }}">{{ $donation->statusText() }}</span></td>
                                </tr>
                            </tbody>
                        </table>
                        @else
                        Belum tersedia
                        @endif

                        <p class="mt-3 mt-lg-4">
                            {!! $donation->campaign->short_description !!}
                        </p>
                    </div>

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
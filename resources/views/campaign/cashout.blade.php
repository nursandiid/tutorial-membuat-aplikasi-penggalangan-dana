@extends('layouts.app')

@section('title', 'Projek')
@section('breadcrumb')
    @parent
    <li class="breadcrumb-item"><a href="{{ route('campaign.index') }}">Projek</a></li>
    <li class="breadcrumb-item active">Pencairan</li>
@endsection

@push('css')
<style>
    .pre {
        font-family: "Courier New", monospace;
    }
</style>
@endpush

@section('content')
<div class="row">
    <div class="col-lg-7">
        <x-card>
            <x-slot name="header">
                <h3>{{ $campaign->title }}</h3>
                <p class="font-weight-bold mb-0">
                    Diposting oleh <span class="text-primary">{{ $campaign->user->name }}</span>
                    <small class="d-block">{{ tanggal_indonesia($campaign->publish_date) }} {{ date('H:i', strtotime($campaign->publish_date)) }}</small>
                </p>
            </x-slot>

            {!! $campaign->body !!}

            <x-slot name="footer">
                <h1 class="font-weight-bold">Rp. {{ format_uang($campaign->nominal) }}</h1>
            <p class="font-weight-bold">Terkumpul dari Rp. {{ format_uang($campaign->goal) }}</p>
            <div class="progress" style="height: .3rem;">
                <div class="progress-bar" role="progressbar" style="width: {{ $campaign->nominal / $campaign->goal * 100 }}%" aria-valuenow="{{ $campaign->nominal / $campaign->goal * 100 }}" aria-valuemin="0" aria-valuemax="{{ 100 }}"></div>
            </div>
            <div class="d-flex justify-content-between mt-1">
                <p>{{ $campaign->nominal / $campaign->goal * 100 }}% tercapai</p>
                @if (now()->parse($campaign->end_date)->lt(now()))
                <p>selesai {{ now()->parse($campaign->end_date)->diffForHumans() }}</p>
                @else
                <p>tersisa {{ now()->parse($campaign->end_date)->diffForHumans() }}</p>
                @endif
            </div>
            </x-slot>
        </x-card>

        @php
            $bank = $campaign->user->mainAccount();
        @endphp

        <x-card class="pre">
            <h3 class="mb-3">Rekening bank tujuan:</h3>
            <div class="row">
                <div class="col-lg-4">
                    <p class="mb-0 font-weight-bold">Nama bank:</p>
                    @if ($bank)
                    <input type="text" class="form-control-plaintext bank-name" value="{{ $bank->name }}" readonly>
                    @endif
                </div>
                <div class="col-lg-4">
                    <p class="mb-0 font-weight-bold">Nomor rekening:</p>
                    @if ($bank)
                    <input type="text" class="form-control-plaintext bank-account" value="{{ sembunyikan_text($bank->pivot->account, 3) }}" readonly>
                    @endif
                </div>
                <div class="col-lg-4">
                    <p class="mb-0 font-weight-bold">Nama pemilik rekening:</p>
                    @if ($bank)
                    <input type="text" class="form-control-plaintext bank-ownername" value="{{ sembunyikan_text($bank->pivot->name, 1) }}" readonly>
                    @endif
                </div>
                <div class="col mt-3">
                    @if ($bank)
                    <button class="btn btn-primary float-left" data-toggle="modal" data-target="#ganti-rekening">Ganti Rekening Tujuan</button>
                    @else
                    <button class="btn btn-warning float-left" data-toggle="modal" data-target="#ganti-rekening">Silahkan Lengkapi Rekening Tujuan</button>
                    @endif
                </div>
            </div>
        </x-card>
    </div>

    <div class="col-lg-5">
        <h3 class="text-primary">Yang bisa dicairkan: Rp. {{ format_uang($campaign->nominal - $campaign->cashouts->whereIn('status', ['success', 'pending'])->sum('cashout_amount')) }}</h3>
        @if ($campaign->cashouts->whereIn('status', ['success', 'pending'])->sum('cashout_amount') > 0)
            @if ($campaign->cashout_latest->status == 'success')
            <h5 class="d-block text-{{ $campaign->cashout_latest->statusColor() }}">Sebelumnya Anda telah mencairkan sebesar Rp. {{ format_uang($campaign->cashout_latest->cashout_amount) }}</h5>
            <p>Terakhir dibuat pada {{ tanggal_indonesia($campaign->cashout_latest->created_at) }} {{ date('H:i', strtotime($campaign->cashout_latest->created_at)) }}</p>
            @elseif ($campaign->cashout_latest->status == 'pending')
            <h5 class="d-block text-{{ $campaign->cashout_latest->statusColor() }}">Admin sedang meninjau permintaan pengajuan pencairan Anda sebelumnya, sebesar Rp. {{ format_uang($campaign->cashout_latest->cashout_amount) }}</h5>
            <p>Terakhir dibuat pada {{ tanggal_indonesia($campaign->cashout_latest->created_at) }} {{ date('H:i', strtotime($campaign->cashout_latest->created_at)) }}</p>
            @endif
        @endif
        <div class="alert alert-light border-primary">
            Disarankan untuk melakukan pencairan dana pada jam kerja normal (Senin-Jumat 08.00-20.00) untuk menghindari transaksi pending dikarenakan terkena cut off time dari bank yang bersangkutan.
        </div>

        <x-card>
            <form action="{{ route('campaign.cashout.store', $campaign->id) }}" method="post" class="form-pencairan" onsubmit="reviewCashout()">
                @csrf

                <input type="hidden" name="campaign_id" value="{{ $campaign->id }}">
                <input type="hidden" name="user_id" value="{{ $campaign->user_id }}">
                <input type="hidden" name="bank_id" value="{{ $bank->id ?? '' }}">
                <input type="hidden" name="total" value="{{ $campaign->nominal - $campaign->cashouts->whereIn('status', ['success', 'pending'])->sum('cashout_amount') }}">

                <div class="form-group">
                    <label for="cashout_amount">Jumlah yang ingin dicairkan: <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon1">Rp</span>
                        </div>
                        <input type="text" class="form-control" name="cashout_amount" id="cashout_amount" onkeyup="format_uang(this)">
                    </div>
                    <small class="text-danger text-message"></small>
                </div>
                <div class="form-group">
                    <label for="cashout_fee">Biaya:</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon1">Rp</span>
                        </div>
                        <input type="text" class="form-control" name="cashout_fee" id="cashout_fee" value="{{ format_uang(5000) }}" readonly>
                    </div>
                </div>
                <div class="form-group">
                    <label for="amount_received">Jumlah yang diterima:</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon1">Rp</span>
                        </div>
                        <input type="text" class="form-control" name="amount_received" id="amount_received" readonly>
                    </div>
                </div>
                <div class="form-group">
                    <label for="remaining_amount">Sisa dana:</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon1">Rp</span>
                        </div>
                        <input type="text" class="form-control" name="remaining_amount" id="remaining_amount" readonly>
                    </div>
                </div>
                <div class="form-group">
                    <button type="button" class="btn btn-success review-cashout" onclick="reviewCashout()" disabled>Review Cashout</button>
                </div>
            </form>
        </x-card>
    </div>
</div>

<x-modal size="modal-md modal-dialog-centered">
    <x-slot name="title">
        Review Aktivitas Cashout
    </x-slot>

    @method('post')

    <table class="table table-sm table-borderless preview pre">
        <tr>
            <td>Nama Bank:</td>
            <td class="text-right nama-bank"></td>
        </tr>
        <tr>
            <td>Nomor Rekening:</td>
            <td class="text-right nomor-rekening"></td>
        </tr>
        <tr>
            <td>Pemilik Rekening:</td>
            <td class="text-right pemilik-rekening"></td>
        </tr>
        <tr>
            <td>Jumlah yang dicairkan:</td>
            <td class="text-right jumlah-dicairkan"></td>
        </tr>
        <tr>
            <td>Biaya:</td>
            <td class="text-right biaya"></td>
        </tr>
        <tr>
            <td>Jumlah yang diterima:</td>
            <td class="text-right jumlah-diterima"></td>
        </tr>
        <tr>
            <td>Sisa saldo:</td>
            <td class="text-right sisa-saldo"></td>
        </tr>
    </table>

    <x-slot name="footer">
        <button type="button" class="btn btn-primary" onclick="submitForm()">Cashout!</button>
    </x-slot>
</x-modal>

<x-modal size="modal-md" id="ganti-rekening">
    <x-slot name="title">
        Ganti Rekening Tujuan
    </x-slot>

    <div class="alert alert-info mt-3">
        <i class="fas fa-info-circle mr-1"></i> Silahkan update rekening dimenu profil
    </div>

    <p class="mb-3">Silahkan klik link <a href="{{ route('profile.show') }}?pills=bank">berikut ini</a> untuk update rekening tujuan</p>
</x-modal>
@endsection

@push('scripts')
<script>
    let modal = '#modal-form';
    let total,
        cashout_fee,
        cashout_amount,
        amount_received,
        remaining_amount,
        text_message,
        review_cashout;

    $(function () {
        total = parseFloat($('[name=total]').val().replaceAll('.', ''));
        cashout_fee = parseFloat($('[name=cashout_fee]').val().replaceAll('.', ''));
        cashout_amount = $('[name=cashout_amount]');
        amount_received = $('[name=amount_received]');
        remaining_amount = $('[name=remaining_amount]');
        text_message = $('.text-message');
        review_cashout = $('.review-cashout');

        cashout_amount.on('keyup', function () {
            let value = parseFloat(this.value == '' ? 0 : this.value.replaceAll('.', ''));

            if (value < 50000) {
                text_message.text('Jumlah minimal adalah 50.000');
                review_cashout.attr('disabled', true);
                amount_received.val('0');
                remaining_amount.val('0');
            } else if (value > total) {
                text_message.text('Saldo tidak cukup');
                review_cashout.attr('disabled', true);
                amount_received.val('0');
                remaining_amount.val('0');
            } else {
                text_message.text('');
                review_cashout.attr('disabled', false);
                amount_received.val(format_uang(value - cashout_fee));
                remaining_amount.val(format_uang(total - value));
            }
        });
    });
    
    function reviewCashout() {
        $(modal).modal('show');

        $('.nama-bank').text($('.bank-name').val());
        $('.nomor-rekening').text($('.bank-account').val());
        $('.pemilik-rekening').text($('.bank-ownername').val());
        $('.jumlah-dicairkan').text(cashout_amount.val());
        $('.biaya').text(format_uang(cashout_fee));
        $('.jumlah-diterima').text(amount_received.val());
        $('.sisa-saldo').text(remaining_amount.val());
    }

    function submitForm() {
        const originalForm = '.form-pencairan';
        $.post($(originalForm).attr('action'), $(originalForm).serialize())
            .done(response => {
                $(modal).modal('hide');
                showAlert(response.message, 'success');
                resetForm(originalForm);

                setTimeout(() => {
                    location.reload();
                }, 3000);
            })
            .fail(errors => {
                $(modal).modal('hide');
                
                if (errors.status == 422) {
                    loopErrors(errors.responseJSON.errors);
                    return;
                }

                showAlert(errors.responseJSON.message, 'danger');
            });
    }
</script>
@endpush
@extends('layouts.app')

@section('title', 'Pencairan')
@section('breadcrumb')
    @parent
    <li class="breadcrumb-item"><a href="{{ route('cashout.index') }}">Pencairan</a></li>
    <li class="breadcrumb-item active">Detail</li>
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

        <div class="pre alert alert-light border-primary">
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
                    <input type="text" class="form-control-plaintext bank-account" value="{{ $bank->pivot->account }}" readonly>
                    @endif
                </div>
                <div class="col-lg-4">
                    <p class="mb-0 font-weight-bold">Nama pemilik rekening:</p>
                    @if ($bank)
                    <input type="text" class="form-control-plaintext bank-ownername" value="{{ $bank->pivot->name }}" readonly>
                    @endif
                </div>
            </div>
        </div>

        <x-card class="card-confirm">
            <x-slot name="header">
                <h5 class="mb-0">Dibuat pada {{ tanggal_indonesia($cashout->created_at) }} {{ date('H:i', strtotime($cashout->created_at)) }}</h5>
            </x-slot>
            
            @if (auth()->user()->hasRole('admin'))
            <div class="alert alert-light border-danger text-danger">
                Silahkan transfer ke rekening diatas sesuai nominal berikut.
            </div>
            <h1 class="font-weight-bold text-danger">Rp. {{ format_uang($cashout->cashout_amount) }}</h1>
            @else
            <div class="alert alert-light border-danger text-danger mb-0">
                Nominal yang ingin Anda cairkan adalah sebesar Rp. {{ format_uang($cashout->cashout_amount) }}
            </div>
            @endif

            <x-slot name="footer">
                @switch($cashout->status)
                    @case('pending')
                        @if ($cashout->user_id == auth()->id())
                        <button class="btn btn-secondary float-left"
                            onclick="editForm('{{ route('cashout.update', $cashout->id) }}', 'canceled', 'Yakin ingin membatalkan pencairan terpilih?', 'secondary')">Batalkan</button> 
                        @endif

                        @if (auth()->user()->hasRole('admin'))
                        <button class="btn btn-success float-right ml-2"
                            onclick="editForm('{{ route('cashout.update', $cashout->id) }}', 'success', 'Yakin ingin mengkonfirmasi pencairan terpilih?', 'success')">Konfirmasi</button> 
                        <button class="btn btn-danger float-right"
                            onclick="editForm('{{ route('cashout.update', $cashout->id) }}', 'rejected', 'Yakin ingin menolak pencairan terpilih?', 'danger')">Tolak</button> 
                        @endif
                        @break
                    @case('canceled')
                        <span class="text-{{ $cashout->statusColor() }}">
                            {{ ucfirst($cashout->statusText()) }} oleh 
                            @if (auth()->id() == $cashout->user_id)
                                Anda
                            @else
                                {{ $cashout->user->name }}
                            @endif
                        </span>
                        @break
                    @case('rejected')
                        <span class="text-{{ $cashout->statusColor() }}">
                            {{ ucfirst($cashout->statusText()) }} oleh Admin karena {{ $cashout->reason_rejected }}
                        </span>
                        @break
                    @case('success')
                        <span class="text-{{ $cashout->statusColor() }}">
                            Berhasil {{ ucfirst($cashout->statusText()) }} oleh Admin
                        </span>
                        @break
                    @default
                @endswitch
            </x-slot>
        </x-card>
    </div>
</div>

<x-modal size="modal-md">
    <x-slot name="title">Form Konfirmasi</x-slot>

    @method('put')

    <input type="hidden" name="status">

    <div class="alert mt-3">
        <i class="fas fa-info-circle mr-1"></i> <span class="text-message"></span>
    </div>

    <div class="form-group reason-rejected" style="display: none">
        <label for="reason_rejected">Alasan</label>
        <textarea name="reason_rejected" id="reason_rejected" rows="3" class="form-control"></textarea>
    </div>

    <x-slot name="footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tidak</button>
        <button type="button" class="btn btn-primary" onclick="submitForm(this.form)">Ya</button>
    </x-slot>
</x-modal>
@endsection

@push('scripts')
<script>
    let modal = '#modal-form';

    function editForm(url, status, message, color) {
        $(modal).modal('show');
        $(`${modal} form`).attr('action', url);
        $(`${modal} [name=_method]`).val('put');

        resetForm(`${modal} form`);
        
        $(`${modal} [name=status]`).val(status);
        $(`${modal} .text-message`).html(message);
        $(`${modal} .alert`).removeClass('alert-success alert-danger').addClass(`alert-${color}`);

        if (status == 'rejected') {
            $('.reason-rejected').show()
        } else {
            $('.reason-rejected').hide()
        }
    }

    function submitForm(originalForm) {
        $.post({
                url: $(originalForm).attr('action'),
                data: new FormData(originalForm),
                dataType: 'json',
                contentType: false,
                cache: false,
                processData: false
            })
            .done(response => {
                $(modal).modal('hide');
                showAlert(response.message, 'success');

                $('.card-footer').remove();
            })
            .fail(errors => {
                if (errors.status == 422) {
                    loopErrors(errors.responseJSON.errors);
                    return;
                }

                showAlert(errors.responseJSON.message, 'danger');
            });
    }
</script>
@endpush
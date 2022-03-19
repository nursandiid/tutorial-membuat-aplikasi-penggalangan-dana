@extends('layouts.app')

@section('title', 'Donasi')
@section('breadcrumb')
    @parent
    <li class="breadcrumb-item"><a href="{{ route('donation.index') }}">Donasi</a></li>
    <li class="breadcrumb-item active">Detail</li>
@endsection

@push('css')
<style>
    .daftar-donasi.nav-pills .nav-link.active, 
    .daftar-donasi.nav-pills .show>.nav-link {
        background: transparent;
        color: var(--dark);
        border-bottom: 3px solid var(--blue);
        border-radius: 0;
    }
</style>
@endpush

@section('content')
<div class="row">
    <div class="col-lg-8">
        <x-card>
            <x-slot name="header">
                <h3>{{ $donation->campaign->title }}</h3>
                <p class="font-weight-bold mb-0">
                    Diposting oleh <span class="text-primary">{{ $donation->campaign->user->name }}</span>
                    <small class="d-block">{{ tanggal_indonesia($donation->campaign->publish_date) }} {{ date('H:i', strtotime($donation->campaign->publish_date)) }}</small>
                </p>
            </x-slot>

            {!! $donation->campaign->short_description !!}

            <br>
            <strong class="d-block mt-3 mb-2">Donatur</strong>
            <table class="table table-sm table-bordered">
                <tbody>
                    <tr>
                        <td width="35%">ID Transaksi</td>
                        <td>: {{ $donation->order_number }}</td>
                    </tr>
                    <tr>
                        <td width="35%">Donatur</td>
                        <td>: {{ $donation->user->name }}</td>
                    </tr>
                    <tr>
                        <td>Jumlah</td>
                        <td>: {{ format_uang($donation->nominal) }}</td>
                    </tr>
                    <tr>
                        <td>Tanggal Donasi</td>
                        <td>: {{ tanggal_indonesia($donation->created_at) }}</td>
                    </tr>
                    <tr>
                        <td>Status</td>
                        <td>: <span class="badge badge-{{ $donation->statusColor() }}">{{ $donation->statusText() }}</span></td>
                    </tr>
                </tbody>
            </table>

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
                            <a href="javascript:void(0)" class="badge badge-dark" data-toggle="modal" data-target="#bukti-transaksi">Lihat</a>
                            @if (Storage::disk('public')->exists($donation->payment->path_image))
                            <a href="{{ Storage::disk('public')->url($donation->payment->path_image) }}" class="badge badge-success ml-1" download="">Download</a>
                            @endif
                        </td>
                    </tr>
                </tbody>
            </table>
            @else
            Belum tersedia
            @endif

            @if ($donation->status == 'not confirmed')
            <x-slot name="footer">
                @if ($donation->user_id == auth()->id())
                <button class="btn btn-danger float-left"
                    onclick="editForm('{{ route('donation.update', $donation->id) }}', 'canceled', 'Yakin ingin membatalkan donasi terpilih?', 'danger')">Batalkan</button>
                @endif

                @if (auth()->user()->hasRole('admin'))
                <button class="btn btn-success float-right"
                    onclick="editForm('{{ route('donation.update', $donation->id) }}', 'confirmed', 'Yakin ingin mengkonfirmasi donasi terpilih?', 'success')">Konfirmasi</button>
                @endif
            </x-slot>
            @endif
        </x-card>
    </div>
    <div class="col-lg-4">
        <x-card>
            <x-slot name="header">
                <h5 class="card-title">Kategori</h5>
            </x-slot>

            <ul>
                @foreach ($donation->campaign->category_campaign as $item)
                <li>{{ $item->name }}</li>
                @endforeach
            </ul>
        </x-card>

        <x-card>
            <x-slot name="header">
                <h5 class="card-title">Gambar Unggulan</h5>
            </x-slot>

            <img src="{{ Storage::disk('public')->url($donation->campaign->path_image) }}" class="img-thumbnail">
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

    <x-slot name="footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tidak</button>
        <button type="button" class="btn btn-primary" onclick="submitForm(this.form)">Ya</button>
    </x-slot>
</x-modal>

@if ($donation->payment)
<x-modal size="modal-lg" id="bukti-transaksi">
    <x-slot name="title">Bukti Transaksi</x-slot>

    @if (Storage::disk('public')->exists($donation->payment->path_image))
    <img src="{{ Storage::disk('public')->url($donation->payment->path_image) }}" alt="{{ $donation->payment->path_image }}"
        class="img-thumbnail">
    @else
    Tidak tersedia
    @endif

    @if (Storage::disk('public')->exists($donation->payment->path_image))
    <x-slot name="footer">
        <a href="{{ Storage::disk('public')->url($donation->payment->path_image) }}" class="btn btn-success" download=""><i class="fas fa-download"></i></a>
    </x-slot>
    @endif
</x-modal>
@endif
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

                let color = '';
                
                if (response.data.status == 'confirmed') color = 'success';
                else if (response.data.status == 'canceled') color = 'danger';

                $('td span.badge').removeAttr('class').attr('class', `badge badge-${color}`);
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
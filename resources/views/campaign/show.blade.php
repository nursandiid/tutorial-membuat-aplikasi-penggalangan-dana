@extends('layouts.app')

@section('title', 'Projek')
@section('breadcrumb')
    @parent
    <li class="breadcrumb-item"><a href="{{ route('campaign.index') }}">Projek</a></li>
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
                <h3>{{ $campaign->title }}</h3>
                <p class="font-weight-bold mb-0">
                    Diposting oleh <span class="text-primary">{{ $campaign->user->name }}</span>
                    <small class="d-block">{{ tanggal_indonesia($campaign->publish_date) }} {{ date('H:i', strtotime($campaign->publish_date)) }}</small>
                </p>
            </x-slot>

            {!! $campaign->body !!}

            @if ($campaign->status == 'pending' && auth()->user()->hasRole('admin'))
            <x-slot name="footer">
                <button class="btn btn-success float-right"
                    onclick="editForm('{{ route('campaign.update_status', $campaign->id) }}', 'publish', 'Yakin ingin mengkonfirmasi projek terpilih?', 'success')">Konfirmasi</button>
            </x-slot>
            @elseif($campaign->status == 'publish' && auth()->user()->hasRole('admin'))
            <x-slot name="footer">
                <button class="btn btn-danger"
                    onclick="editForm('{{ route('campaign.update_status', $campaign->id) }}', 'archived', 'Yakin ingin mengarsipkan projek terpilih?', 'danger')">Arsipkan</button>
            </x-slot>
            @elseif ($campaign->status == 'archived' && auth()->user()->hasRole('admin'))
            <x-slot name="footer">
                <button class="btn btn-success float-right"
                    onclick="editForm('{{ route('campaign.update_status', $campaign->id) }}', 'publish', 'Yakin ingin membuka arsip projek terpilih?', 'success')">Buka Arsip</button>
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
                @foreach ($campaign->category_campaign as $item)
                <li>{{ $item->name }}</li>
                @endforeach
            </ul>
        </x-card>

        <x-card>
            <x-slot name="header">
                <h5 class="card-title">Gambar Unggulan</h5>
            </x-slot>

            <img src="{{ Storage::disk('public')->url($campaign->path_image) }}" class="img-thumbnail">
        </x-card>

        <x-card>
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

            <div class="mt-2 mb-4">
                <a href="{{ route('campaign.cashout', $campaign->id) }}" class="btn btn-success btn-lg btn-block">Cairkan Sekarang</a>
            </div>

            <h4 class="font-weight-bold">Donatur ({{ $campaign->donations->where('status', 'confirmed')->count() }})</h4>
            <ul class="nav nav-pills mb-3 daftar-donasi" id="pills-tab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="pills-waktu-tab" data-toggle="pill" href="#pills-waktu"
                        role="tab" aria-controls="pills-waktu" aria-selected="true">Waktu</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="pills-jumlah-tab" data-toggle="pill" href="#pills-jumlah"
                        role="tab" aria-controls="pills-jumlah" aria-selected="false">Jumlah</a>
                </li>
            </ul>
            <div class="tab-content" id="pills-tabContent">
                <div class="tab-pane fade show active" id="pills-waktu" role="tabpanel"
                    aria-labelledby="pills-waktu-tab">
                    @forelse ($campaign->donations->where('status', 'confirmed')->sortBy('created_at')->load('user') as $key => $item)
                    <div @if ($key > 0) class="mt-1" @endif>
                        <p class="font-weight-bold mb-0">{{ $item->user->name }}</p>
                        <p class="font-weight-bold mb-0">Rp. {{ format_uang($item->nominal) }}</p>
                        <p class="text-muted mb-0">{{ tanggal_indonesia($item->created_at) }}</p>
                    </div>
                    @empty
                    <p class="text-muted mb-0">Belum tersedia</p>
                    @endforelse
                </div>
                <div class="tab-pane fade" id="pills-jumlah" role="tabpanel"
                    aria-labelledby="pills-jumlah-tab">
                    @forelse ($campaign->donations->where('status', 'confirmed')->sortBy('nominal')->load('user') as $key => $item)
                    <div @if ($key > 0) class="mt-1" @endif>
                        <p class="font-weight-bold mb-0">{{ $item->user->name }}</p>
                        <p class="font-weight-bold mb-0">Rp. {{ format_uang($item->nominal) }}</p>
                        <p class="text-muted mb-0">{{ tanggal_indonesia($item->created_at) }}</p>
                    </div>
                    @empty
                    <p class="text-muted mb-0">Belum tersedia</p>
                    @endforelse
                </div>
            </div>
        </x-card>
    </div>
</div>

<x-modal size="modal-md">
    <x-slot name="title">
        Konfirmasi
    </x-slot>

    @method('put')

    <input type="hidden" name="status" value="publish">

    <div class="alert mt-3">
        <i class="fas fa-info-circle mr-1"></i> <span class="text-message"></span>
    </div>

    <x-slot name="footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
        <button type="button" class="btn btn-primary" onclick="submitForm(this.form)">Simpan</button>
    </x-slot>
</x-modal>
@endsection

@push('scripts')
<script>
    let modal = '#modal-form';
    
    function editForm(url, status, message, color) {
        $(modal).modal('show');
        $(`${modal} form`).attr('action', url);
        
        $(`${modal} [name=status]`).val(status);
        $(`${modal} .text-message`).text(message);
        $(`${modal} .alert`).removeClass('alert-success alert-danger').addClass(`alert-${color}`)
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
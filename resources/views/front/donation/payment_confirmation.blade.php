@extends('layouts.front')

@section('title', 'Konfirmasi Pembayaran')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <h5 class="text-center">Konfirmasi Pembayaran</h5>
            <div class="detail text-center mt-3 mt-lg-4">
                <p>ID Transaksi #{{ $donation->order_number }}</p>
                <p class="badge badge-{{ $donation->statusColor() }}">{{ $donation->statusText() }}</p>
            </div>

            <form action="{{ url('/donation/'. $campaign->id .'/payment-confirmation/'. $donation->order_number) }}" method="post" class="mt-3 mt-lg-4" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="name">Atas Nama (pengirim) <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') ?? ($payment->name ?? $donation->user->name) }}">
                    @error('name')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="nominal">Jumlah Nominal Transfer <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('nominal') is-invalid @enderror" name="nominal" value="{{ old('nominal') ?? ($payment->nominal ?? $donation->nominal) }}">
                    @error('nominal')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="bank_id">Bank <span class="text-danger">*</span></label>
                    <select name="bank_id" id="bank_id" class="form-control @error('bank_id') is-invalid @enderror">
                        <option disabled selected>Pilih bank</option>
                        @foreach ($bank as $key => $item)
                            <option value="{{ $key }}" {{ 
                                old('bank_id') == $key 
                                ? 'selected' 
                                : ($payment->bank_id == $key 
                                    ? 'selected' 
                                    : ($mainAccount && $mainAccount->pivot && $mainAccount->pivot->bank_id == $key
                                        ? 'selected'
                                        : ''
                                    )
                                ) 
                            }}>{{ $item }}</option>
                        @endforeach
                    </select>
                    @error('bank_id')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="path_image">Upload Bukti Pembayaran <span class="text-danger">*</span></label>
                    <div class="custom-file">
                        <input type="file" class="custom-file-input @error('path_image') is-invalid @enderror" id="path_image" name="path_image"
                            onchange="preview('.preview-path_image', this.files[0])">
                        <label class="custom-file-label" for="path_image">Choose file</label>
                    </div>
                    @error('path_image')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                
                @if (Storage::disk('public')->exists($payment->path_image))
                <img src="{{ Storage::disk('public')->url($payment->path_image) }}" class="img-thumbnail preview-path_image w-50 mb-2">
                @else
                <img src="" class="img-thumbnail preview-path_image w-50 mb-2" style="display: none;">
                @endif

                <div class="form-group">
                    <label for="note">Keterangan</label>
                    <textarea name="note" id="note" rows="4" class="form-control @error('note') is-invalid @enderror">{{ old('note') ?? $payment->note }}</textarea>
                    @error('note')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <div class="form-group">
                    <button class="btn btn-primary">
                        <i class="fas fa-paper-plane"></i>
                        Kirim Pesan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
@extends('layouts.front')

@section('title', $campaign->title)

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <form action="{{ url('/donation/'. $campaign->id) }}" method="post">
                @csrf
                <div class="card">
                    <div class="card-body d-flex">
                        <div class="thumbnail rounded w-25" style="overflow: hidden">
                            @if (Storage::disk('public')->exists($campaign->path_image))
                            <img src="{{ Storage::disk('public')->url($campaign->path_image) }}" class="w-100" alt="...">
                            @else
                            <img src="data:image/svg+xml;charset=UTF-8,%3Csvg%20width%3D%22286%22%20height%3D%22180%22%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20viewBox%3D%220%200%20286%20180%22%20preserveAspectRatio%3D%22none%22%3E%3Cdefs%3E%3Cstyle%20type%3D%22text%2Fcss%22%3E%23holder_17affada31b%20text%20%7B%20fill%3Argba(255%2C255%2C255%2C.75)%3Bfont-weight%3Anormal%3Bfont-family%3AHelvetica%2C%20monospace%3Bfont-size%3A14pt%20%7D%20%3C%2Fstyle%3E%3C%2Fdefs%3E%3Cg%20id%3D%22holder_17affada31b%22%3E%3Crect%20width%3D%22286%22%20height%3D%22180%22%20fill%3D%22%23777%22%3E%3C%2Frect%3E%3Cg%3E%3Ctext%20x%3D%22107.1953125%22%20y%3D%2295.5265625%22%3E286x180%3C%2Ftext%3E%3C%2Fg%3E%3C%2Fg%3E%3C%2Fsvg%3E" class="w-100" alt="...">
                            @endif
                        </div>

                        <div class="body ml-3">
                            <h5>Anda akan berdonasi untuk:</h5>
                            <p>{{ $campaign->title }}</p>
                        </div>
                    </div>
                </div>

                @if ($campaign->goal == $campaign->donations->sum('nominal'))
                    <div class="alert alert-light border-danger text-danger">
                        <i class="fas fa-info-circle"></i> 
                        Projek sudah mencapai goal, apakah yakin ingin tetap berdonasi pada untuk projek terpilih.

                        <button type="button" class="close text-danger" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif

                <div class="card mt-3">
                    @csrf

                    <div class="card-body">
                        <div class="bg-light rounded d-flex align-items-center p-3">
                            <h1 class="font-weight-bold w-25">Rp.</h1>
                            <div class="form-group w-75">
                                <input type="text" class="form-control @error('nominal') is-invalid @enderror" name="nominal" placeholder="Masukan nominal donasi" value="{{ old('nominal') }}" onkeyup="format_uang(this)">
                                @error('nominal')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>

                        <div class="alert alert-primary mt-3">
                            Donasi mulai dari Rp berapapun dengan Dompet Kebaikan.
                        </div>

                        @if (auth()->user()->hasRole('admin'))
                        <div class="form-group">
                            <label for="user_id">Donatur</label>
                            <select name="user_id" id="user_id" class="form-control @error('user_id') is-invalid @enderror select2">
                                <option disabled selected>Pilih salah satu</option>
                                @foreach ($user as $item)
                                <option value="{{ $item->id }}" data-phone="{{ $item->phone }}" {{ old('user_id') == $item->id ? 'selected' : '' }}>{{ $item->name }}</option>
                                @endforeach
                            </select>
                            @error('user_id')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="form-group mb-0 phone" style="display: none;">
                            <label></label>
                        </div>
                        @else
                        <input type="hidden" name="user_id" value="{{ auth()->id() }}">
                        <div class="form-group mb-0">
                            <label>{{ auth()->user()->phone }}</label>
                        </div>
                        @endif
                        <div class="form-group">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="anonim" name="anonim" value="1" {{ old('anonim') == 1 ? 'checked' : '' }}>
                                <label class="custom-control-label" for="anonim">Sembunyikan nama saya (Anonim)</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <textarea name="support" id="support" rows="4" class="form-control" placeholder="Tulis dukungan atau doa untuk penggalangan dana ini. Contoh: Semoga cepet sembuh, ya!">{{ old('support') }}</textarea>
                        </div>
                    </div>
                </div>

                <div class="form-group mt-3">
                    <button class="btn btn-primary btn-block">Lanjutkan Pembayaran</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@includeIf('includes.select2')

@push('scripts')
<script>
    $('[name=user_id]').on('change', function () {
        let value = $(this).val();
        let phone = $(`[name=user_id] option[value=${value}]`).data('phone')

        $('.phone').show()
        $('.phone label').text(phone);
    });
</script>
@endpush
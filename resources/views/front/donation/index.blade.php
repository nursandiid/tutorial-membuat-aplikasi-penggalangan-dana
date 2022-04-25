@extends('layouts.front')

@section('title', 'Semua Kategori')

@push('css')
<style>
    .kategori .control-lg {
        height: calc(1.5em + 1rem + 2px);
        padding: 0.5rem 1rem;
        line-height: 1.5;
        border-radius: 0.3rem;
    }

    .kategori .card {
        border: 0;
        box-shadow: 0 1rem 3rem rgba(0, 0, 0, .1) !important;
        transition: .5s;
    }
    .kategori .card:hover,
    .kategori .card:focus {
        transform: translateY(-5px);
    }

    .page-item .page-link {
        background: transparent;
        border-radius: .35rem;
        border: none;
        padding: .75rem 1rem;
        font-weight: 700;
        font-size: .9rem;
        color: #454545;
    }
    .page-item.disabled .page-link {
        background: transparent;
    }
    .page-item.active .page-link {
        z-index: 3;
        color: #ffffff;
        background: var(--primary);
        border-color: var(--primary);
    }
    .card-body2 {
        min-height: 10rem;
    }
    @media (max-width: 575.98px) {
        .card-body2 {
            min-height: auto;
        }
    }
</style>
@endpush

@section('content')
{{-- Banner --}}
<div class="banner bg-charity2">
    <div class="container">
        <h2 class="fa-2x text-white">Semua Kategori</h2>
    </div>
</div>

{{-- Kategori --}}
<div class="kategori bg-white">
    <div class="container py-5">
        <div class="row">
            <div class="col-lg-8">
                <h5>Halo #orang baik</h5>
                <p>Pilih campaign yang ingin Anda bantu</p>
            </div>
            <div class="col-lg-4">
                <form class="form-group" action="{{ url('/donation') }}">
                    <select name="categories[]" id="categories" class="select2" multiple required 
                        style="width: 100%;"
                        onchange="$(this.form).submit()">
                        @foreach ($category as $key => $item)
                        <option value="{{ $key }}" {{ request()->has('categories') && in_array($key, request()->categories) ? 'selected' : '' }}>{{ $item }}</option>
                        @endforeach
                    </select>
                </form>
            </div>

            @foreach($campaign as $item)
            <div class="col-lg-4 col-md-6">
                <div class="card mt-4">
                    <div class="rounded-top" style="height: 200px; overflow: hidden;">
                        @if (Storage::disk('public')->exists($item->path_image))
                        <img src="{{ Storage::disk('public')->url($item->path_image) }}" class="card-img-top" alt="...">
                        @else
                        <img src="data:image/svg+xml;charset=UTF-8,%3Csvg%20width%3D%22286%22%20height%3D%22180%22%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20viewBox%3D%220%200%20286%20180%22%20preserveAspectRatio%3D%22none%22%3E%3Cdefs%3E%3Cstyle%20type%3D%22text%2Fcss%22%3E%23holder_17affada31b%20text%20%7B%20fill%3Argba(255%2C255%2C255%2C.75)%3Bfont-weight%3Anormal%3Bfont-family%3AHelvetica%2C%20monospace%3Bfont-size%3A14pt%20%7D%20%3C%2Fstyle%3E%3C%2Fdefs%3E%3Cg%20id%3D%22holder_17affada31b%22%3E%3Crect%20width%3D%22286%22%20height%3D%22180%22%20fill%3D%22%23777%22%3E%3C%2Frect%3E%3Cg%3E%3Ctext%20x%3D%22107.1953125%22%20y%3D%2295.5265625%22%3E286x180%3C%2Ftext%3E%3C%2Fg%3E%3C%2Fg%3E%3C%2Fsvg%3E" class="card-img-top" alt="...">
                        @endif
                    </div>
                    <div class="card-body p-2">
                        <div class="d-flex justify-content-between text-dark">
                            <p class="mb-0">Terkumpul: <strong>{{ format_uang($item->nominal) }}</strong></p>
                            <p class="mb-0">Goal: <strong>{{ format_uang($item->goal) }}</strong></p>
                        </div>
                    </div>
                    <div class="card-body card-body2 p-2 border-top">
                        <a href="{{ url('/donation/'. $item->id) }}" class="card-title text-dark mb-3">{{ $item->title }}</a>
                        @if (Str::length($item->short_description) > 0)
                        <p class="card-text">{{ Str::limit($item->short_description, 100, ' ...') }}</p>
                        @else
                        <p class="card-text">Deskripsi tidak tersedia.</p>
                        @endif
                    </div>
                    <div class="card-footer p-2">
                        <a href="{{ url('/donation/'. $item->id .'/create') }}" class="btn btn-primary d-block rounded">
                            <i class="fas fa-donate mr-2"></i>
                            Donasi Sekarang
                        </a>
                    </div>
                </div>
            </div>
            @endforeach

            
        </div>
    </div>

    <div class="paginasi pb-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 d-flex justify-content-center">
                    <x-pagination-card :model="$campaign" />
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@includeIf('includes.select2', ['placeholder' => 'Semua kategori'])
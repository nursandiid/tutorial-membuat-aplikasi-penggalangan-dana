@extends('layouts.app')

@section('title', 'Kategori')
@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">Kategori</li>
@endsection

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <a href="{{ route('category.create') }}" class="btn btn-primary"><i class="fas fa-plus-circle"></i> Tambah</a>
            </div>
            <div class="card-body">
                
                <form action="" class="d-flex justify-content-between">
                    <x-dropdown-table />
                    <x-filter-table />
                </form>

                <table class="table table-striped">
                    <thead>
                        <th width="5%">No</th>
                        <th>Nama</th>
                        <th width="25%">Jumlah Projek</th>
                        <th width="15%"><i class="fas fa-cog"></i></th>
                    </thead>
                    <tbody>
                        @foreach ($category as $key => $item)
                        <tr>
                            <td><x-number-table :key="$key" :model="$category" /></td>
                            <td>{{ $item->name }}</td>
                            <td>0</td>
                            <td>
                                <form action="{{ route('category.destroy', $item->id) }}" method="post">
                                    @csrf
                                    @method('delete')

                                    <a href="{{ route('category.edit', $item->id) }}" class="btn btn-link text-info"><i class="fas fa-edit"></i></a>
                                    <button class="btn btn-link text-danger" onclick="return confirm('Yakin ingin menghapus data?')"><i class="fas fa-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="float-right mt-3">
                    {{ $category->links('pagination::bootstrap-4') }}
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<x-toast />

@endpush
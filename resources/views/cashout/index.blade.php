@extends('layouts.app')

@section('title', 'Daftar Pencairan')
@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">Daftar Pencairan</li>
@endsection

@section('content')
<div class="row">
    <div class="col-lg-12">
        <x-card>
            <x-slot name="header">
                <a href="{{ route('cashout.index') }}" class="btn btn-primary"><i class="fas fa-plus-circle"></i> Tambah</a>
            </x-slot>

            <x-table>
                <x-slot name="thead">
                    <th width="5%">No</th>
                    <th width="20%">Judul Projek</th>
                    @if (auth()->user()->hasRole('admin'))
                    <th>Donatur</th>
                    @endif
                    <th>Jumlah</th>
                    <th>Status</th>
                    <th>Tgl Cashout</th>
                    <th width="15%"><i class="fas fa-cog"></i></th>
                </x-slot>
            </x-table>
        </x-card>
    </div>
</div>
@endsection

<x-toast />
@includeIf('includes.datatable')

@push('scripts')
<script>
    let table;

    table = $('.table').DataTable({
        processing: true,
        autoWidth: false,
        ajax: {
            url: '{{ route('cashout.data', ['status' => request('status')]) }}'
        },
        columns: [
            {data: 'DT_RowIndex', searchable: false, sortable: false},
            {data: 'title'},
            @if (auth()->user()->hasRole('admin'))
            {data: 'name'},
            @endif
            {data: 'cashout_amount', searchable: false},
            {data: 'status', searchable: false},
            {data: 'created_at', searchable: false},
            {data: 'action', searchable: false, sortable: false},
        ]
    });

    function deleteData(url) {
        if (confirm('Yakin data akan dihapus?')) {
            $.post(url, {
                    '_method': 'delete'
                })
                .done(response => {
                    showAlert(response.message, 'success');
                    table.ajax.reload();
                })
                .fail(errors => {
                    showAlert('Tidak dapat menghapus data');
                    return;
                });
        }
    }
</script>
@endpush
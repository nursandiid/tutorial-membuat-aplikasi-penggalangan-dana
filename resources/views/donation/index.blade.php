@extends('layouts.app')

@section('title', 'Daftar Donasi')
@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">Daftar Donasi</li>
@endsection

@section('content')
<div class="row">
    <div class="col-lg-12">
        <x-card>
            <x-slot name="header">
                <a href="{{ url('/donation') }}" class="btn btn-primary"><i class="fas fa-plus-circle"></i> Tambah</a>
            </x-slot>

            <x-table>
                <x-slot name="thead">
                    <th width="5%">No</th>
                    <th width="20%">Judul Projek</th>
                    <th>Donatur</th>
                    <th>Jumlah</th>
                    <th>Status</th>
                    <th>Tgl Donasi</th>
                    <th>ID Transaksi</th>
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
            url: '{{ route('donation.data', ['status' => request('status')]) }}'
        },
        columns: [
            {data: 'DT_RowIndex', searchable: false, sortable: false},
            {data: 'title'},
            {data: 'name'},
            {data: 'nominal', searchable: false},
            {data: 'status', searchable: false},
            {data: 'created_at', searchable: false},
            {data: 'order_number'},
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
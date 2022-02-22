@extends('layouts.app')

@section('title', 'Laporan donasi '. tanggal_indonesia(date('Y-m-01')) .' s/d '. tanggal_indonesia(date('Y-m-t')))
@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">Laporan</li>
@endsection

@section('content')
<div class="row">
    <div class="col-lg-12">
        <x-card>
            <x-slot name="header">
                <div class="btn-group">
                    <a href="{{ route('category.create') }}" class="btn btn-primary"><i class="fas fa-pencil-alt"></i> Ubah Periode</a>
                <a href="{{ route('category.create') }}" class="btn btn-danger"><i class="fas fa-file-pdf"></i> Export PDF</a>
                <a href="{{ route('category.create') }}" class="btn btn-success"><i class="fas fa-file-excel"></i> Export Excel</a>
                </div>
            </x-slot>

            <x-table>
                <x-slot name="thead">
                    <th width="5%">No</th>
                    <th>Tanggal</th>
                    <th width="20%">Keterangan</th>
                    <th width="20%">Pemasukan</th>
                    <th width="20%">Pengeluaran</th>
                    <th width="20%">Sisa Kas</th>
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
    let modal = '#modal-form';
    let table;

    table = $('.table').DataTable({
        processing: true,
        autoWidth: false,
        ajax: {
            url: '{{ route('report.data') }}'
        },
        columns: [
            {data: 'DT_RowIndex', searchable: false, sortable: false},
            {data: 'tanggal', searchable: false, sortable: false},
            {data: 'keterangan', searchable: false, sortable: false},
            {data: 'pemasukan', searchable: false, sortable: false},
            {data: 'pengeluaran', searchable: false, sortable: false},
            {data: 'sisa', searchable: false, sortable: false},
        ],
        paginate: false,
        searching: false,
        bInfo: false,
        order: []
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
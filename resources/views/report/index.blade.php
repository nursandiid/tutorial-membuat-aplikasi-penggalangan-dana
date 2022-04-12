@extends('layouts.app')

@section('title', 'Laporan Penggalangan Dana '. tanggal_indonesia($start) .' s/d '. tanggal_indonesia($end))
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
                    <button data-toggle="modal" data-target="#modal-form" class="btn btn-primary"><i class="fas fa-pencil-alt"></i> Ubah Periode</button>
                    <a target="_blank" href="{{ route('report.export_pdf', compact('start', 'end')) }}" class="btn btn-danger"><i class="fas fa-file-pdf"></i> Export PDF</a>
                    <a target="_blank" href="{{ route('report.export_excel', compact('start', 'end')) }}" class="btn btn-success"><i class="fas fa-file-excel"></i> Export Excel</a>
                </div>
            </x-slot>

            <x-table>
                <x-slot name="thead">
                    <th width="5%">No</th>
                    <th>Tanggal</th>
                    <th width="25%" style="text-align: left !important;">Pemasukan</th>
                    <th width="25%" style="text-align: left !important;">Pengeluaran</th>
                    <th width="25%" style="text-align: left !important;">Sisa Kas</th>
                </x-slot>
            </x-table>
        </x-card>
    </div>
</div>

@include('report.form')
@endsection

<x-toast />
@includeIf('includes.datatable')
@includeIf('includes.datepicker')

@push('scripts')
<script>
    let modal = '#modal-form';
    let table;

    table = $('.table').DataTable({
        processing: true,
        autoWidth: false,
        ajax: {
            url: '{{ route('report.data', compact('start', 'end')) }}'
        },
        columns: [
            {data: 'DT_RowIndex', searchable: false, sortable: false},
            {data: 'tanggal', searchable: false, sortable: false},
            {data: 'pemasukan', searchable: false, sortable: false, className: 'text-right'},
            {data: 'pengeluaran', searchable: false, sortable: false, className: 'text-right'},
            {data: 'sisa', searchable: false, sortable: false, className: 'text-right'},
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
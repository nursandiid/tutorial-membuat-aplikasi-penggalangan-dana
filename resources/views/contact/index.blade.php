@extends('layouts.app')

@section('title', 'Kontak Masuk')
@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">Kontak Masuk</li>
@endsection

@section('content')
<div class="row">
    <div class="col-lg-12">
        <x-card>
            <x-table>
                <x-slot name="thead">
                    <th width="5%">No</th>
                    <th>Nama</th>
                    <th>Tlp</th>
                    <th>Subjek</th>
                    <th>Pesan</th>
                    <th>Tgl Kirim</th>
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
    let modal = '#modal-form';
    let table;

    table = $('.table').DataTable({
        processing: true,
        autoWidth: false,
        ajax: {
            url: '{{ route('contact.data', ['date' => request('date')]) }}'
        },
        columns: [
            {data: 'DT_RowIndex', searchable: false, sortable: false},
            {data: 'name'},
            {data: 'phone', searchable: false},
            {data: 'subject'},
            {data: 'message', searchable: false},
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
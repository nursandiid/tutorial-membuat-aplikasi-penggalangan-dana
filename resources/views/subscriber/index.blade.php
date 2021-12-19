@extends('layouts.app')

@section('title', 'Subscriber')
@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">Subscriber</li>
@endsection

@section('content')
<div class="row">
    <div class="col-lg-12">
        <x-card>
            <x-table>
                <x-slot name="thead">
                    <th width="5%">No</th>
                    <th>Email</th>
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
            url: '{{ route('subscriber.data') }}'
        },
        columns: [
            {data: 'DT_RowIndex', searchable: false, sortable: false},
            {data: 'email'},
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
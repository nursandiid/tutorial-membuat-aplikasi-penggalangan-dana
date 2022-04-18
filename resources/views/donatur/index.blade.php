@extends('layouts.app')

@section('title', 'Donatur')
@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">Donatur</li>
@endsection

@section('content')
<div class="row">
    <div class="col-lg-12">
        <x-card>
            <x-slot name="header">
                <button onclick="addForm(`{{ route('donatur.store') }}`)" class="btn btn-primary"><i class="fas fa-plus-circle"></i> Tambah</button>
            </x-slot>

            <x-table>
                <x-slot name="thead">
                    <th width="5%">No</th>
                    <th width="20%"></th>
                    <th>Nama</th>
                    <th>Tlp</th>
                    <th style="white-space: nowrap;">Total Projek</th>
                    <th style="white-space: nowrap;">Total Donasi</th>
                    <th style="white-space: nowrap;">Tgl Gabung</th>
                    <th width="15%"><i class="fas fa-cog"></i></th>
                </x-slot>
            </x-table>
        </x-card>
    </div>
</div>

@includeIf('donatur.form')
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
            url: '{{ route('donatur.data', ['email' => request('email')]) }}'
        },
        columns: [
            {data: 'DT_RowIndex', searchable: false, sortable: false},
            {data: 'path_image', searchable: false, sortable: false},
            {data: 'name'},
            {data: 'phone', searchable: false},
            {data: 'campaigns_count', searchable: false, sortable: false},
            {data: 'donations_sum_nominal', searchable: false},
            {data: 'created_at', searchable: false},
            {data: 'action', searchable: false, sortable: false},
        ]
    });

    function addForm(url, title = 'Tambah') {
        $(modal).modal('show');
        $(`${modal} .modal-title`).text(title);
        $(`${modal} form`).attr('action', url);
        $(`${modal} [name=_method]`).val('post');

        resetForm(`${modal} form`);
    }

    function editForm(url, title = 'Edit') {
        $.get(url)
            .done(response => {
                $(modal).modal('show');
                $(`${modal} .modal-title`).text(title);
                $(`${modal} form`).attr('action', url);
                $(`${modal} [name=_method]`).val('put');

                resetForm(`${modal} form`);
                loopForm(response.data);

                let selectedCategories = [];
                response.data.categories.forEach(item => {
                    selectedCategories.push(item.id);
                });

                $('#categories')
                    .val(selectedCategories)
                    .trigger('change');
            })
            .fail(errors => {
                alert('Tidak dapat menampilkan data');
                return;
            });
    }

    function submitForm(originalForm) {
        $.post({
                url: $(originalForm).attr('action'),
                data: new FormData(originalForm),
                dataType: 'json',
                contentType: false,
                cache: false,
                processData: false
            })
            .done(response => {
                $(modal).modal('hide');
                showAlert(response.message, 'success');
                table.ajax.reload();
            })
            .fail(errors => {
                if (errors.status == 422) {
                    loopErrors(errors.responseJSON.errors);
                    return;
                }

                showAlert(errors.responseJSON.message, 'danger');
            });
    }

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
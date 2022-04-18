@extends('layouts.app')

@section('title', 'Projek')
@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">Projek</li>
@endsection

@section('content')
<div class="row">
    <div class="col-lg-12">
        <x-card>
            <x-slot name="header">
                @if (auth()->user()->hasRole('admin'))
                <button onclick="addForm(`{{ route('campaign.store') }}`)" class="btn btn-primary"><i class="fas fa-plus-circle"></i> Tambah</button>
                @else
                <a href="{{ url('/campaign') }}" class="btn btn-primary"><i class="fas fa-plus-circle"></i> Tambah</a>
                @endif
            </x-slot>

            <div class="d-flex justify-content-between">
                <div class="form-group">
                    <label for="status2">Status</label>
                    <select name="status2" id="status2" class="custom-select">
                        <option value="" selected>Semua</option>
                        <option value="publish" {{ request('status') == 'publish' ? 'selected' : '' }}>Publish</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="archived" {{ request('status') == 'archived' ? 'selected' : '' }}>Diarsipkan</option>
                    </select>
                </div>

                <div class="d-flex">
                    <div class="form-group mx-3">
                        <label for="start_date2">Tanggal Awal</label>
                        <div class="input-group datepicker" id="start_date2" data-target-input="nearest">
                            <input type="text" name="start_date2" class="form-control datetimepicker-input" data-target="#start_date2" />
                            <div class="input-group-append" data-target="#start_date2" data-toggle="datetimepicker">
                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="end_date2">Tanggal Akhir</label>
                        <div class="input-group datepicker" id="end_date2" data-target-input="nearest">
                            <input type="text" name="end_date2" class="form-control datetimepicker-input" data-target="#end_date2" />
                            <div class="input-group-append" data-target="#end_date2" data-toggle="datetimepicker">
                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <x-table>
                <x-slot name="thead">
                    <th width="5%">No</th>
                    <th width="20%"></th>
                    <th>Deskripsi</th>
                    <th>Tgl Publish</th>
                    <th>Status</th>
                    <th>Author</th>
                    <th width="15%"><i class="fas fa-cog"></i></th>
                </x-slot>
            </x-table>
        </x-card>
    </div>
</div>

@includeIf('campaign.form')
@endsection

<x-toast />
@includeIf('includes.datatable')
@includeIf('includes.select2')
@includeIf('includes.summernote')
@includeIf('includes.datepicker')

@push('scripts')
<script>
    let modal = '#modal-form';
    let table;

    table = $('.table').DataTable({
        processing: true,
        autoWidth: false,
        ajax: {
            url: '{{ route('campaign.data') }}',
            data: function (d) {
                d.status = $('[name=status2]').val();
                d.start_date = $('[name=start_date2]').val();
                d.end_date = $('[name=end_date2]').val();
            }
        },
        columns: [
            {data: 'DT_RowIndex', searchable: false, sortable: false},
            {data: 'path_image', searchable: false, sortable: false},
            {data: 'short_description'},
            {data: 'publish_date', searchable: false},
            {data: 'status', searchable: false, sortable: false},
            {data: 'author', searchable: false},
            {data: 'action', searchable: false, sortable: false},
        ]
    });

    $('[name=status2]').on('change', function () {
        table.ajax.reload();
    });

    $('.datepicker').on('change.datetimepicker', function () {
        table.ajax.reload();
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
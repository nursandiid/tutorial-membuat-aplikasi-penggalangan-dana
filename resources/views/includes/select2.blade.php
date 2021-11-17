@push('css_vendor')
<link rel="stylesheet" href="{{ asset('/AdminLTE/plugins/select2/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('/AdminLTE/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
@endpush

@push('scripts_vendor')
<script src="{{ asset('/AdminLTE/plugins/select2/js/select2.full.min.js') }}"></script>
@endpush

@push('scripts')
<script>
    $('.select2').select2({
        theme: 'bootstrap4',
        placeholder: '{{ isset($placeholder) ? $placeholder : "Pilih salah satu" }}',
        closeOnSelect: true,
        allowClear: true,
    });

    $('.select2-search__field').css('width', '100%');
    $('.select2-container--bootstrap4 .select2-selection--multiple .select2-search__field')
        .css('margin-left', '.3rem')
        .css('margin-top', '.35rem');
</script>
@endpush
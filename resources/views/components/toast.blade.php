@if (session()->has('success'))
<script>
    $(document).Toasts('create', {
        class: 'bg-success',
        title: 'Success',
        body: '{{ session('message') }}'
    });

    setTimeout(() => {
        $('.toasts-top-right').remove();
    }, 3000);
</script>
@elseif (session()->has('erros'))
<script>
    $(document).Toasts('create', {
        class: 'bg-danger',
        title: 'Error',
        body: '{{ session('message') }}'
    });

    setTimeout(() => {
        $('.toasts-top-right').remove();
    }, 3000);
</script>
@endif
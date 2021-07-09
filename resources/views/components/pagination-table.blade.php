<div class="d-flex justify-content-between mt-3">
    <p>Menampilkan {{ $model->firstItem() }} s/d {{ $model->lastItem() }} dari {{ $model->total() }} entri</p>

    {{ $model->links('pagination::bootstrap-4') }}
</div>
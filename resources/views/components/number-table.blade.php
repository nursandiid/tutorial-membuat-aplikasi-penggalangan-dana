@if(isset($key) && isset($model))
    {{ (($key+1) + ($model->currentPage() * $model->perPage()) - $model->perPage()) }}
@endif
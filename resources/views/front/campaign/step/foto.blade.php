<div class="form-group">
    <label for="path_image">Pilih salah satu foto untuk penggalangan danamu</label>
    <div class="custom-file">
        <input type="file" name="path_image" class="custom-file-input" id="path_image"
            onchange="preview('.preview-path_image', this.files[0])">
        <label class="custom-file-label" for="path_image">Choose file</label>
    </div>
    <small class="text-muted d-block">Format foto harus: (jpg, png, jpeg)</small>
    @if (isset($campaign) && Storage::disk('public')->exists($campaign->path_image))
        <img src="{{ Storage::disk('public')->url($campaign->path_image) }}" class="img-thumbnail w-50" alt="...">
    @else
        <img src="" class="img-thumbnail preview-path_image w-50" style="display: none;">
    @endif
</div>
<div class="form-group">
    <button type="button" class="btn btn-outline-primary" onclick="stepper.previous()">Sebelumnya</button>
    <button type="button" class="btn btn-primary" onclick="stepper.next()">Selanjutnya</button>
</div>
<div class="form-group">
    <label for="path_image">Pilih salah satu foto untuk penggalangan danamu</label>
    <div class="custom-file">
        <input type="file" name="path_image" class="custom-file-input" id="path_image"
            onchange="preview('.preview-path_image', this.files[0])">
        <label class="custom-file-label" for="path_image">Choose file</label>
    </div>
    <small class="text-muted">Format foto harus: (jpg, png, jpeg)</small>
    <img src="" class="img-thumbnail preview-path_image" style="display: none;">
</div>
<div class="form-group">
    <button class="btn btn-outline-primary" onclick="stepper.previous()">Sebelumnya</button>
    <button class="btn btn-primary" onclick="stepper.next()">Selanjutnya</button>
</div>
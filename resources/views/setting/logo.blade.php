<form action="{{ route('setting.update', $setting->id) }}?pills=logo" method="post" enctype="multipart/form-data">
    @csrf
    @method('put')

    <x-card>
        <div class="row justify-content-center">
            <div class="col-lg-4">
                <strong class="d-block text-center">Favicon</strong>
                <div class="text-center">
                    <img src="{{ url($setting->path_image ?? '') }}" alt="" class="img-thumbnail preview-path_image" width="200">
                </div>
                <div class="form-group mt-3">
                    <div class="custom-file">
                        <input type="file" class="custom-file-input" id="path_image" name="path_image"
                            onchange="preview('.preview-path_image', this.files[0])">
                        <label class="custom-file-label" for="path_image">Choose file</label>
                    </div>
                </div>
            </div>
            <div class="col-lg-2"></div>
            <div class="col-lg-4">
                <strong class="d-block text-center">Header</strong>
                <div class="text-center">
                    <img src="{{ url($setting->path_image_header ?? '') }}" alt="" class="img-thumbnail preview-path_image_header" width="200">
                </div>
                <div class="form-group mt-3">
                    <div class="custom-file">
                        <input type="file" class="custom-file-input" id="path_image_header" name="path_image_header"
                            onchange="preview('.preview-path_image_header', this.files[0])">
                        <label class="custom-file-label" for="path_image_header">Choose file</label>
                    </div>
                </div>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-lg-4">
                <strong class="d-block text-center">Footer</strong>
                <div class="text-center">
                    <img src="{{ url($setting->path_image_footer ?? '') }}" alt="" class="img-thumbnail preview-path_image_footer" width="200">
                </div>
                <div class="form-group mt-3">
                    <div class="custom-file">
                        <input type="file" class="custom-file-input" id="path_image_footer" name="path_image_footer"
                            onchange="preview('.preview-path_image_footer', this.files[0])">
                        <label class="custom-file-label" for="path_image_footer">Choose file</label>
                    </div>
                </div>
            </div>
        </div>
        <x-slot name="footer">
            <button type="reset" class="btn btn-dark">Reset</button>
            <button class="btn btn-primary">Simpan</button>
        </x-slot>
    </x-card>
</form>
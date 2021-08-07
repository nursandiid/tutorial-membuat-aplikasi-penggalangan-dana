<form action="{{ route('setting.update', $setting->id) }}?pills=sosial-media" method="post">
    @csrf
    @method('put')

    <x-card>
        <div class="row justify-content-center">
            <div class="col-lg-4">
                <div class="form-group">
                    <label for="instagram_link">Instagram</label>
                    <input type="text" class="form-control @error('instagram_link') is-invalid @enderror" name="instagram_link" id="instagram_link" 
                        value="{{ old('instagram_link') ?? $setting->instagram_link }}">
                    @error('instagram_link')
                    <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="col-lg-4">
                <div class="form-group">
                    <label for="twitter_link">Twitter</label>
                    <input type="text" class="form-control @error('twitter_link') is-invalid @enderror" name="twitter_link" id="twitter_link" 
                        value="{{ old('twitter_link') ?? $setting->twitter_link }}">
                    @error('twitter_link')
                    <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-lg-4">
                <div class="form-group">
                    <label for="fanpage_link">Fanpage</label>
                    <input type="text" class="form-control @error('fanpage_link') is-invalid @enderror" name="fanpage_link" id="fanpage_link" 
                        value="{{ old('fanpage_link') ?? $setting->fanpage_link }}">
                    @error('fanpage_link')
                    <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="col-lg-4">
                <div class="form-group">
                    <label for="google_plus_link">Google Plus</label>
                    <input type="text" class="form-control @error('google_plus_link') is-invalid @enderror" name="google_plus_link" id="google_plus_link" 
                        value="{{ old('google_plus_link') ?? $setting->google_plus_link }}">
                    @error('google_plus_link')
                    <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>

        <x-slot name="footer">
            <button type="reset" class="btn btn-dark">Reset</button>
            <button class="btn btn-primary">Simpan</button>
        </x-slot>
    </x-card>
</form>
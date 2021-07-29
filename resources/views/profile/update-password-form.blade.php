<form action="{{ route('user-password.update') }}" method="post">
    @csrf
    @method('put')

    <x-card>
        <div class="row justify-content-center">
            <div class="col-lg-4">
                <div class="text-center">
                    <img src="{{ url(auth()->user()->path_image ?? '') }}" alt="" class="img-thumbnail preview-path_image" width="200">
                </div>
            </div>
        </div>

        <div class="form-group">
            <label for="current_password">Password Aktif</label>
            <input type="password" class="form-control @error('current_password') is-invalid @enderror" name="current_password" id="current_password">
            @error('current_password')
            <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" id="password">
            @error('password')
            <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>
        <div class="form-group">
            <label for="password_confirmation">Konfirmasi Password</label>
            <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror" name="password_confirmation" id="password_confirmation">
            @error('password_confirmation')
            <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>

        <x-slot name="footer">
            <button type="reset" class="btn btn-dark">Reset</button>
            <button class="btn btn-primary">Simpan</button>
        </x-slot>
    </x-card>
</form>
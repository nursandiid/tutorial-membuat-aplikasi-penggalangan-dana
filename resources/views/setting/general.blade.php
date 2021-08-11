<form action="{{ route('setting.update', $setting->id) }}" method="post">
    @csrf
    @method('put')

    <x-card>
        <div class="row">
            <div class="col-lg-4">
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" id="email"
                        value="{{ old('email') ?? $setting->email }}">
                    @error('email')
                    <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="col-lg-4">
                <div class="form-group">
                    <label for="phone">No. Telp</label>
                    <input type="text" class="form-control @error('phone') is-invalid @enderror" name="phone" id="phone" 
                        value="{{ old('phone') ?? $setting->phone }}">
                    @error('phone')
                    <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="col-lg-4">
                <div class="form-group">
                    <label for="phone_hours">Jam Kerja</label>
                    <input type="text" class="form-control @error('phone_hours') is-invalid @enderror" name="phone_hours" id="phone_hours" 
                        value="{{ old('phone_hours') ?? $setting->phone_hours }}">
                    @error('phone_hours')
                    <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6">
                <div class="form-group">
                    <label for="owner_name">Nama Pemilik</label>
                    <input type="text" class="form-control @error('owner_name') is-invalid @enderror" name="owner_name" id="owner_name" 
                        value="{{ old('owner_name') ?? $setting->owner_name }}">
                    @error('owner_name')
                    <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="col-lg-6">
                <div class="form-group">
                    <label for="company_name">Nama Perusahaan</label>
                    <input type="text" class="form-control @error('company_name') is-invalid @enderror" name="company_name" id="company_name" 
                        value="{{ old('company_name') ?? $setting->company_name }}">
                    @error('company_name')
                    <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6">
                <div class="form-group">
                    <label for="short_description">Desripsi Singkat</label>
                    <input type="text" class="form-control @error('short_description') is-invalid @enderror" name="short_description" id="short_description" 
                        value="{{ old('short_description') ?? $setting->short_description }}">
                    @error('short_description')
                    <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="col-lg-6">
                <div class="form-group">
                    <label for="keyword">Keyword</label>
                    <input type="text" class="form-control @error('keyword') is-invalid @enderror" name="keyword" id="keyword" 
                        value="{{ old('keyword') ?? $setting->keyword }}">
                    @error('keyword')
                    <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>
        <div class="form-group">
            <label for="about">Tentang Perusahaan</label>
            <textarea class="form-control summernote @error('about') is-invalid @enderror" name="about" id="about">{{ old('about') ?? $setting->about }}</textarea>
            @error('about')
            <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>
        <div class="form-group">
            <label for="address">Alamat</label>
            <textarea class="form-control @error('address') is-invalid @enderror" name="address" id="address">{{ old('address') ?? $setting->address }}</textarea>
            @error('address')
            <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>
        <div class="row">
            <div class="col-lg-4">
                <div class="form-group">
                    <label for="province">Provinsi</label>
                    <input type="text" class="form-control @error('province') is-invalid @enderror" name="province" id="province" 
                        value="{{ old('province') ?? $setting->province }}">
                    @error('province')
                    <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="col-lg-4">
                <div class="form-group">
                    <label for="city">Kabupaten</label>
                    <input type="text" class="form-control @error('city') is-invalid @enderror" name="city" id="city" 
                        value="{{ old('city') ?? $setting->city }}">
                    @error('city')
                    <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="col-lg-4">
                <div class="form-group">
                    <label for="postal_code">Kode Pos</label>
                    <input type="text" class="form-control @error('postal_code') is-invalid @enderror" name="postal_code" id="postal_code" 
                        value="{{ old('postal_code') ?? $setting->postal_code }}">
                    @error('postal_code')
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
<form action="{{ route('user-profile-information.update') }}" method="post" enctype="multipart/form-data">
    @csrf
    @method('put')

    <x-card>
        <div class="row justify-content-center">
            <div class="col-lg-4">
                <div class="text-center">
                    @if (Storage::disk('public')->exists(auth()->user()->path_image))
                    <img src="{{ url(auth()->user()->path_image ?? '') }}" alt="" class="img-thumbnail preview-path_image" width="200"> 
                    @else
                    <img src="{{ asset('AdminLTE/dist/img/user1-128x128.jpg') }}" alt="" class="img-thumbnail preview-path_image" width="200">
                    @endif
                </div>
                <div class="form-group mt-3">
                    <div class="custom-file">
                        <input type="file" class="custom-file-input" id="path_image" name="path_image"
                            onchange="preview('.preview-path_image', this.files[0])">
                        <label class="custom-file-label" for="path_image">Choose file</label>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-4">
                <div class="form-group">
                    <label for="name">Nama</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" id="name" 
                        value="{{ old('name') ?? auth()->user()->name }}">
                    @error('name')
                    <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="col-lg-4">
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" id="email" 
                        value="{{ old('email') ?? auth()->user()->email }}">
                    @error('name')
                    <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="col-lg-4">
                <label for="role">Role</label>
                <input type="text" class="form-control @error('role') is-invalid @enderror" name="role" id="role" 
                    value="{{ old('role') ?? auth()->user()->role->name }}" disabled>
                @error('role')
                <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6">
                <div class="form-group">
                    <label for="phone">No. Telp</label>
                    <input type="text" class="form-control @error('phone') is-invalid @enderror" name="phone" id="phone" 
                        value="{{ old('phone') ?? auth()->user()->phone }}">
                    @error('phone')
                    <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="col-lg-6">
                <div class="form-group">
                    <label for="gender">Jenis Kelamin</label>
                    <select class="form-control @error('gender') is-invalid @enderror" name="gender" id="gender" 
                        value="{{ old('gender') ?? auth()->user()->gender }}">
                        <option selected disabled>Pilih salah satu</option>
                        <option value="laki-laki" {{ auth()->user()->gender == 'laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                        <option value="perempuan" {{ auth()->user()->gender == 'perempuan' ? 'selected' : '' }}>Perempuan</option>
                    </select>
                    @error('gender')
                    <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6">
                <div class="form-group">
                    <label for="birth_date">Tgl Lahir</label>
                    <div class="input-group datepicker" id="birth_date" data-target-input="nearest">
                        <input type="text" name="birth_date" class="form-control datetimepicker-input @error('birth_date') is-invalid @enderror" data-target="#birth_date" 
                            value="{{ old('birth_date') ?? auth()->user()->birth_date }}"/>
                        <div class="input-group-append" data-target="#birth_date" data-toggle="datetimepicker">
                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                        </div>
                    </div>
                    @error('birth_date')
                    <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="col-lg-6">
                <div class="form-group">
                    <label for="job">Pekerjaan</label>
                    <input type="text" class="form-control @error('job') is-invalid @enderror" name="job" id="job" 
                        value="{{ old('job') ?? auth()->user()->job }}">
                    @error('job')
                    <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>
        <div class="form-group">
            <label for="address">Alamat</label>
            <textarea class="form-control @error('address') is-invalid @enderror" name="address" id="address">{{ old('address') ?? auth()->user()->address }}</textarea>
            @error('address')
            <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>
        <div class="form-group">
            <label for="about">Tentang</label>
            <textarea class="form-control @error('about') is-invalid @enderror" name="about" id="about">{{ old('about') ?? auth()->user()->about }}</textarea>
            @error('about')
            <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>

        <x-slot name="footer">
            <button type="reset" class="btn btn-dark">Reset</button>
            <button class="btn btn-primary">Simpan</button>
        </x-slot>
    </x-card>
</form>

@includeIf('includes.datepicker')
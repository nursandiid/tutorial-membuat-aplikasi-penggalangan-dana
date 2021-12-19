<x-modal size="modal-lg">
    <x-slot name="title">
        Tambah
    </x-slot>

    @method('post')

    <div class="form-group mb-3">
        <label for="name">Nama</label>
        <input type="text" class="form-control" id="name" name="name">
    </div>
    <div class="form-group mb-3">
        <label for="email">Email</label>
        <input type="email" class="form-control" id="email" name="email">
    </div>
    <div class="form-group mb-3">
        <label for="password">Password</label>
        <input type="password" class="form-control" id="password" name="password">
    </div>
    <div class="form-group mb-3">
        <label for="password_confirmation">Konfirmasi Password</label>
        <input type="password" class="form-control" id="password_confirmation" name="password_confirmation">
    </div>

    <x-slot name="footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
        <button type="button" class="btn btn-primary" onclick="submitForm(this.form)">Simpan</button>
    </x-slot>
</x-modal>
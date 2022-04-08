<x-modal size="modal-lg" method="get">
    <x-slot name="title">
        Tambah
    </x-slot>

    <div class="form-group">
        <label for="start">Tanggal Awal</label>
        <div class="input-group datepicker" id="start" data-target-input="nearest">
            <input type="text" name="start" class="form-control datetimepicker-input" data-target="#start" />
            <div class="input-group-append" data-target="#start" data-toggle="datetimepicker">
                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
            </div>
        </div>
    </div>

    <div class="form-group">
        <label for="end">Tanggal Selesai</label>
        <div class="input-group datepicker" id="end" data-target-input="nearest">
            <input type="text" name="end" class="form-control datetimepicker-input" data-target="#end" />
            <div class="input-group-append" data-target="#end" data-toggle="datetimepicker">
                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
            </div>
        </div>
    </div>

    <x-slot name="footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
        <button class="btn btn-primary">Simpan</button>
    </x-slot>
</x-modal>
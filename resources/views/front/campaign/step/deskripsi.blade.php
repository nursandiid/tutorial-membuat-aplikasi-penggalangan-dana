<div class="form-group">
    <label for="short_description">Ceritakan tentang diri Anda, alasan penggalangan dana, dan rencana penggunaan dana</label>
    <textarea name="short_description" id="short_description" rows="4" class="form-control">{{ isset($campaign) ? $campaign->short_description : '' }}</textarea>
</div>
<div class="form-group">
    <label for="body">Tulis konten secara lengkap</label>
    <textarea name="body" id="body" rows="4" class="form-control summernote">{{ isset($campaign) ? $campaign->body : '' }}</textarea>
</div>
<div class="form-group">
    <label for="note">Tulis ajakan singkat untuk mengajak orang berdonasi</label>
    <textarea name="note" id="note" class="form-control">{{ isset($campaign) ? $campaign->note : '' }}</textarea>
</div>
<div class="form-group">
    <button type="button" class="btn btn-outline-primary" onclick="stepper.previous()">Sebelumnya</button>
    <button type="button" class="btn btn-primary" onclick="stepper.next()">Selanjutnya</button>
</div>
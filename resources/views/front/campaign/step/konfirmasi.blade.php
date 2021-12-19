<div class="form-group">
    <label for="receiver">Galang dana tersebut diperuntukan kepada?</label>
    <div class="custom-control custom-radio">
        <input type="radio" name="receiver" class="custom-control-input" id="saya" value="Saya Sendiri"
            {{ isset($campaign) && $campaign->receiver == 'Saya Sendiri' ? 'checked' : '' }}>
        <label class="custom-control-label font-weight-normal" for="saya">Saya Sendiri</label>
    </div>
    <div class="custom-control custom-radio">
        <input type="radio" name="receiver" class="custom-control-input" id="keluarga" value="Keluarga / Kerabat"
            {{ isset($campaign) && $campaign->receiver == 'Keluarga / Kerabat' ? 'checked' : '' }}>
        <label class="custom-control-label font-weight-normal" for="keluarga">Keluarga / Kerabat</label>
    </div>
    <div class="custom-control custom-radio">
        <input type="radio" name="receiver" class="custom-control-input" id="organisasi" value="Organisasi / Lembaga"
            {{ isset($campaign) && $campaign->receiver == 'Organisasi / Lembaga' ? 'checked' : '' }}>
        <label class="custom-control-label font-weight-normal" for="organisasi">Organisasi / Lembaga</label>
    </div>
    <div class="custom-control custom-radio">
        <input type="radio" name="receiver" class="custom-control-input" id="lainnya" value="Lainnya"
            {{ isset($campaign) && $campaign->receiver == 'Lainnya' ? 'checked' : '' }}>
        <label class="custom-control-label font-weight-normal" for="lainnya">Lainnya</label>
    </div>
</div>
<div class="alert alert-primary">
    Saya setuju dengan <strong>Syarat dan Ketentuan</strong> donasi di {{ $setting->company_name }}
</div>
<div class="form-group">
    <button type="button" class="btn btn-outline-primary" onclick="stepper.previous()">Sebelumnya</button>
    <button class="btn btn-primary">Selesai</button>
</div>
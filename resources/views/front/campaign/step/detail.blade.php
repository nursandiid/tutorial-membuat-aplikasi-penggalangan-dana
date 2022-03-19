<div class="form-group">
    <label for="goal">Target Donasi</label>
    <div class="input-group mb-3">
        <div class="input-group-prepend">
            <div class="input-group-text">Rp</div>
        </div>
        <input type="text" name="goal" id="goal" class="form-control" placeholder="0" value="{{ isset($campaign) ? format_uang($campaign->goal) : 0 }}" onkeyup="format_uang(this)">
    </div>
</div>
<div class="form-group">
    <label for="publish_date">Tanggal Publish</label>
    <div class="input-group datetimepicker" id="publish_date" data-target-input="nearest">
        <input type="text" name="publish_date" class="form-control datetimepicker-input" data-target="#publish_date" value="{{ isset($campaign) ? $campaign->publish_date : '' }}" />
        <div class="input-group-append" data-target="#publish_date" data-toggle="datetimepicker">
            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
        </div>
    </div>
</div>
<div class="form-group">
    <label for="end_date">Batas waktu penggalangan dana</label>
    <div class="input-group datetimepicker" id="end_date" data-target-input="nearest">
        <input type="text" name="end_date" class="form-control datetimepicker-input" data-target="#end_date"  value="{{ isset($campaign) ? $campaign->end_date : '' }}" />
        <div class="input-group-append" data-target="#end_date" data-toggle="datetimepicker">
            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
        </div>
    </div>
</div>
<div class="form-group">
    <button type="button" class="btn btn-outline-primary" onclick="stepper.previous()">Sebelumnya</button>
    <button type="button" class="btn btn-primary" onclick="stepper.next()">Selanjutnya</button>
</div>
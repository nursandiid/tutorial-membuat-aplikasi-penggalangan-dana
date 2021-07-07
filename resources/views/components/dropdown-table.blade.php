<div class="form-inline">
    <label for="rows">Tampilkan</label>
    <select name="rows" id="rows" class="custom-select mx-3"
        onchange="$(this.form).submit()">
        <option value="10" {{ request('rows') == '10' ? 'selected' : '' }}>10</option>
        <option value="25" {{ request('rows') == '25' ? 'selected' : '' }}>25</option>
        <option value="50" {{ request('rows') == '50' ? 'selected' : '' }}>50</option>
        <option value="100" {{ request('rows') == '100' ? 'selected' : '' }}>100</option>
    </select>
    <label for="rows">Entri</label>
</div>
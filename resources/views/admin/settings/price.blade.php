<form action="{{ route('admin.settings.update', 'price') }}" method="POST" class="card shadow">
    @csrf
    @method('PUT')

    <div class="card-header">
		<div class="row no-gutters">
			<div class="col">
				<h6 class="text-primary font-weight-bold">Harga</h6>
			</div>
		</div>
	</div>
    <div class="card-body">
		<div class="form-group">
            <label>Harga Per-Kubik</label>
            <input name="per_kubik" type="number" class="form-control" min="0" value="{{ $price->per_kubik }}" required>
        </div>
		<div class="form-group">
            <label>Harga Abudemen</label>
            <input name="abudemen" type="number" class="form-control" min="0" value="{{ $price->abudemen }}" required>
        </div>
    </div>
    <div class="card-footer d-flex justify-content-end">
        <button type="submit" class="btn btn-primary">Simpan</button>
    </div>
</form>
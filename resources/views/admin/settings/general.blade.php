<form action="{{ route('admin.settings.update', 'general') }}" method="POST" class="card shadow">
    @csrf
    @method('PUT')

    <div class="card-header">
		<div class="row no-gutters">
			<div class="col">
				<h6 class="text-primary font-weight-bold">General</h6>
			</div>
		</div>
	</div>
    <div class="card-body">
		<div class="form-group">
            <label>Nama Aplikasi</label>
            <input name="app_name" type="text" class="form-control" value="{{ $general->app_name }}" required>
        </div>
        <div class="form-group">
            <label>Rekening Info</label>
            <textarea name="mobile_rekening_info" class="form-control" required>{{ $general->mobile_rekening_info }}</textarea>
        </div>
    </div>
    <div class="card-footer d-flex justify-content-end">
        <button type="submit" class="btn btn-primary">Simpan</button>
    </div>
</form>
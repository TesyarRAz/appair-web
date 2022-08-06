<form class="modal fade" id="modal-import" method="POST" action="{{ route('admin.customer.import') }}" autocomplete="off" enctype="multipart/form-data">
	@csrf

	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<div class="modal-title">
					Import Customer
				</div>
				<button class="close" data-dismiss="modal" type="button">x</button>
			</div>
			<div class="modal-body">
				<div class="form-group">
					<label>Delimiter CSV</label>
					<input type="text" name="delimiter" class="form-control" required>
				</div>
				<div class="form-group">
					<label>Berkas CSV</label>
					<input type="file" name="berkas" class="form-control-file" accept=".csv" required>
					<span>Format : <br>(Nama, RT, Meteran Akhir, Email&lt;Opsional&gt;, Username&lt;Opsional&gt;, Password&lt;Opsional&gt;)</span>
				</div>
			</div>
			<div class="modal-footer justify-content-between">
				<button type="submit" class="btn btn-primary">Simpan</button>
				<button type="button" class="btn btn-outline-primary" data-dismiss="modal">Batalkan</button>
			</div>
		</div>
	</div>
</form>
<form action="{{ route('admin.customer.store') }}" method="POST" id="modal-create" class="modal fade" autocomplete="off">
    @csrf
    
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Tambah Customer</h4>
                <button type="button" class="close" data-dismiss="modal">
                    <span>x</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label class="font-weight-bold">Nama <span class="text-danger">*</span></label>
                    <input name="name" type="text" class="form-control" required>
                </div>
                <div class="form-group">
                    <label class="font-weight-bold">RT</label>
                    <input name="rt" type="number" class="form-control">
                </div>
                <div class="form-group">
                    <label class="font-weight-bold">Meteran Pertama</label>
                    <input name="meteran_pertama" type="number" class="form-control">
                </div>
                <div class="form-group">
                    <label class="font-weight-bold">Email</label>
                    <input name="email" type="email" class="form-control">
                </div>
                <div class="form-group">
                    <label class="font-weight-bold">Username</label>
                    <input name="username" type="text" class="form-control" placeholder="Bila dikosongkan, akan mengikuti email">
                </div>
                <div class="form-group">
                    <label class="font-weight-bold">Password</label>
                    <input name="password" type="text" class="form-control" placeholder="Bila dikosongkan, akan mengikuti username">
                </div>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="submit" class="btn btn-primary">Simpan</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batalkan</button>
            </div>
        </div>
    </div>
</form>
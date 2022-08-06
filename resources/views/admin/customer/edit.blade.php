<form method="POST" id="modal-edit" class="modal fade" autocomplete="off">
    @csrf
    @method('PUT')

    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Edit Customer</h4>
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
                    <input name="username" type="text" class="form-control" required>
                </div>
                <div class="form-group">
                    <label class="font-weight-bold">Password</label>
                    <input name="password" type="text" class="form-control">
                </div>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="submit" class="btn btn-primary">Simpan</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batalkan</button>
            </div>
        </div>
    </div>
</form>

@push('js')
    <script type="text/javascript">
        window.edit = function(id) {
            let modal = $("#modal-edit");

            let url_target = `{{ url('admin/customer') }}/${id}`;
            $.getJSON(url_target, function(data) {
                data.user.rt = data.rt;
                data.user.meteran_pertama = data.meteran_pertama;
                data = data.user;

                modal.find("input,textarea").val(function(index, value) {
                    if (this.type == 'checkbox' || this.type == 'radio') {
                        return value;
                    }
                    return ['_method', '_token'].includes(this.name) ? value : (data[this.name]);
                }).each(function() {
                    if (this.type == 'checkbox' || this.type == 'radio') {
                        $(this).prop('checked', Boolean(parseInt(data[this.name])));
                    }
                }).trigger("input");

				modal.attr('action', url_target);
				modal.modal();
            });
        }
    </script>
@endpush

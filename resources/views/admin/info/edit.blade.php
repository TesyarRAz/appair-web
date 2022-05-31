<form method="POST" id="modal-edit" class="modal fade" autocomplete="off" enctype="multipart/form-data" data-backdrop="static">
    @csrf
    @method('PUT')
    
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Edit Info</h4>
                <button type="button" class="close" data-dismiss="modal">
                    <span>x</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12 col-lg-6">
                        <div class="form-group">
                            <label class="font-weight-bold">Judul <span class="text-danger">*</span></label>
                            <input name="title" type="text" class="form-control" required>
                        </div>
                        <div class="form-group" data-toggle="image-preview">
                            <label class="font-weight-bold">Gambar</label>
                            <input type="file" name="image" class="d-none" data-source="true" accept="image/*">
                            <img src="{{ asset('empty-image.png') }}" role="button" class="d-block img-thumbnail" width="300" height="300" data-target="true">
                        </div>
                        <div class="form-group">
                            <label class="font-weight-bold">Link</label>
                            <input name="url" type="url" class="form-control">
                        </div>
                    </div>
                    <div class="col-12 col-lg-6">
                        <div class="form-group">
                            <label class="font-weight-bold">Deskripsi <span class="text-danger">*</span></label>
                            <textarea name="description" id="edit-editor" class="h-100"></textarea>
                        </div>
                    </div>
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

<script type="text/javascript" src="{{ asset('js/ckeditor/ckeditor.js') }}"></script>

<script type="text/javascript">
	$(function() {
		let editor = CKEDITOR.replace( document.querySelector('#edit-editor'), {
			filebrowserUploadUrl: '{{ route('admin.info.upload', ['_token' => csrf_token()]) }}',
			filebrowserUploadMethod: 'form',
            // disallowedContent: 'img{width,height}'
		});

        window.edit = function(id) {
            let modal = $("#modal-edit");

            let url_target = `{{ url('admin/info') }}/${id}`;
            $.getJSON(url_target, function(data) {
                modal.find("input,textarea").val(function(index, value) {
                    if (this.type == 'checkbox' || this.type == 'radio' || this.type == 'file') {
                        return value;
                    }
                    return ['_method', '_token', 'description'].includes(this.name) ? value : (data[this.name]);
                }).each(function() {
                    if (this.type == 'checkbox' || this.type == 'radio') {
                        $(this).prop('checked', Boolean(parseInt(data[this.name])));
                    } else if (this.type == 'file') {
                        let src = data[this.name];

                        $(this).siblings('img[data-target]').attr('src', src != null ? '{{ \Storage::disk('public')->url('') }}' + src : '{{ asset('empty-image.png') }}');
                    }
                }).trigger("input");

                editor.setData(data.description);

				modal.attr('action', url_target);
				modal.modal();
            });
        }
	});
</script>
@endpush
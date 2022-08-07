<form method="POST" id="modal-edit" class="modal fade" autocomplete="off" enctype="multipart/form-data" data-backdrop="static">
    @csrf
    @method('PUT')
    
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Bayar Transaksi</h4>
                <button type="button" class="close" data-dismiss="modal">
                    <span>x</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col">
                        <div class="form-group" x-data="{ status: '', keterangan_ditolak: '' }" x-init="$watch('status', value => keterangan_ditolak = (value != 'ditolak' ? '' : keterangan_ditolak))">
                            <div class="form-group">
                                <label class="font-weight-bold">Customer</label>
                                <select name="customer_id" class="form-control"></select>
                            </div>
                            <div class="form-group">
                                <label class="font-weight-bold">Tanggal Bayar</label>
                                <input type="date" class="form-control" name="tanggal_bayar" value="{{ now()->format('Y-m-d') }}" readonly required>
                            </div>
                            <div class="form-group">
                                <label class="font-weight-bold">Tanggal Tempo</label>
                                <input type="hidden" class="form-control" name="tanggal_tempo" value="{{ now()->endOfMonth()->format('Y-m-d') }}" required>

                                <div class="form-row">
                                    <div class="col">
                                        <input type="text" name="bulan_tempo" class="form-control" readonly>
                                    </div>
                                    <div class="col">
                                        <input type="text" name="tahun_tempo" class="form-control" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="font-weight-bold">Meteran Awal</label>
                                <input type="text" class="form-control" name="meteran_awal" value="0" required>
                            </div>
                            <div class="form-group">
                                <label class="font-weight-bold">Meteran Akhir</label>
                                <input type="text" class="form-control" name="meteran_akhir" value="0" required>
                            </div>
                            <div class="form-group">
                                <label class="font-weight-bold">Status</label>
                                <select name="status" class="form-control" x-model="status" required>
                                    <option value="belum_bayar">Belum Bayar</option>
                                    <option value="diterima">Diterima</option>
                                    <option value="ditolak">Ditolak</option>
                                    <option value="lewati">Lewati</option>
                                    <option value="lunas" selected>Lunas</option>
                                </select>
                            </div>
                            <div class="form-group" x-bind:class="status != 'ditolak' ? 'd-none' : ''">
                                <label class="font-weight-bold">Keterangan Ditolak</label>
                                <textarea name="keterangan_ditolak" class="form-control" rows="3" x-model="keterangan_ditolak"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg">
                        <div class="form-group d-none">
                            <label class="font-weight-bold">Total Bayar</label>
                            <input type="text" class="form-control" name="total_bayar" value="0" required>
                        </div>
                        <div class="form-group">
                            <label class="font-weight-bold">Total Harga</label>
                            <input type="text" class="form-control" name="total_harga" value="0" required>
                        </div>
                        <div class="form-group" data-toggle="image-preview">
                            <label class="font-weight-bold">Bukti Bayar</label>
                            <input type="file" name="bukti_bayar" class="d-none" data-source="true" accept="image/*">
                            <img src="{{ asset('empty-image.png') }}" role="button" class="d-block img-thumbnail" width="300" height="300" data-target="true">
                        </div>
                        <div class="form-group">
                            <span class="text-muted font-italic small">Catatan</span>
                            <br>
                            <span class="small">Harga Per Kubik : Rp. {{ number_format($price, 0, ',', '.') }}</span>
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
<script type="text/javascript">
    $(function() {
        let modal = $('#modal-edit');

        let price = {{ $price }};

        let customerElement = modal.find("select[name=customer_id]").select2({
            disabled: true,
			placeholder: 'Cari',
			theme: 'bootstrap',
			ajax: {
				url: '{{ route('admin.customer.index') }}',
				type: 'get',
				dataType: 'json',
				delay: 250,
				data: function(params) {
					return {
						search: params.term,
						type: 'select2',
					};
				},
				processResults: data => ({
					results: $.map(data, item => ({
						text: `${item.user.name} - ${item.id}`,
						id: item.id,
                        item,
					}))
				}),
				cache: true
			}
		});

        modal.find('input[name=meteran_akhir]').on('change', function() {
            let meteran_awal = modal.find('input[name=meteran_awal]').val();
            let meteran_akhir = modal.find('input[name=meteran_akhir]').val();
            let total_harga = (meteran_akhir - meteran_awal) * price;

            modal.find('input[name=total_harga]').val(total_harga).trigger('input');
        });

        modal.find('input[name=total_harga]').mask('000.000.000', {
            reverse: true,
        });

        window.edit = function(id) {
            let modal = $("#modal-edit");

            let url_target = `{{ url('admin/transaksi') }}/${id}`;
            $.getJSON(url_target, function(data) {
                modal.find("input,textarea,select").val(function(index, value) {
                    if (this.type == 'checkbox' || this.type == 'radio' || this.type == 'file') {
                        return value;
                    }

                    if (data[this.name] == null) {
                        return value;
                    }

                    return ['_method', '_token'].includes(this.name) ? value : (data[this.name]);
                }).each(function() {
                    if (this.type == 'checkbox' || this.type == 'radio') {
                        $(this).prop('checked', Boolean(parseInt(data[this.name])));
                    } else if (this.type == 'file') {
                        let src = data[this.name];

                        $(this).siblings('img[data-target]').attr('src', src != null ? '{{ \Storage::disk('public')->url('') }}' + src : '{{ asset('empty-image.png') }}');
                    }
                }).trigger("input");

                customerElement.select2("trigger", "select", {
					data: {
						text: `${data.customer.user.name} - ${data.id}`,
						id: data.customer.id,
					}
				});

                modal.find('input[name=bulan_tempo]').val(dayjs(modal.find('input[name=tanggal_tempo]').val()).format('MMMM'));
                modal.find('input[name=tahun_tempo]').val(dayjs(modal.find('input[name=tanggal_tempo]').val()).format('YYYY'));

				modal.attr('action', url_target);
				modal.modal();
            });
        }
    })
</script>
@endpush
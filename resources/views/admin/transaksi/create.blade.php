<form action="{{ route('admin.transaksi.store') }}" method="POST" id="modal-create" class="modal fade" autocomplete="off" enctype="multipart/form-data" data-backdrop="static">
    @csrf
    
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Tambah Transaksi</h4>
                <button type="button" class="close" data-dismiss="modal">
                    <span>x</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12 col-lg-6">
                        <div class="form-group" x-data="{ status: '', keterangan_ditolak: '' }" x-init="$watch('status', value => keterangan_ditolak = (value != 'ditolak' ? '' : keterangan_ditolak))">
                            <div class="form-group">
                                <label class="font-weight-bold">Customer</label>
                                <select name="customer_id" class="form-control" required></select>
                            </div>
                            <div class="form-group">
                                <label class="font-weight-bold">Tanggal Bayar</label>
                                <input type="date" class="form-control" name="tanggal_bayar" value="{{ now()->format('Y-m-d') }}" required>
                            </div>
                            <div class="form-group">
                                <label class="font-weight-bold">Tanggal Tempo</label>
                                <input type="date" class="form-control" name="tanggal_tempo" value="{{ now()->endOfMonth()->format('Y-m-d') }}" required>
                            </div>
                            <div class="form-group">
                                <label class="font-weight-bold">Total Bayar</label>
                                <input type="text" class="form-control" name="total_bayar" value="{{ $price }}" required>
                            </div>
                            <div class="form-group">
                                <label class="font-weight-bold">Total Harga</label>
                                <input type="text" class="form-control" name="total_harga" value="0" required>
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
                    <div class="col-12 col-lg-6">
                        <div class="form-group">
                            <label class="font-weight-bold">Meteran Awal</label>
                            <input type="text" class="form-control" name="meteran_awal" value="0" required>
                        </div>
                        <div class="form-group">
                            <label class="font-weight-bold">Meteran Akhir</label>
                            <input type="text" class="form-control" name="meteran_akhir" value="0" required>
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
        const modal = $('#modal-create');

        const price = {{ $price }};

        const customerElement = modal.find("select[name=customer_id]").select2({
			placeholder: 'Cari',
			theme: 'bootstrap',
			ajax: {
				url: '{{ route('admin.customer.index', ['with' => 'latestTransaksi']) }}',
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
                        item
					}))
				}),
				cache: true
			}
		});

        customerElement.on('select2:select', e => {
			const customer = e.params.data.item;
            
            modal.find('input[name=meteran_awal]').val(customer.last_meter || 0)
		});
    })
</script>
@endpush
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
            <input id="per_kubik" name="per_kubik" type="text" class="form-control" value="{{ $price->per_kubik }}"
                required>
        </div>
        <div class="form-group">
            <label>Harga Abudemen</label>
            <input id="abudemen" name="abudemen" type="text" class="form-control" value="{{ $price->abudemen }}"
                required>
        </div>
    </div>
    <div class="card-footer d-flex justify-content-end">
        <button type="submit" class="btn btn-primary">Simpan</button>
    </div>
</form>

@push('js')
    <script src="{{ asset('js/jquery.mask.min.js') }}"></script>

    <script type="text/javascript">
        $(function() {
            $('#per_kubik, #abudemen').mask('000.000.000', {
                reverse: true,
            });
        })
    </script>
@endpush

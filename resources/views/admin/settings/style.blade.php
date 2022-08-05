<form action="{{ route('admin.settings.update', 'style') }}" method="POST" class="card shadow"
    enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div class="card-header">
        <div class="row no-gutters">
            <div class="col">
                <h6 class="text-primary font-weight-bold">Style</h6>
            </div>
        </div>
    </div>
    <div class="card-body" x-data="{ type: '{{ $style->bg_type }}' }">
        {{-- <div class="form-group" data-toggle="image-preview">
            <label>Gambar Aplikasi</label>
            <input type="file" name="app_image" class="d-none" data-source="true" accept="image/*">
            <img src="{{ asset('empty-image.png') }}" role="button" class="d-block img-thumbnail" width="300"
                height="300" data-target="true">
        </div> --}}
        <div class="form-group">
            <nav class="nav nav-pills nav-justified mb-2">
                <input type="hidden" name="bg_type" x-model="type">
                <a class="nav-item nav-link" href="#" x-on:click.prevent="type = 'image'"
                    :class="type == 'image' && ['active', 'bg-info']">Gambar</a>
                <a class="nav-item nav-link" href="#" x-on:click.prevent="type = 'color'"
                    :class="type == 'color' && ['active', 'bg-info']">Warna</a>
            </nav>
        </div>
        <div x-show="type == 'color'" x-transition class="form-group">
            <label>Warna Background</label>
            <input name="bg_color" type="color" class="form-control" value="{{ $style->bg_color }}" required>
        </div>
        <div x-show="type == 'image'" x-transition class="form-group" data-toggle="image-preview">
            <label>Gambar Background</label>
            <input type="file" name="bg_image" class="d-none" data-source="true" accept="image/*">
            <img src="{{ \Storage::disk('public')->url($style->bg_image) ?? asset('empty-image.png') }}" role="button" class="d-block img-thumbnail" width="300"
                height="300" data-target="true">
        </div>
    </div>
    <div class="card-footer d-flex justify-content-end">
        <button type="submit" class="btn btn-primary">Simpan</button>
    </div>
</form>

@push('js')
    <script src="https://unpkg.com/alpinejs"></script>
@endpush

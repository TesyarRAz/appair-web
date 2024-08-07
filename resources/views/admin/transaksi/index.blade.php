@extends('layouts.admin')

@section('content')

@include('admin.transaksi.create')
@include('admin.transaksi.edit')

<div class="card shadow">
    <div class="card-header">
		<div class="row no-gutters">
			<div class="col">
				<h6 class="text-primary font-weight-bold">Daftar Transaksi</h6>
			</div>
			<div class="ml-auto">
				{{-- <button type="button" class="btn btn-sm btn-outline-primary" data-toggle="modal" data-target="#modal-create">
					<i class="fas fa-plus"></i>
					Tambah
				</button> --}}
			</div>
		</div>
	</div>
    <div class="card-body">
		<form class="form-group" action="{{ route('admin.transaksi.index') }}" method="get" id="form-filter-status">
    		<nav class="nav nav-pills nav-justified mb-2" x-data="{ status: '{{ in_array(request()->status, ['belum_bayar', 'diterima', 'ditolak', 'lewati', 'lunas']) ? request()->status : 'belum_bayar' }}' }" x-init="$watch('status', () => $('#form-filter-status').trigger('change'))">
				<input type="hidden" name="status" x-model="status">
				<a class="nav-item nav-link" href="#" x-on:click="status = 'belum_bayar'" :class="status == 'belum_bayar' && ['active', 'bg-primary']">Belum Bayar</a>
				<a class="nav-item nav-link" href="#" x-on:click="status = 'diterima'" :class="status == 'diterima' && ['active', 'bg-primary']">Diterima</a>
				<a class="nav-item nav-link" href="#" x-on:click="status = 'ditolak'" :class="status == 'ditolak' && ['active', 'bg-primary']">Ditolak</a>
				<a class="nav-item nav-link" href="#" x-on:click="status = 'lewati'" :class="status == 'lewati' && ['active', 'bg-primary']">Dilewati</a>
				<a class="nav-item nav-link" href="#" x-on:click="status = 'lunas'" :class="status == 'lunas' && ['active', 'bg-primary']">Lunas</a>
			</nav>
    	</form>

		<form class="form-group" action="{{ route('admin.transaksi.index') }}" method="get" id="form-filter-tanggal">
    		<div class="form-row no-gutters align-items-center">
				<div class="col-lg-4">
					<input type="date" name="from" class="form-control form-control-sm">
				</div>
				<div class="col-auto">
					-
				</div>
				<div class="col-lg-4">
					<input type="date" name="to" class="form-control form-control-sm">
				</div>
			</div>
    	</form>
		<hr>

        {{ $dataTable->table() }}
    </div>
</div>
@endsection

@push('js')
<script src="{{ asset('js/jquery.mask.min.js') }}"></script>
<script src="{{ asset('js/dayjs.min.js') }}"></script>
<script src="{{ asset('js/dayjs-id.js') }}"></script>

{{ $dataTable->scripts() }}

<script type="text/javascript">
    $(function() {
		dayjs.locale('id')

        $("#form-filter-status, #form-filter-tanggal").on('change', function() {
			LaravelDataTables["dataTableBuilder"].ajax.reload()
		})
    })

	function dialogImage(url) {
		Swal.fire({
			imageUrl: url,
			showCancelButton: false,
			showConfirmButton: false
		})
	}
</script>
@endpush
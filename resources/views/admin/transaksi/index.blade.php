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
				<button type="button" class="btn btn-sm btn-outline-primary" data-toggle="modal" data-target="#modal-create">
					<i class="fas fa-plus"></i>
					Tambah
				</button>
			</div>
		</div>
	</div>
    <div class="card-body">
		<form class="form-group" action="{{ route('admin.transaksi.index') }}" method="get" id="form-filter-status">
    		<nav class="nav nav-pills nav-justified mb-2" x-data="{ status: '{{ in_array(request()->status, ['diterima', 'ditolak', 'lewati', 'lunas']) ? request()->status : 'diterima' }}' }" x-init="$watch('status', () => $('#form-filter-status').trigger('change'))">
				<input type="hidden" name="status" x-model="status">
				<a class="nav-item nav-link" href="#" x-on:click="status = 'diterima'" :class="status == 'diterima' && ['active', 'bg-primary']">Diterima</a>
				<a class="nav-item nav-link" href="#" x-on:click="status = 'ditolak'" :class="status == 'ditolak' && ['active', 'bg-primary']">Ditolak</a>
				<a class="nav-item nav-link" href="#" x-on:click="status = 'lewati'" :class="status == 'lewati' && ['active', 'bg-primary']">Dilewati</a>
				<a class="nav-item nav-link" href="#" x-on:click="status = 'lunas'" :class="status == 'lunas' && ['active', 'bg-primary']">Lunas</a>
			</nav>
    	</form>

		<form class="form-group" action="{{ route('admin.transaksi.index') }}" method="get" id="form-filter-tanggal">
    		<div class="form-row no-gutters align-items-center">
				<div class="col-lg-4">
					<input type="date" name="from" class="form-control form-control-sm" value="{{ now()->subMonth(1)->format('Y-m-d') }}">
				</div>
				<div class="col-auto">
					-
				</div>
				<div class="col-lg-4">
					<input type="date" name="to" class="form-control form-control-sm" value="{{ now()->format('Y-m-d') }}">
				</div>
			</div>
    	</form>
		<hr>

        {{ $dataTable->table() }}
    </div>
</div>
@endsection

@push('js')
{{ $dataTable->scripts() }}

<script type="text/javascript">
    $(function() {
        $("#form-filter-status, #form-filter-tanggal").on('change', function() {
			LaravelDataTables["dataTableBuilder"].ajax.reload()
		})
    })
</script>
@endpush
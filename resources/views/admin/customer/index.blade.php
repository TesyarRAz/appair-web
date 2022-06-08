@extends('layouts.admin')

@section('content')

@include('admin.customer.create')
@include('admin.customer.edit')
@include('admin.customer.import')

<div class="card shadow">
    <div class="card-header">
		<div class="row no-gutters">
			<div class="col">
				<h6 class="text-primary font-weight-bold">Daftar Customer</h6>
			</div>
			<div class="ml-auto">
				<button type="button" class="btn btn-sm btn-outline-primary" data-toggle="modal" data-target="#modal-import">
					<i class="fas fa-download"></i>
					Import
				</button>
				<button type="button" class="btn btn-sm btn-outline-primary" data-toggle="modal" data-target="#modal-create">
					<i class="fas fa-plus"></i>
					Tambah
				</button>
			</div>
		</div>
	</div>
    <div class="card-body">
        {{ $dataTable->table() }}
    </div>
</div>
@endsection

@push('js')
{{ $dataTable->scripts() }}
@endpush
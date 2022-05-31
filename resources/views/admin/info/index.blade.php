@extends('layouts.admin')

@section('content')

@include('admin.info.create')
@include('admin.info.edit')

<div class="card shadow">
    <div class="card-header">
		<div class="row no-gutters">
			<div class="col">
				<h6 class="text-primary font-weight-bold">Daftar Info</h6>
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
        {{ $dataTable->table() }}
    </div>
</div>
@endsection

@push('js')
{{ $dataTable->scripts() }}
@endpush
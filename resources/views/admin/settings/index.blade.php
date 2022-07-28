@extends('layouts.admin')

@section('content')

<h4>Pengaturan</h4>

<div class="row mt-5">
	<div class="col-lg-4 col-md-6">
		@include('admin.settings.price')
	</div>
	<div class="col-lg-4 col-md-6">
		@include('admin.settings.style')
	</div>
	<div class="col-lg-4 col-md-6">
		@include('admin.settings.tools')
	</div>
</div>

@endsection
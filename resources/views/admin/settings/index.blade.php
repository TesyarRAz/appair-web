@extends('layouts.admin')

@section('content')

<h4>Pengaturan</h4>

<div class="card-columns mt-5">
	@include('admin.settings.general')
	@include('admin.settings.price')
	@include('admin.settings.style')
	@include('admin.settings.tools')
</div>

@endsection
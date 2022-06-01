@extends('layouts.sb-admin')


@section('sidebar')
<!-- Nav Item - Dashboard -->
<li class="nav-item {{ request()->routeIs('home') ? 'active' : '' }}">
	<a class="nav-link" href="{{ route('home') }}">
		<i class="fas fa-fw fa-tachometer-alt"></i>
		<span>Dashboard</span>
	</a>
</li>

<!-- Divider -->
<hr class="sidebar-divider">

<li class="nav-item {{ request()->routeIs('admin.customer.*') ? 'active' : '' }}">
	<a class="nav-link" href="{{ route('admin.customer.index') }}">
		<i class="fas fa-fw fa-user"></i>
		<span>Kelola Customer</span>
	</a>
</li>
<li class="nav-item {{ request()->routeIs('admin.info.*') ? 'active' : '' }}">
	<a class="nav-link" href="{{ route('admin.info.index') }}">
		<i class="fas fa-fw fa-newspaper"></i>
		<span>Kelola Info</span>
	</a>
</li>
<li class="nav-item {{ request()->routeIs('admin.transaksi.*') ? 'active' : '' }}">
	<a class="nav-link" href="{{ route('admin.transaksi.index') }}">
		<i class="fas fa-fw fa-money-bill-wave"></i>
		<span>Kelola Transaksi</span>
	</a>
</li>

@if(auth()->user()->hasRole('superadmin'))
<!-- Heading -->
<div class="sidebar-heading">
	Lainnya
</div>
<!-- Heading -->
<li class="nav-item {{ request()->routeIs('superadmin.setting.*') ? 'active' : '' }}">
	<a class="nav-link" href="{{ route('superadmin.setting.index') }}">
		<i class="fas fa-fw fa-cog"></i>
		<span>Persyaratan</span>
	</a>
</li>
@endif


<!-- Divider -->
<hr class="sidebar-divider">
@endsection

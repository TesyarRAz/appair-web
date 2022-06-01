<!DOCTYPE html>
<html lang="id">
<head>
	<meta charset="utf-8">
	<title>{{ config('app.name') }} - @yield('title')</title>
	@unless(isset($without_viewport) && $without_viewport)
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	@endunless
	<meta name="csrf-token" content="{{ csrf_token() }}">
	
	<link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
	<link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
	<link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
	<link rel="mask-icon" href="/safari-pinned-tab.svg" color="#5bbad5">
	<meta name="msapplication-TileColor" content="#00aba9">
	<meta name="theme-color" content="#ffffff">

	{{-- Bootstrap --}}
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
	{{-- SB Admin --}}
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/startbootstrap-sb-admin-2/4.1.3/css/sb-admin-2.min.css" integrity="sha512-RIG2KoKRs0GLkvl0goS0cdkTgQ3mOiF/jupXuBsMvyB3ITFpTJLnBu59eE+0R39bxDQKo2dsatA5CwHeIKVFcw==" crossorigin="anonymous" />

	{{-- Font Awesome --}}
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css"/>

	{{-- DataTables --}}
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.24/css/dataTables.bootstrap4.min.css">

	<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.0.3/css/buttons.dataTables.min.css">

	{{-- DataTables Responsive --}}
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.2.7/css/responsive.bootstrap4.min.css">

	{{-- Select2 --}}
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" integrity="sha512-nMNlpuaDPrqlEls3IX/Q56H36qvBASwb3ipuo3MxeWbsQB1881ox0cRv7UPTgBlriqoynt35KjEwgGUeUXIPnw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-theme@0.1.0-beta.10/dist/select2-bootstrap.min.css" integrity="sha256-nbyata2PJRjImhByQzik2ot6gSHSU4Cqdz5bNYL2zcU=" crossorigin="anonymous">
	
	@stack('css')
</head>
<body>
	@if(isset($without_default_container) && $without_default_container)
	@yield('container')
	@else
	<!-- Page Wrapper -->
	<div id="wrapper">

		<!-- Sidebar -->
		<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion toggled" id="accordionSidebar">

			<!-- Sidebar - Brand -->
			<a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('home') }}">
				<div class="sidebar-brand-icon">
					<i class="fas fa-water"></i>
				</div>
				<div class="sidebar-brand-text mx-3">
					AppAir
				</div>
			</a>

			<!-- Divider -->
			<hr class="sidebar-divider my-0">

			@yield('sidebar')

			<div class="text-center d-none d-md-inline">
	            <button class="rounded-circle border-0" id="sidebarToggle"></button>
	        </div>
		</ul>
		<!-- End of Sidebar -->

		<!-- Content Wrapper -->
		<div id="content-wrapper" class="d-flex flex-column">

			<!-- Main Content -->
			<div id="content">

				<!-- Topbar -->
				<nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

					<!-- Sidebar Toggle (Topbar) -->
					<button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
						<i class="fa fa-bars"></i>
					</button>

					<!-- Topbar Navbar -->
					<ul class="navbar-nav ml-auto">

						<!-- Nav Item - User Information -->
						<li class="nav-item dropdown no-arrow">
							<a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								<span class="mr-2 d-lg-inline text-gray-600 small">
									{{ auth()->user()->name }}
								</span>
							</a>
							<!-- Dropdown - User Information -->
							<div class="dropdown-menu dropdown-menu-right shadow animated--grow-in">
								<a class="dropdown-item" href="{{ route('admin.account.index') }}">
									<i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
									Account
								</a>
								<a class="dropdown-item" href="{{ route('logout') }}">
									<i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
									Logout
								</a>
							</div>
						</li>

					</ul>

				</nav>
				<!-- End of Topbar -->

				<!-- Begin Page Content -->
				<div class="container-fluid">

					<!-- Page Heading -->
					<div class="d-sm-flex align-items-center justify-content-between mb-4">
						<h1 class="h3 mb-0 text-gray-800">
							@yield('content_header')
						</h1>
					</div>
					@stack('before_section')
					@yield('content')
				</div>
				<!-- Footer -->
				<!-- <footer class="sticky-footer bg-white">
					<div class="container my-auto">
						<div class="copyright text-center my-auto">
							<span>Copyright &copy; TesyarRAz 2021</span>
						</div>
					</div>
				</footer> -->
				<!-- End of Footer -->
			</div>
			<!-- End of Content Wrapper -->
		</div>
	</div>
	@endif
	
	{{-- Lodash --}}
	<script src="https://cdnjs.cloudflare.com/ajax/libs/lodash.js/4.17.21/lodash.min.js" integrity="sha512-WFN04846sdKMIP5LKNphMaWzU7YpMyCU245etK3g/2ARYbPK9Ub18eG+ljU96qKRCWh+quCY7yefSmlkQw1ANQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

	{{-- JQuery --}}
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js" integrity="sha512-bLT0Qm9VnAYZDflyKcBaQ2gg0hSYNQrJ8RilYldYQ1FxQYoCLtUjuuRuZo+fjqhx/qtq/1itJ0C2ejDxltZVFg==" crossorigin="anonymous"></script>
	
	{{-- SB Admin --}}
	<script src="https://cdnjs.cloudflare.com/ajax/libs/startbootstrap-sb-admin-2/4.1.3/js/sb-admin-2.min.js" integrity="sha512-COtY6/Rv4GyQdDShOyay/0YI4ePJ7QeKwtJIOCQ3RNE32WOPI4IYxq6Iz5JWcQpnylt/20KBvqEROZTEj/Hopw==" crossorigin="anonymous"></script>
	<script type="text/javascript">
		$(function() {
			$(window).off("resize");
		})
	</script>

	{{-- SweetAlert --}}
	@include('sweetalert::alert')

	{{-- Bootstrap --}}
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>

	{{-- JQuery MaskMoney --}}
	{{-- <script src="https://cdn.jsdelivr.net/npm/jquery-mask-plugin@1.14.16/dist/jquery.mask.min.js" integrity="sha256-Kg2zTcFO9LXOc7IwcBx1YeUBJmekycsnTsq2RuFHSZU=" crossorigin="anonymous"></script> --}}

	{{-- DataTables --}}
	<script type="text/javascript" src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
	<script type="text/javascript" src="https://cdn.datatables.net/1.10.24/js/dataTables.bootstrap4.min.js"></script>

	{{-- DataTables Responsive --}}
	<script type="text/javascript" src="https://cdn.datatables.net/responsive/2.2.7/js/dataTables.responsive.min.js"></script>
	<script type="text/javascript" src="https://cdn.datatables.net/responsive/2.2.7/js/responsive.bootstrap4.min.js"></script>

	{{-- Image Preview --}}
	<script type="text/javascript" src="{{ asset('js/image-preview.js') }}"></script>

	{{-- Password Preview --}}
	<script type="text/javascript" src="{{ asset('js/password-preview.js') }}"></script>
	
	<script src="https://cdn.datatables.net/buttons/1.0.3/js/dataTables.buttons.min.js"></script>
	<script type="text/javascript" src="{{ asset('vendor/datatables/buttons.server-side.js') }}"></script>

	{{-- popper.js --}}
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.9.2/umd/popper.min.js" integrity="sha512-2rNj2KJ+D8s1ceNasTIex6z4HWyOnEYLVC3FigGOmyQCZc2eBXKgOxQmo3oKLHyfcj53uz4QMsRCWNbLd32Q1g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
	<script type="text/javascript">
		$(function () {
		  $('[data-toggle="popover"]').popover({
		  	html: true,
		  })
		})
	</script>

	{{-- AlphineJs --}}
	<script src="https://cdnjs.cloudflare.com/ajax/libs/alpinejs/3.7.0/cdn.min.js" integrity="sha512-snKy1ArwmuMarok87UQk7lVf2AmQ/Mw2Zv2ziPX0hpoAu/uGQSxf0AaqtQPgp0DJ51Kb7veRL4aNcIIBlk8YSQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

	{{-- Select2 --}}
	<script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.full.min.js" integrity="sha256-vjFnliBY8DzX9jsgU/z1/mOuQxk7erhiP0Iw35fVhTU=" crossorigin="anonymous"></script>

	{{-- DayJs --}}
	<script src="https://unpkg.com/dayjs@1.8.21/dayjs.min.js"></script>

	{{-- MaxLength Fixer --}}
	<script type="text/javascript" src="{{ asset('js/max-length-fixer.js') }}"></script>

	{{-- Default Datatable --}}
	<script type="text/javascript">
		// Add responsive by default
		$.extend( $.fn.dataTable.defaults, {
		    responsive: true,
		} );
	</script>

	{{-- Muncul Notif Saat Error --}}
	<script type="text/javascript">
		@if (session()->has('status'))
			Swal.fire("Informasi", '{!! session('status') !!}', 'info');
		@endif
		@if ($errors->any())
			Swal.fire("Error", '{!! $errors->first() !!}', 'error');
		@endif
	</script>

	<script type="text/javascript">
		$(function() {
			if ($(document).width() > 992) {
				$(".sidebar").removeClass('toggled');
			}
		});
	</script>

	@stack('js')

</body>
</html>
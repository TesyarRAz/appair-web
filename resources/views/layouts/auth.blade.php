<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>@yield('title') - {{ config('app.name') }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css" integrity="sha512-HK5fgLBL+xu6dm/Ii3z4xhlSUyZgTT9tuc/hSrtw6uzJOvgRr2a9jyxxT1ely+B+xFAmJKVSTbpM/CuL7qxO8w==" crossorigin="anonymous" />
    
    <style type="text/css">
        html, body {
            height: 100%;
        }
    </style>

    @stack('css')
</head>
<body class="vh-100">
    <div class="container-fluid">
        @yield('content')
    </div>
    
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
    
    {{-- Password Preview --}}
    <script type="text/javascript" src="{{ asset('js/password-preview.js') }}"></script>

    {{-- MaxLength Fixer --}}
    <script type="text/javascript" src="{{ asset('js/max-length-fixer.js') }}"></script>

    {{-- SweetAlert --}}
	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

	{{-- Muncul Notif Saat Error --}}
	<script type="text/javascript">
		@if (session()->has('status'))
			Swal.fire("Informasi", '{!! session('status') !!}', 'info');
		@endif
		@if ($errors->any())
			Swal.fire("Error", '{!! $errors->first() !!}', 'error');
		@endif
	</script>

    @stack('js')
</body>
</html>
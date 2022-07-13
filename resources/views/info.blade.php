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

	{{-- Font Awesome --}}
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css"/>
	
    @stack('css')
</head>
<body>
    <div class="container mt-5">
        <h4 class="text-center">{{ $info->title }}</h4>
        @if(filled($info->image))
        <img src="{{ $info->image }}" alt="image.png" class="img-fluid mx-0">
        @endif
        <div class="mt-5">
            {!! $info->description !!}
        </div>
    </div>

	{{-- Bootstrap --}}
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
</body>
</html>
@extends('layouts.auth')

@section('title', 'Login')

@push('css')
<style type="text/css">
    body {
        @if ($style->bg_type == 'color')
            background-color: {{ $style->bg_color }};
        @else
            background-image: url('{{ \Storage::disk('public')->url($style->bg_image) }}');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
        @endif

        height:100vh;
    }
</style>
@endpush

@section('content')
<div class="row justify-content-center align-items-center vh-100 m-0">
    <div class="col-lg-4 col-md-6 col-sm-8 h-50">
        <form action="{{ route('postLogin') }}" method="post" class="card" autocomplete="off">
            @csrf
            <div class="card-header bg-white">
                <h2 class="text-center font-weight-bold mb-4">{{ $general->app_name }}</h2>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <label>Username / Email</label>
                    <div class="input-group">
                        <input type="text" class="form-control @error('username_or_email') is-invalid @enderror" name="username_or_email" placeholder="Username" required>
                        <div class="input-group-append">
                            <span class="input-group-text">
                                <i class="fas fa-envelope"></i>
                            </span>
                        </div>
                        @error('username_or_email')
                        <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="form-group">
                    <label>Password</label>
                    <div class="input-group" data-toggle="password-preview">
                        <input class="form-control @error('password') is-invalid @enderror" name="password" class="form-control" placeholder="Password" type="password" required data-source>
                        <div role="button" class="input-group-append" data-target>
                            <span class="input-group-text">
                                <i class="fa fa-eye-slash" aria-hidden="true"></i>
                            </span>
                        </div>
                        @error('password')
                        <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="form-group">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                        <label for="remember-me" class="form-check-label">Remember Me</label>
                    </div>
                </div>
            </div>
            <div class="card-footer bg-white">
                <button id="button" type="submit" class="btn btn-primary btn-block font-weight-bold">Login</button>
            </div>
        </form>
    </div>
</div>
@endsection
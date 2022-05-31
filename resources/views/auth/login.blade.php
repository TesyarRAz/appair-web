@extends('layouts.auth')

@section('title', 'Login')

@section('content')
<div class="row justify-content-center align-items-center vh-100 m-0">
    <div class="col-lg-4 col-md-6 col-sm-8 h-50">
        <form action="{{ route('postLogin') }}" method="post" class="card" autocomplete="off">
            @csrf
            <div class="card-header bg-primary">
                <div class="card-title text-white">
                    <h3>Login</h3>
                </div>
            </div>
            <div class="card-body mt-3">
                <div class="form-group">
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
            </div>
            <div class="card-footer bg-white">
                <button id="button" type="submit" class="btn btn-primary btn-block font-weight-bold">Login</button>
            </div>
        </form>
    </div>
</div>
@endsection
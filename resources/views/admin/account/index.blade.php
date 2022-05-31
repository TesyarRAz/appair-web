@extends('layouts.admin')

@section('content')
<div class="card">
    <div class="card-header bg-primary text-white">
        <span class="card-title">Kelola Password</span>
    </div>

    <div class="card-body">
        <form action="{{ route('admin.account.password') }}" method="post">
            @csrf

            <div class="form-row mb-3">
                <div class="col-md-3">
                    <label>Username</label>
                </div>

                <div class="col input-group">
                    <input type="text" class="form-control" value="{{auth()->user()->username}}" name="username" required>
                </div>
            </div>
            <div class="form-row mb-3">
                <div class="col-md-3">
                    <label>Old Password</label>
                </div>
                <div class="col input-group" data-toggle="password-preview">
                    <input class="form-control" name="old_password" class="form-control" type="password" data-source>
                    <div role="button" class="input-group-append" data-target>
                        <span class="input-group-text">
                            <i class="fa fa-eye-slash" aria-hidden="true"></i>
                        </span>
                    </div>
                </div>
            </div>

            <div class="form-row mb-3">
                <div class="col-md-3">
                    <label>New Password</label>
                </div>
                <div class="col input-group" data-toggle="password-preview">
                    <input class="form-control" name="new_password" class="form-control" type="password" data-source>
                    <div role="button" class="input-group-append" data-target>
                        <span class="input-group-text">
                            <i class="fa fa-eye-slash" aria-hidden="true"></i>
                        </span>
                    </div>
                </div>
            </div>

            <div class="form-row mb-3">
                <div class="col-md-3">
                    <label>Confirm New Password</label>
                </div>
                <div class="col input-group" data-toggle="password-preview">
                    <input class="form-control" name="new_password_confirmation" class="form-control" type="password" data-source>
                    <div role="button" class="input-group-append" data-target>
                        <span class="input-group-text">
                            <i class="fa fa-eye-slash" aria-hidden="true"></i>
                        </span>
                    </div>
                </div>
            </div>


            <div class="clearfix">
                <button type="submit" class="btn btn-primary float-right">Simpan</button>
            </div>
        </form>
    </div>
</div>
@endsection

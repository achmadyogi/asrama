@extends('layouts.app')

@section('content')
<div class="container">
    <div class="form-group">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading"><h2>Edit Profile</h2></div>
                <div class="panel-body">
                    <form action="{{ route('editprofile') }}" method="POST" class="form-horizontal">
                    {{ csrf_field() }}
                        <div class="col-md-12">
                            <div class="col-md-4">
                                <img src="http://localhost:8000/img/guest.png" style="width: 80%; margin: 5px;" />
                            </div>
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label for="id" class="col-md-3 control-label">ID User</label>
                                    <div class="col-md-8">
                                        <input type="text" name="id" id="id" class="form-control" value="#{{ Auth::user()->id }}" readonly="readonly">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="id" class="col-md-3 control-label">Username</label>
                                    <div class="col-md-8">
                                        <input type="text" name="username" id="username" class="form-control" value="{{ Auth::user()->username }}" readonly="readonly">
                                    </div>
                                </div>
                                <div class="form-group{{ $errors->has('nama') ? ' has-error' : '' }}">
                                    <label for="id" class="col-md-3 control-label">Nama</label>
                                    <div class="col-md-8">
                                        <input type="text" name="nama" id="nama" class="form-control" value="{{ Auth::user()->nama }}" required>
                                        @if ($errors->has('nama'))
                                            <span class="help-block">
                                                <small><strong>{{ $errors->first('nama') }}</strong></small>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                    <label for="id" class="col-md-3 control-label">Email</label>
                                    <div class="col-md-8">
                                        <input type="email" name="email" id="email" class="form-control" value="{{ Auth::user()->email }}" required>
                                        @if ($errors->has('email'))
                                            <span class="help-block">
                                                <small><strong>{{ $errors->first('email') }}</strong></small>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <h4>Change password</h4>
                            <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                <div class="row">
                                    <label for="id" class="col-md-3 control-label">New Password</label>
                                    <div class="col-md-8">
                                        <input type="password" name="password" id="password" class="form-control" value="">
                                    </div>
                                </div>
                                <div class="row" style="margin-top: 12px;">
                                    <label for="id" class="col-md-3 control-label">Confirm Password</label>
                                    <div class="col-md-8">
                                        <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" value="">
                                        @if ($errors->has('password'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('password') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <p><i>Leave it empty if you don't wish to change your password.</i></p>
                        </div>
                        <div class="form-group">
                            <div class="col-md-4"></div>
                            <a class="btn btn-default" href="{{ route('myprofile') }}">
                                <i class="glyphicon glyphicon-chevron-left"></i> Back
                            </a>
                            <button type="submit" class="btn btn-primary">
                                Save
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

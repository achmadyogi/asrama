@extends('layouts.default')

@section('title','Login')

@section('main_menu')
    @parent

@endsection

@section('header_title','Login')
@section('content')

@section('content')
<div class="container">
    <br><br><br>
    @if (session()->has('verified'))
        <div class="alert_command">
            <P>{{session()->get()}}</P>
        </div><br><br>
    @endif
    <!-- ALERT -->
    @if (session()->has('status1'))
        <div class="alert_failed">
            {{session()->get('status1')}}
        </div><br> 
    @elseif (session()->has('status2'))
        <div class="alert_success">
            {{session()->get('status2')}}
        </div><br>
    @endif
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div style="margin-top: 0px; height: 4px; background-color: #0769B0; border-top-left-radius: 3px; border-top-right-radius: 3px;"></div>
            <div class="panel panel-default">
                <div class="row">
                    <div class="col-md-7">
                        <div class="panel-heading"><h3>Login</h3><hr></div>
                        <div class="panel-body">
                            <form class="form-horizontal" role="form" method="POST" action="{{ route('login') }}">
                                {{ csrf_field() }}

                                <div class="form-group{{ $errors->has('username') ? ' has-error' : '' }}">
                                    <label for="username" class="col-md-4 control-label">Username / Email</label>

                                    <div class="col-md-6">
                                        <input id="username" type="text" class="form-control" name="username" value="{{ old('username') }}" required autofocus>

                                        @if ($errors->has('username'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('username') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                    <label for="password" class="col-md-4 control-label">Password</label>

                                    <div class="col-md-6">
                                        <input id="password" type="password" class="form-control" name="password" required>

                                        @if ($errors->has('password'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('password') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-md-6 col-md-offset-4">
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> Remember Me
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-md-8 col-md-offset-4">
                                        <h5><button type="submit" class="btn btn-primary">
                                            Login
                                        </button> <b><span style="font-size: 25px;">|</span> <a href="/password/reset" style="color: #0769B0">Lupa Password?</a></b></h5>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="panel-heading"><h3>Central Authentication ITB</h3><hr></div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-xs-4">
                                    <img src="{{asset('img/LOGO_ITB.png')}}" width="100%">
                                </div>
                                <div class="col-xs-8">
                                    <small>Akses login akun INA (ITB Network Account) digunakan untuk mahasiswa, dosen, dan staff.</small>
                                    <h5><a href="{{route('SSOLogin')}}"><button type="button" class="btn btn-primary" style="background-color: #3e5f93">
                                    <span class="fa fa-sign-in"></span> INA Login
                                    </button></a>
                                </div>
                            </div>
                            <hr width="50%">
                            <div style="text-align: center;">
                                 <h5><b><a href="https://nic.itb.ac.id/manajemen-akun/reset-password" style="color: grey">Lupa Password?</a></b></h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div style="text-align: center">
            	<p>Belum punya akun? <b><a href="{{ route('register') }}" style="color: #0769B0">register</a></b></p>
            </div>
        </div>
    </div>
    <br><br><br><br>
</div>
@endsection

@extends('layouts.default')

@section('title','Register')

@section('main_menu')
    @parent

@endsection

@section('header_title','Register')
@section('content')
@section('content')
<div class="container">
    <br><br><br>
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
        <div class="col-md-8 col-md-offset-2">
            <div style="margin-top: 0px; height: 4px; background-color: #0769B0; border-top-left-radius: 3px; border-top-right-radius: 3px;"></div>
            <div class="panel panel-default">
                <div class="panel-heading"><h2>Register Akun INA</h2></div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{ route('SSOregister') }}">
                    	<input type="hidden" name="_token" value="{{ csrf_token() }}">

                        <div class="form-group">
                            <label for="name" class="col-md-4 control-label">Name</label>

                            <div class="col-md-6">
                                <input type="text" class="form-control" name="name" value="{{DormAuth::User()->name}}" disabled>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="name" class="col-md-4 control-label">ITB Mail</label>

                            <div class="col-md-6">
                                <input type="text" class="form-control" name="ITBmail" value="{{DormAuth::User()->ITBmail}}" disabled>
                            </div>
                        </div>

                        <p><b>Silahkan login dengan akun yang sudah dibuat</b></p>
                        <div class="form-group">
                            <label for="name" class="col-md-4 control-label">Alamat Email (Akun)</label>

                            <div class="col-md-6">
                                <input type="text" class="form-control" name="email" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="name" class="col-md-4 control-label">Password</label>

                            <div class="col-md-6">
                                <input type="password" class="form-control" name="password" required>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Register
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <br><br><br><br>
</div>
@endsection

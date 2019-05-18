@extends('layouts.default')

@section('title','Dashboard')
@section('menu_dash','active')

@section('main_menu')
	@parent

@endsection

@section('header_title','Dashboard | Ganti Username')
@section('content')
<div class="container">
	<br><br>
	<div class="row">
		<div class="col-md-9">
			<!-- KONTEN UTAMA-->
			<!-- ALERT -->
			@if (session()->has('status1'))
				<div class="alert_fail">
					{{session()->get('status1')}}
				</div> <br>
			@elseif (session()->has('status2'))
				<div class="alert_success">
					{{session()->get('status2')}}
				</div> <br>
			@endif
			<div class="sider">
				<div style="margin-top: 0px; height: 4px; background-color: #0769B0; border-top-left-radius: 3px; border-top-right-radius: 3px;"></div>
				<div class="sider_body" style="background-color: white; padding: 10px 15px 10px 15px;">
					<h2 style="margin-top: 0px;"><b>Ganti Username</b></h2>
					<form action="{{route('action_username')}}" method="post">
		                {{ csrf_field() }}
		                <div class="form-group{{ $errors->has('username') ? ' has-error' : '' }}">
						  	<input id="username" class="input" type="text" name="username" value="{{old('username')}}" placeholder="Masukkan username baru Anda">
						  	@if ($errors->has('username'))
		                        <span class="help-block">
		                            <strong>{{ $errors->first('username') }}</strong>
		                        </span>
		                    @endif
						</div>
						<button type="submit" class="button">Change</button>
		            </form>
				</div>
            </div><br><br>
		</div>
		<div class="col-md-3">
			<!-- MENU DASHBOARD -->
			@include('dashboard.menuDashboard')
		</div>
	</div>
	<br><br><br>
</div>
@endsection

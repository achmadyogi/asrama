@extends('layouts.default')

@section('title','Ganti Password')
@section('menu_dash','active')
@section('main_menu')
	@parent

@endsection

@section('header_title','Dashboard | Ganti Password')
@section('content')
<div class="container">
	<br><br>
	<div class="row">
		<div class="col-md-9">
			<!-- KONTEN UTAMA-->
			<div id="wait" style="display: none;"><img src="{{ asset('img/icon/load1.gif') }}" width="64" height="64" />Memproses...</div>
			<div id="content">
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
						<h2><b>Ubah Password</b></h2>
						<form action="{{ route('submit_password') }}" method="POST">
							{{csrf_field()}}
							<label>Masukkan password lama</label>
							<div class="form-group{{ $errors->has('password_lama') ? ' has-error' : '' }}">
								<input id='password_lama' class="input" name="password_lama" type="password" required placeholder="Masukkan password lama" focus><br>
								@if ($errors->has('password_lama'))
			                        <span class="help-block">
			                            <strong>{{ $errors->first('password_lama') }}</strong>
			                        </span>
			                    @endif
							</div>
							<label>Masukkan password baru</label>
							<div class="form-group{{ $errors->has('password_baru') ? ' has-error' : '' }}">
								<input id='password_baru' class="input" name="password_baru" type="password" required placeholder="Masukkan password baru" focus><br>
								@if ($errors->has('password_baru'))
			                        <span class="help-block">
			                            <strong>{{ $errors->first('password_baru') }}</strong>
			                        </span>
			                    @endif
							</div>
							<label>Ulangi password baru</label>
							<div class="form-group{{ $errors->has('re_password_baru') ? ' has-error' : '' }}">
								<input id='re_password_baru' class="input" name="re_password_baru" type="password" required placeholder="Ulangi password baru" focus><br>
								@if ($errors->has('re_password_baru'))
			                        <span class="help-block">
			                            <strong>{{ $errors->first('re_password_baru') }}</strong>
			                        </span>
			                    @endif
							</div>
							<button type="submit" class="button">Change Password</button><br><br>
						</form>
					</div>
				</div>
			</div><br><br><br>
		</div>
		<div class="col-md-3">
			<!-- MENU DASHBOARD -->
			@include('dashboard.menuDashboard')
		</div>
	</div>
	<br><br><br>
</div>
@endsection

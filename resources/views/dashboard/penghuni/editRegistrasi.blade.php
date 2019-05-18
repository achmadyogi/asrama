@extends('layouts.default')

@section('title','Periode Tinggal')
@section('menu_dash','active')

@section('main_menu')
	@parent

@endsection

@section('header_title','Penghuni | Edit Nomor Registrasi')
@section('content')
<div class="container">
	<br><br>
	<div class="row">
		<div class="col-md-9">
			<!-- KONTEN UTAMA-->
			<div id="content">
				<!-- ALERT -->
				@if (session()->has('status1'))
					<div class="alert_fail">
						{{session()->get('status1')}}
					</div> 
				@elseif (session()->has('status2'))
					<div class="alert_success">
						{{session()->get('status2')}}
					</div> 
				@endif
                <h1><b>Data Penghuni</b></h1>
                <p>
                    <span style="display: inline-block; width: 100px;">Nama</span>: {{DormAuth::User()->name}}<br>
                    <span style="display: inline-block; width: 100px;">NIM</span>: {{ITBdorm::DataUser(DormAuth::User()->id)->nim}}<br>
                    <span style="display: inline-block; width: 100px;">Registrasi</span>: {{ITBdorm::DataUser(DormAuth::User()->id)->registrasi}}<br>
                </p>
				<div class="sider">
                    <div style="margin-top: 0px; height: 4px; background-color: #0769B0; border-top-left-radius: 3px; border-top-right-radius: 3px;"></div>
                    <div class="sider_body" style="background-color: white; padding: 10px 15px 10px 15px;">
                        <h3><b>Form Edit Nomor Registrasi</b></h3>
						<form action="{{ route('ganti_registrasi') }}" method="post">
							{{ csrf_field() }}
							<div class="form-group{{ $errors->has('registrasi') ? ' has-error' : '' }}">
                                <input id="registrasi" type="text" name="registrasi" class="input" value="{{old('registrasi')}}" placeholder="Masukkan Nomor Registrasi Anda">
                                @if ($errors->has('registrasi'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('registrasi') }}</strong>
                                </span>
                                @endif
                            </div>
							<button class="button" type="submit">Submit</button>
						</form>
					</div>
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
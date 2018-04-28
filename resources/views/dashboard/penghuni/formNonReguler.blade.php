@extends('layouts.default')

@section('title','Pendaftaran')

@section('main_menu')
	@parent

@endsection

@section('header_title','Penghuni | Pendaftaran Non Reguler')
@section('content')
<div class="container">
	<br><br>
	<div class="row">
		<div class="col-md-3">
			<!-- MENU DASHBOARD -->
			@include('dashboard.menuDashboard')
		</div>
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
				<h1><b>Pendaftaran Non Reguler</b></h1>
				<p>Anda akan mendaftarkan diri sebagai penghuni untuk sementara waktu. Pastikan Anda sudah membaca segala ketentuan dan jumlah pembayaran yang telah ditetapkan.</p>
				<div style="border: 1px solid #C9C9C9; border-radius: 5px;">
					<div style="background-color: #E8E8E8; padding: 10px 15px 10px 15px">
						Form Pendaftaran Penghuni Non Reguler
					</div>
					<div style="padding: 10px 15px 10px 15px;"><br>
						<form action="{{ route('form_non_reguler') }}" method="post">
							{{ csrf_field() }}
	                        <label>Pilihan Kamar</label><br>
	                        <input type="radio" name="preference" value="1" required> Sendiri<br>
	                        <input type="radio" name="preference" value="2" required> Berdua<br>
	                        <input type="radio" name="preference" value="3" required> Bertiga<br><br>
	                        <label>Dimanakah lokasi asrama yang hendak ditinggali?</label><br>
	                        <input type="radio" name="lokasi_asrama" value="ganesha" required> Asrama ITB Ganesha<br>
	                        <input type="radio" name="lokasi_asrama" value="jatinangor" required> Asrama ITB Jatinangor<br><br>
	                        <label>Apakah Anda termasuk orang yang memiliki disabilitas?</label><br>
	                        <input type="radio" name="difable" value="0" required> Tidak<br>
	                        <input type="radio" name="difable" value="1" required> Iya<br><br>
	                        <label>Pilih paket periode tinggal</label><br>
	                        <input type="radio" name="tempo" value="harian" required> Bulanan<br>
	                        <input type="radio" name="tempo" value="bulanan" required> Harian<br><br>
	                        <div class="form-group{{ $errors->has('jumlah') ? ' has-error' : '' }}">
								<input class="input" id="jumlah" type="number" name="jumlah" placeholder="Jumlah hari/bulan lama tinggal" value="{{ old('jumlah') }}" required autofocus>
	                            @if ($errors->has('jumlah'))
	                                <span class="help-block">
	                                    <strong>{{ $errors->first('jumlah') }}</strong>
	                                </span>
	                            @endif
	                        </div>
	                        <div class="form-group{{ $errors->has('tanggal_masuk') ? ' has-error' : '' }}">
								<input class="input" id="tanggal_masuk" type="text" name="tanggal_masuk" placeholder="Tanggal Masuk Asrama" value="{{ old('tanggal_masuk') }}" required autofocus>
	                            @if ($errors->has('tanggal_masuk'))
	                                <span class="help-block">
	                                    <strong>{{ $errors->first('tanggal_masuk') }}</strong>
	                                </span>
	                            @endif
	                        </div>
							<div class="form-group{{ $errors->has('tujuan_tinggal') ? ' has-error' : '' }}">
								<input class="input" id="tujuan_tinggal" type="text" name="tujuan_tinggal" placeholder="Tujuan Tinggal" value="{{ old('tujuan_tinggal') }}" required autofocus>
	                            @if ($errors->has('tujuan_tinggal'))
	                                <span class="help-block">
	                                    <strong>{{ $errors->first('tujuan_tinggal') }}</strong>
	                                </span>
	                            @endif
	                        </div>
							<button class="button" type="submit">Submit</button>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>			
	<br><br><br>
</div>
@endsection

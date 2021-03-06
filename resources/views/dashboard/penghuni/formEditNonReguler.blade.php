@extends('layouts.default')

@section('title','Pendaftaran')

@section('main_menu')
	@parent

@endsection

@section('header_title','Penghuni | Edit Pendaftaran Non Reguler')
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
				<h1><b>Edit Pendaftaran Non Reguler</b></h1>
				<p>Anda akan mendaftarkan diri sebagai penghuni untuk sementara waktu. Pastikan Anda sudah membaca segala ketentuan dan jumlah pembayaran yang telah ditetapkan.</p>
				<div style="margin-top: 0px; height: 4px; background-color: #0769B0; border-top-left-radius: 3px; border-top-right-radius: 3px;"></div>
				<div class="sider_body" style="background-color: white; border-radius: 0px; color: black">
					<div style="padding: 0px 15px 10px 15px;"><br>
						<h4 style="margin-top: 0px;"><b>Form Edit Pendaftaran Non-Reguler</b></h4><hr>
						<form action="{{ route('submit_edit_non_reguler') }}" method="post">
							{{ csrf_field() }}
							<input type="hidden" value="{{ $id_daftar }}" name="id_daftar">
	                        <label>Pilihan Kamar</label><br>
	                        <input type="radio" name="preference" value="1" required> Sendiri<br>
	                        <input type="radio" name="preference" value="2" required> Berdua<br>
	                        <input type="radio" name="preference" value="3" required> Bertiga<br><br>
	                        <label>Dimanakah lokasi asrama yang hendak ditinggali?</label><br>
	                        <input type="radio" name="lokasi_asrama" value="ganesha" required> Asrama ITB Ganesha<br>
	                        <input type="radio" name="lokasi_asrama" value="jatinangor" required> Asrama ITB Jatinangor<br><br>
	                        <label>Apakah Anda memiliki kebutuhan khusus?</label><br>
	                        <input type="radio" id="difable" name="difable" value="0" required> Tidak<br>
	                        <input type="radio" id="difable" name="difable" value="1" required> Iya<br><br>
	                        <div id="khusus" style="display: none;">
	                        	<label>Rincian Kebutuhan khusus</label> <input name="ket_difable" class="input" type="text"><br><Br>
	                        </div>
	                        <script type="text/javascript">
	                        	$(document).ready(function(){
	                        		$('input[type=radio][name=difable]').change(function(){
	                        			var difa = $(this).val();
	                        			if(difa == 1){
	                        				$('#khusus').show(500);
	                        			}else{
	                        				$('#khusus').hide(500);
	                        			}
	                        		});
	                        	});
	                        </script>
	                        <label>Pilih paket periode tinggal</label><br>
	                        <input type="radio" name="tempo" value="harian" required> Harian<br>
	                        <input type="radio" name="tempo" value="bulanan" required> Bulanan<br><br>
	                        <div class="form-group{{ $errors->has('jumlah') ? ' has-error' : '' }}">
	                        	<label>Jumlah hari/bulan lama tinggal</label><br>
								<input class="input" id="jumlah" type="number" name="jumlah" placeholder="Masukkan angka" value="{{ old('jumlah') }}" required autofocus>
	                            @if ($errors->has('jumlah'))
	                                <span class="help-block">
	                                    <strong>{{ $errors->first('jumlah') }}</strong>
	                                </span>
	                            @endif
	                        </div>
	                        <div class="form-group{{ $errors->has('tanggal_masuk') ? ' has-error' : '' }}">
	                        	<label>Tanggal Mulai Tinggal</label><br>
								<input class="input" id="tanggal_masuk" type="date" name="tanggal_masuk" placeholder="Tanggal Masuk Asrama" value="{{ old('tanggal_masuk') }}" required autofocus>
	                            @if ($errors->has('tanggal_masuk'))
	                                <span class="help-block">
	                                    <strong>{{ $errors->first('tanggal_masuk') }}</strong>
	                                </span>
	                            @endif
	                        </div>
							<div class="form-group{{ $errors->has('tujuan_tinggal') ? ' has-error' : '' }}">
								<label>Tujuan Tinggal</label><br>
								<input class="input" id="tujuan_tinggal" type="text" name="tujuan_tinggal" placeholder="Alasan menginap sementara di asrama" value="{{ $tujuan_tinggal }}" disabled>
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
		<div class="col-md-3">
			<!-- MENU DASHBOARD -->
			@include('dashboard.menuDashboard')
		</div>
	</div>			
	<br><br><br>
</div>
@endsection

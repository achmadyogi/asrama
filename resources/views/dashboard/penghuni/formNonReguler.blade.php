@extends('layouts.default')

@if(session()->has('en')) 
	@section('title','registration')
@else 
	@section('title','Pendaftaran')
@endif

@section('menu_dash','active')

@section('main_menu')
	@parent

@endsection

@if(session()->has('en')) 
	@section('header_title','Occupant | The Non-Regular Registration')
@else 
	@section('header_title','Penghuni | Pendaftaran Non Reguler')
@endif
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
				<h1><b>@if(session()->has('en')) Non-Regular Registration @else Pendaftaran Non Reguler @endif</b></h1>
				<p>@if(session()->has('en')) You will be signing up for temporary. Make sure You have read all the instruction and billings for your plan! @else Anda akan mendaftarkan diri sebagai penghuni untuk sementara waktu. Pastikan Anda sudah membaca segala ketentuan dan jumlah pembayaran yang telah ditetapkan. @endif </p>
				<div style="margin-top: 0px; height: 4px; background-color: #0769B0; border-top-left-radius: 3px; border-top-right-radius: 3px;"></div>
				<div class="sider_body" style="background-color: white; border-radius: 0px; color: black">
					<div style="padding: 0px 15px 10px 15px;"><br>
						<h4 style="margin-top: 0px;"><b>@if(session()->has('en')) The Registration Form @else Form Pendaftaran Non Reguler @endif</b></h4><hr>
						<form action="{{ route('form_non_reguler') }}" method="post">
							{{ csrf_field() }}
	                        <label>@if(session()->has('en')) Choose room capacity @else Pilih Kapasitas Kamar @endif</label><br>
	                        <input type="radio" name="preference" value="1" required> @if(session()->has('en')) One Person @else Sendiri @endif<br>
	                        <input type="radio" name="preference" value="2" required> @if(session()->has('en')) Two Persons @else Berdua @endif<br>
	                        <input type="radio" name="preference" value="3" required> @if(session()->has('en')) Three Persons @else Bertiga @endif<br><br>
	                        <label>@if(session()->has('en')) Where is your proposed dormitory location? @else Dimanakah lokasi asrama yang hendak ditinggali? @endif </label><br>
	                        <input type="radio" name="lokasi_asrama" value="ganesha" required> @if(session()->has('en')) The Dormitory at ITB Ganesha @else Asrama ITB Ganesha @endif<br>
	                        <input type="radio" name="lokasi_asrama" value="jatinangor" required> @if(session()->has('en')) The Dormitory at ITB Jatinangor @else Asrama ITB Jatinangor @endif<br><br>
	                        <label>@if(session()->has('en')) Do you have any special treatments? (due to sickness or disability) @else Apakah Anda memiliki kebutuhan khusus? @endif </label><br>
	                        <input type="radio" id="difable" name="difable" value="0" required> @if(session()->has('en')) No @else Tidak @endif<br>
	                        <input type="radio" id="difable" name="difable" value="1" required> @if(session()->has('en')) Yes @else Iya @endif<br><br>
	                        <div id="khusus" style="display: none;">
	                        	<label>@if(session()->has('en')) Your Needs Details @else Rincian Kebutuhan Khusus @endif </label> <input name="ket_difable" class="input" type="text"><br><Br>
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
	                        <label>@if(session()->has('en')) Choose your living period @else Pilih paket periode tinggal @endif </label><br>
	                        <input type="radio" name="tempo" value="harian" required> @if(session()->has('en')) Daily @else harian @endif<br>
	                        <input type="radio" name="tempo" value="bulanan" required> @if(session()->has('en')) Monthly @else Bulanan @endif<br><br>
	                        <div class="form-group{{ $errors->has('jumlah') ? ' has-error' : '' }}">
	                        	<label>@if(session()->has('en')) The amount of days/months @else Jumlah hari/bulan lama tinggal @endif </label><br>
								<input class="input" id="jumlah" type="number" name="jumlah" placeholder="@if(session()->has('en')) Type numbers @else Masukkan angka @endif" value="{{ old('jumlah') }}" required autofocus>
	                            @if ($errors->has('jumlah'))
	                                <span class="help-block">
	                                    <strong>{{ $errors->first('jumlah') }}</strong>
	                                </span>
	                            @endif
	                        </div>
	                        <div class="form-group{{ $errors->has('tanggal_masuk') ? ' has-error' : '' }}">
	                        	<label>@if(session()->has('en')) Your Entry Date @else Tanggal Mulai Tinggal @endif </label><br>
								<input class="input" id="tanggal_masuk" type="date" name="tanggal_masuk" placeholder="Tanggal Masuk Asrama" value="{{ old('tanggal_masuk') }}" required autofocus>
	                            @if ($errors->has('tanggal_masuk'))
	                                <span class="help-block">
	                                    <strong>{{ $errors->first('tanggal_masuk') }}</strong>
	                                </span>
	                            @endif
	                        </div>
							<div class="form-group{{ $errors->has('tujuan_tinggal') ? ' has-error' : '' }}">
								<label>@if(session()->has('en')) Living Purposes @else Tujuan Tinggal @endif </label><br>
								<input class="input" id="tujuan_tinggal" type="text" name="tujuan_tinggal" placeholder="@if(session()->has('en')) Your reason for living at the dormitory @else Alasan menginap sementara di asrama @endif " value="{{ old('tujuan_tinggal') }}" required autofocus>
	                            @if ($errors->has('tujuan_tinggal'))
	                                <span class="help-block">
	                                    <strong>{{ $errors->first('tujuan_tinggal') }}</strong>
	                                </span>
	                            @endif
	                        </div>
							<button class="button" type="submit">@if(session()->has('en')) Submit @else Kumpulkan @endif</button>
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

@extends('layouts.default')

@section('title','Dashboard | Edit Data Diri')
@section('menu_dash','active')

@section('main_menu')
	@parent

@endsection

@section('header_title','Dashboard | Edit Data Diri')
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
					</div> <br>
				@elseif (session()->has('status2'))
					<div class="alert_success">
						{{session()->get('status2')}}
					</div> <br>
				@endif
                <h1 style="margin-top: 0px;"><b>Data Diri Penghuni</b></h1>
				<p>Silahkan mengganti data diri anda pada form dibawah ini</p>
				<form  method="POST" role="form" action="{{ route('edit_data_penghuni') }}">
					{{ csrf_field() }}
					<div class="sider">
						<div style="margin-top: 0px; height: 4px; background-color: #0769B0; border-top-left-radius: 3px; border-top-right-radius: 3px;"></div>
						<div class="sider_body" style="background-color: white; padding: 10px 15px 10px 15px;">
							<h3><b>Edit Data Diri</b></h3>
							<div class="form-group{{ $errors->has('nomor_identitas') ? ' has-error' : '' }}">
								<input id="nomor_identitas" class="input" name="nomor_identitas" type="text" value="{{ITBdorm::DataUser(DormAuth::User()->id)->nomor_identitas}}" placeholder="Nomor Identitas" required><br>
								@if ($errors->has('nomor_identitas'))
	                                <span class="help-block">
	                                    <strong>{{ $errors->first('nomor_identitas') }}</strong>
	                                </span>
	                            @endif
							</div>
							<div class="form-group{{ $errors->has('jenis_identitas') ? ' has-error' : '' }}">
								<input id="jenis_identitas" class="input" name="jenis_identitas" type="text" value="{{ITBdorm::DataUser(DormAuth::User()->id)->jenis_identitas}}" placeholder="Jenis Identitas (contoh: SIM, KTP, paspor)" required><br>
								@if ($errors->has('jenis_identitas'))
	                                <span class="help-block">
	                                    <strong>{{ $errors->first('jenis_identitas') }}</strong>
	                                </span>
	                            @endif
							</div>
							<div class="form-group{{ $errors->has('tempat lahir') ? ' has-error' : '' }}">
								<input id="tempat_lahir" class="input" name="tempat_lahir" type="text" value="{{ITBdorm::DataUser(DormAuth::User()->id)->tempat_lahir}}" placeholder="Kota Lahir" required><br>
								@if ($errors->has('tempat_lahir'))
	                                <span class="help-block">
	                                    <strong>{{ $errors->first('tempat_lahir') }}</strong>
	                                </span>
	                            @endif
							</div>
							<div class="form-group{{ $errors->has('tanggal_lahir') ? ' has-error' : '' }}">
								<label>Tanggal Lahir</label><br>
									<input class="input" id="tanggal_lahir" name="tanggal_lahir" placeholder="Tanggal Lahir (YYYY-MM-DD)" type="date" value="{{ITBdorm::DataUser(DormAuth::User()->id)->tanggal_lahir}}" required>
								@if ($errors->has('tanggal_lahir'))
		                            <span class="help-block">
		                                <strong>{{ $errors->first('tanggal_lahir') }}</strong>
		                            </span>
		                        @endif
							</div>
							Golongan Darah:<br>
							<input type="radio" name="gol_darah" value="O" required> O
							<span style="display: inline-block; width: 50px;"></span>
							<input type="radio" name="gol_darah" value="AB" required> AB
							<span style="display: inline-block; width: 50px;"></span>
							<input type="radio" name="gol_darah" value="A" required> A
							<span style="display: inline-block; width: 50px;"></span>
							<input type="radio" name="gol_darah" value="B" required> B
							<span style="display: inline-block; width: 50px;"></span><br><br>
							Jenis Kelamin:<br>
							<input type="radio" name="kelamin" value="L" required> Laki-laki
							<span style="display: inline-block; width: 50px;"></span>
							<input type="radio" name="kelamin" value="P" required> Perempuan<br><br>
							Asal Negara:<br>
							<select id="country" name ="negara" value="{{ITBdorm::DataUser(DormAuth::User()->id)->negara}}" required></select></br></br>
							Propinsi/State:<br>
							<select name ="propinsi" id ="state" value="{{ITBdorm::DataUser(DormAuth::User()->id)->propinsi}}" required></select></br></br>
							<script language="javascript">
								populateCountries("country", "state");
							</script>
							<div class="form-group{{ $errors->has('kota') ? ' has-error' : '' }}">
								<input id="kota" class="input" name="kota" type="text" value="{{ITBdorm::DataUser(DormAuth::User()->id)->kota}}" placeholder="Nama Kota" required><br>
								@if ($errors->has('kota'))
	                                <span class="help-block">
	                                    <strong>{{ $errors->first('kota') }}</strong>
	                                </span>
	                            @endif
							</div>
							<div class="form-group{{ $errors->has('alamat') ? ' has-error' : '' }}">
								<input id="alamat" class="input" name="alamat" type="text" value="{{ITBdorm::DataUser(DormAuth::User()->id)->alamat}}" placeholder="Alamat" required><br>
								@if ($errors->has('alamat'))
	                                <span class="help-block">
	                                    <strong>{{ $errors->first('alamat') }}</strong>
	                                </span>
	                            @endif
							</div>
							<div class="form-group{{ $errors->has('kodepos') ? ' has-error' : '' }}">
								<input id="kodepos" class="input" name="kodepos" type="text" value="{{ITBdorm::DataUser(DormAuth::User()->id)->kodepos}}" placeholder="Kode Pos" required><br>
								@if ($errors->has('kodepos'))
	                                <span class="help-block">
	                                    <strong>{{ $errors->first('kodepos') }}</strong>
	                                </span>
	                            @endif
							</div>
							<div class="form-group{{ $errors->has('agama') ? ' has-error' : '' }}">
								<input id="agama" class="input" name="agama" type="text" value="{{ITBdorm::DataUser(DormAuth::User()->id)->agama}}" placeholder="Agama" required><br>
								@if ($errors->has('agama'))
	                                <span class="help-block">
	                                    <strong>{{ $errors->first('agama') }}</strong>
	                                </span>
	                            @endif
							</div>
							<div class="form-group{{ $errors->has('pekerjaan') ? ' has-error' : '' }}">
								<input id="pekerjaan" class="input" name="pekerjaan" type="text" value="{{ITBdorm::DataUser(DormAuth::User()->id)->pekerjaan}}" placeholder="Pekerjaan" required><br>
								@if ($errors->has('pekerjaan'))
	                                <span class="help-block">
	                                    <strong>{{ $errors->first('pekerjaan') }}</strong>
	                                </span>
	                            @endif
							</div>
							Warga Negara:<br>
							<select id="country2" name ="warga_negara" value="{{old('warga_negara')}}" required></select><br><br>
							<div class="form-group{{ $errors->has('telepon') ? ' has-error' : '' }}">
								<input id="telepon" class="input" name="telepon" type="text" value="{{ITBdorm::DataUser(DormAuth::User()->id)->telepon}}" placeholder="Telepon" required><br>
								@if ($errors->has('telepon'))
	                                <span class="help-block">
	                                    <strong>{{ $errors->first('telepon') }}</strong>
	                                </span>
	                            @endif
							</div>
							<div class="form-group{{ $errors->has('kontak_darurat') ? ' has-error' : '' }}">
								<input id="kontak_darurat" class="input" name="kontak_darurat" type="text" value="{{ITBdorm::DataUser(DormAuth::User()->id)->kontak_darurat}}" placeholder="Telepon Darurat" required><br>
								@if ($errors->has('kontak_darurat'))
	                                <span class="help-block">
	                                    <strong>{{ $errors->first('kontak_darurat') }}</strong>
	                                </span>
	                            @endif
							</div>
							<div>
								<div class="form-group{{ $errors->has('instansi') ? ' has-error' : '' }}">
									<input class="input" name="instansi" type="text" value="{{ITBdorm::DataUser(DormAuth::User()->id)->instansi}}" placeholder="Nama Instansi"><br></div>
								</div>
							<script language="javascript">
								populateCountries("country2");
							</script>
						</div>
					</div><br>
					<div class="sider">
						<div style="margin-top: 0px; height: 4px; background-color: #0769B0; border-top-left-radius: 3px; border-top-right-radius: 3px;"></div>
						<div class="sider_body" style="background-color: white; padding: 10px 15px 10px 15px;">
							<h3><b>Data Orang Tua/Wali</b></h3>
							<input class="input" name="nama_ortu_wali" type="text" value="{{ITBdorm::DataUser(DormAuth::User()->id)->nama_ortu_wali}}" placeholder="Nama Orang Tua / Wali" required><br><br>
							<input class="input" name="pekerjaan_ortu_wali" type="text" value="{{ITBdorm::DataUser(DormAuth::User()->id)->pekerjaan_ortu_wali}}" placeholder="Pekerjaan Orang Tua / Wali" required><br><br>
							<input class="input" name="alamat_ortu_wali" type="text" value="{{ITBdorm::DataUser(DormAuth::User()->id)->alamat_ortu_wali}}" placeholder="Alamat Orang Tua / Wali" required><br><br>
							<input class="input" name="telepon_ortu_wali" type="text" value="{{ITBdorm::DataUser(DormAuth::User()->id)->telepon_ortu_wali}}" placeholder="Telepon Orang Tua / Wali" required><br><br>
							<button type="submit" name="submit" class="button">Submit</button><br><br>
						</div>
					</div><br>
                </form>
            </div><br><br>
        </div>
		<div class="col-md-3">
			<!-- MENU DASHBOARD -->
			@include('dashboard.menuDashboard')
		</div>
    </div>
</div>
</div>
<br><br><br>
</div>
@endsection
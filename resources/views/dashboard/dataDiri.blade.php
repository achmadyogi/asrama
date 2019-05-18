@extends('layouts.default')

@section('title','Dashboard | Data Diri')
@section('menu_dash','active')

@section('main_menu')
	@parent

@endsection

@section('header_title','Dashboard | Data Diri')
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
				</div> 
			@elseif (session()->has('status2'))
				<div class="alert_success">
					{{session()->get('status2')}}
				</div> 
			@endif <br>
			<br>
			<!-- TRIGER UNTUK MASUK APLIKASI -->
			<div class="row">
				<div class="col-md-12">
					<style type="text/css">
						.background{
							
    						position:absolute; 
    						left: -100%; 
    						right: -100%; 
    						top: -100%; 
    						bottom: -100%;
    						margin: auto; 
    						min-height: 100%; 
    						min-width: 100%;
						}
						@media only screen and (min-width: 800px){
							.back_div{
								top: 10%;
							}
							.babak{
								display: block;
							}
						}
						@media only screen and (max-width: 800px){
							.back_div{
								top: 5%;
							}
							.babak{
								display: none;
							}
						}  
					</style>
					<div style='background-color: white; width: 100%; height: 150px; overflow: hidden;margin-top: 0px; position: relative; background-color: #D2D6DE'>
    					<div style="-webkit-filter: blur(6px); /* Safari 6.0 - 9.0 */
    						filter: blur(6px); " class="babak">
							@if(DormAuth::User()->foto_profil == NULL && ITBdorm::DataUser(DormAuth::User()->id)->jenis_kelamin == 'L')
							<img src="{{asset('img/profil/default_men.png')}}" class="background" width='50px;'height='50px;' alt='user'>
							@elseif(DormAuth::User()->foto_profil == NULL && ITBdorm::DataUser(DormAuth::User()->id)->jenis_kelamin == 'P')
							<img src="{{asset('img/profil/default_women.png')}}" class="background" width ='50px;' alt='user'>
							@else
							<img src="/storage/avatars/{{ DormAuth::User()->foto_profil }}" class="background" width='100%' alt='user'>
							@endif 
						</div>
					</div>
					<div style="text-align: center; position: absolute; left: 50%; margin: -90px 0px 0px -90px;" class="back_div">
						<div style='background-color: white; width: 180px; height: 180px; overflow: hidden;margin-top: 0px; position: relative; border-radius: 50%; border: 2px solid white'>
							@if(DormAuth::User()->foto_profil == NULL && ITBdorm::DataUser(DormAuth::User()->id)->jenis_kelamin == 'L')
							<img src="{{asset('img/profil/default_men.png')}}" style='position:absolute; left: -100%; right: -100%; top: -100%; bottom: -100%; margin: auto; min-height: 100%; min-width: 100%;' width='50px;'height='50px;' alt='user'>
							@elseif(DormAuth::User()->foto_profil == NULL && ITBdorm::DataUser(DormAuth::User()->id)->jenis_kelamin == 'P')
							<img src="{{asset('img/profil/default_women.png')}}" style='position:absolute; left: -100%; right: -100%; top: -100%; bottom: -100%; margin: auto; min-height: 100%; min-width: 100%;' width='50px;'height='50px;' alt='user'>
							@else
							<img src="/storage/avatars/{{ DormAuth::User()->foto_profil }}" style='position:absolute; left: -100%; right: -100%; top: -100%; bottom: -100%; margin: auto; width: 170%; min-height: 100%; min-width: 100%;' width='180px;' alt='user'>
							@endif 
						</div><br>
					</div>
					<div style="margin-top: 0px; height: 4px; background-color: #0769B0; border-top-left-radius: 3px; border-top-right-radius: 3px;"></div>
					<div class="sider_body" style="background-color: white; border-radius: 0px; color: black; padding-left: 20px; padding-right: 20px;"><br>
						<div class="row">
							<div class="col-md-8">
								<h2 style="margin-top: 0px;"><b>Data Diri</b></h2><hr>
								<span style="display: inline-block; width: 150px;">Nama</span>: {{DormAuth::User()->name}}<br>
								<span style="display: inline-block; width: 150px;">Nomor Identitas</span>: {{ITBdorm::DataUser(DormAuth::User()->id)->nomor_identitas}} ({{ITBdorm::DataUser(DormAuth::User()->id)->jenis_identitas}})<br>
								<span style="display: inline-block; width: 150px;">Tempat Lahir</span>: {{ITBdorm::DataUser(DormAuth::User()->id)->tempat_lahir}}<br>
								<span style="display: inline-block; width: 150px;">Tanggal Lahir</span>: {{ITBdorm::Date(ITBdorm::DataUser(DormAuth::User()->id)->tanggal_lahir)}}<br>
								<span style="display: inline-block; width: 150px;">Jenis Kelamin</span>: @if(ITBdorm::DataUser(DormAuth::User()->id)->jenis_kelamin == 'L') Laki-laki @else Perempuan @endif <br>
								<span style="display: inline-block; width: 150px;">Golongan Darah</span>: {{ITBdorm::DataUser(DormAuth::User()->id)->gol_darah}}<br>
								<span style="display: inline-block; width: 150px;">Jabatan di Asrama</span>:
								@if(DormAuth::User()->is_penghuni == '1')
									Penghuni 
								@endif
								@if(DormAuth::User()->is_sekretariat == '1')
									 | 
								@endif
								@if(DormAuth::User()->is_sekretariat == '1')
									Sekretariat
								@endif
								@if(DormAuth::User()->is_pengelola == '1')
									 | 
								@endif
								@if(DormAuth::User()->is_pengelola == '1')
									Pengelola 
								@endif
								@if(DormAuth::User()->is_admin == '1')
									 | 
								@endif
								@if(DormAuth::User()->is_admin == '1')
									Admin 
								@endif
								@if(DormAuth::User()->is_pimpinan == '1')
									 | 
								@endif
								@if(DormAuth::User()->is_pimpinan == '1')
									Pimpinan
								@endif
							</div>
							<div class="col-md-4"><br><br><br>
								<b>Unggah foto profil</b><br><br>
								<form action="{{ route('foto_profil') }}" method="POST" enctype="multipart/form-data">
									{{ csrf_field() }}
									<div class="form-group{{ $errors->has('avatar') ? ' has-error' : '' }}">
											<input type="file" class="form-control-file" name="avatar" id="avatar_pic" aria-describedby="fileHelp" required>
										@if ($errors->has('avatar'))
											<span class="help-block">
												<strong>{{ $errors->first('avatar') }}</strong>
											</span>
										@endif
									</div>
			            			<small id="fileHelp" class="form-text text-muted">Upload file gambar (jpg, png, jpeg, giv, svg). Ukuran gambar tidak lebih dari 2MB.</small><br><br>
									<button class="button" type="submit">Upload</button><br><br>
								</form>
							</div>
						</div>
						
					</div>
				</div>
			</div><br>
			<div style="margin-top: 0px; height: 4px; background-color: #0769B0; border-top-left-radius: 3px; border-top-right-radius: 3px;"></div>
			<div class="sider_body" style="background-color: white; border-radius: 0px; color: black; padding-left: 20px; padding-right: 20px;">
				<h4><b>Detail User</b></h4><hr>
				<span style="display: inline-block; width: 210px;">Alamat</span>: {{ITBdorm::DataUser(DormAuth::User()->id)->alamat}}<br>
				<span style="display: inline-block; width: 210px;">Kota</span>: {{ITBdorm::DataUser(DormAuth::User()->id)->kota}}<br>
				<span style="display: inline-block; width: 210px;">Propinsi</span>: {{ITBdorm::DataUser(DormAuth::User()->id)->propinsi}}<br>
				<span style="display: inline-block; width: 210px;">Kode Pos</span>: {{ITBdorm::DataUser(DormAuth::User()->id)->kodepos}}<br>
				<span style="display: inline-block; width: 210px;">Negara</span>: {{ITBdorm::DataUser(DormAuth::User()->id)->negara}}<br>
				<span style="display: inline-block; width: 210px;">Agama</span>: {{ITBdorm::DataUser(DormAuth::User()->id)->agama}}<br>
				<span style="display: inline-block; width: 210px;">Pekerjaan</span>: {{ITBdorm::DataUser(DormAuth::User()->id)->pekerjaan}}<br>
				<span style="display: inline-block; width: 210px;">Warga Negara</span>: {{ITBdorm::DataUser(DormAuth::User()->id)->warga_negara}}<br>
				<span style="display: inline-block; width: 210px;">Telepon</span>: {{ITBdorm::DataUser(DormAuth::User()->id)->telepon}}<br>
				<span style="display: inline-block; width: 210px;">Instansi</span>: {{ITBdorm::DataUser(DormAuth::User()->id)->instansi}}<br><br>
			</div><br>
			<div style="margin-top: 0px; height: 4px; background-color: #0769B0; border-top-left-radius: 3px; border-top-right-radius: 3px;"></div>
			<div class="sider_body" style="background-color: white; border-radius: 0px; color: black; padding-left: 20px; padding-right: 20px;">
				<h4><b>Detail Orang Tua/Wali</b></h4><hr>
				<span style="display: inline-block; width: 210px;">Nama Orang Tua/Wali</span>: {{ITBdorm::DataUser(DormAuth::User()->id)->nama_ortu_wali}}<br>
				<span style="display: inline-block; width: 210px;">Alamat Orang Tua/Wali</span>: {{ITBdorm::DataUser(DormAuth::User()->id)->alamat_ortu_wali}}<br>
				<span style="display: inline-block; width: 210px;">Telepon Orang Tua/Wali</span>: {{ITBdorm::DataUser(DormAuth::User()->id)->telepon_ortu_wali}}<br>
				<span style="display: inline-block; width: 210px;">Kontak Darurat</span>: {{ITBdorm::DataUser(DormAuth::User()->id)->kontak_darurat}}<br><br>
				<button type="button" class="button"><a href="{{route('edit_data_diri')}}" style="text-decoration: none; color: white;">Edit Data Diri</a></button>
				<br><br>
			</div><br>
		</div>
		<div class="col-md-3">
			<!-- MENU DASHBOARD -->
			@include('dashboard.menuDashboard')
		</div>
	</div>
	<br><br><br>
</div>
@endsection

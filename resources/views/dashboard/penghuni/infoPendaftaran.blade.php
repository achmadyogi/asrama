@extends('layouts.default')

@section('title','Pendaftaran')

@section('main_menu')
	@parent

@endsection

@section('header_title','Penghuni | Pendaftaran')
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

				@if($nonReguler == '0' && $reguler == '0')
					<h1><b>Informasi Pendaftaran</b></h1>
					<p>Terimakasih telah bergabung dengan UPT Asrama ITB. Silahkan daftarkan diri Anda untuk permohonan tinggal di asarama.
						Syarat dan ketentuan adalah sebagai berikut:<br>
						<h4><b>PENGHUNI REGULER</b></h4>Penghuni reguler adalah penghuni dengan status mahasiswa ITB. Seorang penghuni reguler hanya dapat mendaftar pada periode tertentu yang waktunya telah ditetapkan oleh pihak asrama.<br>
						<h4><b>PENGHUNI NON REGULER</b></h4>Penghuni Non Reguler terbuka bagi siapa saja yang ingin mendaftar ke asrama. Penghuni Non Reguler dapat menetapkan tanggal masuk dan tanggal keluar dari asrama sesuai keperluan tinggal.
					</p><br>
					<h2><b>Periode Pendaftaran Tersedia</b></h2>
					<div class="row">
						<div class="col-md-6" style="text-align: center;">
							<h3><b>Pendaftaran Non Reguler</b></h3>
							<div style="text-align: center;"><a href="{{ route('daftar_non_reguler') }}"><button class="button">Daftar Sekarang</button></a></div>
						</div>
						<div class="col-md-6" style="text-align: center;">
							<h3><b>Pendaftaran Reguler</b></h3>
						</div>
					</div>
				@else
					<h2><b>Status Pendaftaran</b></h2> 
					@if($reguler == '0')
						<div class="table">
							<table>
								<tr>
									<th>No.</th>
									<th>Tanggal Daftar</th>
									<th>Tujuan Tinggal</th>
									<th>Preference</th>
									<th>Lokasi Asrama</th>
									<th>Tanggal Masuk</th>
									<th>Lama Tinggal</th>
								</tr>
							</table>
						</div>
						<span style="display: inline-block; width: 150px;">Kategori Penghuni</span>: Penghuni Non Reguler<br>
						<span style="display: inline-block; width: 150px;">Tujuan Tinggal</span>:<br>
					@else
						<span style="display: inline-block; width: 150px;">Kategori Penghuni</span>: Penghuni Reguler
					@endif
				@endif
			</div>
		</div>
	</div>			
	<br><br><br>
</div>
@endsection

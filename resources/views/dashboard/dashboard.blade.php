@extends('layouts.default')

@section('title','Dashboard')

@section('main_menu')
	@parent

@endsection

@section('header_title','Dashboard')
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
			<div id="wait" style="display: none;"><img src="{{ asset('img/icon/load1.gif') }}" width="64" height="64" />Memproses...</div>
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
				@if($userPenghuni == '0')
					<!-- TRIGER UNTUK PENDAFTARAN DATA DIRI-->
					@include('dashboard.penghuni.pendaftaran')
				@elseif($user->is_penghuni=='0'&&$user->is_sekretariat=='0'&&$user->is_pengelola=='0'&&$user->is_admin=='0'&&$user->is_pimpinan=='0')
					<!-- TRIGER UNTUK PENDAFTARAN PENGHUNI ASRAMA -->
					<h1><b>Informasi Pendaftaran</b></h1>
					<p>Terimakasih telah bergabung dengan UPT Asrama ITB. Silahkan daftarkan diri Anda untuk permohonan tinggal di asarama.
						Syarat dan ketentuan adalah sebagai berikut:<br>
						<h4><b>PENGHUNI REGULER</b></h4>Penghuni reguler adalah penghuni dengan status mahasiswa ITB. Seorang penghuni reguler hanya dapat mendaftar pada periode tertentu yang waktunya telah ditetapkan oleh pihak asrama.<br>
						<h4><b>PENGHUNI NON REGULER</b></h4>Penghuni Non Reguler terbuka bagi siapa saja yang ingin mendaftar ke asrama. Penghuni Non Reguler dapat menetapkan tanggal masuk dan tanggal keluar dari asrama sesuai keperluan tinggal.
					</p>
					<div style="text-align: center;">
						<a href="{{url('/daftar_reguler')}}"><button class="button">Daftar Reguler</button></a>
						<a href="{{url('/daftar_non_reguler')}}"><button class="button">Daftar Non-Reguler</button></a>
					</div>
				@else
					<!-- TRIGER UNTUK MASUK APLIKASI -->
					<h1><b>Selamat Datang...</b></h1>
					<p>Anda telah terdaftar di UPT Asrama ITB sebagai:<br>
						<b><ul>
							@if($user->is_penghuni == '1')
								<li>Penghuni</li>
							@endif
							@if($user->is_sekretariat == '1')
								<li>Sekretariat</li>
							@endif
							@if($user->is_pengelola == '1')
								<li>Pengelola</li>
							@endif
							@if($user->is_admin == '1')
								<li>Admin</li>
							@endif
							@if($user->is_pimpinan == '1')
								<li>Pimpinan</li>
							@endif
						</ul></b>
						Silahkan masuk ke aplikasi yang tersedia untuk memeriksa informasi yang diperlukan.
					</p>
				@endif

			</div>
		</div>
	</div>
	<br><br><br>
</div>
@endsection

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
							@if($pass_periode == 0)
								<p>Belum ada pendaftaran reguler untuk saat ini</p>
							@else
								<div style="text-align: center;"><a href="{{route('daftar_reguler')}}"><button class="button">Daftar Sekarang</button></a></div>
							@endif
						</div>
					</div>
				@else
					<h2><b>Status Pendaftaran</b></h2>
						<h3><b>Riwayat Pendaftaran Penghuni Non Reguler</b></h3> 
						@if($nonReguler != '0')
						<div class="table">
							<table>
								<tr>
									<th>No.</th>
									<th>Tanggal Daftar</th>
									<th>Status</th>
									<th>Rincian</th>
								</tr>
								<?php $a = 1; ?>
								@foreach($nonReguler as $non)
								<tr>
									<td>{{$a}}.</td>
									<td>{{$tanggal_daftar_non[$a-1]}}</td>
									<td>
									@if($non->verification == 0)
							  	  		Menunggu Verifikasi
							  	  	@elseif($non->verification == 1)
							  	  		@if($out[$a-1] == 'Aktif')
							  	  			<span style="color:green;"><b>Aktif</b></span>
							  	  		@else
							  	  			<b>Checkout</b></span>
							  	  		@endif
							  	  	@endif </td>
									<td><button type="button" class="button" id="btn{{$non->id_user}}">Rincian</button>
								</tr>
								<!-- MODAL UNTUK EDIT PERIODE -->
								<style type="text/css">
									/* The Close Button */
								.close{{$non->id_user}} {
									color: white;
									float: right;
									font-size: 28px;
									font-weight: bold;
								}

								.close{{$non->id_user}}:hover,
								.close{{$non->id_user}}:focus {
									color: #000;
									text-decoration: none;
									cursor: pointer;
								}
								</style>
								<div id="myModal{{$non->id_user}}" class="modal">

								  <!-- Modal content -->
								  <div class="modal-content">
									<div class="modal-header">
									  <span class="close{{$non->id_user}}">&times;</span>
									  <h3><b>Rincian Pendaftaran</b></h3>
									</div><br>
									<div class="modal-body">
										<div class="row">
											<div class="col-md-6">
												<p><span style="display: inline-block; width: 150px;">Nama</span><b>: {{Auth::User()->name}}</b><br>
										  	  	<span style="display: inline-block; width: 150px;">Tanggal Daftar</span>: {{$tanggal_daftar_non[$a-1]}}<br>
										  	  	<span style="display: inline-block; width: 150px;">Keperluan Tinggal</span>: {{$non->tujuan_tinggal}}<br>
										  	  	<span style="display: inline-block; width: 150px;">Lokasi Asrama</span>: {{$non->lokasi_asrama}}<br>
										  	  	@if($non->preference == 1)
										  	  		<span style="display: inline-block; width: 150px;">Preference</span>: Sendirian<br>
										  	  	@elseif($non->preference == 2)
										  	  		<span style="display: inline-block; width: 150px;">Preference</span>: Berdua<br>
										  	  	@else
										  	  		<span style="display: inline-block; width: 150px;">Preference</span>: Bertiga<br>
										  	  	@endif
										  	  	<span style="display: inline-block; width: 150px;">Tempo</span>: {{$non->tempo}}<br>
										  	  	<span style="display: inline-block; width: 150px;">Jumlah hari/bulan</span>:
										  	  	@if($non->tempo == 'harian')
										  	  		{{$non->lama_tinggal}} hari
										  	  	@else
										  	  		{{$non->lama_tinggal}} bulan
										  	  	@endif <br></p>
											</div>
											<div class="col-md-6">
												<span style="display: inline-block; width: 150px;">Tanggal Masuk</span>: {{$tanggal_masuk_non[$a-1]}}<br>
										  	  	<span style="display: inline-block; width: 150px;">Kebutuhan Khusus</span>: 
										  	  	@if($non->is_difable == 1)
										  	  	 	Ya
										  	  	@else
										  	  		Tidak
										  	  	@endif <br>
										  	  	<span style="display: inline-block; width: 150px;">Rincian Kebutuhan</span>: {{$non->ket_difable}} <br>
										  	  	@if($non->verification == 0)
										  	  		<span style="display: inline-block; width: 150px;">Status</span>: Menunggu Verifikasi<br>
										  	  	@elseif($non->verification == 1)
										  	  		@if($out[$a-1] == 'Aktif')
										  	  			<span style="display: inline-block; width: 150px;">Status</span>: <span style="color:green;"><b>Aktif</b></span><br>
										  	  		@else
										  	  			<span style="display: inline-block; width: 150px;">Status</span>: <b>Checkout</b></span><br>
										  	  		@endif
										  	  		<span style="display: inline-block; width: 150px;">Asrama</span>: {{$nama_asrama[$a-1]}}<br>
										  	  		<span style="display: inline-block; width: 150px;">Kamar</span>: {{$nama_kamar[$a-1]}}<br>
										  	  		<span style="display: inline-block; width: 150px;">Total Tagihan</span>: {{$total[$a-1]}}<b></b><br>
										  	  		@if($bill != 0)
										  	  			<span style="display: inline-block; width: 150px;">Total Pembayaran</span>: {{$bill[$a-1]}}<b></b><br>
										  	  		@else
										  	  			<span style="display: inline-block; width: 150px;">Total Pembayaran</span>: Rp0,00<b></b><br>
										  	  		@endif
										  	  		@if($lunas == 'Belum lunas')
										  	  			<span style="display: inline-block; width: 150px;">Keterangan</span>: <span style="color:red;"><b>Belum lunas</b></span><br>
										  	  		@else
										  	  			<span style="display: inline-block; width: 150px;">Keterangan</span>: <span style="color:green;"><b>Lunas</b></span><br>
										  	  		@endif
										  	  	@else
										  	  		<span style="display: inline-block; width: 150px;">Status</span>: <span style="color:red"><b>Pendaftaran ditolak</b></span><br>
										  	  	@endif
											</div>
										</div><hr>
										<i>Pendaftaran Anda akan kami konfirmasikan dalam waktu 24 jam setelah pendaftaran pada jam kerja. Untuk mempercepat proses verifikasi, Anda dapat langsung menghubungi petugas kami atau datang langsung ke kantor kami bila kebutuhan bersifat segera.</i>
									</div>
								  </div>

								</div>
								<script>
								// Get the modal
								var modal{{$non->id_user}} = document.getElementById('myModal{{$non->id_user}}');

								// Get the button that opens the modal
								var btn{{$non->id_user}} = document.getElementById("btn{{$non->id_user}}");

								// Get the <span> element that closes the modal
								var span{{$non->id_user}} = document.getElementsByClassName("close{{$non->id_user}}")[0];

								// When the user clicks the button, open the modal 
								btn{{$non->id_user}}.onclick = function() {
									modal{{$non->id_user}}.style.display = "block";
								}

								// When the user clicks on <span> (x), close the modal
								span{{$non->id_user}}.onclick = function() {
									modal{{$non->id_user}}.style.display = "none";
								}

								// When the user clicks anywhere outside of the modal, close it
								window.onclick = function(event) {
									if (event.target == modal{{$non->id_user}}) {
										modal{{$non->id_user}}.style.display = "none";
									}
								}
								</script>
								<?php $a += 1; ?>
								@endforeach
							</table>
						</div>
					@else
						Belum ada riwayat pendaftaran non reguler hingga saat ini.
					@endif<br>
					<h3><b>Riwayat Pendaftaran Penghuni Reguler</b></h3> 
						@if($reguler != '0')
						<div class="table">
							<table>
								<tr>
									<th>No.</th>
									<th>Nama</th>
									<th>Tanggal Daftar</th>
									<th>Rincian</th>
								</tr>
								<?php $i = 1; ?>
								@foreach($reguler as $reg)
								<tr>
									<td>{{$i}}.</td>
									<td>{{Auth::User()->name}}</td>
									<td>{{$tanggal_daftar[$i-1]}}</td>
									<td><button type="button" class="button" id="btn_reg{{$reg->id_user}}">Rincian</button>
								</tr>
								<!-- MODAL UNTUK EDIT PERIODE -->
								<style type="text/css">
									/* The Close Button */
								.close_reg{{$reg->id_user}} {
									color: white;
									float: right;
									font-size: 28px;
									font-weight: bold;
								}

								.close_reg{{$reg->id_user}}:hover,
								.close_reg{{$reg->id_user}}:focus {
									color: #000;
									text-decoration: none;
									cursor: pointer;
								}
								</style>
								<div id="myModal_reg{{$reg->id_user}}" class="modal">

								  <!-- Modal content -->
								  <div class="modal-content">
									<div class="modal-header">
									  <span class="close_reg{{$reg->id_user}}">&times;</span>
									  <h3><b>Rincian Pendaftaran</b></h3>
									</div><br>
									<div class="modal-body">
										<div class="row">
											<div class="col-md-6">
												<p><span style="display: inline-block; width: 150px;">Nama</span><b>: {{Auth::User()->name}}</b><br>
										  	  	<span style="display: inline-block; width: 150px;">Tanggal Daftar</span>: {{$tanggal_daftar[$i-1]}}<br>
										  	  	<span style="display: inline-block; width: 150px;">Lokasi Asrama</span>: {{$reg->lokasi_asrama}}<br>
										  	  	@if($reg->preference == 1)
										  	  		<span style="display: inline-block; width: 150px;">Preference</span>: Sendirian<br>
										  	  	@elseif($reg->preference == 2)
										  	  		<span style="display: inline-block; width: 150px;">Preference</span>: Berdua<br>
										  	  	@else
										  	  		<span style="display: inline-block; width: 150px;">Preference</span>: Bertiga<br>
										  	  	@endif
										  	   <br></p>
											</div>
											<div class="col-md-6">
												<span style="display: inline-block; width: 150px;">Tanggal Masuk</span>: {{$tanggal_masuk[$i-1]}}<br>
										  	  	<span style="display: inline-block; width: 150px;">Disabilitas</span>: 
										  	  	@if($reg->is_difable == 1)
										  	  	 	Ya
										  	  	@else
										  	  		Tidak
										  	  	@endif <br>
										  	  	@if($reg->verification == 0)
										  	  		<span style="display: inline-block; width: 150px;">Status</span>: Menunggu Verifikasi<br>
										  	  	@elseif($reg->verification == 1)
										  	  		@if($out_reguler[$i-1] == 'Aktif')
										  	  			<span style="display: inline-block; width: 150px;">Status</span>: <span style="color:green;"><b>Aktif</b></span><br>
										  	  		@else
										  	  			<span style="display: inline-block; width: 150px;">Status</span>: <b>Checkout</b></span><br>
										  	  		@endif
										  	  		<span style="display: inline-block; width: 150px;">Asrama</span>: {{$nama_asrama_reguler[$i-1]}}<br>
										  	  		<span style="display: inline-block; width: 150px;">Kamar</span>: {{$nama_kamar_reguler[$i-1]}}<br>
										  	  		<span style="display: inline-block; width: 150px;">Total Tagihan</span>: {{$total_reguler[$i-1]}}<b></b><br>
										  	  		@if($bill_reguler != 0)
										  	  			<span style="display: inline-block; width: 150px;">Total Pembayaran</span>: {{$bill_reguler[$i-1]}}<b></b><br>
										  	  		@else
										  	  			<span style="display: inline-block; width: 150px;">Total Pembayaran</span>: Rp0,00<b></b><br>
										  	  		@endif
										  	  		@if($lunas_reguler == 'Belum lunas')
										  	  			<span style="display: inline-block; width: 150px;">Keterangan</span>: <span style="color:red;"><b>Belum lunas</b></span><br>
										  	  		@else
										  	  			<span style="display: inline-block; width: 150px;">Keterangan</span>: <span style="color:green;"><b>Lunas</b></span><br>
										  	  		@endif
										  	  	@else
										  	  		<span style="display: inline-block; width: 150px;">Status</span>: <span style="color:red"><b>Pendaftaran ditolak</b></span><br>
										  	  	@endif
											</div>
										</div><hr>
										<i>Pendaftaran Anda akan kami konfirmasikan dalam waktu 24 jam setelah pendaftaran pada jam kerja. Untuk mempercepat proses verifikasi, Anda dapat langsung menghubungi petugas kami atau datang langsung ke kantor kami bila kebutuhan bersifat segera.</i>
									</div>
								  </div>

								</div>
								<script>
								// Get the modal
								var modal_reg{{$reg->id_user}} = document.getElementById('myModal_reg{{$reg->id_user}}');

								// Get the button that opens the modal
								var btn_reg{{$reg->id_user}} = document.getElementById("btn_reg{{$reg->id_user}}");

								// Get the <span> element that closes the modal
								var span_reg{{$reg->id_user}} = document.getElementsByClassName("close_reg{{$reg->id_user}}")[0];

								// When the user clicks the button, open the modal 
								btn_reg{{$reg->id_user}}.onclick = function() {
									modal_reg{{$reg->id_user}}.style.display = "block";
								}

								// When the user clicks on <span> (x), close the modal
								span_reg{{$reg->id_user}}.onclick = function() {
									modal_reg{{$reg->id_user}}.style.display = "none";
								}

								// When the user clicks anywhere outside of the modal, close it
								window.onclick = function(event) {
									if (event.target == modal_reg{{$reg->id_user}}) {
										modal_reg{{$reg->id_user}}.style.display = "none";
									}
								}
								</script>
								<?php $i += 1; ?>
								@endforeach
							</table>
						</div>
					</div>
					@else
						Belum ada riwayat pendaftaran reguler hingga saat ini.
					@endif
					<br><br><br>
					<h2><b>Periode Pendaftaran Tersedia</b></h2>
					<div class="row">
						<div class="col-md-6" style="text-align: center;">
							<h3><b>Pendaftaran Non Reguler</b></h3>
							<div style="text-align: center;"><a href="{{ route('daftar_non_reguler') }}"><button class="button">Daftar Sekarang</button></a></div>
						</div>
						<div class="col-md-6" style="text-align: center;">
							<h3><b>Pendaftaran Reguler</b></h3>
								<div style="text-align: center;"><a href="{{route('daftar_reguler')}}"><button class="button">Daftar Sekarang</button></a></div>
						</div>
					</div>
				@endif
			</div>
		</div>
	</div>			
	<br><br><br>
</div>
@endsection

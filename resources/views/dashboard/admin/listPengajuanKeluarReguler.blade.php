@extends('layouts.default')

@section('title','Validasi Pengajuan Keluar')
@section('menu_dash','active')

@section('main_menu')
	@parent

@endsection

@section('header_title','Admin | Validasi Pengajuan Keluar')
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
				@endif
				@if (session()->has('status2'))
					<div class="alert_success">
						{{session()->get('status2')}}
					</div> 
				@endif
				<h2><b>Validasi Pengajuan Keluar</b></h2>
				@if(isset($checkout))
					<div class="table">
						<table>
							<tr>
								<th>No.</th>
								<th>Nama Penghuni</th>
								<th>Tanggal Pengajuan</th>
								<th>Asrama</th>
								<th>Pendaftaran</th>
								<th>Detail</th>
							</tr>
							<?php $urut = 0; ?>
							@foreach($checkout as $checkout)
							<tr>
								<td>{{$urut+1}}.</td>
								<td>{{$checkout->name}}</td>
								<td>{{$checkout->tanggal_keluar}}</td>
								<td>{{$checkout->asrama}}</td>
								@if($checkout->daftar_asrama_type = "Daftar_asrama_reguler")
									<td>Reguler</td>
								@else
									<td>Non Reguler</td>
								@endif
								<td><button class="button" id="btn{{$checkout->daftar_asrama_id}}" type="button">Rincian</button></td>
								
							</tr>

							
							<!-- MODAL UNTUK validasi pendaftaran -->
							<style type="text/css">
								/* The Close Button */
							.close{{$checkout->daftar_asrama_id}} {
								color: white;
								float: right;
								font-size: 28px;
								font-weight: bold;
							}

							.close{{$checkout->daftar_asrama_id}}:hover,
							.close{{$checkout->daftar_asrama_id}}:focus {
								color: #000;
								text-decoration: none;
								cursor: pointer;
							}
							</style>
							<div id="myModal{{$checkout->daftar_asrama_id}}" class="modal">

							  <!-- Modal content -->
							  <div class="modal-content">
								<div class="modal-header">
								  <span class="close{{$checkout->daftar_asrama_id}}">&times;</span>
								  <h3><b>Validasi Pengajuan Keluar</b></h3>
								</div>
								<div class="modal-body">
							  		<br>
							  	  	<p><span style="display: inline-block; width: 150px;">Nama</span><b>: {{$checkout->name}}</b><br>
							  	  	<span style="display: inline-block; width: 150px;">Tanggal Pengajuanr</span>: {{$checkout->tanggal_keluar}}<br>
							  	  	<span style="display: inline-block; width: 150px;">Email</span>: {{$checkout->email}}<br>
									<span style="display: inline-block; width: 150px;">Lokasi Asrama</span>: {{$checkout->asrama}}<br>
									<span style="display: inline-block; width: 150px;">Alasan</span>: {{$checkout->alasan_checkout}}<br>
									</p><hr>
									<p style="color:red"><i>Harap untuk mengirimkan email konfirmasi kepada penghuni yang telah mengajukan permohonan, apakah permohonanya diterima atau ditolak.<br></i></p>
									
									@if ($checkout->daftar_asrama_type = "Daftar_asrama_reguler")
										<form action="{{route('accept_pengajuan_keluar_reguler')}}" method="POST" style="display:inline-block">
											{{ csrf_field() }}
											<label>Tanggal Keluar</label>
											<input type="date" class="input" name="tanggal_keluar"/><br>
											<label>Catatan</label>
											<input type="text" class="input" name="catatan_keluar"/><br><br>
											<input type="Hidden" name="id_daftar" value="{{$checkout->daftar_asrama_id}}">
											<input type="Hidden" name="id_checkout" value="{{$checkout->id_checkout}}">
											<button class="button" type="submit">Terima</button>
										</form>
										<form action="{{route('reject_pengajuan_keluar_reguler')}}" method="POST" style="display:inline-block">
											{{ csrf_field() }}
											<input type="Hidden" name="id_checkout" value="{{$checkout->id_checkout}}">
											<button class="button" type="submit">Tolak</button>
										</form>
									@else 
										<form action="{{route('accept_pengajuan_keluar_non_reguler')}}" method="POST" style="display:inline-block">
											{{ csrf_field() }}
											<label>Tanggal Keluar</label>
											<input type="date" class="input" name="tanggal_keluar"/><br>
											<label>Catatan</label>
											<input type="text" class="input" name="catatan_keluar"/><br><br>
											<input type="Hidden" name="id_daftar" value="{{$checkout->daftar_asrama_id}}">
											<input type="Hidden" name="id_checkout" value="{{$checkout->id_checkout}}">
											<button class="button" type="submit">Terima</button>
										</form>
										<form action="{{route('reject_pengajuan_keluar_non_reguler')}}" method="POST" style="display:inline-block">
											{{ csrf_field() }}
											<input type="Hidden" name="id_checkout" value="{{$checkout->id_checkout}}">
											<button class="button" type="submit">Tolak</button>
										</form>
									@endif
								</div>
							  </div>

							</div>
							<script>
							// Get the modal
							var modal{{$checkout->daftar_asrama_id}} = document.getElementById('myModal{{$checkout->daftar_asrama_id}}');

							// Get the button that opens the modal
							var btn{{$checkout->daftar_asrama_id}} = document.getElementById("btn{{$checkout->daftar_asrama_id}}");

							// Get the <span> element that closes the modal
							var span{{$checkout->daftar_asrama_id}} = document.getElementsByClassName("close{{$checkout->daftar_asrama_id}}")[0];

							// When the user clicks the button, open the modal 
							btn{{$checkout->daftar_asrama_id}}.onclick = function() {
								modal{{$checkout->daftar_asrama_id}}.style.display = "block";
							}

							// When the user clicks on <span> (x), close the modal
							span{{$checkout->daftar_asrama_id}}.onclick = function() {
								modal{{$checkout->daftar_asrama_id}}.style.display = "none";
							}

							// When the user clicks anywhere outside of the modal, close it
							window.onclick = function(event) {
								if (event.target == modal{{$checkout->daftar_asrama_id}}) {
									modal{{$checkout->daftar_asrama_id}}.style.display = "none";
								}
							}
							</script>

							
							<?php $urut += 1; ?>
							@endforeach
						</table>
						{{-- {{$Reg->links()}} --}}
					</div>
				@else
				<p>Belum ada penghuni reguler baru yang mengajukan keluar.</p>
				@endif
				<br><br>

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

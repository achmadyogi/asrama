@extends('layouts.default')

@section('title','Validasi Pendaftaran')

@section('main_menu')
	@parent

@endsection

@section('header_title','Sekretariat | Validasi Pendaftaran')
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
				@endif
				@if (session()->has('status2'))
					<div class="alert_success">
						{{session()->get('status2')}}
					</div> 
				@endif
				<h2><b>Validasi Pendaftaran Reguler</b></h2>
				@if($Reg != 0)
					<div class="table">
						<table>
							<tr>
								<th>No.</th>
								<th>Nama Penghuni</th>
								<th>Tanggal Daftar</th>
								<th>Detail</th>
							</tr>
							<?php $urut = 0; ?>
							@foreach($Reg as $reguler)
							<tr>
								<td>{{$urut+1}}.</td>
								<td>{{$reguler->name}}</td>
								<td>{{$updated_at[$urut]}}</td>
								<td><button class="button" id="btn{{$reguler->id_user}}" type="button">Edit</button>
							</tr>
							<!-- MODAL UNTUK EDIT PERIODE -->
							<style type="text/css">
								/* The Close Button */
							.close{{$reguler->id_user}} {
								color: white;
								float: right;
								font-size: 28px;
								font-weight: bold;
							}

							.close{{$reguler->id_user}}:hover,
							.close{{$reguler->id_user}}:focus {
								color: #000;
								text-decoration: none;
								cursor: pointer;
							}
							</style>
							<div id="myModal{{$reguler->id_user}}" class="modal">

							  <!-- Modal content -->
							  <div class="modal-content">
								<div class="modal-header">
								  <span class="close{{$reguler->id_user}}">&times;</span>
								  <h3><b>Verifikasi Pendaftaran</b></h3>
								</div>
								<div class="modal-body">
							  		<br>
							  	  	<p><span style="display: inline-block; width: 150px;">Nama</span><b>: {{$reguler->name}}</b><br>
							  	  	<span style="display: inline-block; width: 150px;">Tanggal Daftar</span>: {{$updated_at[$urut]}}<br>
							  	  	<span style="display: inline-block; width: 150px;">Lokasi Asrama</span>: {{$reguler->lokasi_asrama}}<br>
							  	  	@if($reguler->preference == 1)
							  	  		<span style="display: inline-block; width: 150px;">Preference</span>: Sendirian<br>
							  	  	@elseif($reguler->preference == 2)
							  	  		<span style="display: inline-block; width: 150px;">Preference</span>: Berdua<br>
							  	  	@else
							  	  		<span style="display: inline-block; width: 150px;">Preference</span>: Bertiga<br>
							  	  	@endif
							  	  	<span style="display: inline-block; width: 150px;">Tanggal Masuk</span>: {{$tanggal_masuk[$urut]}}<br>
							  	  	<span style="display: inline-block; width: 150px;">Disabilitas</span>: 
							  	  	@if($reguler->is_difable == 1)
							  	  	 	Ya
							  	  	@else
							  	  		Tidak
							  	  	@endif
							  	  	</p><hr>
							  	  	<h3><b>Form Verifikasi</b></h3>
									  <form action="{{route('inboundReg_approval')}}" method="POST">
									  	{{ csrf_field() }}
									  	<input type="Hidden" name="id_daftar" value="{{$reguler->id_daftar}}">
									  	<label>Tanggal Masuk</label><br>
									  	<div class="form-group{{ $errors->has('tanggal_masuk') ? ' has-error' : '' }}">
										  	<input id="tanggal_masuk" class="input" type="date" name="tanggal_masuk" value="{{$reguler->tanggal_masuk}}">
										  	@if ($errors->has('tanggal_masuk'))
				                                <span class="help-block">
				                                    <strong>{{ $errors->first('tanggal_masuk') }}</strong>
				                                </span>
				                            @endif
										</div>
										<p><i>Catatan: form ini digunakan untuk memastikan bahwa data yang dimasukkan oleh calon penghuni sebelum disetujui masih dapat diedit kembali sesuai dengan keperluan. Setelah Anda melakukan verifikasi maka calon penghuni akan mendapatkan kamar dan data tagihan yang harus dibayar.<br></i></p>
									  	<button class="button" type="submit">Verify</button><br><br>
									  </form>
								</div>
							  </div>

							</div>
							<script>
							// Get the modal
							var modal{{$reguler->id_user}} = document.getElementById('myModal{{$reguler->id_user}}');

							// Get the button that opens the modal
							var btn{{$reguler->id_user}} = document.getElementById("btn{{$reguler->id_user}}");

							// Get the <span> element that closes the modal
							var span{{$reguler->id_user}} = document.getElementsByClassName("close{{$reguler->id_user}}")[0];

							// When the user clicks the button, open the modal 
							btn{{$reguler->id_user}}.onclick = function() {
								modal{{$reguler->id_user}}.style.display = "block";
							}

							// When the user clicks on <span> (x), close the modal
							span{{$reguler->id_user}}.onclick = function() {
								modal{{$reguler->id_user}}.style.display = "none";
							}

							// When the user clicks anywhere outside of the modal, close it
							window.onclick = function(event) {
								if (event.target == modal{{$reguler->id_user}}) {
									modal{{$reguler->id_user}}.style.display = "none";
								}
							}
							</script>
							<?php $urut += 1; ?>
							@endforeach
						</table>
					</div>
				@else
				<p>Belum ada penghuni reguler baru yang mengajukan pendaftaran.</p>
				@endif
				<br><br>
				<h2><b>Validasi Pendaftaran Non Reguler</b></h2>
				@if($nonReg != 0)
					<div class="table">
						<table>
							<tr>
								<th>No.</th>
								<th>Nama Penghuni</th>
								<th>Tanggal Daftar</th>
								<th>Detail</th>
							</tr>
							<?php $urut = 0; ?>
							@foreach($nonReg as $nonreg)
							<tr>
								<td>{{$urut+1}}.</td>
								<td>{{$nonreg->name}}</td>
								<td>{{$updated_at2[$urut]}}</td>
								<td><button class="button" id="btn_non{{$nonreg->id_user}}" type="button">Edit</button>
							</tr>
							<!-- MODAL UNTUK EDIT PERIODE -->
							<style type="text/css">
								/* The Close Button */
							.close_non{{$nonreg->id_user}} {
								color: white;
								float: right;
								font-size: 28px;
								font-weight: bold;
							}

							.close_non{{$nonreg->id_user}}:hover,
							.close_non{{$nonreg->id_user}}:focus {
								color: #000;
								text-decoration: none;
								cursor: pointer;
							}
							</style>
							<div id="myModal_non{{$nonreg->id_user}}" class="modal">

							  <!-- Modal content -->
							  <div class="modal-content">
								<div class="modal-header">
								  <span class="close_non{{$nonreg->id_user}}">&times;</span>
								  <h3><b>Verifikasi Pendaftaran</b></h3>
								</div>
								<div class="modal-body">
							  		<br>
							  	  	<p><span style="display: inline-block; width: 150px;">Nama</span><b>: {{$nonreg->name}}</b><br>
							  	  	<span style="display: inline-block; width: 150px;">Tanggal Daftar</span>: {{$updated_at2[$urut]}}<br>
							  	  	<span style="display: inline-block; width: 150px;">Keperluan Tinggal</span>: {{$nonreg->tujuan_tinggal}}<br>
							  	  	<span style="display: inline-block; width: 150px;">Lokasi Asrama</span>: {{$nonreg->lokasi_asrama}}<br>
							  	  	@if($nonreg->preference == 1)
							  	  		<span style="display: inline-block; width: 150px;">Preference</span>: Sendirian<br>
							  	  	@elseif($nonreg->preference == 2)
							  	  		<span style="display: inline-block; width: 150px;">Preference</span>: Berdua<br>
							  	  	@else
							  	  		<span style="display: inline-block; width: 150px;">Preference</span>: Bertiga<br>
							  	  	@endif
							  	  	<span style="display: inline-block; width: 150px;">Tempo</span>: {{$nonreg->tempo}}<br>
							  	  	<span style="display: inline-block; width: 150px;">Jumlah hari/bulan</span>:
							  	  	@if($nonreg->tempo == 'harian')
							  	  		{{$nonreg->lama_tinggal}} hari
							  	  	@else
							  	  		{{$nonreg->lama_tinggal}} bulan
							  	  	@endif <br>
							  	  	<span style="display: inline-block; width: 150px;">Tanggal Masuk</span>: {{$tanggal_masuk2[$urut]}}<br>
							  	  	<span style="display: inline-block; width: 150px;">Kebutuhan Khusus</span>: 
							  	  	@if($nonreg->is_difable == 1)
							  	  	 	Ya
							  	  	@else
							  	  		Tidak
							  	  	@endif <br>
							  	  	<span style="display: inline-block; width: 150px;">Rincian</span>: {{$nonreg->ket_difable}}
							  	  	</p><hr>
							  	  	<h3><b>Form Verifikasi</b></h3>
									  <form action="{{ route('inboundNonReg_approval') }}" method="POST">
									  	{{ csrf_field() }}
									  	<input type="Hidden" name="id_daftar" value="{{$nonreg->id_daftar}}">
									  	<label>Tanggal Masuk</label><br>
									  	<div class="form-group{{ $errors->has('tanggal_masuk') ? ' has-error' : '' }}">
										  	<input id="tanggal_masuk" class="input" type="date" name="tanggal_masuk" value="{{$nonreg->tanggal_masuk}}">
										  	@if ($errors->has('tanggal_masuk'))
				                                <span class="help-block">
				                                    <strong>{{ $errors->first('tanggal_masuk') }}</strong>
				                                </span>
				                            @endif
										</div>
										<label>Tempo</label><br>
										@if($nonreg->tempo == 'harian')
											<input type="radio" name="tempo" value="{{$nonreg->tempo}}" checked> Harian<br>
											<input type="radio" name="tempo" value="bulanan"> Bulanan<br>
										@else
											<input type="radio" name="tempo" value="harian"> Harian<br>
											<input type="radio" name="tempo" value="{{$nonreg->tempo}}" checked> Bulanan<br>
										@endif <br>
										<label>Lama Tinggal</label><br>
										<div class="form-group{{ $errors->has('lama_tinggal') ? ' has-error' : '' }}">
										  	<input id="lama_tinggal" class="input" type="number" name="lama_tinggal" placeholder="Jumlah hari atau bulan" value="{{$nonreg->lama_tinggal}}">
										  	@if ($errors->has('lama_tinggal'))
				                                <span class="help-block">
				                                    <strong>{{ $errors->first('lama_tinggal') }}</strong>
				                                </span>
				                            @endif
										</div>
										<p><i>Catatan: form ini digunakan untuk memastikan bahwa data yang dimasukkan oleh calon penghuni sebelum disetujui masih dapat diedit kembali sesuai dengan keperluan. Setelah Anda melakukan verifikasi maka calon penghuni akan mendapatkan kamar dan data tagihan yang harus dibayar.<br></i></p>
									  	<button class="button" type="submit">Verify</button><br><br>
									  </form>
								</div>
							  </div>

							</div>
							<script>
							// Get the modal
							var modal_non{{$nonreg->id_user}} = document.getElementById('myModal_non{{$nonreg->id_user}}');

							// Get the button that opens the modal
							var btn_non{{$nonreg->id_user}} = document.getElementById("btn_non{{$nonreg->id_user}}");

							// Get the <span> element that closes the modal
							var span_non{{$nonreg->id_user}} = document.getElementsByClassName("close_non{{$nonreg->id_user}}")[0];

							// When the user clicks the button, open the modal 
							btn_non{{$nonreg->id_user}}.onclick = function() {
								modal_non{{$nonreg->id_user}}.style.display = "block";
							}

							// When the user clicks on <span> (x), close the modal
							span_non{{$nonreg->id_user}}.onclick = function() {
								modal_non{{$nonreg->id_user}}.style.display = "none";
							}

							// When the user clicks anywhere outside of the modal, close it
							window.onclick = function(event) {
								if (event.target == modal_non{{$nonreg->id_user}}) {
									modal_non{{$nonreg->id_user}}.style.display = "none";
								}
							}
							</script>
							<?php $urut += 1; ?>
							@endforeach
						</table>
					</div>
				@else
				<p>Belum ada penghuni non reguler baru yang mengajukan pendaftaran.</p>
				@endif
			</div>
		</div>
	</div>
	<br><br><br>
</div>
@endsection

@extends('layouts.default')

@section('title','Validasi Pendaftaran Non Reguler')
@section('menu_dash','active')

@section('main_menu')
	@parent

@endsection

@section('header_title','Sekretariat | Validasi Pendaftaran')
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
				
				<h2><b>Validasi Pendaftaran Non Reguler</b></h2>
				@if(isset($nonReg))
					<div class="input-group" style="z-index: 1">
						<input type="text" class="form-control" name="q"
							placeholder="Search users"> <span class="input-group-btn">
							<button type="submit" class="btn btn-default">
								<span class="glyphicon glyphicon-search"></span>
							</button>
						</span>
					</div>
					<br><br>
					<div class="table">
						<table>
							<tr>
								<th>No.</th>
								<th>Nama Penghuni</th>
								<th>Tanggal Daftar</th>
								<th>Tujuan Tinggal</th>
								<th>Detail</th>
							</tr>
							<?php $urut = 0; ?>
							@foreach($nonReg as $nonreg)
							<tr>
								<td>{{$urut+1}}.</td>
								<td>{{$nonreg->name}}</td>
								<td>{{$updated_at2[$urut]}}</td>
								<td>{{ $nonreg->tujuan_tinggal}}</td>
								<td><button class="button" id="btn_non{{$nonreg->id_daftar}}" type="button">Edit</button>
							</tr>
							<!-- MODAL UNTUK EDIT PERIODE -->
							<style type="text/css">
								/* The Close Button */
							.close_non{{$nonreg->id_daftar}} {
								color: white;
								float: right;
								font-size: 28px;
								font-weight: bold;
							}

							.close_non{{$nonreg->id_daftar}}:hover,
							.close_non{{$nonreg->id_daftar}}:focus {
								color: #000;
								text-decoration: none;
								cursor: pointer;
							}
							</style>
							<div id="myModal_non{{$nonreg->id_daftar}}" class="modal">

							  <!-- Modal content -->
							  <div class="modal-content">
								<div class="modal-header">
								  <span class="close_non{{$nonreg->id_daftar}}">&times;</span>
								  <h3><b>Verifikasi Pendaftaran</b></h3>
								</div>
								<div class="modal-body">
							  		<br>
							  		<div class="row">
							  			<div class="col-md-6">
							  				<p>
							  					<span style="display: inline-block; width: 150px;">Nama</span><b>: {{$nonreg->name}}</b><br>
							  	  				<span style="display: inline-block; width: 150px;">Tanggal Daftar</span>: {{$updated_at2[$urut]}}<br>
							  	  				<span style="display: inline-block; width: 150px;">Lokasi Asrama</span>: {{$nonreg->lokasi_asrama}}<br>
							  					@if($nonreg->preference == 1)
										  	  		<span style="display: inline-block; width: 150px;">Preference</span>: Sendirian<br>
										  	  	@elseif($nonreg->preference == 2)
										  	  		<span style="display: inline-block; width: 150px;">Preference</span>: Berdua<br>
										  	  	@else
										  	  		<span style="display: inline-block; width: 150px;">Preference</span>: Bertiga<br>
										  	  	@endif
										  	  	<span style="display: inline-block; width: 150px;">Tempo</span>: {{$nonreg->tempo}}<br>
							  	  			</p>
							  			</div>
							  			<div class="col-md-6">
							  				<p>
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
										  	  	<span style="display: inline-block; width: 150px;">Rincian</span>: {{$nonreg->ket_difable}}<br>
							  	  				<span style="display: inline-block; width: 150px;">Keperluan Tinggal</span>: {{$nonreg->tujuan_tinggal}}<br>
										  	</p>
							  			</div>
							  		</div>
							  	  	<hr>
							  	  	<select class="select" id="metode{{$nonreg->id_daftar}}">
							  	  		<option value="">~~ Pilih Metode Penerimaan ~~</option>
							  	  		<option value="otomatis">Penerimaan Otomatis</option>
							  	  		<option value="manual">Penerimaan Manual</option>
							  	  	</select>
							  	  	<div id="blank{{$nonreg->id_daftar}}" style="display: none;">
							  	  		<br><p>Pilih metode penerimaan untuk memulai validasi</p>
							  	  	</div>
							  	  	<div id="manual{{$nonreg->id_daftar}}" style="display: none;">	
							  	  		<h3><b>Form Verifikasi (manual)</b></h3>
							  	  		<form action="{{ route('inboundNonReg_manual') }}" method="POST">
										  	{{ csrf_field() }}
										  	<input type="hidden" name="id_daftar" value="{{$nonreg->id_daftar}}">
										  	<label>ID Kamar</label><br>
										  	<input type="number" name="id_kamar" class="input"><br><br>
										  	<label>Jumlah Tagihan</label><br>
										  	<input type="number" name="tagihan" class="input"><br><br>
										  	<label>Disabilitas</label><br>
										  	<input type="radio" name="disabilitas" value="0" selected> Tidak<br>
										  	<input type="radio" name="disabilitas" value="1" selected> Iya<br><br>
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
										  	<button class="button" type="submit">Verify</button>
										  	<button class="button" type="button" id="btn_list{{$nonreg->id_daftar}}">Waiting List</button>
											<button class="button-close" type="button" id="btn_blacklist{{$nonreg->id_daftar}}">Blacklist</button>
											<button class="button-close" type="button" id="btn_taklolos{{$nonreg->id_daftar}}">Tidak Lolos</button><br><br>
										</form>
							  	  	</div>
							  	  	<div id="otomatis{{$nonreg->id_daftar}}" style="display: none;">	
							  	  		<h3><b>Form Verifikasi (otomatis)</b></h3>
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
										  	<button class="button" type="submit">Verify</button>
										  	<button class="button" type="button" id="btn_list_auto{{$nonreg->id_daftar}}">Waiting List</button>
											<button class="button-close" type="button" id="btn_blacklist_auto{{$nonreg->id_daftar}}">Blacklist</button>
											<button class="button-close" type="button" id="btn_taklolos_auto{{$nonreg->id_daftar}}">Tidak Lolos</button><br><br> 
										</form>
							  	  	</div>
							  	  	<script type="text/javascript">
							  	  		$(document).ready(function(){
							  	  			$('#metode{{$nonreg->id_daftar}}').change(function(){
							  	  				var metode = $('#metode{{$nonreg->id_daftar}}').val();
							  	  				if(metode == 'otomatis'){
							  	  					console.log(metode);
							  	  					$('#blank{{$nonreg->id_daftar}}').hide(500);
							  	  					$('#manual{{$nonreg->id_daftar}}').hide(500);
							  	  					$('#otomatis{{$nonreg->id_daftar}}').show(500);
							  	  				}else if(metode == 'manual'){
							  	  					console.log(metode);
							  	  					$('#blank{{$nonreg->id_daftar}}').hide(500);
							  	  					$('#manual{{$nonreg->id_daftar}}').show(500);
							  	  					$('#otomatis{{$nonreg->id_daftar}}').hide(500);
							  	  				}else{
							  	  					console.log(metode);
							  	  					$('#blank{{$nonreg->id_daftar}}').show(500);
							  	  					$('#manual{{$nonreg->id_daftar}}').hide(500);
							  	  					$('#otomatis{{$nonreg->id_daftar}}').hide(500);
							  	  				}
							  	  			});
							  	  		});
							  	  	</script>
							  	  	<!-- MODAL UNTUK WAITING LIST, BLACK LIST, DAN DITOLAK -->
							  	  	<!-- Modal untuk pop up blacklist -->
									<style type="text/css">
										/* The Close Button */
									.close_blacklist{{$nonreg->id_daftar}} {
										color: white;
										float: right;
										font-size: 28px;
										font-weight: bold;
									}

									.close_blacklist{{$nonreg->id_daftar}}:hover,
									.close_blacklist{{$nonreg->id_daftar}}:focus {
										color: #000;
										text-decoration: none;
										cursor: pointer;
									}
									</style>
									<div id="myModal_blacklist{{$nonreg->id_daftar}}" class="modal">

									<!-- Modal content -->
									<div class="modal-content-blacklist">
										<div class="modal-header">
										<span class="close_blacklist{{$nonreg->id_daftar}}">&times;</span>
										<h3><b>Verifikasi Blacklist</b></h3>
										</div>
										<div class="modal-body">
											<br>
											<div class="row">
												<div class="col-md-12">
													<p>Apakah Anda yakin akan blacklist ?</p>
												</div>
											</div><hr>
											<form action="{{route('submit_blacklist_non')}}" method="POST">
												{{ csrf_field() }}
												<label>Alasan Blacklist</label><br>
												<input type="text" name="alasan" class = "input"><br><br>
												<input type="hidden" name="id_daftar" value="{{$nonreg->id_daftar}}">
												<input type="hidden" name="id_user" value="{{$nonreg->id_user}}">
												<button class="button" type="button" id="btn_keluar{{$nonreg->id_daftar}}">Keluar</button>
												<button class="button-close" type="submit">Blacklist</button><br><br>  
											</form>
										</div>
									</div>

									</div>
									<script>
										// Get the modal
										var modal_blacklist{{$nonreg->id_daftar}} = document.getElementById('myModal_blacklist{{$nonreg->id_daftar}}');

										// Get the button that opens the modal
										var btn_blacklist{{$nonreg->id_daftar}} = document.getElementById("btn_blacklist{{$nonreg->id_daftar}}");

										// Get the <span> element that closes the modal
										var span_blacklist{{$nonreg->id_daftar}} = document.getElementsByClassName("close_blacklist{{$nonreg->id_daftar}}")[0];

										// When the user clicks the button, open the modal 
										btn_blacklist{{$nonreg->id_daftar}}.onclick = function() {
											modal_blacklist{{$nonreg->id_daftar}}.style.display = "block";
										}

										//button keluar
										btn_keluar{{$nonreg->id_daftar}}.onclick = function() {
											modal_blacklist{{$nonreg->id_daftar}}.style.display = "none";
										}

										// When the user clicks on <span> (x), close the modal
										span_blacklist{{$nonreg->id_daftar}}.onclick = function() {
											modal_blacklist{{$nonreg->id_daftar}}.style.display = "none";
										}

										// When the user clicks anywhere outside of the modal, close it
										window.onclick = function(event) {
											if (event.target == modal_blacklist{{$nonreg->id_daftar}}) {
												modal_blacklist{{$nonreg->id_daftar}}.style.display = "none";
											}
										}
									</script>

									<!-- Modal untuk pop up waiting list -->
									<style type="text/css">
										/* The Close Button */
									.close_list{{$nonreg->id_daftar}} {
										color: white;
										float: right;
										font-size: 28px;
										font-weight: bold;
									}

									.close_list{{$nonreg->id_daftar}}:hover,
									.close_list{{$nonreg->id_daftar}}:focus {
										color: #000;
										text-decoration: none;
										cursor: pointer;
									}
									</style>
									<div id="myModal_list{{$nonreg->id_daftar}}" class="modal">

									<!-- Modal content -->
									<div class="modal-content">
										<div class="modal-header">
										<span class="close_list{{$nonreg->id_daftar}}">&times;</span>
										<h3><b>Verifikasi Waiting List</b></h3>
										</div>
										<div class="modal-body">
											<br>
											<div class="row">
												<div class="col-md-12">
													<p>Apakah Anda yakin akan memasukkan pada daftar waiting list untuk penghuni ini?</p>
												</div>
											</div><hr>
											<form action="{{route('submit_list_non')}}" method="POST">
												{{ csrf_field() }}
												<input type="hidden" name="id_daftar" value="{{$nonreg->id_daftar}}">
												<input type="hidden" name="id_user" value="{{$nonreg->id_user}}">
												<button class="button" type="button" id="btn_keluar_list{{$nonreg->id_daftar}}">Keluar</button>
												<button class="button-close" type="submit">Waiting List</button><br><br>  
											</form>
										</div>
									</div>

									</div>
									<script>
										// Get the modal
										var modal_list{{$nonreg->id_daftar}} = document.getElementById('myModal_list{{$nonreg->id_daftar}}');

										// Get the button that opens the modal
										var btn_list{{$nonreg->id_daftar}} = document.getElementById("btn_list{{$nonreg->id_daftar}}");

										// Get the <span> element that closes the modal
										var span_list{{$nonreg->id_daftar}} = document.getElementsByClassName("close_list{{$nonreg->id_daftar}}")[0];

										// When the user clicks the button, open the modal 
										btn_list{{$nonreg->id_daftar}}.onclick = function() {
											modal_list{{$nonreg->id_daftar}}.style.display = "block";
										}

										//button keluar
										btn_keluar_list{{$nonreg->id_daftar}}.onclick = function() {
											modal_list{{$nonreg->id_daftar}}.style.display = "none";
										}

										// When the user clicks on <span> (x), close the modal
										span_list{{$nonreg->id_daftar}}.onclick = function() {
											modal_list{{$nonreg->id_daftar}}.style.display = "none";
										}

										// When the user clicks anywhere outside of the modal, close it
										window.onclick = function(event) {
											if (event.target == modal_list{{$nonreg->id_daftar}}) {
												modal_list{{$nonreg->id_daftar}}.style.display = "none";
											}
										}
									</script>

									<!-- Modal untuk pop up tidak lolos -->
									<style type="text/css">
										/* The Close Button */
									.close_taklolos{{$nonreg->id_daftar}} {
										color: white;
										float: right;
										font-size: 28px;
										font-weight: bold;
									}

									.close_taklolos{{$nonreg->id_daftar}}:hover,
									.close_taklolos{{$nonreg->id_daftar}}:focus {
										color: #000;
										text-decoration: none;
										cursor: pointer;
									}
									</style>
									<div id="myModal_taklolos{{$nonreg->id_daftar}}" class="modal">

									<!-- Modal content -->
									<div class="modal-content">
										<div class="modal-header">
										<span class="close_taklolos{{$nonreg->id_daftar}}">&times;</span>
										<h3><b>Verifikasi Tidak Lolos</b></h3>
										</div>
										<div class="modal-body">
											<br>
											<div class="row">
												<div class="col-md-12">
													<p>Apakah Anda yakin untuk tidak meloloskan pendaftaran penghuni ini?</p>
												</div>
											</div><hr>
											<form action="{{route('taklolos_non')}}" method="POST">
												{{ csrf_field() }}
												<input type="hidden" name="id_daftar" value="{{$nonreg->id_daftar}}">
												<input type="hidden" name="id_user" value="{{$nonreg->id_user}}">
												<button class="button" type="button" id="btn_keluar_taklolos{{$nonreg->id_daftar}}">Keluar</button>
												<button class="button-close" type="submit">Tidak Lolos</button><br><br>  
											</form>
										</div>
									</div>

									</div>
									<script>
										// Get the modal
										var modal_taklolos{{$nonreg->id_daftar}} = document.getElementById('myModal_taklolos{{$nonreg->id_daftar}}');

										// Get the button that opens the modal
										var btn_taklolos{{$nonreg->id_daftar}} = document.getElementById("btn_taklolos{{$nonreg->id_daftar}}");

										// Get the <span> element that closes the modal
										var span_taklolos{{$nonreg->id_daftar}} = document.getElementsByClassName("close_taklolos{{$nonreg->id_daftar}}")[0];

										// When the user clicks the button, open the modal 
										btn_taklolos{{$nonreg->id_daftar}}.onclick = function() {
											modal_taklolos{{$nonreg->id_daftar}}.style.display = "block";
										}

										//button keluar
										btn_keluar_taklolos{{$nonreg->id_daftar}}.onclick = function() {
											modal_taklolos{{$nonreg->id_daftar}}.style.display = "none";
										}

										// When the user clicks on <span> (x), close the modal
										span_taklolos{{$nonreg->id_daftar}}.onclick = function() {
											modal_taklolos{{$nonreg->id_daftar}}.style.display = "none";
										}

										// When the user clicks anywhere outside of the modal, close it
										window.onclick = function(event) {
											if (event.target == modal_taklolos{{$nonreg->id_daftar}}) {
												modal_taklolos{{$nonreg->id_daftar}}.style.display = "none";
											}
										}
									</script>
								</div>
							  </div>

							</div>
							<script>
							// Get the modal
							var modal_non{{$nonreg->id_daftar}} = document.getElementById('myModal_non{{$nonreg->id_daftar}}');

							// Get the button that opens the modal
							var btn_non{{$nonreg->id_daftar}} = document.getElementById("btn_non{{$nonreg->id_daftar}}");

							// Get the <span> element that closes the modal
							var span_non{{$nonreg->id_daftar}} = document.getElementsByClassName("close_non{{$nonreg->id_daftar}}")[0];

							// When the user clicks the button, open the modal 
							btn_non{{$nonreg->id_daftar}}.onclick = function() {
								modal_non{{$nonreg->id_daftar}}.style.display = "block";
							}

							// When the user clicks on <span> (x), close the modal
							span_non{{$nonreg->id_daftar}}.onclick = function() {
								modal_non{{$nonreg->id_daftar}}.style.display = "none";
							}

							// When the user clicks anywhere outside of the modal, close it
							window.onclick = function(event) {
								if (event.target == modal_non{{$nonreg->id_daftar}}) {
									modal_non{{$nonreg->id_daftar}}.style.display = "none";
								}
							}
							</script>
							<?php $urut += 1; ?>
							@endforeach
							
						</table>
						{{$nonReg->links()}}
					</div>
				@else
				<p>Belum ada penghuni non reguler baru yang mengajukan pendaftaran.</p>
				@endif
			</div><br><br>
		</div>
		<div class="col-md-3">
			<!-- MENU DASHBOARD -->
			@include('dashboard.menuDashboard')
		</div>
	</div>
	<br><br><br>
</div>
@endsection

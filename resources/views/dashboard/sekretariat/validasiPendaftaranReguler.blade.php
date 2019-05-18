@extends('layouts.default')

@section('title','Validasi Pendaftaran Reguler')
@section('menu_dash','active')

@section('main_menu')
	@parent

@endsection

@section('header_title','Sekretariat | Validasi Pendaftaran Reguler')
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
				<h2><b>Validasi Pendaftaran Reguler</b></h2>
				@if(isset($Reg))
					<div class="table">
						<table>
							<tr>
								<th>No.</th>
								<th>ID Pendaftaran</th>
								<th>Nama Penghuni</th>
								<th>Tanggal Daftar</th>
								<th>Periode</th>
								<th>Status</th>
								<th>Jenis Kelamin</th>
								<th>Beasiswa</th>
								<th>Asrama</th>
								<th>Detail</th>
							</tr>
							<?php $urut = 0; ?>
							@foreach($Reg as $reguler)
							<tr>
								<td>{{$urut+1}}.</td>
								<td>{{$reguler->id_daftar}}</td>
								<td>{{$reguler->name}}</td>
								<td>{{$tanggal_daftar[$urut]}}</td>
								<td>{{$reguler->nama_periode}}</td>
								@if($reguler->verification == 4)
								<td>Waiting List</td>
								@elseif($reguler->verification == 0)
								<td>Menunggu Verifikasi</td>
								@endif
								<td>{{$reguler->jenis_kelamin}}</td>
								<td>{{$reguler->status_beasiswa}}</td>
								<td>{{$reguler->lokasi_asrama}}</td>
								<td><button class="button" id="btn{{$reguler->id_daftar}}" type="button">Rincian</button></td>
								
							</tr>

							
							<!-- MODAL UNTUK validasi pendaftaran -->
							<style type="text/css">
								/* The Close Button */
								.close{{$reguler->id_daftar}} {
									color: white;
									float: right;
									font-size: 28px;
									font-weight: bold;
								}

								.close{{$reguler->id_daftar}}:hover,
								.close{{$reguler->id_daftar}}:focus {
									color: #000;
									text-decoration: none;
									cursor: pointer;
								}
							</style>
							<div id="myModal{{$reguler->id_daftar}}" class="modal">

							  <!-- Modal content -->
							  <div class="modal-content">
								<div class="modal-header">
								  <span class="close{{$reguler->id_daftar}}">&times;</span>
								  <h3><b>Verifikasi Pendaftaran</b></h3>
								</div>
								<div class="modal-body">
							  		<br>
							  	  	<p><span style="display: inline-block; width: 150px;">Nama</span><b>: {{$reguler->name}}</b><br>
							  	  	<span style="display: inline-block; width: 150px;">Tanggal Daftar</span>: {{$tanggal_daftar[$urut]}}<br>
							  	  	<span style="display: inline-block; width: 150px;">Lokasi Asrama</span>: {{$reguler->lokasi_asrama}}<br>
							  	  	@if($reguler->preference == 1)
							  	  		<span style="display: inline-block; width: 150px;">Preference</span>: Sendirian  ({{$reguler->asrama}})<br>
							  	  	@elseif($reguler->preference == 2)
							  	  		<span style="display: inline-block; width: 150px;">Preference</span>: Berdua  ({{$reguler->asrama}})<br>
							  	  	@else
							  	  		<span style="display: inline-block; width: 150px;">Preference</span>: Bertiga  ({{$reguler->asrama}})<br>
							  	  	@endif
							  	  	<span style="display: inline-block; width: 150px;">Tanggal Masuk</span>: {{$tanggal_masuk[$urut]}}<br>
							  	  	<span style="display: inline-block; width: 150px;">Disabilitas</span>: 
							  	  	@if($reguler->is_difable == 1)
							  	  	 	Ya <br>
							  	  	 	<span style="display: inline-block; width: 150px;">Keterangan</span>: {{$reguler->ket_difable}}<br>
							  	  	@else
							  	  		Tidak
							  	  	@endif
										</p><hr>
										
									<select class="select" id="metode{{$reguler->id_daftar}}">
									<option value="">~~ Pilih Metode Penerimaan ~~</option>
									<option value="otomatis">Penerimaan Otomatis</option>
									<option value="manual">Penerimaan Manual</option>
									</select>
									<div id="blank{{$reguler->id_daftar}}" style="display: none;">
										<br><p>Pilih metode penerimaan untuk memulai validasi</p>
									</div>
									<div id="otomatis{{$reguler->id_daftar}}" style="display: none;">
										<h3><b>Form Verifikasi</b></h3>
										<input type="Hidden" name="id_daftar" value="{{$reguler->id_daftar}}">
										<label>Tanggal Masuk</label><br>
										<div class="form-group{{ $errors->has('tanggal_masuk_reg') ? ' has-error' : '' }}">
											<input id="tanggal_masuk_reg{{$reguler->id_daftar}}" class="input" type="date" name="tanggal_masuk_reg" value="{{$reguler->tanggal_masuk}}">
										</div>
										<div class="row">
											<div class="col-md-6">
												<Label>Preferensi</Label><br>
												@if($reguler->preference == 1)
													<input type="radio" name="pref{{$reguler->id_daftar}}" value="1" checked> Sendiri <br>
													<input type="radio" name="pref{{$reguler->id_daftar}}" value="2"> Berdua <br>
													<input type="radio" name="pref{{$reguler->id_daftar}}" value="3"> Bertiga <br>
												@elseif($reguler->preference == 2)
													<input type="radio" name="pref{{$reguler->id_daftar}}" value="1"> Sendiri <br>
													<input type="radio" name="pref{{$reguler->id_daftar}}" value="2" checked> Berdua <br>
													<input type="radio" name="pref{{$reguler->id_daftar}}" value="3"> Bertiga <br>
												@elseif($reguler->preference == 3)
													<input type="radio" name="pref{{$reguler->id_daftar}}" value="1"> Sendiri <br>
													<input type="radio" name="pref{{$reguler->id_daftar}}" value="2"> Berdua <br>
													<input type="radio" name="pref{{$reguler->id_daftar}}"  value="3" checked> Bertiga <br>
												@endif <br>
											</div>
											<div class="col-md-6">
												<label>Disabilitas</label><br>
												@if($reguler->is_difable == 1)
													<input type="radio" name="difable{{$reguler->id_daftar}}" value="1" checked> Ya<br>
													<input type="radio" name="difable{{$reguler->id_daftar}}" value="0"> Tidak<br>
												@else
													<input type="radio" name="difable{{$reguler->id_daftar}}" value="1"> Ya<br>
													<input type="radio" name="difable{{$reguler->id_daftar}}" value="0" checked> Tidak<br>
												@endif <br>
											</div>
										</div>
										<p><i>Catatan: <br>
											<ul>
												<li>form ini digunakan untuk memastikan bahwa data yang dimasukkan oleh calon penghuni sebelum disetujui masih dapat diedit kembali sesuai dengan keperluan.</li>
												<li>Calon penghuni dengan disabilitas harap untuk diverifikasi secara manual.</li>
											</ul><br></i></p>
										<button id="ava_check{{$reguler->id_daftar}}" class="button" type="button">Alokasi Kamar Baru</button> <button id="ava_lama{{$reguler->id_daftar}}" class="button" type="button">Alokasi Kamar Lama</button>
										<div id="wait{{$reguler->id_daftar}}" style="display: none;">Memeriksa ketersediaan kamar...</div>
										<div id="ava_check_div{{$reguler->id_daftar}}"></div>
										<script type="text/javascript">
											$(document).ready(function(){
												$(document).ajaxStart(function(){
											        $("#wait{{$reguler->id_daftar}}").css("display", "block");
											    });
											    $(document).ajaxComplete(function(){
											        $("#wait{{$reguler->id_daftar}}").css("display", "none");
											    });
												$('#ava_check{{$reguler->id_daftar}}').click(function() {
													var preference = $("input:radio[name=pref{{$reguler->id_daftar}}]:checked").val();
													var difable = $("input:radio[name=difable{{$reguler->id_daftar}}]:checked").val();
													var tanggal_masuk_reg = $('#tanggal_masuk_reg{{$reguler->id_daftar}}').val();
													console.log(preference);
												  	$.get('{{ route("alokasi_reg") }}',{
												  		'preference': preference,
												  		'difable': difable,
												  		'id_daftar': <?php echo $reguler->id_daftar; ?>,
												  		'tanggal_masuk_reg': tanggal_masuk_reg, 
												  		'_token':$('input[name=_token]').val()
												  	}, function(data, status){
														$('#ava_check_div{{$reguler->id_daftar}}').html(data);
													});
												});
												$('#ava_lama{{$reguler->id_daftar}}').click(function() {
													var preference = $("input:radio[name=pref{{$reguler->id_daftar}}]:checked").val();
													var difable = $("input:radio[name=difable{{$reguler->id_daftar}}]:checked").val();
													var tanggal_masuk_reg = $('#tanggal_masuk_reg{{$reguler->id_daftar}}').val();
												  	$.get('{{ route("alokasi_reg_lama_matic") }}',{
												  		'preference': preference,
												  		'difable': difable,
												  		'id_daftar': <?php echo $reguler->id_daftar; ?>,
												  		'tanggal_masuk_reg': tanggal_masuk_reg, 
												  		'_token':$('input[name=_token]').val()
												  	}, function(data, status){
														console.log(preference);
														$('#ava_check_div{{$reguler->id_daftar}}').html(data);
													});
												});
											});
										</script>
										<br><br>
									</div>
									<div id="manual{{$reguler->id_daftar}}" style="display: none;">
										<h3><b>Form Verifikasi Manual</b></h3>
										
										<form action="{{route('submit_alokasi')}}" method="POST">
											{{ csrf_field() }}
											<button class="button" type="button" id="btn_lanjut{{$reguler->id_daftar}}">Cek Lanjut Periode</button>
											<div id="lanjut_status{{$reguler->id_daftar}}" style="display: none;">
												<br>
												<p style="color:blue">*Pendaftar merupakan penghuni lama yang melanjutkan periode</p>
											</div>
											<div id="tdk_lanjut_status{{$reguler->id_daftar}}" style="display: none;">
												<br>
												<p style="color:red">*Pendaftar merupakan penghuni baru, silahkan alokasikan kamar</p>
											</div>
											<div id="cek_lanjut{{$reguler->id_daftar}}" class="form-group" style="display:none">
												<label>Jenis Penghuni</label><br>
												<select name="cek_lanjut" id="cek_lanjut_pilihan{{$reguler->id_daftar}}" class="form-control">
													<option value="" disable ="true" selected ="true">Pilih Jenis Penghuni</option>
												</select>
											</div>
											<script>
												$('#btn_lanjut{{$reguler->id_daftar}}').on('click',function(e){
													var id_user = {{$reguler->id_user}};
													console.log(id_user);
													$.get("/json_cek_lanjut_periode?id_user=" + id_user, function(data){
														console.log(data);
														if(data == 0) {
															console.log("Kosong");
															$('#lanjut_status{{$reguler->id_daftar}}').hide(500);
															$('#tdk_lanjut_status{{$reguler->id_daftar}}').show(500);
															$('#cek_lanjut{{$reguler->id_daftar}}').show(500);
															$('#cek_lanjut_pilihan{{$reguler->id_daftar}}').append('<option value="0" selected ="true">Penghuni Baru</option>');
														}else {
															console.log("Tak Kosong");
															$('#asrama{{$reguler->id_daftar}}').append('<option value="'+data[0].id_asrama+'" selected="true">'+data[0].asrama+'</option>');
															$('#gedung{{$reguler->id_daftar}}').append('<option value="'+data[0].id_gedung+'" selected="true">'+data[0].gedung+'</option>');
															$('#kamar{{$reguler->id_daftar}}').append('<option value="'+data[0].id_kamar+'" selected="true">'+data[0].kamar+'</option>');
															$('#tdk_lanjut_status{{$reguler->id_daftar}}').hide(500);
															$('#lanjut_status{{$reguler->id_daftar}}').show(500);
															$('#cek_lanjut{{$reguler->id_daftar}}').show(500);
															$('#cek_lanjut_pilihan{{$reguler->id_daftar}}').append('<option value="1" selected ="true">Penghuni Lama</option>');
														}
													});
												});
											</script>
											<div class="form-group">
												<label>Asrama</label><br>
												<select name="asrama" id="asrama{{$reguler->id_daftar}}" class="form-control">
													<option value="0" disable = "true" selected = "true">Pilih Asrama</option>
													@foreach($list_asrama as $asrama)
														<option value="{{$asrama->id_asrama}}">{{$asrama->nama}}</option>
													@endforeach
												</select>
											</div>
											<div id="gedung_field" class="form-group">
												<label>Gedung</label><br>
												<select name="gedung" id="gedung{{$reguler->id_daftar}}" class="form-control">
													<option value="0" disable = "true" selected = "true">Pilih Gedung</option>
												</select>
											</div>
											<div id="kamar_field" class="form-group">
												<label>Kamar</label><br>
												<select name="kamar" id="kamar{{$reguler->id_daftar}}" class="form-control">
													<option value="0" disable="true" selected = "true">Pilih Kamar</option>
												</select>
											</div>
											<script>
												
												var id = {!!json_encode($reguler->id_daftar, JSON_HEX_TAG)!!} 
												console.log(id);
												$('#asrama'+id).on('change', function(e){
													var id = {!!json_encode($reguler->id_daftar, JSON_HEX_TAG)!!} 
													console.log(id);
													var id_asrama = e.target.value;
													$.get("/json_gedung?id_asrama=" + id_asrama, function(data){
														
														$('#gedung'+id).empty();
														$('#gedung'+id).append('<option value="0" disable="true" selected="true">Pilih Gedung</option>');
											
														$('#kamar'+id).empty();
														$('#kamar'+id).append('<option value="0" disable="true" selected="true">Pilih Kamar</option>');
											
														$.each(data, function(index, gedungObj){
											
															$('#gedung'+id).append('<option value="'+ gedungObj.id_gedung +'">'+ gedungObj.nama +'</option>');
														})
											
													})
												});
												
												$('#gedung'+id).on('change', function(e){
													var id = {!!json_encode($reguler->id_daftar, JSON_HEX_TAG)!!} 
													console.log(id);
													var id_gedung = e.target.value;
													$.get("/json_kamar?id_gedung=" + id_gedung, function(data){
														$('#kamar'+id).empty();
														$('#kamar'+id).append('<option value="0" disable="true" selected="true">Pilih Kamar</option>');
											
														$.each(data, function(index, kamarObj){
											
															$('#kamar'+id).append('<option value="'+ kamarObj.id_kamar +'">'+ kamarObj.nama +'</option>');
														})
											
													})
												});
												
											</script>
											<div class="form-group">
												<label>Tagihan</label><br>
												<select name="tagihan" class="form-control" id="tagihan{{$reguler->id_daftar}}" required>
													<option value="0" disable="true" selected = "true">Pilih Tagihan</option>
													<option value="1">Rp. 1.500.000</option>
													<option value="2">Rp. 2.250.000</option>
													<option value="3">Rp. 0</option>
													<option value="4">Lainnya</option>
												</select>
											</div>
											<div id="tagihan_lain{{$reguler->id_daftar}}" class="form-group" style="display:none">
												<label>Nominal Tagihan</label><br>
												<input type="number" name="tagihan_lain" class = "input">
											</div>
											<script type="text/javascript">
												$(document).ready(function(){
													$('#tagihan{{$reguler->id_daftar}}').change(function(){
														var tagihan = $('#tagihan{{$reguler->id_daftar}}').val();
														console.log(tagihan);
														if(tagihan == '4'){
															console.log(tagihan);
															$('#tagihan_lain{{$reguler->id_daftar}}').show(500);
														} else {
															$('#tagihan_lain{{$reguler->id_daftar}}').hide(500);
														}
													});
												});
											</script>
											<label>Tanggal Masuk</label><br>
											<input id="tanggal_masuk_reg" class="input" type="date" name="tanggal_masuk_reg" value="{{$reguler->tanggal_masuk}}">
											<label>Disabilitas</label><br>
											@if($reguler->is_difable == 1)
												<input type="radio" name="difable" value="1" checked> Ya<br>
												<input type="radio" name="difable" value="0"> Tidak<br>
											@else
												<input type="radio" name="difable" value="1"> Ya<br>
												<input type="radio" name="difable" value="0" checked> Tidak<br>
											@endif <br>
											<input type="hidden" name="id_daftar" value="{{$reguler->id_daftar}}">
											<input type="hidden" name="id_user" value="{{$reguler->id_user}}">
											<button class="button" type="submit">Verify</button>
											<button class="button" type="button" id="btn_list{{$reguler->id_daftar}}">Waiting List</button>
											<button class="button-close" type="button" id="btn_blacklist{{$reguler->id_daftar}}">Blacklist</button>
											<button class="button-close" type="button" id="btn_taklolos{{$reguler->id_daftar}}">Tidak Lolos</button><br><br>  
										</form>
									</div>
									<script type="text/javascript">
										$(document).ready(function(){
											$('#metode{{$reguler->id_daftar}}').change(function(){
												var metode = $('#metode{{$reguler->id_daftar}}').val();
												if(metode == 'otomatis'){
													console.log(metode);
													$('#blank{{$reguler->id_daftar}}').hide(500);
													$('#manual{{$reguler->id_daftar}}').hide(500);
													$('#otomatis{{$reguler->id_daftar}}').show(500);
												}else if(metode == 'manual'){
													console.log(metode);
													$('#blank{{$reguler->id_daftar}}').hide(500);
													$('#manual{{$reguler->id_daftar}}').show(500);
													$('#otomatis{{$reguler->id_daftar}}').hide(500);
												}else{
													console.log(metode);
													$('#blank{{$reguler->id_daftar}}').show(500);
													$('#manual{{$reguler->id_daftar}}').hide(500);
													$('#otomatis{{$reguler->id_daftar}}').hide(500);
												}
											});
										});
									</script>
								</div>
							  </div>

							</div>
							<script>
							// Get the modal
							var modal{{$reguler->id_daftar}} = document.getElementById('myModal{{$reguler->id_daftar}}');

							// Get the button that opens the modal
							var btn{{$reguler->id_daftar}} = document.getElementById("btn{{$reguler->id_daftar}}");

							// Get the <span> element that closes the modal
							var span{{$reguler->id_daftar}} = document.getElementsByClassName("close{{$reguler->id_daftar}}")[0];

							// When the user clicks the button, open the modal 
							btn{{$reguler->id_daftar}}.onclick = function() {
								modal{{$reguler->id_daftar}}.style.display = "block";
							}

							// When the user clicks on <span> (x), close the modal
							span{{$reguler->id_daftar}}.onclick = function() {
								modal{{$reguler->id_daftar}}.style.display = "none";
							}

							// When the user clicks anywhere outside of the modal, close it
							window.onclick = function(event) {
								if (event.target == modal{{$reguler->id_daftar}}) {
									modal{{$reguler->id_daftar}}.style.display = "none";
								}
							}
							</script>

							<!-- Modal untuk pop up blacklist -->
							<style type="text/css">
								/* The Close Button */
								.close_blacklist{{$reguler->id_daftar}} {
									color: white;
									float: right;
									font-size: 28px;
									font-weight: bold;
								}

								.close_blacklist{{$reguler->id_daftar}}:hover,
								.close_blacklist{{$reguler->id_daftar}}:focus {
									color: #000;
									text-decoration: none;
									cursor: pointer;
								}
							</style>
							<div id="myModal_blacklist{{$reguler->id_daftar}}" class="modal">

							<!-- Modal content -->
							<div class="modal-content-blacklist">
								<div class="modal-header">
								<span class="close_blacklist{{$reguler->id_daftar}}">&times;</span>
								<h3><b>Verifikasi Blacklist</b></h3>
								</div>
								<div class="modal-body">
									<br>
									<div class="row">
										<div class="col-md-12">
											<p>Apakah Anda yakin akan blacklist ?</p>
										</div>
									</div><hr>
									<form action="{{route('submit_blacklist')}}" method="POST">
										{{ csrf_field() }}
										<label>Alasan Blacklist</label><br>
										<input type="text" name="alasan" class = "input"><br><br>
										<input type="hidden" name="id_daftar" value="{{$reguler->id_daftar}}">
										<input type="hidden" name="id_user" value="{{$reguler->id_user}}">
										<button class="button" type="button" id="btn_keluar{{$reguler->id_daftar}}">Keluar</button>
										<button class="button-close" type="submit">Blacklist</button><br><br>  
									</form>
								</div>
							</div>

							</div>
							<script>
								// Get the modal
								var modal_blacklist{{$reguler->id_daftar}} = document.getElementById('myModal_blacklist{{$reguler->id_daftar}}');

								// Get the button that opens the modal
								var btn_blacklist{{$reguler->id_daftar}} = document.getElementById("btn_blacklist{{$reguler->id_daftar}}");

								// Get the <span> element that closes the modal
								var span_blacklist{{$reguler->id_daftar}} = document.getElementsByClassName("close_blacklist{{$reguler->id_daftar}}")[0];

								// When the user clicks the button, open the modal 
								btn_blacklist{{$reguler->id_daftar}}.onclick = function() {
									modal_blacklist{{$reguler->id_daftar}}.style.display = "block";
								}

								//button keluar
								btn_keluar{{$reguler->id_daftar}}.onclick = function() {
									modal_blacklist{{$reguler->id_daftar}}.style.display = "none";
								}

								// When the user clicks on <span> (x), close the modal
								span_blacklist{{$reguler->id_daftar}}.onclick = function() {
									modal_blacklist{{$reguler->id_daftar}}.style.display = "none";
								}

								// When the user clicks anywhere outside of the modal, close it
								window.onclick = function(event) {
									if (event.target == modal_blacklist{{$reguler->id_daftar}}) {
										modal_blacklist{{$reguler->id_daftar}}.style.display = "none";
									}
								}
							</script>

							<!-- Modal untuk pop up waiting list -->
							<style type="text/css">
								/* The Close Button */
								.close_list{{$reguler->id_daftar}} {
									color: white;
									float: right;
									font-size: 28px;
									font-weight: bold;
								}

								.close_list{{$reguler->id_daftar}}:hover,
								.close_list{{$reguler->id_daftar}}:focus {
									color: #000;
									text-decoration: none;
									cursor: pointer;
								}
							</style>
							<div id="myModal_list{{$reguler->id_daftar}}" class="modal">

							<!-- Modal content -->
							<div class="modal-content">
								<div class="modal-header">
								<span class="close_list{{$reguler->id_daftar}}">&times;</span>
								<h3><b>Verifikasi Waiting List</b></h3>
								</div>
								<div class="modal-body">
									<br>
									<div class="row">
										<div class="col-md-12">
											<p>Apakah Anda yakin akan memasukkan pada daftar waiting list untuk penghuni ini?</p>
										</div>
									</div><hr>
									<form action="{{route('submit_list')}}" method="POST">
										{{ csrf_field() }}
										<input type="hidden" name="id_daftar" value="{{$reguler->id_daftar}}">
										<input type="hidden" name="id_user" value="{{$reguler->id_user}}">
										<button class="button" type="button" id="btn_keluar_list{{$reguler->id_daftar}}">Keluar</button>
										<button class="button-close" type="submit">Waiting List</button><br><br>  
									</form>
								</div>
							</div>

							</div>
							<script>
								// Get the modal
								var modal_list{{$reguler->id_daftar}} = document.getElementById('myModal_list{{$reguler->id_daftar}}');

								// Get the button that opens the modal
								var btn_list{{$reguler->id_daftar}} = document.getElementById("btn_list{{$reguler->id_daftar}}");

								// Get the <span> element that closes the modal
								var span_list{{$reguler->id_daftar}} = document.getElementsByClassName("close_list{{$reguler->id_daftar}}")[0];

								// When the user clicks the button, open the modal 
								btn_list{{$reguler->id_daftar}}.onclick = function() {
									modal_list{{$reguler->id_daftar}}.style.display = "block";
								}

								//button keluar
								btn_keluar_list{{$reguler->id_daftar}}.onclick = function() {
									modal_list{{$reguler->id_daftar}}.style.display = "none";
								}

								// When the user clicks on <span> (x), close the modal
								span_list{{$reguler->id_daftar}}.onclick = function() {
									modal_list{{$reguler->id_daftar}}.style.display = "none";
								}

								// When the user clicks anywhere outside of the modal, close it
								window.onclick = function(event) {
									if (event.target == modal_list{{$reguler->id_daftar}}) {
										modal_list{{$reguler->id_daftar}}.style.display = "none";
									}
								}
							</script>

							<!-- Modal untuk pop up tidak lolos -->
							<style type="text/css">
								/* The Close Button */
								.close_taklolos{{$reguler->id_daftar}} {
									color: white;
									float: right;
									font-size: 28px;
									font-weight: bold;
								}

								.close_taklolos{{$reguler->id_daftar}}:hover,
								.close_taklolos{{$reguler->id_daftar}}:focus {
									color: #000;
									text-decoration: none;
									cursor: pointer;
								}
							</style>
							<div id="myModal_taklolos{{$reguler->id_daftar}}" class="modal">

							<!-- Modal content -->
							<div class="modal-content">
								<div class="modal-header">
								<span class="close_taklolos{{$reguler->id_daftar}}">&times;</span>
								<h3><b>Verifikasi Tidak Lolos</b></h3>
								</div>
								<div class="modal-body">
									<br>
									<div class="row">
										<div class="col-md-12">
											<p>Apakah Anda yakin untuk tidak meloloskan pendaftaran penghuni ini?</p>
										</div>
									</div><hr>
									<form action="{{route('taklolos')}}" method="POST">
										{{ csrf_field() }}
										<input type="hidden" name="id_daftar" value="{{$reguler->id_daftar}}">
										<input type="hidden" name="id_user" value="{{$reguler->id_user}}">
										<button class="button" type="button" id="btn_keluar_taklolos{{$reguler->id_daftar}}">Keluar</button>
										<button class="button-close" type="submit">Tidak Lolos</button><br><br>  
									</form>
								</div>
							</div>

							</div>
							<script>
								// Get the modal
								var modal_taklolos{{$reguler->id_daftar}} = document.getElementById('myModal_taklolos{{$reguler->id_daftar}}');

								// Get the button that opens the modal
								var btn_taklolos{{$reguler->id_daftar}} = document.getElementById("btn_taklolos{{$reguler->id_daftar}}");

								// Get the <span> element that closes the modal
								var span_taklolos{{$reguler->id_daftar}} = document.getElementsByClassName("close_taklolos{{$reguler->id_daftar}}")[0];

								// When the user clicks the button, open the modal 
								btn_taklolos{{$reguler->id_daftar}}.onclick = function() {
									modal_taklolos{{$reguler->id_daftar}}.style.display = "block";
								}

								//button keluar
								btn_keluar_taklolos{{$reguler->id_daftar}}.onclick = function() {
									modal_taklolos{{$reguler->id_daftar}}.style.display = "none";
								}

								// When the user clicks on <span> (x), close the modal
								span_taklolos{{$reguler->id_daftar}}.onclick = function() {
									modal_taklolos{{$reguler->id_daftar}}.style.display = "none";
								}

								// When the user clicks anywhere outside of the modal, close it
								window.onclick = function(event) {
									if (event.target == modal_taklolos{{$reguler->id_daftar}}) {
										modal_taklolos{{$reguler->id_daftar}}.style.display = "none";
									}
								}
							</script>

							
							<?php $urut += 1; ?>
							@endforeach
						</table>
						{{$Reg->links()}}
					</div>
				@else
				<p>Belum ada penghuni reguler baru yang mengajukan pendaftaran.</p>
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

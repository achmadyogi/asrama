@extends('layouts.default')

@section('title','Validasi Pembayaran Reguler')
@section('menu_dash','active')

@section('main_menu')
	@parent

@endsection

@section('header_title','Sekretariat | Validasi Pembayaran Reguler')
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
				<h2><b>Validasi Pembayaran Reguler</b></h2><hr>
				<h4><b>Penelusuran Cepat</b></h4>
				Kategori pencarian<br>
				{{ csrf_field() }}
				<select name="kategori" id="kategori">
					<option value="nama">Nama</option>
					<option value="nim">NIM</option>
					<option value="registrasi">Nomor Registrasi</option>
					<option value="email">Email</option>
				</select><br><br>
				<input type="text" placeholder="Pencarian disini" id="cari" class="input" style="width: 400px; max-width: 100%"><br><br><hr>
				<div id="wait" style="display: none;"><img src="{{ asset('img/icon/load3.gif') }}" alt="loading" width="80px"> Sedang memuat...</div>
				<div id="hasil"></div>
				<script type="text/javascript">
					$(document).ready(function(){
						$(document).ajaxStart(function(){
					        $("#wait").css("display", "block");
					    });
					    $(document).ajaxComplete(function(){
					        $("#wait").css("display", "none");
					    });
						$("#cari").keyup(function(){
						  	var cari = $(this).val();
						  	var kategori = $('#kategori').val();
							console.log(kategori);
						  	$.post('{{ route("ajax_bayar") }}',{
						  		'cari': cari,
						  		'kategori': kategori, 
						  		'_token':$('input[name=_token]').val()
						  	}, function(data, status){
							console.log('cari');
								$('#hasil').html(data);
							});
						});
					});
				</script>
				@if(isset($bayar_reguler))
					<div id="show">
						@if($h<=8)
						<p><i>Menunjukkan {{$h}} dari {{$h}} total data</i></p>
						@else
						<p><i>Menunjukkan 10 dari {{$h}} total data</i></p>
						@endif
						<div class="table">
							<table>
								<tr>
									<th>No.</th>
									<th>ID Pendaftaran</th>
									<th>Nama Penghuni</th>
	                                <th>Tanggal Bayar</th>
									<th>Asrama</th>
									<th>Aksi</th>
								</tr>
								<?php $urut = 0; ?>
								@foreach($bayar_reguler as $reguler)
									@if($urut <= 9)
									<tr>
										<td>{{$urut+1}}.</td>
										<td>{{$reguler->id_daftar}}</td>
										<td>{{$reguler->name}}</td>
										<td>{{$tanggal_bayar[$urut]}}</td>
										<td>{{$reguler->asrama}}</td>
										<td><button class="button" id="btn{{$reguler->id_pembayaran}}" type="button">Rincian</button></td>
									</tr>
									<!-- MODAL UNTUK validasi pendaftaran -->
									<style type="text/css">
										/* The Close Button */
										.close{{$reguler->id_pembayaran}} {
											color: white;
											float: right;
											font-size: 28px;
											font-weight: bold;
										}

										.close{{$reguler->id_pembayaran}}:hover,
										.close{{$reguler->id_pembayaran}}:focus {
											color: #000;
											text-decoration: none;
											cursor: pointer;
										}
										.close_tolak{{$reguler->id_pembayaran}} {
											color: white;
											float: right;
											font-size: 28px;
											font-weight: bold;
										}

										.close_tolak{{$reguler->id_pembayaran}}:hover,
										.close_tolak{{$reguler->id_pembayaran}}:focus {
											color: #000;
											text-decoration: none;
											cursor: pointer;
										}
									</style>
									<!-- Modal Pertama -->
									<div id="myModal{{$reguler->id_pembayaran}}" class="modal">

									  <!-- Modal content -->
									  <div class="modal-content">
										<div class="modal-header">
										  <span class="close{{$reguler->id_pembayaran}}">&times;</span>
										  <h3><b>Verifikasi Pendaftaran</b></h3>
										</div>
										<div class="modal-body">
									  		<br>
									  	  	<p><span style="display: inline-block; width: 150px;">Nama</span><b>: {{$reguler->name}}</b><br>
									  	  	<span style="display: inline-block; width: 150px;">Tanggal Bayar</span>: {{$tanggal_bayar[$urut]}}<br>
		                                    <span style="display: inline-block; width: 150px;">Lokasi Asrama</span>: {{$reguler->asrama}}<br>
		                                    @if($reguler->jenis_pembayaran == 0)
		                                        <span style="display: inline-block; width: 150px;">Pembayaran</span>: Host-to-Host<br>
												<span style="display: inline-block; width: 150px;">Jumlah Pembayaran</span>: {{$jumlah_bayar[$urut]}}<br>
											@elseif($reguler->jenis_pembayaran == 1) 
		                                        <span style="display: inline-block; width: 150px;">Pembayaran</span>: Rek. Penampungan<br>
												<span style="display: inline-block; width: 150px;">Jumlah Pembayaran</span>: {{$jumlah_bayar[$urut]}}<br>
												<span style="display: inline-block; width: 150px;">Nama Pengirim</span>: {{$reguler->nama_pengirim}}<br>
												<span style="display: inline-block; width: 150px;">Bank Asal</span>: {{$reguler->bank_asal}}<br>
											@endif
											
		                                    </p><hr>
		                                    @if($reguler->jenis_pembayaran == 0 || $reguler->jenis_pembayaran == 1)
									  	  	    <h3><b>Form Verifikasi Pembayaran</b></h3>
		                                        <form action="{{route('submit_pembayaran_reguler')}}" method="POST">
													{{ csrf_field() }}
		                                            <input type="Hidden" name="id_pembayaran" value="{{$reguler->id_pembayaran}}">
		                                            <input type="checkbox" name="bukti_pembayaran" value="1">Bukti Pembayaran<br><br>
		                                            <label>Keterangan Tambahan</label><br>
		                                            <input id="keterangan" type="text" name="keterangan" class="input" value="{{old('keterangan')}}"><br><br>
		                                            <button class="button" type="submit">Verify</button>
		                                            <button class="button-close" type="button" id="btn_tolak{{$reguler->id_pembayaran}}">Tolak</button>
		                                        </form>
		                                    @endif
										</div>
									  </div>
									</div>
									<!-- Modal Kedua -->
									<div id="myModal_tolak{{$reguler->id_pembayaran}}" class="modal">

									  <!-- Modal content -->
									  <div class="modal-content">
										<div class="modal-header">
										  <span class="close_tolak{{$reguler->id_pembayaran}}">&times;</span>
										  <h3><b>Konfirmasi Penolakan Pembayaran</b></h3>
										</div>
										<div class="modal-body"><br>
											<form action="{{ route('tolak_bayar') }}" method="POST">
												{{ csrf_field() }}
										  		<label>Catatan Validator</label><br>
										  		<input class="input" name="catatan_validator" type="text" required>
										  		<input type="Hidden" name="id_daftar" value="{{$reguler->id_daftar}}">
			                                    <input type="Hidden" name="id_pembayaran" value="{{$reguler->id_pembayaran}}"><br>
			                                    <i>Catatan validator harus diisi sebagai keterangan kenapa pembayaran ditolak</i><hr>
			                                    <button class="button-close" type="submit">Tolak Sekarang</button>
		                                	</form>
										</div>
									  </div>
									</div>
									<script>
										// Get the modal
										var modal_tolak{{$reguler->id_pembayaran}} = document.getElementById('myModal_tolak{{$reguler->id_pembayaran}}');

										// Get the button that opens the modal
										var btn_tolak{{$reguler->id_pembayaran}} = document.getElementById("btn_tolak{{$reguler->id_pembayaran}}");

										// Get the <span> element that closes the modal
										var span_tolak{{$reguler->id_pembayaran}} = document.getElementsByClassName("close_tolak{{$reguler->id_pembayaran}}")[0];

										// When the user clicks the button, open the modal 
										btn_tolak{{$reguler->id_pembayaran}}.onclick = function() {
											modal_tolak{{$reguler->id_pembayaran}}.style.display = "block";
										}

										// When the user clicks on <span> (x), close the modal
										span_tolak{{$reguler->id_pembayaran}}.onclick = function() {
											modal_tolak{{$reguler->id_pembayaran}}.style.display = "none";
										}

										// When the user clicks anywhere outside of the modal, close it
										window.onclick = function(event) {
											if (event.target == modal_tolak{{$reguler->id_pembayaran}}) {
												modal_toolak{{$reguler->id_pembayaran}}.style.display = "none";
											}
										}
									</script>
									<script>
										// Get the modal
										var modal{{$reguler->id_pembayaran}} = document.getElementById('myModal{{$reguler->id_pembayaran}}');

										// Get the button that opens the modal
										var btn{{$reguler->id_pembayaran}} = document.getElementById("btn{{$reguler->id_pembayaran}}");

										// Get the <span> element that closes the modal
										var span{{$reguler->id_pembayaran}} = document.getElementsByClassName("close{{$reguler->id_pembayaran}}")[0];

										// When the user clicks the button, open the modal 
										btn{{$reguler->id_pembayaran}}.onclick = function() {
											modal{{$reguler->id_pembayaran}}.style.display = "block";
										}

										// When the user clicks on <span> (x), close the modal
										span{{$reguler->id_pembayaran}}.onclick = function() {
											modal{{$reguler->id_pembayaran}}.style.display = "none";
										}

										// When the user clicks anywhere outside of the modal, close it
										window.onclick = function(event) {
											if (event.target == modal{{$reguler->id_pembayaran}}) {
												modal{{$reguler->id_pembayaran}}.style.display = "none";
											}
										}
									</script>
									<?php $urut += 1; ?>
									@endif
								@endforeach
							</table>
						</div>
					</div>
					<div id="wait" style="display: none; margin-top: 0px; margin-bottom: 0px;">
						<i>fetching data...</i>
					</div>
					<div class="row" id="page">
						<div class="col-md-6" style="text-align: right;">
							<h4 style="color: #1aa3ff; cursor: pointer;" id="prev"><b><i>< previous</i></b></h4>
						</div>
						<div class="col-md-6" style="text-align: left;">
							<h4 style="color: #1aa3ff; cursor: pointer;" id="next"><b><i>next ></i></b></h4>
						</div>
					</div>
					<script type="text/javascript">
						$(document).ready(function(){
							var total_ = $('#total_').val();
							$(document).ajaxStart(function(){
						        $("#wait").css("display", "block");
						    });
						    $(document).ajaxComplete(function(){
						        $("#wait").css("display", "none");
						    });
							var count = 0;
							$('#next').click(function(){
								count = count + 10;
								if(count >= <?php echo $h; ?>){
									count = count - 10;
								}else{
									console.log(count);
								  	$.get('{{ route("nextPrev") }}',{
								  		'count': count,
								  		'_token':$('input[name=_token]').val()
								  	}, function(data, status){
									console.log('count');
										$('#show').html(data);
									});
								}
							});
							$('#prev').click(function(){
								count = count - 10;
								if(count < 0){
									count = count + 10;
								}else{
									console.log(count);
								  	$.get('{{ route("nextPrev") }}',{
								  		'count': count,
								  		'_token':$('input[name=_token]').val()
								  	}, function(data, status){
									console.log('count');
										$('#show').html(data);
									});
								}
							});
						});
					</script>
				@else
				<p>Belum ada penghuni reguler yang melakukan pembayaran.</p>
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

@extends('layouts.default')

@section('title','Periode Tinggal')
@section('menu_dash','active')

@section('main_menu')
	@parent

@endsection

@section('header_title','Sekretariat | Edit Periode')
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
				@elseif (session()->has('status2'))
					<div class="alert_success">
						{{session()->get('status2')}}
					</div> 
				@endif
				<h1><b>List Periode Terdaftar</b></h1>
				@if($user->is_sekretariat == '1')
					@if($t_periode == 1)
						<div class="table">
							<table>
								<tr>
									<th>No.</th>
									<th>Nama Periode</th>
									<th>Tanggal Buka Daftar</th>
									<th>Tanggal Tutup Daftar</th>
									<th>Tanggal Mulai Tinggal</th>
									<th>Tanggal Selesai Tinggal</th>
									<th>Lama Bulan</th>
									<th>Status</th>
									<th>Keterangan</th>
									<th>Edit Periode</th>
								</tr>
								<?php $urut = 0; ?>
								@foreach($nama_periodes as $nama_periode)
								<tr>
									<td>{{$urut+1}}.</td>
									<td>{{$nama_periode}}</td>
									<td>{{$t_buka_daftar[$urut]}}</td>
									<td>{{$t_tutup_daftar[$urut]}}</td>
									<td>{{$t_mulai_tinggal[$urut]}}</td>
									<td>{{$t_selesai_tinggal[$urut]}}</td>
									<td>{{$jumlah_bulan[$urut]}}</td>
									@if($status[$urut] == 'aktif')
										<td style="color: green"><b>{{$status[$urut]}}</b></td>
									@elseif($status[$urut] == 'ditutup')
										<td style="color: red"><b>{{$status[$urut]}}</b></td>
									@else
										<td style="color: #8D802B"><b>{{$status[$urut]}}</b></td>
									@endif
									<td>{{$keterangan[$urut]}}</td>
									<td><button class="button" id="btn{{$id_periode[$urut]}}" type="button">Edit</button>
								</tr>
								<!-- MODAL UNTUK EDIT PERIODE -->
								<style type="text/css">
									/* The Close Button */
								.close{{$id_periode[$urut]}} {
									color: white;
									float: right;
									font-size: 28px;
									font-weight: bold;
								}

								.close{{$id_periode[$urut]}}:hover,
								.close{{$id_periode[$urut]}}:focus {
									color: #000;
									text-decoration: none;
									cursor: pointer;
								}
								</style>
								<div id="myModal{{$id_periode[$urut]}}" class="modal">

								  <!-- Modal content -->
								  <div class="modal-content">
									<div class="modal-header">
									  <span class="close{{$id_periode[$urut]}}">&times;</span>
									  <h3><b>Edit Periode</b></h3>
									</div>
									<div class="modal-body">
								  <br>
								  	  <p><i>Nama Periode:</i> <b>{{$nama_periode}}</b><br>
								  	  Pengeditan dilakukan untuk membuka kembali pendaftaran setelah sesi pendaftaran sebelumnya sudah ditutup.</p><hr>
									  <form action="{{ route('edit_lama') }}" method="POST">
									  	{{ csrf_field() }}
									  	<label>Nama Periode</label><br>
										<input id="nama_periode_edit" class="input" type="text" name="nama_periode_edit" required><br><br>
									  	<label>Tanggal Pendaftaran Dibuka (ex: 04/25/2019 08:30 AM)</label><br>
										<input id="tanggal_pendaftaran_dibuka" class="input" type="datetime-local" name="tanggal_pendaftaran_dibuka" placeholder="Tanggal Pendaftaran Dibuka" required><br><br>
									  	<input type="Hidden" name="id_periode" value="{{$id_periode[$urut]}}">
										<label>Tanggal Pendaftaran Ditutup (ex: 04/25/2019 08:30 AM)</label><br>
										<input id="tanggal_pendaftaran_ditutup" class="input" type="datetime-local" name="tanggal_pendaftaran_ditutup" placeholder="Tanggal Pendaftaran Ditutup" required><br><br>
									  	<button class="button" type="submit">Edit</button><br><br>
									  </form>
									</div>
								  </div>

								</div>
								<script>
								// Get the modal
								var modal{{$id_periode[$urut]}} = document.getElementById('myModal{{$id_periode[$urut]}}');

								// Get the button that opens the modal
								var btn{{$id_periode[$urut]}} = document.getElementById("btn{{$id_periode[$urut]}}");

								// Get the <span> element that closes the modal
								var span{{$id_periode[$urut]}} = document.getElementsByClassName("close{{$id_periode[$urut]}}")[0];

								// When the user clicks the button, open the modal 
								btn{{$id_periode[$urut]}}.onclick = function() {
									modal{{$id_periode[$urut]}}.style.display = "block";
								}

								// When the user clicks on <span> (x), close the modal
								span{{$id_periode[$urut]}}.onclick = function() {
									modal{{$id_periode[$urut]}}.style.display = "none";
								}

								// When the user clicks anywhere outside of the modal, close it
								window.onclick = function(event) {
									if (event.target == modal{{$id_periode[$urut]}}) {
										modal{{$id_periode[$urut]}}.style.display = "none";
									}
								}
								</script>
								<?php $urut += 1; ?>
								@endforeach
							</table>
						</div>
					@else
						<p>Belum ada periode yang tercatat hingga saat ini.</p>
					@endif
					
				@endif
				<h1><b>Buat Periode Baru</b></h1>
				<p>Catatan: Setiap periode yang terdaftar di sini merupakan periode yang diperuntukkan untuk penghuni reguler. Untuk penghuni non reguler tidak diberikan periode pendaftaran.</p>
				<div style="border: 1px solid #C9C9C9; border-radius: 5px;">
					<div style="background-color: #E8E8E8; padding: 10px 15px 10px 15px">
						Form Pembuatan Periode Baru
					</div>
					<div style="padding: 10px 15px 10px 15px;"><br>
						<form action="{{ route('tambah_periode') }}" method="post">
							{{ csrf_field() }}
							<div class="form-group{{ $errors->has('nama_periode') ? ' has-error' : '' }}">
								<label>Nama Periode</label><br>
								<input class="input" id="nama_periode" type="text" name="nama_periode" placeholder="Nama Periode" value="{{ old('nama_periode') }}" required autofocus>
	                            @if ($errors->has('nama_periode'))
	                                <span class="help-block">
	                                    <strong>{{ $errors->first('nama_periode') }}</strong>
	                                </span>
	                            @endif
	                        </div>
	                        <div class="form-group{{ $errors->has('tanggal_buka_daftar') ? ' has-error' : '' }}">
	                        	<label>Tanggal Pendaftaran Dibuka (ex: 04/25/2019 08:30 AM)</label><br>
								<input class="input" id="tanggal_buka_daftar" type="datetime-local" name="tanggal_buka_daftar" placeholder="Tanggal Pendaftaran Dibuka" value="{{ old('tanggal_buka_daftar') }}" required autofocus>
	                            @if ($errors->has('tanggal_buka_daftar'))
	                                <span class="help-block">
	                                    <strong>{{ $errors->first('tanggal_buka_daftar') }}</strong>
	                                </span>
	                            @endif
	                        </div>
	                        <div class="form-group{{ $errors->has('tanggal_tutup_daftar') ? ' has-error' : '' }}">
	                        	<label>Tanggal Pendaftaran Ditutup (ex: 04/25/2019 08:30 AM)</label><br>
								<input class="input" id="tanggal_tutup_daftar" type="datetime-local" name="tanggal_tutup_daftar" placeholder="Tanggal Pendaftaran Ditutup" value="{{ old('tanggal_tutup_daftar') }}" required autofocus>
	                            @if ($errors->has('tanggal_tutup_daftar'))
	                                <span class="help-block">
	                                    <strong>{{ $errors->first('tanggal_tutup_daftar') }}</strong>
	                                </span>
	                            @endif
	                        </div>
	                        <div class="form-group{{ $errors->has('tanggal_mulai_tinggal') ? ' has-error' : '' }}">
	                        	<label>Tanggal Mulai Tinggal (ex: 04/25/2019)</label><br>
								<input class="input" id="tanggal_mulai_tinggal" type="date" name="tanggal_mulai_tinggal" placeholder="Tanggal Mulai Tinggal" value="{{ old('tanggal_mulai_tinggal') }}" required autofocus>
	                            @if ($errors->has('tanggal_mulai_tinggal'))
	                                <span class="help-block">
	                                    <strong>{{ $errors->first('tanggal_mulai_tinggal') }}</strong>
	                                </span>
	                            @endif
	                        </div>
	                        <div class="form-group{{ $errors->has('tanggal_selesai_tinggal') ? ' has-error' : '' }}">
	                        	<label>Tanggal Selesai Tinggal (ex: 04/25/2019)</label><br>
								<input class="input" id="tanggal_selesai_tinggal" type="date" name="tanggal_selesai_tinggal" placeholder="Tanggal Selesai Tinggal" value="{{ old('tanggal_selesai_tinggal') }}" required autofocus>
	                            @if ($errors->has('tanggal_selesai_tinggal'))
	                                <span class="help-block">
	                                    <strong>{{ $errors->first('tanggal_selesai_tinggal') }}</strong>
	                                </span>
	                            @endif
	                        </div>
	                        <div class="form-group{{ $errors->has('jumlah_bulan') ? ' has-error' : '' }}">
	                        	<label>Jumlah Bulan</label><br>
								<input class="input" id="jumlah_bulan" type="number" name="jumlah_bulan" placeholder="Jumlah bulan dalam satu periode" value="{{ old('jumlah_bulan') }}" required autofocus>
	                            @if ($errors->has('jumlah_bulan'))
	                                <span class="help-block">
	                                    <strong>{{ $errors->first('jumlah_bulan') }}</strong>
	                                </span>
	                            @endif
	                        </div>
	                        <label>Keterangan Tambahan</label><br>
							<input class="input" type="text" name="keterangan" placeholder="Keterangan Tambahan" required autofocus><br><br>
							<button class="button" type="submit">Submit</button>
						</form>
					</div>
				</div>
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

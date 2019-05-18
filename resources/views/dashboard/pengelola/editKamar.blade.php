@extends('layouts.default')

@section('title','Edit Kamar Penghuni')
@section('menu_dash','active')

@section('main_menu')
	@parent

@endsection

@section('header_title','Pengelola | Edit Kamar')
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
				<h2><b>Edit Kamar Penghuni</b></h2><hr>
				<form action="{{ route('pencarianKamar') }}" method="POST">
					{{ csrf_field() }}
					<label>Pilih Asrama</label><br>
					<select name="dorm" required>
						<option value="">~~Pilih Asrama~~</option>
					@foreach($dorm as $dorm)
						<option value="{{$dorm->id_asrama}}">{{$dorm->nama}}</option>
					@endforeach
					</select><br><br>
					<button type="submit" class="button">Cari</button><br>
				</form><hr>
				@if(isset($pencarian))
				<h3><b>{{$asrama}}</b></h3>
				<div class="table">
					<table>
						<tr>
							<th>No.</th>
							<th>ID Kamar</th>
							<th>Kamar</th>
							<th>Kapasitas</th>
							<th>Jumlah Penghuni</th>
							<th>Gedung</th>
							<th>Status</th>
							<th>Keterangan</th>
							<th>Edit</th>
						</tr>
						<?php $a = 0 ?>
						@foreach($kamar as $kamar)
						<tr>
							<td>{{$a+1}}</td>
							<td>{{$kamar->id_kamar}}</td>
							<td>{{$kamar->nama}}</td>
							<td>{{$kamar->kapasitas}}</td>
							@if($kamar->sekarang == NULL)
							<td>0</td>
							@else
							<td>{{$kamar->sekarang}}</td>
							@endif
							<td>{{$kamar->gedung}}</td>
							@if($kamar->status == 1)
								<td>Tersedia</td>
							@else
								<td>Ditutup</td>
							@endif
							@if($kamar->keterangan == NULL)
								<td>-</td>
							@else
								<td>{{$kamar->keterangan}}</td>
							@endif
							<td><button type="submit" class="button" id="btn{{$kamar->id_kamar}}">Edit</button></td>
						</tr>
						<!-- MODAL UNTUK EDIT PERIODE -->
							<style type="text/css">
								/* The Close Button */
							.close{{$kamar->id_kamar}} {
								color: white;
								float: right;
								font-size: 28px;
								font-weight: bold;
							}

							.close{{$kamar->id_kamar}}:hover,
							.close{{$kamar->id_kamar}}:focus {
								color: #000;
								text-decoration: none;
								cursor: pointer;
							}
							</style>
							<div id="myModal{{$kamar->id_kamar}}" class="modal">

							  <!-- Modal content -->
							  <div class="modal-content">
								<div class="modal-header">
								  <span class="close{{$kamar->id_kamar}}">&times;</span>
								  <h3><b>Edit Kamar</b></h3>
								</div>
								<div class="modal-body">
							  		<br>
							  		<form action="{{ route('submit_edit_kamar') }}" method="POST">
							  			{{ csrf_field() }}
							  		  	<input type="hidden" name="id_kamar" value="{{$kamar->id_kamar}}">
							  		  	<input type="hidden" name="dorm" value="{{$pencarian}}">
							  		  	<div class="form-group{{ $errors->has('nama') ? ' has-error' : '' }}">
	                        				<label>Nama Kamar</label><br>
											<input class="input" id="nama" type="text" name="nama" value="{{$kamar->nama}}" required autofocus>
				                            @if ($errors->has('nama'))
				                                <span class="help-block">
				                                    <strong>{{ $errors->first('nama') }}</strong>
				                                </span>
				                            @endif
				                        </div>
							  		  	<div class="form-group{{ $errors->has('kapasitas') ? ' has-error' : '' }}">
	                        				<label>Kapasitas</label><br>
											<input class="input" id="kapasitas" type="number" name="kapasitas" value="{{$kamar->kapasitas}}" required autofocus>
				                            @if ($errors->has('kapasitas'))
				                                <span class="help-block">
				                                    <strong>{{ $errors->first('kapasitas') }}</strong>
				                                </span>
				                            @endif
				                        </div>
				                        <label>Jenis Kelamin</label><br>
				                        	<input type="radio" name="gender" value="{{$kamar->gender}}" <?php if($kamar->gender == 'L'){ echo 'checked'; }?> > Laki-laki<br>
				                        	<input type="radio" name="gender" value="{{$kamar->gender}}" <?php if($kamar->gender == 'P'){ echo 'checked'; }?> > Perempuan<br><br>
				                        <label>Kriteria Penghuni</label><br>
				                        <select name="which_user">
				                        	<option value="1" <?php if($kamar->which_user == '1'){ echo 'selected'; }?>>Reguler</option>
				                        	<option value="2" <?php if($kamar->which_user == '2'){ echo 'selected'; }?>>International</option>
				                        	<option value="3" <?php if($kamar->which_user == '3'){ echo 'selected'; }?>>Umum</option>
				                        </select><br><br>
				                        <label>Khusus Disabilitas</label><br>
				                        <input type="radio" name="is_difable" value="1" <?php if($kamar->is_difable == '1'){ echo 'checked'; }?> > Ya<br>
				                        <input type="radio" name="is_difable" value="0" <?php if($kamar->is_difable == '0'){ echo 'checked'; }?> > Tidak<br><br>
				                        <label>Status</label><br>
				                        <input type="radio" name="status" value="1" <?php if($kamar->status == '1'){ echo 'checked'; }?>> Tersedia<br>
				                        <input type="radio" name="status" value="0" <?php if($kamar->status == '0'){ echo 'checked'; }?>> Ditutup<br><br>
				                        <label>Keterangan</label><br>
				                        <input type="text" class="input" name="keterangan" value="{{$kamar->keterangan}}"><br><br>
									  	<button class="button" type="submit">Verify</button><br><br>
									</form>
								</div>
							  </div>

							</div>
							<script>
							// Get the modal
							var modal{{$kamar->id_kamar}} = document.getElementById('myModal{{$kamar->id_kamar}}');

							// Get the button that opens the modal
							var btn{{$kamar->id_kamar}} = document.getElementById("btn{{$kamar->id_kamar}}");

							// Get the <span> element that closes the modal
							var span{{$kamar->id_kamar}} = document.getElementsByClassName("close{{$kamar->id_kamar}}")[0];

							// When the user clicks the button, open the modal 
							btn{{$kamar->id_kamar}}.onclick = function() {
								modal{{$kamar->id_kamar}}.style.display = "block";
							}

							// When the user clicks on <span> (x), close the modal
							span{{$kamar->id_kamar}}.onclick = function() {
								modal{{$kamar->id_kamar}}.style.display = "none";
							}

							// When the user clicks anywhere outside of the modal, close it
							window.onclick = function(event) {
								if (event.target == modal{{$kamar->id_kamar}}) {
									modal{{$kamar->id_kamar}}.style.display = "none";
								}
							}
							</script>
							<?php $a += 1; ?>
						@endforeach
					</table>
				</div>
				@else
				<p>Pilih asrama terlebih dahulu untuk memunculkan data.</p>
				@endif
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

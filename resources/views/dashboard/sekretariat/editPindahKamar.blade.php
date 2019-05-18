@extends('layouts.default')

@section('title','Edit Pindah Kamar')
@section('menu_dash','active')

@section('main_menu')
	@parent

@endsection

@section('header_title','Sekretariat | Edit Pindah Kamar')
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
				<h1><b>Edit Pindah Kamar</b></h1>
				<form action="{{route('pencarian_pindah_kamar')}}" method="POST">
					{{csrf_field()}}
					<label>Pilih Jalur</label><br>
					<select name="jalur" id="jalur" required>
						<option value="0">~~Pilih Jalur~~</option>
						<option value="1">Reguler</option>
						<option value="2">Non Reguler</option>
					</select><br><br>
					<div id="periode"style="display: none">
						<label>Pilih Nama Periode</label><br>
					<select name="periode" required>
					@foreach($periode as $periode)
						<option value="{{$periode->id_periode}}">{{$periode->nama_periode}}</option>
					@endforeach
					</select><br><br></div>
					<script type="text/javascript">
						$(document).ready(function(){
							$('#jalur').change(function(){
								var jalur = $(this).val();
								if(jalur == 1){
									$('#periode').show(500);
								}else{
									$('#periode').hide(500);
								}
							});
						});
					</script>
					<label>Pilih Asrama</label><br>
					<select name="asrama">
					@foreach($asrama as $asrama)
						<option value="{{$asrama->id_asrama}}">{{$asrama->nama}}</option>
					@endforeach
						<option value="semua">Semua</option>
					</select><br><br>
					<button type="submit" class="button">Cari</button>
				</form>
				<hr>
				@if(isset($jalur) && $jalur == 1)
					<div class="table">
						<table>
							<tr>
								<th>No.</th>
								<th>Nama</th>
								<th>NIM</th>
								<th>Kamar</th>
								<th>Asrama</th>
								<th>Edit</th>
							</tr>
							<?php $a = 0; ?>
							@foreach($data as $data)
							<tr>
								<td>{{$a+1}}</td>
								<td>{{$data->name}}</td>
								<td>{{$data->nim}}</td>
								<td>{{$data->kamar}}</td>
								<td>{{$data->asrama}}</td>
								<td><button type="submit" class="button" id="btn_reg{{$data->id_daftar}}">Edit</button></td>
							</tr>
							<!-- MODAL UNTUK EDIT PERIODE -->
								<style type="text/css">
									/* The Close Button */
								.close_reg{{$data->id_daftar}} {
									color: white;
									float: right;
									font-size: 28px;
									font-weight: bold;
								}

								.close_reg{{$data->id_daftar}}:hover,
								.close_reg{{$data->id_daftar}}:focus {
									color: #000;
									text-decoration: none;
									cursor: pointer;
								}
								</style>
								<div id="myModal_reg{{$data->id_daftar}}" class="modal">

								  <!-- Modal content -->
								  <div class="modal-content">
									<div class="modal-header">
									  <span class="close_reg{{$data->id_daftar}}">&times;</span>
									  <h3><b>Pindah Kamar</b></h3>
									</div><br>
									<div class="modal-body">
										<span style="display: inline-block; width: 150px;">Kamar saat ini</span>: {{$data->kamar}}<br>
										<hr>
										<form action="{{ route('input_ubah_kamar_reguler') }}" method="POST">
											{{csrf_field()}}
											<label>Pilih Asrama</label>
											<select name="asrama" id="asramaX">
												<option value="0">~~Pilih Asrama~~</option>
												@foreach($asrama2 as $asrama2)
													<option value="{{$asrama2->id_asrama}}">{{$asrama2->nama}}</option>
												@endforeach
											</select><br><br>
											<div id="gedungX"></div>
											<div id="kamarX"></div>
											<script type="text/javascript">
												$(document).ready(function(){
													$("#asramaX").change(function(){
													  	var asrama = $(this).val();
													  	$.post('{{ route("gedungX") }}',{
													  		'asrama': asrama, 
													  		'_token':$('input[name=_token]').val()
													  	}, function(data, status){
															console.log(asrama);
															$('#gedungX').html(data);
														});
													});
												});
											</script>
											<button type="submit" class="button">Submit</button>
										</form>
									</div>
								  </div>

								</div>
								<script>
								// Get the modal
								var modal_reg{{$data->id_daftar}} = document.getElementById('myModal_reg{{$data->id_daftar}}');

								// Get the button that opens the modal
								var btn_reg{{$data->id_daftar}} = document.getElementById("btn_reg{{$data->id_daftar}}");

								// Get the <span> element that closes the modal
								var span_reg{{$data->id_daftar}} = document.getElementsByClassName("close_reg{{$data->id_daftar}}")[0];

								// When the user clicks the button, open the modal 
								btn_reg{{$data->id_daftar}}.onclick = function() {
									modal_reg{{$data->id_daftar}}.style.display = "block";
								}

								// When the user clicks on <span> (x), close the modal
								span_reg{{$data->id_daftar}}.onclick = function() {
									modal_reg{{$data->id_daftar}}.style.display = "none";
								}

								// When the user clicks anywhere outside of the modal, close it
								window.onclick = function(event) {
									if (event.target == modal_reg{{$data->id_daftar}}) {
										modal_reg{{$data->id_daftar}}.style.display = "none";
									}
								}
								</script>
							<?php $a += 1?>
							@endforeach
						</table>
					</div>
				@elseif(isset($jalur) && $jalur == 2)
					<div class="table">
						<table>
							<tr>
								<th>No.</th>
								<th>Nama</th>
								<th>Kamar</th>
								<th>Asrama</th>
								<th>Edit</th>
							</tr>
							<?php $a = 0; ?>
							@foreach($data as $data)
							<tr>
								<td>{{$a+1}}</td>
								<td>{{$data->name}}</td>
								<td>{{$data->kamar}}</td>
								<td>{{$data->asrama}}</td>
								<td><button type="submit" class="button" id="btn_reg{{$data->id_daftar}}">Edit</button></td>
							</tr>
							<!-- MODAL UNTUK EDIT PERIODE -->
								<style type="text/css">
									/* The Close Button */
								.close_reg{{$data->id_daftar}} {
									color: white;
									float: right;
									font-size: 28px;
									font-weight: bold;
								}

								.close_reg{{$data->id_daftar}}:hover,
								.close_reg{{$data->id_daftar}}:focus {
									color: #000;
									text-decoration: none;
									cursor: pointer;
								}
								</style>
								<div id="myModal_reg{{$data->id_daftar}}" class="modal">

								  <!-- Modal content -->
								  <div class="modal-content">
									<div class="modal-header">
									  <span class="close_reg{{$data->id_daftar}}">&times;</span>
									  <h3><b>Pindah Kamar</b></h3>
									</div><br>
									<div class="modal-body">
										
									</div>
								  </div>

								</div>
								<script>
								// Get the modal
								var modal_reg{{$data->id_daftar}} = document.getElementById('myModal_reg{{$data->id_daftar}}');

								// Get the button that opens the modal
								var btn_reg{{$data->id_daftar}} = document.getElementById("btn_reg{{$data->id_daftar}}");

								// Get the <span> element that closes the modal
								var span_reg{{$data->id_daftar}} = document.getElementsByClassName("close_reg{{$data->id_daftar}}")[0];

								// When the user clicks the button, open the modal 
								btn_reg{{$data->id_daftar}}.onclick = function() {
									modal_reg{{$data->id_daftar}}.style.display = "block";
								}

								// When the user clicks on <span> (x), close the modal
								span_reg{{$data->id_daftar}}.onclick = function() {
									modal_reg{{$data->id_daftar}}.style.display = "none";
								}

								// When the user clicks anywhere outside of the modal, close it
								window.onclick = function(event) {
									if (event.target == modal_reg{{$data->id_daftar}}) {
										modal_reg{{$data->id_daftar}}.style.display = "none";
									}
								}
								</script>
							<?php $a += 1?>
							@endforeach
						</table>
					</div>
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

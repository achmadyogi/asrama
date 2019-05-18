@extends('layouts.default')

@section('title','Pendaftaran Mahasiswa Asing')
@section('menu_dash','active')

@section('main_menu')
	@parent

@endsection

@section('header_title','Keuangan | Periksa Pendaftaran Mahasiswa Asing')
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
				<h2><b>Periksa Pendaftaran Penghuni Asing</b></h2>
				<hr>
				<form action="{{ route('pencarian_pendaftaran_asing') }}" method="POST">
					{{ csrf_field() }}
					<b>Filter data</b>
					
					<label>Filter berdasarkan jalur pendaftaran</label><br>
					<select name="jalur" id="jalur" required>
						<option value="">~~Berdasarkan jalur daftar~~</option>
						<option value="reguler">Jalur Reguler</option>
						<option value="nonReguler">Jalur Non Reguler</option>
					</select><br><br>
					
					<button class="button" type="submit">Submit</button>
				</form>
				<hr>
				{{-- <h3><b>Pencarian cepat</b></h3><br>
				<label>Pilihan Filter Pencarian Cepat</label><br>
				<select name="filter_fast">
					<option value="">~~Pilih Filter~~</option>
					<option value="nim">NIM</option>
					<option value="registrasi">Nomor Registrasi</option>
					<option value="nama">Nama</option>
					<option value="email">Email</option>
				</select><br><br>
				<input type="text" class="input" name="cariBayar" id="cariBayar" style="width: 400px; max-width: 100%" placeholder="Tulis pencarian di sini"><br><hr> --}}
				@if(isset($c))
				<div id="show">
					
					<div class="table">
						<table>
							<tr>
								<th style="border-top-left-radius: 5px;">No.</th>
								<th>ID</th>
								<th>Nama</th>
								<th>Identitas</th>
								<th>Asal Negara</th>
								<th>Program</th>
								<th>Status</th>
							</tr>
							<?php $i = 0; ?>
							@if($jalur == "reguler")

								@foreach($asing_reguler as $reg)
									
									<tr>
										<td>{{$i+=1}}</td>
										<td>{{$reg->id}}</td>
										<td>{{$reg->name}}</td>
										<td>{{$reg->nomor_identitas}}</td>
										<td>{{$reg->negara}}</td>
										<td>{{$reg->status_beasiswa}}</td>
										@if($reg->verification == 0)
											<td> <b> Menunggu Verifikasi </b></td>
										@elseif($reg->verification == 1)
											<td><span style="color:green;"><b>Diterima</b></span><td>
										@elseif($reg->verification == 2)
											<td><span style="color:red;"><b>Pendaftaran Dibatalkan</b></span></td>
										@elseif($reg->verification == 3)	
											<td><span style="color:red;"><b>Black List</b></span></td>
										@elseif($reg->verification == 4)	
											<td><span><b>Waiting List</b></span></td>
										@elseif($reg->verification == 5)	
											<td><span style="color:green;"><b>Aktif</b></span><td>
										@elseif($reg->verification == 7)	
											<td><span style="color:red;"><b>Tidak Diterima</b></span><td>
										@endif
									</tr>
									
								@endforeach
							@else	
								@foreach($asing_non_reguler as $non_reg)
									<tr>
										<td>{{$i+=1}}</td>
										<td>{{$non_reg->id}}</td>
										<td>{{$non_reg->name}}</td>
										<td>{{$non_reg->nomor_identitas}}</td>
										<td>{{$non_reg->negara}}</td>
										<td>{{$non_reg->tujuan_tinggal}}</td>
										@if($non_reg->verification == 0)
											<td> <b> Menunggu Verifikasi </b></td>
										@elseif($non_reg->verification == 1)
											<td><span style="color:green;"><b>Diterima</b></span><td>
										@elseif($non_reg->verification == 2)
											<td><span style="color:red;"><b>Pendaftaran Dibatalkan</b></span></td>
										@elseif($non_reg->verification == 3)	
											<td><span style="color:red;"><b>Black List</b></span></td>
										@elseif($non_reg->verification == 4)	
											<td><span><b>Waiting List</b></span></td>
										@elseif($non_reg->verification == 5)	
											<td><span style="color:green;"><b>Aktif</b></span><td>
										@elseif($non_reg->verification == 7)	
											<td><span style="color:red;"><b>Tidak Diterima</b></span><td>
										@endif
									</tr>								
								@endforeach
							@endif
						</table>
					</div>
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

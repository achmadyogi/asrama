@extends('layouts.default')

@section('title','Periksa Penghuni Aktif')
@section('menu_dash','active')

@section('main_menu')
	@parent

@endsection

@section('header_title','Sekretariat | Periksa Penghuni Aktif')
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
				<h1><b>Periksa Penghuni Aktif</b></h1>
				<hr>
				<form action="{{ route('periksa_aktif') }}" method="post">
					{{ csrf_field() }}
					<label>Pilih Jalur</label><br>
					<select name="jalur" required id="jalur">
						<option value="">~~Pilih Jalur~~</option>
						<option value="1">Reguler</option>
						<option value="2">Non Reguler</option>
					</select><br><br>
					<label>Pilih Asrama</label><br>
					<select name="asrama" required id="asrama">
						<option value="">~~Pilih Asrama~~</option>
						@foreach($asrama as $asrama)
						<option value="{{$asrama->id_asrama}}">{{$asrama->nama}}</option>
						@endforeach
					</select><br><br>
					<button class="button" type="submit">Cari</button>
				</form>
				<hr>
				@if(isset($rincian) && $type == 'reguler')
				<p><i>Filter: Reguler | {{$asramaFilter->nama}}</i></p> <br>
				<div class="table">
					<table>
						<tr>
							<th>No.</th>
							<th>Nama</th>
							<th>Fakultas/Jurusan</th>
							<th>NIM</th>
							<th>Nomor Registrasi</th>
							<th>Jenis Kelamin</th>
							<th>Kamar</th>
							<th>Gedung</th>
							<th>Periode Tinggal</th>
						</tr>
						<?php $count = 1; ?>
						@foreach($rincian as $rinci)
						<tr>
							<td>{{$count}}</td>
							<td>{{$rinci->name}}</td>
							<td>{{$rinci->nama_prodi}}</td>
							<td>{{$rinci->nim}}</td>
							<td>{{$rinci->registrasi}}</td>
							<td>{{$rinci->jenis_kelamin}}</td>
							<td>{{$rinci->kamar}}</td>
							<td>{{$rinci->gedung}}</td>
							<td>{{$rinci->nama_periode}}</td>
							<?php $count += 1; ?>
						</tr>
						@endforeach
					</table>
				</div>
				@elseif(isset($rincian) && $type == 'non reguler')
				<p><i>Filter: Non Reguler | {{$asramaFilter->nama}}</i></p> <br>
				<div class="table">
					<table>
						<tr>
							<th>No.</th>
							<th>Nama</th>
							<th>Tujuan Tinggal</th>
							<th>Lama Tinggal</th>
							<th>Jenis Kelamin</th>
							<th>Kamar</th>
							<th>Gedung</th>
						</tr>
						<?php $count = 1; ?>
						@foreach($rincian as $rinci)
						<tr>
							<td>{{$count}}</td>
							<td>{{$rinci->name}}</td>
							<td>{{$rinci->tujuan_tinggal}}</td>
							<td>{{$rinci->lama_tinggal}} {{$rinci->tempo}}</td>
							<td>{{$rinci->jenis_kelamin}}</td>
							<td>{{$rinci->kamar}}</td>
							<td>{{$rinci->gedung}}</td>
							<?php $count += 1; ?>
						</tr>
						@endforeach
					</table>
				</div>
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

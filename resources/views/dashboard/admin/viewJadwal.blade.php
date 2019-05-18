@extends('layouts.default')

@section('title','Jadwal Kegiatan Asrama')
@section('menu_dash','active')

@section('main_menu')
	@parent

@endsection

@section('header_title','Admin | Jadwal Kegiatan Asrama')
@section('content')
<div class="container">
	<br><br>
	<div class="row">
		<div class="col-md-9">
			<!-- ALERT -->
				@if (session()->has('status1'))
					<div class="alert_fail">
						{{session()->get('status1')}}
					</div><br> 
				@endif
				@if (session()->has('status2'))
					<div class="alert_success">
						{{session()->get('status2')}}
					</div><br>
                @endif 
			<div style="margin-top: 0px; height: 4px; background-color: #0769B0; border-top-left-radius: 3px; border-top-right-radius: 3px;"></div>
			<div class="sider_body" style="background-color: white;">
				<h4><b>Form Tambah Jadwal Kegiatan</b></h4><hr>
				<form action="{{ route('addJadwal') }}" method="POST">
					{{ csrf_field() }}
					<input type="hidden" name="id" value="{{DormAuth::User()->id}}">
					<label>Judul</label><br>
					<input type="text" name="judul" class="input" style="width: 400px; max-width: 100%;" placeholder="Judul Kalender" required><br><br>
					<label>Deskripsi</label><br>
					<input type="text" name="deskripsi" class="input" style="width: 400px; max-width: 100%;" placeholder="informasi tambahan (singkat)" required><br><br>
					<label>Tanggal Kegiatan</label><br>
					<input class="input" name="tanggal" placeholder="Tanggal Lahir (YYYY-MM-DD)" type="date" style="width: 400px; max-width: 100%;" required><br><br>
					<button type="submit" name="submit" class="button">Submit</button><br><br>
				</form>
			</div><hr>
		</div>
		<div class="col-md-3">
			<!-- MENU DASHBOARD -->
			@include('dashboard.menuDashboard')
		</div>
	</div>
	<br><br><br>
</div>
@endsection

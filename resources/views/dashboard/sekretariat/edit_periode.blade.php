@extends('layouts.default')

@section('title','Periode Tinggal')

@section('main_menu')
	@parent

@endsection

@section('header_title','Dashboard')
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
				@elseif (session()->has('status2'))
					<div class="alert_success">
						{{session()->get('status2')}}
					</div> 
				@endif
				<h1><b>List Periode Terdaftar</b></h1>
				@if($user->is_sekretariat == '1')
					@if($t_periode == 1)
						<p>Table muncul disini</p>
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
								<input class="input" id="nama_periode" type="text" name="nama_periode" placeholder="Nama Periode" value="{{ old('nama_periode') }}" required autofocus>
	                            @if ($errors->has('nama_periode'))
	                                <span class="help-block">
	                                    <strong>{{ $errors->first('nama_periode') }}</strong>
	                                </span>
	                            @endif
	                        </div>
	                        <div class="form-group{{ $errors->has('tanggal_buka_daftar') ? ' has-error' : '' }}">
								<input class="input" id="tanggal_buka_daftar" type="text" name="tanggal_buka_daftar" placeholder="Tanggal Pendaftaran Dibuka" value="{{ old('tanggal_buka_daftar') }}" required autofocus>
	                            @if ($errors->has('tanggal_buka_daftar'))
	                                <span class="help-block">
	                                    <strong>{{ $errors->first('tanggal_buka_daftar') }}</strong>
	                                </span>
	                            @endif
	                        </div>
	                        <div class="form-group{{ $errors->has('tanggal_tutup_daftar') ? ' has-error' : '' }}">
								<input class="input" id="tanggal_tutup_daftar" type="text" name="tanggal_tutup_daftar" placeholder="Tanggal Pendaftaran Ditutup" value="{{ old('tanggal_tutup_daftar') }}" required autofocus>
	                            @if ($errors->has('tanggal_tutup_daftar'))
	                                <span class="help-block">
	                                    <strong>{{ $errors->first('tanggal_tutup_daftar') }}</strong>
	                                </span>
	                            @endif
	                        </div>
	                        <div class="form-group{{ $errors->has('tanggal_mulai_tinggal') ? ' has-error' : '' }}">
								<input class="input" id="tanggal_mulai_tinggal" type="text" name="tanggal_mulai_tinggal" placeholder="Tanggal Mulai Tinggal" value="{{ old('tanggal_mulai_tinggal') }}" required autofocus>
	                            @if ($errors->has('tanggal_mulai_tinggal'))
	                                <span class="help-block">
	                                    <strong>{{ $errors->first('tanggal_mulai_tinggal') }}</strong>
	                                </span>
	                            @endif
	                        </div>
	                        <div class="form-group{{ $errors->has('tanggal_selesai_tinggal') ? ' has-error' : '' }}">
								<input class="input" id="tanggal_selesai_tinggal" type="text" name="tanggal_selesai_tinggal" placeholder="Tanggal Selesai Tinggal" value="{{ old('tanggal_selesai_tinggal') }}" required autofocus>
	                            @if ($errors->has('tanggal_selesai_tinggal'))
	                                <span class="help-block">
	                                    <strong>{{ $errors->first('tanggal_selesai_tinggal') }}</strong>
	                                </span>
	                            @endif
	                        </div>
	                        <div class="form-group{{ $errors->has('ammount of month') ? ' has-error' : '' }}">
								<input class="input" id="ammount of month" type="text" name="jumlah_bulan" placeholder="Jumlah bulan dalam satu periode" value="{{ old('jumlah_bulan') }}" required autofocus>
	                            @if ($errors->has('ammount of month'))
	                                <span class="help-block">
	                                    <strong>{{ $errors->first('ammount of month') }}</strong>
	                                </span>
	                            @endif
	                        </div>
							<input class="input" type="text" name="keterangan" placeholder="Keterangan Tambahan" required autofocus><br><br>
							<button class="button" type="submit">Submit</button>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
	<br><br><br>
</div>
@endsection

@extends('layouts.default')

@section('title','Pendaftaran Mahasiswa Asing')

@section('main_menu')
	@parent

@endsection

@section('header_title','IRO | Pendaftaran Mahasiswa Asing')
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
				<h1><b>Pendaftaran Mahasiswa Asing</b></h1>
				<p>Anda akan mendaftarkan mahasiswa asing untuk menempati asrama ITB</p>
				<div style="border: 1px solid #C9C9C9; border-radius: 5px;">
					<div style="background-color: #E8E8E8; padding: 10px 15px 10px 15px">
						Form Pendaftaran Mahasiswa Asing
					</div>
					<div style="padding: 10px 15px 10px 15px;"><br>
						<form action="{{ route('save_pendaftaran_mahasiswa_asing') }}" method="post">
							{{ csrf_field() }}
							<label>Jenis Pendaftaran</label><br>
							<input type="radio" name="pendaftaran" value="reguler" <?php if(Input::old('pendaftaran')== "reguler") { echo 'checked="checked"'; } ?> required> Reguler
							<span style="display: inline-block; width: 50px;"></span>
							<input type="radio" name="pendaftaran" value="non_reguler" <?php if(Input::old('pendaftaran')== "non_reguler") { echo 'checked="checked"'; } ?> required> Non Reguler <br><br>
							
							<label>Nama Mahasiswa</label><br>
							<div class="form-group{{ $errors->has('nama') ? ' has-error' : '' }}">
								<input id="nama" class="input" name="nama" type="text" value="{{old('nama')}}" required><br>
								@if ($errors->has('nama'))
	                                <span class="help-block">
	                                    <strong>{{ $errors->first('nama') }}</strong>
	                                </span>
	                            @endif
							</div>
							<label>No.Passport</label><br>
							<div class="form-group{{ $errors->has('pasport') ? ' has-error' : '' }}">
								<input id="pasport" class="input" name="pasport" type="text" value="{{old('pasport')}}" required><br>
								@if ($errors->has('pasport'))
	                                <span class="help-block">
	                                    <strong>{{ $errors->first('pasport') }}</strong>
	                                </span>
	                            @endif
							</div>
							<label>Jenis Kelamin</label><br>
							<input type="radio" name="kelamin" value="L" <?php if(Input::old('kelamin')== "L") { echo 'checked="checked"'; } ?> required> Laki-laki
							<span style="display: inline-block; width: 50px;"></span>
							<input type="radio" name="kelamin" value="P" <?php if(Input::old('kelamin')== "P") { echo 'checked="checked"'; } ?> required> Perempuan<br><br>
							
							<div class="form-group{{ $errors->has('negara') ? ' has-error' : '' }}">
								<label>Asal Negara</label><br>
								<input id="negara" class="input" name="negara" type="text" value="{{old('negara')}}" required><br>
								@if ($errors->has('negara'))
	                                <span class="help-block">
	                                    <strong>{{ $errors->first('negara') }}</strong>
	                                </span>
	                            @endif
							</div>
	                        <label>Pilihan Kamar</label><br>
	                        <input type="radio" name="preference" value="1" required> Single<br>
	                        <input type="radio" name="preference" value="2" required> Sharing<br><br>
	                        <div class="form-group{{ $errors->has('tanggal_masuk') ? ' has-error' : '' }}">
	                        	<label>Tanggal Masuk</label><br>
								<input class="input" id="tanggal_masuk" type="date" name="tanggal_masuk" placeholder="Tanggal Masuk Asrama" value="{{ old('tanggal_masuk') }}" required autofocus>
	                            @if ($errors->has('tanggal_masuk'))
	                                <span class="help-block">
	                                    <strong>{{ $errors->first('tanggal_masuk') }}</strong>
	                                </span>
	                            @endif
							</div>
							<label>Pilih paket periode tinggal</label><br>
	                        <input type="radio" name="tempo" value="harian" required> Harian<br>
	                        <input type="radio" name="tempo" value="bulanan" required> Bulanan<br><br>
	                        <div class="form-group{{ $errors->has('jumlah') ? ' has-error' : '' }}">
	                        	<label>Jumlah hari/bulan lama tinggal</label><br>
								<input class="input" id="jumlah" type="number" name="jumlah" placeholder="Masukkan angka" value="{{ old('jumlah') }}" required autofocus>
	                            @if ($errors->has('jumlah'))
	                                <span class="help-block">
	                                    <strong>{{ $errors->first('jumlah') }}</strong>
	                                </span>
	                            @endif
							</div>
							<div class="form-group{{ $errors->has('tujuan_tinggal') ? ' has-error' : '' }}">
								<label>Program Mahasiswa Asing</label><br>
								<input class="input" id="tujuan_tinggal" type="text" name="tujuan_tinggal" placeholder="Alasan tinggal di asrama" value="{{ old('tujuan_tinggal') }}" required autofocus>
	                            @if ($errors->has('tujuan_tinggal'))
	                                <span class="help-block">
	                                    <strong>{{ $errors->first('tujuan_tinggal') }}</strong>
	                                </span>
	                            @endif
	                        </div>
	                        
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

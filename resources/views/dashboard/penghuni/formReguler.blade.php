@extends('layouts.default')

@section('title','Pendaftaran')

@section('main_menu')
	@parent

@endsection

@section('header_title','Penghuni | Pendaftaran Reguler')
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
				<h1><b>Pendaftaran Reguler</b></h1>
				<p>Anda akan mendaftarkan diri sebagai penghuni asrama. Pastikan Anda sudah membaca segala ketentuan dan jumlah pembayaran yang telah ditetapkan.</p>
				<div style="border: 1px solid #C9C9C9; border-radius: 5px;">
					<div style="background-color: #E8E8E8; padding: 10px 15px 10px 15px">
						Form Pendaftaran Penghuni Reguler
					</div>
					<div style="padding: 10px 15px 10px 15px;"><br>
						<form class="form-horizontal" role="form" method="POST" action="{{ route('form_reguler') }}">
                            {{ csrf_field() }}
                            <div class="form-group">
                                <label for="asrama" class="col-md-3 control-label">Asrama</label>
                                <div class="col-md-9">
                                    <select id="asrama" class="form-control" name="asrama" required>
                                        <option value="">Pilih asrama tujuan</option>
                                        <option>Asrama Ganesha</option>
                                        <option>Asrama Jatinangor</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                    <label for="asrama" class="col-md-3 control-label">Preferences</label>
                                    <div class="col-md-9">
                                        <select id="asrama" class="form-control" name="preference" required>
                                            <option value="">Pilih Preferences</option>
                                                <option>Sendiri</option>
                                                <option>Berdua</option>
                                                <option>Bertiga</option>
                                        </select>
                                    </div>
                                </div>
                             
                            <div class="form-group">
                                    <label for="asrama" class="col-md-3 control-label">Beasiswa</label>
                                    <div class="col-md-9">
                                        <select id="beasiswa" class="form-control" name="beasiswa" required>
                                            <option value="">Pilih Beasiswa</option>
                                                <option>Bidikmisi</option>
                                                <option>Afirmasi</option>
                                                <option>Non-Beasiswa</option>
                                                <option>Lainnya</option>
                                        </select>
                                    </div>
                                </div>
                             
                            <div class="form-group">
                                    <label for="asrama" class="col-md-3 control-label">Status Mahasiswa</label>
                                    <div class="col-md-9">
                                        <select id="mahasiswa" class="form-control" name="mahasiswa" required>
                                            <option value="">Status Mahasiswa</option>
                                                <option>Ganesha</option>
                                                <option>Jatinangor</option>
                                                <option>Cirebon</option>
                                        </select>
                                    </div>
                                </div>
                               
                            <div class="form-group">
                                    <label for="asrama" class="col-md-3 control-label">Kebutuhan Khusus</label>
                                    <div class="col-md-9">
                                        <select id="difable" class="form-control" name="difable" required>
                                            <option value="">Pilih Kebutuhan Khusus</option>
                                                <option>Sehat</option>
                                                <option>Berkebutuhan Khusus</option>
                                        </select>
                                    </div>
                                </div>
                           
                           
                            <div class="form-group" id="difable-form">
                                <div class="col-md-6 col-md-offset-4 well well-sm">
    
                                    <div class="row">
                                        <label for="difable-form" class="col-md-3 control-label">Kebutuhan khusus *</label>
                                        <div class="col-md-8">
                                            <input id="ket_difable" type="text" class="form-control" name="ket_difable" value="">
                                        </div>
                                    </div>
    
                                </div>
                            </div>
    
                            <div class="form-group">
                                    <label for="asrama" class="col-md-3 control-label">Status</label>
                                    <div class="col-md-9">
                                        <select id="asrama" class="form-control" name="international" required>
                                            <option value="">Pilih Status</option>
                                                <option>Mahasiswa Internasional</option>
                                                <option>Non-Internasional</option>
                                        </select>
                                    </div>
                                </div>
                            
    
                            <div class="form-group">
                                <label for="periode" class="col-md-3 control-label">Periode</label>
                                <div class="col-md-9">
                                   
                                    <select id="periode" class="form-control" name="periode" required>
                                        @foreach ($list_periode as $nama_periode)
                                        <option value="{{$nama_periode->id_periode}}">
                                            {{$nama_periode->nama_periode}}
                                        </option>
                                        @endforeach
                                    </select>
                                    @foreach ($list_periode as $nama_periode)
                                        <input id="tanggal_mulai" type="hidden"  name="tanggal_mulai" value="{{$nama_periode->tanggal_mulai_tinggal}}">
                                    @endforeach
                                </div>
                            </div>
    
                            <div class="form-group">
                                <div class="col-md-7 col-md-offset-3">
                                    <a class="btn btn-default" href="{{ url('/dashboard') }}"><i class="glyphicon glyphicon-chevron-left"></i> Back</a>
                                    <button type="submit" class="btn btn-primary">
                                        Submit
                                    </button>
                                </div>
                            </div>
                        </form>
					</div>
				</div>
			</div>
		</div>
	</div>			
	<br><br><br>
</div>
@endsection

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
						<form action="{{ route('form_reguler') }}" method="post">
							{{ csrf_field() }}
	                        <label>Pilih Asrama</label><br>
	                        <select id="asrama" class="form-control" name="asrama" required>
                                <option value="">Pilih asrama tujuan</option>
                                <option>Asrama Sangkuriang</option>
                                <option>Asrama Kidang Pananjung</option>
                                <option>Asrama Kanayakan</option>
                                <option>Asrama Jatinangor</option>
                                <option>Asrama Internasional</option>
                            </select><br>
	                        <label>Pilih Opsi Kamar</label><br>
	                        <select id="preference" class="form-control" name="preference" required>
                                <option value="">Pilih Preferences</option>
                                <option>Sendiri</option>
                                <option>Berdua</option>
                                <option>Bertiga</option>
                            </select><br>
	                        <label>Pilih Beasiswa</label><br>
	                        <select id="beasiswa" class="form-control" name="beasiswa" required>
                                <option value="">Pilih Beasiswa</option>
                                <option>Bidikmisi</option>
                                <option>Afirmasi</option>
                                <option>Non-Beasiswa</option>
                                <option>Lainnya</option>
                            </select><br>
	                        <label>Pilih Kampus</label><br>
	                        <select id="mahasiswa" class="form-control" name="mahasiswa" required>
                                <option value="">Status Mahasiswa</option>
                                <option>Kampus Ganesha</option>
                                <option>Kampus Jatinangor</option>
                                <option>Kampus Cirebon</option>
                            </select><br>
                            <label>Pilih Periode Tinggal</label><br>
                            <select id="periode" class="form-control" name="periode" required>
                                @foreach ($list_periode as $nama_periode)
                                <option value="{{$nama_periode->id_periode}}">
                                    {{$nama_periode->nama_periode}}
                                </option>
                                @endforeach
                            </select><br>
                            @foreach ($list_periode as $nama_periode)
                                <input id="tanggal_mulai" type="hidden"  name="tanggal_mulai" value="{{$nama_periode->tanggal_mulai_tinggal}}">
                            @endforeach
                            <label>Apakah Anda Memiliki Riwayat Penyakit Berat atau yang Sedang Dialami ?</label><br>
	                        <input type="radio" id="penyakit1" name="penyakit" value="1" required> Ya<br>
                            <input type="radio" id="penyakit2" name="penyakit" value="0" required> Tidak<br><br>
                            <div id="ket_penyakit">
                                <label>Keterangan Penyakit</label>
                                <input class="input" type="text" class="form-control" name="ket_penyakit" autofocus><br><br>
                            </div>
                            <label>Apakah Anda Termasuk Orang yang Memiliki Keterbatasan Fisik ?</label><br>
	                        <input type="radio" id="difable1" name="difable" value="1" required> Ya<br>
                            <input type="radio" id="difable2" name="difable" value="0" required> Tidak<br><br>
                            <div id="ket_difable">
                                <label>Keterangan</label>
                                <input class="input" type="text" name="ket_difable" autofocus><br><br>
                            </div>
                            <label>Keterangan</label>
                            <label>Apakah Anda Termasuk Mahasiswa Internasional ?</label><br>
	                        <input type="radio" name="inter" value="1" required> Ya<br>
	                        <input type="radio" name="inter" value="0" required> Tidak<br><br>
							<button class="button" type="submit">Submit</button>
						</form>
					</div>
                </div>
			</div>
		</div>
	</div>			
	<br><br><br>
</div>
<script>
    $(document).ready(function () {
        $("#ket_difable").hide();
        $("#difable1").click(function () {
            $("#ket_difable").show(500);
        });
        $("#difable2").click(function () {
            $("#ket_difable").hide(500);
        });
    });

    $(document).ready(function () {
        $("#ket_penyakit").hide();
        $("#penyakit1").click(function () {
            $("#ket_penyakit").show(500);
        });
        $("#penyakit2").click(function () {
            $("#ket_penyakit").hide(500);
        });
    });
</script>
@endsection

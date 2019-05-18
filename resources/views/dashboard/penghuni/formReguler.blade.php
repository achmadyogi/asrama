@extends('layouts.default')

@section('title','Pendaftaran')
@section('menu_dash','active')

@section('main_menu')
	@parent

@endsection

@section('header_title','Penghuni | Pendaftaran Reguler')
@section('content')
<div class="container">
	<br><br>
	<div class="row">
		<div class="col-md-9">
			<!-- KONTEN UTAMA-->
			<div id="content">
                <style type="text/css">
                    .alert_fail {
                        color: black;
                        padding: 5px;
                        background-color: #F5CBCC;
                        border-radius: 5px;
                        border: 1px solid #FF3D40;
                        width: 100%;
                    }
                    .alert_success {
                        color: black;
                        padding: 5px;
                        background-color: #C1E2F7;
                        border-radius: 5px;
                        border: 1px solid #083688;
                        width: 100%;
                    }
                </style>
				<!-- ALERT -->
				@if (session()->has('status1'))
					<div class="alert_fail">
						{{session()->get('status1')}}
					</div> <br>
				@elseif (session()->has('status2'))
					<div class="alert_success">
						{{session()->get('status2')}}
					</div> <br>
                @endif
                <h1><b>Pendaftaran Reguler</b></h1>
				<p>Anda akan mendaftarkan diri sebagai penghuni asrama. Pastikan Anda sudah membaca segala ketentuan dan jumlah pembayaran yang telah ditetapkan.</p>
                <div style="margin-top: 0px; height: 4px; background-color: #0769B0; border-top-left-radius: 3px; border-top-right-radius: 3px;"></div>
				<div class="sider_body" style="background-color: white; border-radius: 0px; color: black">
                    <div style="padding: 0px 15px 10px 15px;"><br>
					    <h4 style="margin-top: 0px;"><b>Form Pendaftaran Penghuni Reguler</b></h4><hr>
						<form action="{{ route('form_reguler') }}" method="post">
							{{ csrf_field() }}
	                        <label>Pilih Asrama</label><br>
	                        <select id="asrama" class="form-control" name="asrama" required>
                                <option value="">~~Pilih asrama tujuan~~</option>
                                <option>Asrama Sangkuriang</option>
                                @if(ITBdorm::DataUser(DormAuth::User()->id)->jenis_kelamin == 'L')
                                    <option>Asrama Kidang Pananjung</option>
                                @else
                                    <option>Asrama Kanayakan</option>
                                @endif
                                <option>Asrama Jatinangor</option>
                                <option>Asrama Internasional</option>
                            </select><br>
	                        <label>Pilih Opsi Kamar</label><br>
	                        <select id="preference" class="form-control" name="preference" required>
                                <option value="">~~Pilih Preferences~~</option>
                                <option value = "1">Sendiri</option>
                                <option value = "2">Berdua</option>
                                <option value = "3">Bertiga</option>
                            </select><br>
	                        <label>Pilih Beasiswa</label><br>
	                        <select id="beasiswa" class="form-control" name="beasiswa" required>
                                <option value="">~~Pilih Beasiswa~~</option>
                                <option>Bidikmisi</option>
                                <option>Afirmasi</option>
                                <option>Non-Beasiswa</option>
                                <option>Lainnya</option>
                            </select><br>
                            <div id="r_beasiswa" style="display: none;">
                            <input type="text" class="input" name="r_beasiswa" value="{{old('r_beasiswa')}}"  placeholder="Tuliskan beasiswa yang sedang Anda terima"><br><br></div>
                            <script>
                                $(document).ready(function(){
                                    $('#beasiswa').change(function(){
                                        var r_beasiswa = $('#beasiswa').val();
                                        console.log(r_beasiswa);
                                        if(r_beasiswa == 'Lainnya'){
                                            $('#r_beasiswa').show(500);
                                        }else{
                                            $('#r_beasiswa').hide(500);
                                        }
                                    });
                                })
                            </script>
	                        <label>Pilih Kampus</label><br>
	                        <select id="mahasiswa" class="form-control" name="mahasiswa" required>
                                <option value="">~~Pilih Kampus~~</option>
                                <option>Kampus Ganesha</option>
                                <option>Kampus Jatinangor</option>
                                <option>Kampus Cirebon</option>
                            </select><br>
                            <label>Pilih Periode Tinggal</label><br>
                            <select id="periode" class="form-control" name="periode" required>
                                @foreach ($periode as $p)
                                    @if(ITBdorm::CompareDate($now, $p->tanggal_tutup_daftar) == 1)
                                    <option value="{{$p->id_periode}}">
                                        {{$p->nama_periode}}
                                    </option>
                                    @endif
                                @endforeach
                            </select><br>
                            <label>Apakah Anda Memiliki Riwayat Penyakit Berat atau yang Sedang Dialami ?</label><br>
	                        <input type="radio" id="penyakit1" name="penyakit" value="1" required> Ya<br>
                            <input type="radio" id="penyakit2" name="penyakit" value="0" required> Tidak<br><br>
                            <div id="ket_penyakit">
                                <label>Keterangan Penyakit</label>
                                <input class="input" type="text" class="form-control" name="ket_penyakit" autofocus><br><br>
                            </div>
                            <label>Apakah Anda Termasuk Orang yang Memiliki Kebutuhan Khusus ?</label><br>
	                        <input type="radio" id="difable1" name="difable" value="1" required> Ya<br>
                            <input type="radio" id="difable2" name="difable" value="0" required> Tidak<br><br>
                            <div id="ket_difable">
                                <label>Keterangan Kebutuhan Khusus</label>
                                <input class="input" type="text" name="ket_difable" autofocus><br><br>
                            </div>
                            <label>Apakah Anda Termasuk Mahasiswa Internasional ?</label><br>
	                        <input type="radio" name="inter" value="1" required> Ya<br>
	                        <input type="radio" name="inter" value="0" required> Tidak<br><br>
                            <label>Tanggal Rencana Masuk Asrama</label><br>
                            <input type="date" name="tanggal" class="form-control" required><br>
                            <label><input type="checkbox" required/> Dengan ini saya menerima kondisi kamar tersebut dan akan memanfaatkannya dengan sebaik-baiknya sesuai aturan yang berlaku di asrama ITB. </label><br> 
                            <a target="_blank" href="https://drive.google.com/open?id=1GCPMdHV8yj-Z9PVIxSKVTVGqGHooV7-C" target="_blank">Daftar fasilitas kamar bisa diakses disini</a><br><br>
                             <label><input type="checkbox" required/>  Dengan ini saya menerima dan mentaati semua peraturan asrama</label><br>
                            <a target="_blank" href="https://drive.google.com/open?id=0B6Zo8o-IGldNNkNUVTNVOThpRkFydlNtcXhFLXYwV2tMSmQw">Peraturan asrama bisa diakses disini</a><br><br>
							<button class="button" type="submit">Submit</button>
						</form>
					</div>
                </div>
			</div>
		</div>
        <div class="col-md-3">
            <!-- MENU DASHBOARD -->
            @include('dashboard.menuDashboard')
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

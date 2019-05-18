<?php

use Illuminate\Support\Facades\DB;

	function getCurrency($count){
		if($count >= 0){
      $a = 3;
        $i = 0;
        $length = strlen($count);
        $money = ',00';
        while($length - $a + 3 >= 0){
          if($length - $a + 3 >= 3){
            $money = substr($count, $a*(-1), 3).$money;
          }else{
            $final = 'Rp '.substr($count, $a*(-1), $length%3).$money;
          }
          if($length - $a != 0){
            $money = '.'.$money;  
          }
          $i += 1;
          $a = $a + 3;
        }
    }else{
      $count = $count*(-1);
      $a = 3;
        $i = 0;
        $length = strlen($count);
        $money = ',00';
        while($length - $a + 3 >= 0){
          if($length - $a + 3 >= 3){
            $money = substr($count, $a*(-1), 3).$money;
          }else{
            $final = 'Rp -'.substr($count, $a*(-1), $length%3).$money;
          }
          if($length - $a != 0){
            $money = '.'.$money;  
          }
          $i += 1;
          $a = $a + 3;
        }
    }
  
    return $final;
	}

$kategori = $_POST['kategori'];
$cari = $_POST['cari'];

if($cari != NULL && strlen($cari) > 3){
	if($kategori == "nama"){
		$field = "name";
	}elseif($kategori == "nim"){
		$field = "nim";
	}elseif($kategori == "registrasi"){
		$field = "registrasi";
	}else{
		$field = "email";
	}
	$list = DB::select("SELECT id_daftar, id, periodes.id_periode, periodes.nama_periode, email, name, foto_profil, status_beasiswa, nomor_transaksi, jumlah_bayar, tanggal_bayar, id_pembayaran, jenis_pembayaran, file, bayar.id_tagihan, jumlah_tagihan, is_accepted, registrasi, nim, jenis_kelamin, wil.kamar, wil.gedung, wil.asrama FROM daftar_asrama_reguler 
                LEFT JOIN users ON users.id = daftar_asrama_reguler.id_user 
                LEFT JOIN periodes ON periodes.id_periode = daftar_asrama_reguler.id_periode 
                LEFT JOIN 
                (
                    select pembayaran.id_pembayaran, nomor_transaksi, jumlah_bayar, tanggal_bayar, jenis_pembayaran, file, tagihan.id_tagihan, tagihan.daftar_asrama_id, tagihan.daftar_asrama_type, jumlah_tagihan, is_accepted from tagihan 
                    LEFT JOIN pembayaran ON tagihan.id_tagihan = pembayaran.id_tagihan
                ) as bayar ON bayar.daftar_asrama_id = daftar_asrama_reguler.id_daftar AND bayar.daftar_asrama_type = 'Daftar_asrama_reguler' 
                LEFT JOIN user_nim ON user_nim.id_user = daftar_asrama_reguler.id_user 
                LEFT JOIN user_penghuni ON user_penghuni.id_user = daftar_asrama_reguler.id_user 
                LEFT JOIN 
                (
                    select kamar_penghuni.daftar_asrama_id, kamar_penghuni.daftar_asrama_type, tempat.id_kamar, tempat.id_gedung, tempat.id_asrama, tempat.kamar, tempat.gedung, tempat.asrama from kamar_penghuni 
                    LEFT JOIN 
                    (
                        select kamar.id_kamar, kamar.nama as kamar, fasil.id_asrama, fasil.id_gedung, asrama, gedung from kamar 
                        LEFT JOIN 
                        (
                            select asrama.id_asrama, asrama.nama as asrama, gedung.id_gedung, gedung.nama as gedung from gedung 
                            LEFT JOIN asrama ON asrama.id_asrama = gedung.id_asrama
                        ) as fasil ON fasil.id_gedung = kamar.id_gedung
                    ) as tempat ON tempat.id_kamar = kamar_penghuni.id_kamar
                ) as wil ON wil.daftar_asrama_id = daftar_asrama_reguler.id_daftar AND wil.daftar_asrama_type = 'Daftar_asrama_reguler' 
                WHERE daftar_asrama_reguler.verification in (1,5,6) AND bayar.is_accepted = 0 AND $field like ?",["%".$cari."%"]);

	?>
	<p>Pencarian untuk kategori "{{$kategori}}" dan dengan kata kunci "{{$cari}}".</p>
	<style type="text/css">
		.baru{
			padding: 10px 15px 10px 15px;
			background: red; /* For browsers that do not support gradients */
    		background: linear-gradient(white, #C5C5C5);
    		border: 1px solid grey; /* Standard syntax (must be last) */
		}
		.b_bayar{
			background-color: #34A400;
			border-radius: 3px;
			padding: 5px 7px 5px 7px;
			color: white;
			border: none;
		}
		.b_bayar:hover{
			background-color: #0E5500;
		}
	</style>
	<?php $count = 0; ?>
	@foreach($list as $list)
	<?php
	if($list->jenis_pembayaran == 0){
		$jenis_bayar = 'via Host-to-host';
	}elseif($list->jenis_pembayaran == 1){
		$jenis_bayar = 'via Rekening Penampungan';
	}elseif($list->jenis_pembayaran == 2){
		$jenis_bayar = 'dalam Penangguhan';
	}
	?>
	<div class="baru">
		<h3 style="margin-top: 0px"><b>Pembayaran {{$jenis_bayar}}</b></h3>
		<div class="row">
			<div class="col-md-2">
				<div style='background-color: white; width: 120px; height: 120px; overflow: hidden;margin-top: 0px; position: relative; border-radius: 50%; border: 2px solid black'>
					@if($list->foto_profil == NULL && $list->jenis_kelamin == 'L')
					<img src="{{asset('img/profil/default_men.png')}}" style='position:absolute; left: -100%; right: -100%; top: -100%; bottom: -100%; margin: auto; min-height: 100%; min-width: 100%;' width='40px;'height='40px;' alt='user'>
					@elseif($list->foto_profil == NULL && $list->jenis_kelamin == 'P')
					<img src="{{asset('img/profil/default_women.png')}}" style='position:absolute; left: -100%; right: -100%; top: -100%; bottom: -100%; margin: auto; min-height: 100%; min-width: 100%;' width='40px;'height='40px;' alt='user'>
					@else
					<img src="/storage/avatars/{{ $list->foto_profil }}" style='position:absolute; left: -100%; right: -100%; top: -100%; bottom: -100%; margin: auto; width: 170%; min-height: 100%; min-width: 100%;' width='120px;' alt='user'>
					@endif 
				</div>
			</div>
			<div class="col-md-5">
				<span style="display: inline-block; width: 100px;">Nama</span>: {{$list->name}}<br>
				<span style="display: inline-block; width: 100px;">Email</span>: {{$list->email}}<br>
				<span style="display: inline-block; width: 100px;">Registrasi</span>: {{$list->registrasi}}<br>
				<span style="display: inline-block; width: 100px;">NIM</span>: {{$list->nim}}<br>
				<span style="display: inline-block; width: 100px;">Beasiswa</span>: {{$list->status_beasiswa}}<br>
				<span style="display: inline-block; width: 100px;">Periode</span>: {{$list->nama_periode}}<br>
			</div>
			<div class="col-md-5">
				<span style="display: inline-block; width: 100px;">Kamar</span>: {{$list->kamar}}<br>
				<span style="display: inline-block; width: 100px;">Gedung</span>: {{$list->gedung}}<br>
				<span style="display: inline-block; width: 100px;">Asrama</span>: {{$list->asrama}}<br>
				<span style="display: inline-block; width: 100px;">Tagihan</span>: {{getCurrency($list->jumlah_tagihan)}}<br>
				@if($list->jenis_pembayaran == 2)
				<span style="display: inline-block; width: 100px;">Penangguhan</span>: {{getCurrency($list->jumlah_tangguhan)}}<br>
				@else
				<span style="display: inline-block; width: 100px;">Pembayaran</span>: {{getCurrency($list->jumlah_bayar)}}<br>
				@endif
			</div>
		</div><br>
		@if($list->file != "-")
		<button type="button" class="b_bayar"><a target="_blank" href="{{Storage::url($list->file)}}" style="text-decoration: none; color: white; "> Bukti Pembayaran</a></button>
		@endif <button type="button" class="button" id="btn{{$list->id_pembayaran}}">Rincian</button>
	</div><br>
	<!-- MODAL UNTUK validasi pendaftaran -->
	<style type="text/css">
		/* The Close Button */
	.close{{$list->id_pembayaran}} {
		color: white;
		float: right;
		font-size: 28px;
		font-weight: bold;
	}

	.close{{$list->id_pembayaran}}:hover,
	.close{{$list->id_pembayaran}}:focus {
		color: #000;
		text-decoration: none;
		cursor: pointer;
	}
	.close_tolak{{$list->id_pembayaran}} {
		color: white;
		float: right;
		font-size: 28px;
		font-weight: bold;
	}

	.close_tolak{{$list->id_pembayaran}}:hover,
	.close_tolak{{$list->id_pembayaran}}:focus {
		color: #000;
		text-decoration: none;
		cursor: pointer;
	}
	</style>
	<!-- Modal Pertama -->
	<div id="myModal{{$list->id_pembayaran}}" class="modal">

	  <!-- Modal content -->
	  <div class="modal-content">
		<div class="modal-header">
		  <span class="close{{$list->id_pembayaran}}">&times;</span>
		  <h3><b>Verifikasi Pendaftaran</b></h3>
		</div>
		<div class="modal-body">
	  		<br>
            @if($list->jenis_pembayaran == 0 || $list->jenis_pembayaran == 1)
	  	  	    <h3><b>Form Verifikasi Pembayaran</b></h3>
                <form action="{{route('submit_pembayaran_reguler')}}" method="POST">
					{{ csrf_field() }}
                    <input type="Hidden" name="id_pembayaran" value="{{$list->id_pembayaran}}">
                    <input type="checkbox" name="bukti_pembayaran" value="1">Bukti Pembayaran<br><br>
                    <label>Keterangan Tambahan</label><br>
                    <input id="keterangan" type="text" name="keterangan" class="input" value="{{old('keterangan')}}"><br> 
                    <p><i>Form ini digunakan untuk mengecek kelengkapan dokumen saat daftar ulang<br></i></p>
                    <button class="button" type="submit">Verify</button>
                    <button class="button-close" type="button" id="btn_tolak{{$list->id_pembayaran}}">Tolak</button>
                </form>
            @endif
		</div>
	  </div>
	</div>
	<!-- Modal Kedua -->
	<div id="myModal_tolak{{$list->id_pembayaran}}" class="modal">

	  <!-- Modal content -->
	  <div class="modal-content">
		<div class="modal-header">
		  <span class="close_tolak{{$list->id_pembayaran}}">&times;</span>
		  <h3><b>Konfirmasi Penolakan Pembayaran</b></h3>
		</div>
		<div class="modal-body"><br>
			<form action="{{ route('tolak_bayar') }}" method="POST">
				{{ csrf_field() }}
		  		<label>Catatan Validator</label><br>
		  		<input class="input" name="catatan_validator" type="text" required>
		  		<input type="Hidden" name="id_daftar" value="{{$list->id_daftar}}">
                <input type="Hidden" name="id_pembayaran" value="{{$list->id_pembayaran}}"><br>
                <i>Catatan validator harus diisi sebagai keterangan kenapa pembayaran ditolak</i><hr>
                <button class="button-close" type="submit">Tolak Sekarang</button>
        	</form>
		</div>
	  </div>
	</div>
	<script>
	// Get the modal
	var modal_tolak{{$list->id_pembayaran}} = document.getElementById('myModal_tolak{{$list->id_pembayaran}}');

	// Get the button that opens the modal
	var btn_tolak{{$list->id_pembayaran}} = document.getElementById("btn_tolak{{$list->id_pembayaran}}");

	// Get the <span> element that closes the modal
	var span_tolak{{$list->id_pembayaran}} = document.getElementsByClassName("close_tolak{{$list->id_pembayaran}}")[0];

	// When the user clicks the button, open the modal 
	btn_tolak{{$list->id_pembayaran}}.onclick = function() {
		modal_tolak{{$list->id_pembayaran}}.style.display = "block";
	}

	// When the user clicks on <span> (x), close the modal
	span_tolak{{$list->id_pembayaran}}.onclick = function() {
		modal_tolak{{$list->id_pembayaran}}.style.display = "none";
	}

	// When the user clicks anywhere outside of the modal, close it
	window.onclick = function(event) {
		if (event.target == modal_tolak{{$list->id_pembayaran}}) {
			modal_toolak{{$list->id_pembayaran}}.style.display = "none";
		}
	}
	</script>
	<script>
	// Get the modal
	var modal{{$list->id_pembayaran}} = document.getElementById('myModal{{$list->id_pembayaran}}');

	// Get the button that opens the modal
	var btn{{$list->id_pembayaran}} = document.getElementById("btn{{$list->id_pembayaran}}");

	// Get the <span> element that closes the modal
	var span{{$list->id_pembayaran}} = document.getElementsByClassName("close{{$list->id_pembayaran}}")[0];

	// When the user clicks the button, open the modal 
	btn{{$list->id_pembayaran}}.onclick = function() {
		modal{{$list->id_pembayaran}}.style.display = "block";
	}

	// When the user clicks on <span> (x), close the modal
	span{{$list->id_pembayaran}}.onclick = function() {
		modal{{$list->id_pembayaran}}.style.display = "none";
	}

	// When the user clicks anywhere outside of the modal, close it
	window.onclick = function(event) {
		if (event.target == modal{{$list->id_pembayaran}}) {
			modal{{$list->id_pembayaran}}.style.display = "none";
		}
	}
	</script>
	<?php $count += 1; ?>
	@endforeach
	@if($count == 0)
	Penelusuran tidak ditemukan.<br>
	@endif
	<hr>
	<?php
}elseif(strlen($cari) != 0 && strlen($cari) < 4){
	echo "Masukkan setidaknya 4 karakter untuk memulai pencarian.<br><hr>";
}


?>

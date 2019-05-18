<?php

use App\User_penghuni;
use App\User;
use App\User_nim;
use App\Prodi;
use Illuminate\Support\Facades\DB;
use App\Periode;
use App\Daftar_asrama_non_reguler;
use App\Daftar_asrama_reguler;
use App\Pembayaran;
use App\Asrama;



$id_periode = $_POST['id_periode'];
$id_asrama = $_POST['id_asrama'];
$count = $_POST['count'];
$dir = $_POST['direction'];

if($id_periode != ""){
	$allBayar = DB::select("SELECT * FROM (SELECT tagihan.id_tagihan, jumlah_bayar, jenis_pembayaran, is_accepted, tagihan.daftar_asrama_id, tagihan.daftar_asrama_type, jumlah_tagihan FROM tagihan LEFT JOIN pembayaran ON tagihan.id_tagihan = pembayaran.id_tagihan AND is_accepted = 1 AND jenis_pembayaran IN (0,1)) AS bayar LEFT JOIN (SELECT id_daftar, id, name, email, nim, registrasi, daftar_asrama_reguler.verification, daftar_asrama_reguler.id_periode, nama_periode, ruang.id_kamar, ruang.kamar, ruang.id_gedung, ruang.gedung, ruang.id_asrama, ruang.asrama, telepon, telepon_ortu_wali FROM daftar_asrama_reguler LEFT JOIN users ON users.id = daftar_asrama_reguler.id_user LEFT JOIN user_nim ON user_nim.id_user = daftar_asrama_reguler.id_user LEFT JOIN user_penghuni ON user_penghuni.id_user = daftar_asrama_reguler.id_user LEFT JOIN periodes ON periodes.id_periode = daftar_asrama_reguler.id_periode left join (SELECT kamar_penghuni.daftar_asrama_id, kamar_penghuni.daftar_asrama_type, room.id_kamar, room.kamar, room.id_gedung, room.gedung, room.id_asrama, room.asrama from kamar_penghuni left join (SELECT kamar.id_kamar, kamar.nama as kamar, dorm.id_gedung, dorm.gedung, dorm.id_asrama, dorm.asrama FROM kamar left join (SELECT asrama.id_asrama, asrama.nama as asrama, gedung.id_gedung, gedung.nama as gedung FROM gedung left join asrama on asrama.id_asrama = gedung.id_asrama) as dorm on dorm.id_gedung = kamar.id_gedung) as room on room.id_kamar = kamar_penghuni.id_kamar WHERE kamar_penghuni.daftar_asrama_type = 'daftar_asrama_reguler') as ruang ON ruang.daftar_asrama_id = daftar_asrama_reguler.id_daftar) as dat ON dat.id_daftar = bayar.daftar_asrama_id WHERE bayar.daftar_asrama_type = 'daftar_Asrama_Reguler'AND dat.id_asrama = ? AND dat.id_periode = ?", [$id_asrama, $id_periode]);
	// Menghitung total pembayaran dan memasukkan dalam variable
	$c = 0;
	foreach ($allBayar as $bay) {
        $b_id_tagihan[$c] = $bay->id_tagihan;
        $b_jumlah_bayar[$c] = $bay->jumlah_bayar;
        $b_jumlah_tagihan[$c] = $bay->jumlah_tagihan;
        $b_id[$c] = $bay->id;
        $b_name[$c] = $bay->name;
        $b_nim[$c] = $bay->nim;
        $b_email[$c] = $bay->email;
        $b_telepon[$c] = $bay->telepon;
        $b_telepon_ortu_wali[$c] = $bay->telepon_ortu_wali;
        $b_registrasi[$c] = $bay->registrasi;
        $b_jumlah_bayar_rp[$c] = getCurrency($b_jumlah_bayar[$c]);
        $b_jumlah_tagihan_rp[$c] = getCurrency($b_jumlah_tagihan[$c]);
        $b_deposit[$c] = getCurrency($b_jumlah_bayar[$c] - $b_jumlah_tagihan[$c]);
        $c += 1;
	}
	?>
	<p><i>Menunjukkan 10 dari {{$c}} total data</i></p>
					<div class="table">
						<table>
							<tr>
								<th style="border-top-left-radius: 5px;">No.</th>
								<th>ID</th>
								<th>Nama</th>
								<th>NIM</th>
								<th>Jumlah Tagihan</th>
								<th>Jumlah Bayar</th>
								<th>Deposit</th>
								<th style="border-top-right-radius: 5px;">Rincian</th>
							</tr>
							@if($dir = 'next')
								@for($i=$count; $i <= $count + 9; $i++)
									@if($i<$c)
									<tr>
										<td>{{$i+1}}</td>
										<td>{{$b_id[$i]}}</td>
										<td>{{$b_name[$i]}}</td>
										<td>{{$b_nim[$i]}}</td>
										<td>{{$b_jumlah_tagihan_rp[$i]}}</td>
										<td>
											@if($b_jumlah_bayar[$i] == NULL)
												Rp 0,00
											@else
												{{$b_jumlah_bayar_rp[$i]}}
											@endif
										</td>
										<td>
											@if($b_jumlah_bayar[$i] - $b_jumlah_tagihan[$i] >= 0)
												<span style="color: green"><b>{{$b_deposit[$i]}}</b></span>
											@else
												<span style="color: red"><b>{{$b_deposit[$i]}}</b></span>
											@endif
										</td>
										<td><button class="button" type="button" id="btn_reg{{$b_id[$i]}}">Rincian</button></td>
									</tr>
									<!-- MODAL UNTUK EDIT PERIODE -->
									<style type="text/css">
										/* The Close Button */
									.close_reg{{$b_id[$i]}} {
										color: white;
										float: right;
										font-size: 28px;
										font-weight: bold;
									}

									.close_reg{{$b_id[$i]}}:hover,
									.close_reg{{$b_id[$i]}}:focus {
										color: #000;
										text-decoration: none;
										cursor: pointer;
									}
									</style>
									<!-- Modal untuk rincian -->
									<div id="myModal_reg{{$b_id[$i]}}" class="modal">

										<!-- Modal content -->
										<div class="modal-content">
											<div class="modal-header">
											  <span class="close_reg{{$b_id[$i]}}">&times;</span>
											  <h3><b>Rincian Keuangan</b></h3>
											</div><br>
											<div class="modal-body">
												<div class="row">
													<div class="col-md-6">
														<span style="display: inline-block; width: 110px;">Nama</span><b>: {{$b_name[$i]}}</b><br>
														<span style="display: inline-block; width: 110px;">NIM</span>: {{$b_nim[$i]}}<br>
														<span style="display: inline-block; width: 110px;">Registrasi</span>: {{$b_registrasi[$i]}}<br>
														<span style="display: inline-block; width: 110px;">Email</span>: {{$b_email[$i]}}<br>
													</div>
													<div class="col-md-6">
														<span style="display: inline-block; width: 110px;">Telepon</span>: {{$b_telepon[$i]}}<br>
														<span style="display: inline-block; width: 110px;">Telepon Ortu</span>: {{$b_telepon_ortu_wali[$i]}}<br>
														<span style="display: inline-block; width: 110px;">Total Tagihan</span>: {{$b_jumlah_tagihan_rp[$i]}}<br>
														<span style="display: inline-block; width: 110px;">Total Bayar</span>:
														@if($b_jumlah_bayar[$i] == NULL)
															Rp 0,00
														@else
															{{$b_jumlah_bayar_rp[$i]}}
														@endif<br>
														@if($b_jumlah_bayar[$i] - $b_jumlah_tagihan[$i] >= 0)
															<span style="display: inline-block; width: 110px;">Total Deposit</span>:
															<span style="color: green;"><b>{{$b_deposit[$i]}}</b></span>
														@else
															<span style="display: inline-block; width: 110px;">Total Deposit</span>:
															<span style="color: red;"><b>{{$b_deposit[$i]}}</b></span>
														@endif
													</div>
												</div><hr>
													<br><br>
											</div>
										</div>
									</div>

									<script>
									// Get the modal
									var modal_reg{{$b_id[$i]}} = document.getElementById('myModal_reg{{$b_id[$i]}}');

									// Get the button that opens the modal
									var btn_reg{{$b_id[$i]}} = document.getElementById("btn_reg{{$b_id[$i]}}");

									// Get the <span> element that closes the modal
									var span_reg{{$b_id[$i]}} = document.getElementsByClassName("close_reg{{$b_id[$i]}}")[0];

									// When the user clicks the button, open the modal 
									btn_reg{{$b_id[$i]}}.onclick = function() {
										modal_reg{{$b_id[$i]}}.style.display = "block";
									}

									// When the user clicks on <span> (x), close the modal
									span_reg{{$b_id[$i]}}.onclick = function() {
										modal_reg{{$b_id[$i]}}.style.display = "none";
									}

									// When the user clicks anywhere outside of the modal, close it
									window.onclick = function(event) {
										if (event.target == modal_reg{{$b_id[$i]}}) {
											modal_reg{{$b_id[$i]}}.style.display = "none";
										}
									}
									</script>
									@endif
								@endfor
							@else
								@for($i=$count; $i <= $count - 9; $i++)
									@if($i<$c)
									<tr>
										<td>{{$i+1}}</td>
										<td>{{$b_id[$i]}}</td>
										<td>{{$b_name[$i]}}</td>
										<td>{{$b_nim[$i]}}</td>
										<td>{{$b_registrasi[$i]}}</td>
										<td>{{$b_jumlah_tagihan[$i]}}</td>
										<td>
											@if($b_jumlah_bayar[$i] == NULL)
												0
											@else
												{{$b_jumlah_bayar[$i]}}
											@endif
										</td>
										<td>
											@if($b_jumlah_bayar[$i] - $b_jumlah_tagihan[$i] >= 0)
												<span style="color: green"><b>{{$b_jumlah_bayar[$i] - $b_jumlah_tagihan[$i]}}</b></span>
											@else
												<span style="color: red"><b>{{$b_jumlah_bayar[$i] - $b_jumlah_tagihan[$i]}}</b></span>
											@endif
										</td>
										<td><button class="button" type="button">Rincian</button></td>
									</tr>
									@endif
								@endfor
							@endif
						</table>
					</div>
	<?php
}
?>
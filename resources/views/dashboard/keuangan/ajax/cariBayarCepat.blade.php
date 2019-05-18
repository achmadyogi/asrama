@if(isset($gagal))
<p>Silahkan memilih kategori pencarian terlebih dahulu.</p>
@else
<p>Filter dengan kata kunci: "<i>{{$input}}</i>"</p>
<div class="table">
	<table>
		<tr>
			<th style="border-top-left-radius: 5px;">No.</th>
			<th>Nama</th>
			<th>Jumlah Tagihan</th>
			<th>Jumlah Bayar</th>
			<th>Deposit</th>
			<th style="border-top-right-radius: 5px;">Rincian</th>
		</tr>
		<?php $tes=0; ?>
		@for($i=0; $i <= 9; $i++)
			@if($i<$x)
			<tr>
				<td>{{$i+1}}</td>
				<td>{{$name[$i]}}</td>
				<td>{{$tagihan_total[$i]}}</td>
				<td>
					@if($pembayaran_total[$i] == NULL)
						Rp 0,00
					@else
						{{$pembayaran_total[$i]}}
					@endif
				</td>
				<td>
					@if($depos[$i] >= 0)
						<span style="color: green"><b>{{$deposit[$i]}}</b></span>
					@else
						<span style="color: red"><b>{{$deposit[$i]}}</b></span>
					@endif
				</td>
				<td><button class="button" type="button" id="btn_reg{{$id[$i]}}">Rincian</button></td>
			</tr>
			<!-- MODAL UNTUK EDIT PERIODE -->
			<style type="text/css">
				/* The Close Button */
				.close_reg{{$id[$i]}} {
					color: white;
					float: right;
					font-size: 28px;
					font-weight: bold;
				}

				.close_reg{{$id[$i]}}:hover,
				.close_reg{{$id[$i]}}:focus {
					color: #000;
					text-decoration: none;
					cursor: pointer;
				}
			</style>
			<!-- Modal untuk rincian -->
			<div id="myModal_reg{{$id[$i]}}" class="modal">

				<!-- Modal content -->
				<div class="modal-content">
					<div class="modal-header">
					  <span class="close_reg{{$id[$i]}}">&times;</span>
					  <h3><b>Rincian Keuangan</b></h3>
					</div><br>
					<div class="modal-body">
						<h4 style="margin-top: 0px;"><b>Informasi Personal</b></h4>
						<div class="row">
							<div class="col-md-2">
								<div style='background-color: white; width: 100px; height: 100px; overflow: hidden;margin-top: 0px; position: relative; border-radius: 50%; border: 2px solid black; margin-left: auto; margin-right: auto;'>
									@if($foto_profil[$i] == NULL && $jenis_kelamin[$i] == 'L')
									<img src="{{asset('img/profil/default_men.png')}}" style='position:absolute; left: -100%; right: -100%; top: -100%; bottom: -100%; margin: auto; min-height: 100%; min-width: 100%;' width='50px;'height='50px;' alt='user' align="middle">
									@elseif($foto_profil[$i] == NULL && $jenis_kelamin[$i] == 'P')
									<img src="{{asset('img/profil/default_women.png')}}" style='position:absolute; left: -100%; right: -100%; top: -100%; bottom: -100%; margin: auto; min-height: 100%; min-width: 100%;' width='50px;'height='50px;' alt='user' align="middle">
									@else
									<img src="/storage/avatars/{{ $foto_profil[$i] }}" style='position:absolute; left: -100%; right: -100%; top: -100%; bottom: -100%; margin: auto; width: 170%; min-height: 100%; min-width: 100%;' width='50px;' alt='user' align="middle">
									@endif 
								</div><br>
							</div>
							<div class="col-md-5">
								<span style="display: inline-block; width: 110px;">Nama</span><b>: {{$name[$i]}}</b><br>
								<span style="display: inline-block; width: 110px;">Email</span>: {{$email[$i]}}<br>
								<span style="display: inline-block; width: 110px;">NIM</span>: {{$nim[$i]}}<br>
								<span style="display: inline-block; width: 110px;">No. Registrasi</span>: {{$registrasi[$i]}}<br>
								<span style="display: inline-block; width: 110px;">Telepon</span>: {{$telepon[$i]}}<br>
							</div>
							<div class="col-md-5">
								<span style="display: inline-block; width: 110px;">Telepon Ortu</span>: {{$telepon_ortu_wali[$i]}}<br>
								<span style="display: inline-block; width: 110px;">Total Tagihan</span>: {{$tagihan_total[$i]}}<br>
								<span style="display: inline-block; width: 110px;">Total Bayar</span>:
								@if($pembayaran_total[$i] == NULL)
									Rp 0,00
								@else
									{{$pembayaran_total[$i]}}
								@endif<br>
								@if($depos[$i] >= 0)
									<span style="display: inline-block; width: 110px;">Total Deposit</span>:
									<span style="color: green;"><b>{{$deposit[$i]}}</b></span><br>
								@else
									<span style="display: inline-block; width: 110px;">Total Deposit</span>:
									<span style="color: red;"><b>{{$deposit[$i]}}</b></span><br>
								@endif
							</div>
						</div><hr>
						<h4><b>Rincian Pendaftaran</b></h4>
						<p><b>Pendaftaran Reguler</b></p>
						@for($z=0; $z < sizeof($r_id_user); $z++)
							@if($r_id_user[$z] == $id[$i])
								<div class="row">
									<div class="col-md-6">
										<p><span style="width: 120px; display: inline-block;">Nama Periode</span>: {{$r_nama_periode[$z]}}<br>
											<span style="width: 120px; display: inline-block;">Status Beasiswa</span>: {{$r_status_beasiswa[$z]}}<br>
											<span style="width: 120px; display: inline-block;">Kamar</span>: {{$r_kamar[$z]}}<br>
											<span style="width: 120px; display: inline-block;">Gedung</span>: {{$r_gedung[$z]}}<br>
											<span style="width: 120px; display: inline-block;">Asrama</span>: {{$r_asrama[$z]}}<br></p>
									</div>
									<div class="col-md-6">
										<p><span style="width: 120px; display: inline-block;">Jumlah Tagihan</span>: {{$r_jumlah_tagihan[$z]}}<br>
											<span style="width: 120px; display: inline-block;">Total Bayar</span>: {{$r_total_bayar[$z]}}<br>
											<span style="width: 120px; display: inline-block;">Total Deposit</span>: 
											@if($r_depos[$z] < 0)
												<span style="color: red">{{$r_deposit[$z]}}</span><br>
											@else
												<span style="color: green">{{$r_deposit[$z]}}</span><br>
											@endif
											<span style="width: 120px; display: inline-block;">Keterangan</span>: {{$r_keterangan[$z]}}<br>
									</div>
								</div>
								<p>----------</p>
							@endif
						@endfor
						<p><b>Pendaftaran Non Reguler</b></p>
						@for($z=0; $z < sizeof($n_id_user); $z++)
							@if($n_id_user[$z] == $id[$i])
								<div class="row">
									<div class="col-md-6">
										<p><span style="width: 120px; display: inline-block;">Tujuan Tinggal</span>: {{$n_tujuan_tinggal[$z]}}<br>
											<span style="width: 120px; display: inline-block;">Kamar</span>: {{$n_kamar[$z]}}<br>
											<span style="width: 120px; display: inline-block;">Gedung</span>: {{$n_gedung[$z]}}<br>
											<span style="width: 120px; display: inline-block;">Asrama</span>: {{$n_asrama[$z]}}<br></p>
									</div>
									<div class="col-md-6">
										<p><span style="width: 120px; display: inline-block;">Jumlah Tagihan</span>: {{$n_jumlah_tagihan[$z]}}<br>
											<span style="width: 120px; display: inline-block;">Total Bayar</span>: {{$n_total_bayar[$z]}}<br>
											<span style="width: 120px; display: inline-block;">Total Deposit</span>: 
											@if($n_depos[$z] < 0)
												<span style="color: red">{{$n_deposit[$z]}}</span><br>
											@else
												<span style="color: green">{{$n_deposit[$z]}}</span><br>
											@endif
											<span style="width: 120px; display: inline-block;">Keterangan</span>: {{$n_keterangan[$z]}}<br>
									</div>
								</div>
								<p>----------</p>
							@endif
						@endfor
							<hr><br>
					</div>
				</div>
			</div>

			<script>
				// Get the modal
				var modal_reg{{$id[$i]}} = document.getElementById('myModal_reg{{$id[$i]}}');

				// Get the button that opens the modal
				var btn_reg{{$id[$i]}} = document.getElementById("btn_reg{{$id[$i]}}");

				// Get the <span> element that closes the modal
				var span_reg{{$id[$i]}} = document.getElementsByClassName("close_reg{{$id[$i]}}")[0];

				// When the user clicks the button, open the modal 
				btn_reg{{$id[$i]}}.onclick = function() {
					modal_reg{{$id[$i]}}.style.display = "block";
				}

				// When the user clicks on <span> (x), close the modal
				span_reg{{$id[$i]}}.onclick = function() {
					modal_reg{{$id[$i]}}.style.display = "none";
				}

				// When the user clicks anywhere outside of the modal, close it
				window.onclick = function(event) {
					if (event.target == modal_reg{{$id[$i]}}) {
						modal_reg{{$id[$i]}}.style.display = "none";
					}
				}
			</script>
			<?php $tes += 1; ?>
			@endif
		@endfor
		
	</table>
</div>
@if($tes > 9)
	<p><i>*Hasil pencarian hanya ditampilkan sepuluh data teratas saja. Gunakan kata kunci yang lebih detail untuk mendapatkan kriteria yang diinginkan</i></p>
@endif
@endif
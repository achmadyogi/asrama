@if($h<=8)
					<p><i>Menunjukkan {{$h}} dari {{$h}} total data</i></p>
					@else
					<p><i>Menunjukkan {{$c}} dari {{$h}} total data</i></p>
					@endif
					<div class="table">
						<table>
							<tr>
								<th>No.</th>
								<th>ID Pendaftaran</th>
								<th>Nama Penghuni</th>
                                <th>Asrama</th>
								<th>Kamar</th>
								<th>Aksi</th>
							</tr>
							<?php $urut = 0; ?>
							@foreach($daful as $d)
								@if($urut >= $count && $urut < $count + $c)
									<tr>
										<td>{{$urut+1}}.</td>
										<td>{{$d->id_daftar}}</td>
										<td>{{$d->name}}</td>
										<td>{{$d->asrama}}</td>
										<td>{{$d->kamar}}</td>
										<td><button class="button" id="btn{{$d->id_daftar}}" type="button">Rincian</button></td>
									</tr>
									<!-- MODAL UNTUK validasi pendaftaran -->
									<style type="text/css">
										/* The Close Button */
										.close{{$d->id_daftar}} {
											color: white;
											float: right;
											font-size: 28px;
											font-weight: bold;
										}

										.close{{$d->id_daftar}}:hover,
										.close{{$d->id_daftar}}:focus {
											color: #000;
											text-decoration: none;
											cursor: pointer;
										}
										.close_tolak{{$d->id_daftar}} {
											color: white;
											float: right;
											font-size: 28px;
											font-weight: bold;
										}

										.close_tolak{{$d->id_daftar}}:hover,
										.close_tolak{{$d->id_daftar}}:focus {
											color: #000;
											text-decoration: none;
											cursor: pointer;
										}
									</style>
									<!-- Modal Pertama -->
									<div id="myModal{{$d->id_daftar}}" class="modal">

									  <!-- Modal content -->
									  <div class="modal-content">
										<div class="modal-header">
										  <span class="close{{$d->id_daftar}}">&times;</span>
										  <h3><b>Verifikasi Pendaftaran</b></h3>
										</div>
										<div class="modal-body">
											<div class="row">
												<div class="col-md-6">
											  		<br>
											  	  	<p><span style="display: inline-block; width: 150px;">Nama</span><b>: {{$d->name}}</b><br><span style="display: inline-block; width: 150px;">Email</span>: {{$d->email}}<br>
											  	  	<span style="display: inline-block; width: 150px;">NIM</span>: {{$d->nim}}<br>
											  	  	<span style="display: inline-block; width: 150px;">No. Registrasi</span>: {{$d->registrasi}}<br>
											  	  	<span style="display: inline-block; width: 150px;">Status Beasiswa</span>: {{$d->status_beasiswa}}<br>
				                                    </p>
												</div>
												<div class="col-md-6">
													<br>
													<span style="display: inline-block; width: 150px;">Periode</span>: {{$d->nama_periode}}<br>
													<span style="display: inline-block; width: 150px;">Kamar</span>: {{$d->kamar}}<br>
													<span style="display: inline-block; width: 150px;">Gedung</span>: {{$d->gedung}}<br>
				                                    <span style="display: inline-block; width: 150px;">Lokasi Asrama</span>: {{$d->asrama}}<br>
				                                    <span style="display: inline-block; width: 150px;">Tagihan</span>: {{$tagihan[$urut]}}<br>
												</div>
											</div><hr>
											@if($d->jumlah_tangguhan != NULL)
											<h4><b>Daftar Ulang (Mengajukan Penangguhan)</b></h4>
											<i>Alasan</i>: {{$d->alasan_penangguhan}}<br>
											@else
											<h4><b>Daftar Ulang</b></h4>
											@endif <br>
											<form action="{{ route('submitDaful') }}" method="POST">
												{{ csrf_field() }}
												<input type="hidden" name="id_daftar" value="{{$d->id_daftar}}">
												<input type="hidden" name="jumlah_tangguhan" value="{{$d->jumlah_tangguhan}}">
												<input type="hidden" name="id_penangguhan" value="{{$d->id_penangguhan}}">
												<input type="checkbox" name="surat_perjanjian"> Surat Perjanjian<br>
												<input type="checkbox" name="ktm"> KTM<br>
												@if($d->jumlah_tangguhan != NULL)
												<input type="checkbox" name="formulir_penangguhan"> Formulir Penangguhan<br>
												<input type="checkbox" name="sktm"> SKTM/Bukti Bidikmisi<br>
												@endif <br>
												<label>Keterangan tambahan</label><br>
												<input type="text" name="keterangan" class="input"><br><br>
												<button class="button" type="submit">Daftarkan</button>
											</form>
										</div>
									  </div>
									</div>
									<script>
										// Get the modal
										var modal{{$d->id_daftar}} = document.getElementById('myModal{{$d->id_daftar}}');

										// Get the button that opens the modal
										var btn{{$d->id_daftar}} = document.getElementById("btn{{$d->id_daftar}}");

										// Get the <span> element that closes the modal
										var span{{$d->id_daftar}} = document.getElementsByClassName("close{{$d->id_daftar}}")[0];

										// When the user clicks the button, open the modal 
										btn{{$d->id_daftar}}.onclick = function() {
											modal{{$d->id_daftar}}.style.display = "block";
										}

										// When the user clicks on <span> (x), close the modal
										span{{$d->id_daftar}}.onclick = function() {
											modal{{$d->id_daftar}}.style.display = "none";
										}

										// When the user clicks anywhere outside of the modal, close it
										window.onclick = function(event) {
											if (event.target == modal{{$d->id_daftar}}) {
												modal{{$d->id_daftar}}.style.display = "none";
											}
										}
									</script>
								@endif
								<?php $urut += 1; ?>
							@endforeach
						</table>
					</div>
@if(isset($fail) && $fail == 1)
<p>Tulis minimal empat karakter untuk memulai pencarian</p><hr>
@else
	<style type="text/css">
		.baru{
				padding: 10px 15px 10px 15px;
				background: red; /* For browsers that do not support gradients */
	    		background: linear-gradient(white, #C5C5C5);
	    		border: 1px solid grey; /* Standard syntax (must be last) */
			}
	</style>
	<?php $urut = 0; ?>
	@foreach($daful as $d)
		@if($urut <= 5)
		<div class="baru">
			<h3 style="margin-top: 0px"><b>Daftar Ulang @if($d->jumlah_tangguhan != NULL) (Mengajukan Penangguhan) @endif</b></h3>
			<div class="row">
				<div class="col-md-2"><br>
					<div style='background-color: white; width: 120px; height: 120px; overflow: hidden;margin-top: 0px; position: relative; border-radius: 50%; border: 2px solid black'>
						@if($d->foto_profil == NULL && $d->jenis_kelamin == 'L')
						<img src="{{asset('img/profil/default_men.png')}}" style='position:absolute; left: -100%; right: -100%; top: -100%; bottom: -100%; margin: auto; min-height: 100%; min-width: 100%;' width='40px;'height='40px;' alt='user'>
						@elseif($d->foto_profil == NULL && $d->jenis_kelamin == 'P')
						<img src="{{asset('img/profil/default_women.png')}}" style='position:absolute; left: -100%; right: -100%; top: -100%; bottom: -100%; margin: auto; min-height: 100%; min-width: 100%;' width='40px;'height='40px;' alt='user'>
						@else
						<img src="/storage/avatars/{{ $d->foto_profil }}" style='position:absolute; left: -100%; right: -100%; top: -100%; bottom: -100%; margin: auto; width: 170%; min-height: 100%; min-width: 100%;' width='120px;' alt='user'>
						@endif 
					</div>
				</div>
				<div class="col-md-5">
			  		<br>
			  	  	<p><span style="display: inline-block; width: 100px;">Nama</span><b>: {{$d->name}}</b><br><span style="display: inline-block; width: 100px;">Email</span>: {{$d->email}}<br>
			  	  	<span style="display: inline-block; width: 100px;">NIM</span>: {{$d->nim}}<br>
			  	  	<span style="display: inline-block; width: 100px;">No. Registrasi</span>: {{$d->registrasi}}<br>
			  	  	<span style="display: inline-block; width: 100px;">Beasiswa</span>: {{$d->status_beasiswa}}<br>
                    </p>
				</div>
				<div class="col-md-5">
					<br>
					<span style="display: inline-block; width: 100px;">Periode</span>: {{$d->nama_periode}}<br>
					<span style="display: inline-block; width: 100px;">Kamar</span>: {{$d->kamar}}<br>
					<span style="display: inline-block; width: 100px;">Gedung</span>: {{$d->gedung}}<br>
                    <span style="display: inline-block; width: 100px;">Asrama</span>: {{$d->asrama}}<br>
                    <span style="display: inline-block; width: 100px;">Tagihan</span>: {{$tagihan[$urut]}}<br>
				</div>
			</div>
			<button class="button" id="btn{{$d->id_daftar}}" type="button">Rincian</button>
		</div><br>
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
			  <h3><b>Verifikasi Pendaftaran ({{$d->name}})</b></h3>
			</div>
			<div class="modal-body">
				@if($d->jumlah_tangguhan != NULL)
				<h4><b>Daftar Ulang (Mengajukan Penangguhan)</b></h4>
				<i>Alasan</i>: {{$d->alasan_penangguhan}}<br>
				@else
				<h4><b>Daftar Ulang</b></h4>
				@endif <br>
				<form method="POST" action="{{ route('submitDaful') }}">
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
					<input class="button" type="submit" value="Daftarkan">
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
	@if($urut > 5)
	<p><i>Batas pencarian adalah lima unit. Gunakan kata kunci yang lebih detail untuk memudahkan pencarian.</i></p>
	@endif				
	<hr>				
@endif
<hr>
@if(isset($message))
	<?php echo $message; ?>
@else
	<p>Calon penghuni akan didaftarkan pada kamar berikut:</p>
	<div class="row">
		<div class="col-md-6">
			<span style="display: inline-block; width: 150px">Kamar</span>: {{$kamarVar->nama}} <br>
			<span style="display: inline-block; width: 150px">Gedung</span>: {{$gedungVar->nama}} <br>
			<span style="display: inline-block; width: 150px">Asrama</span>: {{$asramaVar->nama}} <br>
			<span style="display: inline-block; width: 150px">Gender</span>: {{$kamarVar->gender}} <br>
		</div>
		<div class="col-md-6">
			<span style="display: inline-block; width: 150px">Kapasitas</span>: {{$kamarVar->kapasitas}} <br>
			<span style="display: inline-block; width: 150px">Penghuni sekarang</span>: {{$kap}}<br>
			<span style="display: inline-block; width: 150px">Tagihan</span>: {{$jumlah_tagihan}}<br>
			<span style="display: inline-block; width: 150px">Keterangan Kamar</span>: {{$kamarVar->keterangan}}<br>
		</div>
	</div><br>
	<form method="POST" action="{{route('inboundReg_approval')}}">
		{{ csrf_field() }}
		<input type="Hidden" name="id_daftar" value="{{$id_daftar}}">
		<input type="Hidden" name="preference" value="{{$preference}}">
		<input type="Hidden" name="tagihan_total" value="{{$real_tagihan}}">
		<input type="Hidden" name="id_kamar" value="{{$kamarVar->id_kamar}}">
		<input type="Hidden" name="tanggal_masuk_reg" value="{{$tanggal_masuk_reg}}">
		<button class="button" type="submit">Verify</button>
		<button class="button" type="button" id="btn_list{{$id_daftar}}">Waiting List</button>
		<button class="button-close" type="button" id="btn_blacklist{{$id_daftar}}">Blacklist</button>
		<button class="button-close" type="button" id="btn_taklolos{{$id_daftar}}">Tidak Lolos</button>
	</form>
	<!-- Modal untuk pop up blacklist -->
	<style type="text/css">
		/* The Close Button */
		.close_blacklist{{$id_daftar}} {
			color: white;
			float: right;
			font-size: 28px;
			font-weight: bold;
		}

		.close_blacklist{{$id_daftar}}:hover,
		.close_blacklist{{$id_daftar}}:focus {
			color: #000;
			text-decoration: none;
			cursor: pointer;
		}
	</style>
	<div id="myModal_blacklist{{$id_daftar}}" class="modal">

		<!-- Modal content -->
		<div class="modal-content-blacklist">
			<div class="modal-header">
			<span class="close_blacklist{{$id_daftar}}">&times;</span>
			<h3><b>Verifikasi Blacklist</b></h3>
			</div>
			<div class="modal-body">
				<br>
				<div class="row">
					<div class="col-md-12">
						<p>Apakah Anda yakin akan blacklist ?</p>
					</div>
				</div><hr>
				<form action="{{route('submit_blacklist')}}" method="POST">
					{{ csrf_field() }}
					<label>Alasan Blacklist</label><br>
					<input type="text" name="alasan" class = "input"><br><br>
					<input type="hidden" name="id_daftar" value="{{$id_daftar}}">
					<input type="hidden" name="id_user" value="{{$id_user}}">
					<button class="button" type="button" id="btn_keluar{{$id_daftar}}">Keluar</button>
					<button class="button-close" type="submit">Blacklist</button><br><br>  
				</form>
			</div>
		</div>

	</div>
	<script>
		// Get the modal
		var modal_blacklist{{$id_daftar}} = document.getElementById('myModal_blacklist{{$id_daftar}}');

		// Get the button that opens the modal
		var btn_blacklist{{$id_daftar}} = document.getElementById("btn_blacklist{{$id_daftar}}");

		// Get the <span> element that closes the modal
		var span_blacklist{{$id_daftar}} = document.getElementsByClassName("close_blacklist{{$id_daftar}}")[0];

		// When the user clicks the button, open the modal 
		btn_blacklist{{$id_daftar}}.onclick = function() {
			modal_blacklist{{$id_daftar}}.style.display = "block";
		}

		//button keluar
		btn_keluar{{$id_daftar}}.onclick = function() {
			modal_blacklist{{$id_daftar}}.style.display = "none";
		}

		// When the user clicks on <span> (x), close the modal
		span_blacklist{{$id_daftar}}.onclick = function() {
			modal_blacklist{{$id_daftar}}.style.display = "none";
		}

		// When the user clicks anywhere outside of the modal, close it
		window.onclick = function(event) {
			if (event.target == modal_blacklist{{$id_daftar}}) {
				modal_blacklist{{$id_daftar}}.style.display = "none";
			}
		}
	</script>

	<!-- Modal untuk pop up waiting list -->
	<style type="text/css">
		/* The Close Button */
		.close_list{{$id_daftar}} {
			color: white;
			float: right;
			font-size: 28px;
			font-weight: bold;
		}

		.close_list{{$id_daftar}}:hover,
		.close_list{{$id_daftar}}:focus {
			color: #000;
			text-decoration: none;
			cursor: pointer;
		}
	</style>
	<div id="myModal_list{{$id_daftar}}" class="modal">

		<!-- Modal content -->
		<div class="modal-content">
			<div class="modal-header">
			<span class="close_list{{$id_daftar}}">&times;</span>
			<h3><b>Verifikasi Waiting List</b></h3>
			</div>
			<div class="modal-body">
				<br>
				<div class="row">
					<div class="col-md-12">
						<p>Apakah Anda yakin akan memasukkan pada daftar waiting list untuk penghuni ini?</p>
					</div>
				</div><hr>
				<form action="{{route('submit_list')}}" method="POST">
					{{ csrf_field() }}
					<input type="hidden" name="id_daftar" value="{{$id_daftar}}">
					<input type="hidden" name="id_user" value="{{$id_user}}">
					<button class="button" type="button" id="btn_keluar_list{{$id_daftar}}">Keluar</button>
					<button class="button-close" type="submit">Waiting List</button><br><br>  
				</form>
			</div>
		</div>

	</div>
	<script>
		// Get the modal
		var modal_list{{$id_daftar}} = document.getElementById('myModal_list{{$id_daftar}}');

		// Get the button that opens the modal
		var btn_list{{$id_daftar}} = document.getElementById("btn_list{{$id_daftar}}");

		// Get the <span> element that closes the modal
		var span_list{{$id_daftar}} = document.getElementsByClassName("close_list{{$id_daftar}}")[0];

		// When the user clicks the button, open the modal 
		btn_list{{$id_daftar}}.onclick = function() {
			modal_list{{$id_daftar}}.style.display = "block";
		}

		//button keluar
		btn_keluar_list{{$id_daftar}}.onclick = function() {
			modal_list{{$id_daftar}}.style.display = "none";
		}

		// When the user clicks on <span> (x), close the modal
		span_list{{$id_daftar}}.onclick = function() {
			modal_list{{$id_daftar}}.style.display = "none";
		}

		// When the user clicks anywhere outside of the modal, close it
		window.onclick = function(event) {
			if (event.target == modal_list{{$id_daftar}}) {
				modal_list{{$id_daftar}}.style.display = "none";
			}
		}
	</script>

	<!-- Modal untuk pop up tidak lolos -->
	<style type="text/css">
		/* The Close Button */
		.close_taklolos{{$id_daftar}} {
			color: white;
			float: right;
			font-size: 28px;
			font-weight: bold;
		}

		.close_taklolos{{$id_daftar}}:hover,
		.close_taklolos{{$id_daftar}}:focus {
			color: #000;
			text-decoration: none;
			cursor: pointer;
		}
	</style>
	<div id="myModal_taklolos{{$id_daftar}}" class="modal">

		<!-- Modal content -->
		<div class="modal-content">
			<div class="modal-header">
			<span class="close_taklolos{{$id_daftar}}">&times;</span>
			<h3><b>Verifikasi Tidak Lolos</b></h3>
			</div>
			<div class="modal-body">
				<br>
				<div class="row">
					<div class="col-md-12">
						<p>Apakah Anda yakin untuk tidak meloloskan pendaftaran penghuni ini?</p>
					</div>
				</div><hr>
				<form action="{{route('taklolos')}}" method="POST">
					{{ csrf_field() }}
					<input type="hidden" name="id_daftar" value="{{$id_daftar}}">
					<input type="hidden" name="id_user" value="{{$id_user}}">
					<button class="button" type="button" id="btn_keluar_taklolos{{$id_daftar}}">Keluar</button>
					<button class="button-close" type="submit">Tidak Lolos</button><br><br>  
				</form>
			</div>
		</div>

	</div>
	<script>
		// Get the modal
		var modal_taklolos{{$id_daftar}} = document.getElementById('myModal_taklolos{{$id_daftar}}');

		// Get the button that opens the modal
		var btn_taklolos{{$id_daftar}} = document.getElementById("btn_taklolos{{$id_daftar}}");

		// Get the <span> element that closes the modal
		var span_taklolos{{$id_daftar}} = document.getElementsByClassName("close_taklolos{{$id_daftar}}")[0];

		// When the user clicks the button, open the modal 
		btn_taklolos{{$id_daftar}}.onclick = function() {
			modal_taklolos{{$id_daftar}}.style.display = "block";
		}

		//button keluar
		btn_keluar_taklolos{{$id_daftar}}.onclick = function() {
			modal_taklolos{{$id_daftar}}.style.display = "none";
		}

		// When the user clicks on <span> (x), close the modal
		span_taklolos{{$id_daftar}}.onclick = function() {
			modal_taklolos{{$id_daftar}}.style.display = "none";
		}

		// When the user clicks anywhere outside of the modal, close it
		window.onclick = function(event) {
			if (event.target == modal_taklolos{{$id_daftar}}) {
				modal_taklolos{{$id_daftar}}.style.display = "none";
			}
		}
	</script>
@endif
<br><i>*Refresh kembali untuk mendapatkan kemungkinan alokasi yang berbeda.</i>
<hr>
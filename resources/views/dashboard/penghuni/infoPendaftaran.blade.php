@extends('layouts.default')

@if(session()->has('en'))
	@section('title',  'Registration')
@else	
	@section('title',  'Pendaftaran')
@endif

@section('menu_dash','active')

@section('main_menu')
	@parent

@endsection

@if(session()->has('en'))
	@section('header_title', 'Occupant | Registration')
@else	
	@section('header_title', 'Penghuni | Pendaftaran')
@endif



@section('content')
<div class="container">
	<br><br>
	<div class="row">
		<div class="col-md-9">
			<!-- KONTEN UTAMA-->
			<div id="content">
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

				@if($countNonReg == 0 && $countReg == 0)
					@if(session()->has('en'))
						<h1><b>General Information</b></h1>
						<p>Thank you for joining us! You can proceed the registration under the following terms and condition.
							<h4><b>REGULAR OCCUPANT</b></h4>This type of occupancy is intentionally made for an active ITB student. It provides structured living period to support academic activities around campuses. Once a student signing up for a regular category, he will be living for about 5 months in accordance with the academic calendar.<br>
							<h4><b>NON REGULAR OCCUPANT</b></h4>The Non Regular living period is designed for a short time living. Currently, we can not receive an application from strangers who have no business or important purposes towards the university. To obtain the eligibility, you must fill in an online registration form and send a formal letter from your organization to WRAM ITB. After your permission is approved, we will proceed your living plan as well.
						</p><br>
						<h2><b>Available Registration Period</b></h2>
					@else	
						<h1><b>Informasi Pendaftaran</b></h1>
						<p>jgfjghTerimakasih telah bergabung dengan UPT Asrama ITB. Silahkan daftarkan diri Anda untuk permohonan tinggal di asarama.
							Syarat dan ketentuan adalah sebagai berikut:<br>
							<h4><b>PENGHUNI REGULER</b></h4>Penghuni reguler adalah penghuni dengan status mahasiswa ITB. Seorang penghuni reguler hanya dapat mendaftar pada periode tertentu yang waktunya telah ditetapkan oleh pihak asrama.<br>
							<h4><b>PENGHUNI NON REGULER</b></h4>Penghuni Non Reguler terbuka bagi siapa saja yang ingin mendaftar ke asrama. Penghuni Non Reguler dapat menetapkan tanggal masuk dan tanggal keluar dari asrama sesuai keperluan tinggal.
						</p><br>
						<h2><b>Periode Pendaftaran Tersedia</b></h2>
					@endif
					<div class="row">
						<div class="col-md-6" style="text-align: center;">
							<h3><b>@if(session()->has('en')) Non-Regular Registration @else Pendaftaran Non Reguler @endif</b></h3>
							<div style="text-align: center;"><a href="{{ route('daftar_non_reguler') }}"><button class="button">@if(session()->has('en')) Register Now @else Daftar Sekarang @endif</button></a></div>
						</div>
						<div class="col-md-6" style="text-align: center;">
							<h3><b>@if(session()->has('en')) Regular Registration @else Pendaftaran Reguler @endif</b></h3>
							@if($pass_periode == 0)
								<p>@if(session()->has('en')) There is no regular registration for now being opened. @else Belum ada pendaftaran reguler untuk saat ini @endif</p>
							@else
								<div style="text-align: center;"><a href="{{route('daftar_reguler')}}"><button class="button">@if(session()->has('en')) Register Now @else Daftar Sekarang @endif</button></a></div>
							@endif
						</div>
					</div>
				@else
					<h2><b>@if(session()->has('en')) Registration Status @else Status Pendaftaran @endif</b></h2>
					<h3><b>@if(session()->has('en')) Regular Registration History @else Riwayat Pendaftaran Reguler @endif</b></h3> 
					@if($countReg > 0)
						<div class="table">
							<table>
								<tr>
									<th>No.</th>
									<th>@if(session()->has('en')) Period @else Periode @endif</th>
									<th>@if(session()->has('en')) Reg. Date @else Tanggal Daftar @endif</th>
									<th>Status</th>
									<th>@if(session()->has('en')) Action @else Aksi @endif</th>
								</tr>
								<?php $i = 1; ?>
								@foreach($reguler as $reg)
								<tr>
									<td>{{$i}}.</td>
									<td>{{$reg->nama_periode}}</td>
									<td>{{ITBdorm::DateTime($reg->created_at)}}</td>
									<td>
									@if($reg->verification == 0)
									  	@if(session()->has('en')) Waiting for being verified @else Menunggu verifikasi @endif
									@elseif($reg->verification == 1)
							  	  		@if($reg->id_checout == NULL)
							  	  			<span style="color:green;"><b>@if(session()->has('en')) Accepted @else Diterima @endif</b></span>
							  	  		@else
							  	  			Checkout
							  	  		@endif
									@elseif($reg->verification == 2)
										<span style="color:red;"><b>@if(session()->has('en')) Abandoned @else Dibatalkan @endif</b></span>
									@elseif($reg->verification == 3)	
										<span style="color:red;"><b>Black List</b></span>
									@elseif($reg->verification == 4)	
										<span><b>Waiting List</b></span>
									@elseif($reg->verification == 5)	
										<span style="color:green;"><b>@if(session()->has('en')) Active @else Aktif @endif</b></span>
									@elseif($reg->verification == 6)	
										<span><b>Checkout</b></span>
									@elseif($reg->verification == 7)	
										<span style="color:red;"><b>@if(session()->has('en')) Rejected @else Tidak diterima @endif</b></span>
									@endif
									</td>
									<td style="vertical-align: middle" align="center">
										<button type="button" class="button" id="btn_reg{{$reg->id_daftar}}">@if(session()->has('en')) Details @else Rincian @endif</button>
									</td>
								</tr>
								<!-- MODAL UNTUK EDIT PERIODE -->
								<style type="text/css">
									/* The Close Button */
								.close_reg{{$reg->id_daftar}} {
									color: white;
									float: right;
									font-size: 28px;
									font-weight: bold;
								}

								.close_reg{{$reg->id_daftar}}:hover,
								.close_reg{{$reg->id_daftar}}:focus {
									color: #000;
									text-decoration: none;
									cursor: pointer;
								}
								</style>
								<!-- Modal untuk rincian -->
								<div id="myModal_reg{{$reg->id_daftar}}" class="modal">

									<!-- Modal content -->
									<div class="modal-content">
										<div class="modal-header">
										  <span class="close_reg{{$reg->id_daftar}}">&times;</span>
										  <h3><b>@if(session()->has('en')) Registration Details @else Rincian Pendaftaran @endif</b></h3>
										</div><br>
										<div class="modal-body">
											<div class="row">
												<div class="col-md-6">
													<p><span style="display: inline-block; width: 150px;">@if(session()->has('en')) Name @else Nama @endif</span><b>: {{DormAuth::User()->name}}</b><br>
											  	  	<span style="display: inline-block; width: 150px;">@if(session()->has('en')) Reg. Date @else Tanggal Daftar @endif</span>: {{ITBdorm::DateTime($reg->created_at)}}<br>
											  	  	<span style="display: inline-block; width: 150px;">@if(session()->has('en')) Dorm Location @else Lokasi Asrama @endif</span>: {{$reg->lokasi_asrama}}<br>
													<span style="display: inline-block; width: 150px;">@if(session()->has('en')) Entry Date @else Tanggal Masuk @endif</span>: {{ITBdorm::Date($reg->tanggal_masuk)}}<br>
											  	  	<span style="display: inline-block; width: 150px;">@if(session()->has('en')) Disability @else Disabilitas @endif</span>: 
											  	  	@if($reg->is_difable == 1)
											  	  	 	@if(session()->has('en')) Yes @else Ya @endif
											  	  	@else
											  	  		@if(session()->has('en')) No @else Tidak @endif
											  	  	@endif <br></p>
												</div>
												<div class="col-md-6">
											  	  	@if($reg->verification == 0)
											  	  		<span style="display: inline-block; width: 150px;">Status</span>: @if(session()->has('en')) Waiting for being verified @else Menunggu Verifikasi @endif<br>
											  	  	@elseif($reg->verification == 1 || $reg->verification == 5)
											  	  		@if($reg->verification == 1)
											  	  			<span style="display: inline-block; width: 150px;">Status</span>: <span style="color:green;"><b>@if(session()->has('en')) Accepted @else Diterima @endif</b></span><br>
											  	  		@elseif($reg->verification == 5)
											  	  			<span style="display: inline-block; width: 150px;">Status</span>: <span style="color:green;"><b>@if(session()->has('en')) Active @else Aktif @endif</b></span><br>
											  	  		@elseif($reg->id_checout != NULL)
											  	  			<span style="display: inline-block; width: 150px;">Status</span>: <b>Checkout</b></span><br>
														@endif
														@if(ITBdorm::DataRoom($reg->id_kamar)->asrama=="Asrama Jatinangor")
															<span style="display: inline-block; width: 150px;">@if(session()->has('en')) Building @else Gedung @endif</span>: Gedung {{ITBdorm::DataRoom($reg->id_kamar)->gedung}}<br>
														@else
															<span style="display: inline-block; width: 150px;">@if(session()->has('en')) Dormitory @else Asrama @endif</span>: {{ITBdorm::DataRoom($reg->id_kamar)->asrama}}<br>
														@endif
											  	  		<span style="display: inline-block; width: 150px;">@if(session()->has('en')) Room @else Kamar @endif</span>: {{ITBdorm::DataRoom($reg->id_kamar)->kamar}}<br>
											  	  		<span style="display: inline-block; width: 150px;">@if(session()->has('en')) Billing Amount @else Total Tagihan @endif</span>: {{ITBdorm::Currency($reg->jumlah_tagihan)}}<b></b><br>
											  	  		@if($reg->total != NULL)
											  	  			<span style="display: inline-block; width: 150px;">@if(session()->has('en')) Total Payments @else Total Pembayaran @endif</span>: {{ITBdorm::Currency($reg->total)}}<b></b><br>
											  	  		@else
											  	  			<span style="display: inline-block; width: 150px;">@if(session()->has('en')) Total Payments @else Total Pembayaran @endif</span>: Rp0,00<b></b><br>
											  	  		@endif
											  	  		@if($reg->total - $reg->jumlah_tagihan < 0)
											  	  			<span style="display: inline-block; width: 150px;">@if(session()->has('en')) Statement @else Keterangan @endif</span>: <span style="color:red;"><b>@if(session()->has('en')) Indebted @else Belum Lunas @endif</b></span><br>
											  	  		@else
											  	  			<span style="display: inline-block; width: 150px;">Keterangan</span>: <span style="color:green;"><b>@if(session()->has('en')) Fully Paid @else Lunas @endif</b></span><br>
											  	  		@endif
											  	  	@elseif($reg->verification == 2)
											  	  		<span style="display: inline-block; width: 150px;">Status</span>: <span style="color:red"><b>@if(session()->has('en')) Abandoned @else Dibatalkan @endif</b></span><br>
													@elseif($reg->verification == 3)
														<span style="display: inline-block; width: 150px;">Status</span>: <span style="color:red"><b>Black List</b></span><br>
													@elseif($reg->verification == 4)
														<span style="display: inline-block; width: 150px;">Status</span>: <span><b>Waiting List</b></span><br>
													@elseif($reg->verification == 7)
														<span style="display: inline-block; width: 150px;">Status</span>: <span style="color:red"><b>@if(session()->has('en')) Rejected @else Tidak Diterima @endif</b></span><br>
													@endif
												</div>
											</div><hr>
											@if($reg->verification == 0)
												<form method="POST" action="{{ route('edit_daftar_reguler') }}">
													{{ csrf_field() }}
													<input type="hidden" name="id_daftar" value="{{ $reg->id_daftar }}">
													<input type="hidden" name="id_periode" value="{{ $reg->id_periode }}">
													<button type="submit" class="button">Edit</button>
													<button type="button" class="button-close" id="btn_batal{{$reg->id_daftar}}">@if(session()->has('en')) Abandon @else Batalkan @endif</button>
													<br><br>
												</form>
											@elseif($reg->verification == 1)
												<form method="POST" action="{{ route('edit_daftar_reguler') }}">
													{{ csrf_field() }}
													<input type="hidden" name="id_daftar" value="{{ $reg->id_daftar }}">
													<input type="hidden" name="id_periode" value="{{ $reg->id_periode }}">
													<button type="button" class="button-close" id="btn_batal{{$reg->id_daftar}}">@if(session()->has('en')) Abandon @else Batalkan @endif</button>
													<button type="button" class="button"><a style="text-decoration:none; color:white" href="{{route('generate_file')}}">@if(session()->has('en')) Print Data @else Cetak Berkas @endif</a></button>
													<br><br>
												</form>
											@elseif($reg->verification == 5)
												@if($reg->total - $reg->jumlah_tagihan >= 0)
													<form method="POST" action="{{ route('batal_verif_non_reguler') }}">
														{{ csrf_field() }}
														<input type="hidden" name="id_daftar" value="{{ $reg->id_daftar }}">
														<input type="hidden" name="id_periode" value="{{ $reg->id_periode }}">
														<button type="button" class="button"><a style="text-decoration:none; color:white" href="{{route('generate_file')}}">@if(session()->has('en')) Print Data @else Cetak Berkas @endif</a></button>
													</form>
												@else
													<form method="GET" action="{{ route('pembayaran_penghuni') }}">
														{{ csrf_field() }}
														<input type="hidden" name="id_daftar" value="{{ $reg->id_daftar }}">
														<input type="hidden" name="id_periode" value="{{ $reg->id_periode }}">
														<button type="submit" class="button">@if(session()->has('en')) Payments @else Pembayaran @endif</button>
														<button type="button" class="button"><a style="text-decoration:none; color:white" href="{{route('generate_file')}}">@if(session()->has('en')) Print Data @else Cetak Berkas @endif</a></button>
													</form>
												@endif
												<br><br>
											@endif
											@if($reg->verification == 0)
												@if(session()->has('en')) 
													<i>Your registration is now under review. You can still edit your data in case you have blunders or abandone the registration at this session.</i>
												@else
													<i>Pendaftaran sendang diproses untuk verifikasi. Anda masih bisa melakukan pengeditan pendaftaran apabila terdapat kesalahan pengisian ataupun melakukan pembatalan pendaftaran pada fase ini.</i>
												@endif
											@elseif($reg->verification == 1)
												@if(session()->has('en')) 
													<i>Your application has succesfully been reviewed. Please proceed to payment for finishing the administration process. If you find any mistake on your data, please let us know to repair them immediately.</i>
												@else
													<i>Status pendaftaran Anda sudah disetujui. Silahkan kan melakukan pembayaran sesuai instruksi yang ada. Pembatalan bisa dilakukan sampai pembayaran dilakukan. Apabila terdapat kesalahan data, silahkan laporkan kasusnya ke sekretariat untuk ditindaklanjuti.</i>
												@endif
											@elseif($reg->verification == 2)
											<i>@if(session()->has('en')) The registration has abandoned @else Pendaftaran ini sudah dibatalkan @endif</i>
											@elseif($reg->verification == 5)
											<i>@if(session()->has('en')) You have already checked in! @else Proses checkin sudah dilakukan untuk pendaftaran ini. @endif</i>
											@else
											<i>@if(session()->has('en')) You have already checked out! @else Proses checkout sudah dilakukan untuk pendaftaran ini. @endif</i>
											@endif
										</div>
									</div>
								</div>

								<script>
								// Get the modal
								var modal_reg{{$reg->id_daftar}} = document.getElementById('myModal_reg{{$reg->id_daftar}}');

								// Get the button that opens the modal
								var btn_reg{{$reg->id_daftar}} = document.getElementById("btn_reg{{$reg->id_daftar}}");

								// Get the <span> element that closes the modal
								var span_reg{{$reg->id_daftar}} = document.getElementsByClassName("close_reg{{$reg->id_daftar}}")[0];

								// When the user clicks the button, open the modal 
								btn_reg{{$reg->id_daftar}}.onclick = function() {
									modal_reg{{$reg->id_daftar}}.style.display = "block";
								}

								// When the user clicks on <span> (x), close the modal
								span_reg{{$reg->id_daftar}}.onclick = function() {
									modal_reg{{$reg->id_daftar}}.style.display = "none";
								}

								// When the user clicks anywhere outside of the modal, close it
								window.onclick = function(event) {
									if (event.target == modal_reg{{$reg->id_daftar}}) {
										modal_reg{{$reg->id_daftar}}.style.display = "none";
									}
								}
								</script>

								<style type="text/css">
										/* The Close Button */
								.close_batal{{$reg->id_daftar}} {
									color: white;
									float: right;
									font-size: 28px;
									font-weight: bold;
								}

								.close_batal{{$reg->id_daftar}}:hover,
								.close_batal{{$reg->id_daftar}}:focus {
									color: #000;
									text-decoration: none;
									cursor: pointer;
								}
								</style>
								<!-- Modal Pembatalan -->
								<div id="myModal_batal{{$reg->id_daftar}}" class="modal">

									<!-- Modal content -->
									<div class="modal-content-batal">
										<div class="modal-header">
											<span class="close_batal{{$reg->id_daftar}}">&times;</span>
											<h3><b>@if(session()->has('en')) Confirm Your Cancellation @else Konfirmasi Pembatalan @endif</b></h3>
										</div><br>
										<div class="modal-body">
											<div class="row">
												<div class="col-md-12">
													<p>@if(session()->has('en')) Are you sure with this cancellation? @else Apakah kamu yakin akan membatalkan pendaftaran ini? @endif</p>
												</div>
											</div>
											<hr>
											<div> 
												@if($reg->verification == 0)
												<form method="POST" action="{{ route('submit_batal_reguler') }}">
													{{ csrf_field() }}
													<input type="hidden" name="id_daftar" value="{{ $reg->id_daftar }}">
													<input type="hidden" name="id_periode" value="{{ $reg->id_periode }}">
													<button type="button" class="button" id="btn_keluar{{$reg->id_daftar}}">@if(session()->has('en')) No, Thanks! @else Keluar @endif</button>
													<button type="submit" class="button-close">@if(session()->has('en')) Yes, Proceed! @else Lanjutkan batal @endif</button>
												</form>
												@elseif($reg->verification == 1)
												<form method="POST" action="{{ route('batal_verif_reguler') }}">
													{{ csrf_field() }}
													<input type="hidden" name="id_daftar" value="{{ $reg->id_daftar }}">
													<input type="hidden" name="id_periode" value="{{ $reg->id_periode }}">
													<button type="button" class="button" id="btn_keluar{{$reg->id_daftar}}">@if(session()->has('en')) No, Thanks! @else Keluar @endif</button>
													<button type="submit" class="button-close">@if(session()->has('en')) Yes, Proceed! @else Lanjutkan batal @endif</button>
												</form>
												@endif
											</div>
										</div>
									</div>
								</div>
								<script>
									// Get the modal
									var modal_batal{{$reg->id_daftar}} = document.getElementById('myModal_batal{{$reg->id_daftar}}');
	
									// Get the button that opens the modal
									var btn_batal{{$reg->id_daftar}} = document.getElementById("btn_batal{{$reg->id_daftar}}");
	
									// Get the <span> element that closes the modal
									var span_batal{{$reg->id_daftar}} = document.getElementsByClassName("close_batal{{$reg->id_daftar}}")[0];
	
									// When the user clicks the button, open the modal 
									btn_batal{{$reg->id_daftar}}.onclick = function() {
										modal_batal{{$reg->id_daftar}}.style.display = "block";
									}
									
									btn_keluar{{$reg->id_daftar}}.onclick = function() {
										modal_batal{{$reg->id_daftar}}.style.display = "none";
									}

									// When the user clicks on <span> (x), close the modal
									span_batal{{$reg->id_daftar}}.onclick = function() {
										modal_batal{{$reg->id_daftar}}.style.display = "none";
									}
	
									// When the user clicks anywhere outside of the modal, close it
									window.onclick = function(event) {
										if (event.target == modal_batal{{$reg->id_daftar}}) {
											modal_batal{{$reg->id_daftar}}.style.display = "none";
										}
									}
								</script>
		
								<?php $i += 1; ?>
								@endforeach
							</table>
						</div>
					@else
						@if(session()->has('en')) There is no regular registration history for now @else Belum ada riwayat pendaftaran reguler hingga saat ini. @endif 
					@endif
					<br><br>
					<h3><b>@if(session()->has('en')) Non-Regular Registration History @else Riwayat Pendaftaran Penghuni Non Reguler @endif </b></h3> 
						@if($countNonReg > 0)
						<div class="table">
							<table>
								<tr>
									<th>No.</th>
									<th>@if(session()->has('en')) Purpose @else Keperluan @endif</th>
									<th>@if(session()->has('en')) Reg. Date @else Tanggal Daftar @endif</th>
									<th>Status</th>
									<th>@if(session()->has('en')) Action @else Aksi @endif</th>
								</tr>
								<?php $a = 1; $b = 1;?>
								@foreach($nonReguler as $non)
								<tr>
									<td>{{$a}}.</td>
									<td>{{$non->tujuan_tinggal}}</td>
									<td>{{ITBdorm::DateTime($non->created_at)}}</td>
									<td>
									@if($non->verification == 0)
									  	@if(session()->has('en')) Waiting for being verified @else Menunggu verifikasi @endif
									@elseif($non->verification == 1)
							  	  		@if($non->id_checkout == NULL)
							  	  			<span style="color:green;"><b>@if(session()->has('en')) Accepted @else Diterima @endif</b></span>
							  	  		@else
							  	  			Checkout
							  	  		@endif
									@elseif($non->verification == 2)
										<span style="color:red;"><b>@if(session()->has('en')) Abandoned @else Dibatalkan @endif</b></span>
									@elseif($non->verification == 3)	
										<span style="color:red;"><b>Black List</b></span>
									@elseif($non->verification == 4)	
										<span><b>Waiting List</b></span>
									@elseif($non->verification == 5)	
										<span style="color:green;"><b>@if(session()->has('en')) Active @else Aktif @endif</b></span>
									@elseif($non->verification == 6)	
										<span><b>Checkout</b></span>
									@elseif($non->verification == 7)	
										<span style="color:red;"><b>@if(session()->has('en')) Rejected @else Tidak Diterima @endif</b></span>
									@endif
									</td>
									<td>
										<button type="button" class="button" id="btn{{$non->id_daftar}}">@if(session()->has('en')) Details @else Rincian @endif</button>
									</td>
								</tr>
								<!-- MODAL UNTUK EDIT PERIODE -->
								<style type="text/css">
									/* The Close Button */
								.close{{$non->id_daftar}} {
									color: white;
									float: right;
									font-size: 28px;
									font-weight: bold;
								}

								.close{{$non->id_daftar}}:hover,
								.close{{$non->id_daftar}}:focus {
									color: #000;
									text-decoration: none;
									cursor: pointer;
								}
								</style>
								<div id="myModal{{$non->id_daftar}}" class="modal">

								  <!-- Modal content -->
								  <div class="modal-content">
									<div class="modal-header">
									  <span class="close{{$non->id_daftar}}">&times;</span>
									  <h3><b>@if(session()->has('en')) Registration Details @else Rincian Pendaftaran @endif</b></h3>
									</div><br>
									<div class="modal-body">
										<div class="row">
											<div class="col-md-6">
												<p><span style="display: inline-block; width: 150px;">@if(session()->has('en')) Name @else nama @endif</span><b>: {{DormAuth::User()->name}}</b><br>
										  	  	<span style="display: inline-block; width: 150px;">@if(session()->has('en')) Reg. Date @else Tanggal Daftar @endif</span>: {{ITBdorm::DateTime($non->created_at)}}<br>
										  	  	<span style="display: inline-block; width: 150px;">@if(session()->has('en')) Purpose @else Keperluan @endif</span>: {{$non->tujuan_tinggal}}<br>
										  	  	<span style="display: inline-block; width: 150px;">@if(session()->has('en')) Dorm Location @else Lokasi Asrama @endif</span>: {{$non->lokasi_asrama}}<br>
										  	  	@if($non->preference == 1)
										  	  		<span style="display: inline-block; width: 150px;">Preference</span>: @if(session()->has('en')) Alone @else Sendirian @endif<br>
										  	  	@elseif($non->preference == 2)
										  	  		<span style="display: inline-block; width: 150px;">Preference</span>: @if(session()->has('en')) Two Persons @else Berdua @endif<br>
										  	  	@else
										  	  		<span style="display: inline-block; width: 150px;">Preference</span>: @if(session()->has('en')) Three Persons @else Bertiga @endif<br>
										  	  	@endif
										  	  	<span style="display: inline-block; width: 150px;">Tempo</span>: @if($non->tempo == 'harian')
										  	  		@if(session()->has('en')) Days @else Harian @endif
										  	  	@else
										  	  		@if(session()->has('en')) Months @else Bulanan @endif
										  	  	@endif<br>
										  	  	<span style="display: inline-block; width: 150px;">@if(session()->has('en')) Amount of days/months @else Jumlah hari/bulan @endif</span>:
										  	  	@if($non->tempo == 'harian')
										  	  		{{$non->lama_tinggal}} @if(session()->has('en')) day(s) @else hari @endif
										  	  	@else
										  	  		{{$non->lama_tinggal}} @if(session()->has('en')) month(s) @else bulan @endif
										  	  	@endif <br></p>
											</div>
											<div class="col-md-6">
												<span style="display: inline-block; width: 150px;">@if(session()->has('en')) Entry Date @else Tanggal Masuk @endif</span>: {{ITBdorm::Date($non->tanggal_masuk)}}<br>
										  	  	<span style="display: inline-block; width: 150px;">@if(session()->has('en')) Specific Needs @else Kebutuhan Khusus @endif</span>: 
										  	  	@if($non->is_difable == 1)
										  	  	 	@if(session()->has('en')) Yes @else Ya @endif
										  	  	@else
										  	  		@if(session()->has('en')) No @else Tidak @endif
										  	  	@endif <br>
										  	  	<span style="display: inline-block; width: 150px;">@if(session()->has('en')) The Specific Need Details @else Rincian Kebutuhan Khusus @endif</span>:
										  	  	 {{$non->ket_difable}}<br>
										  	  	@if($non->verification == 0)
										  	  		<span style="display: inline-block; width: 150px;">Status</span>: @if(session()->has('en')) Waiting for being verified @else Menunggu Verifikasi @endif<br>
										  	  	@elseif($non->verification == 1 || $non->verification == 5)
										  	  		@if($non->verification == 1)
										  	  			<span style="display: inline-block; width: 150px;">Status</span>: <span style="color:green;"><b>@if(session()->has('en')) Accepted @else Diterima @endif</b></span><br>
										  	  		@elseif($non->verification == 5)
										  	  			<span style="display: inline-block; width: 150px;">Status</span>: <span style="color:green;"><b>@if(session()->has('en')) Active @else aktif @endif</b></span><br>
										  	  		@elseif($non->id_checout != NULL)
										  	  			<span style="display: inline-block; width: 150px;">Status</span>: <b>Checkout</b></span><br>
										  	  		@endif
										  	  		@if(ITBdorm::DataRoom($non->id_kamar)->asrama=="Asrama Jatinangor")
														<span style="display: inline-block; width: 150px;">@if(session()->has('en')) Building @else Gedung @endif</span>: Gedung {{ITBdorm::DataRoom($non->id_kamar)->gedung}}<br>
													@else
														<span style="display: inline-block; width: 150px;">@if(session()->has('en')) Dormitory @else Asrama @endif</span>: {{ITBdorm::DataRoom($non->id_kamar)->asrama}}<br>
													@endif
										  	  		<span style="display: inline-block; width: 150px;">@if(session()->has('en')) Room @else Kamar @endif</span>: {{ITBdorm::DataRoom($non->id_kamar)->kamar}}<br>
										  	  		<span style="display: inline-block; width: 150px;">@if(session()->has('en')) Billing Amount @else Total Tagihan @endif</span>: {{ITBdorm::Currency($non->jumlah_tagihan)}}<b></b><br>
										  	  		@if($non->total != NULL)
										  	  			<span style="display: inline-block; width: 150px;">@if(session()->has('en')) Total Payments @else Total Pembayaran @endif</span>: {{ITBdorm::Currency($non->total)}}<b></b><br>
										  	  		@else
										  	  			<span style="display: inline-block; width: 150px;">@if(session()->has('en')) Total Payments @else Total Pembayaran @endif</span>: Rp0,00<b></b><br>
										  	  		@endif
										  	  		@if($non->total - $non->jumlah_tagihan < 0)
										  	  			<span style="display: inline-block; width: 150px;">@if(session()->has('en')) Statement @else Keterangan @endif</span>: <span style="color:red;"><b>@if(session()->has('en')) Indebted @else Belum Lunas @endif</b></span><br>
										  	  		@else
										  	  			<span style="display: inline-block; width: 150px;">@if(session()->has('en')) Statement @else Keterangan @endif</span>: <span style="color:green;"><b>@if(session()->has('en')) Fully Paid @else Lunas @endif</b></span><br>
										  	  		@endif
										  	  		<?php $b += 1; ?>
										  	  	@elseif($non->verification == 2)
										  	  		<span style="display: inline-block; width: 150px;">Status</span>: <span style="color:red"><b>@if(session()->has('en')) Abandoned @else Dibatalkan @endif</b></span><br>
												@elseif($non->verification == 3)
													<span style="display: inline-block; width: 150px;">Status</span>: <span style="color:red"><b>Black List</b></span><br>
												@elseif($non->verification == 4)
													<span style="display: inline-block; width: 150px;">Status</span>: <span><b>Waiting List</b></span><br>
												@elseif($non->verification == 5)
													<span style="display: inline-block; width: 150px;">Status</span>: <span style="color:red"><b>@if(session()->has('en')) Rejected @else Tidak Diterima @endif</b></span><br>
												@endif
											</div>
										</div><hr>
										@if($non->verification == 0)
											<form method="POST" action="{{ route('edit_daftar_non_reguler') }}">
												{{ csrf_field() }}
												<input type="hidden" name="id_daftar" value="{{ $non->id_daftar }}">
												<button type="submit" class="button">@if(session()->has('en')) Edit @else Ubah @endif</button>
												<button type="button" class="button-close" id="btn_non_batal{{$non->id_daftar}}">@if(session()->has('en')) Abandon @else Batalkan @endif</button>
												<br><br>
											</form>
										@elseif($non->verification == 1)
											<form method="POST" action="{{ route('SuratPerjanjianNonReguler') }}">
												{{ csrf_field() }}
												<input type="hidden" name="id_daftar" value="{{ $non->id_daftar }}">
												<button type="button" class="button-close" id="btn_non_batal{{$non->id_daftar}}">@if(session()->has('en')) Abandon @else Batalkan @endif</button>
												<button type="submit" class="button">@if(session()->has('en')) Print File @else Cetak Berkas @endif</button>
											</form>
											<br><br>
										@elseif($non->verification == 5)
										<form method="POST" action="{{ route('SuratPerjanjianNonReguler') }}">
											{{ csrf_field() }}
											<input type="hidden" name="id_daftar" value="{{ $non->id_daftar }}">
											<button type="submit" class="button">@if(session()->has('en')) Print File @else Cetak Berkas @endif</button>
										</form><br><br>	
										@endif
										@if($non->verification == 0)
											@if(session()->has('en')) 
												<i>Your registration is now under review. You can still edit your data in case you have blunders or abandone the registration at this session.</i>
											@else
												<i>Pendaftaran sendang diproses untuk verifikasi. Anda masih bisa melakukan pengeditan pendaftaran apabila terdapat kesalahan pengisian ataupun melakukan pembatalan pendaftaran pada fase ini.</i>
											@endif
										@elseif($non->verification == 1)
											@if(session()->has('en')) 
												<i>Your application has succesfully been reviewed. Please proceed to payment for finishing the administration process. If you find any mistake on your data, please let us know to repair them immediately.</i>
											@else
												<i>Status pendaftaran Anda sudah disetujui. Silahkan kan melakukan pembayaran sesuai instruksi yang ada. Pembatalan bisa dilakukan sampai pembayaran dilakukan. Apabila terdapat kesalahan data, silahkan laporkan kasusnya ke sekretariat untuk ditindaklanjuti.</i>
											@endif
										@elseif($non->verification == 2)
										<i>@if(session()->has('en')) The registration has abandoned @else Pendaftaran ini sudah dibatalkan @endif</i>
										@elseif($non->verification == 5)
										<i>@if(session()->has('en')) You have already checked in! @else Proses checkin sudah dilakukan untuk pendaftaran ini. @endif</i>
										@else
										<i>@if(session()->has('en')) You have already checked out! @else Proses checkout sudah dilakukan untuk pendaftaran ini. @endif</i>
										@endif
									</div>
								  </div>

								</div>
								<script>
								// Get the modal
								var modal{{$non->id_daftar}} = document.getElementById('myModal{{$non->id_daftar}}');

								// Get the button that opens the modal
								var btn{{$non->id_daftar}} = document.getElementById("btn{{$non->id_daftar}}");

								// Get the <span> element that closes the modal
								var span{{$non->id_daftar}} = document.getElementsByClassName("close{{$non->id_daftar}}")[0];

								// When the user clicks the button, open the modal 
								btn{{$non->id_daftar}}.onclick = function() {
									modal{{$non->id_daftar}}.style.display = "block";
								}

								// When the user clicks on <span> (x), close the modal
								span{{$non->id_daftar}}.onclick = function() {
									modal{{$non->id_daftar}}.style.display = "none";
								}

								// When the user clicks anywhere outside of the modal, close it
								window.onclick = function(event) {
									if (event.target == modal{{$non->id_daftar}}) {
										modal{{$non->id_daftar}}.style.display = "none";
									}
								}
								</script>

								<!-- PEMBATALAN -->
								<style type="text/css">
									/* The Close Button */
								.close_non_batal{{$non->id_daftar}} {
								color: white;
								float: right;
								font-size: 28px;
								font-weight: bold;
								}

								.close_non_batal{{$non->id_daftar}}:hover,
								.close_non_batal{{$non->id_daftar}}:focus {
								color: #000;
								text-decoration: none;
								cursor: pointer;
								}
								</style>
								<!-- Modal Pembatalan -->
								<div id="myModal_non_batal{{$non->id_daftar}}" class="modal">

									<!-- Modal content -->
									<div class="modal-content-batal">
										<div class="modal-header">
												<span class="close_non_batal{{$non->id_daftar}}">&times;</span>
												<h3><b>@if(session()->has('en')) Confirm Your Cancellation @else Konfirmasi Pembatalan @endif</b></h3>
										</div><br>
										<div class="modal-body">
											<div class="row">
												<div class="col-md-12">
													<p>@if(session()->has('en')) Are You sure with this cancellation? @else Apakah Anda yakin akan membatalkan pendaftaran ini? @endif</p>
												</div>
											</div>
											<hr>
											@if($non->verification == 0)
											<form method="POST" action="{{ route('submit_batal_non_reguler') }}">
												{{ csrf_field() }}
												<input type="hidden" name="id_daftar" value="{{ $non->id_daftar }}">
												<button type="button" class="button" id="btn_non_keluar{{$non->id_daftar}}">@if(session()->has('en')) No, Thanks! @else Keluar @endif</button>
												<button type="submit" class="button-close">@if(session()->has('en')) Yes, Proceed! @else Batalkan @endif</button>
											</form>
											@elseif($non->verification == 1) 
											<form method="POST" action="{{ route('batal_verif_non_reguler') }}">
												{{ csrf_field() }}
												<input type="hidden" name="id_daftar" value="{{ $non->id_daftar }}">
												<button type="button" class="button" id="btn_non_keluar{{$non->id_daftar}}">@if(session()->has('en')) No, Thanks! @else Keluar @endif</button>
												<button type="submit" class="button-close">@if(session()->has('en')) Yes, Proceed! @else Batalkan @endif</button>
											</form>
											@endif
										</div> 
									</div>
								</div>
								<script>
								// Get the modal
								var modal_non_batal{{$non->id_daftar}} = document.getElementById('myModal_non_batal{{$non->id_daftar}}');

								// Get the button that opens the modal
								var btn_non_batal{{$non->id_daftar}} = document.getElementById("btn_non_batal{{$non->id_daftar}}");

								// Get the <span> element that closes the modal
								var span_non_batal{{$non->id_daftar}} = document.getElementsByClassName("close_non_batal{{$non->id_daftar}}")[0];

								// When the user clicks the button, open the modal 
								btn_non_batal{{$non->id_daftar}}.onclick = function() {
									modal_non_batal{{$non->id_daftar}}.style.display = "block";
								}

								btn_non_keluar{{$non->id_daftar}}.onclick = function() {
									modal_non_batal{{$non->id_daftar}}.style.display = "none";
								}

								// When the user clicks on <span> (x), close the modal
								span_non_batal{{$non->id_daftar}}.onclick = function() {
									modal_non_batal{{$non->id_daftar}}.style.display = "none";
								}

								// When the user clicks anywhere outside of the modal, close it
								window.onclick = function(event) {
									if (event.target == modal_non_batal{{$non->id_daftar}}) {
										modal_non_batal{{$non->id_daftar}}.style.display = "none";
									}
								}
								</script>
								<?php $a += 1; ?>
								@endforeach
							</table>
						</div>
					@else
						@if(session()->has('en')) There is no non-reguler registration history for now. @else Belum ada riwayat pendaftaran non reguler hingga saat ini. @endif 
					@endif<br><br>
					<h2><b>@if(session()->has('en')) Available Registration Periode @else Periode Pendaftaran Tersedia @endif</b></h2>
					<div class="row">
						<div class="col-md-6" style="text-align: center;">
							<h3><b>@if(session()->has('en')) The Non-Regular Registration @else Pendaftaran Non Reguler @endif</b></h3>
							<div style="text-align: center;"><a href="{{ route('daftar_non_reguler') }}"><button class="button">@if(session()->has('en')) Register Now @else Daftar Sekarang @endif</button></a></div>
						</div>
						<div class="col-md-6" style="text-align: center;">
							<h3><b>@if(session()->has('en')) The Regular Registration @else Pendaftaran Reguler @endif</b></h3>
							@if($pass_periode == 2)
								<p>@if(session()->has('en')) There is no reguler registration for now @else Belum ada pendaftaran reguler untuk saat ini @endif</p>
							@else
								<div style="text-align: center;"><a href="{{route('daftar_reguler')}}"><button class="button">@if(session()->has('en')) Register Now @else Daftar Sekarang @endif</button></a></div>
							@endif
						</div>
					</div>
				@endif
			</div><br><br>
		</div>
		<div class="col-md-3">
			<!-- MENU DASHBOARD -->
			@include('dashboard.menuDashboard')
		</div>
	</div>			
	<br><br><br>
</div>
@endsection

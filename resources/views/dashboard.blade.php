@extends('layouts.app')
@section('content')
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<div id="content">
		<section class="container">
		<div class="col-lg-3">
			<div class="panel panel-info">
				<div class="panel-heading">
					<div class="left">
						<strong>Profile</strong>
					</div>
					<div class="right">
						<a href="{{ route('myprofile') }}">Update <span class="glyphicon glyphicon-cog" aria-hidden="true"></span></a>                        </div>
					<div class="clear"></div>
				</div>
				<div class="panel-body">
					<ul class="profile">
						<li>
							<div class="icon left">
								<span class="glyphicon glyphicon-user" aria-hidden="true"></span>
							</div>
							<div class="content right">
								{{ $user->nama }}</div>
							<div class="clear"></div>
						</li>
						<li>
							<div class="icon left">
								<span class="glyphicon glyphicon-tags" aria-hidden="true"></span>
							</div>
							<div class="content right">
								{{ $user->nim }}
							</div>
							<div class="clear"></div>
						</li>
						<li>
							<div class="icon left">
								<span class="glyphicon glyphicon-calendar" aria-hidden="true"></span>
							</div>
							<div class="content right">
								@if ($user_penghuni_info != NULL)
									{{ $user_penghuni_info->tempat_lahir }}, {{ $user_penghuni_info->tanggal_lahir }}
								@else
									-
								@endif
							</div>
							<div class="clear"></div>
						</li>
						<li>
							<div class="icon left">
								<span class="glyphicon glyphicon-envelope" aria-hidden="true"></span>
							</div>
							<div class="content right">
								{{ $user->email }}</div>
							<div class="clear"></div>
						</li>
						<li>
							<div class="icon left">
								<span class="glyphicon glyphicon-phone-alt" aria-hidden="true"></span>
							</div>
							<div class="content right">
								@if ($user_penghuni_info != NULL)
									{{ $user_penghuni_info->telepon }}
								@else
									-
								@endif
							</div>
							<div class="clear"></div>
						</li>
						<li>
							<div class="icon left">
								<span class="glyphicon glyphicon-home" aria-hidden="true"></span>
							</div>
							<div class="content right">
								@if ($user_penghuni_info != NULL)
									{{ $user_penghuni_info->instansi }}
								@else
									-
								@endif
							</div>
							<div class="clear"></div>
						</li>
					</ul>
				</div>
			</div>
			<div class="panel panel-info">
				<div class="panel-heading"><strong><span class="glyphicon glyphicon-signal" aria-hidden="true"></span> Statistik</strong></div>
				<div class="panel-body">
					<div class="tab-content">
						@if ($user->is_penghuni == '1')
						<div id="statistik_penghuni" class="tab-pane fade in active">
							<h5><strong>Statistik Penghuni</strong></h5>
							<div class="row">
								<div class="col-sm-6 col-sm-offset-1" style="padding-right:0px">Jmlh pendaftaran</div>
								<div class="col-sm-4">: {{ ($user_daftar)? count($user_daftar) : 0 }}</div>
							</div>
						</div>
						@endif
						@if ($user->is_pengelola == '1')
						<div id="statistik_pengelola" class="tab-pane fade">
							<h5><strong>{{ $nama_asrama }}</strong></h5>
							<h5><strong>Statistik Asrama</strong></h5>
							<h6><strong>Total Pendaftar</strong></h6>
							<div class="row">
								<div class="col-sm-6 col-sm-offset-1" style="padding-right:0px">Reguler</div>
								<div class="col-sm-4">: {{ $count_pendaftar_reguler }}</div>
							</div>
							<div class="row">
								<div class="col-sm-6 col-sm-offset-1" style="padding-right:0px">Non-Reguler</div>
								<div class="col-sm-4">: {{ $count_pendaftar_non_reguler }}</div>
							</div>
							<h6><strong>Total Penghuni</strong></h6>
							<div class="row">
								<div class="col-sm-6 col-sm-offset-1" style="padding-right:0px">Penghuni aktif</div>
								<div class="col-sm-4">: {{ $jumlah_penghuni }}</div>
							</div>

							<h5><strong>Statistik Kamar</strong></h5>
							<div class="row">
								<div class="col-sm-6 col-sm-offset-1" style="padding-right:0px">Dihuni</div>
								<div class="col-sm-4">: {{ $kamar_dihuni }}</div>
							</div>
							<div class="row">
								<div class="col-sm-6 col-sm-offset-1" style="padding-right:0px">Rusak</div>
								<div class="col-sm-4">: {{ $kamar_rusak[0]->jumlah }}</div>
							</div>
							<div class="row">
								<div class="col-sm-6 col-sm-offset-1" style="padding-right:0px">Kosong</div>
								<div class="col-sm-4">: {{ $kamar_kosong }}</div>
							</div>
							<h5><strong>Laporan Kerusakan Kamar</strong></h5>
							<div class="row">
								<div class="col-sm-6 col-sm-offset-1" style="padding-right:0px">Unresolved</div>
								<div class="col-sm-4">: {{ ($laporan_belum_ditangani)? count($laporan_belum_ditangani) : 0 }}</div>
							</div>
							<div class="row">
								<div class="col-sm-6 col-sm-offset-1" style="padding-right:0px">Total laporan</div>
								<div class="col-sm-4">: {{ ($laporan)? count($laporan) : 0 }}</div>
							</div>
						</div>
						@endif
						@if ($user->is_sekretariat == '1')
						<div id="statistik_sekretariat" class="tab-pane fade">
							<h5><strong>Statistik Sekretariat</strong></h5>
							<i>To be defined.</i>
						</div>
						@endif
						@if ($user->is_pimpinan == '1')
						<div id="statistik_pimpinan" class="tab-pane fade">
							<h5><strong>Statistik Pimpinan</strong></h5>
							<i>To be defined.</i>
						</div>
						@endif
						@if ($user->is_admin == '1')
						<div id="statistik_admin" class="tab-pane fade">
							<h5><strong>Statistik Administrator</strong></h5>
							<div class="row">
								<div class="col-sm-6 col-sm-offset-1" style="padding-right:0px">Jumlah user</div>
								<div class="col-sm-4">: {{ $count_user }}</div>
							</div>
						</div>
						@endif
					</div>
				</div>
			</div>
		</div>

		<div class="col-lg-9 bottom20">
		<div class="panel panel-default">
			<ul class="nav nav-tabs">

			@if ($user->is_penghuni == '1')
				<li class="active"><a data-toggle="tab" href="#dash_penghuni" data-target="#dash_penghuni, #statistik_penghuni">Penghuni</a></li>
			@endif
			@if ($user->is_pengelola == '1')
				<li {{ ($user->is_penghuni == 0)? 'class=active' : '' }}><a data-toggle="tab" href="#dash_pengelola" data-target="#dash_pengelola, #statistik_pengelola">Pengelola</a></li>
			@endif
			@if ($user->is_sekretariat == '1')
				<li {{ ($user->is_penghuni == 0 && $user->is_pengelola == 0)? 'class=active' : '' }}><a data-toggle="tab" href="#dash_sekretariat" data-target="#dash_sekretariat, #statistik_sekretariat">Sekretariat</a></li>
			@endif
			@if ($user->is_pimpinan == '1')
				<li {{ ($user->is_penghuni == 0 && $user->is_pengelola == 0 && $user->is_sekretariat == 0)? 'class=active' : '' }}><a data-toggle="tab" href="#dash_pimpinan" data-target="#dash_pimpinan, #statistik_pimpinan">Pimpinan</a></li>
			@endif
			@if ($user->is_admin == '1')
				<li {{ ($user->is_penghuni == 0 && $user->is_pengelola == 0 && $user->is_sekretariat == 0 && $user->is_pimpinan == 0)? 'class=active' : '' }}><a data-toggle="tab" href="#dash_admin" data-target="#dash_admin, #statistik_admin">Administrator</a></li>
			@endif
			</ul>
			<div class="panel-body">
			<div class="tab-content">
				@if ($user->is_penghuni == '1')
				<div id="dash_penghuni" class="tab-pane fade in active">

					<!-- JIKA PENGHUNI -->
						@if (session('mess'))
						    <div class="alert alert-success">
						        {{ session('mess') }}
						    </div>
						@endif
						@if ($is_blacklist)
							<div class="alert alert-danger">
						        Maaf anda terblacklist, silahkan hubungi pengelola asrama.
								<br>Alasan: {{ $is_blacklist->alasan }}
								<br>Anda tidak dapat melakukan:
								<br>1. Pendaftaran asrama
								<br>2. to be defined
						    </div>
						@else
							@if ($user_penghuni_info == NULL)
								<div class="panel panel-danger">
									<div class="panel-heading">
										* Silahkan mengisi <a href="{{ route('edit_penghuni_info') }}">detail informasi penghuni</a> untuk dapat melakukan pendaftaran.
									</div>
								</div>
								<h4 style="font-family: Raleway,sans-serif;">★ Daftar Penghuni Reguler</h4 style="font-family: Raleway,sans-serif;">
								<p>{{ $des_reguler }}</p>
								<h4 style="font-family: Raleway,sans-serif;">★ Daftar Penghuni Non Reguler</h4 style="font-family: Raleway,sans-serif;">
								<p>{{ $des_nonreguler }}</p>
							@elseif ($user_penghuni_info->status_daftar == NULL)
								@if ($user_penghuni_info->pekerjaan == 'Mahasiswa ITB')
									<h4 style="font-family: Raleway,sans-serif;"><a href="/daftar_reguler">★ Daftar Penghuni Reguler</a></h4 style="font-family: Raleway,sans-serif;">
									<p>{{ $des_reguler }}</p>
								@else
									<h4 style="font-family: Raleway,sans-serif;">★ Daftar Penghuni Reguler</h4 style="font-family: Raleway,sans-serif;">
									<p>{{ $des_reguler }}</p>
								@endif
								<h4 style="font-family: Raleway,sans-serif;"><a href="/daftar_non_reguler">★ Daftar Penghuni Non Reguler</a></h4 style="font-family: Raleway,sans-serif;">
								<p>{{ $des_nonreguler }}</p>
							@endif
						@endif

						@if ($is_tombol == '1')
							<p>Periode kepenghunian anda akan berakhir pada tanggal <strong>{{ $tanggal_akhir }}</strong>.</p>
							<p>Apakah anda ingin lanjut ke periode <strong>{{ $periode_lanjut->nama }} ({{ $periode_lanjut->tanggal_awal }} s.d. {{ $periode_lanjut->tanggal_akhir }})</strong> ?</p>
							<a class="btn btn-primary" href="/lanjut_periode/{{ $periode_lanjut->id_periode }}" onclick="event.preventDefault(); document.getElementById('lanjut-periode').submit();"><span class="glyphicon glyphicon-ok" aria-hidden="true"></span> Lanjut</a>
							<form id="lanjut-periode" action="/lanjut_periode/{{ $periode_lanjut->id_periode }}" method="POST" style="display: none;">
                                {{ csrf_field() }}
                            </form>

                            <a class="btn btn-danger" href="/keluar_periode" onclick="event.preventDefault(); document.getElementById('keluar-periode').submit();"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span> Keluar</a>
							<form id="keluar-periode" action="/keluar_periode" method="POST" style="display: none;">
                                {{ csrf_field() }}
                            </form>
                            <br><br>
						@endif

						@if ($pesan_checkin == '1')
							<div class="alert alert-danger">
								Silahkan temui pengelola asrama untuk melakukan checkin.<br>
								Bawa <strong>Surat Perjanjian Asrama Umum</strong> anda.<br>
								<strong>NB</strong>: surat perjanjian asrama umum dapat di-generate pada halaman <a href="/download">download</a>
							</div>
						@endif

						@if ($pesan_checkout == '1')
							<div class="alert alert-danger">
								Silahkan temui pengelola asrama untuk melakukan checkout.<br>
								Bawa <strong>Formulir Keluar Asrama</strong> dan <strong>kunci</strong> anda.<br>
								<strong>NB</strong>: formulir keluar asrama dapat di-generate pada halaman <a href="/download">download</a>
							</div>
						@endif

				        @if ($user_daftar != NULL)
				        <div class="panel panel-default">
				        <div class="panel-heading"><h4>History Pendaftaran</h4></div>
							<table class="table table-striped table-condensed table-hover">
							<thead>
								<tr>
									<th style="width:18%;">Asrama</th>
									<th style="width:10%;">Kamar</th>
									<th style="width:13%;">Tgl Masuk</th>
									<th style="width:13%;">Tgl Keluar</th>
									<th style="width:12%;">Jenis</th>
									<th style="width:14%;">Status Daftar</th>
									<th style="width:22%;">Action</th>
								</tr>
							</thead>
							<tbody>
							@foreach ($user_daftar as $data)
							<tr>
								<td>{{ $data->asrama }}</td>
								<td>{{ $data->nama_kamar }}</td>
								<td>{{ $data->tanggal_masuk }}</td>
								<td>{{ $data->tanggal_keluar }}</td>
								<td>{{ $data->status_penghuni }}</td>
								<td>{{ $data->status }}</td>
								<td>
								@if ($data->status == 'Menunggu')
									@if ($data->status_penghuni == 'Reguler')
										<a class="btn btn-warning btn-xs col-sm-4" href="/edit_daftar_reguler/{{ $data->id_daftar }}">
											<span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
											<br>Update
										</a>
										<a class="btn btn-danger btn-xs col-sm-4" href="{{ route('delete_reguler', ['id_daftar' => $data->id_daftar]) }}" onclick="event.preventDefault(); document.getElementById('delete-reguler').submit();">
											<span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
											<br>Delete
										</a>
										<form id="delete-reguler" action="{{ route('delete_reguler', ['id_daftar' => $data->id_daftar]) }}" method="POST" style="display: none;">
		                                    {{ csrf_field() }}
		                                </form>
									@elseif ($data->status_penghuni == 'Non Reguler')
										<a class="btn btn-warning btn-xs col-sm-4" href="/edit_daftar_non_reguler/{{ $data->id_daftar }}">
											<span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
											<br>Update
										</a>
										<a class="btn btn-danger btn-xs col-sm-4" href="{{ route('delete_non_reguler', ['id_daftar' => $data->id_daftar]) }}" onclick="event.preventDefault(); document.getElementById('delete-nonreguler').submit();">
											<span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
											<br>Delete
										</a>
										<form id="delete-nonreguler" action="{{ route('delete_non_reguler', ['id_daftar' => $data->id_daftar]) }}" method="POST" style="display: none;">
		                                    {{ csrf_field() }}
		                                </form>
									@endif
								@elseif ($data->status == 'Menghuni')
									@if ($data->status_penghuni == 'Reguler')
										<a class="btn btn-warning btn-xs col-sm-4" href="/requestpindah/reguler/{{$data->id_daftar}}" title="Request Pindah">
											<span class="glyphicon glyphicon-remove" aria-hidden="true"></span><br>Pindah
										</a>
										<a class="btn btn-danger btn-xs col-sm-4" href="/requestkeluar/reguler/{{$data->id_daftar}}" title="Request Keluar">
											<span class="glyphicon glyphicon-remove" aria-hidden="true"></span><br>Keluar
										</a>
									@elseif ($data->status_penghuni == 'Non Reguler')
										<a class="btn btn-warning btn-xs col-sm-4" href="/requestpindah/nonreguler/{{$data->id_daftar}}" title="Request Pindah">
											<span class="glyphicon glyphicon-remove" aria-hidden="true"></span><br>Pindah
										</a>
										<a class="btn btn-danger btn-xs col-sm-4" href="/requestkeluar/nonreguler/{{$data->id_daftar}}" title="Request Keluar">
											<span class="glyphicon glyphicon-remove" aria-hidden="true"></span><br>Keluar
										</a>
									@endif
									<a class="btn btn-info btn-xs col-sm-4" href="/kerusakan_kamar/{{$data->id_kamar}}/add" title="Lapor Kerusakan">
										<span class="glyphicon glyphicon-warning-sign" aria-hidden="true"></span><br>Lapor
									</a>
								@elseif ($data->status == 'Teralokasi')
									@if ($data->status_penghuni == 'Reguler')
										<a class="btn btn-xs btn-primary" href="/print/reguler/{{$data->id_daftar}}">Dokumen<br>Check In</a>
									@elseif ($data->status_penghuni == 'Non Reguler')
										<a class="btn btn-xs btn-primary" href="/print/nonreguler/{{$data->id_daftar}}">Dokumen<br>Check In</a>
									@endif
								@elseif ($data->status == 'Lanjut ke periode berikutnya' ||$data->status == 'Tidak Lanjut' || $data->status == 'Disetujui keluar')
									@if ($data->status_penghuni == 'Reguler')
										<a class="btn btn-xs btn-primary" href="/printOut/reguler/{{$data->id_daftar}}">Dokumen<br>Check Out</a>
									@elseif ($data->status_penghuni == 'Non Reguler')
										<a class="btn btn-xs btn-primary" href="/printOut/nonreguler/{{$data->id_daftar}}">Dokumen<br>Check Out</a>
									@endif
								@else
									-
								@endif
								</td>
							</tr>
							@endforeach
							</tbody>
							</table>
						</div>
						@endif
					<!-- END OF JIKA PENGHUNI -->
				</div>
				@endif
				@if ($user->is_pengelola == '1')
				<div id="dash_pengelola" class="tab-pane fade {{ ($user->is_penghuni == 0)? 'in active' : '' }}">
					<!--
					**************************************************
								DASHBOARD PENGELOLA

					**************************************************
					-->
					<div class="row" style="margin: 0px; padding: 4px;">
						<h4>Pengelolaan Asrama Umum</h4>
						<div class="col-md-4 col-md-offset-2">
							<button type="submit" class="btn btn-default" style="height: 100%;" onclick="window.location='{{ route("pendaftaran") }}'">
	                            <img src="img/icon/pendaftaran-icon.png" style="width: 50%;"><br>
	                            Persetujuan Pendaftaran <red style="color:red">*{{ $count_request_daftar }}</red>
	                        </button>
						</div>
						<div class="col-md-4">
							<button type="submit" class="btn btn-default" style="height: 100%;" onclick="window.location='{{ url('/kerusakan_kamar') }}'">
								<img src="img/icon/kerusakan-icon.png" style="width: 50%;"><br>
	                            Manage Kerusakan Kamar <red style="color:red">*{{ ($laporan_belum_ditangani)? count($laporan_belum_ditangani) : 0 }}</red>
	                        </button>
						</div>
					</div>
					<div class="row" style="margin: 0px; padding: 4px;">
						<h4>Pengelolaan Penghuni Reguler</h4>
						<div class="col-md-4">
							<button type="submit" class="btn btn-default" style="height: 100%;" onclick="window.location='{{ route("alokasi.index") }}'">
	                            <img src="img/icon/alokasi-icon.png" style="width: 50%;"><br>
	                            Manage Alokasi <red style="color:red">*{{ $count_alokasi_reguler }}</red>
	                        </button>
						</div>
						<div class="col-md-4">
							<button type="submit" class="btn btn-default" style="height: 100%;" onclick="window.location='{{ url('/autoalokasi') }}'">
	                            <img src="img/icon/alokasi-otomatis-icon.png" style="width: 50%;"><br>
	                            Alokasi Otomatis
	                        </button>
						</div>
						<div class="col-md-4">
							<button type="submit" class="btn btn-default" style="height: 100%;" onclick="window.location='{{ url('/manage/reguler') }}'">
	                            <img src="img/icon/check-in-icon.png" style="width: 50%;"><br>
	                            Check In <red style="color:red">*{{$count_checkin_reguler}}</red> / Check Out <red style="color:red">*{{$count_checkout_reguler}}</red>
	                        </button>
						</div>
					</div>
					<div class="row" style="margin: 0px; padding: 4px;">
						<h4>Pengelolaan Penghuni Non-Reguler</h4>
						<div class="col-md-4 col-md-offset-2">
							<button type="submit" class="btn btn-default" style="height: 100%;" onclick="window.location='{{ route("alokasinonreguler.index") }}'">
	                            <img src="img/icon/alokasi-icon.png" style="width: 50%;"><br>
	                            Manage Alokasi <red style="color:red">*{{ $count_alokasi_non_reguler }}</red>
	                        </button>
						</div>
						<div class="col-md-4">
							<button type="submit" class="btn btn-default" style="height: 100%;" onclick="window.location='{{ url('/manage/nonreguler') }}'">
	                            <img src="img/icon/check-in-icon.png" style="width: 50%;"><br>
	                            Check In <red style="color:red">*{{$count_checkin_non_reguler}}</red> / Check Out <red style="color:red">*{{$count_checkout_non_reguler}}</red>
	                        </button>
						</div>
					</div>
				</div>
				@endif
				@if ($user->is_sekretariat == '1')
				<div id="dash_sekretariat" class="tab-pane fade {{ ($user->is_penghuni == 0 && $user->is_pengelola == 0)? 'in active' : '' }}">
					<!--
					**************************************************
								DASHBOARD SEKRETARIAT

					**************************************************
					-->
					<div class="row" style="margin: 0px; padding: 4px;">
						<h4>Manajemen UPT Asrama</h4>
						<div class="col-md-4">
							<button type="submit" class="btn btn-default" style="height: 100%;" onclick="location.href='/managerequestkeluar';">
	                            <img src="img/icon/exit-icon.png" style="width: 50%;"><br>
	                            Manage Request Keluar <red style="color:red">*{{ $count_request_keluar }}</red>
	                        </button>
						</div>
						<div class="col-md-4">
							<button type="submit" class="btn btn-default" style="height: 100%;" onclick="location.href='/managerequestpindah';">
	                            <img src="img/icon/move-out-icon.png" style="width: 50%;"><br>
	                            Manage Request Pindah Kamar <red style="color:red">*{{ $count_request_pindah }}</red>
	                        </button>
						</div>
						<div class="col-md-4">
							<button type="submit" class="btn btn-default" style="height: 100%;" onclick="window.location='{{ route("admintarif.index") }}'">
	                            <img src="img/icon/tariff-icon.png" style="width: 50%;"><br>
	                            Manage Tarif Asrama
	                        </button>
						</div>
					</div>
					<div class="row" style="margin: 0px; padding: 4px;">
						<h4>Manajemen Periode</h4>
						<div class="col-md-4 col-md-offset-2">
							<button type="submit" class="btn btn-default" style="height: 100%;" onclick="window.location='{{ route("periodes.index") }}'">
	                            <img src="img/icon/period-icon.png" style="width: 50%;"><br>
	                            Manage Periode
	                        </button>
						</div>
						<div class="col-md-4">
							<button type="submit" class="btn btn-default" style="height: 100%;" onclick="location.href='/manage_lanjut_periode';">
	                            <img src="img/icon/continue-icon.png" style="width: 50%;"><br>
	                            Manage Periode Lanjutan
	                        </button>
						</div>
					</div>
				</div>
				@endif
				@if ($user->is_pimpinan == '1')
				<div id="dash_pimpinan" class="tab-pane fade">
					<!--
					**************************************************
								DASHBOARD PIMPINAN

					**************************************************
					-->
					<h3><center><i>To be defined later.</i></center></h3>
				</div>
				@endif
				@if ($user->is_admin == '1')
				<div id="dash_admin" class="tab-pane fade {{ ($user->is_penghuni == 0 && $user->is_pengelola == 0 && $user->is_sekretariat == 0 && $user->is_pimpinan == 0)? 'in active' : '' }}">
					<!--
					**************************************************
								DASHBOARD ADMINISTRATOR

					**************************************************
					-->
					<div class="row" style="margin: 0px; padding: 4px;">
						<h4>Administrasi Sistem</h4>
						<div class="col-md-4 col-md-offset-2">
							<button type="submit" class="btn btn-default" style="height: 100%;" onclick="window.location='{{ route("users.index") }}'">
	                            <img src="img/icon/user-icon.png" style="width: 50%;"><br>
	                            Manage Users
	                        </button>
						</div>
						<div class="col-md-4">
							<button type="submit" class="btn btn-default" style="height: 100%;" onclick="location.href='/formupload';">
	                            <img src="img/icon/upload-icon.png" style="width: 50%;"><br>
	                            Upload File
	                        </button>
						</div>
					</div>
				</div>
				@endif
			</div>
			</div>
		</div>
		</div>


		</section>
	</div>
</div><!-- content -->
@endsection

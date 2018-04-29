@extends('layouts.default')

@section('title','Periode Tinggal')

@section('main_menu')
	@parent

@endsection

@section('header_title','Penghuni | Pendaftaran')
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
				<h1><b>Informasi Pendaftaran</b></h1>
				<p>Terimakasih telah bergabung dengan UPT Asrama ITB. Silahkan daftarkan diri Anda untuk permohonan tinggal di asarama.
					Syarat dan ketentuan adalah sebagai berikut:<br>
					<h4><b>PENGHUNI REGULER</b></h4>Penghuni reguler adalah penghuni dengan status mahasiswa ITB. Seorang penghuni reguler hanya dapat mendaftar pada periode tertentu yang waktunya telah ditetapkan oleh pihak asrama.<br>
					<h4><b>PENGHUNI NON REGULER</b></h4>Penghuni Non Reguler terbuka bagi siapa saja yang ingin mendaftar ke asrama. Penghuni Non Reguler dapat menetapkan tanggal masuk dan tanggal keluar dari asrama sesuai keperluan tinggal.
				</p><br>
				<h2><b>Biaya Tinggal</b></h2>
				<p>Berikut ini adalah list biaya tinggal di asrama sesuai dengan Surat Keputusan Rektor Institut Teknologi Bandung Nomor SK/11.B01/PP/2017.</p>
				<div class="table">
					<table>
						<tr>
							<th>Nama Asrama</th>
							<th>Kapasitas Kamar</th>
							<th>Tempo Tinggal</th>
							<th>Tarif Sarjana</th>
							<th>Tarif Pascasarjana</th>
							<th>Tarif Internasional</th>
							<th>Tarif Umum</th>
						</tr>
						@foreach($tarif as $bayar)
						<tr>
							<td>{{$bayar->nama}}</td>
							<td>{{$bayar->kapasitas_kamar}}</td>
							<td>{{$bayar->tempo}}</td>
							@if($bayar->tarif_sarjana != NULL)
								<td>Rp<?php echo substr($bayar->tarif_sarjana, -6, 3).".".substr($bayar->tarif_sarjana, -3).",00"; ?></td>
							@else
								<td>-</td>
							@endif
							@if($bayar->tarif_pasca_sarjana != NULL)
								<td>Rp<?php echo substr($bayar->tarif_pasca_sarjana, -6, 3).".".substr($bayar->tarif_pasca_sarjana, -3).",00"; ?></td>
							@else
								<td>-</td>
							@endif
							@if($bayar->tarif_international != NULL)
								<td>Rp<?php echo substr($bayar->tarif_international, -6, 3).".".substr($bayar->tarif_international, -3).",00"; ?></td>
							@else
								<td>-</td>
							@endif
							@if($bayar->tarif_umum != NULL)
								<td>Rp<?php echo substr($bayar->tarif_umum, -6, 3).".".substr($bayar->tarif_umum, -3).",00"; ?></td>
							@else
								<td>-</td>
							@endif
						</tr>
						@endforeach
					</table>
				</div>
				<p>Keterangan:
					<ul>
						<li>Biaya tersebut berlaku sesuai dengan jumlah penghuni dalam satu kamar seperti yang telah disebutkan.</li>
						<li>Apabila penghuni baru hendak tinggal sendiri dalam satu kamar, maka biaya akan dilipatkan berdasarkan kapasitas kamar</li>
						<li>Untuk tinggal sementara dengan biaya harian, lama tinggal maksimal adalah 10 hari. Bila lebih dari itu, maka biaya akan berganti menjadi bulanan</li>
						<li>Untuk kolom yang tidak ada harganya, maka pilihan tersebut tidak ada. Namun, harga dapat ditentukan lebih lanjut bila memang sangat diperlukan.</li>
					</ul>
				</p>

				<br>
				<h2><b>Periode Pendaftaran Tersedia</b></h2>
				<div class="row">
					<div class="col-md-6" style="text-align: center;">
						<h3><b>Pendaftaran Non Reguler</b></h3>
						<div style="text-align: center;"><a href="#"><button class="button">Daftar Sekarang</button></a></div>
					</div>
					<div class="col-md-6" style="text-align: center;">
						<h3><b>Pendaftaran Reguler</b></h3>
					<div style="text-align: center;"><a href="{{url('/dashboard/penghuni/daftar_reguler')}}"><button class="button">Daftar Sekarang</button></a></div>
					</div>
				</div>
			</div>
		</div>
	</div>			
	<br><br><br>
</div>
@endsection

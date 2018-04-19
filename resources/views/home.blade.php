@extends('layouts.default')


@section('title','Home')

@section('main_menu')
	@parent

@endsection

@section('header_title','Home')
@section('content')
	<div style="background-color: white; width: 100%; height: 400px; overflow: hidden;margin-top: 0px; position: relative;">
		<img src="{{ asset('img/sangkuriang.JPG') }}" style="position: absolute;" class="img_center2" width="100%;" alt="user">
		<div class="container">
			<div style="position: absolute; background-color: rgba(0,0,0,0.6); padding: 10px; color:white; z-index: 10; margin-top: 100px; max-width: 93%; width: 500px; ">
				<h4><b>Selamat Datang!</b></h4>
				<p>UPT Asrama ITB memberikan pelayanan utama berupa pendidikan karakter bagi seluruh penghuninya.
				Difasilitasi dengan segenap personel tutor dan karyawan kami siap membangun generasi penerus bangsa yang lebih baik.</p>
				<a href="#"><button class="home1"><b>Telurusi >></b></button></a>
			</div>
		</div>
	</div>
	<div class="container">
		<h1>Berita Terbaru</h1>
		<hr>
		<div class="row">
			@if($berita == '0')
				<div class="col-md-12" style="height: 100px;"> Belum ada berita untuk ditampilkan saat ini. </div>
			@else
				<?php $count = 0; $date_count = 0;?>
				@foreach($berita as $post)
					@if($count%2 == 1)
					<?php $count = $count + 1; ?>
					<div class="col-md-3">
						<div style="style=padding: 0px; border-style: solid; border-width: 1px; border-color: #CCCCCC">
							<div style="padding: 10px;">
								<h3>{{$post->title}}</h3>
								<p><i><?php echo $date[$date_count]; ?></i></p>
								<p>
									<?php
									echo substr($post->isi,0,150).'...';
									?>
									<br><br>
								<a href="#">Cari Tahu >></a></p>
							</div>
							<div class="berita">
								<div style="background-color: white; width: 100%; height: 200px; overflow: hidden;margin-top: 0px; position: relative;">
								<img src="<?php echo 'img/berita/'.$post->file; ?>" style="position: absolute;" class="img_center" width="100%;" alt="berita1" >
								</div>
							</div>
						</div><br><br>
					</div>
					@elseif($count%2 == 0)
					<?php $count = $count + 1; ?>
					<div class="col-md-3">
						<div style="style=padding: 0px; border-style: solid; border-width: 1px; border-color: #CCCCCC">
							<div class="berita">
								<div style="background-color: white; width: 100%; height: 200px; overflow: hidden;margin-top: 0px; position: relative;">
								<img src="<?php echo 'img/berita/'.$post->file; ?>" style="position: absolute;"  class="img_center" width="100%;" alt="berita1" >
								</div>
							</div>
							<div style="padding: 10px;">
								<h3>{{$post->title}}</h3>
								<p><i><?php echo $date[$date_count]; ?></i></p>
								<p>
									<?php
									echo substr($post->isi,0,150).'...';
									?>
									<br><br>
								<a href="#">Cari Tahu >></a></p>
							</div>
						</div><br><br>
					</div>
					@endif
				@endforeach
			@endif
		</div><br>
	</div>
	<div class="budaya" style="width: 100%; min-height: 250px; overflow: hidden;margin-top: 0px; position: relative;">
			<div class="container" style="padding: 10px; color:white;">
				<h1>Budaya Asrama ITB</h1><br>
				<div class="row" style="text-align: center;">
					<div class="col-xs-3">
						<i class="fa fa-users" style="font-size: 70px;"></i><br><br>
						<p>Berbaik sangka, senyum, bekerja sama, dan musyawarah.</p>
					</div>
					<div class="col-xs-3">
						<i class="fa fa-tachometer" style="font-size: 70px;"></i><br><br>
						<p>Disiplin waktu dan antri</p>
					</div>
					<div class="col-xs-3">
						<i class="fa fa-recycle" style="font-size: 70px;"></i><br><br>
						<p>Memungut, memilah, dan memanfaatkan sampah.</p>
					</div>
					<div class="col-xs-3">
						<i class="fa fa-bolt" style="font-size: 70px;"></i><br><br>
						<p>Hemat, dan konservasi air serta energi.</p>
					</div>
				</div>
			</div>
	</div>
		<br><br>
	<div class="container">
	<div class="row">
		<div class="col-md-6">
			<table class="tab">
				<tr>
					<th class="tab1"><h4><b>Informasi</b></h4></th>
				</tr>
				@if($pengumuman == '0')
					<tr><td>Belum ada pengumuman untuk saat ini.</td></tr>
				@else
					<?php $j = 0; ?>
					@foreach($pengumuman as $informasi)
					<tr><td class="tab2"><h4><b>{{$informasi->title}}</b></h4><i>{{$dateInfo[$j]}}</i>
						<br><?php echo substr($informasi->isi,0,100).'...'; ?>
						<div style="text-align: right"><a href="#">Selengkapnya >></a></div></td></tr>
					@endforeach
				@endif
			</table><br><br>
		</div>
		<div class="col-md-6">
			<div style="padding: 5px 10px 5px 10px; background-color: #0769B0; border-top-left-radius: 5px; border-top-right-radius: 5px; color: white">
				<h4><b>Kegiatan Terdekat</b></h4>
			</div>
			<div class="media">
				<div class="media-left">
					<div style="padding: 0px; text-align: center; color: black; border-radius: 5px; background-color: rgba(196,196,196,1.00); width: 100px; padding-bottom: 5px;">
						<div style="padding: 5px 10px 5px 10px; color: white; background-color: #205081; border-top-left-radius: 5px; border-top-right-radius: 5px;">
							<b>Desember</b>
						</div>
						<h1 style="margin-top: 5px;"><b>27</b></h1>
					</div>
				</div>
				<div class="media-body">
					<h3 style="margin-top: 0px;"><b>Pembinaan Terpusat Desember</b></h3>
					<p>Pembinaan untuk seluruh penghuni asrama. Mulai dari penghuni, tutor hingga dosen sekalipun.</p>
				</div>
			</div>
			<div class="media">
				<div class="media-left">
					<div style="padding: 0px; text-align: center; color: black; border-radius: 5px; background-color: rgba(196,196,196,1.00); width: 100px; padding-bottom: 5px;">
						<div style="padding: 5px 10px 5px 10px; color: white; background-color: #205081; border-top-left-radius: 5px; border-top-right-radius: 5px;">
							<b>Desember</b>
						</div>
						<h1 style="margin-top: 5px;"><b>27</b></h1>
					</div>
				</div>
				<div class="media-body">
					<h3 style="margin-top: 0px;"><b>Pembinaan Terpusat Desember</b></h3>
					<p>Pembinaan untuk seluruh penghuni asrama. Mulai dari penghuni, tutor hingga dosen sekalipun.</p>
				</div>
			</div><br><br>
			
		</div>
	</div>
		
	</div>
	<br><br>
@endsection
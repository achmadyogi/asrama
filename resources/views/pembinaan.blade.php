@extends('layouts.default')


@section('title','Pembinaan')

@section('menu_pembinaan','active')
@section('main_menu')
	@parent
	<div class="atas" id="atas" style="font-size: 14px;">
	<div class="sub_menu">
	<div class="container">
	<button id="dir_down" style="border: none; background-color: transparent;"><b><i class="fa fa-angle-down" style="font-size: 24px;"></i></b></button>
	<button id="dir_up" style="border: none; background-color: transparent;"><b><i class="fa fa-angle-up" style="font-size: 24px;"></i></b></button>
		<ul class="sub_dir">
			<li class="sub_dir_list"><a href="#">Tutor Asrama ITB</a></li>
			<li class="sub_dir_list"><a href="#">Pembinaan Karakter</a></li>
			<li class="sub_dir_list"><a href="#">Layanan</a></li>
			<li class="sub_dir_list"><a href="">Kegiatan Penghuni</a></li>
		</ul>
	</div>
	</div>
	</div>
<div id="smoother" class="smoother" style="height: 40px;">
	
</div>
<style>
	.atas{
		position: fixed;
		top: 60px;
		left: 0;
		z-index: 999;
		width: 100%;
	}
	.smoother{
		display: none;
	}
</style>
<script type="text/javascript">
	$(document).ready(function() {
		var atas = 70;
		var j = 1;
		$("#icon").click(function(){
			j += 1;
			if(j%2==0){
				atas = 70;
			}else{
				atas = 300;
			}
		});
		$('#atas').removeClass('atas');
		$('#dir_down').click(function(){
			$('#dir_down').hide(500);
			$('#dir_up').show(500);
			$(".sub_dir").show(500);
			$("#smoother").css("height","170");
		});
		$('#dir_up').click(function(){
			$('#dir_down').show(500);
			$('#dir_up').hide(500);
			$(".sub_dir").hide(500);
			$("#smoother").css("height","40");
		});
		$(window).on('scroll', function () {
			if (atas <= $(window).scrollTop()) {
				// if so, add the fixed class
				$('#atas').addClass('atas');
				$('#smoother').removeClass('smoother');
			} else {
				// otherwise remove it
				$('#atas').removeClass('atas');
				$('#smoother').addClass('smoother');
			}
		})
	});
</script>
@endsection

@section('header_title','Pembinaan')
@section('content')
	<div style="background-color: white; width: 100%; height: 400px; overflow: hidden;margin-top: 0px; position: relative;">
		<img src="{{ asset('img/sangkuriang.JPG') }}" style="position: absolute;" class="img_center" width="100%;" alt="user">
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
			<div class="col-md-3">
				<div style="style=padding: 0px; border-style: solid; border-width: 1px; border-color: #CCCCCC">
					<div style="padding: 10px;">
						<h3>Belajar di Asrama</h3>
						<p>Paragraf ini berisi tentang overview singkat dari kegiatan yang bersangkutan. overview ini harus menarik perhatian pembaca sehingga mau melihat informasi lebih lanjut.<br><br>
						<a href="#">Cari Tahu >></a></p>
					</div>
					<div class="berita">
						<img src="{{ asset('img/bebekipa4.jpg') }}" width="100%" alt="berita1" class="img_center">
					</div>
				</div><br><br>
			</div>
			<div class="col-md-3">
				<div style="style=padding: 0px; border-style: solid; border-width: 1px; border-color: #CCCCCC">
					<div class="berita">
						<img src="{{ asset('img/bebekipa4.jpg') }}" width="100%" alt="berita1" class="img_center">
					</div>
					<div style="padding: 10px;">
						<h3>Belajar di Asrama</h3>
						<p>Paragraf ini berisi tentang overview singkat dari kegiatan yang bersangkutan. overview ini harus menarik perhatian pembaca sehingga mau melihat informasi lebih lanjut.<br><br>
						<a href="#">Cari Tahu >></a></p>
					</div>
				</div><br><br>
			</div>
			<div class="col-md-3">
				<div style="style=padding: 0px; border-style: solid; border-width: 1px; border-color: #CCCCCC">
					<div style="padding: 10px;">
						<h3>Belajar di Asrama</h3>
						<p>Paragraf ini berisi tentang overview singkat dari kegiatan yang bersangkutan. overview ini harus menarik perhatian pembaca sehingga mau melihat informasi lebih lanjut.<br><br>
						<a href="#">Cari Tahu >></a></p>
					</div>
					<div class="berita">
						<img src="{{ asset('img/bebekipa4.jpg') }}" width="100%" alt="berita1" class="img_center">
					</div>
				</div><br><br>
			</div>
			<div class="col-md-3">
				<div style="style=padding: 0px; border-style: solid; border-width: 1px; border-color: #CCCCCC">
					<div class="berita">
						<img src="{{ asset('img/bebekipa4.jpg') }}" width="100%" alt="berita1" class="img_center">
					</div>
					<div style="padding: 10px;">
						<h3>Belajar di Asrama</h3>
						<p>Paragraf ini berisi tentang overview singkat dari kegiatan yang bersangkutan. overview ini harus menarik perhatian pembaca sehingga mau melihat informasi lebih lanjut.<br><br>
						<a href="#">Cari Tahu >></a></p>
					</div>
				</div><br><br>
			</div>
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
				<tr><td class="tab2">[date]<br>Asrama dalam perbaikan</td></tr>
				<tr><td class="tab2">[date]<br>Asrama dalam perbaikan</td></tr>
				<tr><td class="tab2">[date]<br>Asrama dalam perbaikan</td></tr>
				<tr><td class="tab2">[date]<br>Asrama dalam perbaikan</td></tr>
				<tr><td class="tab2">[date]<br>Asrama dalam perbaikan</td></tr>
				<tr><td class="tab2">[date]<br>Asrama dalam perbaikan</td></tr>
				<tr><td class="tab2">[date]<br>Asrama dalam perbaikan</td></tr>
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
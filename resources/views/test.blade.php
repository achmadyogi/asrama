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
				{{csrf_field()}}
				<div id="check">
					test button here!.
				</div>
				<button type="button" class="button" id="test">Test</button>
				<script type="text/javascript">
					$(document).ready(function(){
						$('#test').click(function(){
							var text = "You have check your box";
							$.post('test',{'text': text, '_token':$('input[name=_token]').val()}, function(data){
								console.log(text);
								$('#check').load(location.href + ' #check');
							});
						})
					});
				</script>
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
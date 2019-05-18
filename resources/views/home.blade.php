@extends('layouts.default')


@section('title','Home')

@section('main_menu')
	@parent

@endsection

@section('header_title','Home')
@section('content')
	<div id="demo" class="carousel slide" data-ride="carousel">
		  <ul class="carousel-indicators">
		    <li data-target="#demo" data-slide-to="0" class="active"></li>
		    <li data-target="#demo" data-slide-to="1"></li>
		    <li data-target="#demo" data-slide-to="2"></li>
		    <li data-target="#demo" data-slide-to="3"></li>
		    <li data-target="#demo" data-slide-to="4"></li>
		  </ul>
		  <div class="carousel-inner">
		  	<div class="carousel-item active">
		      <img src="{{ asset('img/home/asramaR.jpg') }}" alt="Los Angeles">
		      <div class="carousel-caption">
		      	<div style="padding: 10px; background-image: linear-gradient(to right, transparent , black, transparent); border-radius: 5px; width: 600px; max-width: 100%; margin:0 auto">
		      		@if(session()->has('en')) The Dormitory has buildings placed around both main campus (Ganesha) and branch campus (Jatinangor). @else Asrama ITB memiliki gedung-gedung asrama yang tersebar di sekitar kampus Ganesha dan Jatinangor. @endif
		      	</div>
		      </div>   
		    </div>
		    <div class="carousel-item">
		      <img src="{{ asset('img/home/penghuniR.jpg') }}" alt="Los Angeles">
		      <div class="carousel-caption">
		      	<div style="padding: 10px; background-image: linear-gradient(to right, transparent , black, transparent); border-radius: 5px; width: 600px; max-width: 100%; margin:0 auto">
		      		@if(session()->has('en')) The Dormitory provides bundles of activities that support student's learning environments. @else Asrama ITB dilengkapi dengan rangkaian kegiatan yang menunjang pembelajaran mahasiswa di kampus. @endif
		      	</div>
		      </div>   
		    </div>
		    <div class="carousel-item">
		      <img src="{{ asset('img/home/ptR.jpg') }}" alt="New York">
		      <div class="carousel-caption">
		      	<div style="padding: 10px; background-image: linear-gradient(to right, transparent , black, transparent); border-radius: 5px; width: 600px; max-width: 100%; margin:0 auto">
		      		@if(session()->has('en')) The Dormitory has its greatest nurturing event called "Pembinaan Terpusat" attended by almost the whole dormitory community. @else Asrama ITB memiliki kegiatan pembinaan terbesar yang dihadiri oleh seluruh penghuni asrama (Tahap Persiapan Bersama). @endif
		      	</div>
		      </div>   
		    </div>
		    <div class="carousel-item">
		      <img src="{{ asset('img/home/staffR.jpg') }}" alt="Chicago">
		      <div class="carousel-caption">
		      	<div style="padding: 10px; background-image: linear-gradient(to right, transparent , black, transparent); border-radius: 5px; width: 600px; max-width: 100%; margin:0 auto">
		      		@if(session()->has('en')) The dormitory has warm staff and employees that facilitates the students needs. @else Asrama ITB memiliki karyawan dan staff yang siap melayani kebutuhan penghuni. @endif
		      	</div>
		      </div>   
		    </div>
		    <div class="carousel-item">
		      <img src="{{ asset('img/home/tutorR.jpg') }}" alt="New York">
		      <div class="carousel-caption">
		      	<div style="padding: 10px; background-image: linear-gradient(to right, transparent , black, transparent); border-radius: 5px; width: 600px; max-width: 100%; margin:0 auto">
		      		@if(session()->has('en')) The Dormitory has tutors as the main nurturing agents taken from the previous occupants that have strong commitment to involve in any nurturing projects @else Asrama ITB memiliki tutor-tutor yang merupakan agen pengawal pembinaan di asrama. Mereka adalah senior-senior yang sebelumnya juga menjadi penghuni. @endif
		      	</div>
		      </div>   
		    </div>
		  </div>
		  <a class="carousel-control-prev" href="#demo" data-slide="prev">
		    <span class="carousel-control-prev-icon"></span>
		  </a>
		  <a class="carousel-control-next" href="#demo" data-slide="next">
		    <span class="carousel-control-next-icon"></span>
		  </a>
	</div>
	<div class="budaya" style="width: 100%; margin-top: -5px; padding: 10px 25px 10px 25px;">
		<br>
		<div class="row">
			
			<div class="col-md-3 zooming">
				<a href="{{ route('info') }}" style="text-decoration: none;">
				<img src="{{ asset('img/home/futureStudents.png') }}" width="100%"><br><br>
				<div style="position: absolute; z-index: 10; width: 100%; color: white; top: 7px; left: 30px; font-family: Calibri;">
					<p style="margin-bottom: 0px;">@if(session()->has('en')) Browse @else Telusuri @endif</p>
					<h3 style="margin-top: 0px;">@if(session()->has('en')) Information for <br> Future Occupants @else Informasi untuk <br> Calon Penghuni Baru @endif</h3>
				</div>
				</a>
			</div>
			
			<div class="col-md-3 zooming">
				<a href="{{ route('pengumuman') }}" style="text-decoration: none;">
				<img src="{{ asset('img/home/currentStudents.png') }}" width="100%"><br><br>
				<div style="position: absolute; z-index: 10; width: 100%; color: white; top: 7px; left: 30px; font-family: Calibri;">
					<p style="margin-bottom: 0px;">@if(session()->has('en')) Browse @else Telusuri @endif</p>
					<h3 style="margin-top: 0px;">@if(session()->has('en')) Information for <br> Current Occupants @else Informasi untuk <br> Penghuni Aktif @endif</h3>
				</div>
				</a>
			</div>
			<div class="col-md-3 zooming">
				<a href="{{ route('faq') }}" style="text-decoration: none;">
				<img src="{{ asset('img/home/faq.png') }}" width="100%"><br><br>
				<div style="position: absolute; z-index: 10; width: 100%; color: white; top: 7px; left: 30px; font-family: Calibri;">
					<p style="margin-bottom: 0px;">@if(session()->has('en')) Browse @else Telusuri @endif</p>
					<h3 style="margin-top: 0px;">Frequently Asked <br> Question (FAQ)</h3>
				</div>
				</a>
			</div>
			<div class="col-md-3 zooming">
				<a href="{{ route('info') }}" style="text-decoration: none;">
				<img src="{{ asset('img/home/dormTour.png') }}" width="100%"><br><br>
				<div style="position: absolute; z-index: 10; width: 90%; color: white; top: 7px; left: 30px; font-family: Calibri;">
					<p style="margin-bottom: 0px;">@if(session()->has('en')) Browse @else Telusuri @endif</p>
					<h3 style="margin-top: 0px;">@if(session()->has('en')) Dormitory <br> Quick Tour @else Keliling Asrama @endif</h3>
				</div>
				</a>
			</div>
		</div>
	</div>
	<div class="container">
		<h1>@if(session()->has('en')) Recent News @else Berita Terbaru @endif</h1>
		<br>
		<div class="row">
			@if($berita == '0')
				<div class="col-md-12" style="height: 100px;"> <p>@if(session()->has('en')) There is no news to share with for now @else Belum ada berita untuk ditampilkan saat ini. @endif </p></div>
			@else
				<?php $count = 0; $date_count = 0;?>
				@foreach($berita as $post)
				<div class="col-md-4">
					<div style="text-align: center; position: absolute; z-index: -5; top: 0px; left: 50%; margin: 0px 0px 0px -170px; ;">
						<div style='background-color: white; width: 340px; max-width: 100%; height: 250px; overflow: hidden;margin-top: 0px; position: relative;'>
							<img src="{{Storage::url($post->file)}}" style='position:absolute; left: -100%; right: -100%; top: -100%; bottom: -100%; margin: auto; min-height: 100%; min-width: 100%;' height='250px;' alt='user'>
						</div>
					</div>
					<br><br><br><br><br><br><br><br><br><br>
					<div style="margin-top: 0px; height: 5px; background-color: #0769B0; border-top-left-radius: 3px; border-top-right-radius: 3px;"></div>
					<div class="sider_body" style="background-color: white; border-radius: 0px; color: black; padding-left: 20px; padding-right: 20px; height: 400px;">
						<h3 style="color: #70381f;">{{$post->title}}</h3>
						<small><i><?php echo ITBdorm::DateTime($post->updated_at); ?></i></small>
						<p>
							<?php
							echo substr($post->isi,0,150).'...';
							?>
							<br><br>
						<a href="berita/{{$post->id_berita}}" style="color: #70381f">@if(session()->has('en')) Find out more >> @else Cari Tahu >> @endif</a></p>
					</div><br>
				</div>
				<?php $count += 1; $date_count += 1; ?>
				@endforeach
			@endif
		</div><br>
	</div>
	<div class="budaya" style="width: 100%; min-height: 250px; overflow: hidden;margin-top: 0px; position: relative;">
			<div class="container" style="padding: 10px; color:white;">
				<h1>@if(session()->has('en')) The Dormitory Cultures @else Budaya Asrama ITB @endif</h1><br>
				<div class="row" style="text-align: center;">
					<div class="col-xs-3">
						<i class="fa fa-users" style="font-size: 70px;"></i><br><br>
						<p>@if(session()->has('en')) Posisitive thinking, smiling, cooperating, and consolidating @else Berbaik sangka, senyum, bekerja sama, dan musyawarah. @endif</p>
					</div>
					<div class="col-xs-3">
						<i class="fa fa-tachometer" style="font-size: 70px;"></i><br><br>
						<p>@if(session()->has('en')) Managing time and queue @else Disiplin waktu dan antri @endif</p>
					</div>
					<div class="col-xs-3">
						<i class="fa fa-recycle" style="font-size: 70px;"></i><br><br>
						<p>@if(session()->has('en')) Waste caring, classifying, and recycling @else Memungut, memilah, dan memanfaatkan sampah. @endif</p>
					</div>
					<div class="col-xs-3">
						<i class="fa fa-bolt" style="font-size: 70px;"></i><br><br>
						<p>@if(session()->has('en')) Water and energy conservation @else Hemat, dan konservasi air serta energi. @endif</p>
					</div>
				</div>
			</div>
	</div>
		<br><br>
	<div class="container">
	<div class="row">
		<div class="col-md-6">
			<div style="margin-top: 0px; height: 4px; background-color: #0769B0; border-top-left-radius: 3px; border-top-right-radius: 3px;"></div>
			<div style="border: 1px solid #E6E9EE; background-color: white; padding:10px 20px 20px 20px;">
				
				<h4><b>@if(session()->has('en')) Announcement @else Pengumuman @endif</b></h4>
				<hr>
				@if($pengumuman == '0')
					<tr><td><p>@if(session()->has('en')) There is no announcement to share with for now. @else Belum ada pengumuman saat ini. @endif</p></td></tr>
				@else
				<?php $j = 0; ?>
					@foreach($pengumuman as $informasi)
					<h4><b>{{$informasi->title}}</b></h4><i>{{ITBdorm::DateTime($informasi->updated_at)}}</i>
						<br><?php echo substr($informasi->isi,0,100).'...'; ?>
						<div style="text-align: right"><a href="pengumuman/{{$informasi->id_pengumuman}}">@if(session()->has('en')) Find out more >> @else Selengkapnya >> @endif</a></div>
						<?php $j += 1; ?>
					@if($j < 4)
					<hr>
					@endif
					@endforeach
				@endif
			</div><br><br>
		</div>
		<div class="col-md-6">
			<div style="margin-top: 0px; height: 5px; background-color: #0769B0; border-top-left-radius: 3px; border-top-right-radius: 3px;"></div>
			<div class="sider_body" style="background-color: white; border-radius: 0px; color: black; padding-left: 20px; padding-right: 20px;">
				<h4><b>@if(session()->has('en')) Schedule @else Kegiatan Terdekat @endif</b></h4>
			</div>
			@foreach($jadwal as $j)
				<div class="media" style="background-color: white; padding: 10px; border: 1px solid #C9C9C9;">
					<div class="media-left">
						<div style="padding: 0px; text-align: center; color: black; border-radius: 5px; background-color: rgba(196,196,196,1.00); width: 100px; padding-bottom: 5px;">
							<div style="padding: 5px 10px 5px 10px; color: white; background-color: #205081; border-top-left-radius: 5px; border-top-right-radius: 5px;">
								<b>{{ITBdorm::BreakDate($j->tanggal)->month}}</b>
							</div>
							<h1 style="margin-top: 5px;"><b>{{ITBdorm::BreakDate($j->tanggal)->day}}</b></h1>
						</div>
					</div>
					<div class="media-body">
						<h3 style="margin-top: 0px;"><b>{{$j->judul}}</b></h3>
						<p>{{$j->deskripsi}}</p>
					</div>
				</div>
			@endforeach
			<br><br>
			
		</div>
	</div>
		
	</div>
	<div class="budaya" style="width: 100%; min-height: 250px; overflow: hidden;margin-top: 0px; position: relative;">
		<div class="container" style="padding: 25px 0px 25px 0px; color:white;">
			<div class="tech-slideshow">
			  <div class="mover-1"></div>
			  <div class="mover-2"></div>
			</div>
			<style type="text/css">
				.tech-slideshow {
				  height: 200px;
				  width: 100%;
				  margin: 0 auto;
				  position: relative;
				  overflow: hidden;
				  transform: translate3d(0, 0, 0);
				}

				.tech-slideshow > div {
				  height: 200px;
				  width: 2526px;
				  background: url("{{asset ('img/carousel2.jpg')}}");
				  position: absolute;
				  top: 0;
				  left: 0;
				  height: 100%;
				  transform: translate3d(0, 0, 0);
				}
				.tech-slideshow .mover-1 {
				  animation: moveSlideshow 30s linear infinite;
				}
				.tech-slideshow .mover-2 {
				  opacity: 0;
				  transition: opacity 0.5s ease-out;
				  background-position: 0 -200px;
				  animation: moveSlideshow 30s linear infinite;
				}
				.tech-slideshow:hover .mover-2 {
				  opacity: 1;
				}

				@keyframes moveSlideshow {
				  100% { 
				    transform: translateX(-66.6666%);  
				  }
				}
			</style>
		</div>
	</div>
	<style type="text/css">
		.back-amazing{
			background-image: url('../img/sosmed/back_home.png');
			background-repeat:  no-repeat center;
			background-size: cover;
		}
	</style><br><br>
	<div class="container">
		<h1>@if(session()->has('en')) Facts and Statistic @else Fakta dan Statistik @endif</h1>
		<hr>
		<div class="row">
			<div class="col-md-8">
				<div style="width: 100%">
					<canvas id="canvas"></canvas>
				</div>
				<script>
					var barChartData = {
						labels: [
							<?php 
								for($i=0; $i<sizeof($cp_nama_periode); $i++){
									echo "'Periode ".($i+1)." ";
									if($activation[$i] == 1){
										echo "(aktif)";
									}else{
										echo "(ditutup)";
									}
									echo "',";
								}
							?> ],
						datasets: [
							<?php
								$colors = ['grey','blue','green','yellow','red','orage','black'];
								for($i=0;$i<sizeof($asrama);$i++){
									echo 
									"
										{
											label: '".$asrama[$i]."',
											backgroundColor: window.chartColors.".$colors[$i].",
											data: [";
												$c1 = 0;
												for($z=0;$z<sizeof($asrama_1n);$z++){
													if($asrama_1n[$z] == $i){
														echo $asrama_1[$z].",";
														$c1 += 1;
													}
												}
												if($c1 == 0){
													echo "0,";
												}
												$c2 = 0;
												for($z=0;$z<sizeof($asrama_2n);$z++){
													if($asrama_2n[$z] == $i){
														echo $asrama_2[$z].",";
														$c2 += 1;
													}
												}
												if($c2 == 0){
													echo "0,";
												}
												$c3 = 0;
												for($z=0;$z<sizeof($asrama_3n);$z++){
													if($asrama_3n[$z] == $i){
														echo $asrama_3[$z].",";
														$c3 += 1;
													}
												}
												if($c3 == 0){
													echo "0,";
												}
												$c4 = 0;
												for($z=0;$z<sizeof($asrama_4n);$z++){
													if($asrama_4n[$z] == $i){
														echo $asrama_4[$z].",";
														$c4 += 1;
													}
												}
												if($c4 == 0){
													echo "0,";
												}
									echo "
											]
										},
									";
								}
							?>]

					};
					window.onload = function() {
						var ctx = document.getElementById('canvas').getContext('2d');
						window.myBar = new Chart(ctx, {
							type: 'bar',
							data: barChartData,
							options: {
								title: {
									display: false,
									text: 'Chart.js Bar Chart - Stacked'
								},
								tooltips: {
									mode: 'index',
									intersect: false
								},
								responsive: true,
							}
						});
					};

					document.getElementById('randomizeData').addEventListener('click', function() {
						barChartData.datasets.forEach(function(dataset) {
							dataset.data = dataset.data.map(function() {
								return randomScalingFactor();
							});
						});
						window.myBar.update();
					});
				</script>
				<br><br>
			</div>
			<div class="col-md-4">
				<p>@if(session()->has('en')) Explanation: @else Keterangan: @endif</p>
				<p style="text-align: justify;">
				@if(session()->has('en'))
				The data are collected from four recent available period. The data with 'active' tail means that the period is currently in progress. Conversely, the data with 'closed' tail means that the periode has ended and students have left the dormitory for that living period.
				@else
				Data asrama yang ditampilkan diambil dari empat periode terakhir. Data yang bersifat 'aktif' artinya periode tersebut sedang berlangsung. Sebaliknya, data yang bersifat 'ditutup' artinya periode tersebut sudah berlalu.
				@endif</p><br>

				@for($i=0; $i<=sizeof($cp_nama_periode)-1; $i++)
					<p><b>Periode {{$i+1}}</b><br><i>{{$cp_nama_periode[$i]}}</i></p>
				@endfor
				<br><br>
			</div>
		</div>
	</div><br>
	<div class="budaya" style="width: 100%; min-height: 250px; overflow: hidden;margin-top: 0px; position: relative;">
		<div class="container" style="padding: 25px 0px 25px 0px; color:white;">
			<style type="text/css">
				.download3{
					border: none; 
					background-color: #2380D7; 
					padding: 10px 15px 10px 15px; 
					border-radius: 4px; 
					box-shadow: 5px 5px 5px #363636;
				}
				.download3:hover{
					background-color: #115BC0;
				}
				.zooming:hover{
					transform: scale(1.05);
				}
				.zooming{
					transition: 0.5s;
				}
				.aja{
					text-decoration: none;
					color: white;
				}
				.aja:hover{
					text-decoration: none;
					color: white;
				}
			</style>
			<div class="row">
				<div class="col-md-4">
					<div style="background-color: rgba(92,92,92,0.80); padding: 10px 20px 10px 20px; height: 200px;" class="zooming">
						<h4><b>@if(session()->has('en')) The Dormitory Broshure @else Brosur UPT Asrama ITB @endif</b></h4>
						<p>@if(session()->has('en')) It is about the general information, including vision and mission, personnel, tutor, activity, and succinct information related to facilities. @else Berisi tentang gambaran umum asrama meliputi visi dan misi, personel, tutor, kegiatan, dan gedung asrama. @endif </p>
						<button class="download3"><b><a href="{{ asset('Files/home/Brosur_UPT_Asrama_ITB.pdf') }}" class="aja" download>@if(session()->has('en')) Download @else Unduh @endif</a></b></button>
					</div>
				</div>
				<div class="col-md-4">
					<div style="background-color: rgba(92,92,92,0.80); padding: 10px 20px 10px 20px; height: 200px;" class="zooming">
						<h4><b>@if(session()->has('en')) The Dormitory Book Profile @else Buku Profil Asrama @endif</b></h4>
						<p>@if(session()->has('en')) It is about detailed information about the dormitory. @else Berisi mengenai penjelasan yang lebih detail tentang UPT Asrama ITB yang meliputi apa-apa yang sudah disebutkan pada brosur. @endif </p>
						<button class="download3"><b><a href="{{ asset('Files/home/Buku_Profile_Asrama_20162017.pdf') }}" class="aja" download>@if(session()->has('en')) Download @else Unduh @endif</a></b></button>
					</div>
				</div>
				<div class="col-md-4">
					<div style="background-color: rgba(92,92,92,0.80); padding: 10px 20px 10px 20px; height: 200px;" class="zooming">
						<h4><b>@if(session()->has('en')) Brief Poster @else Poster Singkat Asrama @endif</b></h4>
						<p>@if(session()->has('en')) This poster is useful for introducing any provided dormitories around campuses. Each dorm has its own uniqueness. @else Poster ini digunakna untuk mengenalkan asrama yang ada di ITB. Setiap asrama memiliki keunikannya masing-masing. @endif </p>
						<button class="download3"><b><a href="{{ asset('Files/home/poster.jpg') }}" class="aja" download>@if(session()->has('en')) Download @else Unduh @endif</a></b></button>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="back-amazing">
		<div class="container"><br>
			<h1>@if(session()->has('en')) A Video of The Dormitory at Glance @else Video Sekilas Asrama ITB @endif</h1>
			<hr>
			<div class="row">
				<div class="col-md-6">
					<object width="100%" height="400" data="https://www.youtube.com/v/EDWPW90eynQ" style="max-width: 100%"></object>
				</div>
				<div class="col-md-6"><br><br>
					<div style="text-align: center;">
						<h3><b>@if(session()->has('en')) Follow Us! @else Kunjungi Kami @endif</b></h3><br>
					</div>
					<div class="row">
						<div class="col-xs-6">
							<div style="text-align: right; padding: 10px 15px 10px 15px;">
								<a href="https://www.instagram.com/asrama_itb/?hl=en" target="_blank"><img src="{{ asset('img/sosmed/instagram.png') }}" alt="instagram" width="70px"></a><br><br><br>
								<a href="https://web.facebook.com/uptasramaitb/" target="_blank"><img src="{{ asset('img/sosmed/facebook.png') }}" alt="instagram" width="70px"></a><br><br>
							</div>
						</div>
						<div class="col-xs-6">
							<div style="text-align: left; padding: 10px 15px 10px 15px;">
								<a href="https://www.linkedin.com/company/upt-asrama-itb/" target="_blank"><img src="{{ asset('img/sosmed/linkedin.png') }}" alt="instagram" width="70px"></a><br><br><br>
								<a href="https://www.youtube.com/channel/UCIsH_iMHo-Lu8AbLW_w_pWg/featured" target="_blank"><img src="{{ asset('img/sosmed/youtube.png') }}" alt="instagram" width="70px"></a><br><br>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	<br><br><br>
	</div>
@endsection
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>UPT Asrama ITB | @yield('title')</title>
<!-- next -->

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<script src="https://cdn.plot.ly/plotly-latest.min.js"></script>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
<script
  src="https://code.jquery.com/jquery-3.3.1.min.js"
  integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
  crossorigin="anonymous"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
<script type= "text/javascript" src = "{{ asset('js/countries.js') }}"></script>
<script type= "text/javascript" src="{{ asset('js/chart_1.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/chart_utils.js') }}"></script>
<link href="{{ asset('css/app.css') }}" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('css/default.css') }}" type="text/css">
<!-- maps -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.3.1/dist/leaflet.css"
   integrity="sha512-Rksm5RenBEKSKFjgI3a41vrjkw4EVPlJ3+OiI65vTjIdo9brlAacEuKOiQ5OFh7cOI1bkDwLqdLw3Zg0cRJAAQ=="
   crossorigin=""/>
<script src="https://unpkg.com/leaflet@1.3.1/dist/leaflet.js"
   integrity="sha512-/Nsx9X4HebavoBvEBuyp3I7od5tA0UzAxs+j83KgC8PU0kgB4XiK4Lfe4y4cgBtaRJQEIFCW+oC506aPT2L1zw=="
   crossorigin=""></script>
<link href='https://fonts.googleapis.com/css?family=Nunito' rel='stylesheet'>

	<style>
		/* Make the image fully responsive */
	  	.carousel-inner img {
		    width: 100%;
		    height: 100%;
	  	}
	  	p{
	  		font-size: 16px;
	  	}
	 </style>
</head>
<link rel="shorcut icon" href="{{ asset('img/logo/logo.png') }}"/>
<body style="font-family: Nunito; color: black; background-color: rgb(243,243,243); font-size: 15px;">
	<style type="text/css">
		::-webkit-scrollbar
        {
          width: 11px;  /* for vertical scrollbars */
          height: 11px; /* for horizontal scrollbars */
        }

        ::-webkit-scrollbar-track
        {
          background: rgb(218, 218, 218)
           /* -webkit-border-radius: 10px; */
        }

        ::-webkit-scrollbar-thumb
        {
          background: rgba(0, 0, 0, 0.5);
            /* -webkit-border-radius: 10px; */
        }
	</style>
	<style>
		@keyframes chartjs-render-animation{from{opacity:.99}to{opacity:1}}.chartjs-render-monitor{animation:chartjs-render-animation 1ms}.chartjs-size-monitor,.chartjs-size-monitor-expand,.chartjs-size-monitor-shrink{position:absolute;direction:ltr;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1}.chartjs-size-monitor-expand>div{position:absolute;width:1000000px;height:1000000px;left:0;top:0}.chartjs-size-monitor-shrink>div{position:absolute;width:200%;height:200%;left:0;top:0}
	canvas {
		-moz-user-select: none;
		-webkit-user-select: none;
		-ms-user-select: none;
	}
	</style>
@section('main_menu')
<div class="container">
<div style="text-align: right; color:#979797; margin-top: 3px;">
		<ul class="top_header">
			@guest
				<li><a href="{{ route('login') }}" style="color: #8B8B8B"><i class="fa fa-sign-in"></i> @if(session()->has('en')) Login @else Masuk @endif</a></li>
				<li> <a href="{{ route('register') }}" style="color: #8B8B8B"><i class="fa fa-user"></i> @if(session()->has('en')) Register @else Daftar @endif</a></li>
				<li><span style="display:inline-block; width: 5px;"></span>|<span style="display:inline-block; width: 5px;"></span></li>
                @if(session()->has('en'))
                	<li><a class="@yield('menu_translate')" href="{{ route('translate') }}" class="li_menu"><img src="{{asset('img/logo/indo.png')}}" width="20px"> Indonesian</a></li>
                @else 
                	<li><a class="@yield('menu_translate')" href="{{ route('translate') }}" class="li_menu"><img src="{{asset('img/logo/british.png')}}" width="20px"> English</a></li>
                @endif
			@else
				<li>
				    <style>
				        .dropdown2 {
                          float: left;
                          overflow: hidden;
                        }
                        
                        .dropdown2 {
                          font-size: 16px;  
                          border: none;
                          outline: none;
                          background-color: inherit;
                          font-family: inherit;
                          margin: 0;
                        }
                        
                        .dropdown-content {
                          display: none;
                          position: absolute;
                          background-color: #f9f9f9;
                          min-width: 160px;
                          box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
                          z-index: 9;
                        }
                        
                        .dropdown-content a {
                          color: black;
                          padding: 12px 16px;
                          border-radius: 3px;
                          text-decoration: none;
                          display: block;
                          text-align: left;
                        }
                        
                        .dropdown-content a:hover {
                          background-color: #ddd;
                        }
                        
                        .dropdown2:hover .dropdown-content {
                          display: block;
                        }
				    </style>
					<div class="dropdown2">
	                    <a href="#">{{ DormAuth::User()->username }} <span class="caret"></span></a>

	                    <div class="dropdown-content">
	                    	<a href="{{ route('dashboard') }}">
	                            @if(session()->has('en')) Dashboard @else Beranda @endif
	                        </a>
	                        <a href="{{ route('SSOLogout') }}">
	                            @if(session()->has('en')) Logout @else Keluar @endif
	                        </a>
	                    </div>
	                </div>
                </li>
                <li>|<span style="display:inline-block; width: 10px;"></span></li>
                @if(session()->has('en'))
                	<li><a class="@yield('menu_translate')" href="{{ route('translate') }}" class="li_menu"><img src="{{asset('img/logo/indo.png')}}" width="20px"> Indonesian</a></li>
                @else 
                	<li><a class="@yield('menu_translate')" href="{{ route('translate') }}" class="li_menu"><img src="{{asset('img/logo/british.png')}}" width="20px"> English</a></li>
                @endif
                
			@endguest
		</ul>
</div>
<div class="icon" id="icon">
			<i class="fa fa-navicon" style="font-size: 30px; color: #0769B0;"></i>
</div>
	<div class="row" style="margin-bottom: 5px;">
		<div class="col-md-2"><a href="{{url('/')}}"><img src="{{ asset('img/logo/logoasrama3.png') }}" class="logo" alt="logo"></a></div>
		<div class="col-md-7">
			<nav class="navigation" id="navigation">
				<ul>
					@if (isset(DormAuth::User()->empty))
						@if(session()->has('en'))
		                	<li class="small_top_header"><a class="@yield('menu_translate')" href="{{ route('translate') }}" class="li_menu"><img src="{{asset('img/logo/indo.png')}}" width="20px"> Indonesian</a></li>
		                @else 
		                	<li class="small_top_header"><a class="@yield('menu_translate')" href="{{ route('translate') }}" class="li_menu"><img src="{{asset('img/logo/british.png')}}" width="20px"> English</a></li>
		                @endif
						<li class="small_top_header"><a href="{{ route('login') }}" style="color: #8B8B8B"><i class="fa fa-sign-in"></i> @if(session()->has('en')) Login @else Masuk @endif</a></li>
					@else
						<div class="small_top_header">
                            @if(session()->has('en'))
			                	<li><a class="@yield('menu_translate')" href="{{ route('translate') }}" class="li_menu"><img src="{{asset('img/logo/indo.png')}}" width="20px"> Indonesian</a></li>
			                @else 
			                	<li><a class="@yield('menu_translate')" href="{{ route('translate') }}" class="li_menu"><img src="{{asset('img/logo/british.png')}}" width="20px"> English</a></li>
			                @endif
							<li><a href="{{ route('dashboard') }}">{{ DormAuth::User()->username }}</a></li>
                        </div>
					@endif
					@if(!isset(DormAuth::User()->empty))
					    <li><a class="@yield('menu_dash')" href="{{route('dashboard')}}" class="li_menu">@if(session()->has('en')) Dashboard @else Beranda @endif</a></li>
					@endif
					<li><a class="@yield('menu_tentang')" href="{{url('/about')}}" class="li_menu">@if(session()->has('en')) About @else Tentang @endif</a></li>
					<li><a class="@yield('menu_asrama')" href="{{url('/asrama')}}" class="li_menu">@if(session()->has('en')) Dormitory @else Asrama @endif</a></li>
					<li><a class="@yield('menu_informasi')" href="{{url('/informasi/pendaftaran')}}" class="li_menu">@if(session()->has('en')) Information @else Informasi @endif</a></li>
					<li><a href="https://asrama.itb.ac.id/pembinaan" target="_blank" class="li_menu">@if(session()->has('en')) Nurturing @else Pembinaan @endif</a></li>
					<li><a class="@yield('menu_download')" href="{{url('/download')}}" class="li_menu">@if(session()->has('en')) Download @else Unduh @endif</a></li>
					<li class="small_top_header">
						<a href="{{ route('SSOLogout') }}"> @if(session()->has('en')) Logout @else Keluar @endif
                        </a>
                    </li>
				</ul>
			</nav>
		</div>
	</div>
</div>
<script type="text/javascript">
	$(document).ready(function() {
		var top = 70;
		var i = 1;
		$("#icon").click(function(){
			i += 1;
			if(i%2==0){
				top = 360;
				//$("#smooth").css("height","200px");
			}else{
				top = 70;
			}
			$("#navigation").toggle(500);
		});
		$('#top').removeClass('top');
		$(window).on('scroll', function () {
			if (top <= $(window).scrollTop()) {
				// if so, add the fixed class
				$('#top').addClass('top');
				$('#smooth').removeClass('smooth');
			} else {
				// otherwise remove it
				$('#top').removeClass('top');
				$('#smooth').addClass('smooth');
			}
		});
		$('.search_icon').click(function(){
			$('.search').css("display","block");
			$('.search_button').css("display","block");
			$('.close_icon').css("display","block");
			$('.search_icon').css("display","none");
		});
		$('.close_icon').click(function(){
			$('.search').css("display","none");
			$('.search_button').css("display","none");
			$('.close_icon').css("display","none");
			$('.search_icon').css("display","block");
		});
	});
</script>
<style>
	.top{
		position: fixed;
		top: 0;
		left: 0;
		z-index: 999;
		width: 100%;
	}
	.smooth{
		display: none;
	}
</style>
<div id="smooth" class="smooth" style="height: 60px;">
	
</div>
<div id="top" class="top">
	<div class="header_box">
	<div class="container">
		<div class="row">
			<div class="col-xs-8">
				<h3 style="color: #C1C1C1; margin: 0px 0px 0px 0px;">@yield('header_title')</h3 sty
				>
			</div>
			<div class="col-xs-4" style="text-align: right">
				<div class="search_box">
					<table align="right">
						<tr>
							<form action="{{ route('search') }}" method="POST">
								{{ csrf_field() }}
							<td><input id="search" name="search" type="text" class="search" placeholder="Search UPT Asrama ITB" required></td>
							<td><button id="search_button" type="submit" class="search_button"><i class="fa fa-search" style="font-size: 20px; color: white"></i></button></td>
							</form>
							<td style="padding: 5px 0px 5px 5px;"><button class="search_icon" type="button" style="border: none; background-color: transparent;"><i class="fa fa-search" style="font-size: 20px; color: white"></i></button><button class="close_icon" type="button" style="border: none; background-color: transparent;"><i class="fa fa-close" style="font-size: 20px; color: white;"></i></button></td>
						</tr>
					</table>
					
				</div>
			</div>
		</div>
	</div>
	</div>
</div>
@show
<script type="text/javascript">
	$(document).ready(function () {
		$('#translate').click(function(){
			$('#translator').toggle(500);
		});
	});
</script>
        
	@yield('content')

<div style="height: 15px; width: 100%; background-color: #205081"></div>
<div class="footer">
	<div class="container">
		<div class="row">
			<div class="col-md-4">
				<address>
					<!-- <span style="display: inline-block; width: 60px;"><a href="#page-top" class="js-scroll-trigger"><img src="{{ asset('img/logo/logo.png') }}" width="50px;" style="border-radius: 5px;"></a></span> -->
					<h3 style="margin-top: 0px;"><b>UPT Asrama ITB</b></h3><br>
					@if(session()->has('en')) 10 Ganesha Street, Bandung @else Jalan Ganesha 10, Bandung @endif<br>
					@if(session()->has('en')) East Campus Center Building, the Second flor @else Gedung Campus Center Timur Lantai 2 @endif<br>
					@if(session()->has('en')) Postal Code: 40132 @else Kode Pos: 40132 @endif<br>
					+62 22-2534119 | +62 811-2295-723<br>
					Email: sekretariat@asrama.itb.ac.id<br><br>
					@if(session()->has('en')) Working Hours: 08.30 - 16.30 WIB (GMT + 7) @else Jam Kerja 08.00 - 16.30 WIB @endif<br>
					@if(session()->has('en')) Break and Lunch: 12.00 - 13.00 WIB (GMT + 7) @else Istirahat 12.00 - 13.00 WIB @endif<br>
					<hr style="background-color: white">
					<span style="display: inline-block; width: 90px;"><a href="http://seabaditb.id/" target="_blank"><img src="{{ asset('img/logo/ppid.png') }}" width="90px;"></a></span>
					<span style="display: inline-block; width: 90px;"><a href="http://seabaditb.id/" target="_blank"><img src="{{ asset('img/logo/ITB1000.png') }}" width="90px;"></a></span>
					<span style="display: inline-block; width: 140px;"><a href="https://www.lapor.go.id/"><img src="{{ asset('img/logo/lapor.png') }}" width="140px;"></a></span>
				</address><br>
			</div>
			<div class="col-md-8" style="font-size: 13px;">
				<div class="row">
					<div class="col-md-3">
						<b>@if(session()->has('en')) About @else Tentang @endif</b><hr style="margin: 2px 0px 5px 0px">
						<a class="link_footer" href="{{url('/about')}}">@if(session()->has('en')) Dormitory at Glance @else Gambaran Umum @endif</a><br>
						<a class="link_footer" href="{{url('/about/struktur_organisasi')}}">@if(session()->has('en')) Organization Structure @else Struktur Organisasi @endif</a><br><br>
						<b>@if(session()->has('en')) Dormitory @else Asrama @endif</b><hr style="margin: 2px 0px 5px 0px">
						<a class="link_footer" href="{{url('/asrama')}}">@if(session()->has('en')) Kidang Pananjung Dormitory @else Asrama Kidang Pananjung @endif</a><br>
						<a class="link_footer" href="{{url('/asrama')}}">@if(session()->has('en')) Sangkuriang Dormitory @else Asrama Sangkuriang @endif</a><br>
						<a class="link_footer" href="{{url('/asrama')}}">@if(session()->has('en')) Kanayakan Dormitory @else Asrama Kanayakan @endif</a><br>
						<a class="link_footer" href="{{url('/asrama')}}">@if(session()->has('en')) Jatinangor Dormitory @else Asrama Jatinangor @endif</a><br>
						<a class="link_footer" href="{{url('/asrama')}}">@if(session()->has('en')) International Dormitory @else Asrama Internasional @endif</a><br><br>
					</div>
				<!--	<div class="col-md-2">
						<b>Pembinaan</b><hr style="margin: 2px 0px 5px 0px">
						<a class="link_footer" href="#">Tutor Asrama ITB</a><br>
						<a class="link_footer" href="#">Pembinaan Karakter</a><br>
						<a class="link_footer" href="#">Layanan</a><br>
						<a class="link_footer" href="#">Kegiatan Penghuni</a><br><br><br>
					</div>-->
					<div class="col-md-3">
						<b>@if(session()->has('en')) Information @else Informasi @endif</b><hr style="margin: 2px 0px 5px 0px">
						<a class="link_footer" href="{{url('/informasi/pendaftaran')}}">@if(session()->has('en')) Registration @else Pendaftaran @endif</a><br>
						<a class="link_footer" href="{{url('/berita')}}">@if(session()->has('en')) News @else Berita @endif</a><br>
						<a class="link_footer" href="{{url('/pengumuman')}}">@if(session()->has('en')) Announcement @else Pengumuman @endif</a><br>
						<a class="link_footer" href="{{route('peta')}}">@if(session()->has('en')) Maps @else Peta @endif</a><br><br>

						
						<!--<a class="link_footer" href="#">Hubungi Kami</a>-->
					</div>
					<!--<div class="col-md-2">
						<b>Download</b><hr style="margin: 2px 0px 5px 0px">
						<a class="link_footer" href="#">Lembar Kendali</a><br>
						<a class="link_footer" href="#">Form Perizinan</a><br>
						<a class="link_footer" href="#">Form Surat</a><br>
						<a class="link_footer" href="#">Peraturan Umum</a><br><br><br>
					</div>-->
					<div class="col-md-3">
						<b>@if(session()->has('en')) Bandung Institute of Technology @else Institut Teknologi Bandung @endif</b><hr style="margin: 2px 0px 5px 0px">
						<a class="link_footer" target="_blank" href="https://itb.ac.id">Website ITB</a><br>
						<a class="link_footer" target="_blank" href="https://ppid.itb.ac.id">@if(session()->has('en')) Public Information (PPID) @else Info Publik (PPID) @endif</a><br>
						<a class="link_footer" target="_blank" href="http://journals.itb.ac.id/">Journal</a><br>
						<a class="link_footer" target="_blank" href="http://research.lppm.itb.ac.id/">@if(session()->has('en')) Research @else Hasil Penelitian @endif</a><br>
						<a class="link_footer" target="_blank" href="https://digilib.itb.ac.id/">@if(session()->has('en')) Digital Library @else Perpustakaan Digital @endif</a><br>
						<a class="link_footer" target="_blank" href="https://pditt.kuliah.itb.ac.id/">@if(session()->has('en')) Online Learning (PPID) @else Pembelajaran Jarak Jauh @endif</a><br>
						<br>
					</div>
				</div>
			</div>
		</div>
		<!-- <div style="text-align: right;">
			Test aja
		</div> -->
	</div>
</div>
<div style="background-color: #5C5C5C; color: white; padding: 10px 0px 10px 0px">
	<div class="container" style="text-align: center;">
		<small style="margin-top: 0px">
			@if(session()->has('en')) 
				We only use available phone number listed on the web for communication. It is not our responsibility for any stranger who contact you on behalf of UPT Asrama ITB. 
			@else 
				Untuk komunikasi via telepon, kami hanya
				menggunakan nomor di atas dan tidak bertanggung jawab
				atas segala kontak selain yang disebutkan dengan
				mengatasnamakan UPT Asrama ITB.
			@endif
			
		</small>
	</div>
</div>
<div style="padding: 10px 0px 10px 0px; background-color: #2F2F2F; color: white;">
		<div style="text-align: center; font-size: 10px;">
			@if(session()->has('en')) Copyright @else Hak Cipta @endif &copy; 2018-2019 asrama.itb.ac.id &mdash; v.2.0
		</div>
</div>

	@yield('scripts')
</body>
</html>

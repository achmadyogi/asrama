<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>UPT Asrama ITB | @yield('title')</title>
<!-- next -->

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
<script
  src="https://code.jquery.com/jquery-3.3.1.min.js"
  integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
  crossorigin="anonymous"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<script type= "text/javascript" src = "{{ asset('js/countries.js') }}"></script>
<script src="{{ asset('js/app.js') }}" defer></script>
<link href="{{ asset('css/app.css') }}" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('css/default.css') }}" type="text/css">
<link rel="stylesheet" href="{{ asset('css/search.css') }}" type="text/css">
<link rel="stylesheet" href="{{ asset('css/main.css') }}" type="text/css">
<!-- maps -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.3.1/dist/leaflet.css"
   integrity="sha512-Rksm5RenBEKSKFjgI3a41vrjkw4EVPlJ3+OiI65vTjIdo9brlAacEuKOiQ5OFh7cOI1bkDwLqdLw3Zg0cRJAAQ=="
   crossorigin=""/>
<script src="https://unpkg.com/leaflet@1.3.1/dist/leaflet.js"
   integrity="sha512-/Nsx9X4HebavoBvEBuyp3I7od5tA0UzAxs+j83KgC8PU0kgB4XiK4Lfe4y4cgBtaRJQEIFCW+oC506aPT2L1zw=="
   crossorigin=""></script>
</head>
<link rel="shorcut icon" href="{{ asset('img/logo/logo.png') }}"/>
<body style="font-family: Helvetica; color: black; background-color: #ECF0F5;">
@section('main_menu')
<div class="container">
<div style="text-align: right; color:#979797; margin-top: 3px;">
		<ul class="top_header">
			@guest
				<li><a href="{{ route('login') }}" style="color: #8B8B8B"><i class="fa fa-sign-in"></i> login</a></li>
				<li> <a href="{{ route('register') }}" style="color: #8B8B8B"><i class="fa fa-user"></i> register</a></li>
			@else
				<li class="nav-item dropdown">
                    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>{{ Auth::user()->username }} <span class="caret"></span></a>

                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    	<a class="dropdown-item" href="{{ route('dashboard') }}">
                            Dashboard
                        </a><br>
                        <a class="dropdown-item" href="{{ route('logout') }}"onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                            Logout
                        </a>

                    	<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">{{ csrf_field() }}</form>
                    </div>
                </li>
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
					@if (Auth::guest())
						<li class="small_top_header"><a href="{{ route('login') }}" style="color: #8B8B8B"><i class="fa fa-sign-in"></i> login</a></li>
					@else
						<div class="small_top_header">
							<li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->username }} <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                	<a class="dropdown-item" href="{{ route('dashboard') }}">
                                        Dashboard
                                    </a><br>
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        Logout
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        </div>
					@endif
					@if(!Auth::guest())
					    <li><a class="@yield('menu_dash')" href="{{route('dashboard')}}" class="li_menu">Dashboard</a></li>
					@endif
					<li><a class="@yield('menu_tentang')" href="{{url('/about')}}" class="li_menu">Tentang</a></li>
					<li><a class="@yield('menu_asrama')" href="{{url('/asrama')}}" class="li_menu">Asrama</a></li>
					<!-- <li><a class="@yield('menu_pembinaan')" href="{{url('/pembinaan')}}" class="li_menu">Pembinaan</a></li> -->
					<li><a class="@yield('menu_informasi')" href="{{url('/informasi/pendaftaran')}}" class="li_menu">Informasi</a></li>
					<li><a class="@yield('menu_download')" href="{{url('/download')}}" class="li_menu">Download</a></li>

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
			</div>
		</div>
	</div>
	</div>
</div>
@show

	@yield('content')

<div style="height: 15px; width: 100%; background-color: #205081"></div>
<div class="footer">
<div class="container">
	<div class="row">
		<div class="col-md-4">
			<address>
				<h3 style="margin-top: 0px;"><b>UPT Asrama ITB</b></h3><br>
				Jalan Ganesha 10, Bandung<br>
				Gedung Campus Center Timur Lantai 2<br>
				Kode Pos: 40132<br>
				022-2534119 (telepon)<br>
				Email: sekretariat@asrama.itb.ac.id<br>
			</address><br>
		</div>
		<div class="col-md-8" style="font-size: 13px;">
			<div class="row">
				<div class="col-md-2">
					<b>Tentang</b><hr style="margin: 2px 0px 5px 0px">
					<a class="link_footer" href="{{url('/about')}}">Gambaran Umum</a><br>
					<a class="link_footer" href="{{url('/about/struktur_organisasi')}}">Struktur Organisasi</a><br>
				</div>
				<div class="col-md-3">
					<b>Asrama</b><hr style="margin: 2px 0px 5px 0px">
					<a class="link_footer" href="{{url('/asrama')}}">Asrama Kidang Pananjung</a><br>
					<a class="link_footer" href="{{url('/asrama')}}">Asrama Sangkuriang</a><br>
					<a class="link_footer" href="{{url('/asrama')}}">Asrama Kanayakan</a><br>
					<a class="link_footer" href="{{url('/asrama')}}">Asrama Jatinangor</a><br>
					<a class="link_footer" href="{{url('/asrama')}}">Asrama International</a><br>
					<!--<a class="link_footer" href="#">Asrama Bumi Ganesha</a><br><br><br>-->
				</div>
			<!--	<div class="col-md-2">
					<b>Pembinaan</b><hr style="margin: 2px 0px 5px 0px">
					<a class="link_footer" href="#">Tutor Asrama ITB</a><br>
					<a class="link_footer" href="#">Pembinaan Karakter</a><br>
					<a class="link_footer" href="#">Layanan</a><br>
					<a class="link_footer" href="#">Kegiatan Penghuni</a><br><br><br>
				</div>-->
				<div class="col-md-2">
					<b>Informasi</b><hr style="margin: 2px 0px 5px 0px">
					<a class="link_footer" href="{{url('/informasi/pendaftaran')}}">Pendaftaran</a><br>
					<a class="link_footer" href="{{url('/berita')}}">Berita</a><br>
					<a class="link_footer" href="{{url('/pengumuman')}}">Pengumuman</a><br>
					<a class="link_footer" href="{{route('peta')}}">Peta</a><br>
					<!--<a class="link_footer" href="#">Hubungi Kami</a>-->
					<br><br><br>
				</div>
				<!--<div class="col-md-2">
					<b>Download</b><hr style="margin: 2px 0px 5px 0px">
					<a class="link_footer" href="#">Lembar Kendali</a><br>
					<a class="link_footer" href="#">Form Perizinan</a><br>
					<a class="link_footer" href="#">Form Surat</a><br>
					<a class="link_footer" href="#">Peraturan Umum</a><br><br><br>
				</div>-->
				<div class="col-md-1">
					
				</div>
			</div>
		</div>
	</div><br><br>
	<div style="text-align: center; font-size: 10px;">
		Copyright &copy; 2018-2019 asrama.itb.ac.id &mdash; v.2.0
	</div>
</div>
</div>

	@yield('scripts')
</body>
</html>

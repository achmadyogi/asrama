<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>UPT Asrama ITB | @yield('title')</title>
<!-- untuk chart -->
<link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
<!-- next -->
<script
  src="https://code.jquery.com/jquery-3.3.1.min.js"
  integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
  crossorigin="anonymous"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
<script type= "text/javascript" src = "{{ asset('js/countries.js') }}"></script>
<script src="{{ asset('js/app.js') }}" defer></script>
<link href="{{ asset('css/app.css') }}" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('css/default.css') }}" type="text/css">
<link rel="stylesheet" href="{{ asset('css/main.css') }}" type="text/css">
<!--formden.js communicates with FormDen server to validate fields and submit via AJAX -->
<script type="text/javascript" src="https://formden.com/static/cdn/formden.js"></script>

<!-- Special version of Bootstrap that is isolated to content wrapped in .bootstrap-iso -->
<link rel="stylesheet" href="https://formden.com/static/cdn/bootstrap-iso.css" />

<!--Font Awesome (added because you use icons in your prepend/append)-->
<link rel="stylesheet" href="https://formden.com/static/cdn/font-awesome/4.4.0/css/font-awesome.min.css" />
<!-- Inline CSS based on choices in "Settings" tab -->
<style>.bootstrap-iso .formden_header h2, .bootstrap-iso .formden_header p, .bootstrap-iso form{font-family: Arial, Helvetica, sans-serif; color: black}.bootstrap-iso form button, .bootstrap-iso form button:hover{color: white !important;} .asteriskField{color: red;}</style>
</head>
<link rel="shorcut icon" href="{{ asset('img/logo/logo.png') }}"/>
<body style="font-family: Century Gothic; color: black;">
@section('main_menu')
<div class="container">
<div style="text-align: right; color:#979797; margin-top: 3px;">
		<ul class="top_header">
			@guest
				<li><a href="{{ route('login') }}" style="color: #8B8B8B"><i class="fa fa-sign-in"></i> login</a></li>
				<li><a href="{{ route('register') }}" style="color: #8B8B8B"><i class="fa fa-user"></i> register</a></li>
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
		<div class="col-md-2"><a href="/"><img src="{{ asset('img/logo/logoasrama3.png') }}" class="logo" alt="logo"></a></div>
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
					<li><a class="@yield('menu_tentang')" href="/about" class="li_menu">Tentang</a></li>
					<li><a class="@yield('menu_asrama')" href="#" class="li_menu">Asrama</a></li>
					<li><a class="@yield('menu_pembinaan')" href="/pembinaan" class="li_menu">Pembinaan</a></li>
					<li><a class="@yield('menu_informasi')" href="/informasi/pendaftaran" class="li_menu">Informasi</a></li>
					<li><a class="@yield('menu_download')" href="#" class="li_menu">Download</a></li>
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
							<td><input id="search" type="text" class="search" placeholder="Search UPT Asrama ITB" ></td>
							<td><button id="search_button" type="submit" class="search_button"><i class="fa fa-search" style="font-size: 20px; color: white"></i></button></td>
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
				089615098438 | 089660552121 (telepon)<br>
				Email: sekretariat.asramaitb@gmail.com<br>
			</address><br>
		</div>
		<div class="col-md-8" style="font-size: 13px;">
			<div class="row">
				<div class="col-md-2">
					<b>Tentang</b><hr style="margin: 2px 0px 5px 0px">
					<a class="link_footer" href="#">Organisasi</a><br>
					<a class="link_footer" href="#">Sejarah</a><br>
					<a class="link_footer" href="#">Visi dan Misi</a><br>
					<a class="link_footer" href="#">Proyek</a><br><br><br>
				</div>
				<div class="col-md-3">
					<b>Asrama</b><hr style="margin: 2px 0px 5px 0px">
					<a class="link_footer" href="#">Asrama Kidang Pananjung</a><br>
					<a class="link_footer" href="#">Asrama Sangkuriang</a><br>
					<a class="link_footer" href="#">Asrama Kanayakan</a><br>
					<a class="link_footer" href="#">Asrama Jatinangor</a><br>
					<a class="link_footer" href="#">Asrama International</a><br>
					<a class="link_footer" href="#">Asrama Bumi Ganesha</a><br><br><br>
				</div>
				<div class="col-md-2">
					<b>Pembinaan</b><hr style="margin: 2px 0px 5px 0px">
					<a class="link_footer" href="#">Tutor Asrama ITB</a><br>
					<a class="link_footer" href="#">Pembinaan Karakter</a><br>
					<a class="link_footer" href="#">Layanan</a><br>
					<a class="link_footer" href="#">Kegiatan Penghuni</a><br><br><br>
				</div>
				<div class="col-md-2">
					<b>Informasi</b><hr style="margin: 2px 0px 5px 0px">
					<a class="link_footer" href="#">Pendaftaran</a><br>
					<a class="link_footer" href="#">Fasilitas</a><br>
					<a class="link_footer" href="#">Peta</a><br>
					<a class="link_footer" href="#">Hubungi Kami</a><br><br><br>
				</div>
				<div class="col-md-2">
					<b>Download</b><hr style="margin: 2px 0px 5px 0px">
					<a class="link_footer" href="#">Lembar Kendali</a><br>
					<a class="link_footer" href="#">Form Perizinan</a><br>
					<a class="link_footer" href="#">Form Surat</a><br>
					<a class="link_footer" href="#">Peraturan Umum</a><br><br><br>
				</div>
				<div class="col-md-1">
					
				</div>
			</div>
		</div>
	</div><br><br>
	<div style="text-align: center; font-size: 10px;">
		Copyright &copy; 2017-2018 asrama.itb.ac.id
	</div>
</div>
</div>

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/js/bootstrap-datepicker.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/css/bootstrap-datepicker3.css"/>
<script>
	$(document).ready(function(){
		var date_input=$('input[name="date"]'); //our date input has the name "date"
		var container=$('.bootstrap-iso form').length>0 ? $('.bootstrap-iso form').parent() : "body";
		date_input.datepicker({
			format: 'yyyy-mm-dd',
			container: container,
			todayHighlight: true,
			autoclose: true,
		})
	})
</script>
</body>
</html>

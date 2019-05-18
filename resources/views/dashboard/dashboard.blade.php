@extends('layouts.default')

@if(session()->has('en')) @section('title','Dashboard') @else @section('title','Beranda') @endif

@section('menu_dash','active')
@section('main_menu')
	@parent

@endsection

@if(session()->has('en')) @section('header_title','Dashboard') @else @section('header_title','Beranda') @endif

@section('content')
<div class="container">
	<br><br>
	<!-- KONTEN UTAMA-->
	<div id="content">
		<!-- ALERT -->
		@if (session()->has('status1'))
			<div class="alert_fail">
				{{session()->get('status1')}}
			</div><br> 
		@elseif (session()->has('status2'))
			<div class="alert_success">
				{{session()->get('status2')}}
			</div><br>
		@endif
		@if(ITBdorm::DataUser(DormAuth::User()->id)->id_penghuni == NULL)
			<!-- TRIGER UNTUK PENDAFTARAN DATA DIRI-->
			@include('dashboard.penghuni.pendaftaran')
			<hr>
		@elseif(DormAuth::User()->is_penghuni=='0'&&DormAuth::User()->is_sekretariat=='0'&&DormAuth::User()->is_pengelola=='0'&&DormAuth::User()->is_admin=='0'&&DormAuth::User()->is_pimpinan=='0')
			<!-- TRIGER UNTUK PENDAFTARAN PENGHUNI ASRAMA -->
			@if(session()->has('en'))
				<h1><b>General Information</b></h1>
				<p>Thank you for joining us! You can proceed the registration under the following terms and condition.
					<h4><b>REGULAR OCCUPANT</b></h4>This type of occupancy is intentionally made for an active ITB student. It provides structured living period to support academic activities around campuses. Once a student signing up for a regular category, he will be living for about 5 months in accordance with the academic calendar.<br>
					<h4><b>NON REGULAR OCCUPANT</b></h4>The Non Regular living period is designed for a short time living. Currently, we can not receive an application from strangers who have no businesses or important purposes towards the university. To obtain the eligibility, you must fill in an online registration form and send a formal letter from your organization to WRAM ITB that contains an explanation about your purposes and intentions to stay at the dormitory for few days. After your permission is approved, we will proceed your living plan as well.
				</p><br>
			@else	
				<h1><b>Informasi Pendaftaran</b></h1>
				<p>jgfjghTerimakasih telah bergabung dengan UPT Asrama ITB. Silahkan daftarkan diri Anda untuk permohonan tinggal di asarama.
					Syarat dan ketentuan adalah sebagai berikut:<br>
					<h4><b>PENGHUNI REGULER</b></h4>Penghuni reguler adalah penghuni dengan status mahasiswa ITB. Seorang penghuni reguler hanya dapat mendaftar pada periode tertentu yang waktunya telah ditetapkan oleh pihak asrama.<br>
					<h4><b>PENGHUNI NON REGULER</b></h4>Penghuni Non Reguler terbuka bagi siapa saja yang ingin mendaftar ke asrama. Penghuni Non Reguler dapat menetapkan tanggal masuk dan tanggal keluar dari asrama sesuai keperluan tinggal.
				</p><br>
			@endif
		<div style="text-align: center;"><a href="{{url('/dashboard/penghuni/pendaftaran_penghuni')}}"><button class="button">@if(session()->has('en')) Register Now @else Daftar Sekarang @endif</button></a>
			</div><br><br>
		@endif

	</div>
	<div style="margin-top: 0px; height: 4px; background-color: #0769B0; border-top-left-radius: 3px; border-top-right-radius: 3px;"></div>
	<div class="sider_body" style="background-color: white; border-radius: 0px; color: black; padding-left: 20px; padding-right: 20px;">
		<h4><b><span class="fa fa-address-card"></span> @if(session()->has('en')) User Information @else Informasi Pengguna @endif</b></h4><hr>
		<br>
		<div class="row">
			<div class="col-md-3">
				<div style="text-align: center; position: absolute; top: 70px; left: 50%; margin: -80px 0px 0px -80px;">
				<div style='background-color: white; width: 130px; max-width: 100%; height: 130px; overflow: hidden;margin-top: 0px; position: relative; border-radius: 50%; border: 2px solid black;'>
					@if(ITBdorm::DataUser(DormAuth::User()->id)->id_penghuni == NULL)
					<img src="{{asset('img/profil/default_men.png')}}" style='position:absolute; left: -100%; right: -100%; top: -100%; bottom: -100%; margin: auto; min-height: 100%; min-width: 100%;' width='50px;'height='50px;' alt='user'>
					@elseif(DormAuth::User()->foto_profil == NULL && ITBdorm::DataUser(DormAuth::User()->id)->jenis_kelamin == 'L')
					<img src="{{asset('img/profil/default_men.png')}}" style='position:absolute; left: -100%; right: -100%; top: -100%; bottom: -100%; margin: auto; min-height: 100%; min-width: 100%;' width='50px;'height='50px;' alt='user'>
					@elseif(DormAuth::User()->foto_profil == NULL && ITBdorm::DataUser(DormAuth::User()->id)->jenis_kelamin == 'P')
					<img src="{{asset('img/profil/default_women.png')}}" style='position:absolute; left: -100%; right: -100%; top: -100%; bottom: -100%; margin: auto; min-height: 100%; min-width: 100%;' width='50px;'height='50px;' alt='user'>
					@else
					<img src="/storage/avatars/{{ DormAuth::User()->foto_profil }}" style='position:absolute; left: -100%; right: -100%; top: -100%; bottom: -100%; margin: auto; width: 170%; min-height: 100%; min-width: 100%;' width='130px;' alt='user'>
					@endif 
				</div><br>
				</div>
			</div>
			<div class="col-md-2" style="text-align: center;">
				<span class="fa fa-user" style="font-size: 70px;"></span>
				<h4><i>Username</i></h4>
				<h4><b>{{DormAuth::User()->username}}</b></h4>
			</div>
			<div class="col-md-3" style="text-align: center;">
				<span class="fa fa-drivers-license-o" style="font-size: 70px;"></span>
				<h4><i>@if(session()->has('en')) Full Name @else Nama Lengkap @endif</i></h4>
				<h4><b>{{DormAuth::User()->name}}</b></h4>
			</div>
			<div class="col-md-3" style="text-align: center;">
				<span class="fa fa-envelope" style="font-size: 70px;"></span>
				<h4><i>Email</i></h4>
				<h4><b>{{DormAuth::User()->email}}</b></h4>
			</div>
		</div><br>
	</div><br><br><br>
	<div class="row">
		<div class="col-md-4">
			<div style="text-align: center; vertical-align: middle;">
				<span class="fa fa-share-square-o" style="font-size: 100px; color: #0769B0;"></span><br><h3 style="color: #0769B0"><b>@if(session()->has('en')) Account Management @else Manajemen Akun @endif</b></h3><hr>
				@if(ITBdorm::DataUser(DormAuth::User()->id)->id_penghuni != NULL)
					<h4 style="color: #0769B0; margin-bottom: 0px;"><b>@if(session()->has('en')) User Profile @else Data Diri @endif</b></h4>
					<div style="background-color: #0769B0; height: 3px; width: 200px; display: inline-block;"></div>
					<h4><a href="{{route('dataDiri')}}">@if(session()->has('en')) User Profile Information @else Informasi Data Diri @endif</a></h4>
	            	@if(ITBdorm::DataUser(DormAuth::User()->id)->id_nim != NULL)
						<h4><a href="{{route('lihat_nim')}}">@if(session()->has('en')) Edit NIM @else Atur NIM @endif</a></h4>
						<h4><a href="{{route('lihat_no_reg')}}"> @if(session()->has('en')) Edit Registration Number @else Atur Nomor Registrasi @endif</a></h4>
	            	@endif
	            @endif<br>
	            <h4 style="color: #0769B0;  margin-bottom: 0px;"><b>@if(session()->has('en')) Account Setting @else Pengaturan Akun @endif</b></h4>
				<div style="background-color: #0769B0; height: 3px; width: 200px; display: inline-block;"></div>
	            	<h4><a href="{{route('ganti_username')}}">@if(session()->has('en')) Change Username @else Ganti Username @endif</a></h4>
	            	<h4><a href="{{route('ganti_email')}}">@if(session()->has('en')) Change Email @else Ganti Email @endif</a></h4>
	            	<h4><a href="{{route('password')}}">@if(session()->has('en')) Change Password @else Ganti Password @endif</a></h4>
			</div><br><br>
		</div>
		<div class="col-md-4">
			<div style="text-align: center; vertical-align: middle;">
				@if(ITBdorm::DataUser(DormAuth::User()->id)->id_nim != NULL)
				<span class="fa fa-group" style="font-size: 100px; color: #175123"></span><br><h3 style="color: #175123"><b>@if(session()->has('en')) Occupant @else Penghuni @endif</b></h3><hr>
				
					<h4 style="color: #175123; margin-bottom: 0px;"><b>@if(session()->has('en')) Services @else Layanan @endif</b></h4>
					<div style="background-color: #175123; height: 3px; width: 200px; display: inline-block;"></div>
					<h4><a href="{{ route('pendaftaran_penghuni') }}">@if(session()->has('en')) Registration @else Pendaftaran @endif</a></h4>
					<h4><a href="{{ route('form_pengajuan_keluar') }}">@if(session()->has('en')) Propose Expeltion @else Pengajuan Keluar @endif</a></h4>
	            @endif<br>
	            @if(DormAuth::User()->is_penghuni == 1)
	            <h4 style="color: #175123; margin-bottom: 0px;"><b>@if(session()->has('en')) Payment @else Pembayaran @endif</b></h4>
				<div style="background-color: #175123; height: 3px; width: 200px; display: inline-block;"></div>
	            	<h4><a href="{{ route('pembayaran_penghuni') }}">@if(session()->has('en')) Payment (via host-to-host) @else Pembayaran (host-to-host) @endif</a></h4>
	            	<h4><a href="{{ route('pembayaran_penghuni_rekening') }}">@if(session()->has('en')) Payment (via bank account) @else Pembayaran (Rekening Penampungan) @endif</a></h4>
	            	<h4><a href="{{ route('penangguhan_penghuni') }}">@if(session()->has('en')) Deferment @else Penangguhan Pembayaran @endif</a></h4>
	            <br>
	            @endif
			</div><br><br>
		</div>
		<div class="col-md-4">
			@if(DormAuth::User()->is_pengelola == 1)
			<div style="text-align: center; vertical-align: middle;">
				<span class="fa fa-asl-interpreting" style="font-size: 100px; color: #A75901"></span><br><h3 style="color: #A75901"><b>@if(session()->has('en')) The Dormitory Organizer @else Pengelola Asrama @endif</b></h3><hr>
				<h4 style="color: #A75901; margin-bottom: 0px;"><b>@if(session()->has('en')) Rooms @else Kamar @endif</b></h4>
				<div style="background-color: #A75901; height: 3px; width: 200px; display: inline-block;"></div>
	            	<h4><a href="{{ route('edit_kamar') }}">@if(session()->has('en')) Rooms Setting @else Atur Kamar @endif</a></h4>
	            	<h4><a href="{{ route('periksa_penghuni_aktif') }}">@if(session()->has('en')) Check Current Occupant @else Periksa Penghuni Aktif @endif</a></h4><br>
	            <h4 style="color: #A75901; margin-bottom: 0px;"><b>@if(session()->has('en')) Logistics @else Sarana dan Prasarana @endif</b></h4>
				<div style="background-color: #A75901; height: 3px; width: 200px; display: inline-block;"></div>
	            	<h4 style="color: grey"><i>@if(session()->has('en')) There is nothing to show @else Belum ada menu @endif</i></h4><br>
	   			<br>
			</div><br><br>
			@endif
		</div>
	</div>
	<div class="row">
		<div class="col-md-4">
			@if(DormAuth::User()->is_sekretariat == 1)
			<div style="text-align: center; vertical-align: middle;">
				<span class="fa fa-bank" style="font-size: 100px; color: #6C0062"></span><br><h4 style="color: #6C0062"><b>@if(session()->has('en')) Secretary Office @else Sekretariat @endif</b></h4><hr>
				
				<h4 style="color: #6C0062; margin-bottom: 0px;"><b>@if(session()->has('en')) Reguler Validation @else Validasi Reguler @endif</b></h4>
				<div style="background-color: #6C0062; height: 3px; width: 200px; display: inline-block;"></div>
	            	<h4><a href="{{ route('validasi_pendaftaran_reguler') }}">@if(session()->has('en')) New Intake @else Penerimaan Baru @endif</a></h4>
					<h4><a href="{{ route('daftarUlang') }}">@if(session()->has('en')) Secondary Registration @else Daftar Ulang @endif</a></h4>
	            	<h4><a href="{{ route('validasi_pembayaran') }}">@if(session()->has('en')) Payments @else Pembayaran @endif</a></h4><br>
	            <h4 style="color: #6C0062; margin-bottom: 0px;"><b>@if(session()->has('en')) Non-Reguler Validation @else Validasi Non Reguler @endif</b></h4>
				<div style="background-color: #6C0062; height: 3px; width: 200px; display: inline-block;"></div>
	            	<h4><a href="{{ route('validasi_pendaftaran_non_reguler') }}">@if(session()->has('en')) New Intake @else Penerimaan Baru @endif</a></h4>
	            	<h4><a href="{{ route('daftarUlangNon') }}">@if(session()->has('en')) Secondary Registration & Payments @else Daftar Ulang & Pembayaran @endif</a></h4><br>
	            <h4 style="color: #6C0062; margin-bottom: 0px;"><b>@if(session()->has('en')) Occupant Information @else Data Penghuni @endif</b></h4>
				<div style="background-color: #6C0062; height: 3px; width: 200px; display: inline-block;"></div>
	            	<h4><a href="{{ route('edit_periode') }}">@if(session()->has('en')) Create or Edit Period @else Buat / Atur Periode @endif</a></h4>
	            	<h4><a href="{{ route('periksa_penghuni_aktif') }}">@if(session()->has('en')) Check Current Occupant @else Periksa Penghuni Aktif @endif</a></h4>
	            <br>
			</div><br><br>
			@endif
		</div>
		<div class="col-md-4">
			@if(DormAuth::User()->is_admin == 1)
			<div style="text-align: center; vertical-align: middle;">
				<span class="fa fa-puzzle-piece" style="font-size: 100px;"></span><br><h4><b>Admin</b></h4><hr>
				
				<h4 style="margin-bottom: 0px;"><b>@if(session()->has('en')) Website Contents @else Konten Website @endif</b></h4>
				<div style="background-color: black; height: 3px; width: 200px; display: inline-block;"></div>
	            	<h4><a href="{{route('show_upload')}}">@if(session()->has('en')) Upload Files @else Unggah File @endif</a></h4>
					<h4><a href="{{route('show_tambah_pengumuman')}}">@if(session()->has('en')) Publish Announcement @else Unggah Pengumuman @endif</a></h4>
					<h4><a href="{{route('show_tambah_berita')}}">@if(session()->has('en')) Publish News @else Unggah Berita @endif</a></h4>
					<h4><a href="{{route('show_tambah_jadwal')}}">@if(session()->has('en')) Publish Schedules @else Unggah Jadwal Kegiatan @endif</a></h4><br>
				<h4 style="margin-bottom: 0px;"><b>@if(session()->has('en')) User Access Control @else Pengaturan Akses Penguna @endif</b></h4>
				<div style="background-color: black; height: 3px; width: 200px; display: inline-block;"></div>
	            	<h4><a href="{{route('users.index')}}">@if(session()->has('en')) Set Access @else Atur Akses @endif</a></h4>
	            	<h4><a href="{{route('list_pengajuan_keluar')}}">@if(session()->has('en')) List of Expeltion @else List Pengajuan Keluar @endif</a></h4>
					<h4><a href="{{route('halaman_checkout_otomatis')}}">@if(session()->has('en')) Automatic Checkout System @else Checkout Otomatis @endif</a></h4>
					<h4><a href="{{route('periksa_daftar_checkout')}}">@if(session()->has('en')) Checkout List @else Daftar Checkout @endif</a></h4>
					<br>
			</div><br><br>
			@endif
		</div>
		<div class="col-md-4">
			@if(DormAuth::User()->is_keuangan == 1)
			<div style="text-align: center; vertical-align: middle;">
				<span class="fa fa-bank" style="font-size: 100px; color: #08A090"></span><br><h4 style="color: #08A090"><b>@if(session()->has('en')) Finance @else Keuangan @endif</b></h4><hr>
				
				<h4 style="color: #08A090; margin-bottom: 0px;"><b>@if(session()->has('en')) Statistic @else Statistik @endif</b></h4>
				<div style="background-color: #08A090; height: 3px; width: 200px; display: inline-block;"></div>
	            	<h4><a href="{{ route('stat_keuangan') }}">@if(session()->has('en')) Finance Monitoring @else Monitor Keuangan @endif</a></h4><br>
	            <h4 style="color: #08A090; margin-bottom: 0px;"><b>Audit</b></h4>
				<div style="background-color: #08A090; height: 3px; width: 200px; display: inline-block;"></div>
	            	<h4><a href="{{ route('cekPembayaran') }}">@if(session()->has('en')) Occupant Payment Details @else Detail Pembayaran Penghuni @endif</a></h4>
	            <br>
			</div><br><br>
			@endif
		</div>
	</div>
	<div class="row">
		
		<div class="col-md-4">
			@if(DormAuth::User()->is_pimpinan == 1)
			<div style="text-align: center; vertical-align: middle;">
				<span class="fa fa-handshake-o" style="font-size: 100px; color: #B70000"></span><br><h4 style="color: #B70000"><b>@if(session()->has('en')) Chief Executive Officer @else Pimpinan @endif</b></h4><hr>
				<h4 style="color: #B70000; margin-bottom: 0px;"><b>@if(session()->has('en')) Statistic @else Statistik @endif</b></h4>
				<div style="background-color: #B70000; height: 3px; width: 200px; display: inline-block;"></div>
	            	<h4><a href="{{ route('stat_keuangan') }}">@if(session()->has('en')) Finance @else Keuangan @endif</a></h4><br>
        	<br>
			</div><br><br>
			@endif
		</div>
		
		
		<div class="col-md-4">
			@if(DormAuth::User()->is_eksternal == 1)
			<div style="text-align: center; vertical-align: middle;">
				<span class="fa fa-puzzle-piece" style="font-size: 100px; color: #737200"></span><br><h4 style="color: #737200"><b>@if(session()->has('en')) External Relation @else Eksternal Asrama @endif</b></h4><hr>
				
				<h4 style="margin-bottom: 0px; color: #737200"><b>International Relation Office</b></h4>
				<div style="background-color: black; height: 3px; width: 200px; display: inline-block; background-color: #737200"></div>
	            	<h4><a href="{{route('pendaftaran_asing_iro')}}">@if(session()->has('en')) Registering Foreign Student @else Daftarkan Mahasiswa Asing @endif</a></h4>
					<h4><a href="{{route('cek_pendaftaran_asing')}}">@if(session()->has('en')) Foreigners Data @else Data Mahasiswa Asing @endif</a></h4><br>
				<h4 style="margin-bottom: 0px; color: #737200"><b>@if(session()->has('en')) The Student Institute (LK ITB) @else Lembaga Kemahasiswaan @endif</b></h4>
				<div style="background-color: black; height: 3px; width: 200px; display: inline-block; background-color: #737200"></div>
	            	<h4 style="color: grey"><i>@if(session()->has('en')) There is nothing to show @else Belum ada menu @endif</i></h4><br>
	            <h4 style="margin-bottom: 0px; color: #737200"><b>@if(session()->has('en')) Faculty/School @else Fakultas/Sekolah @endif</b></h4>
				<div style="background-color: black; height: 3px; width: 200px; display: inline-block; background-color: #737200"></div>
	            	<h4 style="color: grey"><i>@if(session()->has('en')) There is nothing to show @else Belum ada menu @endif</i></h4><br>
			</div><br><br>
			@endif
		</div>
		
	</div>
	<br><br><br>
</div>
@endsection

<!-- SIDER MENU DASHBOARD-->
<div class="sider">
	<div style="margin-top: 0px; height: 4px; background-color: #0769B0; border-top-left-radius: 3px; border-top-right-radius: 3px;"></div>
	<div class="sider_body" style="background-color: white;">
		<h4><b><span class="fa fa-address-card"></span> @if(session()->has('en')) User Information @else Informasi Pengguna @endif</b></h4><hr>
		<p>
		<i>@if(session()->has('en')) User Information @else Informasi Pengguna @endif</i><br>
		<b><span class="fa fa-user"></span> {{DormAuth::User()->username}}</b><br>
		<i>@if(session()->has('en')) Full Name @else Nama Lengkap @endif</i><br>
		<b><span class="fa fa-drivers-license-o"></span>  {{DormAuth::User()->name}}</b><br>
		<i>Email</i><br>
		<b><span class="fa fa-envelope"></span> {{DormAuth::User()->email}}</b><br>
		</p>
	</div>
</div><br>

<div class="sider" style="background-color: white">
	<div style="margin-top: 0px; height: 4px; background-color: #0769B0; border-top-left-radius: 3px; border-top-right-radius: 3px;"></div>
	<div class="sider_header" style="background-color: white; border-radius: 0px; color: black">
		<h4><b><span class="fa fa-share-square-o"></span> @if(session()->has('en')) User Access @else Akses Pengguna @endif</b></h4>
	</div>
	<style>
		a.tablinks {
			color: black;
		}
		a.activate {
			font-weight: bold;
			font-style: italic;
		}
	</style>
	<script>
		function dapatkanId(pan){
			var x = document.getElementById(pan);
			$(document).ready(function(){
				$(x).toggle(500);
			});
		}
		function siderLoad(evt) {
		    var i, tablinks;
		    tablinks = document.getElementsByClassName("tablinks");
		    for (i = 0; i < tablinks.length; i++) {
		        tablinks[i].className = tablinks[i].className.replace(" activate", "");
		    }
		    evt.currentTarget.className += " activate";
		}
	</script>
		<div class="sider_pan" onclick="dapatkanId('pan_akun')" style="cursor: pointer;"><b><i class="fa fa-angle-down"></i> @if(session()->has('en')) Account Management @else Manajemen Akun @endif</b></div>
		@if(session()->has('menu') && session('menu') == 'dataDiri' || session('menu') == 'editNim' || session('menu') == 'editRegis' || session('menu') == 'username' || session('menu') == 'email'|| session('menu') == 'password')
		<div class="sider_body" id="pan_akun" style="display: block">
		@else
		<div class="sider_body" id="pan_akun" style="display: none">
		@endif
			@if(ITBdorm::DataUser(DormAuth::User()->id)->id_penghuni != NULL)
				<p style="color: #0769B0; margin: 0px;"><b>@if(session()->has('en')) User Profile @else Data Diri @endif</b></p>
				<div style="height: 3px; background-color: #0769B0"></div> 
				@if(session()->has('menu') && session('menu') == 'dataDiri')
					<a class="activate" href="{{route('dataDiri')}}">@if(session()->has('en')) User Profile Information @else Informasi Data Diri @endif</a><br>
				@else
					<a href="{{route('dataDiri')}}">@if(session()->has('en')) User Profile Information @else Informasi Data Diri @endif</a><br>
				@endif
            	@if(ITBdorm::DataUser(DormAuth::User()->id)->id_nim != NULL)
            		@if(session()->has('menu') && session('menu') == 'editNim')
            			<a class="activate" href="{{route('lihat_nim')}}">@if(session()->has('en')) Edit NIM @else Atur NIM @endif</a><br>
            		@else
						<a href="{{route('lihat_nim')}}">@if(session()->has('en')) Edit NIM @else Atur NIM @endif</a><br>
					@endif
					@if(session()->has('menu') && session('menu') == 'editRegis')
						<a class="activate" href="{{route('lihat_no_reg')}}"> @if(session()->has('en')) Edit Registration Number @else Atur Nomor Registrasi @endif</a><br>
					@else
						<a href="{{route('lihat_no_reg')}}"> @if(session()->has('en')) Edit Registration Number @else Atur Nomor Registrasi @endif</a><br>
					@endif
            	@endif
            @endif
            <br><p style="color: #0769B0; margin: 0px;"><b>@if(session()->has('en')) Account Setting @else Pengaturan Akun @endif</b></p>
			<div style="height: 3px; background-color: #0769B0"></div>
            @if(session()->has('menu') && session('menu') == 'username')
            	<a class="activate" href="{{route('ganti_username')}}">@if(session()->has('en')) Change Username @else Ganti Username @endif</a><br>
			@else
            	<a href="{{route('ganti_username')}}">@if(session()->has('en')) Change Username @else Ganti Username @endif</a><br>
			@endif
			@if(session()->has('menu') && session('menu') == 'email')
            	<a class="activate" href="{{route('ganti_email')}}">@if(session()->has('en')) Change Email @else Ganti Email @endif</a><br>
			@else
            	<a href="{{route('ganti_email')}}">@if(session()->has('en')) Change Email @else Ganti Email @endif</a><br>
			@endif
			@if(session()->has('menu') && session('menu') == 'password')
            	<a class="activate" href="{{route('password')}}">@if(session()->has('en')) Change Password @else Ganti Password @endif</a><br>
			@else
            	<a href="{{route('password')}}">@if(session()->has('en')) Change Password @else Ganti Password @endif</a><br>
			@endif
			<br>
           	<!-- <a href="/password/reset">Ganti Password</a><br> -->
		</div>
	@if(ITBdorm::DataUser(DormAuth::User()->id)->id_penghuni != NULL)
		<div class="sider_pan" onclick="dapatkanId('pan_penghuni')" style="cursor: pointer;"><b><i class="fa fa-angle-down"></i> @if(session()->has('en')) Occupant @else Penghuni @endif</b></div>
		@if(session()->has('menu') && session('menu') == 'penghuni/pendaftaran_penghuni' || session('menu') == 'pembayaran_penghuni' || session('menu') == 'pembayaran_penghuni_rekening' || session('menu') == 'penangguhan_penghuni' || session('menu') == 'penghuni/pengajuan_keluar')
		<div class="sider_body" id="pan_penghuni" style="display: block">
		@else
		<div class="sider_body" id="pan_penghuni" style="display: none">
		@endif
			<p style="color: #0769B0; margin: 0px;"><b>@if(session()->has('en')) Services @else Layanan @endif</b></p>
			<div style="height: 3px; background-color: #0769B0"></div> 
			@if(session()->has('menu') && session('menu') == 'penghuni/pendaftaran_penghuni')
				<a class="activate" href="{{ route('pendaftaran_penghuni') }}">@if(session()->has('en')) Registration @else Pendaftaran @endif</a><br>
			@else
				<a href="{{ route('pendaftaran_penghuni') }}">@if(session()->has('en')) Registration @else Pendaftaran @endif</a><br>
			@endif
			@if(session()->has('menu') && session('menu') == 'penghuni/pengajuan_keluar')
				<a class="activate" href="{{ route('form_pengajuan_keluar') }}">@if(session()->has('en')) Propose Expeltion @else Pengajuan Keluar @endif</a><br>
			@else
				<a href="{{ route('form_pengajuan_keluar') }}">@if(session()->has('en')) Propose Expeltion @else Pengajuan Keluar @endif</a><br>
			@endif
			<!--
			@if(session()->has('menu') && session('menu') == 'pengajuan_pindah_kamar')
				<a class="activate" href="{{ route('pengajuan_pindah_kamar') }}">Pengajuan Pindah Kamar</a><br>
			@else
				<a href="{{ route('pengajuan_pindah_kamar') }}">Pengajuan Pindah Kamar</a><br>
			@endif
			-->


			<br><p style="color: #0769B0; margin: 0px;"><b>@if(session()->has('en')) Payment @else Pembayaran @endif</b></p>
			<div style="height: 3px; background-color: #0769B0"></div> 
			@if(session()->has('menu') && session('menu') == 'pembayaran_penghuni')
				<a class="activate" href="{{ route('pembayaran_penghuni') }}">@if(session()->has('en')) Payment (via host-to-host) @else Pembayaran (host-to-host) @endif</a><br>
			@else
				<a href="{{ route('pembayaran_penghuni') }}">@if(session()->has('en')) Payment (via host-to-host) @else Pembayaran (host-to-host) @endif</a><br>
			@endif
			@if(session()->has('menu') && session('menu') == 'pembayaran_penghuni_rekening')
				<a class="activate" href="{{ route('pembayaran_penghuni_rekening') }}">@if(session()->has('en')) Payment (via bank account) @else Pembayaran (Rekening Penampungan) @endif</a><br>
			@else
				<a href="{{ route('pembayaran_penghuni_rekening') }}">@if(session()->has('en')) Payment (via bank account) @else Pembayaran (Rekening Penampungan) @endif</a><br>
			@endif
			@if(session()->has('menu') && session('menu') == 'penangguhan_penghuni')
				<a class="activate" href="{{ route('penangguhan_penghuni') }}">@if(session()->has('en')) Deferment @else Penangguhan Pembayaran @endif</a><br>
			@else
				<a href="{{ route('penangguhan_penghuni') }}">@if(session()->has('en')) Deferment @else Penangguhan Pembayaran @endif</a><br>
			@endif
			<br>
			<!--
			<a href="#">Lapor Kerusakan</a><br>
			<a href="#">Pindah Kamar</a><br>
			<a href="#">Keluar Asrama</a><br>
			-->
		</div>
	@endif 
	@if(DormAuth::User()->is_pengelola == 1)
		<div class="sider_pan" onclick="dapatkanId('pan_pengelola')" style="cursor: pointer;"><b><i class="fa fa-angle-down"></i> @if(session()->has('en')) The Dormitory Organizer @else Pengelola Asrama @endif</b></div>
		@if(session()->has('menu') && session('menu') == 'pengelola/edit_kamar' || session('menu') == 'periksa_penghuni_aktif')
		<div class="sider_body" id="pan_pengelola" style="display: block">
		@else
		<div class="sider_body" id="pan_pengelola" style="display: none">
		@endif
			<p style="color: #0769B0; margin: 0px;"><b>@if(session()->has('en')) Rooms @else Kamar @endif</b></p>
			<div style="height: 3px; background-color: #0769B0"></div>
			@if(session()->has('menu') && session('menu') == 'pengelola/edit_kamar')
				<a href="{{ route('edit_kamar') }}" class="activate">@if(session()->has('en')) Rooms Setting @else Atur Kamar @endif</a><br>
			@else
				<a href="{{ route('edit_kamar') }}">@if(session()->has('en')) Rooms Setting @else Atur Kamar @endif</a><br>
			@endif
			@if(session()->has('menu') && session('menu') == 'periksa_penghuni_aktif')
				<a class="activate" href="{{ route('periksa_penghuni_aktif') }}">@if(session()->has('en')) Check Current Occupant @else Periksa Penghuni Aktif @endif</a><br>
			@else
				<a href="{{ route('periksa_penghuni_aktif') }}">@if(session()->has('en')) Check Current Occupant @else Periksa Penghuni Aktif @endif</a><br>
			@endif
			<br><p style="color: #0769B0; margin: 0px;"><b>@if(session()->has('en')) Logistics @else Sarana dan Prasarana @endif</b></p>
			<div style="height: 3px; background-color: #0769B0"></div>
			<p style="color: grey"><i>@if(session()->has('en')) There is nothing to show @else Belum ada menu @endif</i></p><br><br>
		</div>
	@endif
	@if(DormAuth::User()->is_sekretariat == 1)
		<div class="sider_pan" onclick="dapatkanId('pan_sekretariat')" style="cursor: pointer;"><b><i class="fa fa-angle-down"></i> @if(session()->has('en')) Secretary Office @else Sekretariat @endif</b></div>
		@if(session()->has('menu') && session('menu') == 'sekretariat/validasi_pembayaran' || session('menu') == 'sekretariat/validasi_pendaftaran_reguler' || session('menu') == 'sekretariat/validasi_pendaftaran' || session('menu') == 'sekretariat_buat/edit_periode' || session('menu') == 'periksa_penghuni_aktif' || session('menu') == 'periksa_penghuni_keseluruhan' || session('menu') == 'sekretariat/edit_pindah_kamar' || session('menu') == 'daftarUlangReg' || session('menu') == 'daftarUlangNon')
		<div class="sider_body" id="pan_sekretariat" style="display: block">
		@else
		<div class="sider_body" id="pan_sekretariat" style="display: none">
		@endif
			<p style="color: #0769B0; margin: 0px;"><b>@if(session()->has('en')) Reguler Validation @else Validasi Reguler @endif</b></p>
			<div style="height: 3px; background-color: #0769B0"></div>
			@if(session()->has('menu') && session('menu') == 'sekretariat/validasi_pendaftaran_reguler')
				<a class="activate" href="{{ route('validasi_pendaftaran_reguler') }}">@if(session()->has('en')) New Intake @else Penerimaan Baru @endif</a><br>
			@else
				<a href="{{ route('validasi_pendaftaran_reguler') }}">@if(session()->has('en')) New Intake @else Penerimaan Baru @endif</a><br>
			@endif
			@if(session()->has('menu') && session('menu') == 'daftarUlangReg')
				<a class="activate" href="{{ route('daftarUlang') }}">@if(session()->has('en')) Secondary Registration @else Daftar Ulang @endif</a><br>
			@else
				<a href="{{ route('daftarUlang') }}">@if(session()->has('en')) Secondary Registration @else Daftar Ulang @endif</a><br>
			@endif
			@if(session()->has('menu') && session('menu') == 'sekretariat/validasi_pembayaran')
				<a class="activate" href="{{ route('validasi_pembayaran') }}">@if(session()->has('en')) Payments @else Pembayaran @endif</a><br>
			@else
				<a href="{{ route('validasi_pembayaran') }}">@if(session()->has('en')) Payments @else Pembayaran @endif</a><br>
			@endif
			<br><p style="color: #0769B0; margin: 0px;"><b>@if(session()->has('en')) Non-Reguler Validation @else Validasi Non Reguler @endif</b></p>
			<div style="height: 3px; background-color: #0769B0"></div>
			@if(session()->has('menu') && session('menu') == 'sekretariat/validasi_pendaftaran')
				<a class="activate" href="{{ route('validasi_pendaftaran_non_reguler') }}">@if(session()->has('en')) New Intake @else Penerimaan Baru @endif</a><br>
			@else
				<a href="{{ route('validasi_pendaftaran_non_reguler') }}">@if(session()->has('en')) New Intake @else Penerimaan Baru @endif</a><br>
			@endif
			@if(session()->has('menu') && session('menu') == 'daftarUlangNon')
				<a class="activate" href="{{ route('daftarUlangNon') }}">@if(session()->has('en')) Secondary Registration & Payments @else Daftar Ulang & Pembayaran @endif</a><br>
			@else
				<a href="{{ route('daftarUlangNon') }}">@if(session()->has('en')) Secondary Registration & Payments @else Daftar Ulang & Pembayaran @endif</a><br>
			@endif
			<br><p style="color: #0769B0; margin: 0px;"><b>@if(session()->has('en')) Occupant Information @else Data Penghuni @endif</b></p>
			<div style="height: 3px; background-color: #0769B0"></div>
			@if(session()->has('menu') && session('menu') == 'sekretariat_buat/edit_periode')
				<a class="activate" href="{{ route('edit_periode') }}" id="edit_periode">@if(session()->has('en')) Create or Edit Period @else Buat / Atur Periode @endif</a><br>
			@else
				<a href="{{ route('edit_periode') }}" id="edit_periode">@if(session()->has('en')) Create or Edit Period @else Buat / Atur Periode @endif</a><br>
			@endif
			@if(session()->has('menu') && session('menu') == 'periksa_penghuni_aktif')
				<a class="activate" href="{{ route('periksa_penghuni_aktif') }}">@if(session()->has('en')) Check Current Occupant @else Periksa Penghuni Aktif @endif</a><br>
			@else
				<a href="{{ route('periksa_penghuni_aktif') }}">@if(session()->has('en')) Check Current Occupant @else Periksa Penghuni Aktif @endif</a><br>
			@endif
			@if(session()->has('menu') && session('menu') == 'periksa_penghuni_keseluruhan')
				<a class="activate" href="{{ route('Data_Penghuni_Keseluruhan') }}">Periksa Penghuni Keseluruhan</a><br>
			@else
				<a href="{{ route('Data_Penghuni_Keseluruhan') }}">Periksa Penghuni Keseluruhan</a><br>
			@endif
			@if(session()->has('menu') && session('menu') == 'sekretariat/edit_pindah_kamar')
				<a href="{{ route('edit_pindah_kamar') }}" class="activate">Edit Pindah Kamar</a><br>
			@else
				<a href="{{ route('edit_pindah_kamar') }}">Edit Pindah Kamar</a><br>
			@endif
			<br>
		</div>
	@endif
	@if(DormAuth::User()->is_keuangan == 1)
		<div class="sider_pan" onclick="dapatkanId('pan_keuangan')" style="cursor: pointer;"><b><i class="fa fa-angle-down"></i> @if(session()->has('en')) Finance @else Keuangan @endif</b></div>
		@if(session()->has('menu') && session('menu') == 'stat_keuangan' || session('menu') == 'keuangan_pembayaran_penghuni')
		<div class="sider_body" id="pan_keuangan" style="display: block">
		@else
		<div class="sider_body" id="pan_keuangan" style="display: none">
		@endif
			<p style="color: #0769B0; margin: 0px;"><b>@if(session()->has('en')) Statistic @else Statistik @endif</b></p>
			<div style="height: 3px; background-color: #0769B0"></div>
			@if(session()->has('menu') && session('menu') == 'stat_keuangan')
				<a class="activate" href="{{ route('stat_keuangan') }}">@if(session()->has('en')) Finance Monitoring @else Monitor Keuangan @endif</a><br><br>
			@else
				<a href="{{ route('stat_keuangan') }}">@if(session()->has('en')) Finance Monitoring @else Monitor Keuangan @endif</a><br><br>
			@endif
			<p style="color: #0769B0; margin: 0px;"><b>Audit</b></p>
			<div style="height: 3px; background-color: #0769B0"></div>
			@if(session()->has('menu') && session('menu') == 'keuangan_pembayaran_penghuni')
				<a class="activate" href="{{ route('cekPembayaran') }}">@if(session()->has('en')) Occupant Payment Details @else Detail Pembayaran Penghuni @endif</a><br><br>
			@else
				<a href="{{ route('cekPembayaran') }}">@if(session()->has('en')) Occupant Payment Details @else Detail Pembayaran Penghuni @endif</a><br><br>
			@endif
		</div>
	@endif
	@if(DormAuth::User()->is_admin == 1)
		<div class="sider_pan" onclick="dapatkanId('pan_admin')" style="cursor: pointer;"><b><i class="fa fa-angle-down"></i> Admin</b></div>
		@if(session()->has('menu') && session('menu') == 'upload_file' || session('menu') == 'post_pengumuman' || session('menu') == 'post_berita' || session('menu') == 'atur_akses' || session('menu') == 'admin/checkout_otomatis' || session('menu') == 'admin/daftar_checkout' || session('menu') == 'viewJadwal')
		<div class="sider_body" id="pan_admin" style="display: block">
		@else
		<div class="sider_body" id="pan_admin" style="display: none">
		@endif
			<p style="color: #0769B0; margin: 0px;"><b>@if(session()->has('en')) Website Contents @else Konten Website @endif</b></p>
			<div style="height: 3px; background-color: #0769B0"></div>
			@if(session()->has('menu') && session('menu') == 'upload_file')
				<a class="activate" href="{{route('show_upload')}}">@if(session()->has('en')) Upload Files @else Unggah File @endif</a><br>
			@else
				<a href="{{route('show_upload')}}">@if(session()->has('en')) Upload Files @else Unggah File @endif</a><br>
			@endif
			@if(session()->has('menu') && session('menu') == 'post_pengumuman')
				<a class="activate" href="{{route('show_tambah_pengumuman')}}">@if(session()->has('en')) Publish Announcement @else Unggah Pengumuman @endif</a><br>
			@else
				<a href="{{route('show_tambah_pengumuman')}}">@if(session()->has('en')) Publish Announcement @else Unggah Pengumuman @endif</a><br>
			@endif
			@if(session()->has('menu') && session('menu') == 'post_berita')
				<a class="activate" href="{{route('show_tambah_berita')}}">@if(session()->has('en')) Publish News @else Unggah Berita @endif</a><br>
			@else
				<a href="{{route('show_tambah_berita')}}">@if(session()->has('en')) Publish News @else Unggah Berita @endif</a><br>
			@endif
			@if(session()->has('menu') && session('menu') == 'viewJadwal')
				<a class="activate" href="{{route('show_tambah_jadwal')}}">@if(session()->has('en')) Publish Schedules @else Unggah Jadwal Kegiatan @endif</a><br><br>
			@else
				<a href="{{route('show_tambah_jadwal')}}">@if(session()->has('en')) Publish Schedules @else Unggah Jadwal Kegiatan @endif</a><br><br>
			@endif
			<p style="color: #0769B0; margin: 0px;"><b>@if(session()->has('en')) User Access Control @else Pengaturan Akses Penguna @endif</b></p>
			<div style="height: 3px; background-color: #0769B0"></div>
			@if(session()->has('menu') && session('menu') == 'atur_akses')
				<a class="activate" href="{{route('users.index')}}">@if(session()->has('en')) Set Access @else Atur Akses @endif</a><br>
			@else
				<a href="{{route('users.index')}}">@if(session()->has('en')) Set Access @else Atur Akses @endif</a><br>
			@endif
			@if(session()->has('menu') && session('menu') == 'admin/list_pengajuan_keluar')
				<a class="activate" href="{{route('list_pengajuan_keluar')}}">@if(session()->has('en')) List of Expeltion @else List Pengajuan Keluar @endif</a><br>
			@else
				<a href="{{route('list_pengajuan_keluar')}}">@if(session()->has('en')) List of Expeltion @else List Pengajuan Keluar @endif</a><br>
			@endif
			@if(session()->has('menu') && session('menu') == 'admin/checkout_otomatis')
				<a class="activate" href="{{route('halaman_checkout_otomatis')}}">@if(session()->has('en')) Automatic Checkout System @else Checkout Otomatis @endif</a><br>
			@else
				<a href="{{route('halaman_checkout_otomatis')}}">@if(session()->has('en')) Automatic Checkout System @else Checkout Otomatis @endif</a><br>
			@endif
			@if(session()->has('menu') && session('menu') == 'admin/daftar_checkout')
				<a class="activate" href="{{route('periksa_daftar_checkout')}}">@if(session()->has('en')) Checkout List @else Daftar Checkout @endif</a><br><br>
			@else
				<a href="{{route('periksa_daftar_checkout')}}">@if(session()->has('en')) Checkout List @else Daftar Checkout @endif</a><br><br>
			@endif
		</div>
	@endif
	@if(DormAuth::User()->is_eksternal == 1)
		<div class="sider_pan" onclick="dapatkanId('pan_eksternal')" style="cursor: pointer;"><b><i class="fa fa-angle-down"></i> @if(session()->has('en')) External Relation @else Eksternal Asrama @endif</b></div>
		@if(session()->has('menu') && session('menu') == 'iro_daftar_asing' || session('menu') == 'iro_data_asing')
		<div class="sider_body" id="pan_eksternal" style="display: block">
		@else
		<div class="sider_body" id="pan_eksternal" style="display: none">
		@endif
			<p style="color: #0769B0; margin: 0px;"><b>International Relation Office</b></p>
			<div style="height: 3px; background-color: #0769B0"></div>
			@if(session()->has('menu') && session('menu') == 'iro_daftar_asing')
				<a class="activate" href="{{route('pendaftaran_asing_iro')}}">@if(session()->has('en')) Registering Foreign Student @else Daftarkan Mahasiswa Asing @endif</a><br>
			@else
				<a href="{{route('pendaftaran_asing_iro')}}">@if(session()->has('en')) Registering Foreign Student @else Daftarkan Mahasiswa Asing @endif</a><br>
			@endif
			@if(session()->has('menu') && session('menu') == 'iro_data_asing')
				<a class="activate" href="{{route('cek_pendaftaran_asing')}}">@if(session()->has('en')) Foreigners Data @else Data Mahasiswa Asing @endif</a><br><br>
			@else
				<a href="{{route('cek_pendaftaran_asing')}}">@if(session()->has('en')) Foreigners Data @else Data Mahasiswa Asing @endif</a><br><br>
			@endif
			<p style="color: #0769B0; margin: 0px;"><b>@if(session()->has('en')) The Student Institute (LK ITB) @else Lembaga Kemahasiswaan @endif</b></p>
			<div style="height: 3px; background-color: #0769B0"></div>
			<p style="color: grey"><i>@if(session()->has('en')) There is nothing to show @else Belum ada menu @endif</i></p><br>
			<p style="color: #0769B0; margin: 0px;"><b>@if(session()->has('en')) Faculty/School @else Fakultas/Sekolah @endif</b></p>
			<div style="height: 3px; background-color: #0769B0"></div>
			<p style="color: grey"><i>@if(session()->has('en')) There is nothing to show @else Belum ada menu @endif</i></p><br>
		</div>
	@endif
	@if(DormAuth::User()->is_pimpinan == 1)
		<div class="sider_pan" onclick="dapatkanId('pan_pimpinan')" style="cursor: pointer;"><b><i class="fa fa-angle-down"></i> @if(session()->has('en')) Chief Executive Officer @else Pimpinan @endif</b></div>
		@if(session()->has('menu') && session('menu') == 'stat_keuangan')
			<div class="sider_body" id="pan_pimpinan" style="display: block">
		@else
			<div class="sider_body" id="pan_pimpinan" style="display: block">
		@endif
			<p style="color: #0769B0; margin: 0px;"><b>@if(session()->has('en')) Statistic @else Statistik @endif</b></p>
			<div style="height: 3px; background-color: #0769B0"></div>
			@if(session()->has('menu') && session('menu') == 'stat_keuangan')
				<a class="activate" href="{{ route('stat_keuangan') }}">@if(session()->has('en')) Finance @else Keuangan @endif</a><br><br>
			@else
				<a href="{{ route('stat_keuangan') }}">@if(session()->has('en')) Finance @else Keuangan @endif</a><br><br>
			@endif
		</div>
	@endif
</div><br><br>

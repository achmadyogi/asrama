<!-- SIDER MENU DASHBOARD-->
<div class="sider">
	<div class="sider_header">
		<h4><b><span class="fa fa-address-card"></span> Informasi Pengguna</b></h4>
	</div>
	<div class="sider_body">
		<i>Username</i><br>
		<b><span class="fa fa-user"></span> {{$user->username}}</b><br>
		<i>Nama Lengkap</i><br>
		<b><span class="fa fa-drivers-license-o""></span>  {{$user->name}}</b><br>
		<i>Email</i><br>
		<b><span class="fa fa-envelope"></span> {{$user->email}}</b><br>
	</div>
</div><br>

<div class="sider">
	<div class="sider_header">
		<h4><b><span class="fa fa-cogs"></span> Aplikasi</b></h4>
	</div>
	<style>
		a.tablinks {
			color: black;
		}
		a.active {
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
		        tablinks[i].className = tablinks[i].className.replace(" active", "");
		    }
		    evt.currentTarget.className += " active";
		}
	</script>
		<div class="sider_pan" onclick="dapatkanId('pan_akun')" style="cursor: pointer;"><b><i class="fa fa-angle-down"></i> Manajemen Akun</b></div>
		<div class="sider_body" id="pan_akun" style="display: block;">
			@if($userPenghuni != '0')
            	<a href="{{route('edit_data_diri')}}">Edit Data Diri</a><br>
            	@if($userNim != '0')
            		<a href="{{route('lihat_nim')}}">Edit NIM</a><br>
            	@endif
            @endif
            <a href="#">Ganti Username</a><br>
            <a href="#">Ganti Password</a><br>
		</div>
	@if($userPenghuni != '0')
		<div class="sider_pan" onclick="dapatkanId('pan_penghuni')" style="cursor: pointer;"><b><i class="fa fa-angle-down"></i> Penghuni</b></div>
		<div class="sider_body" id="pan_penghuni" style="display: none">
			@if(session()->has('menu') && session('menu') == 'penghuni/pendaftaran_penghuni')
				<a class="active" href="{{ route('pendaftaran_penghuni') }}">Pendaftaran</a><br>
			@else
				<a href="{{ route('pendaftaran_penghuni') }}">Pendaftaran</a><br>
			@endif
			
			@if($user->is_penghuni == 1)
			<a href="#">Informasi Pembayaran</a><br>
			<a href="#">Lapor Kerusakan</a><br>
			<a href="#">Pindah Kamar</a><br>
			<a href="#">Keluar Asrama</a><br>
			@endif
		</div>
	@endif 
	@if($user->is_pengelola == 1)
		<div class="sider_pan" onclick="dapatkanId('pan_pengelola')" style="cursor: pointer;"><b><i class="fa fa-angle-down"></i> Pengelola Asrama</b></div>
		<div class="sider_body" id="pan_pengelola" style="display: none">
			<a href="#">Utama</a><br>
			<a href="#">Informasi Pembayaran</a><br>
			<a href="#">Lapor Kerusakan</a><br>
		</div>
	@endif
	@if($user->is_sekretariat == 1)
		<div class="sider_pan" onclick="dapatkanId('pan_sekretariat')" style="cursor: pointer;"><b><i class="fa fa-angle-down"></i> Sekretariat</b></div>
		<div class="sider_body" id="pan_sekretariat" style="display: none">
			<a href="#">Utama</a><br>
			<a href="#">Informasi Pembayaran</a><br>
			@if(session()->has('menu') && session('menu') == 'sekretariat/validasi_pendaftaran')
				<a class="active" href="{{ route('validasi_pendaftaran') }}">Validasi Pendaftaran</a><br>
			@else
				<a href="{{ route('validasi_pendaftaran') }}">Validasi Pendaftaran</a><br>
			@endif
			@if(session()->has('menu') && session('menu') == 'sekretariat_buat/edit_periode')
				<a class="active" href="{{ route('edit_periode') }}" id="edit_periode">Buat/Edit Periode</a><br>
			@else
				<a href="{{ route('edit_periode') }}" id="edit_periode">Buat/Edit Periode</a><br>
			@endif
		</div>
	@endif
	@if($user->is_pimpinan == 1)
		<div class="sider_pan" onclick="dapatkanId('pan_pimpinan')" style="cursor: pointer;"><b><i class="fa fa-angle-down"></i> Pimpinan</b></div>
		<div class="sider_body" id="pan_pimpinan" style="display: none">
			<a href="#">Utama</a><br>
			<a href="#">Informasi Pembayaran</a><br>
			<a href="#">Lapor Kerusakan</a><br>
		</div>
	@endif
	@if($user->is_admin == 1)
		<div class="sider_pan" onclick="dapatkanId('pan_admin')" style="cursor: pointer;"><b><i class="fa fa-angle-down"></i> Admin</b></div>
		<div class="sider_body" id="pan_admin" style="display: none">
			<a href="{{route("users.index")}}">Manage User</a><br>
			<a href="#">Informasi Pembayaran</a><br>
			<a href="#">Lapor Kerusakan</a><br>
		</div>
	@endif
</div><br><br>
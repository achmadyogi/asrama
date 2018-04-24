<!-- SIDER MENU DASHBOARD-->
<div class="sider">
	<div class="sider_header">
		<h4><b><span class="fa fa-address-card"></span> Informasi Pengguna</b></h4>
	</div>
	<div class="sider_body">
		<i>Username</i><br>
		<b><span class="fa fa-user"></span> {{$user->username}}</b><br>
		<i>Nama Lengkap</i><br>
		<b><span class="fa fa-drivers-license-o"></span>  {{$user->name}}</b><br>
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
            	<a class="tablinks" href="#" onclick="siderLoad(event)">Edit Data Diri</a><br>
            	@if($userNim != '0')
            		<a class="tablinks" href="#" onclick="siderLoad(event)">Edit NIM</a><br>
            	@endif
            @endif
            <a class="tablinks" href="#" onclick="siderLoad(event)">Ganti Username</a><br>
            <a class="tablinks" href="#" onclick="siderLoad(event)">Ganti Password</a><br>
		</div>
	@if($userPenghuni != '0')
		<div class="sider_pan" onclick="dapatkanId('pan_penghuni')" style="cursor: pointer;"><b><i class="fa fa-angle-down"></i> Penghuni</b></div>
		<div class="sider_body" id="pan_penghuni" style="display: none">
			<a class="tablinks" href="#" onclick="siderLoad(event)">Pendaftaran</a><br>
			@if($user->is_penghuni == 1)
			<a class="tablinks" href="#" onclick="siderLoad(event)">Informasi Pembayaran</a><br>
			<a class="tablinks" href="#" onclick="siderLoad(event)">Lapor Kerusakan</a><br>
			<a class="tablinks" href="#" onclick="siderLoad(event)">Pindah Kamar</a><br>
			<a class="tablinks" href="#" onclick="siderLoad(event)">Keluar Asrama</a><br>
			@endif
		</div>
	@endif 
	@if($user->is_pengelola == 1)
		<div class="sider_pan" onclick="dapatkanId('pan_pengelola')" style="cursor: pointer;"><b><i class="fa fa-angle-down"></i> Pengelola Asrama</b></div>
		<div class="sider_body" id="pan_pengelola" style="display: none">
			<a class="tablinks" href="#" onclick="siderLoad(event)">Utama</a><br>
			<a class="tablinks" href="#" onclick="siderLoad(event)">Informasi Pembayaran</a><br>
			<a class="tablinks" href="#" onclick="siderLoad(event)">Lapor Kerusakan</a><br>
		</div>
	@endif
	@if($user->is_sekretariat == 1)
		<div class="sider_pan" onclick="dapatkanId('pan_sekretariat')" style="cursor: pointer;"><b><i class="fa fa-angle-down"></i> Sekretariat</b></div>
		<div class="sider_body" id="pan_sekretariat" style="display: none">
			<a class="tablinks" href="#" onclick="siderLoad(event)">Utama</a><br>
			<a class="tablinks" href="#" onclick="siderLoad(event)">Informasi Pembayaran</a><br>
			<a class="tablinks" href="#" onclick="siderLoad(event)">Lapor Kerusakan</a><br>
			<a class="tablinks" href="{{ route('edit_periode') }}" onclick="siderLoad(event)" id="edit_periode">Buat/Edit Periode</a><br>
		</div>
	@endif
	@if($user->is_pimpinan == 1)
		<div class="sider_pan" onclick="dapatkanId('pan_pimpinan')" style="cursor: pointer;"><b><i class="fa fa-angle-down"></i> Pimpinan</b></div>
		<div class="sider_body" id="pan_pimpinan" style="display: none">
			<a class="tablinks" href="#" onclick="siderLoad(event)">Utama</a><br>
			<a class="tablinks" href="#" onclick="siderLoad(event)">Informasi Pembayaran</a><br>
			<a class="tablinks" href="#" onclick="siderLoad(event)">Lapor Kerusakan</a><br>
		</div>
	@endif
	@if($user->is_admin == 1)
		<div class="sider_pan" onclick="dapatkanId('pan_admin')" style="cursor: pointer;"><b><i class="fa fa-angle-down"></i> Admin</b></div>
		<div class="sider_body" id="pan_admin" style="display: none">
			<a class="tablinks" href="#" onclick="siderLoad(event)">Utama</a><br>
			<a class="tablinks" href="#" onclick="siderLoad(event)">Informasi Pembayaran</a><br>
			<a class="tablinks" href="#" onclick="siderLoad(event)">Lapor Kerusakan</a><br>
		</div>
	@endif
</div><br><br>
<script>
	$(document).ready(function(){
		$(document).ajaxStart(function(){
			$("#wait").css("display", "block");
		});
		$(document).ajaxComplete(function(){
			$("#wait").css("display", "none");
		});
		// PENGHUNI
		$("#data_diri").click(function(){
		});
		// SEKRETARIAT
		$("#edit_periode").click(function(){
			$.ajax({
				type: 'POST',
				url: '/sekretariat',
			});
			$("#content").load("resources/views/sekretariat/edit_periode");
		});
	});
</script>
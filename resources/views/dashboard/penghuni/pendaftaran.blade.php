				<!-- PENGISIAN FORM DATA PENGHUNI DAN NIM PENGHUNI -->
				@if($userPenghuni == '0')
				<h1 style="margin-top: 0px;"><b>Data Diri Penghuni</b></h1>
				<p>Sebelum melanjutkan pada daftar aplikasi, silahkan melengkapi data diri Anda pada form di bawah ini.</p>
				<form  method="POST" role="form" action="{{ route('daftar_penghuni') }}">
					{{ csrf_field() }}
					<div style="border: 1px solid #C9C9C9; border-radius: 5px;">
						<div style="background-color: #E8E8E8; padding: 10px 15px 10px 15px">
							Kemahasiswaan
						</div>
						<div style="padding: 10px 15px 10px 15px;">
							<p>Apakah Anda mahasiswa ITB?</p>
								<input id="mahasiswa" name="mahasiswa" type="radio" value="1" <?php if(Input::old('mahasiswa')== "1") { echo 'checked="checked"'; } ?> required> Yes, I am a student<br>
								<input id="mahasiswa" name="mahasiswa" type="radio" value="0" <?php if(Input::old('mahasiswa')== "0") { echo 'checked="checked"'; } ?> required> No, I am not a student<br>
							<div id="msg" style="display: none;"><br>
								<div class="form-group{{ $errors->has('nim') ? ' has-error' : '' }}">
								<input type="text" name="nim" class="input" value="{{old('nim')}}" placeholder="Masukkan NIM Anda">
								</div>
							</div>
						</div>
						<script type="text/javascript">
							$(document).ready(function(){
								$("input[type=radio][name=mahasiswa]").change(function(){
								  var nim = $(this).val();
								  if (nim == 1){
								  	$('#msg').show(500);
								  	$('#itb').show(500);
								  	$('#non_itb').hide(500);
								  }else{
								  	$('#msg').hide(500);
								  	$('#itb').hide(500);
								  	$('#non_itb').show(500);
								  }
								});
							});
						</script>
					</div><br>
					<div style="border: 1px solid #C9C9C9; border-radius: 5px;">
						<div style="background-color: #E8E8E8; padding: 10px 15px 10px 15px">
							Data Diri
						</div>
						<div style="padding: 10px 15px 10px 15px;"><br>
							<div class="form-group{{ $errors->has('nomor_identitas') ? ' has-error' : '' }}">
							<input class="input" name="nomor_identitas" type="text" value="{{old('nomor_identitas')}}" placeholder="Nomor Identitas" required><br></div>
							<div class="form-group{{ $errors->has('jenis_identitas') ? ' has-error' : '' }}">
							<input class="input" name="jenis_identitas" type="text" value="{{old('jenis_identitas')}}" placeholder="Jenis Identitas (contoh: SIM, KTP, paspor)" required><br></div>
							<div class="form-group{{ $errors->has('tempat lahir') ? ' has-error' : '' }}">
							<input class="input" name="tempat_lahir" type="text" value="{{old('tempat_lahir')}}" placeholder="Kota Lahir" required><br></div>
							<div class="input-group">
								<div class="input-group-addon" >
									<i class="fa fa-calendar"></i>
								</div>
								<div class="form-group{{ $errors->has('tanggal_lahir') ? ' has-error' : '' }}">
								<input autocomplete="off" autocorrect="off" autocapitalize="off" spellcheck="false" style="width: 100%;" class="form-control" id="date" name="tanggal_lahir" placeholder="Tanggal Lahir (YYYY-MM-DD)" type="text" required></div>
							</div><br>
							Golongan Darah:<br>
							<input type="radio" name="gol_darah" value="O" <?php if(Input::old('gol_darah')== "O") { echo 'checked="checked"'; } ?> required> O
							<span style="display: inline-block; width: 50px;"></span>
							<input type="radio" name="gol_darah" value="AB" required <?php if(Input::old('gol_darah')== "AB") { echo 'checked="checked"'; } ?>> AB
							<span style="display: inline-block; width: 50px;"></span>
							<input type="radio" name="gol_darah" value="A" <?php if(Input::old('gol_darah')== "A") { echo 'checked="checked"'; } ?> required> A
							<span style="display: inline-block; width: 50px;"></span>
							<input type="radio" name="gol_darah" value="B" <?php if(Input::old('gol_darah')== "B") { echo 'checked="checked"'; } ?> required> B
							<span style="display: inline-block; width: 50px;"></span><br><br>
							Jenis Kelamin:<br>
							<input type="radio" name="kelamin" value="L" <?php if(Input::old('kelamin')== "L") { echo 'checked="checked"'; } ?> required> Laki-laki
							<span style="display: inline-block; width: 50px;"></span>
							<input type="radio" name="kelamin" value="P" <?php if(Input::old('kelamin')== "P") { echo 'checked="checked"'; } ?> required> Perempuan<br><br>
							Asal Negara:<br>
							<select id="country" name ="negara" required></select></br></br>
							Propinsi/State:<br>
							<select name ="propinsi" id ="state" required></select></br></br>
							<script language="javascript">
								populateCountries("country", "state");
							</script>
							<div class="form-group{{ $errors->has('kota') ? ' has-error' : '' }}">
							<input class="input" name="kota" type="text" value="{{old('kota')}}" placeholder="Nama Kota" required><br></div>
							<div class="form-group{{ $errors->has('alamat') ? ' has-error' : '' }}">
							<input class="input" name="alamat" type="text" value="{{old('alamat')}}" placeholder="Alamat" required><br></div>
							<div class="form-group{{ $errors->has('kodepos') ? ' has-error' : '' }}">
							<input class="input" name="kodepos" type="text" value="{{old('kodepos')}}" placeholder="Kode Pos" required><br></div>
							<div class="form-group{{ $errors->has('agama') ? ' has-error' : '' }}">
							<input class="input" name="agama" type="text" value="{{old('agama')}}" placeholder="Agama" required><br></div>
							<div class="form-group{{ $errors->has('pekerjaan') ? ' has-error' : '' }}">
							<input class="input" name="pekerjaan" type="text" value="{{old('pekerjaan')}}" placeholder="Pekerjaan" required><br></div>
							Warga Negara:<br>
							<select id="country2" name ="warga_negara"></select><br><br>
							<input class="input" name="telepon" type="text" value="{{old('telepon')}}" placeholder="Telepon" required><br><br>
							<input class="input" name="kontak_darurat" type="text" value="{{old('kontak_darurat')}}" placeholder="Kontak Darurat" required><br><br>
							<div id="non_itb" style="display: none;">
								<div class="form-group{{ $errors->has('instansi') ? ' has-error' : '' }}">
							<input class="input" name="instansi" type="text" value="{{old('instansi')}}" placeholder="Nama Instansi"><br></div>
							</div>
							<div id="itb" style="display: none;">
								<input class="input" name="instansi_itb" type="text" value="Institut Teknologi Bandung" disabled><br><br>
							</div>
							<script language="javascript">
								populateCountries("country2");
							</script>
						</div>
					</div><br>
					<div style="border: 1px solid #C9C9C9; border-radius: 5px;">
						<div style="background-color: #E8E8E8; padding: 10px 15px 10px 15px">
							Data Orang Tua / Wali
						</div>
						<div style="padding: 10px 15px 10px 15px;"><br>
							<input class="input" name="nama_ortu_wali" type="text" value="{{old('nama_ortu_wali')}}" placeholder="Nama Orang Tua / Wali" required><br><br>
							<input class="input" name="pekerjaan_ortu_wali" type="text" value="{{old('pekerjaan_ortu_wali')}}" placeholder="Pekerjaan Orang Tua / Wali" required><br><br>
							<input class="input" name="alamat_ortu_wali" type="text" value="{{old('alamat_ortu_wali')}}" placeholder="Alamat Orang Tua / Wali" required><br><br>
							<input class="input" name="telepon_ortu_wali" type="text" value="{{old('telepon_ortu_wali')}}" placeholder="Telepon Orang Tua / Wali" required><br><br>
							<button type="submit" name="submit" class="button">Submit</button><br><br>
						</div>
					</div><br>
				</form> 
			@endif
			<!-- PENDAFTARAN ASRAMA -->
			@if($user->is_penghuni == 0 && $userPenghuni != '0')
				<h1><b>Informasi Pendaftaran</b></h1>
				<p>Terimakasih telah bergabung dengan UPT Asrama ITB. Silahkan daftarkan diri Anda untuk permohonan tinggal di asarama.
					Syarat dan ketentuan adalah sebagai berikut:<br>
					<h4><b>PENGHUNI REGULER</b></h4>Penghuni reguler adalah penghuni dengan status mahasiswa ITB. Seorang penghuni reguler hanya dapat mendaftar pada periode tertentu yang waktunya telah ditetapkan oleh pihak asrama.<br>
					<h4><b>PENGHUNI NON REGULER</b></h4>Penghuni Non Reguler terbuka bagi siapa saja yang ingin mendaftar ke asrama. Penghuni Non Reguler dapat menetapkan tanggal masuk dan tanggal keluar dari asrama sesuai keperluan tinggal.
					<h4><b>KETERSEDIAAN PERIODE PENDAFTARAN</b></h4>Berikut ini adalah ketersediaan periode pendaftaran.<br>

				</p>
				<div style="text-align: center;"><a href="#"><button class="button">Daftar Sekarang</button></a></div>
			@endif
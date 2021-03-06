				<!-- PENGISIAN FORM DATA PENGHUNI DAN NIM PENGHUNI -->
				@if(ITBdorm::DataUser(DormAuth::User()->id)->id_penghuni == NULL)
				<h1 style="margin-top: 0px;"><b>Data Diri Penghuni</b></h1>
				<p>Sebelum melanjutkan pada daftar aplikasi, silahkan melengkapi data diri Anda pada form di bawah ini.</p>
				<form  method="POST" role="form" action="{{ route('daftar_penghuni') }}">
					{{ csrf_field() }}
					<div class="sider">
                    	<div style="margin-top: 0px; height: 4px; background-color: #0769B0; border-top-left-radius: 3px; border-top-right-radius: 3px;"></div>
						<div class="sider_body" style="background-color: white; padding: 10px 15px 10px 15px;">
                        	<h4><b>Data Kemahasiswaan</b></h4><hr>
							<label>Apakah Anda mahasiswa ITB?</label><br>
							<input id="mahasiswa" name="mahasiswa" type="radio" value="1" <?php if(old('mahasiswa')== "1") { echo 'checked="checked"'; } ?> required> Yes, I am a student<br>
							<input id="mahasiswa" name="mahasiswa" type="radio" value="0" <?php if(old('mahasiswa')== "0") { echo 'checked="checked"'; } ?> required> No, I am not a student<br>
							<div id="non_itb" style="display: none;">
								<br><input class="input" name="instansi" type="text" value="" placeholder="Nama Instansi"><br>
							</div>
							<div id="itb" style="display: none;">
								<input class="input" name="instansi_itb" type="text" value="Institut Teknologi Bandung" disabled><br><br>
							</div>
							<div id="std">
								<input type="hidden" name="registrasi" value="0">
							</div>
							<div id="m_nim">
							</div>

							<div id="fak" style="display: none;"><br>
								<label>Pilih Fakultas</label><br>
								<select name="fakultas" id="fakultas">
									<option value="" selected>~~Pilih Fakultas~~</option>
									@foreach($fakultas as $fakultas)
										<option value="{{$fakultas->id_fakultas}}">{{$fakultas->nama}}</option>
									@endforeach
								</select>
							</div>
						</div>
						<script type="text/javascript">
							$(document).ready(function(){
								$("input[type=radio][name=mahasiswa]").change(function(){
									$('#fak').hide(500);
								  	var mahasiswa = $(this).val();
								  	if(mahasiswa == 0){
								  		$('#non_itb').show(500);
								  	}else{
								  		$('#non_itb').hide(500);
								  	}
								  	var kode = 'mahasiswa';
								  	$.post('mahasiswa',{
								  		'kode': kode,
								  		'mahasiswa': mahasiswa, 
								  		'_token':$('input[name=_token]').val()
								  	}, function(data, status){
								  		console.log(kode);
										$('#std').html(data);
									});
								});
							});
						</script>
					</div><br>
					<div class="sider">
                    	<div style="margin-top: 0px; height: 4px; background-color: #0769B0; border-top-left-radius: 3px; border-top-right-radius: 3px;"></div>
						<div class="sider_body" style="background-color: white; padding: 10px 15px 10px 15px;">
                        	<h4><b>Data Diri</b></h4><hr>
							<div class="form-group{{ $errors->has('nomor_identitas') ? ' has-error' : '' }}">
								<input id="nomor_identitas" class="input" name="nomor_identitas" type="text" value="{{old('nomor_identitas')}}" placeholder="Nomor Identitas" required><br>
								@if ($errors->has('nomor_identitas'))
	                                <span class="help-block">
	                                    <strong>{{ $errors->first('nomor_identitas') }}</strong>
	                                </span>
	                            @endif
							</div>
							<div class="form-group{{ $errors->has('jenis_identitas') ? ' has-error' : '' }}">
								<input id="jenis_identitas" class="input" name="jenis_identitas" type="text" value="{{old('jenis_identitas')}}" placeholder="Jenis Identitas (contoh: SIM, KTP, paspor)" required><br>
								@if ($errors->has('jenis_identitas'))
	                                <span class="help-block">
	                                    <strong>{{ $errors->first('jenis_identitas') }}</strong>
	                                </span>
	                            @endif
							</div>
							<div class="form-group{{ $errors->has('tempat lahir') ? ' has-error' : '' }}">
								<input id="tempat_lahir" class="input" name="tempat_lahir" type="text" value="{{old('tempat_lahir')}}" placeholder="Kota Lahir" required><br>
								@if ($errors->has('tempat_lahir'))
	                                <span class="help-block">
	                                    <strong>{{ $errors->first('tempat_lahir') }}</strong>
	                                </span>
	                            @endif
							</div>
							<div class="form-group{{ $errors->has('tanggal_lahir') ? ' has-error' : '' }}">
								<label>Tanggal Lahir</label><br>
									<input class="input" id="tanggal_lahir" name="tanggal_lahir" placeholder="Tanggal Lahir (YYYY-MM-DD)" type="date" value="{{old('tanggal_lahir')}}" required>
								@if ($errors->has('tanggal_lahir'))
		                            <span class="help-block">
		                                <strong>{{ $errors->first('tanggal_lahir') }}</strong>
		                            </span>
		                        @endif
							</div>
							Golongan Darah:<br>
							<input type="radio" name="gol_darah" value="O" <?php if(old('gol_darah')== "O") { echo 'checked="checked"'; } ?> required> O
							<span style="display: inline-block; width: 50px;"></span>
							<input type="radio" name="gol_darah" value="AB" required <?php if(old('gol_darah')== "AB") { echo 'checked="checked"'; } ?>> AB
							<span style="display: inline-block; width: 50px;"></span>
							<input type="radio" name="gol_darah" value="A" <?php if(old('gol_darah')== "A") { echo 'checked="checked"'; } ?> required> A
							<span style="display: inline-block; width: 50px;"></span>
							<input type="radio" name="gol_darah" value="B" <?php if(old('gol_darah')== "B") { echo 'checked="checked"'; } ?> required> B
							<span style="display: inline-block; width: 50px;"></span><br><br>
							Jenis Kelamin:<br>
							<input type="radio" name="kelamin" value="L" <?php if(old('kelamin')== "L") { echo 'checked="checked"'; } ?> required> Laki-laki
							<span style="display: inline-block; width: 50px;"></span>
							<input type="radio" name="kelamin" value="P" <?php if(old('kelamin')== "P") { echo 'checked="checked"'; } ?> required> Perempuan<br><br>
							Asal Negara:<br>
							<select id="country" name ="negara" value="{{old('negara')}}" required></select></br></br>
							Propinsi/State:<br>
							<select name ="propinsi" id ="state" value="{{old('propinsi')}}" required></select></br></br>
							<script language="javascript">
								populateCountries("country", "state");
							</script>
							<div class="form-group{{ $errors->has('kota') ? ' has-error' : '' }}">
								<input id="kota" class="input" name="kota" type="text" value="{{old('kota')}}" placeholder="Nama Kota" required><br>
								@if ($errors->has('kota'))
	                                <span class="help-block">
	                                    <strong>{{ $errors->first('kota') }}</strong>
	                                </span>
	                            @endif
							</div>
							<div class="form-group{{ $errors->has('alamat') ? ' has-error' : '' }}">
								<input id="alamat" class="input" name="alamat" type="text" value="{{old('alamat')}}" placeholder="Alamat" required><br>
								@if ($errors->has('alamat'))
	                                <span class="help-block">
	                                    <strong>{{ $errors->first('alamat') }}</strong>
	                                </span>
	                            @endif
							</div>
							<div class="form-group{{ $errors->has('kodepos') ? ' has-error' : '' }}">
								<input id="kodepos" class="input" name="kodepos" type="text" value="{{old('kodepos')}}" placeholder="Kode Pos" required><br>
								@if ($errors->has('kodepos'))
	                                <span class="help-block">
	                                    <strong>{{ $errors->first('kodepos') }}</strong>
	                                </span>
	                            @endif
							</div>
							<div class="form-group{{ $errors->has('agama') ? ' has-error' : '' }}">
								<input id="agama" class="input" name="agama" type="text" value="{{old('agama')}}" placeholder="Agama" required><br>
								@if ($errors->has('agama'))
	                                <span class="help-block">
	                                    <strong>{{ $errors->first('agama') }}</strong>
	                                </span>
	                            @endif
							</div>
							<div class="form-group{{ $errors->has('pekerjaan') ? ' has-error' : '' }}">
								<input id="pekerjaan" class="input" name="pekerjaan" type="text" value="{{old('pekerjaan')}}" placeholder="Pekerjaan" required><br>
								@if ($errors->has('pekerjaan'))
	                                <span class="help-block">
	                                    <strong>{{ $errors->first('pekerjaan') }}</strong>
	                                </span>
	                            @endif
							</div>
							Warga Negara:<br>
							<select id="country2" name ="warga_negara" value="{{old('warga_negara')}}" required></select><br><br>
							<div class="form-group{{ $errors->has('telepon') ? ' has-error' : '' }}">
								<input id="telepon" class="input" name="telepon" type="text" value="{{old('telepon')}}" placeholder="Telepon" required><br>
								@if ($errors->has('telepon'))
	                                <span class="help-block">
	                                    <strong>{{ $errors->first('telepon') }}</strong>
	                                </span>
	                            @endif
							</div>
							<div class="form-group{{ $errors->has('kontak_darurat') ? ' has-error' : '' }}">
								<input id="kontak_darurat" class="input" name="kontak_darurat" type="text" value="{{old('kontak_darurat')}}" placeholder="Telepon Darurat" required><br>
								@if ($errors->has('kontak_darurat'))
	                                <span class="help-block">
	                                    <strong>{{ $errors->first('kontak_darurat') }}</strong>
	                                </span>
	                            @endif
							</div>
							<script language="javascript">
								populateCountries("country2");
							</script>
						</div>
					</div><br>
					<div class="sider">
                    	<div style="margin-top: 0px; height: 4px; background-color: #0769B0; border-top-left-radius: 3px; border-top-right-radius: 3px;"></div>
						<div class="sider_body" style="background-color: white; padding: 10px 15px 10px 15px;">
                        	<h4><b>Data Orang Tua/Wali</b></h4><hr>
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
			@if(DormAuth::User()->is_penghuni == 0 && ITBdorm::DataUser(DormAuth::User()->id)->id_penghuni != NULL)
				<h1><b>Informasi Pendaftaran</b></h1>
				<p>Terimakasih telah bergabung dengan UPT Asrama ITB. Silahkan daftarkan diri Anda untuk permohonan tinggal di asarama.
					Syarat dan ketentuan adalah sebagai berikut:<br>
					<h4><b>PENGHUNI REGULER</b></h4>Penghuni reguler adalah penghuni dengan status mahasiswa ITB. Seorang penghuni reguler hanya dapat mendaftar pada periode tertentu yang waktunya telah ditetapkan oleh pihak asrama.<br>
					<h4><b>PENGHUNI NON REGULER</b></h4>Penghuni Non Reguler terbuka bagi siapa saja yang ingin mendaftar ke asrama. Penghuni Non Reguler dapat menetapkan tanggal masuk dan tanggal keluar dari asrama sesuai keperluan tinggal.
					<h4><b>KETERSEDIAAN PERIODE PENDAFTARAN</b></h4>Berikut ini adalah ketersediaan periode pendaftaran.<br>

				</p>
				<div style="text-align: center;"><a href="#"><button class="button">Daftar Sekarang</button></a></div>
			@endif
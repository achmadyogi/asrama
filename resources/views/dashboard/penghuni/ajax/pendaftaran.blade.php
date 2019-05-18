@if($_POST['kode'] == 'mahasiswa' && $_POST['mahasiswa'] == 1) <br>
	<input type="text" class="input" name="registrasi" placeholder="Nomor Registrasi" value="{{old('registrasi')}}"><br>
	<p style="color:red;">*untuk mahasiswa non-TPB silahkan mengisi '0' (nol) tanpa tanda petik pada kolom registrasi.</p>
	<label>Apakah Anda sudah memiliki NIM?</label><br>
	<input type="radio" name="nomor_NIM" value="1" id="nomor_NIM"> Sudah<br>
	<input type="radio" name="nomor_NIM" value="0" id="nomor_NIM"> Belum<br>
	<script type="text/javascript">
		$(document).ready(function(){
			$("input[type=radio][name=nomor_NIM]").change(function(){
			  	var no_NIM = $(this).val();
			  	if(no_NIM == 1){
			  		$('#fak').hide(500);
				  	var kode = 'nomor_NIM';
				  		console.log(kode);
				  	$.post('mahasiswa',{
				  		'kode': kode,
				  		'no_NIM': no_NIM, 
				  		'_token':$('input[name=_token]').val()
				  	}, function(data, status){
						$('#m_nim').html(data);
					});
			  	}else{
			  		$('#fak').show(500);
			  		var kode = 'nomor_NIM';
				  		console.log(kode);
				  	$.post('mahasiswa',{
				  		'kode': kode,
				  		'no_NIM': no_NIM, 
				  		'_token':$('input[name=_token]').val()
				  	}, function(data, status){
						$('#m_nim').html(data);
					});
			  	}
			});
		});
	</script>
@endif

@if($_POST['kode'] == 'nomor_NIM' && $_POST['no_NIM'] == 1) <br>
		<input id="nim" type="text" name="nim" class="input" placeholder="Masukkan NIM Anda">
@endif
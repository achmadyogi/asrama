@if($_POST['kode'] == 'mahasiswa' && $_POST['mahasiswa'] == 1) <br>
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
	<div class="form-group{{ $errors->has('nim') ? ' has-error' : '' }}">
		<input id="nim" type="text" name="nim" class="input" value="{{old('nim')}}" placeholder="Masukkan NIM Anda">
		@if ($errors->has('nim'))
        <span class="help-block">
            <strong>{{ $errors->first('nim') }}</strong>
        </span>
    	@endif
	</div>
@endif
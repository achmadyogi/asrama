@extends('layouts.default')

@section('title','Email Penghuni')
@section('menu_dash','active')

@section('main_menu')
	@parent

@endsection

@section('header_title','Penghuni | Email Penghuni')
@section('content')
<div class="container">
	<br><br>
	<div class="row">
		<div class="col-md-9">
			<!-- KONTEN UTAMA-->
			<div id="content">
				<!-- ALERT -->
				@if (session()->has('status1'))
					<div class="alert_fail">
						{{session()->get('status1')}}
					</div> 
				@elseif (session()->has('status2'))
					<div class="alert_success">
						{{session()->get('status2')}}
					</div> 
                @endif
                <h1><b>Email Penghuni</b></h1>
				<div style="border: 1px solid #C9C9C9; border-radius: 5px;">
					<div style="background-color: #E8E8E8; padding: 10px 15px 10px 15px">
						Form Pendaftaran Penghuni Reguler
					</div>
					<div style="padding: 10px 15px 10px 15px;"><br>
						<form action="{{ route('tambah_email') }}" method="post">
                            {{ csrf_field() }}
                           
                            
                            <label>Pilih Jenis Pengiriman</label><br>
	                        <input type="radio" id="single" name="tujuan" value="1" required> Single<br>
                            <input type="radio" id="group" name="tujuan" value="0" required> Group<br><br>
                            <div id="email_tujuan">
                                <label>Tujuan Pengiriman</label>
                                <input class="input" type="text" class="form-control" name="email_tujuan" autofocus><br><br>
                            </div>
                           
                            <div class="form-group {{ $errors->has('konten') ? 'has-error' : '' }}">
                                <label for="konten" class="control-label">Konten</label>
                                <script src ="ckeditor/ckeditor.js"></script>
                                <textarea id="konten" name="konten" cols="30" rows="5" class="form-control"placeholder="Content" required><?php echo old ('content');?>masukan text</textarea>
                                <script type="text/javascript">  
                                        CKEDITOR.replace( 'konten' );
                                        
                                    </script>
                                    @if ($errors->has('konten'))
                                        <span class="help-block">{{ $errors->first('konten') }}</span>
                                    @endif
                            </div>
                           
                            <div class="form-group">
        						<button type="submit" class="btn btn-info">Simpan</button>
       							<a href="{{ route('dashboard') }}" class="btn btn-default">Kembali</a>
   					 		</div>
						</form>
					</div>
                </div>
			</div>
		</div>
        <div class="col-md-3">
            <!-- MENU DASHBOARD -->
            @include('dashboard.menuDashboard')
        </div>
	</div>			
	<br><br><br>
</div>
<script>
    $(document).ready(function () {
        $("#email_tujuan").hide();
        $("#single").click(function () {
            $("#email_tujuan").show(500);
        });
        $("#group").click(function () {
            $("#email_tujuan").hide(500);
        });
    });

    $(document).ready(function () {
        $("#ket_penyakit").hide();
        $("#penyakit1").click(function () {
            $("#ket_penyakit").show(500);
        });
        $("#penyakit2").click(function () {
            $("#ket_penyakit").hide(500);
        });
    });
</script>
@endsection

@extends('layouts.default')

@section('title','Penghuni')
@section('menu_dash','active')

@section('main_menu')
	@parent

@endsection

@section('header_title','Penghuni | Form Keluar Asrama')
@section('content')
<div class="container">
	<br><br>
	<div class="row">
		<div class="col-md-9">
			<!-- KONTEN UTAMA-->
			<!-- ALERT -->
			@if (session()->has('status1'))
				<div class="alert_fail">
					{{session()->get('status1')}}
				</div> 
			@elseif (session()->has('status2'))
				<div class="alert_success">
					{{session()->get('status2')}}
				</div>
			@elseif (session()->has('status3'))
				<div class="alert_file_file">
					{{session()->get('status3')}}
				</div>
			@endif <br>
			
            <h2 style="margin-top: 0px;"><b>Form Pengajuan Keluar Asrama</b></h2>
            <p>Form ini merupakan form yang bisa digunakan penghuni untuk mengajukan keluar asrama. Pengajuan akan diperiksa oleh sekretariat dan akan di tentukan akan diterima keluar atau tidak.</p>
			<div style="border: 1px solid #C9C9C9; border-radius: 5px;">
				<div style="background-color: #E8E8E8; padding: 10px 15px 10px 15px">
					Form Pengajuan Keluar Asrama
				</div>
				<div style="padding: 10px 15px 10px 15px;"><br>
					<form action="{{route('action_pengajuan_keluar')}}" method="post">
		                {{ csrf_field() }}
		                <div class="form-group{{ $errors->has('alasan') ? ' has-error' : '' }}">
						  	<label>Masukkan alasan kenapa Anda mengundurkan diri</label>
						  	<input id="alasan" class="input" type="text" name="alasan" value="{{old('alasan')}}" required/>
						  	@if ($errors->has('alasan'))
		                        <span class="help-block">
		                            <strong>{{ $errors->first('alasan') }}</strong>
		                        </span>
		                    @endif
                        </div>
                        
                    	<div class="form-group{{ $errors->has('tanggal_keluar') ? ' has-error' : '' }}">
    						<label>Masukkan tanggal rencana keluar</label>
    				  		<input id="tanggal_keluar" class="input" type="date" name="tanggal_keluar" value="{{old('tanggal_keluar')}}" required/>
    				  		@if ($errors->has('tanggal_keluar'))
    							<span class="help-block">
    									<strong>{{ $errors->first('tanggal_keluar') }}</strong>
    							</span>
    						@endif
						</div>
						{{-- Cara memasukkan trait ke if --}}
						@foreach ($reguler as $reguler)
						@if ($reguler->id_daftar != NULL && $reguler->verification = 5)
							<input id="id_daftar" class="input" type="hidden" name="id_daftar" value="{{$reguler->id_daftar}}"/>
							<input id="daftar_asrama_type" class="input" type="hidden" name="daftar_asrama_type" value="daftar_asrama_reguler"/>
							<input id="tanggal_masuk" class="input" type="hidden" name="tanggal_masuk" value="{{$reguler->tanggal_masuk}}"/>
						@elseif ($nonReguler->id_daftar != NULL && $nonReguler->verification = 0)
							<input id="id_daftar" class="input" type="hidden" name="id_daftar" value="{{$nonReguler->id_daftar}}"/>
							<input id="daftar_asrama_type" class="input" type="hidden" name="daftar_asrama_type" value="daftar_asrama_non_reguler"/>
							<input id="tanggal_masuk" class="input" type="hidden" name="tanggal_masuk" value="{{$nonReguler->tanggal_masuk}}"/>
						@endif
						@endforeach
                        
                        
                        <button type="submit" class="button">Kirim Permintaan</button>
                       
                        <p style="color:red"><i>*Setelah melakukan pengajuan keluar asrama, harap untuk mendownload formulir keluar asrama  <br>
							Kemudian isi formulir keluar tersebut, dan serahkan ke pengelola asrama. Permintaan keluar akan diproses <br>
							paling lama 24 jam selama hari kerja setelah penyerahan formulir ke pengelola asrama</i></p>
							<br>
		            </form>
		            
		            <form action="{{route('generate_file_keluar_asrama')}}" method="post">
						{{ csrf_field() }}
							@if ($id_daftar != 0 && $verif_reg == 5)
								<input id="id_daftar" class="input" type="hidden" name="id_daftar" value="{{$id_daftar}}"/>
							@elseif ($id_daftar_non != 0 && $verif_non_reg == 0)
								<input id="id_daftar" class="input" type="hidden" name="id_daftar" value="{{$id_daftar_non}}"/>
							@elseif ($verif_reg != 5 && $verif_non_reg != 0)
								<input id="id_daftar" class="input" type="hidden" name="id_daftar" value="0"/>
							@endif
						<button type="submit" class="button-close"> Generate Surat Keluar</button>
					</form>
					
		            <!--<a href="{{route('generate_file_keluar_asrama')}}"> <button class="button-close"> Generate Surat Keluar</button> </a>-->
				</div>
            </div><br><br>
		</div>
		<div class="col-md-3">
			<!-- MENU DASHBOARD -->
			@include('dashboard.menuDashboard')
		</div>
	</div>
	<br><br><br>
</div>
@endsection

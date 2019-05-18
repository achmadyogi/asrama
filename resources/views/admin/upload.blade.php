@extends('layouts.default')

@section('title','Periode Tinggal')
@section('menu_dash','active')

@section('main_menu')
	@parent

@endsection

@section('header_title','Penghuni | Upload File')
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
                <h1><b>Form Upload File</b></h1>
				<div style="border: 1px solid #C9C9C9; border-radius: 5px;">
					<div style="background-color: #E8E8E8; padding: 10px 15px 10px 15px">
						Form Upload File
					</div>
					<div style="padding: 10px 15px 10px 15px;"><br>
						<form action="{{ route('upload_file') }}" method="post">
							{{ csrf_field() }}
							<div class="form-group{{ $errors->has('nama') ? ' has-error' : '' }}">
                                <input id="nama" type="text" name="nama" class="input" value="{{old('nama')}}" placeholder="Masukkan Nama File">
                                @if ($errors->has('nama'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('nama') }}</strong>
                                </span>
                                 @endif
                            </div>
                            <div class="form-group{{ $errors->has('deskripsi') ? ' has-error' : '' }}">
                                <input id="deskripsi" type="text" name="deskripsi" class="input" value="{{old('deskripsi')}}" placeholder="Deskripsi File">
                                @if ($errors->has('deskripsi'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('deskripsi') }}</strong>
                                </span>
                                 @endif
                            </div>
                            <div class="form-group{{ $errors->has('link') ? ' has-error' : '' }}">
                                <input id="link" type="text" name="link" class="input" value="{{old('link')}}" placeholder="URL File">
                                @if ($errors->has('link'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('link') }}</strong>
                                </span>
                                 @endif
                            </div>
							<button class="button" type="submit">Submit</button>
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
@endsection
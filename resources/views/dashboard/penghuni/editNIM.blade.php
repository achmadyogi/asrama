@extends('layouts.default')

@section('title','Periode Tinggal')

@section('main_menu')
	@parent

@endsection

@section('header_title','Penghuni | Edit NIM')
@section('content')
<div class="container">
	<br><br>
	<div class="row">
		<div class="col-md-3">
			<!-- MENU DASHBOARD -->
			@include('dashboard.menuDashboard')
		</div>
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
                <h1><b>Data NIM</b></h1>
                <div class="table">
                    <table>
                        <tr>
                            <th>No.</th>
                            <th>Nama</th>
                            <th>NIM</th>
                            <th>No. Registrasi</th>
                        </tr>
                        <?php $urut = 0; ?>
                        @foreach($nim as $nim)
                        <tr>
                            <td>{{$urut+1}}.</td>
                            <td>{{$nama}}</td>
                            <td>{{$nim->nim}}</td>
                            <td>{{$nim->registrasi}}</td>
                        </tr>
                        @endforeach
                    </table>
                </div>
                <h1><b>Form Edit NIM</b></h1>
				<div style="border: 1px solid #C9C9C9; border-radius: 5px;">
					<div style="background-color: #E8E8E8; padding: 10px 15px 10px 15px">
						Form Edit NIM
					</div>
					<div style="padding: 10px 15px 10px 15px;"><br>
						<form action="{{ route('ganti_nim') }}" method="post">
							{{ csrf_field() }}
							<div class="form-group{{ $errors->has('nim') ? ' has-error' : '' }}">
                                <input id="nim" type="text" name="nim" class="input" value="{{old('nim')}}" placeholder="Masukkan NIM Anda">
                                @if ($errors->has('nim'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('nim') }}</strong>
                                </span>
                                 @endif
                            </div>
							<button class="button" type="submit">Submit</button>
						</form>
					</div>
                </div>
            </div>
        </div>
    </div>
    <br><br><br>
</div>
@endsection
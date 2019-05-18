@extends('layouts.default')

@section('title','Penangguhan')
@section('menu_dash','active')

@section('main_menu')
	@parent

@endsection

@section('header_title','Penghuni | Penangguhan')
@section('content')
<div class="container">
	<br><br>
	<div class="row">
		<div class="col-md-9">
			<!-- KONTEN UTAMA-->
			<div id="content">
                <style type="text/css">
                    .alert_fail {
                        color: black;
                        padding: 5px;
                        background-color: #F5CBCC;
                        border-radius: 5px;
                        border: 1px solid #FF3D40;
                        width: 100%;
                    }
                    .alert_success {
                        color: black;
                        padding: 5px;
                        background-color: #C1E2F7;
                        border-radius: 5px;
                        border: 1px solid #083688;
                        width: 100%;
                    }
                </style>
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
                <h1><b>Record Penangguhan yang Telah Dilakukan</b></h1>
                <?php $show = false ?>
                @foreach($bayar_reg as $reg)
                    @foreach(ITBdorm::Penangguhan($reg->id_daftar) as $tang)
                        <?php $show = true; ?>
                    @endforeach
                @endforeach
                @if($show == false)
                    <p>Belum ada data pembayaran yang sudah dilakukan untuk saat ini.</p>
                @else
                <div class="table">
                    <table>
                        <tr>
                            <th>No.</th>
                            <th>Periode</th>
                            <th>Alasan Penangguhan</th>
                            <th>Tanggal Pelunasan</th>
                            <th>Jumlah Tangguhan</th>
                            <th>Status</th>
                        </tr>
                        <?php $a = 0; ?>
                        @foreach($bayar_reg as $reg)
                            @foreach(ITBdorm::Penangguhan($reg->id_daftar) as $tang)
                                <tr>
                                    <td>{{$a+1}}</td>
                                    <td>{{$reg->nama_periode}}</td>
                                    <td>{{$tang->alasan_penangguhan}}</td>
                                    <td>{{ITBdorm::DateTime($tang->deadline_pembayaran)}}</td>
                                    <td>{{ITBdorm::Currency($tang->jumlah_tangguhan)}}</td>
                                    @if($reg->total - $reg->jumlah_tagihan < 0)
                                        <td style="color: red">Belum terbayar</td>
                                    @else
                                        <td style="color: green;">Sudah dibayar</td>
                                    @endif
                                    <?php $a += 1; ?>
                                </tr>
                            @endforeach
                        @endforeach
                    </table>
                </div>
                @endif <br>
                <h1><b>Penangguhan Pembayaran </b></h1>
                Apabila Anda tidak sanggup untuk membayar asrama di awal. Silahkan mengisi form berikut <br><br>
                <div style="margin-top: 0px; height: 4px; background-color: #0769B0; border-top-left-radius: 3px; border-top-right-radius: 3px;"></div>
                <div class="sider_body" style="background-color: white; padding: 10px 15px 10px 15px;">
					<h4><b>Form Penangguhan Pembayaran</b></h4><hr>
					<div>
                        <form action="{{route('submit_penangguhan_penghuni')}}" method="POST" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <label>Keperluan Penangguhan Pendaftaran</label><br>
                            <select name="list" required>
                                <option value="">Pilih Periode / Keperluan</option>
                            @foreach($bayar_reg as $list_reg)
                                @if($list_reg->verification == 1 || $list_reg->verification == 5 || $list_reg->verification == 6)
                                <option value="{{$list_reg->id_tagihan}}">{{$list_reg->nama_periode}}</option>
                                @endif
                            @endforeach
                            </select><br><br>
                            <label>Jumlah Tangguhan</label><br>
                            <div class="form-group{{ $errors->has('jumlah_tangguhan') ? ' has-error' : '' }}">
                                <input id="jumlah_tangguhan" class="input" name="jumlah_tangguhan" type="number" value="{{old('jumlah_tangguhan')}}" required><br>
                                @if ($errors->has('jumlah_tangguhan'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('jumlah_tangguhan') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <label>Terbilang</label><br>
                            <div class="form-group{{ $errors->has('terbilang') ? ' has-error' : '' }}">
                                <input id="terbilang" class="input" name="terbilang" type="text" value="{{old('terbilang')}}" required><br>
                                @if ($errors->has('terbilang'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('terbilang') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <label>Rincian Bulan yang Ditangguhkan</label><br>
                            <div class="form-group{{ $errors->has('rincian_bulan') ? ' has-error' : '' }}">
                                <input id="rincian_bulan" class="input" name="rincian_bulan" type="text" value="{{old('rincian_bulan')}}" required><br>
                                @if ($errors->has('rincian_bulan'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('rincian_bulan') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <label>Alasan Ditangguhkan</label><br>
                            <div class="form-group{{ $errors->has('alasan') ? ' has-error' : '' }}">
                                <input id="alasan" class="input" name="alasan" type="text" value="{{old('alasan')}}" required><br>
                                @if ($errors->has('alasan'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('alasan') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <label>Waktu Pelunasan</label><br>
                            <div class="form-group{{ $errors->has('pelunasan') ? ' has-error' : '' }}">
                                <input id="pelunasan" class="input" name="pelunasan" type="date" value="{{old('pelunasan')}}" required><br>
                                @if ($errors->has('pelunasan'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('pelunasan') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <button type="submit" class="button" name="submit">Submit</button>
                        </form><br>
					</div>
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
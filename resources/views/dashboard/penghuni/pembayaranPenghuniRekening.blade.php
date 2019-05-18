@extends('layouts.default')

@section('title','Pembayaran')
@section('menu_dash','active')

@section('main_menu')
	@parent

@endsection

@section('header_title','Penghuni | Pembayaran (Rekening Penampungan)')
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
                <h1><b>Record Pembayaran yang Telah Dilakukan</b></h1>
                <h3><b>Record Pembayaran non Reguler</b></h3>
                <?php $show = false ?>
                @foreach($bayar_non as $non)
                    @foreach(ITBdorm::NonRegPay($non->id_daftar) as $nonregpay)
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
                                <th>Tujuan Tinggal</th>
                                <th>Tanggal Bayar</th>
                                <th>Nomor Transaksi</th>
                                <th>Jumlah Pembayaran</th>
                                <th>Keterangan</th>
                                <th>Status</th>
                            </tr>
                            <?php $a = 0; ?>
                            @foreach($bayar_non as $non)
                                @foreach(ITBdorm::NonRegPay($non->id_daftar) as $nonregpay)
                                    <tr>
                                        <td>{{$a+1}}</td>
                                        <td>{{$non->tujuan_tinggal}}</td>
                                        <td>{{ITBdorm::DateTime($nonregpay->tanggal_bayar)}}</td>
                                        <td><a target="_blank" href="{{Storage::url($nonregpay->file)}}"> {{$nonregpay->nomor_transaksi}}</a></td>
                                        <td>{{ITBdorm::Currency($nonregpay->jumlah_bayar)}}</td>
                                        <td>{{$nonregpay->keterangan}}</td>
                                        @if($nonregpay->is_accepted == 0)
                                            <td>Belum Diperiksa</td>
                                        @elseif($nonregpay->is_accepted == 1)
                                            <td style="color: green;">Pembayaran Diterima</td>
                                        @elseif($nonregpay->is_accepted == 2)
                                            <td style="color: red">Pembayaran/Penangguhan Ditolak</td>
                                        @endif
                                        <?php $a += 1; ?>
                                    </tr>
                                @endforeach
                            @endforeach
                        </table>
                    </div>
                @endif <br>
                <h3><b>Record Pembayaran Reguler</b></h3>
                <?php $show = false ?>
                @foreach($bayar_reg as $reg)
                    @foreach(ITBdorm::RegPay($reg->id_daftar) as $regpay)
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
                                <th>Nama Periode</th>
                                <th>Tanggal Bayar</th>
                                <th>Nomor Transaksi</th>
                                <th>Jumlah Pembayaran</th>
                                <th>Keterangan</th>
                                <th>Status</th>
                            </tr>
                            <?php $a = 0; ?>
                            @foreach($bayar_reg as $r)
                                @foreach(ITBdorm::RegPay($r->id_daftar) as $regpay)
                                    <tr>
                                        <td>{{$a+1}}</td>
                                        <td>{{$r->nama_periode}}</td>
                                        <td>{{ITBdorm::DateTime($regpay->tanggal_bayar)}}</td>
                                        <td><a target="_blank" href="{{Storage::url($regpay->file)}}"> {{$regpay->nomor_transaksi}}</a></td>
                                        <td>{{ITBdorm::Currency($regpay->jumlah_bayar)}}</td>
                                        @if($regpay->keterangan == NULL)
                                        <td>-</td>
                                        @else
                                            <td>{{$regpay->keterangan}}</td>
                                        @endif
                                        @if($regpay->is_accepted == 0)
                                            <td>Belum Diperiksa</td>
                                        @elseif($regpay->is_accepted == 1)
                                            <td style="color: green;">Pembayaran Diterima</td>
                                        @elseif($regpay->is_accepted == 2)
                                            <td style="color: red">Pembayaran/Penangguhan Ditolak</td>
                                        @endif
                                        <?php $a += 1; ?>
                                    </tr>
                                @endforeach
                            @endforeach
                        </table>
                    </div>
                @endif <br>
				<h1><b>Pembayaran Pendaftaran </b></h1>
                Setelah Anda melakukan pembayaran di bank, silahkan konfirmasi pembayaran Anda di form berikut ini.<br><br>
				<div style="margin-top: 0px; height: 4px; background-color: #0769B0; border-top-left-radius: 3px; border-top-right-radius: 3px;"></div>
                <div class="sider_body" style="background-color: white; padding: 10px 15px 10px 15px;">
					<h4><b>Form Pembayaran Penghuni (Rekening Penampungan)</b></h4>
					<div style="padding: 10px 15px 10px 15px;">
                        <form action="{{route('submit_pembayaran_rekening')}}" method="POST" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <label>Pendaftaran Untuk</label><br>
                            <select name="list" required>
                                <option value="">Pilih Periode / Keperluan</option>
                            @foreach($bayar_reg as $list_reg)
                                @if($list_reg->verification == 1 || $list_reg->verification == 5 || $list_reg->verification == 6)
                                <option value="{{$list_reg->id_tagihan}}">{{$list_reg->nama_periode}}</option>
                                @endif
                            @endforeach
                            @foreach($bayar_non as $list_non)
                                @if($list_non->verification == 1 || $list_non->verification == 5 || $list_non->verification == 6)
                                <option value="{{$list_non->id_tagihan}}">{{$list_non->tujuan_tinggal}}</option>
                                @endif
                            @endforeach
                            </select><br><br>
                            <label>Nama Pengirim</label><br>
                            <div class="form-group{{ $errors->has('nama_pengirim') ? ' has-error' : '' }}">
                                <input id="nama_pengirim" class="input" name="nama_pengirim" type="text" value="{{old('nama_pengirim')}}" required><br>
                                @if ($errors->has('nama_pengirim'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('nama_pengirim') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <label>Bank Asal</label><br>
                            <div class="form-group{{ $errors->has('bank_asal') ? ' has-error' : '' }}">
                                <input id="bank_asal" class="input" name="bank_asal" type="text" value="{{old('bank_asal')}}" required><br>
                                @if ($errors->has('bank_asal'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('bank_asal') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <label>Tanggal Bayar</label><br>
                            <div class="form-group{{ $errors->has('tanggal_bayar') ? ' has-error' : '' }}">
                                <input id="tanggal_bayar" class="input" name="tanggal_bayar" type="date" value="{{old('tanggal_bayar')}}" placeholder="Nomor Identitas" required><br>
                                @if ($errors->has('tanggal_bayar'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('tanggal_bayar') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <label>Nomor Transaksi</label><br>
                            <div class="form-group{{ $errors->has('nomor_transaksi') ? ' has-error' : '' }}">
                                <input id="nomor_transaksi" class="input" name="nomor_transaksi" type="text" value="{{old('nomor_transaksi')}}" required><br>
                                @if ($errors->has('nomor_transaksi'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('nomor_transaksi') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <label>Jumlah Bayar</label><br>
                            <div class="form-group{{ $errors->has('jumlah_bayar') ? ' has-error' : '' }}">
                                <input id="jumlah_bayar" class="input" name="jumlah_bayar" type="number" value="{{old('jumlah_bayar')}}" required><br>
                                @if ($errors->has('jumlah_bayar'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('jumlah_bayar') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <label>Keterangan</label><br>
                            <div class="form-group{{ $errors->has('keterangan') ? ' has-error' : '' }}">
                                <input id="keterangan" class="input" name="keterangan" type="text" value="{{old('keterangan')}}" required><br>
                                @if ($errors->has('keterangan'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('keterangan') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <input type="file" name="file" required>
                            <small>Ukuran file maksimal adalah 500 KB. Gunakan file .jpg, .png, atau .jpeg</small><br><br>
                            <button type="submit" class="button" name="submit">Kumpulkan</button>
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

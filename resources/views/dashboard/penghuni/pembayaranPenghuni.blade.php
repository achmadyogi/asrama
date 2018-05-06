@extends('layouts.default')

@section('title','Pembayaran')

@section('main_menu')
	@parent

@endsection

@section('header_title','Penghuni | Pembayaran')
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
                <h1><b>Record Pendaftaran yang Telah Dilakukan</b></h1>
                <h3><b>Record Pendaftaran non Reguler</b></h3>
                @if($non_exist == 0)
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
                        @foreach($bayar_non as $bayar_non)
                            <tr>
                                <td>{{$a+1}}</td>
                                <td>{{$bayar_non->tujuan_tinggal}}</td>
                                <td>{{$tanggal_bayar[$a]}}</td>
                                <td>{{$bayar_non->nomor_transaksi}}</td>
                                 @if(strlen($bayar_non->jumlah_bayar) == 6)
                                    <td>Rp<?php echo substr($bayar_non->jumlah_bayar, -6, 3).".".substr($bayar_non->jumlah_bayar, -3).",00"; ?></td>
                                @elseif(strlen($bayar_non->jumlah_bayar) == 5)
                                    <td>Rp<?php echo substr($bayar_non->jumlah_bayar, -6, 2).".".substr($bayar_non->jumlah_bayar, -3).",00"; ?></td>
                                @endif
                                <td>{{$bayar_non->keterangan}}</td>
                                @if($bayar_non->is_accepted == 0)
                                    <td>Belum Diperiksa</td>
                                @else
                                    <td style="color: green;">Pembayaran Diterima</td>
                                @endif
                                <?php $a += 1; ?>
                            </tr>
                        @endforeach
                    </table>
                @endif <br>
                <h3><b>Record Pendaftaran Reguler</b></h3>
                @if($reg_exist == 0)
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
                        @foreach($bayar_reg as $bayar_reg)
                            <tr>
                                <td>{{$a+1}}</td>
                                <td>{{$bayar_reg->tujuan_tinggal}}</td>
                                <td>{{$tanggal_bayar_reg[$a]}}</td>
                                <td>{{$bayar_reg->nomor_transaksi}}</td>
                                 @if(strlen($bayar_reg->jumlah_bayar) == 6)
                                    <td>Rp<?php echo substr($bayar_reg->jumlah_bayar, -6, 3).".".substr($bayar_reg->jumlah_bayar, -3).",00"; ?></td>
                                @elseif(strlen($bayar_reg->jumlah_bayar) == 5)
                                    <td>Rp<?php echo substr($bayar_reg->jumlah_bayar, -6, 2).".".substr($bayar_reg->jumlah_bayar, -3).",00"; ?></td>
                                @endif
                                <td>{{$bayar_reg->keterangan}}</td>
                                @if($bayar_reg->is_accepted == 0)
                                    <td>Belum Diperiksa</td>
                                @else
                                    <td style="color: green;">Pembayaran Diterima</td>
                                @endif
                                <?php $a += 1; ?>
                            </tr>
                        @endforeach
                    </table>
                @endif <br>
				<h1><b>Pembayaran Pendaftaran</b></h1>
                Setelah Anda melakukan pembayaran di bank, silahkan konfirmasi pembayaran Anda di form berikut ini.<br><br>
				<div style="border: 1px solid #C9C9C9; border-radius: 5px;">
					<div style="background-color: #E8E8E8; padding: 10px 15px 10px 15px">
						Form Pembayaran Penghuni
					</div>
					<div style="padding: 10px 15px 10px 15px;"><br>
                        <form action="{{route('submit_pembayaran')}}" method="POST" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <label>Pendaftaran Untuk</label><br>
                            <select name="list">
                            @foreach($list_reg as $list_reg)
                                <option value="{{$list_reg->id_tagihan}}">{{$list_reg->nama_periode}}</option>
                            @endforeach
                            @foreach($list_non as $list_non)
                                <option value="{{$list_non->id_tagihan}}">{{$list_non->tujuan_tinggal}}</option>
                            @endforeach
                            </select><br><br>
                            <label>Tanggal Bayar</label><br>
                            <div class="form-group{{ $errors->has('tanggal_bayar') ? ' has-error' : '' }}">
                                <input id="tanggal_bayar" class="input" name="tanggal_bayar" type="date" value="{{old('tanggal_bayar')}}" placeholder="Nomor Identitas" required><br>
                                @if ($errors->has('tanggal_bayar'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('tanggal_bayar') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group{{ $errors->has('nomor_transaksi') ? ' has-error' : '' }}">
                                <input id="nomor_transaksi" class="input" name="nomor_transaksi" type="text" value="{{old('nomor_transaksi')}}" placeholder="Nomor Transaksi" required><br>
                                @if ($errors->has('nomor_transaksi'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('nomor_transaksi') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group{{ $errors->has('jumlah_bayar') ? ' has-error' : '' }}">
                                <input id="jumlah_bayar" class="input" name="jumlah_bayar" type="number" value="{{old('jumlah_bayar')}}" placeholder="Jumlah Pembayaran" required><br>
                                @if ($errors->has('jumlah_bayar'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('jumlah_bayar') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <input type="file" name="file" required><br>
                            <button type="submit" class="button" name="submit">Kumpulkan</button>
                        </form><br>
					</div>
				</div>
			</div>
		</div>
	</div>			
	<br><br><br>
</div>
</div>
@endsection

@extends('layouts.default')

@section('title','Halaman Checkout Otomatis')
@section('menu_dash','active')

@section('main_menu')
	@parent

@endsection

@section('header_title','Admin | Halaman Checkout Otomatis')
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
				@endif
				@if (session()->has('status2'))
					<div class="alert_success">
						{{session()->get('status2')}}
					</div> 
                @endif
                <h2><b>Halaman Checkout Otomatis</b></h2><hr>
                <form action="{{ route('filter_checkout_otomatis') }}" method="POST" style="display:inline-block">
					{{ csrf_field() }}
					<b>Filter Penghuni</b><br>
                    <label>Penghuni</label><br>
					<select name="penghuni" required>
                        <option value="">~~Pilih filter penghuni~~</option>
                        <option value="0">Reguler</option>
                        <option value="1">Non Reguler</option>
                    </select><br>
                    <label>Periode</label><br>
					<select name="periode" required>
                        <option value="">~~Pilih filter periode~~</option>
                        @foreach($filter_periode as $periode)
                            <option value="{{$periode->id_periode}}">{{$periode->nama_periode}}</option>
                        @endforeach
						<option value="">Semua</option>
                    </select><br>
                    <label>Asrama</label><br>
                    <select name="asrama" required>
                        <option value="">~~Pilih filter asrama~~</option>
                        @foreach($filter_asrama as $asrama)
                            <option value="{{$asrama->id_asrama}}">{{$asrama->nama}}</option>
                        @endforeach
						<option value="">Semua</option>
                    </select><br>
                    <label>Gedung</label><br>
                    <select name="gedung" required>
						<option value="">~~Pilih filter gedung~~</option>
						@foreach($filter_gedung as $gedung)
                            <option value="{{$gedung->id_gedung}}">{{$gedung->nama}}</option>
                        @endforeach
						<option value="">Semua</option>
					</select><br><br>
					<button class="button" type="submit">Submit</button>
                </form>
                @if($data != 0)
                    <form action="{{ route('tombol_checkout_otomatis') }}" method="POST" style="display:inline-block">
                        {{ csrf_field() }}
                        {{-- <input type="hidden" name="id_penghuni" value="{{$data->id_daftar}}"/>
                        <input type="hidden" name="tanggal_masuk" value="{{$data->tanggal_masuk}}"/> --}}
                        <input type="hidden" name="asrama" value="{{$var_asrama}}"/>
                        <input type="hidden" name="gedung" value="{{$var_gedung}}"/>
                        <input type="hidden" name="periode" value="{{$var_periode}}"/>
                        <input type="hidden" name="penghuni" value="{{$var_penghuni}}"/>
                        <button class="button-close" type="submit">Checkout Otomatis</button>
                    </form>
                @endif
				<hr>
                @if($data == 0) 
                    <p><i>Belum ada yang data yang ditampilkan</i></p>
                @else
                    <div class="table">
						<table>
							<tr>
								<th>No.</th>
								<th>Nama Penghuni</th>
                                <th>Asrama</th>
                                <th>Gedung</th>
                                <th>Kamar</th>
								<th>Aksi</th>
							</tr>
							<?php $urut = 0; ?>
                            @foreach($data as $data)
                                <tr>
                                    <td>{{$urut+1}}.</td>
                                    <td>{{$data->name}}</td>
                                    <td>{{$data->asrama}}</td>
                                    <td>{{$data->gedung}}</td>
                                    <td>{{$data->kamar}}</td>
                                    <td>
                                        <form action="{{ route('filter_checkout_otomatis') }}" method="POST">
                                            {{ csrf_field() }}
                                            <input type="hidden" name="id_penghuni" value="{{$data->id_daftar}}"/>
                                            <input type="hidden" name="tanggal_masuk" value="{{$data->tanggal_masuk}}"/>
                                            <input type="hidden" name="asrama" value="{{$var_asrama}}"/>
                                            <input type="hidden" name="gedung" value="{{$var_gedung}}"/>
                                            <input type="hidden" name="periode" value="{{$var_periode}}"/>
                                            <input type="hidden" name="penghuni" value="{{$var_penghuni}}"/>
                                            <button class="button-close" type="submit">Checkout</button>
                                        </form>
                                    </td>
                                </tr>
                                
                                <?php $urut += 1; ?>
							@endforeach
						</table>
                    </div>
                @endif
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

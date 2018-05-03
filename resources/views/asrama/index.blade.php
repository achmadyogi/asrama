@extends('layouts.default')


@section('title','Asrama')

@section('menu_asrama','active')
@section('main_menu')
    @parent
@endsection

@section('header_title','Data Asrama ITB')

@section('content')
<div class="container">
	<br><br>
	@foreach($list_asrama as $asrama)
	<div class="row">
		<div class="col-md-4">
			<div style="padding:5px; border: 1px solid grey; border-radius: 5px;"><img src="img/asrama/{{ $asrama->filename }}" width="100%"></div>
		</div> 
		<div class="col-md-8">
			<h2 style="margin-top: 0px;"><b>{{ $asrama->nama }}</b></h2>
			<p><b><i>{{ $asrama->alamat }}</i></b></p>
			<div class="row">
				<div class="col-md-3">
					<p>Jumlah penghuni: {{ $asrama->total_penghuni }}</p>
				</div>
				<div class="col-md-3">
					<p>Kapasitas: {{ $asrama->kapasitas }}</p>
				</div>
			</div>
			<p style="text-align: justify;">{{ $asrama->deskripsi }}</p>
		</div>
	</div><hr>
	@endforeach
</div>
@endsection
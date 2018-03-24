@extends('layouts.app')

@section('content')
<div class="container">
	<div class="panel panel-default">
		<div class="panel-heading">
				<h2 class="row">
				<div class="col-md-10">Data Asrama</div>
				@if ($user and $user->is_admin == '1')
					<div class="col-md-2" style="text-align: right;">
					<a class="btn btn-md btn-primary" href="{{ url('/create_asrama') }}"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span> New Asrama</a>
					</div>
				@endif
				</h2>
		</div>
		<div class="panel-body">
			@foreach($list_asrama as $asrama)
			<div class="row">
				<div class="col-xs-6 col-md-3 left"  style="padding-top: 15px">
					<img class="thumbnail" src="uploads/{{ $asrama->filename }}" style="width:100%">
				</div>
				<div class="col-lg-9 left" style="padding-top: 0px">
					<h4 class="asrama judul-asrama">
					<div class="row">
						<div class="col-md-9">
							{{ $asrama->nama }}
						</div>
						@if ($user and $user->is_pengelola == '1' and $nama_asrama == $asrama->nama)
						<div class="col-md-1">
							<a class="btn btn-success btn-xs" href="{{ url('/asrama') }}/{{ $asrama->id_asrama }}" style="width: 150%;"><span class="glyphicon glyphicon-search" aria-hidden="true"></span><br>Expand</a>
						</div>
						<div class="col-md-1">
							<a class="btn btn-primary btn-xs" href="{{ url('/edit_asrama') }}/{{ $asrama->id_asrama }}" style="width: 150%;"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span><br>Edit</a>
						</div>
						<!--
						<div class="col-md-1">
							<form id="del-asr" method="POST" action="{{ url('/delete_asrama') }}/{{ $asrama->id_asrama }}">
							 {{ csrf_field() }}
								<button type="submit" class="btn btn-danger btn-xs" style="width: 150%;" onclick="delAsramaValidation({{ $asrama->total_penghuni }})"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span><br>Delete</button>
							</form>
						</div>
						-->
						@endif
					</div>
					</h4>
					<p class="asrama alamat-asrama">
						{{ $asrama->alamat }}
					</p>
					<div class="row">
						<div class="col-md-3">
							<p class="asrama desk-asrama">
								Jumlah penghuni: {{ $asrama->total_penghuni }}
							</p>
						</div>
						<div class="col-md-3">
							<p class="asrama desk-asrama">
								Kapasitas: {{ $asrama->kapasitas }}
							</p>
						</div>
					</div>
					<p class="asrama desk-asrama">
						{{ $asrama->deskripsi }}
					</p>
				</div>
			</div>
			<hr>
			@endforeach
		</div>
	</div>
</div>
<script>
function delAsramaValidation(x) {
	if (x != 0) {
		alert("Fungsi delete asrama hanya bisa digunakan pada asrama yang tidak memiliki penghuni!");
		document.getElementById("del-asr").method = "";
		document.getElementById("del-asr").action = "#";
	}
}
</script>
@endsection
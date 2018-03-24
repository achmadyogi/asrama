@extends('layouts.app')

@section('content')
<div class="container">
    <div class="panel panel-default">
        <div class="panel-heading">
        	<h2>
        	<div class="row">
	        	<div class="col-md-10">
	        	Detail Asrama
	        	</div>
	        	<div class="col-md-2" style="text-align: right;">
	        	<a class="btn btn-md btn-primary" href="{{ url('/asrama') }}/{{ $id_asrama }}/create_gedung"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span> New Gedung</a>
	        	</div>
	        </div>
        	</h2>
        </div>
        <div class="panel-body">
        	<div class="col-lg-12 bottom20">
        		<ul class="nav nav-tabs">
        			@foreach ($list_gedung as $gedung)
        				<li @if ($gedung == $list_gedung->first()) class="active" @endif>
        					<a data-toggle="tab" href="#tab_{{ $gedung->id_gedung }}">{{ $gedung->nama }}</a>
        				</li>
        			@endforeach
        		</ul>
        		<div class="tab-content">
        			@foreach ($list_gedung as $gedung)
        			<div class="tab-pane @if ($gedung == $list_gedung->first()) fade in active @endif" id="tab_{{ $gedung->id_gedung }}">
						<div class="row">
							<table class="table table-striped table-condensed table-hover">
								<thead>
									<tr>
										<th style="width:25%">No Kamar</th>
										<th style="width:20%">Kapasitas</th>
										<th style="width:20%">Jenis Kamar</th>
										<th style="width:20%">Gender</th>
										<th style="width:15%">Action</th>
									</tr>
								</thead>
								<tbody>
									@if (count($gedung->list_kamar) == 0)
										<tr>
											<td colspan="5" style="text-align: center; font-size: 25px"><i>Nothing to show.</i></td>
										</tr>
									@else
									@foreach ($gedung->list_kamar as $kamar)
										<tr>
											<td>{{ $kamar->nama }}</td>
											<td>{{ $kamar->jumlah_penghuni ? $kamar->jumlah_penghuni : 0 }}/{{ $kamar->kapasitas }}</td>
											<td>{{ $kamar->status }}</td>
											<td>{{ ($kamar->gender == 'P') ? 'Perempuan' : 'Laki-laki' }}</td>
											<td>
												<div class="row">
													<a id="edit-btn{{ $kamar->id_kamar }}" class="btn btn-sm btn-primary" href="/asrama/{{ $id_asrama }}/{{ $gedung->id_gedung }}/edit_kamar/{{ $kamar->id_kamar}}" onclick="editKamarValidation({{ $kamar->jumlah_penghuni ? $kamar->jumlah_penghuni : 0 }}, {{ $kamar->id_kamar }} )"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> Edit</a>
													<form id="del-btn{{ $kamar->id_kamar }}" method="POST" action="/asrama/{{ $id_asrama }}/{{ $gedung->id_gedung }}/delete_kamar/{{ $kamar->id_kamar}}" style="display: inline;">
													{{ csrf_field() }}
														<button type="" class="btn btn-sm btn-danger" onclick="delKamarValidation({{ $kamar->jumlah_penghuni ? $kamar->jumlah_penghuni : 0 }}, {{ $kamar->id_kamar }})"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span> Delete</button>
													</form>
												</div>
											</td>
										</tr>
									@endforeach
									@endif
								</tbody>
							</table>
						</div>
						<br>
						<div class="row">
						<div class="col-md-6">
						<a class="btn btn-primary" href="/asrama/{{ $id_asrama }}/{{ $gedung->id_gedung }}/create_kamar">
                            <span class="glyphicon glyphicon-plus" aria-hidden="true"></span> New Kamar
                        </a>
                        </div>
                        <div class="col-md-6" style="text-align: right;">
                        <a class="btn btn-warning" href="/asrama/{{ $id_asrama }}/edit_gedung/{{ $gedung->id_gedung }}">
                           <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> Edit Gedung
                        </a>
                        <form id="del-ged" method="POST" action="/asrama/{{ $id_asrama }}/delete_gedung/{{ $gedung->id_gedung }}" style="display: inline;">
						{{ csrf_field() }}
							<button type="submit" class="btn btn-danger" onclick="delGedungValidation({{ $gedung->total_penghuni }})"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span> Delete Gedung</button>
						</form>
						</div>
						</div>
					</div>
					@endforeach
        		</div>
        	</div>
        </div>
    </div>
</div>
<script>
function editKamarValidation(x, id_kamar) {
	if (x != '0') {
		alert("Fungsi delete & edit kamar hanya bisa digunakan pada kamar yang kosong!");
		document.getElementById("edit-btn" + id_kamar).href = "#";
	}
}

function delKamarValidation(x, id_kamar) {
	if (x != '0') {
		alert("Fungsi delete & edit kamar hanya bisa digunakan pada kamar yang kosong!");
		document.getElementById("del-btn" + id_kamar).method = "";
		document.getElementById("del-btn" + id_kamar).action = "#";
	}
}

function delGedungValidation(x) {
	if (x != '0') {
		alert("Fungsi delete gedung hanya bisa digunakan pada gedung yang tidak memiliki penghuni!");
		document.getElementById("del-ged").method = "";
		document.getElementById("del-ged").action = "#";
	}
}
</script>
@endsection

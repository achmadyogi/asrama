@extends('layouts.app')

@section('content')
<div class="container">
    <div class="panel panel-default">
        <div class="panel-heading">
        	<h2>Pengelolaan Pendaftaran {{ $nama_asrama }}</h2>
        </div>
        <div class="panel-body">
        <form class="form-horizontal" role="form" method="POST" action="{{ route('pendaftaran') }}">	
        	{{ csrf_field() }}
        	<!-- JIKA PENGELOLA -->
			<div class="col-lg-12 bottom20">
				<!-- NAVBAR TAB -->
				<ul class="nav nav-tabs">
				<li class="active"><a data-toggle="tab" href="#tab_reguler_bidikmisi">Reguler Bidikmisi</a></li>
				<li><a data-toggle="tab" href="#tab_reguler_noprob">Reguler</a></li>
				<li><a data-toggle="tab" href="#tab_reguler_prob">Reguler Bermasalah</a></li>
				<li><a data-toggle="tab" href="#tab_nonreguler">Non Reguler</a></li>
				</ul>
				<div class="tab-content">
					<!-- Tabel Reguler Bidikmisi -->
					@if ($list_reguler_bidikmisi != NULL)
					<div class="tab-pane fade in active" id="tab_reguler_bidikmisi">
						<div class="panel panel-default">
				        <div class="panel-heading">Penghuni Reguler Bidikmisi</div> 
							<table class="table table-striped table-condensed table-hover">
								<thead>
									<tr>
										<th style="width:5%"><input type="checkbox" id="checkall" name="checkall_np"></th>
										<th style="width:15%">Nama</th>
										<th style="width:15%">NIM</th>
										<th style="width:20%">Asrama</th>
										<th style="width:20%">Tgl Masuk</th>
										<th style="width:20%">Tgl Keluar</th>
									</tr>
								</thead>
								<tbody>
									@if (count ($list_reguler_bidikmisi) == 0)
										<tr>
											<td colspan="6" style="text-align: center; font-size: 25px"><i>Nothing to show.</i></td>
										</tr>
									@else
									@foreach ($list_reguler_bidikmisi as $key=>$data)
										<tr>
											<td><input type="checkbox" name="check_bm_{{$key}}"></td>
											<td>{{ $data->nama }}</td>
											<td>{{ $data->nim }}</td>
											<td>{{ $data->asrama }}</td>
											<td>{{ date_format(DateTime::createFromFormat('Y-m-d', $data->tanggal_masuk),"d M Y") }}</td>
											<td>{{ date_format(DateTime::createFromFormat('Y-m-d', $data->tanggal_keluar),"d M Y") }}</td>
										</tr>
									@endforeach
									@endif
								</tbody>
							</table>
						</div>
					</div>
					@endif

					<!-- Tabel Reguler Tidak Bermasalah -->
					@if ($list_reguler_tidak_bermasalah != NULL)
					<div class="tab-pane fade" id="tab_reguler_noprob">
						<div class="panel panel-default">
				        <div class="panel-heading">Penghuni Reguler Tidak Bermasalah</div> 
							<table class="table table-striped table-condensed table-hover">
								<thead>
									<tr>
										<th style="width:5%"><input type="checkbox" id="checkall" name="checkall_np"></th>
										<th style="width:15%">Nama</th>
										<th style="width:15%">NIM</th>
										<th style="width:20%">Asrama</th>
										<th style="width:20%">Tgl Masuk</th>
										<th style="width:20%">Tgl Keluar</th>
									</tr>
								</thead>
								<tbody>
									@if (count ($list_reguler_tidak_bermasalah) == 0)
										<tr>
											<td colspan="6" style="text-align: center; font-size: 25px"><i>Nothing to show.</i></td>
										</tr>
									@else
									@foreach ($list_reguler_tidak_bermasalah as $key=>$data)
										<tr>
											<td><input type="checkbox" name="check_np_{{$key}}"></td>
											<td>{{ $data->nama }}</td>
											<td>{{ $data->nim }}</td>
											<td>{{ $data->asrama }}</td>
											<td>{{ date_format(DateTime::createFromFormat('Y-m-d', $data->tanggal_masuk),"d M Y") }}</td>
											<td>{{ date_format(DateTime::createFromFormat('Y-m-d', $data->tanggal_keluar),"d M Y") }}</td>
										</tr>
									@endforeach
									@endif
								</tbody>
							</table>
						</div>
					</div>
					@endif

					<!-- Tabel Reguler Bermasalah -->
					@if ($list_reguler_bermasalah != NULL)
					<div class="tab-pane fade" id="tab_reguler_prob">
						<div class="panel panel-default">
				        <div class="panel-heading">Penghuni Reguler Bermasalah (tidak memiliki NIM)</div> 
							<table class="table table-striped table-condensed table-hover">
								<thead>
									<tr>
										<th style="width:5%"><input type="checkbox" id="checkall" name="checkall_p"></th>
										<th style="width:25%">Nama</th>
										<th style="width:25%">Asrama</th>
										<th style="width:20%">Tgl Masuk</th>
										<th style="width:20%">Tgl Keluar</th>
									</tr>
								</thead>
								<tbody>
									@if (count ($list_reguler_bermasalah) == 0)
										<tr>
											<td colspan="6" style="text-align: center; font-size: 25px"><i>Nothing to show.</i></td>
										</tr>
									@else
									@foreach ($list_reguler_bermasalah as $key=>$data)
										<tr>
											<td><input type="checkbox" name="check_p_{{$key}}"></td>
											<td>{{ $data->nama }}</td>
											<td>{{ $data->asrama }}</td>
											<td>{{ date_format(DateTime::createFromFormat('Y-m-d', $data->tanggal_masuk),"d M Y") }}</td>
											<td>{{ date_format(DateTime::createFromFormat('Y-m-d', $data->tanggal_keluar),"d M Y") }}</td>
										</tr>
									@endforeach
									@endif
								</tbody>
							</table>
						</div>
					</div>
					@endif

					<!-- Tabel Non Reguler -->
					@if ($list_non_reguler != NULL)
					<div class="tab-pane fade {{ (isset($error_non_reguler)) ? ' has-error' : '' }}" id="tab_nonreguler">
						<div class="panel panel-default">
				        <div class="panel-heading">Penghuni Non Reguler</div> 
							<table class="table table-striped table-condensed table-hover">
								<thead>
									<tr>
										<th style="width:5%"><input type="checkbox" id="checkall" name="checkall_nr"></th>
										<th style="width:25%">Nama</th>
										<th style="width:25%">Asrama</th>
										<th style="width:20%">Tgl Masuk</th>
										<th style="width:20%">Tgl Keluar</th>
									</tr>
								</thead>
								<tbody>
									@if (count ($list_non_reguler) == 0)
										<tr>
											<td colspan="6" style="text-align: center; font-size: 25px"><i>Nothing to show.</i></td>
										</tr>
									@else
									@foreach ($list_non_reguler as $key=>$data)
										<tr>
											<td><input type="checkbox" name="check_nr_{{$key}}"></td>
											<td>{{ $data->nama }}</td>
											<td>{{ $data->asrama }}</td>
											<td>{{ date_format(DateTime::createFromFormat('Y-m-d', $data->tanggal_masuk),"d M Y") }}</td>
											<td>{{ date_format(DateTime::createFromFormat('Y-m-d', $data->tanggal_keluar),"d M Y") }}</td>
										</tr>
									@endforeach
									@endif
								</tbody>
							</table>
						</div>
					</div>
					@endif
				</div>

			</div>
			<!-- END OF JIKA PENGELOLA -->
			<div class="form-group">
				<label for="id" class="col-xs-9 control-label">Action</label>
				<div class="col-xs-3">
					<select id="action" class="form-control" name="action" required>
						<option value="accept">Accept selected</option>
						<option value="reject">Reject selected</option>
					</select>
				</div>
			</div>
			<div class="form-group">
                <div class="col-md-12">
                    <div class="col-md-5"></div>
                    <a class="btn btn-default" href="{{ route('dashboard') }}"><i class="glyphicon glyphicon-chevron-left"></i> Back</a>
                    <button type="submit" class="btn btn-success">
                        Submit
                    </button>
                </div>
            </div>
		</form>
        </div>
    </div>
</div>

@if (isset($error_reguler) && $error_reguler != '')
<script>
	alert('{{ $error_reguler }}');
</script>
@elseif (isset($error_non_reguler) && $error_non_reguler != '')
<script>
	alert('{{ $error_non_reguler }}');
</script>
@endif
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script>
$(document).ready(function(){
    $("input[name=checkall_np]").change(function(){
    	$('tbody tr td input[type="checkbox"][name^=check_np]').prop('checked', $(this).prop('checked'));
	});
	$("input[name=checkall_p]").change(function(){
    	$('tbody tr td input[type="checkbox"][name^=check_p]').prop('checked', $(this).prop('checked'));
	});
	$("input[name=checkall_nr]").change(function(){
    	$('tbody tr td input[type="checkbox"][name^=check_nr]').prop('checked', $(this).prop('checked'));
	});
});
</script>
@endsection

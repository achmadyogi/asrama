@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">
                	<h2>Pengelolaan Periode Lanjutan</h2>
                </div>
                <div class="panel-body">
                	<div class="col-lg-12 bottom20">
                		<div class="tab-content">
								<div class="panel panel-default">
								<div class="panel-heading"><h4>Daftar Periode Berlanjut</h4></div>
									<table class="table table-striped table-condensed table-hover">
										<thead>
											<tr>
												<th style="width:30%">Periode Asal</th>
												<th style="width:30%">Periode Baru</th>
												<th style="width:30%">Created At</th>
												<th style="width:10%">Action</th>
											</tr>
										</thead>
										<tbody>
											@if (count($list_next_periode) == 0)
												<tr>
													<td colspan="4" style="text-align: center; font-size: 25px;">
														<i>Nothing to show</i>
													</td>
											@else
												@foreach ($list_next_periode as $data)
												<tr>
													<td>{{ $data->nama_periode_asal }}</td>
													<td>{{ $data->nama_periode_akhir }}</td>
													<td>{{ date_format(DateTime::createFromFormat('Y-m-d', $data->created_at),"l, d M Y") }}</td>
													<td>
														<a class="btn btn-danger btn-xs" href="/delete_lanjut_periode/{{ $data->periode_asal }}/{{ $data->periode_akhir }}" onclick="event.preventDefault(); document.getElementById('delete-lanjut-periode').submit();"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span> Tutup</a>
														<form id="delete-lanjut-periode" action="/delete_lanjut_periode/{{ $data->periode_asal }}/{{ $data->periode_akhir }}" method="POST" style="display: none;">
				                                    	{{ csrf_field() }}
				                                		</form>
			                                		</td>
												</tr>
												@endforeach
											@endif
										</tbody>
									</table>
								</div>
								<a class="btn btn-primary" href="/form_lanjut_periode">
		                            <span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Create New
		                        </a>
							</div>
                		</div>
                	</div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

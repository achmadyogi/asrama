@extends('layouts.app')

@section('styling')

<style>
.yadcf-filter-wrapper {
	width: 100%; height: 100%;
}

.yadcf-filter {
	display: inline-block;
	width: 90%;
	padding: 0;
}

.yadcf-filter-reset-button {
	display: inline-block;
	width: 10%; height: auto;
	padding: 4px;
}
</style>

@endsection

@section('content')

<div class="container">
	<div class="panel panel-default">
		<div class="panel-heading">
			<h2>Alokasi Kamar Non Reguler</h2>
		</div>

		@if(session('message'))
			<div class="alert alert-danger">{{ Session::get('message') }}</div>
		@endif

		<div class="panel-body">
			<div class="col-md-12">
				<ul class="nav nav-tabs">
					<li class="active"><a data-toggle="tab" href="#belum_dialokasi">Belum dialokasi</a></li>
					<li><a data-toggle="tab" href="#sudah_dialokasi">Sudah dialokasi</a></li>
				</ul>
				<br>				
				<div class="tab-content">
					<br>
					<div id="belum_dialokasi" class="tab-pane fade in active">
						<div class="row">
							<div class="col-md-5 col-md-offset-1" id="select_asrama"></div>
							<div class="col-md-5" id="select_periode"></div>
						</div>
						<br><br>

						<table class="table table-striped" id="thegrid">
						  <thead>
							<tr>
													<th>No</th>
													<th>Id_user</th>
													<th>Nama</th>
													<th>Nomor Identitas</th>
													<th>Jenis Identitas</th>
													<th>Jenis Kelamin</th>
													<th>Asrama</th>
													<th>Tanggal Masuk</th>
													<th>Tanggal Keluar</th>
													<th>Kamar</th>
													<th style="width:50px"></th>
							</tr>
						  </thead>
						  <tbody>
						  </tbody>
						</table>
					</div>
		
					<div id="sudah_dialokasi" class="tab-pane fade">
						<div class="row">
							<div class="col-md-5 col-md-offset-1" id="select_asrama2"></div>
						</div>
						<br><br>

						<table class="table table-striped" id="thegrid2">
						  <thead>
							<tr>
													<th>No</th>
													<th>Id_user</th>
													<th>Nama</th>
													<th>Nomor Identitas</th>
													<th>Jenis Identitas</th>
													<th>Jenis Kelamin</th>
													<th>Asrama</th>
													<th>Tanggal Masuk</th>
													<th>Tanggal Keluar</th>
													<th>Kamar</th>
													<th style="width:50px"></th>
							</tr>
						  </thead>
						  <tbody>
						  </tbody>
						</table>
					</div>		
				</div>	
			</div>
		</div>
	</div>
</div>



@endsection



@section('scripts')
    <script type="text/javascript">
        var theGrid = null;
        $(document).ready(function(){
            theGrid = $('#thegrid').DataTable({
                "processing": true,
                "serverSide": true,
                "ordering": false, // kalo true perlu tambahan coding di serverside (controller)
                "orderable": true,
				"responsive": true,
                "ajax": "{{url('alokasinonreguler/grid')}}",
                "columnDefs": [
					{
						"orderable": false, 
						"targets": [0, 1, 2, 3, 4, 5, 6, 7, 8, 9 ,10]
					},
					{
						"searchable": false,
						"orderable": false,
						"targets": 0
					},
		            {
						"targets": [1],
						"visible": false
					},				
					{
                        "render": function ( data, type, row ) {
							var str = data;
							if (data == null) str = "Belum dialokasi";
                            return str;
                        },
                        "targets": 9
					},
                    {
                        "render": function ( data, type, row ) {
                            return '<a href="{{ url('/alokasinonreguler') }}/'+row[0]+'/edit" class="btn btn-primary">Atur Kamar</a>';
                        },
                        "targets": 10
					},
                ],
				"order": [[ 1, 'asc' ]]		
            });
			theGrid.on( 'order.dt search.dt', function () {
				theGrid.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
					cell.innerHTML = i+1;
				} );
			} ).draw();
			
			yadcf.init(theGrid, [
				{column_number : 6, filter_container_id: "select_asrama", filter_default_label: "Pilih Asrama",
				style_class: "form-control", reset_button_style_class: "btn btn-danger"}]);		
        });
        function doDelete(id) {
            if(confirm('You really want to delete this record?')) {
               $.ajax({ url: '{{ url('/alokasinonreguler') }}/' + id, type: 'DELETE'}).success(function() {
                theGrid.ajax.reload();
               });
            }
            return false;
        }
    </script>
	
    <script type="text/javascript">
        var theGrid = null;
        $(document).ready(function(){
            theGrid = $('#thegrid2').DataTable({
                "processing": true,
                "serverSide": true,
                "ordering": false, // kalo true perlu tambahan coding di serverside (controller)
                "orderable": true,
				"responsive": true,
                "ajax": "{{url('alokasinonreguler/grid2')}}",
                "columnDefs": [
					{
						"orderable": false, 
						"targets": [0, 1, 2, 3, 4, 5, 6, 7, 8, 9 ,10]
					},
					{
						"searchable": false,
						"orderable": false,
						"targets": 0
					},
		            {
						"targets": [1],
						"visible": false
					},				
					{
                        "render": function ( data, type, row ) {
							var str = data;
							if (data == null) str = "Belum dialokasi";
                            return str;
                        },
                        "targets": 9
					},
                    {
                        "render": function ( data, type, row ) {
                            return '<a href="{{ url('/alokasinonreguler') }}/'+row[0]+'/edit" class="btn btn-primary">Atur Kamar</a>';
                        },
                        "targets": 10
					},
                ],
				"order": [[ 1, 'asc' ]]		
            });
			theGrid.on( 'order.dt search.dt', function () {
				theGrid.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
					cell.innerHTML = i+1;
				} );
			} ).draw();
			
			yadcf.init(theGrid, [
				{column_number : 6, filter_container_id: "select_asrama2", filter_default_label: "Pilih Asrama",
				style_class: "form-control", reset_button_style_class: "btn btn-danger"}]);		
        });
        function doDelete(id) {
            if(confirm('You really want to delete this record?')) {
               $.ajax({ url: '{{ url('/alokasinonreguler') }}/' + id, type: 'DELETE'}).success(function() {
                theGrid.ajax.reload();
               });
            }
            return false;
        }
    </script>	
@endsection
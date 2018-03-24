@extends('layouts.app')

@section('content')

<div class="container">
	<div class="panel panel-default">
		<div class="panel-heading">
			<h2>Laporan Kerusakan Kamar</h2>
		</div>

		<div class="panel-body">
			<div class="">
				<table class="table table-striped" id="thegrid">
				  <thead>
					<tr>
											<th>No</th>
											<th>Nama Kamar</th>
											<th>Keterangan</th>
											<th>Tanggal Laporan</th>
											<th>Status</th>
											<th style="width:50px"></th>
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




@endsection



@section('scripts')
    <script type="text/javascript">
        var theGrid = null;
        $(document).ready(function(){
            theGrid = $('#thegrid').DataTable({
                "processing": true,
                "serverSide": true,
                "ordering": true,
                "responsive": true,
                "ajax": "{{url('kerusakan_kamar/grid')}}",
                "columnDefs": [
					{
						"searchable": false,
						"orderable": false,
						"targets": 0
					},				
                    {
                        "render": function ( data, type, row ) {
                            return data;
                        },
                        "targets": 1
                    },
					{
                        "render": function ( data, type, row ) {
                            return '<a href="{{ url('/kerusakan_kamar') }}/'+row[0]+'/edit" class="btn btn-primary">Update</a>';
                        },
                        "targets": 5
					},
                    {
                        "render": function ( data, type, row ) {
                            return '<a href="#" onclick="return doDelete('+row[0]+')" class="btn btn-danger">Delete</a>';
                        },
                        "targets": 6
                    },
                ],
				"order": [[ 1, 'asc' ]]	
            });
			theGrid.on( 'order.dt search.dt', function () {
				theGrid.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
					cell.innerHTML = i+1;
				} );
			} ).draw();
        });
        function doDelete(id) {
            if(confirm('You really want to delete this record?')) {
               $.ajax({ url: '{{ url('/kerusakan_kamar') }}/' + id, type: 'DELETE'}).success(function() {
                theGrid.ajax.reload();
               });
            }
            return false;
        }
    </script>
@endsection
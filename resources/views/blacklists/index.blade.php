@extends('layouts.app')

@section('content')

<div class="container">
	<div class="panel panel-default">
		<div class="panel-heading">
			<h2>Daftar Blacklists</h2>
		</div>

		<div class="panel-body">
			<div class="">
				<table class="table table-striped" id="thegrid">
				  <thead>
					<tr>
						<th style="width: 10%">ID User</th>
						<th style="width: 20%">Nama</th>
						<th style="width: 15%">Email</th>
						<th style="width: 15%">Username</th>
						<th style="width: 30%">Alasan</th>
						<th style="width: 5%"></th>
						<th style="width: 5%"></th>
					</tr>
				  </thead>
				  <tbody>
				  </tbody>
				</table>
			</div>
			<a href="{{url('users')}}" class="btn btn-primary" role="button">Back to users</a>
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
                "ajax": "{{url('blacklists/grid')}}",
                "columnDefs": [
					{
						"orderable": false, 
						"targets": [0, 1, 2, 3, 4, 5, 6]
					},				
                    {
                        "render": function ( data, type, row ) {
                            return data;
                        },
                        "targets": 0
                    },
                    {
                        "render": function ( data, type, row ) {
                            return '<a href="{{ url('/blacklists') }}/'+row[0]+'/edit" class="btn btn-primary" title="Update">'+
                            '<span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></a>';
                        },
                        "targets": 5                    },
                    {
                        "render": function ( data, type, row ) {
                            return '<a href="#" onclick="return doDelete('+row[0]+')" class="btn btn-danger" title="Remove">' +
                            '<span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a>';
                        },
                        "targets": 5+1
                    },
                ]
            });
        });
        function doDelete(id) {
            if(confirm('You really want to delete this record?')) {
               $.ajax({ url: '{{ url('/blacklists') }}/' + id, type: 'DELETE'}).success(function() {
                theGrid.ajax.reload();
               });
            }
            return false;
        }
    </script>
@endsection
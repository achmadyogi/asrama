@extends('layouts.app')

@section('content')


<div class="container">
	<div class="panel panel-default">
		<div class="panel-heading">
			<h2>Manajemen Users</h2>
		</div>

		<div class="panel-body">
			<div class="">
				<table class="table table-striped" id="thegrid">
				  <thead>
					<tr>
											<th style="width:3%">Id</th>
											<th style="width:18%">Nama</th>
											<th style="width:20%">Email</th>
											<th style="width:10%">Created At</th>
											<th style="width:10%">Updated At</th>
											<th style="width:10%">Username</th>
											<th style="width:5%"></th>
                    						<th style="width:5%"></th>
                    						<th style="width:5%"></th>
					</tr>
				  </thead>
				  <tbody>
				  </tbody>
				</table>
			</div>
			<a href="{{url('users/create')}}" class="btn btn-primary" role="button">New User</a>
			<a href="{{url('blacklists')}}" class="btn btn-danger" role="button">Manage Blacklists</a>
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
                "ajax": "{{url('users/grid')}}",
                "columnDefs": [
					{
						"orderable": false, 
						"targets": [0, 1, 2, 3, 4, 5, 6, 7, 8]
					},
                    {
                        "render": function ( data, type, row ) {
                            return data;
                        },
                        "targets": 0
                    },
                    {
                        "render": function ( data, type, row ) {
							var arrayBlacklist = <?php echo json_encode($blacklist); ?>;
							var indexUserBlacklist = [];

							// simpan indeks user yang terblacklist
							$.each(arrayBlacklist, function(index, val) {
								indexUserBlacklist.push(val['id_user']);
							});

							if($.inArray(row[0], indexUserBlacklist) > -1) {
								return '<a href="#" onclick="return doRemoveBlacklist('+row[0]+')" class="btn btn-success btn-md" title="Remove from Blacklist"><span class="glyphicon glyphicon-repeat" aria-hidden="true"></span></a>';
							} else {
								return '<a href="{{ url('/blacklists') }}/'+row[0]+'/add" class="btn btn-warning btn-md" title="Add to Blacklist">🛇</a>';
							}
                        },
                        "targets": 6                   },
                    {
                        "render": function ( data, type, row ) {
							return '<a href="{{ url('/users') }}/'+row[0]+'/edit" class="btn btn-primary btn-md" title="Update"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></a>';
                        },
                        "targets": 6+1
                    },
					{
                        "render": function ( data, type, row ) {
                            return '<a href="#" onclick="return doDelete('+row[0]+')" class="btn btn-danger btn-md" title="Remove"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a>';
                        },
                        "targets": 6+2
                    },
                ]
            });
        });
        function doDelete(id) {
            if(confirm('You really want to delete this record?')) {
               $.ajax({ url: '{{ url('/users') }}/' + id, type: 'DELETE'}).success(function() {
                theGrid.ajax.reload();
               });
            }
            return false;
        }

		function doRemoveBlacklist(id) {
            if(confirm('You really want to remove this user from blacklist?')) {
               $.ajax({ url: '{{ url('/blacklists') }}/' + id, type: 'DELETE'}).success(function() {
                location.reload();
               });
            }
            return false;
		}
    </script>
@endsection

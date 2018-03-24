@extends('layouts.app')

@section('content')



<div class="container">
    <div class="panel panel-default">
            <div class="panel-heading">
                <h2>Manajemen Periode Reguler</h2>
            </div>

            <div class="panel-body">
                    <table class="table table-striped" id="thegrid">
                      <thead>
                        <tr>
                                                <th style="width: 5%;">Id</th>
                                                <th style="width: 30%;">Nama Periode</th>
                                                <th style="width: 15%;">Tanggal Awal</th>
                                                <th style="width: 15%;">Tanggal Akhir</th>
                                                <th style="width: 10%;">Status</th>
                                                <th style="width: 5%"></th>
                                                <th style="width: 5%"></th>
                        </tr>
                      </thead>
                      <tbody>
                      </tbody>
                    </table>
                <a href="{{url('periodes/create')}}" class="btn btn-primary" role="button">New Periode</a>
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
                "ajax": "{{url('periodes/grid')}}",
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
                            return '<a href="{{ url('/periodes') }}/'+row[0]+'/edit" class="btn btn-primary" title="Update">' +
                             '<span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></a>';
                        },
                        "targets": 5                    },
                    {
                        "render": function ( data, type, row ) {
                            return '<a href="#" onclick="return doDelete('+row[0]+')" class="btn btn-danger" title="Delete">' + 
                            '<span class="glyphicon glyphicon-trash" aria-hidden="true"></span> </a>';
                        },
                        "targets": 5+1
                    },
                ]
            });
        });
        function doDelete(id) {
            if(confirm('You really want to delete this record?')) {
               $.ajax({ url: '{{ url('/periodes') }}/' + id, type: 'DELETE'}).success(function() {
                theGrid.ajax.reload();
               });
            }
            return false;
        }
    </script>
@endsection
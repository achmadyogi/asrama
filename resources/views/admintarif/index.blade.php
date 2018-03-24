@extends('layouts.app')

@section('content')

<div class="container">
  <div class="panel panel-default">
      <div class="panel-heading">
          <h2>Managemen Tarif Asrama</h2>
      </div>

      <div class="panel-body">
          <div class="">
              <table class="table table-striped" id="thegrid">
                <thead>
                  <tr>
                      <th style="width: 5%; text-align: center;">Jenis Penyewaan</th>
                      <th style="width: 15%; text-align: center;">Asrama</th>
                      <th style="width: 10%; text-align: center;">Nilai Tarif TPB BM</th>
                      <th style="width: 10%; text-align: center;">Nilai Tarif TPB NBM</th>
                      <th style="width: 10%; text-align: center;">Nilai Tarif PS</th>
                      <th style="width: 10%; text-align: center;">Nilai Tarif IT</th>
                      <th style="width: 10%; text-align: center;">Nilai Tarif NON</th>
                      <th style="width: 5%;"></th>
                      <th style="width: 5%;"></th>
                  </tr>
                </thead>
                <tbody>
                </tbody>
              </table>
          </div>
          <a href="{{url('admintarif/create')}}" class="btn btn-primary" role="button">New Tarif</a>
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
                "ajax": "{{url('admintarif/grid')}}",
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
                            return '<a href="{{ url('/admintarif') }}/'+row[7]+'/edit" class="btn btn-primary" title="Update">' +
                            '<span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></a>';
                        },
                        "targets": 7                    },
                    {
                        "render": function ( data, type, row ) {
                            return '<a href="#" onclick="return doDelete('+row[7]+')" class="btn btn-danger"  title="Delete">' +
                            '<span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a>';
                        },
                        "targets": 7+1
                    },
                ]
            });
        });
        function doDelete(id) {
            if(confirm('You really want to delete this record?')) {
               $.ajax({ url: '{{ url('/admintarif') }}/' + id, type: 'DELETE'}).success(function() {
                theGrid.ajax.reload();
               });
            }
            return false;
        }
    </script>
@endsection

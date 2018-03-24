@extends('layouts.app')

@section('content')

<div class="container">
  <div class="panel panel-default">
      <div class="panel-heading">
          @if (Auth::user() and (Auth::user()->is_admin == '1' or Auth::user()->is_sekretariat == '1'))
          <h2>Manage Berita</h2>
          @else
          <h2>Archived Berita</h2>
          @endif
      </div>

      <div class="panel-body">
          <div class="">
              <table class="table table-striped" id="thegrid">
                <thead>
                  <tr>
                      <th style="width: 20%">Title</th>
                      <th style="width: 40%">Isi</th>
                      <th style="width: 15%">Created At</th>
                      <th style="width: 15%">Updated At</th>
                      <th style="width: 5%"></th>
                      <th style="width: 5%"></th>
                  </tr>
                </thead>
                <tbody>
                </tbody>
              </table>
          </div>
          @if (Auth::user() and (Auth::user()->is_admin == '1' or Auth::user()->is_sekretariat == '1'))
          <a href="{{url('adminberita/create')}}" class="btn btn-primary" role="button">New Berita</a>
          @endif
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
                "ajax": "{{url('adminberita/grid')}}",
                "columnDefs": [
					{
						"orderable": false,
						"targets": [0, 1, 2, 3, 4, 5]
					},
          {
            "targets": [4],
            @if (Auth::user() and (Auth::user()->is_admin == '1' or Auth::user()->is_sekretariat == '1'))
						"visible": true
            @else
            "visible": false
            @endif
          },
          {
            "targets": [5],
            @if (Auth::user() and (Auth::user()->is_admin == '1' or Auth::user()->is_sekretariat == '1'))
            "visible": true
            @else
            "visible": false
            @endif
          },
                    {
                        "render": function ( data, type, row ) {
                            return data;
                        },
                        "targets": 0
                    },
                    {
                        "render": function ( data, type, row ) {
                            return '<a href="{{ url('/adminberita') }}/'+row[4]+'/edit" class="btn btn-default">Update</a>';
                        },
                        "targets": 4                    },
                    {
                        "render": function ( data, type, row ) {
                            return '<a href="#" onclick="return doDelete('+row[4]+')" class="btn btn-danger">Delete</a>';
                        },
                        "targets": 4+1
                    },
                ]
            });
        });
        function doDelete(id) {
            if(confirm('You really want to delete this record?')) {
               $.ajax({ url: '{{ url('/adminberita') }}/' + id, type: 'DELETE'}).success(function() {
                theGrid.ajax.reload();
               });
            }
            return false;
        }
    </script>
@endsection

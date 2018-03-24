@extends('layouts.app')

@section('content')


<div class="container">
  <h2 class="page-header">Berita</h2>

  <div class="panel panel-default">
      <div class="panel-heading">
          View Berita    </div>

      <div class="panel-body">


          <form action="{{ url('/adminberita') }}" method="POST" class="form-horizontal">



          <div class="form-group">
              <label for="id_berita" class="col-sm-3 control-label">Id Berita</label>
              <div class="col-sm-6">
                  <input type="text" name="id_berita" id="id_berita" class="form-control" value="{{$model['id_berita'] or ''}}" readonly="readonly">
              </div>
          </div>


          <div class="form-group">
              <label for="id_penulis" class="col-sm-3 control-label">Id Penulis</label>
              <div class="col-sm-6">
                  <input type="text" name="id_penulis" id="id_penulis" class="form-control" value="{{$model['id_penulis'] or ''}}" readonly="readonly">
              </div>
          </div>


          <div class="form-group">
              <label for="title" class="col-sm-3 control-label">Title</label>
              <div class="col-sm-6">
                  <input type="text" name="title" id="title" class="form-control" value="{{$model['title'] or ''}}" readonly="readonly">
              </div>
          </div>


          <div class="form-group">
              <label for="isi" class="col-sm-3 control-label">Isi</label>
              <div class="col-sm-6">
                  <input type="text" name="isi" id="isi" class="form-control" value="{{$model['isi'] or ''}}" readonly="readonly">
              </div>
          </div>


          <div class="form-group">
              <label for="created_at" class="col-sm-3 control-label">Created At</label>
              <div class="col-sm-6">
                  <input type="text" name="created_at" id="created_at" class="form-control" value="{{$model['created_at'] or ''}}" readonly="readonly">
              </div>
          </div>


          <div class="form-group">
              <label for="updated_at" class="col-sm-3 control-label">Updated At</label>
              <div class="col-sm-6">
                  <input type="text" name="updated_at" id="updated_at" class="form-control" value="{{$model['updated_at'] or ''}}" readonly="readonly">
              </div>
          </div>


          <div class="form-group">
              <div class="col-sm-offset-3 col-sm-6">
                  <a class="btn btn-default" href="{{ url('/adminberita') }}"><i class="glyphicon glyphicon-chevron-left"></i> Back</a>
              </div>
          </div>


          </form>

      </div>
  </div>
</div>






@endsection

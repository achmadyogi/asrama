@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading"><h2>New Asrama</h2></div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{ url('/create_asrama') }}" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label for="nama" class="col-md-3 control-label">Nama</label>
                            <div class="col-md-8">
                                <input id="nama" type="text" class="form-control" name="nama" required autofocus>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="deskripsi" class="col-md-3 control-label">Deskripsi</label>
                            <div class="col-md-8">
                                <textarea id="deskripsi" type="text" class="form-control" name="deskripsi" required autofocus rows="6" style="resize:none"></textarea>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="alamat" class="col-md-3 control-label">Alamat</label>
                            <div class="col-md-8">
                                <input id="alamat" type="text" class="form-control" name="alamat" required autofocus>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="img" class="col-md-3 control-label">Select an image</label>
                            <div class="col-md-8">
                                <input id="img" type="file" class="form-control" name="img" style="height: 100%;" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-8 col-md-offset-3">
                                <a class="btn btn-default" href="{{ url('/asrama') }}"><i class="glyphicon glyphicon-chevron-left"></i> Back</a>
                                <button type="submit" class="btn btn-success">
                                    <i class="glyphicon glyphicon-ok"></i> Create
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
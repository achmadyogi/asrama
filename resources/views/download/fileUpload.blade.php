@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading"><h2>Upload New File</h2></div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{ url('/upload') }}" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label for="nama" class="col-md-3 control-label">Nama File</label>
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
                            <label for="img" class="col-md-3 control-label">Select the File</label>
                            <div class="col-md-8">
                                <input id="datafile" type="file" class="form-control" name="datafile" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-8 col-md-offset-3">
                                <a class="btn btn-default" href="{{ url('/dashboard') }}"><i class="glyphicon glyphicon-chevron-left"></i> Back</a>
                                <button type="submit" class="btn btn-success">
                                    Upload
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

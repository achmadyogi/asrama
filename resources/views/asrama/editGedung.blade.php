@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading"><h2>Edit Gedung</h2></div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="/asrama/{{ $id_asrama }}/edit_gedung/{{ $gedung->id_gedung }}" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label for="nama" class="col-md-4 control-label">Nama Gedung</label>
                            <div class="col-md-6">
                                <input id="nama" type="text" class="form-control" name="nama" required autofocus value="{{ $gedung->nama }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-12">
                                <a class="btn btn-default" href="/asrama/{{ $id_asrama }}"><i class="glyphicon glyphicon-chevron-left"></i> Back</a>
                                <div class="col-md-5"></div>
                                <button type="submit" class="btn btn-success">
                                    <i class="glyphicon glyphicon-floppy-disk"></i> Save
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
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="col-md-10 col-md-offset-1">
    <div class="panel panel-default">
        <div class="panel-heading"><h2>Permohonan Pindah Kamar</h2></div>
        <div class="panel-body">
            <form class="form-horizontal" role="form" method="POST" action="/requestpindah/{{$jenis_kepenghunian}}/{{$id_pendaftaran}}">
                {{csrf_field() }}


                <div class="form-group">
                    <label for="alasan" class="col-md-3 col-md-offset-1 control-label">Alasan Pindah</label>
                    <div class="col-md-6">
                        <textarea id="alasan" class="form-control" name="alasan" style="resize: none; height: 144px;" required></textarea>
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-md-7 col-md-offset-4">
                        <a class="btn btn-default" href="{{ url('/dashboard') }}"><i class="glyphicon glyphicon-chevron-left"></i> Back</a>
                        <button type="submit" class="btn btn-success">
                            <i class="glyphicon glyphicon-ok"></i> Submit
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    </div>
</div>
@endsection


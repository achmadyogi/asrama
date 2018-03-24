@extends('layouts.app')

@section('content')
<div class="container">
    <div class="col-md-10 col-md-offset-1">
    <div class="panel panel-default">
        <div class="panel-heading"><h2>Permohonan Keluar Asrama</h2></div>
        <div class="panel-body">
            <form class="form-horizontal" role="form" method="POST" action="/requestkeluar/{{$jenis_kepenghunian}}/{{$id_pendaftaran}}">
                {{csrf_field() }}
                <div class="form-group">
                    <label for="tanggalkeluar" class="col-md-3 col-md-offset-1 control-label">Tanggal Keluar yang Diajukan</label>
                    <div class="col-md-6">
                        <input id="tanggal_keluar" type="date" class="form-control" name="tanggal_keluar"
                        placeholder="YYYY-MM-DD"
                        required>
                    </div>
                </div>

                <div class="form-group">
                    <label for="alasan" class="col-md-3 col-md-offset-1 control-label">Alasan Keluar</label>
                    <div class="col-md-6">
                        <textarea id="alasan" class="form-control" name="alasan" style="resize: none; height: 144px;" required></textarea>
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-md-12 col-md-offset-4">
                        <a class="btn btn-default" href="{{ url('/dashboard') }}"><i class="glyphicon glyphicon-chevron-left"></i> Back</a>
                        <button type="submit" class="btn btn-success"><i class="glyphicon glyphicon-ok"></i>
                             Submit
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    </div>
</div>
@endsection


@extends('layouts.app')

@section('content')



<h2 class="page-header">Periode</h2>

<div class="panel panel-default">
    <div class="panel-heading">
        View Periode    </div>

    <div class="panel-body">
                

        <form action="{{ url('/periodes') }}" method="POST" class="form-horizontal">


                
        <div class="form-group">
            <label for="id_periode" class="col-sm-3 control-label">Id Periode</label>
            <div class="col-sm-6">
                <input type="text" name="id_periode" id="id_periode" class="form-control" value="{{$model['id_periode'] or ''}}" readonly="readonly">
            </div>
        </div>
        
                
        <div class="form-group">
            <label for="tanggal_awal" class="col-sm-3 control-label">Tanggal Awal</label>
            <div class="col-sm-6">
                <input type="text" name="tanggal_awal" id="tanggal_awal" class="form-control" value="{{$model['tanggal_awal'] or ''}}" readonly="readonly">
            </div>
        </div>
        
                
        <div class="form-group">
            <label for="tanggal_akhir" class="col-sm-3 control-label">Tanggal Akhir</label>
            <div class="col-sm-6">
                <input type="text" name="tanggal_akhir" id="tanggal_akhir" class="form-control" value="{{$model['tanggal_akhir'] or ''}}" readonly="readonly">
            </div>
        </div>
        
                
        <div class="form-group">
            <label for="status" class="col-sm-3 control-label">Status</label>
            <div class="col-sm-6">
                <input type="text" name="status" id="status" class="form-control" value="{{$model['status'] or ''}}" readonly="readonly">
            </div>
        </div>
        
        
        <div class="form-group">
            <div class="col-sm-offset-3 col-sm-6">
                <a class="btn btn-default" href="{{ url('/periodes') }}"><i class="glyphicon glyphicon-chevron-left"></i> Back</a>
            </div>
        </div>


        </form>

    </div>
</div>







@endsection
@extends('layouts.app')

@section('content')



<h2 class="page-header">Permohonan_pindah</h2>

<div class="panel panel-default">
    <div class="panel-heading">
        View Permohonan_pindah    </div>

    <div class="panel-body">
                

        <form action="{{ url('/permohonan_pindahs') }}" method="POST" class="form-horizontal">


                
        <div class="form-group">
            <label for="id_permohonan" class="col-sm-3 control-label">Id Permohonan</label>
            <div class="col-sm-6">
                <input type="text" name="id_permohonan" id="id_permohonan" class="form-control" value="{{$model['id_permohonan'] or ''}}" readonly="readonly">
            </div>
        </div>
        
                
        <div class="form-group">
            <label for="id_user" class="col-sm-3 control-label">Id User</label>
            <div class="col-sm-6">
                <input type="text" name="id_user" id="id_user" class="form-control" value="{{$model['id_user'] or ''}}" readonly="readonly">
            </div>
        </div>
        
                
        <div class="form-group">
            <label for="id_kamar_lama" class="col-sm-3 control-label">Id Kamar Lama</label>
            <div class="col-sm-6">
                <input type="text" name="id_kamar_lama" id="id_kamar_lama" class="form-control" value="{{$model['id_kamar_lama'] or ''}}" readonly="readonly">
            </div>
        </div>
        
                
        <div class="form-group">
            <label for="id_kamar_baru" class="col-sm-3 control-label">Id Kamar Baru</label>
            <div class="col-sm-6">
                <input type="text" name="id_kamar_baru" id="id_kamar_baru" class="form-control" value="{{$model['id_kamar_baru'] or ''}}" readonly="readonly">
            </div>
        </div>
        
                
        <div class="form-group">
            <label for="alasan" class="col-sm-3 control-label">Alasan</label>
            <div class="col-sm-6">
                <input type="text" name="alasan" id="alasan" class="form-control" value="{{$model['alasan'] or ''}}" readonly="readonly">
            </div>
        </div>
        
                
        <div class="form-group">
            <label for="tanggal_mulai_pindah" class="col-sm-3 control-label">Tanggal Mulai Pindah</label>
            <div class="col-sm-6">
                <input type="text" name="tanggal_mulai_pindah" id="tanggal_mulai_pindah" class="form-control" value="{{$model['tanggal_mulai_pindah'] or ''}}" readonly="readonly">
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
                <a class="btn btn-default" href="{{ url('/permohonan_pindahs') }}"><i class="glyphicon glyphicon-chevron-left"></i> Back</a>
            </div>
        </div>


        </form>

    </div>
</div>







@endsection
@extends('layouts.app')

@section('content')


<h2 class="page-header">Permohonan Pindah</h2>

<div class="panel panel-default">
    <div class="panel-heading">
        Add/Modify Permohonan Pindah    </div>

    <div class="panel-body">
                
        <form action="{{ url('/permohonan_pindahs'.( isset($model) ? "/" . $model->id : "")) }}" method="POST" class="form-horizontal">
            {{ csrf_field() }}

            @if (isset($model))
                <input type="hidden" name="_method" value="PATCH">
            @endif


                                                            <div class="form-group">
                <label for="id_permohonan" class="col-sm-3 control-label">Id Permohonan</label>
                <div class="col-sm-2">
                    <input type="number" name="id_permohonan" id="id_permohonan" class="form-control" value="{{$model['id_permohonan'] or ''}}" readonly="readonly">
                </div>
            </div>
                                                                                                <div class="form-group">
                <label for="id_user" class="col-sm-3 control-label">Id User</label>
                <div class="col-sm-2">
                    <input type="number" name="id_user" id="id_user" class="form-control" value="{{$model['id_user'] or ''}}" readonly="readonly">
                </div>
            </div>
                                                                                                <div class="form-group">
                <label for="id_kamar_lama" class="col-sm-3 control-label">Id Kamar Lama</label>
                <div class="col-sm-2">
                    <input type="number" name="id_kamar_lama" id="id_kamar_lama" class="form-control" value="{{$model['id_kamar_lama'] or ''}}">
                </div>
            </div>
                                                                                               
                                                                                    <div class="form-group">
                <label for="alasan" class="col-sm-3 control-label">Alasan</label>
                <div class="col-sm-6">
                    <input type="text" name="alasan" id="alasan" class="form-control" value="{{$model['alasan'] or ''}}">
                </div>
            </div>
                        
            <div class="form-group">
                <div class="col-sm-offset-3 col-sm-6">
                    <a class="btn btn-default" href="{{ url('/permohonan_pindahs') }}"><i class="glyphicon glyphicon-chevron-left"></i> Back</a>
                    <button type="submit" class="btn btn-success">
                        <i class="fa fa-plus"></i> Save
                    </button> 
                </div>
            </div>
        </form>

    </div>
</div>






@endsection
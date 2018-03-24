@extends('layouts.app')

@section('content')

<div class="container">
    <div class="panel panel-default">
        <div class="panel-heading">
            @if (isset($model))
                <h2>Modify Periode</h2>
            @else
                <h2>New Periode</h2>
            @endif
        </div>

        <div class="panel-body">
                    
            <form action="{{ url('/periodes'.( isset($model) ? "/" . $model->id : "")) }}" method="POST" class="form-horizontal">
                {{ csrf_field() }}

                @if (isset($model))
                    <input type="hidden" name="_method" value="PATCH">
                @endif


                <div class="form-group" hidden>
                    <label for="id_periode" class="col-sm-3 control-label">Id Periode</label>
                    <div class="col-sm-6" hidden>
                        <input type="number" name="id_periode" id="id_periode" class="form-control" value="{{$model['id_periode'] or ''}}" readonly="readonly">
                    </div>
                </div>

                <div class="form-group">
                    <label for="nama" class="col-sm-3 control-label">Nama Periode</label>
                    <div class="col-sm-6">
                        <input type="text" name="nama" id="nama" class="form-control" value="{{$model['nama'] or ''}}" required>
                    </div>
                </div>

                <div class="form-group">
                    <label for="tanggal_awal" class="col-sm-3 control-label">Tanggal Awal</label>
                    <div class="col-sm-2">
                        <input type="date" name="tanggal_awal" id="tanggal_awal" class="form-control" value="{{$model['tanggal_awal'] or ''}}" required>
                    </div>
                    <label for="tanggal_akhir" class="col-sm-2 control-label">Tanggal Akhir</label>
                    <div class="col-sm-2">
                        <input type="date" name="tanggal_akhir" id="tanggal_akhir" class="form-control" value="{{$model['tanggal_akhir'] or ''}}" required>
                    </div>
                </div>

                <div class="form-group">
                    <label for="status" class="col-sm-3 control-label">Status</label>
                    <div class="col-md-6">
                        <select name="status" class="form-control">
                            <option value="Buka"
                            @if (isset($model) && $model['status'] == 'Buka')
                            selected
                            @endif 
                            >Buka</option>
                            <option value="Tutup"
                            @if (isset($model) && $model['status'] == 'Tutup')
                            selected
                            @endif
                            >Tutup</option>
                            
                        </select>
                    </div>
                </div>
                                                                
                <div class="form-group">
                    <div class="col-sm-offset-3 col-sm-6">
                        <a class="btn btn-default" href="{{ url('/periodes') }}"><i class="glyphicon glyphicon-chevron-left"></i> Back</a>
                        <button type="submit" class="btn btn-success">
                            <span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span> Save
                        </button> 
                        
                    </div>
                </div>
            </form>

        </div>
    </div>
</div>






@endsection
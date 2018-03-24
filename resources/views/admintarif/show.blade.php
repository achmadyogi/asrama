@extends('layouts.app')

@section('content')


<div class="container">
  <h2 class="page-header">Tarif</h2>

  <div class="panel panel-default">
      <div class="panel-heading">
          View Tarif    </div>

      <div class="panel-body">


          <form action="{{ url('/admintarif') }}" method="POST" class="form-horizontal">



          <div class="form-group">
              <label for="jenis_penyewaan" class="col-sm-3 control-label">Jenis Penyewaan</label>
              <div class="col-sm-6">
                  <input type="text" name="jenis_penyewaan" id="jenis_penyewaan" class="form-control" value="{{$model['jenis_penyewaan'] or ''}}" readonly="readonly">
              </div>
          </div>


          <div class="form-group">
              <label for="asrama" class="col-sm-3 control-label">Asrama</label>
              <div class="col-sm-6">
                  <input type="text" name="asrama" id="asrama" class="form-control" value="{{$model['asrama'] or ''}}" readonly="readonly">
              </div>
          </div>


          <div class="form-group">
              <label for="nilai_tarif_TPB_BM" class="col-sm-3 control-label">Nilai Tarif TPB BM</label>
              <div class="col-sm-6">
                  <input type="text" name="nilai_tarif_TPB_BM" id="nilai_tarif_TPB_BM" class="form-control" value="{{$model['nilai_tarif_TPB_BM'] or ''}}" readonly="readonly">
              </div>
          </div>


          <div class="form-group">
              <label for="nilai_tarif_TPB_NBM" class="col-sm-3 control-label">Nilai Tarif TPB NBM</label>
              <div class="col-sm-6">
                  <input type="text" name="nilai_tarif_TPB_NBM" id="nilai_tarif_TPB_NBM" class="form-control" value="{{$model['nilai_tarif_TPB_NBM'] or ''}}" readonly="readonly">
              </div>
          </div>


          <div class="form-group">
              <label for="nilai_tarif_PS" class="col-sm-3 control-label">Nilai Tarif PS</label>
              <div class="col-sm-6">
                  <input type="text" name="nilai_tarif_PS" id="nilai_tarif_PS" class="form-control" value="{{$model['nilai_tarif_PS'] or ''}}" readonly="readonly">
              </div>
          </div>


          <div class="form-group">
              <label for="nilai_tarif_IT" class="col-sm-3 control-label">Nilai Tarif IT</label>
              <div class="col-sm-6">
                  <input type="text" name="nilai_tarif_IT" id="nilai_tarif_IT" class="form-control" value="{{$model['nilai_tarif_IT'] or ''}}" readonly="readonly">
              </div>
          </div>


          <div class="form-group">
              <label for="nilai_tarif_NON" class="col-sm-3 control-label">Nilai Tarif NON</label>
              <div class="col-sm-6">
                  <input type="text" name="nilai_tarif_NON" id="nilai_tarif_NON" class="form-control" value="{{$model['nilai_tarif_NON'] or ''}}" readonly="readonly">
              </div>
          </div>


          <div class="form-group">
              <div class="col-sm-offset-3 col-sm-6">
                  <a class="btn btn-default" href="{{ url('/admintarif') }}"><i class="glyphicon glyphicon-chevron-left"></i> Back</a>
              </div>
          </div>


          </form>

      </div>
  </div>
</div>






@endsection

@extends('layouts.app')

@section('content')

<div class="container">
  <div class="panel panel-default">
      <div class="panel-heading">
      @if (isset($model))
          <h2>Modify Tarif</h2>  
      @else
          <h2>New Tarif</h2>
      @endif
      </div>

      <div class="panel-body">

          <form action="{{ url('/admintarif'.( isset($model) ? "/" . $model->id : "")) }}" method="POST" class="form-horizontal">
              {{ csrf_field() }}

              @if (isset($model))
                  <input type="hidden" name="_method" value="PUT">
              @endif
              <div class="form-group">
                  <div class="col-sm-6">
                      <input type="hidden" name="id" id="id" class="form-control" value="{{$model['id_tarif'] or ''}}" readonly="readonly">
                  </div>
              </div>

              <div class="form-group">
                  <label for="jenis_penyewaan" class="col-sm-3 control-label">Jenis Penyewaan</label>
                  <div class="col-sm-8">
                    <select name="jenis_penyewaan" id="jenis_penyewaan" class="form-control" value="{{$model['jenis_penyewaan'] or ''}}">
                      @if($model['jenis_penyewaan'] == 'Reguler')
                        <option value="Reguler" selected="selected">Reguler</option>
                        <option value="Harian">Harian</option>
                      @else
                        <option value="Reguler">Reguler</option>
                        <option value="Harian" selected="selected">Harian</option>
                      @endif
                    </select>
                      <!--<input type="text" name="jenis_penyewaan" id="jenis_penyewaan" class="form-control" value="{{$model['jenis_penyewaan'] or ''}}">-->
                  </div>
              </div>
              <div class="form-group">
                  <label for="asrama" class="col-sm-3 control-label">Asrama</label>
                  <div class="col-sm-8">
                      <select name="asrama" id="asrama" class="form-control" value="{{$model['asrama'] or ''}}">
                        @foreach($dataAsrama as $item)
                          @if($model['asrama'] == $item->nama)
                            <option value="{{$item->nama}}" selected="selected">{{$item->nama}}</option>
                          @else
                            <option value="{{$item->nama}}">{{$item->nama}}</option>
                          @endif
                        @endforeach
                      </select>
                      <!--<input type="text" name="asrama" id="asrama" class="form-control" value="{{$model['asrama'] or ''}}">-->
                  </div>
              </div>

              <div class="form-group">
                  <h3 class="col-sm-offset-1">Tarif Umum Mahasiswa ITB</h3>
                  <label for="nilai_tarif_TPB_BM" class="col-sm-3 control-label">Bidikmisi</label>
                  <div class="col-sm-3">
                      <input type="number" name="nilai_tarif_TPB_BM" pattern="^\d+" id="nilai_tarif_TPB_BM" class="form-control" value="{{$model['nilai_tarif_TPB_BM'] or ''}}">
                  </div>
                  <label for="nilai_tarif_TPB_NBM" class="col-sm-2 control-label">Non Bidikmisi</label>
                  <div class="col-sm-3">
                      <input type="number" name="nilai_tarif_TPB_NBM" pattern="^\d+" id="nilai_tarif_TPB_NBM" class="form-control" value="{{$model['nilai_tarif_TPB_NBM'] or ''}}">
                  </div>
              </div>

              <div class="form-group">
                  <h3 class="col-sm-offset-1">Tarif Khusus Mahasiswa ITB</h3>
                  <label for="nilai_tarif_PS" class="col-sm-3 control-label">Mhs Pascasarjana</label>
                  <div class="col-sm-3">
                      <input type="number" name="nilai_tarif_PS" pattern="^\d+" id="nilai_tarif_PS" class="form-control" value="{{$model['nilai_tarif_PS'] or ''}}">
                  </div>
                  <label for="nilai_tarif_IT" class="col-sm-2 control-label">Mhs Internasional</label>
                  <div class="col-sm-3">
                      <input type="number" name="nilai_tarif_IT" pattern="^\d+" id="nilai_tarif_IT" class="form-control" value="{{$model['nilai_tarif_IT'] or ''}}">
                  </div>
              </div>

              <div class="form-group">
                  <h3 class="col-sm-offset-1">Lain-Lain</h3>
                  <label for="nilai_tarif_NON" class="col-sm-3 control-label">Non Civitas Akademik</label>
                  <div class="col-sm-3">
                      <input type="number" name="nilai_tarif_NON" pattern="^\d+" id="nilai_tarif_NON" class="form-control" value="{{$model['nilai_tarif_NON'] or ''}}">
                  </div>
              </div>
              <br>

              <div class="form-group">
                  <div class="col-sm-offset-4 col-sm-6">
                      <a class="btn btn-default" href="{{ url('/admintarif') }}"><i class="glyphicon glyphicon-chevron-left"></i> Back</a>
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

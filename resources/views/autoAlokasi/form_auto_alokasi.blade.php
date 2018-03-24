@extends('layouts.app')

@section('content')
<div class="container">
  <div class="panel panel-default">
      <div class="panel-heading">
          <h2>1-Click Alokasi Otomatis</h2>
      </div>
      <div class="panel-body">
          <form action="/autoalokasi/generate" method="post" class="form-horizontal">
              {{ csrf_field() }}
              <div class="form-group">
                  <label for="periode" class="col-sm-3 control-label">Periode Pendaftaran</label>
                  <div class="col-sm-6">
                    <select name="periode" id="periode" class="form-control">
                        @foreach($daftarPeriode as $item)
                            <option>{{$item->nama or ''}}</option>
                        @endforeach
                    </select>
                  </div>
              </div>

              <div class="form-group">
                  <label for="asrama" class="col-sm-3 control-label">Asrama</label>
                  <div class="col-sm-6">
                    <input type="text" readonly="readonly" name="asrama" id="asrama" class="form-control" value="{{$daftarAsrama->nama}}" />
                  </div>
              </div>

              <div class="form-group">
                  <div class="col-sm-offset-3 col-sm-6">
                      <a class="btn btn-default" href="{{ url('/dashboard') }}"><i class="glyphicon glyphicon-chevron-left"></i> Back</a>
                      <button type="submit" class="btn btn-success">
                          <i class="glyphicon glyphicon-cog"></i> Generate
                      </button>
                  </div>
              </div>

          </form>
      </div>
  </div>
</div>
@endsection

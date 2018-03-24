@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <br>
            <div class="panel panel-default">
            <div class="panel-heading"><h2>Form Lanjut Periode</h2></div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="/create_lanjut_periode">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label for="periode_asal" class="col-md-3 control-label">Periode Asal</label>
                            <div class="col-md-8">
                                <select id="periode_asal" class="form-control" name="periode_asal" required>
                                    @foreach ($list_periode as $periode)
                                        <option>{{ $periode->nama }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="periode_akhir" class="col-md-3 control-label">Periode Akhir</label>
                            <div class="col-md-8">
                                <select id="periode_akhir" class="form-control" name="periode_akhir" required>
                                    @foreach ($list_periode as $periode)
                                        <option>{{ $periode->nama }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <div class="col-md-12">
                                <a class="btn btn-default" href="/manage_lanjut_periode"><i class="glyphicon glyphicon-chevron-left"></i> Back</a>
                                <div class="col-md-5"></div>
                                <button type="submit" class="btn btn-primary">
                                    <i class="glyphicon glyphicon-plus"></i> Create
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

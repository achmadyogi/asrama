@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading"><h2>New Kamar</h2></div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="/asrama/{{ $id_asrama }}/{{ $gedung->id_gedung }}/create_kamar">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label for="nama" class="col-md-4 control-label">No Kamar</label>
                            <div class="col-md-6">
                                <input id="no_kamar" type="text" class="form-control" name="no_kamar" required autofocus>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="kapasitas" class="col-md-4 control-label">Kapasitas</label>
                            <div class="col-md-6">
                                <input id="kapasitas" type="text" class="form-control" name="kapasitas" required autofocus>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="status" class="col-md-4 control-label">Status</label>
                            <div class="col-md-6">
                                <select id="status" class="form-control" name="status" required>
                                    <option>Reguler</option>
                                    <option>Non Reguler</option>
                                    <option>Rusak</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="gender" class="col-md-4 control-label">Gender</label>
                            <div class="col-md-6">
                                <select id="gender" type="text" class="form-control" name="gender" required>
                                    <option value="L">Laki-laki</option>
                                    <option value="P">Perempuan</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-12">
                                <a class="btn btn-default" href="/asrama/{{ $id_asrama }}"><i class="glyphicon glyphicon-chevron-left"></i> Back</a>
                                <div class="col-md-5"></div>
                                <button type="submit" class="btn btn-success">
                                    <i class="glyphicon glyphicon-ok"></i> Create
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
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h2>Edit Informasi Pendaftaran</h2>
                    <h4>Penghuni Non Reguler</h4>
                </div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="/edit_daftar_non_reguler/{{ $info_daftar->id_daftar }}">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label for="asrama" class="col-md-3 control-label">Asrama</label>
                            <div class="col-md-9">
                                <select id="asrama" class="form-control" name="asrama" required>
                                    @foreach ($list_asrama as $asrama)
                                        <option @if ($info_daftar->asrama == $asrama->nama) selected @endif>
                                            {{ $asrama->nama }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="tanggal_masuk" class="col-md-3 control-label">Tanggal Masuk</label>
                            <div class="col-md-3" style="width:28%">
                                <input id="tanggal_masuk" type="date" class="form-control" name="tanggal_masuk" value="{{ $info_daftar->tanggal_masuk }}" required>
                            </div>

                            <label for="tanggal_keluar" class="col-md-3 control-label" style="width:19%">Tanggal Keluar</label>
                            <div class="col-md-3" style="width:28%">
                                <input id="tanggal_keluar" type="date" class="form-control" name="tanggal_keluar" value="{{ $info_daftar->tanggal_keluar }}" required>
                            </div>
                        </div>
                        <br>

                        <div class="form-group">
                            <div class="col-md-7 col-md-offset-5">
                                <a class="btn btn-default" href="{{ url('/dashboard') }}"><i class="glyphicon glyphicon-chevron-left"></i> Back</a>
                                <button type="submit" class="btn btn-primary">
                                    <span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span> Simpan
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

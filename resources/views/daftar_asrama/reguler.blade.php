@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading"><h2>Daftar Penghuni Reguler</h2></div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{ route('daftar_reguler') }}">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label for="asrama" class="col-md-3 control-label">Asrama</label>
                            <div class="col-md-9">
                                <select id="asrama" class="form-control" name="asrama" required>
                                    <option value="">Pilih asrama tujuan</option>
                                    @foreach ($list_asrama as $asrama)
                                        <option>{{ $asrama->nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="periode" class="col-md-3 control-label">Periode</label>
                            <div class="col-md-9">
                                <select id="periode" class="form-control" name="periode" required>
                                    @foreach ($list_periode as $periode)
                                        <option value="{{ $periode->nama }} ({{ $periode->tanggal_awal }} s.d. {{ $periode->tanggal_akhir }})">
                                            {{ $periode->nama }} ({{ date_format(DateTime::createFromFormat('Y-m-d', $periode->tanggal_awal),"d M Y") }} s.d. {{ date_format(DateTime::createFromFormat('Y-m-d', $periode->tanggal_akhir),"d M Y") }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-7 col-md-offset-3">
                                <a class="btn btn-default" href="{{ url('/dashboard') }}"><i class="glyphicon glyphicon-chevron-left"></i> Back</a>
                                <button type="submit" class="btn btn-primary">
                                    Daftar
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

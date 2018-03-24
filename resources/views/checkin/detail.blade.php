@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">
                <h2>
                    @if($pendaftaran->status == 'Teralokasi' or $pendaftaran->status == 'Menghuni')
                        Check In
                    @else
                        Check Out
                    @endif
                </h2>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-8 col-md-offset-3">
                            <h4><strong>Biodata Calon Penghuni</strong></h4>
                            <div class="row">
                                <div class="col-md-4">Nama</div>
                                <div class="col-md-1"></div>
                                <div class="col-md-8"><strong>{{ $pendaftaran->nama }}</strong></div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">Nomor Identitas</div>
                                <div class="col-md-1"></div>
                                <div class="col-md-8"><strong>{{ $pendaftaran->nomor_identitas}} ({{$pendaftaran->jenis_identitas}})</strong></div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">Jenis Kelamin</div>
                                <div class="col-md-1"></div>
                                <div class="col-md-8"><strong>{{ ($pendaftaran->jenis_kelamin == 'L') ? 'Laki-laki' : 'Perempuan' }}</strong></div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">Pekerjaan</div>
                                <div class="col-md-1"></div>
                                <div class="col-md-8"><strong>{{ $pendaftaran->pekerjaan }}</strong></div>
                            </div>
                            <br>
                            <h4><strong>Informasi Kepenghunian</strong></h4>
                            <div class="row">
                                <div class="col-md-4">Kepenghunian</div>
                                <div class="col-md-1"></div>
                                <div class="col-md-8"><strong>
                                    @if ($jenis == 'reguler')
                                        Reguler
                                    @elseif ($jenis == 'nonreguler')
                                        Non Reguler
                                    @endif
                                </strong></div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">Asrama</div>
                                <div class="col-md-1"></div>
                                <div class="col-md-8"><strong>{{ $pendaftaran->asrama }}</strong></div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">Gedung</div>
                                <div class="col-md-1"></div>
                                <div class="col-md-8"><strong>{{ $pendaftaran->nama_gedung }}</strong></div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">Kamar</div>
                                <div class="col-md-1"></div>
                                <div class="col-md-8"><strong>{{ $pendaftaran->nama_kamar }}</strong></div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-md-4">Status</div>
                                <div class="col-md-1"></div>
                                <div class="col-md-8">
                                    <strong>{{$pendaftaran->status}}</strong>
                                </div>
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-md-8">
                                <form class="form-horizontal" role="form" method="POST" action="/manage/{{$jenis}}/{{$pendaftaran->id_daftar}}">
                                    {{csrf_field() }}
                                    <div class="form-group">
                                        <div class="col-md-7 col-md-offset-5">
                                            
                                            <a class="btn btn-default" href="/manage/{{ $jenis }}">
                                                <i class="glyphicon glyphicon-chevron-left"></i> Back
                                            </a>
                                            @if($action == 'checkin')
                                                <input type="hidden" name="action" value="checkin">
                                                <button type="submit" class="btn btn-success">
                                                    <i class="glyphicon glyphicon-ok"></i> Check In
                                                </button>
                                            @endif
                                            @if($action == 'checkout' )
                                                <input type="hidden" name="action" value="checkout">
                                                <button type="submit" class="btn btn-danger">
                                                    <i class="glyphicon glyphicon-remove"></i> Check Out
                                                </button>
                                            @endif
                                        </div>
                                    </div>
                                </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

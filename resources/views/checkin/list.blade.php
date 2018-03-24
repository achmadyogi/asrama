@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading"><h2>Check In / Check Out
                    @if($jenis == 'reguler')
                        Reguler
                    @elseif($jenis == 'nonreguler')
                        Non Reguler
                    @endif
                    </h2>
                </div>

                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="/manage/{{$jenis}}">
                        {{csrf_field() }}
                        <div class="form-group">
                            <label for="tanggalkeluar" class="col-md-3 control-label">Search</label>
                            <div class="col-md-6">
                                <input id="key" type="text" class="form-control" name="key"
                                placeholder="Search Nama/Username/Nomor Identitas">
                            </div>
                            <div class="col-md-2">
                            <button type="submit" class="btn btn-primary">
                                Search
                            </button>
                            </div>
                        </div>
                    </form>
                    <!-- NAVBAR TAB -->
                    <ul class="nav nav-tabs">
                        <li class="active"><a data-toggle="tab" href="#tab_checkin">Check in</a></li>
                        <li><a data-toggle="tab" href="#tab_checkout">Check out</a></li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane fade in active" id="tab_checkin">
                            <table class="table table-striped table-condensed table-hover">
                                <thead>
                                    <th style="width:16%;">Username</th>
                                    <th style="width:16%;">Nama Penghuni</th>
                                    <th style="width:16%;">Nomor Identitas</th>
                                    <th style="width:16%;">Tgl Masuk</th>
                                    <th style="width:16%;">Tgl Keluar</th>
                                    <th style="width:20%;">Action</th>
                                </thead>
                                <tbody>
                                @if (count($listCheckIn) == 0)
                                    <tr>
                                        <td colspan="7" style="font-size: 25px; text-align: center"><i>Nothing to show.</i></td>
                                    </tr>
                                @else
                                @foreach ($listCheckIn as $item)
                                    <tr>
                                        <td>{{$item->username}}</td>
                                        <td>{{$item->nama}}</td>
                                        <td>{{$item->nomor_identitas}}</td>
                                        <td>{{$item->tanggal_masuk}}</td>
                                        <td>{{$item->tanggal_keluar}}</td>
                                        <td >
                                            <a class="btn btn-xs btn-success" href="/manage/{{$jenis}}/{{$item->id_daftar}}">Check<br>In</a>
                                            <a class="btn btn-xs btn-primary" href="/print/{{$jenis}}/{{$item->id_daftar}}">Dokumen<br>Check In</a>
                                        </td>
                                    </tr>
                                @endforeach
                                @endif
                                </tbody>
                            </table>
                        </div>
                        <div class="tab-pane fade" id="tab_checkout">
                            <table class="table table-striped table-condensed table-hover">
                                <thead>
                                    <th style="width:16%;">Username</th>
                                    <th style="width:16%;">Nama Penghuni</th>
                                    <th style="width:16%;">Nomor Identitas</th>
                                    <th style="width:16%;">Tgl Masuk</th>
                                    <th style="width:16%;">Tgl Keluar</th>
                                    <th style="width:20%;">Action</th>
                                </thead>
                                <tbody>
                                @if (count($listCheckOut) == 0)
                                    <tr>
                                        <td colspan="7" style="font-size: 25px; text-align: center"><i>Nothing to show.</i></td>
                                    </tr>
                                @else
                                @foreach ($listCheckOut as $item)
                                    <tr>
                                        <td>{{$item->username}}</td>
                                        <td>{{$item->nama}}</td>
                                        <td>{{$item->nomor_identitas}}</td>
                                        <td>{{$item->tanggal_masuk}}</td>
                                        <td>{{$item->tanggal_keluar}}</td>
                                        <td >
                                            <a class="btn btn-xs btn-danger" href="/manage/{{$jenis}}/{{$item->id_daftar}}">Check<br>Out</a>
                                            <a class="btn btn-xs btn-primary" href="/printOut/{{$jenis}}/{{$item->id_daftar}}">Dokumen<br>Check Out</a>
                                        </td>
                                    </tr>
                                @endforeach
                                @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

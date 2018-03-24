@extends('layouts.app')

@section('content')
<div class="container">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h2>Permohonan Keluar Asrama</h2>
            <h4>Penghuni Reguler</h4>
        </div>
        <div class="panel-body">
            <table class="table table-striped table-condensed table-hover">
                <thead>
                    <th style="width:5%; text-align: center">No</th>
                    <th style="width:20%; text-align: center">Nama Penghuni</th>
                    <th style="width:10%; text-align: center">Tgl Masuk Pendaftaran</th>
                    <th style="width:10%; text-align: center">Tgl Keluar Pendaftaran</th>
                    <th style="width:10%; text-align: center">Tgl Pengajuan Keluar</th>
                    <th style="width:25%; text-align: center">Alasan</th>
                    <th style="width:5%; text-align: center"></th>
                    <th style="width:5%; text-align: center"></th>
                </thead>
                <tbody>
                @php 
                    $counter=0;
                @endphp
                @if (count($regulerProposed) == 0)
                <tr>
                    <td colspan="8" style="text-align: center; font-size: 20px"><i>Nothing to show...<i> </td>
                </tr>
                @else
                @foreach ($regulerProposed as $item) 
                    @php 
                        $counter++;
                    @endphp
                    <tr>
                        <td align="center">{{$counter}}</td>
                        <td align="center">{{$item->nama}}</td>
                        <td align="center">{{$item->tanggal_awal}}</td>
                        <td align="center">{{$item->tanggal_akhir}}</td>
                        <td align="center">{{$item->tanggal_keluar}}</td>
                        <td align="center">{{$item->alasan_keluar}}</td>
                        <td>
                            <form class="form-horizontal" method="POST" action="/managerequestkeluar">
                                {{csrf_field() }}
                                <input type="hidden" name="idPendaftaran" value="{{$item->id_daftar}}">
                                <input type="hidden" name="kepenghunian" value="Reguler">
                                <input type="hidden" name="action" value="Disetujui">
                                <button type="submit" class="btn btn-success btn-sm">
                                    ✓ Approve
                                </button>
                            </form>
                        </td>
                        <td>
                            <form class="form-horizontal" method="POST" action="/managerequestkeluar">
                                {{csrf_field() }}
                                <input type="hidden" name="idPendaftaran" value="{{$item->id_daftar}}">
                                <input type="hidden" name="kepenghunian" value="Reguler">
                                <input type="hidden" name="action" value="Ditolak">
                                <button type="submit" class="btn btn-danger btn-sm">
                                    ✖ Reject
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                @endif
                </tbody>
            </table>
        </div>
    </div>
    <div class="panel panel-default">
        <div class="panel-heading"><h4>Penghuni Non-Reguler</h4></div>
        <div class="panel-body">
            <table class="table table-striped table-condensed table-hover">
                <thead>
                    <th style="width:5%; text-align: center;">No</th>
                    <th style="width:20%; text-align: center;">Nama Penghuni</th>
                    <th style="width:10%; text-align: center;">Tgl Masuk Pendaftaran</th>
                    <th style="width:10%; text-align: center;">Tgl Keluar Pendaftaran</th>
                    <th style="width:10%; text-align: center;">Tgl Pengajuan Keluar</th>
                    <th style="width:25%; text-align: center;">Alasan</th>
                    <th style="width:5%; text-align: center;"></th>
                    <th style="width:5%; text-align: center;"></th>
                </thead>
                <tbody>
                @php 
                    $counter=0;
                @endphp
                @if (count($nonRegulerProposed) == 0)
                <tr>
                    <td colspan="8" style="text-align: center; font-size: 20px"><i>Nothing to show...<i> </td>
                </tr>
                @else
                @foreach ($nonRegulerProposed as $item) 
                    @php 
                        $counter++;
                    @endphp
                    <tr>
                        <td align="center">{{$counter}}</td>
                        <td align="center">{{$item->nama}}</td>
                        <td align="center">{{$item->tanggal_awal}}</td>
                        <td align="center">{{$item->tanggal_akhir}}</td>
                        <td align="center">{{$item->tanggal_keluar}}</td>
                        <td align="center">{{$item->alasan_keluar}}</td>
                        <td>
                            <form class="form-horizontal" method="POST" action="/managerequestkeluar">
                                {{csrf_field() }}
                                <input type="hidden" name="idPendaftaran" value="{{$item->id_daftar}}">
                                <input type="hidden" name="kepenghunian" value="Non Reguler">
                                <input type="hidden" name="action" value="Disetujui">
                                <button type="submit" class="btn btn-success btn-sm">
                                    ✓ Approve
                                </button>
                            </form>
                        </td>
                        <td>
                            <form class="form-horizontal" method="POST" action="/managerequestkeluar">
                                {{csrf_field() }}
                                <input type="hidden" name="idPendaftaran" value="{{$item->id_daftar}}">
                                <input type="hidden" name="kepenghunian" value="Non Reguler">
                                <input type="hidden" name="action" value="Ditolak">
                                <button type="submit" class="btn btn-danger btn-sm">
                                    ✖ Reject
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                @endif
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection



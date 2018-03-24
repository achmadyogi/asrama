@extends('layouts.app')

@section('content')
<div class="container">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h2>Manage NIM</h2>
            <h4>Your NIM(s)</h4>
        </div>
        <div class="panel-body">

            <div class="col-md-10 col-md-offset-1">
            <table class="table table-striped table-condensed table-hover">
                <tr>
                    <th style="width: 5%;">No.</th>
                    <th style="width: 15%;">NIM</th>
                    <th style="width: 20%;">Program Studi</th>
                    <th style="width: 40%;">Fakultas</th>
                    <th style="width: 10%;">Strata</th>
                    <th style="width: 10%;">Status</th>
                </tr>
                @if (count($mynim) == 0)
                <tr>
                    <td colspan="6" style="text-align: center; font-size: 25px">(╯°□°）╯︵ ┻━┻ <br> <i>No NIM to display...<i> </td>
                </tr>
                @else
                    @foreach($mynim as $num=>$nim)
                        <tr                                >
                            <td>{{ $num+1 }}</td>
                            <td>{{ $nim->nim }}</td>
                            <td>{{ $nim->nama_prodi }}</td>
                            <td>{{ $nim->nama_fakultas }}</td>
                            <td>{{ $nim->strata }}</td>
                            <td
                            @if ($nim->status_nim == 1)
                            class="bg-success"
                            @else
                            class="bg-danger"
                            @endif
                            ><center>{{ $nim->status_nim == 0 ? 'INVALID' : 'VALID' }}</center></td>
                        </tr>
                    @endforeach
                @endif
            </table>
            </div>
        </div>
    </div>
    <div class="panel panel-default">
        <div class="panel-heading"><h4>Add a new NIM</h4></div>
        <div class="panel-body">
            <form class="form-horizontal" role="form" method="POST" action="{{ route('addnim') }}">
                {{ csrf_field() }}
                <div class="col-md-8 col-md-offset-2">
                    <label for="nim" class="col-md-2 control-label">NIM</label>
                    <div class="col-md-6">
                        <input id="nim" type="text" class="form-control" name="nim" value="" pattern="[0-9]{8}" title="Harap masukkan 8 digit NIM" required>
                    </div>
                        <button type="submit" class="btn btn-primary col-md-2">
                            Add
                        </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

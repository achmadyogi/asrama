@extends('layouts.default')

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
                                <label for="asrama" class="col-md-3 control-label">Preferences</label>
                                <div class="col-md-9">
                                    <select id="asrama" class="form-control" name="preference" required>
                                        <option value="">Pilih Preferences</option>
                                            <option>Sendiri</option>
                                            <option>Berdua</option>
                                            <option>Bertiga</option>
                                    </select>
                                </div>
                            </div>
                        </div> 
                        <div class="form-group">
                                <label for="asrama" class="col-md-3 control-label">Beasiswa</label>
                                <div class="col-md-9">
                                    <select id="asrama" class="form-control" name="beasiswa" required>
                                        <option value="">Pilih Beasiswa</option>
                                            <option>Bidikmisi</option>
                                            <option>Afirmasi</option>
                                            <option>Non-Beasiswa</option>
                                            <option>Lainnya</option>
                                    </select>
                                </div>
                            </div>
                        </div> 
                        <div class="form-group">
                                <label for="asrama" class="col-md-3 control-label">Status Mahasiswa</label>
                                <div class="col-md-9">
                                    <select id="asrama" class="form-control" name="mahasiswa" required>
                                        <option value="">Status Mahasiswa</option>
                                            <option>Ganesha</option>
                                            <option>Jatinangor</option>
                                            <option>Cirebon</option>
                                    </select>
                                </div>
                            </div>
                        </div>   
                        <div class="form-group">
                                <label for="asrama" class="col-md-3 control-label">Kebutuhan Khusus</label>
                                <div class="col-md-9">
                                    <select id="asrama" class="form-control" name="difable" required>
                                        <option value="">Pilih Kebutuhan Khusus</option>
                                            <option>Sehat</option>
                                            <option>Berkebutuhan Khusus</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                       
                        <div class="form-group" id="difable-form"
                        >
                            <div class="col-md-6 col-md-offset-4 well well-sm">

                                <div class="row">
                                    <label for="difable-form" class="col-md-3 control-label">Kekurangan *</label>
                                    <div class="col-md-8">
                                        <input id="ket_difable" type="text" class="form-control" name="ket_difable" value="">
                                    </div>
                                </div>

                            </div>
                        </div>

                        <div class="form-group">
                                <label for="asrama" class="col-md-3 control-label">Status</label>
                                <div class="col-md-9">
                                    <select id="asrama" class="form-control" name="international" required>
                                        <option value="">Pilih Status</option>
                                            <option>Mahasiswa Internasional</option>
                                            <option>Non-Internasional</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="periode" class="col-md-3 control-label">Periode</label>
                            <div class="col-md-9">
                                <select id="periode" class="form-control" name="periode" required>
                                    <?php $i = 0; ?>
                                    @foreach ($nama_periodes as $nama_periode)
                                        {{$i + 1}}
                                        <option value="{{$nama_periode}} ({{$t_mulai_tinggal[$i]}} s.d. {{$t_selesai_tinggal[$i]}})">
                                            {{$nama_periode}} ({{$t_mulai_tinggal[$i]}} s.d. {{$t_selesai_tinggal[$i]}})
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
$(document).ready(function(){
    $('#difable').on('change', function() {
        if(this.value== 'Berkebutuhan Khusus') {
            $('#difable-form').show(600);
        } else {
            $('#difable-form').hide(600);
        }
    });
});
</script>
@endsection

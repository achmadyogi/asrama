@extends('layouts.app')

@section('content')
<div class="container">
  <div class="panel panel-default">
      <div class="panel-heading">
        <H1>Generate File<H1>
      </div>
      <div class="panel-body">
        <p> Pastikan terlebih dahulu data berikut sudah sesuai dengan diri anda.<br>
            Apabila belum, lakukan pengeditan pada edit profil atau hubungi pihak asrama untuk bantuan lebih lanjut. </p>

        <form method='post' action='/download/1/generate' class="form-horizontal">
            {{ csrf_field() }}
            <div class="form-group">
    					<label for="Nama" class="col-sm-3 control-label">Nama</label>
    					<div class="col-sm-6">
    						<input type="text" name="nama" id="nama" class="form-control" value="{{$data->nama or ''}}" readonly="readonly">
    					</div>
    				</div><br>

            <div class="form-group">
    					<label for="nim" class="col-sm-3 control-label">NIM / No.Identitas</label>
    					<div class="col-sm-6">
    						<input type="text" name="nim" id="nim" class="form-control" value="{{$data->nim or ''}}" readonly="readonly">
    					</div>
    				</div><br>

            <div class="form-group">
    					<label for="prodi" class="col-sm-3 control-label">Program Studi</label>
    					<div class="col-sm-6">
    						<input type="text" name="prodi" id="prodi" class="form-control" value="{{$data->prodi or ''}}" readonly="readonly">
    					</div>
    				</div><br>

            <div class="form-group">
    					<label for="fakultas" class="col-sm-3 control-label">Fakultas</label>
    					<div class="col-sm-6">
    						<input type="text" name="fakultas" id="fakultas" class="form-control" value="{{$data->fakultas or ''}}" readonly="readonly">
    					</div>
    				</div><br>

            <div class="form-group">
              <label for="ttl" class="col-sm-3 control-label">Tempat dan tanggal lahir</label>
              <div class="col-sm-6">
                <input type="text" name="ttl" id="ttl" class="form-control" value="{{$data->tempat_lahir or ''}}" readonly="readonly">
              </div>
            </div><br>

            <div class="form-group">
              <label for="gol_darah" class="col-sm-3 control-label">Gologan Darah</label>
              <div class="col-sm-6">
                <input type="text" name="gol_darah" id="gol_darah" class="form-control" value="{{$data->gol_darah or ''}}" readonly="readonly">
              </div>
            </div><br>

            <div class="form-group">
              <label for="agama" class="col-sm-3 control-label">Agama</label>
              <div class="col-sm-6">
                <input type="text" name="agama" id="agama" class="form-control" value="{{$data->agama or ''}}" readonly="readonly">
              </div>
            </div><br>

            <div class="form-group">
              <label for="jenis_kelamin" class="col-sm-3 control-label">Jenis Kelamin</label>
              <div class="col-sm-6">
                <input type="text" name="jenis_kelamin" id="jenis_kelamin" class="form-control" value="{{$data->jenis_kelamin or ''}}" readonly="readonly">
              </div>
            </div><br>

            <div class="form-group">
              <label for="alamat" class="col-sm-3 control-label">Alamat</label>
              <div class="col-sm-6">
                <input type="text" name="alamat" id="alamat" class="form-control" value="{{$data->alamat or ''}}" readonly="readonly">
              </div>
            </div><br>

            <div class="form-group">
              <label for="telp" class="col-sm-3 control-label">No. telp / No. HP</label>
              <div class="col-sm-6">
                <input type="text" name="telp" id="telp" class="form-control" value="{{$data->telepon or ''}}" readonly="readonly">
              </div>
            </div><br>

            <div class="form-group">
              <label for="email" class="col-sm-3 control-label">Email</label>
              <div class="col-sm-6">
                <input type="text" name="email" id="email" class="form-control" value="{{$data->email or ''}}" readonly="readonly">
              </div>
            </div><br>

            <div class="form-group">
              <label for="nama_ortu_wali" class="col-sm-3 control-label">Nama orang tua/wali</label>
              <div class="col-sm-6">
                <input type="text" name="nama_ortu_wali" id="nama_ortu_wali" class="form-control" value="{{$data->nama_ortu_wali or ''}}" readonly="readonly">
              </div>
            </div><br>

            <div class="form-group">
              <label for="pekerjaan_ortu_wali" class="col-sm-3 control-label">Pekerjaan orang tua/wali</label>
              <div class="col-sm-6">
                <input type="text" name="pekerjaan_ortu_wali" id="pekerjaan_ortu_wali" class="form-control" value="{{$data->pekerjaan_ortu_wali or ''}}" readonly="readonly">
              </div>
            </div><br>

            <div class="form-group">
              <label for="alamat_ortu_wali" class="col-sm-3 control-label">Alamat orang tua/wali</label>
              <div class="col-sm-6">
                <input type="text" name="alamat_ortu_wali" id="alamat_ortu_wali" class="form-control" value="{{$data->alamat_ortu_wali or ''}}" readonly="readonly">
              </div>
            </div><br>

            <div class="form-group">
              <label for="telepon_ortu_wali" class="col-sm-3 control-label">No telp. / HP orang tua / wali</label>
              <div class="col-sm-6">
                <input type="text" name="telepon_ortu_wali" id="telepon_ortu_wali" class="form-control" value="{{$data->telepon_ortu_wali or ''}}" readonly="readonly">
              </div>
            </div><br>

            <div class="form-group">
              <label for="asrama" class="col-sm-3 control-label">Asrama</label>
              <div class="col-sm-6">
                <input type="text" name="asrama" id="asrama" class="form-control" value="{{$data->asrama or ''}}" readonly="readonly">
              </div>
            </div><br>

            <div class="form-group">
              <label for="tanggal_masuk" class="col-sm-3 control-label">Periode Tinggal</label>
              <div class="col-sm-6">
                <input type="text" name="tanggal_masuk" id="tanggal_masuk" class="form-control" value="{{$data->tanggal_masuk or ''}}  -  {{$data->tanggal_keluar or ''}}" readonly="readonly">
              </div>
            </div><br>

            <div class="form-group">
    					<div class="col-sm-offset-3 col-sm-6">
    						<button type="submit" class="btn btn-success">
    							<i class="fa fa-plus"></i> Generate
    						</button>
    						<a class="btn btn-default" href="{{ url('/download') }}"><i class="glyphicon glyphicon-chevron-left"></i> Back</a>
    					</div>
    				</div>
    			</form>
      </div>
  </div>
</div>
@endsection

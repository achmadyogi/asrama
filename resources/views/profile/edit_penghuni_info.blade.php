@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading"><h2>Edit Data Penghuni</h2></div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{ route('edit_penghuni_info') }}">
                        {{ csrf_field() }}
                        <h2> Biodata diri </h2>
                        <!-- IDENTITAS PENGGUNA -->
                        <div class="form-group{{ $errors->has('nomor_identitas') ? ' has-error' : '' }}">
                            <label for="nomor_identitas" class="col-md-3 control-label">No Identitas *</label>

                            <div class="col-md-3">
                                <select id="jenis_identitas" class="form-control" name="jenis_identitas" required>
                                    <option 
                                    @if ($info_penghuni->jenis_identitas == 'KTP')
                                        selected
                                    @endif
                                    >KTP</option>
                                    <option 
                                    @if ($info_penghuni->jenis_identitas == 'SIM')
                                        selected
                                    @endif
                                    >SIM</option>
                                    <option 
                                    @if ($info_penghuni->jenis_identitas == 'Passport')
                                        selected
                                    @endif
                                    >Passport</option>
                                    <option 
                                    @if ($info_penghuni->jenis_identitas == 'No. Registrasi')
                                        selected
                                    @endif
                                    >No. Registrasi</option>
                                    <option 
                                    @if ($info_penghuni->jenis_identitas == 'Kartu Pelajar')
                                        selected
                                    @endif
                                    >Kartu Pelajar</option>
                                    <option 
                                    @if ($info_penghuni->jenis_identitas == 'No. SNMPTN')
                                        selected
                                    @endif
                                    >No. SNMPTN</option>
                                    <option 
                                    @if ($info_penghuni->jenis_identitas == 'No. SBMPTN')
                                        selected
                                    @endif
                                    >No. SBMPTN</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <input id="nomor_identitas" type="text" class="form-control" name="nomor_identitas" value="{{ $info_penghuni->nomor_identitas }}" required autofocus>

                                @if ($errors->has('nomor_identitas'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('nomor_identitas') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <!-- JENIS KELAMIN & GOLONGAN DARAH -->
                        <div class="form-group{{ $errors->has('jenis_kelamin') ? ' has-error' : '' }}">
                            <label for="jenis_kelamin" class="col-md-3 control-label">Jenis Kelamin *</label>

                            <div class="col-md-3">
                                <select id="jenis_kelamin" class="form-control" name="jenis_kelamin" required>
                                    <option 
                                    @if ($info_penghuni->jenis_kelamin == 'P')
                                        selected
                                    @endif
                                    >Laki-laki</option>
                                    <option 
                                    @if ($info_penghuni->jenis_kelamin == 'W')
                                        selected
                                    @endif
                                    >Perempuan</option>
                                </select>
                            </div>
                            <label for="gol_darah" class="col-md-3 control-label">Gol. Darah *</label>

                            <div class="col-md-3">
                                <select id="gol_darah" class="form-control" name="gol_darah" required>
                                    <option></option>
                                    <option 
                                    @if ($info_penghuni->gol_darah == 'A')
                                        selected
                                    @endif
                                    >A</option>
                                    <option 
                                    @if ($info_penghuni->gol_darah == 'B')
                                        selected
                                    @endif
                                    >B</option>
                                    <option 
                                    @if ($info_penghuni->gol_darah == 'AB')
                                        selected
                                    @endif
                                    >AB</option>
                                    <option 
                                    @if ($info_penghuni->gol_darah == 'O')
                                        selected
                                    @endif
                                    >O</option>
                                    <option 
                                    @if ($info_penghuni->gol_darah == '-')
                                        selected
                                    @endif
                                    >Tidak tahu</option>
                                </select>
                            </div>
                        </div>

                        <!-- TEMPAT, TGL LAHIR -->
                        <div class="form-group{{ $errors->has('nama') ? ' has-error' : '' }}">
                            <label for="ttl" class="col-md-3 control-label">Tempat, Tanggal Lahir *</label>

                            <div class="col-md-3">
                                <input id="tempat_lahir" type="text" class="form-control" name="tempat_lahir" value="{{ $info_penghuni->tempat_lahir }}" required>
                                @if ($errors->has('tempat_lahir'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('tempat_lahir') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="col-md-6">
                                <input id="tanggal_lahir" type="date" class="form-control" name="tanggal_lahir" value="{{ $info_penghuni->tanggal_lahir }}" 
                                placeholder="YYYY-MM-DD"
                                required>

                                @if ($errors->has('tanggal_lahir'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('tanggal_lahir') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <!-- ALAMAT TINGGAL -->
                        <div class="form-group{{ $errors->has('alamat') ? ' has-error' : '' }}">
                            <label for="alamat" class="col-md-3 control-label">Alamat *</label>

                            <div class="col-md-9">
                                <textarea id="alamat" class="form-control" name="alamat" style="resize: none;" required>{{ $info_penghuni->alamat }}</textarea>
                            </div>
                        </div>

                        <!-- AGAMA, PEKERJAAN, WARGA NEGARA -->
                        <div class="form-group{{ $errors->has('pekerjaan') ? ' has-error' : '' }}">
                            <label for="pekerjaan" class="col-md-3 control-label">Pekerjaan *</label>
                            <div class="col-md-9">
                                <select id="pekerjaan" class="form-control" name="pekerjaan" required>
                                    <option></option>
                                    <option 
                                    @if ($info_penghuni->pekerjaan == 'Mahasiswa ITB')
                                        selected
                                    @endif
                                    >Mahasiswa ITB</option>
                                    <option 
                                    @if ($info_penghuni->pekerjaan == 'Mahasiswa Non-ITB')
                                        selected
                                    @endif
                                    >Mahasiswa Non-ITB</option>
                                    <option 
                                    @if ($info_penghuni->pekerjaan == 'Dosen')
                                        selected
                                    @endif
                                    >Dosen</option>
                                    <option 
                                    @if ($info_penghuni->pekerjaan == 'Wiraswasta')
                                        selected
                                    @endif
                                    >Wiraswasta</option>
                                    <option 
                                    @if ($info_penghuni->pekerjaan == 'Pegawai Negeri Sipil')
                                        selected
                                    @endif
                                    >Pegawai Negeri Sipil</option>
                                    <option 
                                    @if ($info_penghuni->pekerjaan == 'Ibu Rumah Tangga')
                                        selected
                                    @endif
                                    >Ibu Rumah Tangga</option>
                                    <option 
                                    @if ($info_penghuni->pekerjaan == 'Pelajar')
                                        selected
                                    @endif
                                    >Pelajar</option>
                                </select>
                                @if ($errors->has('pekerjaan'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('pekerjaan') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group" id="nim" 
                        @if ($info_penghuni->pekerjaan !== 'Mahasiswa ITB')
                            style="display: none;"
                        @endif
                        >
                            <div class="col-md-6 col-md-offset-4 well well-sm">
                            @if (isset($nim))
                                NIM terakhir Anda <b>{{ $nim->nim }}</b> <br>
                                Anda dapat mengubah NIM Anda pada halaman <a href="{{ route('managenim') }}">Manage NIM</a>
                            @else
                                Anda belum memasukkan NIM.
                                <div class="row">
                                    <label for="nim" class="col-md-3 control-label">NIM *</label>
                                    <div class="col-md-8">
                                        <input id="nim" type="text" class="form-control" name="nim">
                                    </div>
                                </div>
                            @endif
                                <div class="row">
                                    <label for="roles" class="col-sm-12 control-label" style="text-align: center;">
                                        <input class="col-sm-1" type="checkbox" name="is_bidikmisi" id="is_bidikmisi" class="form-control"
                                        @if ($info_penghuni->is_bidikmisi == '1')
                                        checked
                                        @endif
                                        >
                                        Saya adalah Mahasiswa Bidikmisi.
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('agama') ? ' has-error' : '' }}">
                            <label for="agama" class="col-md-3 control-label">Agama *</label>

                            <div class="col-md-3">
                                <select id="agama" class="form-control" name="agama" required>
                                    <option></option>
                                    <option 
                                    @if ($info_penghuni->agama == 'Islam')
                                        selected
                                    @endif
                                    >Islam</option>
                                    <option 
                                    @if ($info_penghuni->agama == 'Kristen')
                                        selected
                                    @endif
                                    >Kristen</option>
                                    <option 
                                    @if ($info_penghuni->agama == 'Katolik')
                                        selected
                                    @endif
                                    >Katolik</option>
                                    <option 
                                    @if ($info_penghuni->agama == 'Hindu')
                                        selected
                                    @endif
                                    >Hindu</option>
                                    <option 
                                    @if ($info_penghuni->agama == 'Buddha')
                                        selected
                                    @endif
                                    >Buddha</option>
                                    <option 
                                    @if ($info_penghuni->agama == 'Konghucu')
                                        selected
                                    @endif
                                    >Konghucu</option>
                                </select>
                            </div>
                            <label for="warga_negara" class="col-md-3 control-label">Warga Negara *</label>

                            <div class="col-md-3">
                                <input id="warga_negara" type="text" class="form-control" name="warga_negara" value="{{ $info_penghuni->warga_negara }}" required>

                                @if ($errors->has('warga_negara'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('warga_negara') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <!-- TELEPON & INSTANSI -->
                        <div class="form-group{{ $errors->has('telepon') ? ' has-error' : '' }}">
                            <label for="telepon" class="col-md-3 control-label">Telepon *</label>
                            <div class="col-md-9">
                                <input id="telepon" type="text" class="form-control" name="telepon" value="{{ $info_penghuni->telepon }}" pattern="[0-9]+" title="Harap masukkan hanya angka 0-9" required>

                                @if ($errors->has('telepon'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('telepon') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('instansi') ? ' has-error' : '' }}">
                            <label for="instansi" class="col-md-3 control-label">Instansi *</label>
                            <div class="col-md-9">
                                @if ($info_penghuni->pekerjaan == 'Mahasiswa ITB')
                                <input id="instansi" type="text" class="form-control" name="instansi" value="Institut Teknologi Bandung" readonly="true" required>
                                @else
                                <input id="instansi" type="text" class="form-control" name="instansi" value="{{ $info_penghuni->instansi }}" required>
                                @endif

                                @if ($errors->has('instansi'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('instansi') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <br>
                    <div id="biodata_ortu"
                    @if ($info_penghuni->pekerjaan !== 'Mahasiswa ITB')
                        style="display: none;"
                    @endif
                    >
                        <h2> Biodata Orang Tua Wali </h2>
                        <!-- ORTU WALI -->
                        <div class="form-group{{ $errors->has('nama_ortu_wali') ? ' has-error' : '' }}">
                            <label for="nama_ortu_wali" class="col-md-3 control-label">Nama Ortu Wali *</label>
                            <div class="col-md-9">
                                <input id="nama_ortu_wali" type="text" class="form-control" name="nama_ortu_wali" value="{{ $info_penghuni->nama_ortu_wali }}">

                                @if ($errors->has('nama_ortu_wali'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('nama_ortu_wali') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('pekerjaan_ortu_wali') ? ' has-error' : '' }}">
                            <label for="pekerjaan_ortu_wali" class="col-md-3 control-label">Pekerjaan Ortu Wali *</label>
                            <div class="col-md-9">
                                <input id="pekerjaan_ortu_wali" type="text" class="form-control" name="pekerjaan_ortu_wali" value="{{ $info_penghuni->pekerjaan_ortu_wali }}">

                                @if ($errors->has('pekerjaan_ortu_wali'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('pekerjaan_ortu_wali') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('alamat_ortu_wali') ? ' has-error' : '' }}">
                            <label for="alamat_ortu_wali" class="col-md-3 control-label">Alamat Ortu Wali *</label>
                            <div class="col-md-9">
                                <textarea id="alamat_ortu_wali" class="form-control" name="alamat_ortu_wali" style="resize: none;" >{{ $info_penghuni->alamat_ortu_wali }}</textarea>

                                @if ($errors->has('alamat_ortu_wali'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('alamat_ortu_wali') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('telepon_ortu_wali') ? ' has-error' : '' }}">
                            <label for="telepon_ortu_wali" class="col-md-3 control-label">Telepon Ortu Wali *</label>
                            <div class="col-md-9">
                                <input id="telepon_ortu_wali" type="text" class="form-control" name="telepon_ortu_wali" value="{{ $info_penghuni->telepon_ortu_wali }}">

                                @if ($errors->has('telepon_ortu_wali'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('telepon_ortu_wali') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <br>
                    </div>
                        
                        <h2> Kontak Darurat </h2>
                        <div class="form-group{{ $errors->has('kontak_darurat') ? ' has-error' : '' }}">
                            <label for="kontak_darurat" class="col-md-3 control-label">Kontak Darurat *</label>
                            <div class="col-md-9">
                                <input id="kontak_darurat" type="text" class="form-control" name="kontak_darurat" value="{{ $info_penghuni->kontak_darurat }}" pattern="[0-9]+" title="Harap masukkan hanya angka 0-9" required>

                                @if ($errors->has('kontak_darurat'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('kontak_darurat') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        

                        <div class="form-group">
                            <div class="col-md-3">
                            *) Required
                            </div>
                            <div class="col-md-7 col-md-offset-2">
                                <a class="btn btn-default" href="{{ route('myprofile') }}"><i class="glyphicon glyphicon-chevron-left"></i> Back</a>
                                <button type="submit" class="btn btn-success">
                                    <span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span> Save
                                </button>

                            </div>

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script>
$(document).ready(function(){
    $('#pekerjaan').on('change', function() {
      if ( this.value == 'Mahasiswa ITB') {
        $("#biodata_ortu").show(600);
        $("#nim").show(600);
        $("#instansi").val("Institut Teknologi Bandung");
        $("#instansi").prop('readonly', true);
      } else {
        $("#biodata_ortu").hide(600);
        $("#nim").hide(600);
        $("#instansi").prop('readonly', false);
        $("#instansi").val("");
      }
    });
});
</script>
@endsection

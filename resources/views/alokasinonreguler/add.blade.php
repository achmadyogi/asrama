@extends('layouts.app')

@section('content')

<div class="container">
	<div class="panel panel-default">
		<div class="panel-heading">
			<h2>Atur Alokasi Kamar</h2>    </div>
		<div class="panel-body">
		
			<form action="{{ url('/alokasinonreguler'.( isset($kamarNonReguler) ? "/" . $model->id : "")) }}" method="POST" class="form-horizontal">
				{{ csrf_field() }}

				@if (isset($kamarNonReguler))
					<input type="hidden" name="_method" value="PATCH">
				@endif


				<div class="form-group" style="display: none;">
					<label for="id_pendaftaran_non_reguler" class="col-sm-4 control-label">Id daftar</label>
					<div class="col-sm-6">
						<input type="text" name="id_pendaftaran_non_reguler" id="id_pendaftaran_non_reguler" class="form-control" value="{{$model['id_daftar'] or ''}}" readonly="readonly">
					</div>
				</div>
			
				<div class="form-group">
					<label for="nomor_identitas" class="col-sm-4 control-label">Nomor Identitas</label>
					<div class="col-sm-6">
						<input type="number" name="nomor_identitas" id="nomor_identitas" class="form-control" value="{{$model['nomor_identitas'] or ''}}" readonly="readonly">
					</div>
				</div>
				<div class="form-group">
					<label for="jenis_identitas" class="col-sm-4 control-label">Jenis Identitas</label>
					<div class="col-sm-6">
						<input type="text" name="jenis_identitas" id="jenis_identitas" class="form-control" value="{{$model['jenis_identitas'] or ''}}" readonly="readonly">
					</div>
				</div>
				
				<div class="form-group">
					<label for="jenis_kelamin" class="col-sm-4 control-label">Jenis Kelamin</label>
					<div class="col-sm-6">
						<input type="text" name="jenis_kelamin" id="jenis_kelamin" class="form-control" value="{{$model['jenis_kelamin'] or ''}}" readonly="readonly">
					</div>
				</div>
				
				<div class="form-group">
					<label for="asrama" class="col-sm-4 control-label">Tanggal Masuk</label>
					<div class="col-sm-6">
						<input type="text" name="tanggal_masuk" id="tanggal_masuk" class="form-control" value="{{$model['tanggal_masuk'] or ''}}" readonly="readonly">
					</div>
				</div>				

				<div class="form-group">
					<label for="asrama" class="col-sm-4 control-label">Tanggal Keluar</label>
					<div class="col-sm-6">
						<input type="text" name="tanggal_keluar" id="tanggal_keluar" class="form-control" value="{{$model['tanggal_keluar'] or ''}}" readonly="readonly">
					</div>
				</div>	
				
				<div class="form-group">
					<label for="asrama" class="col-sm-4 control-label">Asrama</label>
					<div class="col-sm-6">
						<input type="text" name="asrama" id="asrama" class="form-control" value="{{$model['asrama'] or ''}}" readonly="readonly">
					</div>
				</div>
				
				
				<div class="form-group">
					<label for="id_kamar" class="col-sm-4 control-label">Kamar</label>
						<div class="col-sm-6">
							<select id="id_kamar" class="form-control" name="id_kamar">
								@foreach ($kamars as $kamar)
									@if ($kamar->gender == $model->jenis_kelamin && $kamar->status == "Non Reguler" && ($kamar->jumlah_penghuni ? $kamar->jumlah_penghuni : 0) < $kamar->kapasitas)
										<option
										@if ($kamarNonReguler != null && ($kamar->id_kamar == $kamarNonReguler->id_kamar))
											selected
										@endif
										value="{{$kamar->id_kamar}}">{{$kamar->nama}} ({{$kamar->jumlah_penghuni ? $kamar->jumlah_penghuni : 0}}/{{$kamar->kapasitas}})</option>
									@endif
								@endforeach

                            </select>							
						</div>
				</div>

													
				<div class="form-group">
					<div class="col-sm-offset-4 col-sm-6">
						<a class="btn btn-default" href="{{ url('/alokasinonreguler') }}"><i class="glyphicon glyphicon-chevron-left"></i> Back</a>
						<button type="submit" class="btn btn-success">
							<i class="glyphicon glyphicon-floppy-disk"></i> Save
						</button> 
						
					</div>
				</div>
			</form>

		</div>
	</div>
</div>





@endsection
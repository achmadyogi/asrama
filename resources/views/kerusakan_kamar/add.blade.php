@extends('layouts.app')

@section('content')

<div class="container">
	<div class="col-md-10 col-md-offset-1">
	<div class="panel panel-default">
		<div class="panel-heading">
			<h2>Lapor Kerusakan Kamar</h2>
		</div>

		<div class="panel-body">
					
			<form action="{{ url('/kerusakan_kamar'.( isset($model) ? "/" . $model->id : "")) }}" method="POST" class="form-horizontal">
				{{ csrf_field() }}

				@if (isset($model))
					<input type="hidden" name="_method" value="PATCH">
				@endif
				
				<div class="form-group" style="display: none;">
					<label for="id_kerusakan" class="col-sm-3 control-label">Id Kerusakan</label>
					<div class="col-sm-2">
						<input type="number" name="id_kerusakan" id="id_kerusakan" class="form-control" value="{{$model['id_kerusakan'] or ''}}">
					</div>
				</div>				
				
				<div class="form-group"  style="display: none;">
					<label for="id_kamar" class="col-sm-3 control-label">Id Kamar</label>
					<div class="col-sm-2">
						<input type="number" name="id_kamar" id="id_kamar" class="form-control" value="{{$model['id_kamar'] or $kamar['id_kamar']}}">
					</div>
				</div>
				<div class="form-group" style="display: none;">
					<label for="id_pelapor" class="col-sm-3 control-label">Id Pelapor</label>
					<div class="col-sm-2">
						<input type="number" name="id_pelapor" id="id_pelapor" class="form-control" value="{{$model['id_pelapor'] or $id_user}}">
					</div>
				</div>
				
				<div class="form-group">
					<label for="nama_kamar" class="col-md-3 col-md-offset-1 control-label">Kamar</label>
					<div class="col-md-2">
						<input type="number" name="nama_kamar" id="nama_kamar" class="form-control" value="{{$kamar->nama}}" readonly="readonly">
					</div>
				</div>
				
				@if (isset($model))				
					<div class="form-group">
						<label for="keterangan" class="col-md-3 col-md-offset-1 control-label">Keterangan</label>
						<div class="col-md-6">
							<textarea name="keterangan" id="keterangan" class="form-control" style="resize: none; height: 144px;" required readonly="readonly">{{$model['keterangan'] or ''}}</textarea>
						</div>
					</div>
					
					<div class="form-group">
						<label for="status" class="col-md-3 col-md-offset-1 control-label">Status</label>
							<div class="col-md-6">
								<select id="status" class="form-control" name="status">
									<option value="Belum Ditangani">Belum Ditangani</option>
									<option value="Sedang Ditangani">Sedang Ditangani</option>
									<option value="Sudah Ditangani">Sudah Ditangani</option>
								</select>							
							</div>
					</div>
				@else
					<div class="form-group">
						<label for="keterangan" class="col-md-3 col-md-offset-1 control-label">Keterangan</label>
						<div class="col-md-6">
							<textarea name="keterangan" id="keterangan" class="form-control" style="resize: none; height: 144px;" required>{{$model['keterangan'] or ''}}</textarea>
						</div>
					</div>				
				@endif
				
				
							
				<div class="form-group">
					<div class="col-sm-offset-4 col-sm-6">
					@if (isset($model))	
						<a class="btn btn-default" href="{{ url('/kerusakan_kamar') }}"><i class="glyphicon glyphicon-chevron-left"></i> Back</a>
					@else
						<a class="btn btn-default" href="{{ url('/dashboard') }}"><i class="glyphicon glyphicon-chevron-left"></i> Back</a>
					@endif
						<button type="submit" class="btn btn-success">
							<i class="glyphicon glyphicon-ok"></i> Submit
						</button>
					</div>
				</div>
			</form>

		</div>
	</div>
	</div>
</div>
@endsection
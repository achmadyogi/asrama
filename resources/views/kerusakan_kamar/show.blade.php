@extends('layouts.app')

@section('content')

<div class="container">
	<div class="panel panel-default">
		<div class="panel-heading">
			View Kerusakan_kamar    </div>

		<div class="panel-body">
					

			<form action="{{ url('/kerusakan_kamars') }}" method="POST" class="form-horizontal">


					
			<div class="form-group">
				<label for="id_kerusakan" class="col-sm-3 control-label">Id Kerusakan</label>
				<div class="col-sm-6">
					<input type="text" name="id_kerusakan" id="id_kerusakan" class="form-control" value="{{$model['id_kerusakan'] or ''}}" readonly="readonly">
				</div>
			</div>
			
					
			<div class="form-group">
				<label for="id_kamar" class="col-sm-3 control-label">Id Kamar</label>
				<div class="col-sm-6">
					<input type="text" name="id_kamar" id="id_kamar" class="form-control" value="{{$model['id_kamar'] or ''}}" readonly="readonly">
				</div>
			</div>
			
					
			<div class="form-group">
				<label for="id_pelapor" class="col-sm-3 control-label">Id Pelapor</label>
				<div class="col-sm-6">
					<input type="text" name="id_pelapor" id="id_pelapor" class="form-control" value="{{$model['id_pelapor'] or ''}}" readonly="readonly">
				</div>
			</div>
			
					
			<div class="form-group">
				<label for="keterangan" class="col-sm-3 control-label">Keterangan</label>
				<div class="col-sm-6">
					<input type="text" name="keterangan" id="keterangan" class="form-control" value="{{$model['keterangan'] or ''}}" readonly="readonly">
				</div>
			</div>
			
					
			<div class="form-group">
				<label for="created_at" class="col-sm-3 control-label">Created At</label>
				<div class="col-sm-6">
					<input type="text" name="created_at" id="created_at" class="form-control" value="{{$model['created_at'] or ''}}" readonly="readonly">
				</div>
			</div>
			
					
			<div class="form-group">
				<label for="updated_at" class="col-sm-3 control-label">Updated At</label>
				<div class="col-sm-6">
					<input type="text" name="updated_at" id="updated_at" class="form-control" value="{{$model['updated_at'] or ''}}" readonly="readonly">
				</div>
			</div>
			
			
			<div class="form-group">
				<div class="col-sm-offset-3 col-sm-6">
					<a class="btn btn-default" href="{{ url('/kerusakan_kamar') }}"><i class="glyphicon glyphicon-chevron-left"></i> Back</a>
				</div>
			</div>


			</form>

		</div>
	</div>
</div>






@endsection
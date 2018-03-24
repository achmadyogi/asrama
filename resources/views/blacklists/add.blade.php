@extends('layouts.app')

@section('content')

<div class="container">
	<div class="panel panel-default">
		<div class="panel-heading">
		@if (isset($model))
			<h2>Modify Blacklist</h2>
		@else
			<h2>Add to Blacklist</h2>
		@endif
		</div>

		<div class="panel-body">
					
			<form action="{{ url('/blacklists'.( isset($model) ? "/" . $model->id : "")) }}" method="POST" class="form-horizontal">
				{{ csrf_field() }}

				@if (isset($model))
					<input type="hidden" name="_method" value="PATCH">
				@endif


				<div class="form-group">
					<label for="nama" class="col-sm-3 control-label">Nama</label>
					<div class="col-sm-6">
						<input type="text" name="nama" id="nama" class="form-control" value="{{$model['nama'] or ''}}" readonly="readonly">
					</div>
				</div>
			
					
				<div class="form-group">
					<label for="email" class="col-sm-3 control-label">Email</label>
					<div class="col-sm-6">
						<input type="text" name="email" id="email" class="form-control" value="{{$model['email'] or ''}}" readonly="readonly">
					</div>
				</div>
				
				<div class="form-group" style="display: none;">
					<label for="id_user" class="col-sm-3 control-label">Id User</label>
					<div class="col-sm-2">
						<input type="number" name="id_user" id="id_user" class="form-control" value="{{$model['id'] or ''}}">
					</div>
				</div>
				
				<div class="form-group">
					<label for="alasan" class="col-sm-3 control-label">Alasan</label>
					<div class="col-sm-6">
						<textarea name="alasan" id="alasan" class="form-control" style="resize: none; height: 144px;" required>
							{{$model_blacklist['alasan'] or ''}}
						</textarea>
					</div>
				</div>
																
				<div class="form-group">
					<div class="col-sm-offset-3 col-sm-6">
						<a class="btn btn-default" href="{{ url('/users') }}"><i class="glyphicon glyphicon-chevron-left"></i> Back</a>
						<button type="submit" class="btn btn-success">
							<span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span> Save
						</button> 
						
					</div>
				</div>
			</form>

		</div>
	</div>
</div>






@endsection
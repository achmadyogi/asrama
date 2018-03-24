@extends('layouts.app')

@section('content')

<div class="container">
	<div class="panel panel-default">
		<div class="panel-heading">
			View Blacklist    </div>

		<div class="panel-body">
					

			<form action="{{ url('/blacklists') }}" method="POST" class="form-horizontal">


					
			<div class="form-group">
				<label for="id_user" class="col-sm-3 control-label">Id User</label>
				<div class="col-sm-6">
					<input type="text" name="id_user" id="id_user" class="form-control" value="{{$model['id_user'] or ''}}" readonly="readonly">
				</div>
			</div>
			
					
			<div class="form-group">
				<label for="alasan" class="col-sm-3 control-label">Alasan</label>
				<div class="col-sm-6">
					<input type="text" name="alasan" id="alasan" class="form-control" value="{{$model['alasan'] or ''}}" readonly="readonly">
				</div>
			</div>
			
			
			<div class="form-group">
				<div class="col-sm-offset-3 col-sm-6">
					<a class="btn btn-default" href="{{ url('/blacklists') }}"><i class="glyphicon glyphicon-chevron-left"></i> Back</a>
				</div>
			</div>


			</form>

		</div>
	</div>
</div>







@endsection
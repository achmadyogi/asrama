@extends('layouts.app')

@section('content')



<div class="container">
	<div class="panel panel-default">
		<div class="panel-heading">
			View User    </div>

		<div class="panel-body">


			<form action="{{ url('/users') }}" method="POST" class="form-horizontal">



			<div class="form-group">
				<label for="id" class="col-sm-3 control-label">Id</label>
				<div class="col-sm-6">
					<input type="text" name="id" id="id" class="form-control" value="{{$model['id'] or ''}}" readonly="readonly">
				</div>
			</div>
			

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
				<label for="username" class="col-sm-3 control-label">Username</label>
				<div class="col-sm-6">
					<input type="text" name="username" id="username" class="form-control" value="{{$model['username'] or ''}}" readonly="readonly">
				</div>
			</div>


			<div class="form-group">
				<div class="col-sm-offset-3 col-sm-6">
					<a class="btn btn-default" href="{{ url('/users') }}"><i class="glyphicon glyphicon-chevron-left"></i> Back</a>
				</div>
			</div>


			</form>

		</div>
	</div>
</div>






@endsection

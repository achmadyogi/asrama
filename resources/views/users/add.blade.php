@extends('layouts.app')

@section('content')


<div class="container">
	<div class="panel panel-default">
		<div class="panel-heading">
			@if (isset($model))
				<h2>Edit User</h2>
			@else
				<h2>New User</h2>
			@endif
		</div>

		<div class="panel-body">

			<form action="{{ url('/users'.( isset($model) ? "/" . $model->id : "")) }}" method="POST" class="form-horizontal">
				{{ csrf_field() }}

				@if (isset($model))
					<input type="hidden" name="_method" value="PATCH">
					<input type="hidden" name="id" id="id" class="form-control" value="{{$model['id'] or ''}}">
				@endif

				<div class="form-group">
					<label for="username" class="col-sm-3 control-label">Username</label>
					<div class="col-sm-6">
						<input type="text" name="username" id="username" class="form-control" value="{{$model['username'] or ''}}" required @if (isset($model)) readonly="readonly" @endif>
					</div>
				</div>
				<div class="form-group">
					<label for="nama" class="col-sm-3 control-label">Nama</label>
					<div class="col-sm-6">
						<input type="text" name="nama" id="nama" class="form-control" value="{{$model['nama'] or ''}}" required>
					</div>
				</div>
				<div class="form-group">
					<label for="email" class="col-sm-3 control-label">Email</label>
					<div class="col-sm-6">
						<input type="email" name="email" id="email" class="form-control" value="{{$model['email'] or ''}}" required>
					</div>
				</div>

				<div class="form-group">
					<label for="roles" class="col-sm-3 control-label">Roles :</label>
					<div class="col-sm-6">
						<div class="col-sm-1"></div>
						<label for="roles" class="col-sm-2 control-label" style="text-align: center;">
							<input class="col-sm-12" type="checkbox" name="penghuni_check" id="penghuni_check" class="form-control"
							@if (isset($model) && $model['is_penghuni'] == 1)
							checked
							@endif
							><br>
							<small>Penghuni</small>
						</label>
						<label for="roles" class="col-sm-2 control-label" style="text-align: center;">
							<input class="col-sm-12" type="checkbox" name="pengelola_check" id="pengelola_check" class="form-control"
							@if (isset($model) && $model['is_pengelola'] == 1)
							checked
							@endif
							><br>
							<small>Pengelola Asrama</small>
						</label>
						<label for="roles" class="col-sm-2 control-label" style="text-align: center;">
							<input class="col-sm-12" type="checkbox" name="sekretariat_check" id="sekretariat_check" class="form-control"
							@if (isset($model) && $model['is_sekretariat'] == 1)
							checked
							@endif
							> <br>
							<small>Sekretariat</small>
						</label>
						<label for="roles" class="col-sm-2 control-label" style="text-align: center;">
							<input class="col-sm-12" type="checkbox" name="pimpinan_check" id="pimpinan_check" class="form-control"
							@if (isset($model) && $model['is_pimpinan'] == 1)
							checked
							@endif
							> <br>
							<small>Pimpinan</small>
						</label>
						<label for="roles" class="col-sm-2 control-label" style="text-align: center;">
							<input class="col-sm-12" type="checkbox" name="admin_check" id="admin_check" class="form-control"
							@if (isset($model) && $model['is_admin'] == 1)
							checked
							@endif
							> <br>
							<small>Administrator</small>
						</label>
					</div>
				</div>

				<div class="well well-sm" id="asrama_selector"
				@if (!isset($model) || $model['is_pengelola'] != 1)
                    style="display: none;"
                @endif
				>
					<div class="row">
						<div class="col-sm-6 col-sm-offset-2">
							<small><i>Field berikut hanya untuk role pengelola asrama</i></small>
						</div>
					</div>
					<div class="row">
						<label for="id" class="col-sm-3 control-label">Asrama</label>
						<div class="col-sm-6">
							<select id="asrama" class="form-control" name="asrama">
								<option value="">Pilih asrama</option>
								@if (isset($asrama_list))
								@foreach ($asrama_list as $asrama)
								<option value="{{ $asrama->id_asrama }}"
									@if (isset($model) && isset($model->pengelola) && $model->pengelola->id_asrama == $asrama->id_asrama)
									selected
									@endif
								> {{ $asrama->id_asrama }} - {{ $asrama->nama }}</option>
								@endforeach
								@endif
							</select>
						</div>
					</div>
				</div>


				<div class="form-group">
					<div class="col-sm-offset-3 col-sm-2">
						<a class="btn btn-default" href="{{ url('/users') }}"><i class="glyphicon glyphicon-chevron-left"></i> Back</a>
						<button type="submit" class="btn btn-success">
							<span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span> Save
						</button>
					</div>
					<div class="col-sm-2">
					@if (isset($model))
						<input type="checkbox" name="reset_password" id="reset_password"> Reset Password
					@else
						<input type="hidden" name="reset_password" value="on">
					@endif
					</div>
					<div class="col-sm-4" style="font-size: 12px; font-style: italic;">Default password: 'asramaitb'</div>
				</div>
			</form>

		</div>
	</div>
</div>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script>
$(document).ready(function(){
    $('#pengelola_check').on('change', function() {
      if ( this.checked ) {
        $("#asrama_selector").show(600);
      } else {
        $("#asrama_selector").hide(600);
      }
    });
});
</script>
@endsection

@extends('layouts.default')

@section('title','Dashboard')

@section('main_menu')
	@parent

@endsection

@section('header_title','Dashboard | Ganti Username')
@section('content')
<div class="container">
	<br><br>
	<div class="row">
		<div class="col-md-3">
			<!-- MENU DASHBOARD -->
			@include('dashboard.menuDashboard')
		</div>
		<div class="col-md-9">
			<!-- KONTEN UTAMA-->
			<!-- ALERT -->
			@if (session()->has('status1'))
				<div class="alert_fail">
					{{session()->get('status1')}}
				</div> 
			@elseif (session()->has('status2'))
				<div class="alert_success">
					{{session()->get('status2')}}
				</div> 
			@endif <br>
			<div class="row">
				<div class="col-md-4" style="text-align: right;">
					<h3 style="margin-top: 0px;"><b>Ganti Username</b></h3>
				</div>
				<div class="col-md-8">
					<form class="form-horizontal" action="{{route('action_username')}}" method="post">
		                {{ csrf_field() }}
		                <div class="form-group{{ $errors->has('username') ? ' has-error' : '' }}">
						  	 <input id="username" class="input" type="text" name="username" value="{{old('username')}}">
						  	@if ($errors->has('username'))
		                        <span class="help-block">
		                            <strong>{{ $errors->first('username') }}</strong>
		                        </span>
		                    @endif
						</div>
						<button type="submit" class="button">Change</button>
		            </form>
		        </div>
		    </div>
		</div>
	</div>
	<br><br><br>
</div>
@endsection

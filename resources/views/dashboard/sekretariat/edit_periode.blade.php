@extends('layouts.default')

@section('title','Periode Tinggal')

@section('main_menu')
	@parent

@endsection

@section('header_title','Dashboard')
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
			<div id="content">
				<!-- ALERT -->
				@if (session()->has('status1'))
					<div class="alert_fail">
						{{session()->get('status1')}}
					</div> 
				@elseif (session()->has('status2'))
					<div class="alert_success">
						{{session()->get('status2')}}
					</div> 
				@endif
				<h1><b>List Periode Terdaftar</b></h1>
				@if($user->is_sekretariat == '1')
					@if($periode == 1)
						
					@else
						<p>Belum ada periode yang tercatat hingga saat ini.</p>
					@endif
					
				@endif

			</div>
		</div>
	</div>
	<br><br><br>
</div>
@endsection

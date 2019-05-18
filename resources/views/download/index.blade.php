@extends('layouts.default')

@section('title','Download')
@section('menu_dash','active')

@section('main_menu')
	@parent

@endsection

@section('header_title','Penghuni | Download')

@section('content')
<div class="container">
    <br>
	<div class="panel panel-default">
		<div class="panel-heading"><h2> Download File</h2></div>
    <div class="panel-body">
      	<div class="row">
      		<div class="col-md-10">
		        <h3>Surat Kontrak Masuk Asrama </h3>
			</div>
			@if(Auth::user())
				<div class="col-md-2" style="text-align:right; margin-top: 22px">
				<a href="{{route('generate_file_perjanjian')}}"> <button class="btn btn-md btn-primary"> Generate </button> </a>
				</div>
			@endif
		</div>			
        <div class="row">
            <div class="col-md-10">
              <h3>Formulir Penangguhan Pembayaran </h3>
          </div>
          @if(Auth::user())
              <div class="col-md-2" style="text-align:right; margin-top: 22px">
              <a href="{{route('generate_file_penangguhan')}}"> <button class="btn btn-md btn-primary"> Generate </button> </a>
              </div>
          @endif
      </div>			
    </div>
  </div>
</div>
@endsection
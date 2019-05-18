@extends('layouts.default')


@section('title','Home')

@section('main_menu')
	@parent 

@endsection

@section('header_title','Home')
@section('content')
	Diuji
	@if(isset(DormAuth::User()->empty))
	    Ada belum login
	@else
	    Anda sudah login
	@endif
	<form action="{{route ('testMove') }}" method="POST">
		{{ csrf_field() }}
		<button type="submit" class="button">Submit</button>
	</form>
@endsection
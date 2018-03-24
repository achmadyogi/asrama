@extends('layouts.app')

@section('content')
<div class="container">
	<div class="panel panel-default">
		<div class="panel-heading"><h2> Download </h2></div>
    <div class="panel-body">
      @foreach ($downloadable as $item)
      	<div class="row">
      		<div class="col-md-10">
		        <a href="/download/{{$item->id_file}}"> <h3> {{$item->nama_file}} </h3> </a>
			</div>
			@if(Auth::user())
				<div class="col-md-2" style="text-align:right; margin-top: 22px">
				<a href="/download/{{$item->id_file}}/form"> <button class="btn btn-md btn-primary"> Generate </button> </a>
				</div>
			@endif
		</div>			
		<p> {{$item->deskripsi}} </p>
      @endforeach
    </div>
  </div>
</div>
@endsection

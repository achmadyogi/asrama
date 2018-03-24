@extends('layouts.app')

@section('content')
<div class="container">
	<div class="panel panel-default">
		<div class="panel-heading">
			<h2>Selamat datang di Website UPT Asrama ITB!</h2>
		</div>
		<div class="panel-body">
			<div class="panel panel-default col-md-6">
				<div class="panel-heading"><h3>Berita Terkini</h3></div>
				<div class="panel-body">
					@if (count($berita) == 0)
						<h5> Belum ada berita saat ini. </h5>
					@else
						@foreach ($berita as $item)
						<div class="panel panel-info">
				            <div class="panel-heading">
				              <div class="col-sm-6"><h5>{{ date_format($item->updated_at,"l, d M Y") }}</h5></div>
				              <div class="col-sm-6" style="text-align: right;"><h5>{{ date_format($item->updated_at,"h:m A") }}</h5></div>
				              <h3>{{$item->title}}</h3>
				            </div>
				            <div class="panel-body">
				              {!! $item->isi !!}
							</div>
						</div>
						@endforeach;
					@endif
				</div>
			</div>
			<div class="panel panel-default col-md-6">
				<div class="panel-heading"><h3>Pengumuman</h3></div>
				<div class="panel-body">
					@if (count($pengumuman) == 0)
						<h5> Belum ada pengumuman saat ini. </h5>
					@else
						@foreach ($pengumuman as $item)
						<div class="panel panel-info">
				            <div class="panel-heading">
				              <div class="col-sm-6"><h5>{{ date_format($item->updated_at,"l, d M Y") }}</h5></div>
				              <div class="col-sm-6" style="text-align: right;"><h5>{{ date_format($item->updated_at,"h:m A") }}</h5></div>
				              <h3>{{$item->title}}</h3>
				            </div>
				            <div class="panel-body">
				              {!! $item->isi !!}
							</div>
						</div>
						@endforeach;
					@endif
				</div>
			</div>
			
			
		</div>
	</div>
</div>
@endsection
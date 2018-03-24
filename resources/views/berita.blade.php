@extends('layouts.app')

@section('styling')
  <link href="{{ asset('css/announcement.css') }}" rel="stylesheet">
@endsection

@section('content')
<div class="container">
  <div class="panel panel-default">
      <div class="panel-heading">
        <h2 class="row">
        <div class="col-md-10">Berita</div>

          <div class="col-md-2" style="text-align: right; float:right; display:inline-block;">
            @if ($user and ($user->is_admin == '1' or $user->is_sekretariat == '1'))
              <a class="btn btn-md btn-primary" href="{{ route("adminberita.index") }}"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> Manage Berita</a>
            @else
              <a class="btn btn-md btn-primary" href="{{ route("adminberita.index") }}"><span class="glyphicon glyphicon-inbox" aria-hidden="true"></span> Archived Berita</a>
            @endif
          </div>
        </h2>
      </div>
      <div class="panel-body">
        @if (count ($berita) == 0)
          <h5>Belum ada berita saat ini.</h5>
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
          @endforeach
        @endif
      </div>
  </div>
</div>
@endsection

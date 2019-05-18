@extends('layouts.search')


@section('title','Search')

@section('main_menu')
	@parent

@endsection

@section('header_title','Search')
@section('content')
<style type="text/css">
	.engine:hover{
		text-decoration: underline;
	}
</style>
<div class="container">
	<h1 style="text-align: center;"><b>Halaman Pencarian</b></h1><br><br>
		<form class="form-wrapper cf" method="POST" action="{{ route('search') }}">
			{{ csrf_field() }}
			<input type="text" name="search" placeholder="Telusuri di sini" required>
			<button type="submit">Search</button>
		</form><br>
		<p style="text-align: center;"><i>Silahkan masukkan kata kunci. Gunakan kata kunci lain atau yang lebih sederhana untuk memudahkan pencarian.</i></p><hr>
		<?php $report = 0; ?>
		@if(isset($zonk))
		@elseif($count_p == 0 && $count_b == 0 && $count_d == 0)
		<p>Pencarian tidak ditemukan untuk kategori "{{$search}}". Ganti kata kunci Anda dengan kata yang lebih sederhana.</p>
		@elseif($count_p != 0)
			<?php $report = 1 ?>
			<h2><b>Hasil Pencarian Untuk "{{$search}}"</b></h2><br>
			@for($a = 0; $a < $count_p; $a++)
			<a href="pengumuman/{{$id_pengumuman[$a]}}" class="engine"><h4 style="color: #0B75AF; margin: 0px;"><b>{{$judul_p[$a]}}</b></h4></a>
			<div class="row">
				<div class="col-md-7">
					<p>
					<?php
						echo substr($konten_p[$a],0,150).'...';
					?>
					</p><br>
				</div>
				<div class="col-md-5">
				</div>
			</div>
			@endfor
		@elseif($count_b != 0)
			@if($report != 1)
				<h2><b>Hasil Pencarian Untuk "{{$search}}"</b></h2><br>
			@endif
			@for($b = 0; $b < $count_b; $b++)
			<a href="berita/{{$id_berita[$b]}}" class="engine"><h4 style="color: #0B75AF; margin: 0px;"><b>{{$judul_b[$b]}}</b></h4></a>
			<div class="row">
				<div class="col-md-7">
					<p>
					<?php
						echo substr($konten_b[$a],0,150).'...';
					?>
					</p><br>
				</div>
				<div class="col-md-5">
				</div>
			</div>
			@endfor
		@elseif($count_d != 0)
			@if($report != 1)
				<h2><b>Hasil Pencarian Untuk "{{$search}}"</b></h2><br>
			@endif
			@for($c = 0; $c < $count_d; $c++)
			<a href="berita/{{$id_file[$c]}}" class="engine"><h4 style="color: #0B75AF; margin: 0px;"><b>{{$judul_d[$c]}}</b></h4></a>
			<div class="row">
				<div class="col-md-7">
					<p>
					<?php
						echo substr($konten_d[$c],0,150).'...';
					?>
					</p><br>
				</div>
				<div class="col-md-5">
				</div>
			</div>
			@endfor
		@endif
		<br><br><br><br><br><br>
</div>
@endsection
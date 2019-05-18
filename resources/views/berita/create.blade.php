@extends('layouts.default')

@section('title','Periode Tinggal')
@section('menu_dash','active')

@section('main_menu')
	@parent

@endsection

@section('header_title','Admin | Buat Berita')
@section('content')

<div class="container">
	<br><br>
	<div class="row">
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

				
				<div class="sider">
                    <div style="margin-top: 0px; height: 4px; background-color: #0769B0; border-top-left-radius: 3px; border-top-right-radius: 3px;"></div>
					<div class="sider_body" style="background-color: white; padding: 10px 15px 10px 15px;">
                        <h3><b>Form Post Berita Baru</b></h3><hr>
						<form action="{{ route('tambah_berita') }}" method="post" enctype="multipart/form-data">
   						 {{csrf_field()}}
    						<div class="form-group {{ $errors->has('title') ? 'has-error' : '' }}">
        						<label for="title" class="control-label">Judul</label>
        						<input type="text" class="form-control" name="title" placeholder="Title">
        							@if ($errors->has('title'))
            							<span class="help-block">{{ $errors->first('title') }}</span>
       								@endif
    						</div>

    						<div class="form-group {{ $errors->has('konten') ? 'has-error' : '' }}">
        						<label for="konten" class="control-label">Konten</label>
        						<script src ="ckeditor/ckeditor.js"></script>
        						<textarea id="konten" name="konten" cols="30" rows="5" class="form-control"placeholder="Content" required><?php echo old ('content');?>masukan text</textarea>
        						<script type="text/javascript">  
  									CKEDITOR.replace( 'konten' );
  									  
 								</script>
        							@if ($errors->has('konten'))
            							<span class="help-block">{{ $errors->first('konten') }}</span>
       							 	@endif
							</div>
							
							<div class="form-group {{ $errors->has('image') ? 'has-error' : '' }}">
								<label for="image" class="control-label">Upload Gambar</label>
								<input type="file" name = "image" id= "image" placeholder="Upload Gambar"/>
								@if ($errors->has('image'))
									<span class="help-block">{{ $errors->first('image') }}</span>
								@endif
							</div>

    						{{-- <form action="{{ route('file.upload') }}" method="post" enctype="multipart/form-data">
                       			 {{ csrf_field() }}
                      			  {{ method_field('post') }}
                      		 --}}
    						<div class="form-group">
        						<button type="submit" class="btn btn-info">Simpan</button>
       							<a href="{{ route('dashboard') }}" class="btn btn-default">Kembali</a>
   					 		</div>
						</form>
					</div>

					<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
					<script src="http://malsup.github.com/jquery.form.js"></script>
					<script type="text/javascript">
  						$("body").on("click",".upload-image",function(e){
    						$(this).parents("form").ajaxForm(options);
  						});

  					
					</script>
				</div>
			</div><br><br>
		</div>
		<div class="col-md-3">
			<!-- MENU DASHBOARD -->
			@include('dashboard.menuDashboard')
		</div>
	</div>
	<br><br><br>
</div>
@endsection

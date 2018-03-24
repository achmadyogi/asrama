@extends('layouts.app')

@section('content')

<div class="container">
  <div class="col-md-10 col-md-offset-1">
  <div class="panel panel-default">
      <div class="panel-heading">
          <h2>
              @if (isset($model))
                Modify Pengumuman
              @else
                New Pengumuman
              @endif
          </h2>
      </div>

      <div class="panel-body">

          <form action="{{ url('/adminpengumuman'.( isset($model) ? "/" . $model->id : "")) }}" method="POST" class="form-horizontal">
              {{ csrf_field() }}

              @if (isset($model))
                  <input type="hidden" name="_method" value="PUT">
              @endif
              <div class="form-group">
                  <div class="col-md-7">
                      <input type="hidden" name="id" id="id" class="form-control" value="{{$model['id_pengumuman'] or ''}}" readonly="readonly">
                  </div>
              </div>

              <div class="form-group">
                  <label for="title" class="col-md-2 control-label">Title</label>
                  <div class="col-md-9">
                      <input type="text" name="title" id="title" pattern="{50}" title="Title length mush" class="form-control" value="{{$model['title'] or ''}}" required>
                  </div>
              </div>

              <div class="form-group">
                  <label for="isi" class="col-md-2 control-label">Isi</label>
                  <div class="col-md-9">
                    <textarea name="isi" class="form-control" style="resize:none" width="10">{{ $model['isi'] or '' }}</textarea>
                  </div>
              </div>

              <div class="form-group">
                  <div class="col-md-offset-2 col-md-6">

                      <a class="btn btn-default" href="{{ url('/adminpengumuman') }}"><i class="glyphicon glyphicon-chevron-left"></i> Back</a> 
                      <button type="submit" class="btn btn-success">
                          <i class="fa fa-plus"></i> Save
                      </button>
                  </div>
              </div>
          </form>

      </div>
  </div>
  </div>
</div>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
<script>
 var route_prefix = "{{ url(config('lfm.prefix')) }}";
</script>

<!-- TinyMCE init -->
<script src="//cdn.tinymce.com/4/tinymce.min.js"></script>
<script>
  var editor_config = {
    path_absolute : "",
    selector: "textarea[name=isi]",
    plugins: [
      "link image"
    ],
    relative_urls: false,
    height: 129,
    file_browser_callback : function(field_name, url, type, win) {
      var x = window.innerWidth || document.documentElement.clientWidth || document.getElementsByTagName('body')[0].clientWidth;
      var y = window.innerHeight|| document.documentElement.clientHeight|| document.getElementsByTagName('body')[0].clientHeight;

      var cmsURL = editor_config.path_absolute + route_prefix + '?field_name=' + field_name;
      if (type == 'image') {
        cmsURL = cmsURL + "&type=Images";
      } else {
        cmsURL = cmsURL + "&type=Files";
      }

      tinyMCE.activeEditor.windowManager.open({
        file : cmsURL,
        title : 'Filemanager',
        width : x * 0.8,
        height : y * 0.8,
        resizable : "yes",
        close_previous : "no"
      });
    }
  };

  tinymce.init(editor_config);
</script>

<script>
  {!! \File::get(base_path('vendor/unisharp/laravel-filemanager/public/js/lfm.js')) !!}
</script>




@endsection

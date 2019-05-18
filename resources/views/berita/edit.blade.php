@extends('layouts.app')

@section('content')
<h4>Ubah Artikel</h4>
<form action="{{ route('article.update', $article->id) }}" method="post">
    {{csrf_field()}}
    {{ method_field('PUT') }}
    <div class="form-group {{ $errors->has('title') ? 'has-error' : '' }}">
        <label for="title" class="control-label">Title</label>
        <input type="text" class="form-control" name="title" placeholder="Title" value="{{ $article->title }}">
        @if ($errors->has('title'))
            <span class="help-block">{{ $errors->first('title') }}</span>
        @endif
    </div>
    <div class="form-group {{ $errors->has('content') ? 'has-error' : '' }}">
        <label for="content" class="control-label">Content</label>
        <textarea name="content" cols="30" rows="5" class="form-control">{{ $article->content }}</textarea>
        @if ($errors->has('content'))
            <span class="help-block">{{ $errors->first('content') }}</span>
        @endif
    </div>
    <div class="form-group">
        <button type="submit" class="btn btn-info">Simpan</button>
        <a href="{{ route('article.index') }}" class="btn btn-default">Kembali</a>
    </div>
</form>
@endsection
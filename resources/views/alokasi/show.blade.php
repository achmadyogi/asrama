@extends('crudgenerator::layouts.master')

@section('content')



<h2 class="page-header">Alokasi</h2>

<div class="panel panel-default">
    <div class="panel-heading">
        View Alokasi    </div>

    <div class="panel-body">
                

        <form action="{{ url('/alokasis') }}" method="POST" class="form-horizontal">


                
        <div class="form-group">
            <label for="id" class="col-sm-3 control-label">Id</label>
            <div class="col-sm-6">
                <input type="text" name="id" id="id" class="form-control" value="{{$model['id'] or ''}}" readonly="readonly">
            </div>
        </div>
        
                
        <div class="form-group">
            <label for="a" class="col-sm-3 control-label">A</label>
            <div class="col-sm-6">
                <input type="text" name="a" id="a" class="form-control" value="{{$model['a'] or ''}}" readonly="readonly">
            </div>
        </div>
        
                
        <div class="form-group">
            <label for="s" class="col-sm-3 control-label">S</label>
            <div class="col-sm-6">
                <input type="text" name="s" id="s" class="form-control" value="{{$model['s'] or ''}}" readonly="readonly">
            </div>
        </div>
        
                
        <div class="form-group">
            <label for="d" class="col-sm-3 control-label">D</label>
            <div class="col-sm-6">
                <input type="text" name="d" id="d" class="form-control" value="{{$model['d'] or ''}}" readonly="readonly">
            </div>
        </div>
        
        
        <div class="form-group">
            <div class="col-sm-offset-3 col-sm-6">
                <a class="btn btn-default" href="{{ url('/alokasis') }}"><i class="glyphicon glyphicon-chevron-left"></i> Back</a>
            </div>
        </div>


        </form>

    </div>
</div>







@endsection
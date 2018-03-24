@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">
                @if ($allow_edit)
                    <h2>My Profile</h2>
                @else
                    <h2>View Profile</h2>
                @endif
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-4">
                            @if ($allow_edit)
                            <img src="{{ url('/img/guest.png') }}" style="width: 80%; margin: 5px;" />
                            @else
                            <img src="{{ url('/img/guest.png') }}" style="width: 80%; margin: 5px;" />
                            @endif
                        </div>
                        <div class="col-md-8">
                            <div class="row">
                                <div class="col-md-3"><h4>ID User</h4></div>
                                <div class="col-md-8 col-md-offset-1"><h4><strong>#{{ $selected_user->id }}</strong></h4></div>
                            </div>
                            <div class="row">
                                <div class="col-md-3"><h4>Username</h4></div>
                                <div class="col-md-8 col-md-offset-1"><h4><strong>{{ $selected_user->username }}</strong></h4></div>
                            </div>
                            <div class="row">
                                <div class="col-md-3"><h4>Nama</h4></div>
                                <div class="col-md-8 col-md-offset-1"><h4><strong>{{ $selected_user->nama }}</strong></h4></div>
                            </div>
                            <div class="row">
                                <div class="col-md-3"><h4>Email</h4></div>
                                <div class="col-md-8 col-md-offset-1"><h4><strong>{{ $selected_user->email }}</strong></h4></div>
                            </div>
                        </div>
                    </div>
                    @if ($allow_edit)
                    <div class="row">
                        <div class="col-md-4"></div>
                        <button type="submit" class="btn btn-success col-md-2" style="margin: 5px;" onclick="window.location='{{ route("managenim") }}'">
                            <span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span> Manage NIM
                        </button>
                        <button type="submit" class="btn btn-warning col-md-2" style="margin: 5px;" onclick="window.location='{{ route("editprofile") }}'">
                            <span class="glyphicon glyphicon-user" aria-hidden="true"></span> Edit Profile
                        </button>
                        <button type="submit" class="btn btn-primary col-md-3" style="margin: 5px;" onclick="window.location='{{ route("edit_penghuni_info") }}'">
                            <span class="glyphicon glyphicon-paperclip" aria-hidden="true"></span> Edit Data Penghuni
                        </button>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

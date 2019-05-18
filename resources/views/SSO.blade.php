@foreach($user as $u)
	{{$u->name}}<br>
	{{$u->ITBmail}}<br>
	{{$u->email}}<br>
@endforeach
{{DormAuth::User()->username}}
<a href="{{route('SSOLogout')}}">Logout</a>
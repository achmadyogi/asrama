<!-- SIDER MENU DASHBOARD-->
<div class="sider">
    <div class="sider_header">
        <h4><b><span class="fa fa-address-card"></span> List Berita</b></h4>
    </div>
    @foreach($list_berita as $berita)
    <div class="sider_body">
        <a href="{{url('/berita')}}/{{$berita->id_berita}}">
            <b><span class="fa fa-user"></span> {{$berita->title}}</b><br>
        </a>
    </div>
    @endforeach
</div>
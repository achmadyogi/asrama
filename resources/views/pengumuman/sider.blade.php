<!-- SIDER MENU DASHBOARD-->
<div class="sider">
    <div class="sider_header">
        <h4><b><span class="fa fa-bullhorn"></span> List Pengumuman</b></h4>
    </div>
    @foreach($list_pengumuman as $pengumuman)
    <div class="sider_body">
        <a href="{{url('/pengumuman')}}/{{$pengumuman->id_pengumuman}}">
            <b>{{$pengumuman->title}}</b><br>
        </a>
    </div>
    @endforeach
</div>
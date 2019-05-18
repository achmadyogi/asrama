<!-- SIDER MENU DASHBOARD-->
<div class="sider" style="background-color: white; border: 1px solid #C9C9C9; border-top: none; border-top-right-radius: 3px; border-top-left-radius: 3px;">
    <div style="margin-top: 0px; height: 4px; background-color: #0769B0; border-top-left-radius: 3px; border-top-right-radius: 3px;"></div>
    <div class="sider_header" style="background-color: white; border-radius: 0px; color: black">
        <h4><b><span class="fa fa-bullhorn"></span> @if(session()->has('en')) News List @else Daftar Berita @endif</b></h4>
    </div>
    <div style=" padding: 10px 5px 10px 5px;">
    <table class="table">
    @foreach($list_berita as $berita)
        <tr><td><a href="{{url('/berita')}}/{{$berita->id_berita}}">
            <b>{{$berita->title}}</b><br></a>
            <small>{{ITBdorm::DateTime($berita->updated_at)}}</small><br>
            <?php echo substr($berita->isi,0,50).'...'; ?>
        </td></tr>
    @endforeach
    </table></div>
    <div style="text-align: center;"> 
        {{ $list_berita->links() }}
    </div>
</div><br>
@extends('layouts.default')


@section('title','Informasi | Peta')

@section('menu_informasi','active')
@section('main_menu')
    @parent
    <div class="atas" id="atas" style="font-size: 14px;">
    <div class="sub_menu">
    <div class="container">
    <button id="dir_down" style="border: none; background-color: transparent;"><b><i class="fa fa-angle-down" style="font-size: 24px;"></i></b></button>
    <button id="dir_up" style="border: none; background-color: transparent;"><b><i class="fa fa-angle-up" style="font-size: 24px;"></i></b></button>
        <ul class="sub_dir">
            <li class="sub_dir_list"><a href="{{url('/informasi/pendaftaran')}}">Pendaftaran</a></li>
            <li class="sub_dir_list"><a href="{{url('/berita')}}">Berita</a></li>
            <li class="sub_dir_list"><a href="{{url('/pengumuman')}}">Pengumuman</a></li>
            <li class="sub_dir_list" id="active"><a href="{{ route('peta') }}">Peta</a></li>
        </ul>
    </div>
    </div>
    </div>
<div id="smoother" class="smoother" style="height: 40px;">
    
</div>
<style>
    .atas{
        position: fixed;
        top: 60px;
        left: 0;
        z-index: 999;
        width: 100%;
    }
    .smoother{
        display: none;
    }
</style>
<script type="text/javascript">
    $(document).ready(function() {
        var atas = 70;
        var j = 1;
        $("#icon").click(function(){
            j += 1;
            if(j%2==0){
                atas = 70;
            }else{
                atas = 300;
            }
        });
        $('#atas').removeClass('atas');
        $('#dir_down').click(function(){
            $('#dir_down').hide(500);
            $('#dir_up').show(500);
            $(".sub_dir").show(500);
            $("#smoother").css("height","170");
        });
        $('#dir_up').click(function(){
            $('#dir_down').show(500);
            $('#dir_up').hide(500);
            $(".sub_dir").hide(500);
            $("#smoother").css("height","40");
        });
        $(window).on('scroll', function () {
            if (atas <= $(window).scrollTop()) {
                // if so, add the fixed class
                $('#atas').addClass('atas');
                $('#smoother').removeClass('smoother');
            } else {
                // otherwise remove it
                $('#atas').removeClass('atas');
                $('#smoother').addClass('smoother');
            }
        })
    });
</script>
@endsection

@section('header_title','Informasi | Peta')

@section('content')
<div class="container">
    <br><br>
    <div id='mapid' style='width: 100%; height: 500px; border-radius: 5px; border: 2px solid black; z-index: 0;'></div>
    <script>
    var mymap = L.map('mapid').setView([-6.878158, 107.614803], 16);
    L.tileLayer('https://api.tiles.mapbox.com/v4/{id}/{z}/{x}/{y}.png?access_token={accessToken}', {
        attribution: 'Map data &copy; <a href="http://openstreetmap.org">OpenStreetMap</a> contributors, <a href="http://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, Imagery © <a href="http://mapbox.com">Mapbox</a>',
        maxZoom: 18,
        id: 'mapbox.streets',
        accessToken: 'pk.eyJ1IjoiYWNobWFkeW9naSIsImEiOiJjamdxZHlobmQwdXU0MzFsa2t3Z2k4dmV3In0.K2Ri-W53I7_etKnOo5Fy0Q'
    }).addTo(mymap);
    var popup = L.popup();
    </script>
    @foreach($asrama as $asr)
    <script type="text/javascript">
        var marker{{$asr->id_asrama}} = L.marker([{{$asr->latitude}}, {{$asr->longitude}}]).addTo(mymap);
        marker{{$asr->id_asrama}}.bindPopup("<b>{{$asr->nama}}</b>").closePopup();
    </script>
    @endforeach
    <script type="text/javascript">
    function onMapClick(e) {
        popup
            .setLatLng(e.latlng)
            .setContent("You clicked the map at " + e.latlng.toString())
            .openOn(mymap);
    }

    mymap.on('click', onMapClick);
    </script>
    <br><br>
</div>
@endsection
@extends('layouts.default')


@section('title','Informasi | FAQ')

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
            <li class="sub_dir_list"><a href="{{ route('peta') }}">Peta</a></li>
            <li class="sub_dir_list" id="active"><a href="{{ route('peta') }}">FAQ</a></li>
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
    <h3><b>Frequently Asked Question (FAQ)</b></h3>
    <hr>
    <p>Mohon maaf, FAQ belum tersedia.</p>
    <br><br>
</div>
@endsection
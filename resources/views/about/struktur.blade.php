@extends('layouts.default')


@section('title','Tentang | Struktur Organisasi')

@section('menu_tentang','active')
@section('main_menu')
    @parent
    <div class="atas" id="atas" style="font-size: 14px;">
    <div class="sub_menu">
    <div class="container">
    <button id="dir_down" style="border: none; background-color: transparent;"><b><i class="fa fa-angle-down" style="font-size: 24px;"></i></b></button>
    <button id="dir_up" style="border: none; background-color: transparent;"><b><i class="fa fa-angle-up" style="font-size: 24px;"></i></b></button>
        <ul class="sub_dir">
            <li class="sub_dir_list"><a href="/about">Gambaran Umum</a></li>
            <li class="sub_dir_list" id="active"><a href="/about/struktur_organisasi">Struktur Organisasi</a></li>
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

@section('header_title','Tentang | Struktur Organisasi')

@section('content')
<div class="container">
    <h1><b>Struktur Organisasi UPT Asrama ITB</b></h1><hr>
    <p style="text-align: justify;">Struktur organisasi adalah susunan komponen-komponen (unit-unit kerja) dalam organisasi. Struktur organisasi menunjukkan adanya pembagian kerja dan menunjukkan bagaimana fungsi-fungsi atau kegiatan-kegiatan yang berbeda-beda tersebut diintegrasikan (koordinasi). Selain daripada itu struktur organisasi juga menunjukkan spesialisasi-spesialisasi pekerjaan, saluran perintah dan penyampaian laporan.<br><br>
    Struktur Organisasi dapat didefinisikan sebagai mekanisme-mekanisme formal organisasi diolah. Struktur organisasi terdiri atas unsur spesialisasi kerja, standarisasi, koordinasi, sentralisasi atau desentralisasi dalam pembuatan keputusan dan ukuran satuan kerja.
    Berikut ini adalah struktur organisasi UPT Asrama ITB secara Umum.</p><br>
    <style type="text/css">
        /*Now the CSS*/

        .tree ul {
            padding-top: 20px; position: relative;
            
            transition: all 0.5s;
            -webkit-transition: all 0.5s;
            -moz-transition: all 0.5s;
        }

        .tree li {
            float: left; text-align: center;
            list-style-type: none;
            position: relative;
            padding: 20px 5px 0 5px;
            
            transition: all 0.5s;
            -webkit-transition: all 0.5s;
            -moz-transition: all 0.5s;
        }

        /*We will use ::before and ::after to draw the connectors*/

        .tree li::before, .tree li::after{
            content: '';
            position: absolute; top: 0; right: 50%;
            border-top: 1px solid #ccc;
            width: 50%; height: 20px;
        }
        .tree li::after{
            right: auto; left: 50%;
            border-left: 1px solid #ccc;
        }

        /*We need to remove left-right connectors from elements without 
        any siblings*/
        .tree li:only-child::after, .tree li:only-child::before {
            display: none;
        }

        /*Remove space from the top of single children*/
        .tree li:only-child{ padding-top: 0;}

        /*Remove left connector from first child and 
        right connector from last child*/
        .tree li:first-child::before, .tree li:last-child::after{
            border: 0 none;
        }
        /*Adding back the vertical connector to the last nodes*/
        .tree li:last-child::before{
            border-right: 1px solid #ccc;
            border-radius: 0 5px 0 0;
            -webkit-border-radius: 0 5px 0 0;
            -moz-border-radius: 0 5px 0 0;
        }
        .tree li:first-child::after{
            border-radius: 5px 0 0 0;
            -webkit-border-radius: 5px 0 0 0;
            -moz-border-radius: 5px 0 0 0;
        }

        /*Time to add downward connectors from parents*/
        .tree ul ul::before{
            content: '';
            position: absolute; top: 0; left: 50%;
            border-left: 1px solid #ccc;
            width: 0; height: 20px;
        }

        .tree li a{
            border: 1px solid #ccc;
            padding: 5px 10px;
            text-decoration: none;
            color: #666;
            font-family: arial, verdana, tahoma;
            font-size: 11px;
            display: inline-block;
            
            border-radius: 5px;
            -webkit-border-radius: 5px;
            -moz-border-radius: 5px;
            
            transition: all 0.5s;
            -webkit-transition: all 0.5s;
            -moz-transition: all 0.5s;
        }

        /*Time for some hover effects*/
        /*We will apply the hover effect the the lineage of the element also*/
        .tree li a:hover, .tree li a:hover+ul li a {
            background: #c8e4f8; color: #000; border: 1px solid #94a0b4;
        }
        /*Connector styles on hover*/
        .tree li a:hover+ul li::after, 
        .tree li a:hover+ul li::before, 
        .tree li a:hover+ul::before, 
        .tree li a:hover+ul ul::before{
            border-color:  #94a0b4;
        }

        /*Thats all. I hope you enjoyed it.
        Thanks :)*/
    </style>
    <div style="overflow-x: auto; text-align: center;">
        <div class="tree" style="width: 1000px;">
            <ul>
                <li>
                    <a href="#" >Kepala UPT <br>Asrama ITB</a>
                    <ul>
                        <li><a href="#" >Kepala Sekretariat</a></li>
                        <li>
                            <ul>
                                <li><a href="#" >Kepala Bidang<br> Urusan Jatinangor</a></li>
                                <li><a href="#" >Kepala Bidang<br> Perencanaan dan Monitoring</a></li>
                                <li><a href="#" >Kepala Bidang<br> Operasional</a></li>
                                <li><a href="#" >Kepala Bidang<br> Managemen dan Sistem Informasi</a></li>
                            </ul>
                        </li>
                    </ul>
                </li>
            </ul>
        </div><br>
    </div><br><br><br><br>
    <div class="row">
        <div class="col-md-6">
            <div class="media">
                <div class="media-left">
                    <img src="{{ asset('img/tentang/agung.jpg') }}" alt="agung" width="100px"><br><br>
                </div>
                <div class="media-body">
                    <p><b>Kepala UPT Asrama ITB</b><br>
                        <span style="display: inline-block; width: 100px;">Nama</span>: Dr. Ir. Agung Wiyono Hadi Soeharno, MS, M.Eng.<br>
                        <span style="display: inline-block; width: 100px;">Email</span>: ag.wiyono@yahoo.com<br>
                    </p>
                </div>
            </div>
            <div class="media">
                <div class="media-left">
                    <img src="{{ asset('img/tentang/dadan.jpg') }}" alt="agung" width="100px"><br><br>
                </div>
                <div class="media-body">
                    <p><b>Kepala Bidang Perencanaan dan Monitoring</b><br>
                        <span style="display: inline-block; width: 100px;">Nama</span>: Dr. Eng. Raden Dadan Ramdan, ST.<br>
                        <span style="display: inline-block; width: 100px;">Email</span>: dadan@material.itb.ac.id<br>
                    </p>
                </div>
            </div>
            <div class="media">
                <div class="media-left">
                    <img src="{{ asset('img/tentang/trides.jpg') }}" alt="agung" width="100px"><br><br>
                </div>
                <div class="media-body">
                    <p><b>Kepala Bidang Urusan Jatinangor</b><br>
                        <span style="display: inline-block; width: 100px;">Nama</span>: Dr. Tri Desmana Rachmildha ST, MT.<br>
                        <span style="display: inline-block; width: 100px;">Email</span>: trides@gmail.com<br>
                    </p>
                </div>
            </div>       
        </div>
        <div class="col-md-6">
            <div class="media">
                <div class="media-left">
                    <img src="{{ asset('img/tentang/pak_rena.jpg') }}" alt="agung" width="100px"><br><br>
                </div>
                <div class="media-body">
                    <p><b>Kepala Bidang Operasional</b><br>
                        <span style="display: inline-block; width: 100px;">Nama</span>: Rena Muhammad Tohirin, S.Si, MT.<br>
                        <span style="display: inline-block; width: 100px;">Email</span>: rena@staff.itb.ac.id<br>
                    </p>
                </div>
            </div>
            <div class="media">
                <div class="media-left">
                    <img src="{{ asset('img/tentang/Fazat1.jpg') }}" alt="agung" width="100px"><br><br>
                </div>
                <div class="media-body">
                    <p><b>Kepala Bidang Manajemen dan Sistem Informasi</b><br>
                        <span style="display: inline-block; width: 100px;">Nama</span>: Dr. Fazat Nur Azizah ST, M.Sc.<br>
                        <span style="display: inline-block; width: 100px;">Email</span>: fazat@informatika.org<br>
                    </p>
                </div>
            </div>      
        </div>
    </div>
</div>
<br><br>
@endsection
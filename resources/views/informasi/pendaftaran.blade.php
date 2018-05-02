@extends('layouts.default')


@section('title','Informasi | Pendaftaran')

@section('menu_informasi','active')
@section('main_menu')
    @parent
    <div class="atas" id="atas" style="font-size: 14px;">
    <div class="sub_menu">
    <div class="container">
    <button id="dir_down" style="border: none; background-color: transparent;"><b><i class="fa fa-angle-down" style="font-size: 24px;"></i></b></button>
    <button id="dir_up" style="border: none; background-color: transparent;"><b><i class="fa fa-angle-up" style="font-size: 24px;"></i></b></button>
        <ul class="sub_dir">
            <li class="sub_dir_list" id="active"><a href="/informasi/pendaftaran">Pendaftaran</a></li>
            <li class="sub_dir_list"><a href="#">Fasilitas</a></li>
            <li class="sub_dir_list"><a href="#">Peta</a></li>
            <li class="sub_dir_list"><a href="#">Hubungi Kami</a></li>
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

@section('header_title','Informasi | Pendaftaran')

@section('content')
<div class="container">
    <h1><b>Pendaftaran Penghuni UPT Asrama ITB</b></h1><hr>
    <p style="text-align: justify;">Tinggal di asrama dapat memberikan kesan tersendiri bagi mahasiswa saat proses akademik berlangsung. Untuk itu Asrama ITB hadir dengan berbagai pilihan kebetuhuan tinggal yang sudah disesuaikan dengan ketersediaan fasilitas yang memadai. Berikut ini adalah kategori entitas yang dapat bergabung untuk tinggal di asrama.<br>
        <b>PENGHUNI REGULER</b><br>
        Penghuni reguler adalah penghuni dengan status mahasiswa ITB. Seorang penghuni reguler hanya dapat mendaftar pada periode tertentu yang waktunya telah ditetapkan oleh pihak asrama. Pendaftaran penghuni reguler secara umum dilakukan ketika tahun ajaran baru atau semester baru, namun tidak menutup kemungkinan untuk masih bisa melakukan pendaftaran ditengah-tengahnya apabila terdapat kondisi khusus dengan menghubungi petugas kami terlebih dahulu.<br>
        <b>PENGHUNI NON REGULER</b><br>
        Penghuni Non Reguler terbuka bagi siapa saja yang ingin mendaftar ke asrama. Penghuni Non Reguler dapat menetapkan tanggal masuk dan tanggal keluar dari asrama sesuai keperluan tinggal. Karena persediaan kamar yang terbatas, penghuni non reguler akan diperioritaskan untuk segala entitas yang masih berkecimpung dengan akademik di ITB atau keperluan pendidikan mengingat asrama bukanlah tempat penginapan umum atau hotel yang dirancang untuk bisnis.
    </p><br>
    <h2><b>Biaya Tinggal</b></h2>
    <p>Berikut ini adalah list biaya tinggal di asrama sesuai dengan Surat Keputusan Rektor Institut Teknologi Bandung Nomor SK/11.B01/PP/2017.</p>
    <div class="table">
        <table>
            <tr>
                <th>Nama Asrama</th>
                <th>Kapasitas Kamar</th>
                <th>Tempo Tinggal</th>
                <th>Tarif Sarjana</th>
                <th>Tarif Pascasarjana</th>
                <th>Tarif Internasional</th>
                <th>Tarif Umum</th>
            </tr>
            @foreach($tarif as $bayar)
            <tr>
                <td>{{$bayar->nama}}</td>
                <td style="text-align: center;">{{$bayar->kapasitas_kamar}}</td>
                <td style="text-align: center;">{{$bayar->tempo}}</td>
                @if($bayar->tarif_sarjana != NULL)
                    @if(strlen($bayar->tarif_sarjana) == 6)
                        <td>Rp<?php echo substr($bayar->tarif_sarjana, -6, 3).".".substr($bayar->tarif_sarjana, -3).",00"; ?></td>
                    @elseif(strlen($bayar->tarif_sarjana) == 5)
                        <td>Rp<?php echo substr($bayar->tarif_sarjana, -6, 2).".".substr($bayar->tarif_sarjana, -3).",00"; ?></td>
                    @endif
                @else
                    <td>-</td>
                @endif
                @if($bayar->tarif_pasca_sarjana != NULL)
                    @if(strlen($bayar->tarif_pasca_sarjana) == 6)
                        <td>Rp<?php echo substr($bayar->tarif_pasca_sarjana, -6, 3).".".substr($bayar->tarif_pasca_sarjana, -3).",00"; ?></td>
                    @elseif(strlen($bayar->tarif_pasca_sarjana) == 5)
                        <td>Rp<?php echo substr($bayar->tarif_pasca_sarjana, -6, 2).".".substr($bayar->tarif_pasca_sarjana, -3).",00"; ?></td>
                    @endif
                @else
                    <td>-</td>
                @endif
                @if($bayar->tarif_international != NULL)
                    @if(strlen($bayar->tarif_international) == 6)
                        <td>Rp<?php echo substr($bayar->tarif_international, -6, 3).".".substr($bayar->tarif_international, -3).",00"; ?></td>
                    @elseif(strlen($bayar->tarif_international) == 5)
                        <td>Rp<?php echo substr($bayar->tarif_international, -6, 2).".".substr($bayar->tarif_international, -3).",00"; ?></td>
                    @endif
                @else
                    <td>-</td>
                @endif
                @if($bayar->tarif_umum != NULL)
                    @if(strlen($bayar->tarif_umum) == 6)
                        <td>Rp<?php echo substr($bayar->tarif_umum, -6, 3).".".substr($bayar->tarif_umum, -3).",00"; ?></td>
                    @elseif(strlen($bayar->tarif_umum) == 5)
                        <td>Rp<?php echo substr($bayar->tarif_umum, -6, 2).".".substr($bayar->tarif_umum, -3).",00"; ?></td>
                    @endif
                @else
                    <td>-</td>
                @endif
            </tr>
            @endforeach
        </table>
    </div>
    <p>Keterangan:
        <ul>
            <li>Biaya tersebut berlaku sesuai dengan jumlah penghuni dalam satu kamar seperti yang telah disebutkan.</li>
            <li>Apabila penghuni baru hendak tinggal sendiri dalam satu kamar, maka biaya akan dilipatkan berdasarkan kapasitas kamar</li>
            <li>Untuk tinggal sementara dengan biaya harian, lama tinggal maksimal adalah 10 hari. Bila lebih dari itu, maka biaya akan berganti menjadi bulanan</li>
            <li>Untuk kolom yang tidak ada harganya, maka pilihan tersebut tidak ada. Namun, harga dapat ditentukan lebih lanjut bila memang sangat diperlukan.</li>
        </ul>
    </p><br>
    <h2><b>Prosedur Pendaftaran</b></h2>
    <p>Untuk bisa bergabung di UPT Asrama ITB, berikut ini adalah prosedur umum yang harus dilakukan. Untuk informasi yang lebih spesifik dapat dilihat di halaman utama untuk memeriksa informasi dan pengumuman terkait pendaftaran yang akan segera digelar khususnya untuk pendaftaran reguler.
        <ol>
            <li>Peserta harus membuat akun asrama terlebih dahulu</li>
            <li>Peserta mengisi kelengkapan data diri detail pada dashboard.</li>
            <li>Peserta memilih kategori pendaftaran penghuni apakah reguler atau non reguler berdasarkan ketersediaan periode pendaftaran yang masih dibuka.</li>
            <li>Peserta mengisi form pendaftaran asrama.</li>
            <li>Setelah seluruh administrasi dilakukan, silahkan lakukan pembayaran terlebih dahulu sebelum proses penerimaan difinalisasi dan penentuan kamar.</li>
            <li>Upload bukti hasil pembayaran bank pada akun Peserta.</li>
            <li>Admin kami akan memeriksa status pembayaran Peserta dan akan menyetujui rencana tinggal yang diajukan.</li>
            <li>Setelah itu, Peserta akan mendapatkan kontrak tinggal dan kamar dan asrama siap untuk dihuni.</li>
            <li>Saat hadir di asrama dan proses check in, Peserta harus menyerahkan bukti fisik pendaftaran yang sudah di upload sebelumnya</li>
        </ol>
    Kebutuhan informasi spesifik akan diketahui saat proses pendaftaran berlangsung. Apabila ditemukan kebingunan, Peserta dapat menghubungi kami dengan media yang telah disediakan.
    </p>
    <br>
    @if($user != '0')
        <div style="text-align: center;">
            <a href="{{ route('pendaftaran_penghuni') }}"><button type="button" class="button">Daftar Sekarang</button></a>
        </div>
    @endif
</div>
<br><br>
@endsection
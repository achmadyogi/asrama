@extends('layouts.default')


@section('title','Tentang | Gambaran Umum')

@section('menu_tentang','active')
@section('main_menu')
    @parent
    <div class="atas" id="atas" style="font-size: 14px;">
    <div class="sub_menu">
    <div class="container">
    <button id="dir_down" style="border: none; background-color: transparent;"><b><i class="fa fa-angle-down" style="font-size: 24px;"></i></b></button>
    <button id="dir_up" style="border: none; background-color: transparent;"><b><i class="fa fa-angle-up" style="font-size: 24px;"></i></b></button>
        <ul class="sub_dir">
            <li class="sub_dir_list" id="active"><a href="/about">Gambaran Umum</a></li>
            <li class="sub_dir_list"><a href="/about/struktur_organisasi">Struktur Organisasi</a></li>
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

@section('header_title','Tentang | Gambaran Umum')

@section('content')
<div style="background-color: white; width: 100%; height: 500px; overflow: hidden;margin-top: 0px; position: relative;">
    <img src="{{ asset('img/tentang/1.5.JPG') }}" style="position: absolute;" class="img_center2" width="100%;" alt="user">
    <div class="container">
        <div style="position: absolute; padding: 10px; color:white; z-index: 10; top: 2%; right: 2%; font-family: Sverige Script; color: black; max-width: 93%; width: 500px; ">
            <h4><b><i>Selamat Menikmati Indahnya Perjuangan...!</i></b></h4>
        </div>
    </div>
</div>
<div class="container">
	<h1><b>Gambaran Umum UPT Asrama ITB</b></h1><hr>
	<p style="text-align: justify;">
    	Berkaca dan belajar dari bangsa-bangsa maju dan mengingat pentingnya pengembangan karakter suatu bangsa, pemerintah memandang penting membangun tonggak dimulainya pembangunan karakter bangsa Indonesia. Pada hari besar pendidikan nasional 11 Mei 2010 presiden republik Indonesia mencanangkan dimulainya pembangunan karakter bangsa Indonesia, dan pendidikan dijadikan ujung tombak wahana pengembangan karakter. Ada empat nilai luhur yang ingin dicapai dalam pendidikan karakter nasional, yaitu membangun generasi manusia Indonesia yang cerdas, jujur, tangguh, dan peduli, sebagai perwujudan dari perilaku berkarakter: olah pikir, olah hati, olah raga, dan olah rasa/karsa. Strategi pembangunan karakter bangsa dilakukan dengan metoda intervensi dan habituasi, yang dibentuk melalui pendidikan formal (akademik, ko-kurikuler, dan ekstra-kurikuler), keluarga dan dalam masyarakat. Institut Teknologi Bandung (ITB) sebagai lembaga pendidikan tinggi mengemban amanat mencerdaskan sumberdaya manusia nasional. Kemampuan dan peran yang diambil oleh para lulusan berakar pada proses pendidikan dan reputasi institusi yang secara sadar dibentuk dan dikembangkan menjadi trend setter pengembangan sumberdaya manusia yang unggul sesuai dengan cita-cita ITB, martabat dan harkat bangsa Indonesia. Namun demikian tuntutan kualitas sumberdaya manusia terus meningkat mengikuti perkembangan dunia global yang bergerak secara cepat dan dinamis. ITB bertanggung jawab untuk selalu mengembangkan dirinya menyediakan sistem pendidikan yang tegar dan wahana pengembangan sumberdaya manusia.
    </p>
    <p style="text-align: justify;">
        Potensi afektif (rasa) mahasiswa tampak kurang mendapat tempat pengembangan sebaik pengembangan potensi kognitif. Oleh karena itu, institusi perlu memfasilitasi adanya wahana dan proses pengembangan diri dalam olah fikir, olah hati, olah rasa dan olah raga secara berkeseimbangan, khususnya pada mahasiswa baru tahun pertama. Wahana dapat diwujudkan dalam bentuk pembelajaran yang sistematis dan integratif, sedemikian sehingga mahasiswa tahun pertama memiliki kesempatan berkembang diri secara seimbang. Penyediaan asrama yang wajib bagi mahasiswa baru bisa jadi salah satu wahana yang dapat dibangun untuk memberikan lingkungan belajar afeksi yang terkondisikan. Program-program pembinaan mahasiswa di asrama utamanya ditujukan untuk mengembangkan potensi afeksi dan motorik mahasiswa melengkapi wahana pembelajaran dan kegiatan di kampus. 
    </p>
    <p style="text-align: justify;">
        Operasional asrama dalam rangka efektifitas kegiatan dalam satu unit telah dimulai dengan dibentuknya satuan tugas (satgas) Asrama ITB melalui SK penetapan Satgas Asrama ITB di tetapkan tahun 2012 dan diperpanjang sampai awal tahun 2014. Dengan dibentuknya UPT Asrama ITB pada awal tahun 2014, segala operasional asrama dan kegiatan terkait baik dari keuangan dan RKA sampai pada pembinaan dikelola oleh UPT Asrama dalam satu pintu. Proses pembinaan karakter mahasiswa ITB di asrama akan dapat terlaksana dengan baik apabila ditopang dengan sarana-prasarana yang memadai, administrasi dan roda organisasi UPT yang bekerja dengan baik, serta komitmen semua pihak dalam keluarga besar ITB dan khususnya dalam keluarga besar UPT asrama terjalin dengan baik dan konsisten. Saat ini berdasarkan kebijakan ITB, mahasiswa yang tinggal saat ini adalah mahasiswa TPB program bidik misi untuk Asrama di wilayah bandung (Kampus Ganesha), mahasiswa internasional di asrama internasional dan mahasiswa yang tinggal diwilayah kampusJjatinangor di asrama Jatinangor. 
    </p style="text-align: justify;">
    <p>
        Bagian ini menjelaskan tentang pelaksanaan dan implementasi RENSTRA UPT Asrama ITB terhitung sejak diterbitkannhya SK Rektor ITB Nomor 024/SK/I1.A/OT/2014 pada Bulan Maret 2014 tentang pembentukan Unit Pelaksanan Teknis Asrama ITB. Penjelasan dituangkan dalam 2 bagian, yaitu penjelasan tentang Visi Misi UPT Asrama ITB dan penjelasan tentang Organisasi, Kepemimpinan, dan Tatakelola UPT Asrama ITB. 
    </p>
    <p>
        <strong>Visi ITB</strong><br/>
        Menjadi Perguruan Tinggi yang unggul, bermartabat, mandiri, dan diakui dunia serta memandu perubahan yang mampu meningkatkan kesejahteraan bangsa Indonesia dan dunia.  
    </p>
    <p>
        <strong>Misi ITB</strong><br/>
        Menciptakan, berbagi dan menerapkan ilmu pengetahuan, teknologi, seni dan kemanusiaan serta menghasilkan sumber daya insani yang unggul untuk menjadikan Indonesia dan dunia lebih baik.
        <br/>
        Dengan mengadopsi visi dan misi Lembaga Kemahasiswaan ITB, maka visi dan misi UPT Asrama ITB adalah sebagai berikut: 
    </p>
    <p>
        <strong>Visi UPT Asrama</strong><br/>
        Menjadi UPT yang memiliki atmosfer yang kondusif bagi pengembangan kreativitas intelektual, mental dan spiritual, minat-bakat serta solidaritas sosial dan kepedulian moral mahasiswa sebagai generasi penerus yang memegang kebenaran ilmiah juga memahami kemajemukan nasional dan internasional. 
    </p>    
    <p>
        <strong>Misi UPT Asrama</strong><br/>
        <ol>
            <li>
                Menyelenggarakan program pembinaan untuk mendukung kegiatan akademik serta potensi minat dan bakat mahasiswa.
            </li>
            <li>
                Menumbuhkan semangat kerjasama dan kompetensi dengan konsep dasar maju bersama.
            </li>
            <li>
                Membentuk mahasiswa baru menjadi pribadi sehat jasmani dan rohani, mandiri, bermoral tinggi, berprestasi.
            </li>
            <li>
                Membentuk mahasiswa yang peka dan mampu beradaptasi dengan lingkungan yang majemuk. 
            </li>
        </ol>
    </p>
</div>
<br><br>
@endsection
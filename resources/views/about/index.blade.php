@extends('layouts.default')

@if(session()->has('en'))
@section('title','About | General Description')
@else
@section('title','Tentang | Gambaran Umum')
@endif

@section('menu_tentang','active')
@section('main_menu')
    @parent
    <div class="atas" id="atas" style="font-size: 14px;">
    <div class="sub_menu">
    <div class="container">
    <button id="dir_down" style="border: none; background-color: transparent;"><b><i class="fa fa-angle-down" style="font-size: 24px;"></i></b></button>
    <button id="dir_up" style="border: none; background-color: transparent;"><b><i class="fa fa-angle-up" style="font-size: 24px;"></i></b></button>
        <ul class="sub_dir">
            <li class="sub_dir_list" id="active"><a href="{{url('/about')}}">@if(session()->has('en')) General Description @else Gambaran Umum @endif</a></li>
            <li class="sub_dir_list"><a href="{{url('/about/struktur_organisasi')}}">@if(session()->has('en')) Organizational Structure @else Struktur Organisasi @endif</a></li>
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

@if(session()->has('en'))
@section('header_title','About | General Description')
@else
@section('header_title','Tentang | Gambaran Umum')
@endif

@section('content')
<div style="background-color: white; width: 100%; height: 500px; overflow: hidden;margin-top: 0px; position: relative;">
    <img src="{{ asset('img/tentang/1.5.JPG') }}" style="position: absolute;" class="img_center2" width="100%;" alt="user">
    <div class="container">
        <div style="position: absolute; padding: 10px; color:white; z-index: 10; top: 2%; right: 2%; font-family: Sverige Script; color: black; max-width: 93%; width: 500px; ">
            <h4><b><i>@if(session()->has('en')) Have a nice buffetings...! @else Selamat Menikmati Indahnya Perjuangan...! @endif</i></b></h4>
        </div>
    </div>
</div>
<div class="container">
	<h1><b>@if(session()->has('en')) General Description of the Dormitory @else Gambaran Umum UPT Asrama ITB @endif</b></h1><hr>
	<p style="text-align: justify;">
        @if(session()->has('en'))
        Contemplating and learning what have been doing by many super powers, the Government of Indonesia looks at the outmost aspect that become a background for many successful people. That is, a brilliant character. Defining a good character is not really an easy task. Proper evaluation and plans for the future must be the bulk to determine an appropriate character that is suitable for the country. The Sixth President of Indonesia, Susilo Bambang Yudhoyono, initialized development of character building when celebrating National Education Day – 11 May 2010. He asserted that characters had to be flowered from education in many different stages. There are four glorious values structured to maximize the nation civilization: smart, honest, sturdy, and care. The strategy for building characters uses intervention and habit that applied around formal education, family, and social environment. Bandung Institute of Technology (ITB) as a higher education plays an important role for creating high quality human resources for the nation. To shape high quality graduates, ITB must follow any global developments, which are fast and challenging. According to the situation, ITB holds responsibility to provide a good academic system as a vehicle for students tailoring their future.
        @else
    	Berkaca dan belajar dari bangsa-bangsa maju dan mengingat pentingnya pengembangan karakter suatu bangsa, pemerintah memandang penting membangun tonggak dimulainya pembangunan karakter bangsa Indonesia. Pada hari besar pendidikan nasional 11 Mei 2010 presiden republik Indonesia mencanangkan dimulainya pembangunan karakter bangsa Indonesia, dan pendidikan dijadikan ujung tombak wahana pengembangan karakter. Ada empat nilai luhur yang ingin dicapai dalam pendidikan karakter nasional, yaitu membangun generasi manusia Indonesia yang cerdas, jujur, tangguh, dan peduli, sebagai perwujudan dari perilaku berkarakter: olah pikir, olah hati, olah raga, dan olah rasa/karsa. Strategi pembangunan karakter bangsa dilakukan dengan metoda intervensi dan habituasi, yang dibentuk melalui pendidikan formal (akademik, ko-kurikuler, dan ekstra-kurikuler), keluarga dan dalam masyarakat. Institut Teknologi Bandung (ITB) sebagai lembaga pendidikan tinggi mengemban amanat mencerdaskan sumberdaya manusia nasional. Kemampuan dan peran yang diambil oleh para lulusan berakar pada proses pendidikan dan reputasi institusi yang secara sadar dibentuk dan dikembangkan menjadi trend setter pengembangan sumberdaya manusia yang unggul sesuai dengan cita-cita ITB, martabat dan harkat bangsa Indonesia. Namun demikian tuntutan kualitas sumberdaya manusia terus meningkat mengikuti perkembangan dunia global yang bergerak secara cepat dan dinamis. ITB bertanggung jawab untuk selalu mengembangkan dirinya menyediakan sistem pendidikan yang tegar dan wahana pengembangan sumberdaya manusia.
        @endif
    </p>
    <p style="text-align: justify;">
        @if(session()->has('en'))
        Education process at university consists of two development criteria: affective and cognitive. ITB facilitates cognitive criteria as its own main business. Affective criteria, however, seems to be unmanageable due to student interests and social environments. Dormitory can be an appropriate idea to situate systematic and integrated learning. As occupant, students are able to grow in balance between academic achievements and social interactions. Nurturing programs at dormitory flourish the student potency to help them solve their difficulties and problems.
        @else
        Potensi afektif (rasa) mahasiswa tampak kurang mendapat tempat pengembangan sebaik pengembangan potensi kognitif. Oleh karena itu, institusi perlu memfasilitasi adanya wahana dan proses pengembangan diri dalam olah fikir, olah hati, olah rasa dan olah raga secara berkeseimbangan, khususnya pada mahasiswa baru tahun pertama. Wahana dapat diwujudkan dalam bentuk pembelajaran yang sistematis dan integratif, sedemikian sehingga mahasiswa tahun pertama memiliki kesempatan berkembang diri secara seimbang. Penyediaan asrama yang wajib bagi mahasiswa baru bisa jadi salah satu wahana yang dapat dibangun untuk memberikan lingkungan belajar afeksi yang terkondisikan. Program-program pembinaan mahasiswa di asrama utamanya ditujukan untuk mengembangkan potensi afeksi dan motorik mahasiswa melengkapi wahana pembelajaran dan kegiatan di kampus.
        @endif 
    </p>
    <p style="text-align: justify;">
        @if(session()->has('en'))
        ITB dormitory became an independent unit under formal decree in 2012 and had the name “UPT Asrama ITB”. Since then, the dormitory have had full control of all operations and funds, but it should bear in mind that the unit is still under integrated structure from campus. Character building for students at the dormitory will strive effectively under convenient facilities, administration, and organization chain that consistently available. According to the policy, dormitories at main campus, Ganesha, are occupied by first year students, and International Dormitory is occupied by diverse people across the globe. Another story for Jatinangor, as its location is inside the campus area with huge capacity, all students who wish to live in can easily sign up as residence.
        @else
        Operasional asrama dalam rangka efektifitas kegiatan dalam satu unit telah dimulai dengan dibentuknya satuan tugas (satgas) Asrama ITB melalui SK penetapan Satgas Asrama ITB di tetapkan tahun 2012 dan diperpanjang sampai awal tahun 2014. Dengan dibentuknya UPT Asrama ITB pada awal tahun 2014, segala operasional asrama dan kegiatan terkait baik dari keuangan dan RKA sampai pada pembinaan dikelola oleh UPT Asrama dalam satu pintu. Proses pembinaan karakter mahasiswa ITB di asrama akan dapat terlaksana dengan baik apabila ditopang dengan sarana-prasarana yang memadai, administrasi dan roda organisasi UPT yang bekerja dengan baik, serta komitmen semua pihak dalam keluarga besar ITB dan khususnya dalam keluarga besar UPT asrama terjalin dengan baik dan konsisten. Saat ini berdasarkan kebijakan ITB, mahasiswa yang tinggal saat ini adalah mahasiswa TPB program bidik misi untuk Asrama di wilayah bandung (Kampus Ganesha), mahasiswa internasional di asrama internasional dan mahasiswa yang tinggal diwilayah kampusJjatinangor di asrama Jatinangor.
        @endif 
    </p style="text-align: justify;">
    <p>
        @if(session()->has('en'))
        This part explains about the execution and implementation of RENSTRA UPT Asrama ITB counted from the publication of ITB Chancellor’s Decree number 024/SK/I1.A/OT/2014 on March 2014 about the formation of Unit Pelaksana Teknis Asrama ITB. 
        @else
        Bagian ini menjelaskan tentang pelaksanaan dan implementasi RENSTRA UPT Asrama ITB terhitung sejak diterbitkannhya SK Rektor ITB Nomor 024/SK/I1.A/OT/2014 pada Bulan Maret 2014 tentang pembentukan Unit Pelaksanan Teknis Asrama ITB. Penjelasan dituangkan dalam 2 bagian, yaitu penjelasan tentang Visi Misi UPT Asrama ITB dan penjelasan tentang Organisasi, Kepemimpinan, dan Tatakelola UPT Asrama ITB.
        @endif
    </p>
    <p>
        @if(session()->has('en'))
        <strong>Vision of the University</strong><br>
        ITB as an outstanding, distinguished, independent, and internationally recognized university that leads changes toward welfare improvement of the Indonesian nation and the world.
        @else
        <strong>Visi ITB</strong><br/>
        Menjadi Perguruan Tinggi yang unggul, bermartabat, mandiri, dan diakui dunia serta memandu perubahan yang mampu meningkatkan kesejahteraan bangsa Indonesia dan dunia.
        @endif  
    </p>
    <p>
        @if(session()->has('en'))
        <strong>Mission of the University</strong><br>
        To innovate, share, and apply science, technology, art and humanity, and to produce excellent human resources for better Indonesia and the world.<br>

        @else
        <strong>Misi ITB</strong><br/>
        Menciptakan, berbagi dan menerapkan ilmu pengetahuan, teknologi, seni dan kemanusiaan serta menghasilkan sumber daya insani yang unggul untuk menjadikan Indonesia dan dunia lebih baik.
        <br/>
        Dengan mengadopsi visi dan misi Lembaga Kemahasiswaan ITB, maka visi dan misi UPT Asrama ITB adalah sebagai berikut:
        @endif 
    </p>
    <p>
        @if(session()->has('en'))
        <strong>Vision of the Dormitory</strong><br>
        Become a community with comfortable atmosphere for the development of creativity, intellect, mentality, spirituality, interest, social solidarity, and moral care as students, in which they are the next future generation that hold scientific truth and realize national and international diversity.
        @else
        <strong>Visi UPT Asrama ITB</strong><br/>
        Menjadi UPT yang memiliki atmosfer yang kondusif bagi pengembangan kreativitas intelektual, mental dan spiritual, minat-bakat serta solidaritas sosial dan kepedulian moral mahasiswa sebagai generasi penerus yang memegang kebenaran ilmiah juga memahami kemajemukan nasional dan internasional.
        @endif 
    </p>    
    <p>
        @if(session()->has('en'))
        <strong>Mission of the Dormitory</strong><br>
        <ol>
            <li>Providing nurturing programs for supporting academic activity, talent, and interest of students.</li>
            <li>Triggering student motivation to be cooperated and competitive within the concept of together in advance.</li>
            <li>Creating day-to-day habits of keeping a healthy body, either physically or mentally.</li>
        </ol>
        @else
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
        @endif
    </p>
</div>
<br><br>
@endsection
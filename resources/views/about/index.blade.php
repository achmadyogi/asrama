@extends('layouts.app')

@section('styling')
<style>
#head {
    font-family: "Helvetica Neue",Helvetica,Arial,sans-serif;
    font-weight: 500;
    line-height: 1.1;
    color: #333;
}

#cont {
    font-family: "Helvetica Neue",Helvetica,Arial,sans-serif;
    font-size: 14px;
    line-height: 1.42857143;
    color: #333;
}
</style>
@endsection

@section('content')
<div class="container">
    <br>
	<img src="img/about.jpg" style="width: 100%">
	<div class="panel panel-default">
		<div class="panel-heading">
			<h2 id="head">Gambaran Umum UPT Asrama ITB</h2>
		</div>
		<div class="panel-body">
			<p id="cont">
            	Berkaca dan belajar dari bangsa-bangsa maju dan mengingat pentingnya pengembangan karakter suatu bangsa, pemerintah memandang penting membangun tonggak dimulainya pembangunan karakter bangsa Indonesia. Pada hari besar pendidikan nasional 11 Mei 2010 presiden republik Indonesia mencanangkan dimulainya pembangunan karakter bangsa Indonesia, dan pendidikan dijadikan ujung tombak wahana pengembangan karakter. Ada empat nilai luhur yang ingin dicapai dalam pendidikan karakter nasional, yaitu membangun generasi manusia Indonesia yang cerdas, jujur, tangguh, dan peduli, sebagai perwujudan dari perilaku berkarakter: olah pikir, olah hati, olah raga, dan olah rasa/karsa. Strategi pembangunan karakter bangsa dilakukan dengan metoda intervensi dan habituasi, yang dibentuk melalui pendidikan formal (akademik, ko-kurikuler, dan ekstra-kurikuler), keluarga dan dalam masyarakat. Institut Teknologi Bandung (ITB) sebagai lembaga pendidikan tinggi mengemban amanat mencerdaskan sumberdaya manusia nasional. Kemampuan dan peran yang diambil oleh para lulusan berakar pada proses pendidikan dan reputasi institusi yang secara sadar dibentuk dan dikembangkan menjadi trend setter pengembangan sumberdaya manusia yang unggul sesuai dengan cita-cita ITB, martabat dan harkat bangsa Indonesia. Namun demikian tuntutan kualitas sumberdaya manusia terus meningkat mengikuti perkembangan dunia global yang bergerak secara cepat dan dinamis. ITB bertanggung jawab untuk selalu mengembangkan dirinya menyediakan sistem pendidikan yang tegar dan wahana pengembangan sumberdaya manusia.
            </p>
            <p id="cont">
                Potensi afektif (rasa) mahasiswa tampak kurang mendapat tempat pengembangan sebaik pengembangan potensi kognitif. Oleh karena itu, institusi perlu memfasilitasi adanya wahana dan proses pengembangan diri dalam olah fikir, olah hati, olah rasa dan olah raga secara berkeseimbangan, khususnya pada mahasiswa baru tahun pertama. Wahana dapat diwujudkan dalam bentuk pembelajaran yang sistematis dan integratif, sedemikian sehingga mahasiswa tahun pertama memiliki kesempatan berkembang diri secara seimbang. Penyediaan asrama yang wajib bagi mahasiswa baru bisa jadi salah satu wahana yang dapat dibangun untuk memberikan lingkungan belajar afeksi yang terkondisikan. Program-program pembinaan mahasiswa di asrama utamanya ditujukan untuk mengembangkan potensi afeksi dan motorik mahasiswa melengkapi wahana pembelajaran dan kegiatan di kampus. 
            </p>
            <p id="cont">
                Operasional asrama dalam rangka efektifitas kegiatan dalam satu unit telah dimulai dengan dibentuknya satuan tugas (satgas) Asrama ITB melalui SK penetapan Satgas Asrama ITB di tetapkan tahun 2012 dan diperpanjang sampai awal tahun 2014. Dengan dibentuknya UPT Asrama ITB pada awal tahun 2014, segala operasional asrama dan kegiatan terkait baik dari keuangan dan RKA sampai pada pembinaan dikelola oleh UPT Asrama dalam satu pintu. Proses pembinaan karakter mahasiswa ITB di asrama akan dapat terlaksana dengan baik apabila ditopang dengan sarana-prasarana yang memadai, administrasi dan roda organisasi UPT yang bekerja dengan baik, serta komitmen semua pihak dalam keluarga besar ITB dan khususnya dalam keluarga besar UPT asrama terjalin dengan baik dan konsisten. Saat ini berdasarkan kebijakan ITB, mahasiswa yang tinggal saat ini adalah mahasiswa TPB program bidik misi untuk Asrama di wilayah bandung (Kampus Ganesha), mahasiswa internasional di asrama internasional dan mahasiswa yang tinggal diwilayah kampusJjatinangor di asrama Jatinangor. 
            </p>
            <p id="cont">
                Bagian ini menjelaskan tentang pelaksanaan dan implementasi RENSTRA UPT Asrama ITB terhitung sejak diterbitkannhya SK Rektor ITB Nomor 024/SK/I1.A/OT/2014 pada Bulan Maret 2014 tentang pembentukan Unit Pelaksanan Teknis Asrama ITB. Penjelasan dituangkan dalam 2 bagian, yaitu penjelasan tentang Visi Misi UPT Asrama ITB dan penjelasan tentang Organisasi, Kepemimpinan, dan Tatakelola UPT Asrama ITB. 
            </p>
            <p id="cont">
                <strong>Visi ITB</strong><br/>
                Menjadi Perguruan Tinggi yang unggul, bermartabat, mandiri, dan diakui dunia serta memandu perubahan yang mampu meningkatkan kesejahteraan bangsa Indonesia dan dunia.  
            </p>
            <p id="cont">
                <strong>Misi ITB</strong><br/>
                Menciptakan, berbagi dan menerapkan ilmu pengetahuan, teknologi, seni dan kemanusiaan serta menghasilkan sumber daya insani yang unggul untuk menjadikan Indonesia dan dunia lebih baik.
                <br/>
                Dengan mengadopsi visi dan misi Lembaga Kemahasiswaan ITB, maka visi dan misi UPT Asrama ITB adalah sebagai berikut: 
            </p>
            <p id="cont">
                <strong>Visi UPT Asrama</strong><br/>
                Menjadi UPT yang memiliki atmosfer yang kondusif bagi pengembangan kreativitas intelektual, mental dan spiritual, minat-bakat serta solidaritas sosial dan kepedulian moral mahasiswa sebagai generasi penerus yang memegang kebenaran ilmiah juga memahami kemajemukan nasional dan internasional. 
            </p>    
            <p id="cont">
                <strong>Misi UPT Asrama</strong><br/>
                <ol>
                    <li id="cont">
                        Menyelenggarakan program pembinaan untuk mendukung kegiatan akademik serta potensi minat dan bakat mahasiswa.
                    </li>
                    <li id="cont">
                        Menumbuhkan semangat kerjasama dan kompetensi dengan konsep dasar maju bersama.
                    </li>
                    <li id="cont">
                        Membentuk mahasiswa baru menjadi pribadi sehat jasmani dan rohani, mandiri, bermoral tinggi, berprestasi.
                    </li>
                    <li id="cont">
                        Membentuk mahasiswa yang peka dan mampu beradaptasi dengan lingkungan yang majemuk. 
                    </li>
                </ol>
            </p>
		</div>
	</div>
</div>
<br><br>
@endsection
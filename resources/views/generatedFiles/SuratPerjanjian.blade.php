<!DOCTYPE html>
<html>
    <head>
        <title>Surat Perjanjian</title>
        <link rel="stylesheet" type="text/css" href="{{asset('css/suratperjanjian.css')}}"/>
    </head>
    <body>
      <div class="kop" style="margin:0px; text-align:center;">
           <img src="{{ asset('img/kop_surat_asrama.PNG') }}" style="text-align:center;"/>
           <h2 style="font-size:14px;"><u> SURAT KONTRAK TINGGAL DI ASRAMA ITB </u></h2>
           <p style="font-size:11px;">Nomor : .....................</p>
      </div>
      <div class="content">
          <p><pre>Saya yang bertanda tangan di bawah ini:</pre></p>
          <p><pre>Nama Lengkap                          : {{$user->name or ''}}</pre></p>
          @if(ITBDorm::DataUser()->nim != "-")
          <p><pre>NIM                                           : {{ITBDorm::DataUser()->nim or ''}}</pre></p> 
          @else
          <p><pre>No. Registrasi                          : {{ITBDorm::DataUser()->registrasi or ''}}</pre></p>
          @endif
          <p><pre>No.Identitas                               : {{ITBDorm::DataUser()->nomor_identitas or ''}}</pre></p>
          <p><pre>Program Studi                           : {{ITBDorm::DataUser()->->nama_prodi or ''}}</pre></p>
          <p><pre>Fakultas / Sekolah                     : {{ITBDorm::DataUser()->fakultas or ''}}</pre></p>
          <p><pre>Tempat, Tanggal Lahir              : {{ITBDorm::DataUser()->tempat_lahir or ''}} , {{ date_format(DateTime::createFromFormat('Y-m-d', $userPenghuni->tanggal_lahir),"d M Y") }}</pre></p>
          <p><pre>Golongan darah                         : {{ITBDorm::DataUser()->gol_darah or ''}}</pre></p> 
          <p><pre>Jenis kelamin                             : {{ITBDorm::DataUser()->jenis_kelamin or ''}}</pre></p>
          <p><pre>Agama                                       : {{ITBDorm::DataUser()->agama or ''}}</pre></p>
          <p><pre>Alamat Asli                               : {{ITBDorm::DataUser()->alamat or ''}}</pre></p>
          <p><pre>No. Telpon / HP                        : {{ITBDorm::DataUser()->telepon or ''}}</pre></p>
          <p><pre>Alamat Email                            : {{ITBDorm::DataUser()->email or ''}}</pre></p>
          <p><pre>Nama Orangtua / Wali              : {{ITBDorm::DataUser()->nama_ortu_wali or ''}}</pre></p>
          <p><pre>Pekerjaan Orangtua / Wali        : {{ITBDorm::DataUser()->pekerjaan_ortu_wali or ''}}</pre></p>
          <p><pre>Alamat Orang Tua / Wali          : {{ITBDorm::DataUser()->alamat_ortu_wali or ''}}</pre></p>
          <p><pre>No. Telpon Orang Tua / Wali   : {{ITBDorm::DataUser()->telepon_ortu_wali or ''}}</pre></p>
          <br>
          <p>Menerima kondisi kamar sesuai Formulir Pemeriksaan Kondisi Kamar terlampir, dan bersedia tinggal di kamar asrama sebagai berikut:<p>
          @foreach($asramaUser as $asramaUser)
          <p><pre>Nama Asrama                  : {{$asramaUser->asrama or ''}}</pre></p>
          <p><pre>No. Kamar/Bed                : {{$asramaUser->kamar or ''}}</pre></p>
          @endforeach
          <p><pre>Periode Tinggal               : {{ date_format(DateTime::createFromFormat('Y-m-d', $periodeUser[count($periodeUser)-1]->tanggal_mulai_tinggal),"d M Y") }} hingga {{ date_format(DateTime::createFromFormat('Y-m-d', $periodeUser[count($periodeUser)-1]->tanggal_selesai_tinggal),"d M Y") }}</pre></p>
          <p><pre>dengan pembiayaan total sebesar   :</pre></p>
          <p><pre>dengan pembayaran dilakukan : </pre><br>
          <input type="checkbox" name="pribadi"> Telah membayar di awal;<br>
          <input type="checkbox" name="institusi"> Mengajukan penundaan pembayaran sewa asrama;<br>
          <p>Uang sewa asrama yang telah dibayarkan tidak dapat dikembalikan walaupun saya menyatakan membatalkan asrama baik sebelum maupun sesudah proses <i>check in</i> atau daftar ulang serta keluar dari asrama baik dikeluarkan atau menyatakan mengundurkan diri dari asrama.<br>
          <p>Untuk itu, saya berjanji untuk memenuhi kewajiban dan hak saya sebagai penghuni asrama sesuai dengan peraturan dan tata tertib asrama terlampir.</p>
          <p>Demikian perjanjian ini saya buat dengan penuh kesadaran tanpa paksaan dari pihak mana pun.</p> 
        </div>

      <div class="ttd" style="margin:0px; text-align:center;">
           <img src="{{asset('img/ttd.png')}}" style="text-align:center;"/>
      </div>
      <!-- page 2 form pengecekan kamar -->
      <div style="page-break-after: always;"></div>

        <div class="kop" style="margin:0px; text-align:center;">
          <img src="{{ asset('img/kop_surat_asrama.PNG') }}" style="text-align:center;"/>
          <h2 style="font-size:14px;"><u> Formulir Pemeriksaan Kondisi Kamar </u></h2>
      </div>
      <div class="content">
        <p>Dengan ini, saya yang bertanda tangan di bawah ini: </p>
        <p><pre>Nama                       : {{$user->name or ''}}</pre></p>
        @if($prodiUser[count($prodiUser)-1]->nim != "-")
        <p><pre>NIM                         : {{$prodiUser[count($prodiUser)-1]->nim or ''}}</pre></p> 
        @else
        <p><pre>No. Registrasi          : {{$prodiUser[count($prodiUser)-1]->registrasi or ''}}</pre></p>
        @endif
        <p><pre>Prodi/Fak./Sek.        : {{$prodiUser[count($prodiUser)-1]->nama_prodi or ''}}/{{$prodiUser[count($prodiUser)-1]->nama or ''}}</pre></p>
        <p><pre>Asrama                    : {{$asramaUser->asrama or ''}}</pre></p>
        <p><pre>No. Kamar               : {{$asramaUser->kamar or ''}}</pre></p>
        <p><pre>No. Kontak              : {{$userPenghuni->telepon or ''}}</pre></p>
        <p><pre>Periode Tinggal       : {{ date_format(DateTime::createFromFormat('Y-m-d', $periodeUser[count($periodeUser)-1]->tanggal_mulai_tinggal),"d M Y")}} hingga {{ date_format(DateTime::createFromFormat('Y-m-d', $periodeUser[count($periodeUser)-1]->tanggal_selesai_tinggal),"d M Y")}}</pre></p>
        <p><pre>telah melihat dan mendapati kondisi kamar sebagai berikut (tambahkan fasilitas lain jika perlu):</pre></p>
      </div>

      <div class="tabel_pengecekan" >
          <img src="{{asset('img/tabel_pengecekan.PNG')}}" style="text-align:left;"/>
      </div>
      <p class='content'>Dengan ini menyatakan bahwa saya menerima kondisi kamar tersebut dan akan memanfaatkannya dengan sebaik-baiknya sesuai aturan yang berlaku di Asrama ITB. </p>
      <div class="ttd" style="margin:0px; text-align:center;">
          <img src="{{asset('img/ttd_pengecekan.PNG')}}" style="text-align:center;"/>
      </div>
      <div class="content">
          <p><pre><i>i) Coret yang tidak perlu.</i></pre></p>
          <p><pre><i>ii)Diparaf oleh pengelola asrama yang memeriksa.</i></pre></p>
          <p><pre><i>Formulir ini merupakan lampiran dari Surat Perjanjian Tinggal di Asrama ITB</i></pre></p>
          <p><pre><i>Formulir ini dibuat 3 rangkap, untuk dipegang oleh: (1) penghuni; (2) pengelola Asrama; (3) UPT Asrama ITB</i></pre></p>
      </div>
    </body>
</html>
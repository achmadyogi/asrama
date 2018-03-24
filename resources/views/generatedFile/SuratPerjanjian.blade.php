<!DOCTYPE html>
<html>
    <head>
        <title>Surat Perjanjian</title>
        <link rel="stylesheet" type="text/css" href="\css\suratperjanjian.css"/>
    </head>
    <body>
      <div class="picture_div" style="margin:0px; text-align:center;">
           <img src="img\kop_itb.png" style="text-align:center;"/>
           <h2 style="font-size:14px;"><u> SURAT PERJANJIAN TINGGAL DI ASRAMA ITB </u></h2>
           <p style="font-size:11px;">Nomor : .....................</p>
      </div>

      <div class="content">
          <p>Saya yang bertanda tangan di bawah ini:</p>
          <p><pre>Nama                         : {{$data->nama or ''}}</pre></p>
          <p><pre>NIM / No.Identitas           : {{$mynim->nim or ''}}</pre></p>
          <p><pre>Program Studi                : {{$mynim->nama_prodi or ''}}</pre></p>
          <p><pre>Fakultas                     : {{$mynim->nama_fakultas or ''}}</pre></p>
          <p><pre>Tempat, Tanggal Lahir        : {{$data->tempat_lahir or ''}} , {{ date_format(DateTime::createFromFormat('Y-m-d', $data->tanggal_lahir),"d M Y") }}</pre></p>
          <p><pre>Golongan darah               : {{$data->gol_darah or ''}}</pre></p>
          <p><pre>Agama                        : {{$data->agama or ''}}</pre></p>
          <p><pre>Jenis Kelamin                : {{$jeniskelamin or ''}}</pre></p>
          <p><pre>Alamat                       : {{$data->alamat or ''}}</pre></p>
          <p><pre>No. Telpon / HP              : {{$data->telepon or ''}}</pre></p>
          <p><pre>Email                        : {{$data->email or ''}}</pre></p>
          <p><pre>Nama Orang Tua / Wali        : {{$data->nama_ortu_wali or ''}}</pre></p>
          <p><pre>Pekerjaan Orang Tua / Wali   : {{$data->pekerjaan_ortu_wali or ''}}</pre></p>
          <p><pre>Alamat Orang Tua / Wali      : {{$data->alamat_ortu_wali or ''}}</pre></p>
          <p><pre>No. Telpon Orang Tua / Wali  : {{$data->telepon_ortu_wali or ''}}</pre></p>
          <br><br><br><br><br><br><br><br><br><br>

      </div>

      <!-- page 2 -->
      <div class="picture_div" style="margin:0px; text-align:center;">
           <img src="img\kop_itb.png" style="text-align:center;"/>
      </div>

      <div class="content">
        <p>telah melihat kondisi kamar, menerima kondisi sesuai Formulir Pemeriksaan Kondisi Kamar terlampir, dan bersedia tinggal di kamar asrama sebagai berikut:<p>
        <p><pre>Asrama                       : {{$data->asrama or ''}}</pre></p>
        <p><pre>Periode Tinggal              : {{ date_format(DateTime::createFromFormat('Y-m-d', $data->tanggal_masuk),"d M Y") }} hingga {{ date_format(DateTime::createFromFormat('Y-m-d', $data->tanggal_keluar),"d M Y") }}</pre></p>
        <p>dengan pembayaran akan dilakukan oleh :</p>
        <input type="checkbox" name="pribadi"> Pribadi : pembayaran akan dilakukan paling lambat tanggal ...............................<br>
        <input type="checkbox" name="institusi"> Institusi/Program : ...................................................................<br>
        dengan ini saya lampirkan bukti bahwa biaya asrama akan ditanggung oleh institusi/program tersebut.<br>
        <br>
        <p>Untuk itu, saya berjanji untuk memenuhi kewajiban dan hak saya sebagai penghuni asrama sesuai dengan peraturan dan tata tertib asrama.</p>
        <p>Demikian perjanjian ini saya buat dengan penuh kesadaran tanpa paksaan dari pihak mana pun.</p>
      </div>

      <div class="ttd" style="margin:0px; text-align:center;">
           <img src="img\ttd.png" style="text-align:center;"/>
      </div>

      <!-- page 3 form pengecekan kamar -->
      <div style="page-break-after: always;"></div>

      <div class="picture_div" style="margin:0px; text-align:center;">
           <img src="img\kop_itb.png" style="text-align:center;"/>
           <h2 style="font-size:14px;"><u> Formulir Pemeriksaan Kondisi Kamar </u></h2>
      </div>

      <div class="content">
        <p>Dengan ini, saya yang bertanda tangan di bawah ini: </p>
        <p><pre>Nama                : {{$data->nama or ''}}</pre></p>
        <p><pre>NIM / No.Identitas  : {{$data->nim or ''}}</pre></p>
        <p><pre>Prodi/Fak./Sek.     : {{$mynim->nama_prodi or ''}}/{{$mynim->nama_fakultas or ''}}</pre></p>
        <p><pre>Asrama              : {{$data->asrama or ''}}</pre></p>
        <p><pre>No. Kamar           : {{$nokamar or ''}}</pre></p>
        <p><pre>No. Kontak          : {{$data->telepon or ''}}</pre></p>
        <p><pre>Periode Tinggal     : {{ date_format(DateTime::createFromFormat('Y-m-d', $data->tanggal_masuk),"d M Y")}} hingga {{ date_format(DateTime::createFromFormat('Y-m-d', $data->tanggal_keluar),"d M Y")}}</pre></p>
        <p>telah melihat dan mendapati kondisi kamar sebagai berikut (tambahkan fasilitas lain jika perlu):</p>
      </div>

      <div class="ttd" style="margin:0px; text-align:left;">
           <img src="img\kelayakankamar.png" style="text-align:left;"/>
      </div>

      <!-- page 4 -->
      <div style="page-break-after: always;"></div>
      <div class="ttd" style="margin:0px; text-align:center;">
           <img src="img\kop_itb.png" style="text-align:center;"/>
      </div>
      <p class='content'>dan menyatakan saya menerima kondisi kamar tersebut dan akan memanfaatkannya dengan sebaik-baiknya sesuai aturan yang berlaku di Asrama ITB</p>
      <div class="ttd" style="margin:0px; text-align:center;">
           <img src="img\ttd.png" style="text-align:center;"/>
      </div>

      <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
      <div class="content">
        <p> Catatan : Surat perjanjian ini dibuat 3 rangkap, untuk dipegang oleh: (1) penghuni; (2) pengelola Asrama Mahasiswa ITB tempat penghuni ditempatkan; (3) UPT Asrama ITB</p>
      </div>

    </body>
</html>

<!DOCTYPE html>
<html>
    <head>
        <title>Form Keluar Asrama</title>
        <link rel="stylesheet" type="text/css" href="\css\suratperjanjian.css"/>
        <style>
            table, th, td {
                border: 1px solid black;
                border-collapse: collapse;
            }
        </style>
    </head>
    <body>
      <div class="picture_div" style="margin:0px; text-align:center;">
           <img src="img\kop_itb.png" style="text-align:center;"/>
           <h2 style="font-size:14px;">Formulir Keluar Asrama</h2>
      </div>
      <div class="content">
          <p>Berikut adalah data penghuni Asrama ITB yang mengajukan diri untuk keluar Asrama ITB:</p>
          <p><pre>Nama                         : {{$data->nama or ''}}</pre></p>
          <p><pre>NIM / No.Identitas           : {{$mynim->nim or ''}}</pre></p>
          <p><pre>Program Studi                : {{$mynim->nama_prodi or ''}}</pre></p>
          <p><pre>Asrama                       : {{$data->asrama or ''}}</pre></p>
          <p><pre>No. Kamar                    : {{$nokamar or ''}}</pre></p>
          <p><pre>No. Kontak                   : {{$data->telepon or ''}}</pre></p>
          <p><pre>Periode Tinggal              : {{ date_format(DateTime::createFromFormat('Y-m-d', $data->tanggal_masuk),"d M Y") }} hingga {{ date_format(DateTime::createFromFormat('Y-m-d', $data->tanggal_keluar),"d M Y") }}</pre></p>

      </div>

      <div class="content">
        <p>1.	Status keluar :</p>
        <div style="margin-left:10px;">
          <input type="checkbox" name="a"> Keluar pada periode yang ditentukan<br>
          <input type="checkbox" name="b"> Keluar pada periode yang tidak ditentukan<br>
          <p>Tanggal Keluar : ......................................................</p>
        </div>
      </div>

      <div class="content">
        <p>2.	Pembayaran tagihan Asrama :</p>
        <table style="border: 1px solid black; width=100%; empty-cells: show;">
          <tr>
            <th width="200">Bulan - Tahun</th>
            <th width="200">Jumlah (RP)</th>
            <th width="150" height="15">Status (LUNAS / BELUM)</th>
          </tr>
          <tr>
            <td height="15"></td>
            <td></td>
            <td></td>
          </tr>
          <tr>
            <td height="15"></td>
            <td></td>
            <td></td>
          </tr>
          <tr>
            <td height="15"></td>
            <td></td>
            <td></td>
          </tr>
          <tr>
            <td height="15"></td>
            <td></td>
            <td></td>
          </tr>
          <tr>
            <td height="15"></td>
            <td></td>
            <td></td>
          </tr>
          <tr>
            <td height="15"></td>
            <td></td>
            <td></td>
          </tr>
        </table>
      </div>

      <div style="page-break-after: always;"></div>
      <div class="ttd" style="margin:0px; text-align:center;">
           <img src="img\kop_itb.png" style="text-align:center;"/>
      </div>

      <div class="content">
        <p>3.	Pemeriksaan kondisi kamar dan fasilitasnya</p>
        <p style="margin-left:10px;"><b>Fasilitas kamar dalam kondisi baik, jumlah dan posisi sesuai, rapi, dan bersih</b>.<br> Khusus untuk kunci: diserahkan kepada pengelola pada saat keluar. Dicek dan diisi oleh pengelola asrama.</p>
        <div class="picture_div" style="margin:0px; text-align:left; margin-left:10px;">
             <img src="img\pemeriksaanKeluarKamar.png" style="text-align:left;"/>
        </div>
      </div>

      <div class="content">
        <p>Berdasarkan pemeriksaan persyaratan di atas, maka UPT Asrama diwakili pengelola asrama menyatakan, untuk penghuni tersebut di atas (cek salah satu oleh pengelola asrama):</p>
        <input type="checkbox" name="pribadi"> Disetujui keluar asrama tanpa syarat<br>
        <input type="checkbox" name="institusi"> Menyetujui keluar asrama dengan syarat: (mahasiswa memberikan jaminan KTM/KTP)<br>
        <textarea rows="4" cols="80">
        </textarea><br>
        <input type="checkbox" name="pribadi"> Tidak disetujui keluar asrama<br>
      </div>
      <br>

      <div style="page-break-after: always;"></div>
      <div class="ttd" style="margin:0px; text-align:center;">
           <img src="img\kop_itb.png" style="text-align:center;"/>
      </div>

      <div class="picture_div" style="margin:0px; text-align:center;">
           <img src="img\ttd2.png" style="text-align:center;"/>
      </div>

      <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
      <div class="content">
        <p> Catatan : </p>
          <p>1. *) diisi jika perlu </p>
          <p>2. **) Surat penangguhan pembayaran asrama dilampirkan bersama form ini.</p>
          <p>3. ***) Beri tanda (√) jika fasilitas tidak disediakan dari awal</p>
          <p>3. Formulir ini dibuat rangkap 2: 1 untuk penghuni, 1 untuk petugas.</p>
      </div>

    </body>
</html>

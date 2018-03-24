<!DOCTYPE html>
<html>
    <head>
        <title>Surat Penangguhan</title>
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
           <h2 style="font-size:14px;"><b> PENGAJUAN PENANGGUHAN DAN PERJANJIAN PELUNASAN PEMBAYARAN ASRAMA </b></h2>
      </div>

      <div class="content">
          <p>Saya yang bertanda tangan di bawah ini,</p>
      </div>

      <table style="border: 1px solid black;">
        <tr>
          <td width="200">Nama Mahasiswa</td>
          <td width="300">{{$data->nama or ''}}</td>
        </tr>
        <tr>
          <td>NIM</td>
          <td>{{$mynim->nim or ''}}</td>
        </tr>
        <tr>
          <td>Fakultas</td>
          <td>{{$mynim->nama_fakultas or ''}}</td>
        </tr>
        <tr>
          <td>Asrama dan No. Kamar</td>
          <td>{{$data->asrama or ''}}</td>
        </tr>
        <tr>
          <td>Alamat Email</td>
          <td>{{$data->email or ''}}</td>
        </tr>
        <tr>
          <td>Nomer HP</td>
          <td>{{$data->telepon or ''}}</td>
        </tr>
      </table>
      <br>
      <p class="content">Mengajukan penangguhan pembayaran asrama dengan rincian sebagai berikut,</p>

      <table>
        <tr>
          <td width="200">Jumlah Tangguhan</td>
          <td width="300" style="color:white;">aaaaaa</td>
        </tr>
        <tr>
          <td>Terbilang</td>
          <td></td>
        </tr>
        <tr>
          <td>Rincian Bulan yang Ditangguhkan</td>
          <td></td>
        </tr>
        <tr>
          <td>Alasan ditangguhkan</td>
          <td></td>
        </tr>
      </table>

      <div class="content">
        <p>Dengan ini saya berjanji untuk melunasi jumlah tangguhan tersebut paling lambat tanggal )*:</p>
        <textarea rows="1" cols="80">
        </textarea>
        <p>Jika tidak, saya bersedia menerima konsekuensi apapun yang ditetapkan oleh ITB.</p>
      </div>
      <br>

      <div class="picture_div" style="margin:0px; text-align:center;">
           <img src="img\ttd3.png" style="text-align:center;"/>
      </div>

      <div style="page-break-after: always;"></div>
      <div class="ttd" style="margin:0px; text-align:center;">
           <img src="img\kop_itb.png" style="text-align:center;"/>
      </div>
      <div class="content">
        <p> Catatan : </p>
        <p>1.	)* : Waktu pelunasan tidak boleh melebihi 28 April 2017.</p>
        <p>2.	Formulir penangguhan dibuat rangkap 2: asli untuk UPT Asrama dan copy untuk penghuni.</p>
        <p>3.	Pelunasan dilakukan dengan cara Host to Host di Bank yang ada di Kampus ITB. </p>
        <p>Bukti Pelunasan diserahkan ke Bu Kakay (Asrama Bandung) atau Pak Danar (Asrama Jatinangor)</p>
      </div>
    </body>
</html>

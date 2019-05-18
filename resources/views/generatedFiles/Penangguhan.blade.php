<!DOCTYPE html>
<html>
    <head>
        <title>Surat Penangguhan</title>
        <link rel="stylesheet" type="text/css" href="{{asset('css/suratperjanjian.css')}}"/>
    </head>
    <body>
      <style>
          table{
              width: 100%;
              border: none;
          }
          table tr{
              border:none;
          }
          table tr th{
              border: none;
              font-weight:normal;
          }
      </style>
      <div class="picture_div" style="margin:0px; text-align:center;">
          <img src="{{ asset('img/kop_surat_asrama.PNG') }}" style="text-align:center;"/>
      </div>

      <div class="content-penangguhan" >
        <h2 style="font-size:16px; text-align: center;"><b> PENGAJUAN PENANGGUHAN DAN PERJANJIAN PELUNASAN PEMBAYARAN ASRAMA </b></h2>
        <p>Saya yang bertanda tangan di bawah ini:<br><br>
        <span style="display: inline-block; width: 180px;">Nama Lengkap</span>: {{ITBDorm::DataUser()->name or ''}}<br>
        @if(ITBDorm::DataUser()->nim != "-")
        <span style="display: inline-block; width: 180px;">NIM</span>: {{ITBDorm::DataUser()->nim or ''}}<br> 
        @else
        <span style="display: inline-block; width: 180px;">No. Registrasi</span>: {{ITBDorm::DataUser()->registrasi or ''}}<br>
        @endif
        <span style="display: inline-block; width: 180px;">Program Studi</span>: {{ITBDorm::DataUser()->nama_prodi or ''}}<br>
        <span style="display: inline-block; width: 180px;">Fakultas / Sekolah</span>: {{ITBDorm::DataUser()->fakultas or ''}}<br>
        @foreach($asramaUser as $asramaUser)
        <span style="display: inline-block; width: 180px;">Asrama / Kamar</span>: {{$asramaUser->asrama}} / {{$asramaUser->kamar}}<br>
        @endforeach
        <span style="display: inline-block; width: 180px;">Email</span>: {{ITBDorm::DataUser()->email}}<br>
        <span style="display: inline-block; width: 180px;">Nomor HP</span>: {{ITBDorm::DataUser()->telepon}}<br><br>
        Mengajukan penangguhan pembayaran asrama dengan rincian sebagai berikut,<br><br>
        <span style="display: inline-block; width: 180px;">Jumlah Tangguhan</span>: <br>
        <span style="display: inline-block; width: 180px;">Terbilang</span>:<br>
        <span style="display: inline-block; width: 180px;">Bulan yang Ditangguhkan</span>:<br>
        <span style="display: inline-block; width: 180px;">Alasan Ditangguhkan*</span>: </p>
      </div>
      
      <div class="content-penangguhan">
        <p>Dengan ini saya berjanji untuk melunasi jumlah tangguhan tersebut paling lambat... )**:</p>
        <div style="width: 100%; border: 1px solid black; height: 30px;"></div>
        <p>Jika tidak, saya bersedia menerima konsekuensi apapun yang ditetapkan oleh ITB.</p>
      </div>
      <div class="content-penangguhan">
          <table>
              <tr>
                  <th>
                      <br>
                      <p>
                          Mengetahui,<br>
                          Orang Tua Mahasiswa<br>
                          <br><br><br>
                          ............................<br>
                      </p>
                  </th>
                  <th>
                      <p>
                          Bandung, ... Januari 2019<br>
                          Mahasiswa<br>
                          <br><br>(Materai 6000)<br><br>
                          NIM: .......................
                      </p>
                  </th>
              </tr>
          </table>
      </div>
      <div class="content">
        <p> Catatan :
            <ol>
            <li><span style="display: inline-block; width:50px;">… )*</span>: Dilengkapi dengan surat bukti pendaftar beasiswa bidikmisi atau surat keterangan tidak mampu
                 dari ketua RT atau RW atau Kelurahan tempat asal.</li>
            <li><span style="display: inline-block; width:50px;">… )**</span>: Waktu pelunasan tidak boleh melebihi 28 Februari 2019.</li>
            <li><b>Formulir penangguhan dibuat rangkap 2: 1 untuk UPT Asrama (asli) dan 1 untuk penghuni</b></li>
            </ol>
        </p>
      </div>
    </body>
</html>

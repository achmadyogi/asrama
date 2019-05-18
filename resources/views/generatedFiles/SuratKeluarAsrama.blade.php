<!DOCTYPE html>
<html>
    <head>
            <title>Formulir Kelua Asrama</title>
            <link rel="stylesheet" type="text/css" href="{{asset('css/suratperjanjian.css')}}"/>
    </head>
    <body>
        <div class="kop" style="margin:0px; text-align:center;">
            <img src="{{ asset('img/kop_surat_asrama.PNG') }}" style="text-align:center;"/>
            <h2 style="font-size:14px;"><u> FORMULIR KELUAR ASRAMA </u></h2>
        </div>
        <div class="content">
            <p><pre>Berikut adalah data penghuni Asrama ITB yang mengajukan diri untuk keluar Asrama ITB:</pre></p><br>
            <div class="row">
                <div class="column">
                    <p><pre>Nama Lengkap                          : {{$user->name or ''}}</pre></p>
                    @if($prodiUser[count($prodiUser)-1]->nim != "-")
                        <p><pre>NIM                                           : {{$prodiUser[count($prodiUser)-1]->nim or ''}}</pre></p> 
                    @else
                        <p><pre>No. Registrasi                          : {{$prodiUser[count($prodiUser)-1]->nim or ''}}</pre></p>
                    @endif
                    <p><pre>Program Studi                           : {{$prodiUser[count($prodiUser)-1]->nama_prodi or ''}}</pre></p>
                    <p><pre>Periode Tinggal                         : {{ date_format(DateTime::createFromFormat('Y-m-d', $periodeUser[count($periodeUser)-1]->tanggal_mulai_tinggal),"d M Y") }} hingga {{ date_format(DateTime::createFromFormat('Y-m-d', $periodeUser[count($periodeUser)-1]->tanggal_selesai_tinggal),"d M Y") }}</pre></p>
                </div>
                <div class="column" style="margin-left:10px;">
                    <p><pre>Nama Asrama                  : {{$asramaUser[count($asramaUser)-1]->asrama or ''}}</pre></p>
                    <p><pre>No. Kamar/Bed                : {{$asramaUser[count($asramaUser)-1]->kamar or ''}}</pre></p>
                    <p><pre>No. Telpon / HP               : {{$userPenghuni->telepon or ''}}</pre></p>
                    <p><pre>Tanggal keluar                  : {{$tanggal}}</pre></p>
                </div>
            </div>
            <p><b>1. Pemenuhan persyaratan keluar asrama:</b></p>
            <table style="width: 575px; border:1px solid black">
                <tbody>
                    <tr style="height: 21px;">
                        <td style="width: 250px; height: 21px;">Periode</td>
                        <td style="width: 131px; height: 21px;">Jumlah(Rp)</td>
                        <td style="width: 100px; height: 21px;">Status</td>
                        <td style="width: 100px; height: 21px;">Keterangan *)</td>
                    </tr>
                    @foreach($data_syarat as $data)
                    <tr style="height: 21px;">
                        <td style="width: 250px; height: 21px;">{{$data->nama_periode}}</td>
                        <td style="width: 131px; height: 21px;">{{$jumlah_bayar}}</td>
                        @if($status == 1)
                            <td style="width: 100px; height: 21px;">LUNAS</td>
                        @else
                            <td style="width: 100px; height: 21px;">BELUM LUNAS</td>
                        @endif
                        <td style="width: 75px; height: 21px;"></td>
                    </tr>
                    @endforeach
                    <tr style="height: 25px;">
                        <td style="width: 500px; height: 25px;" colspan="4">Bagi penghuni yg memiliki status pembayaran "belum lunas", diwajibkan segera menemui Bu Kakay di Sekretariat UPT asrama ITB </td>
                    </tr>
                </tbody>
            </table>
            <p><b>2. Pemeriksaan kondisi kamar dan fasilitasnya</b><br>
            <b>Fasilitas kamar dalam kondisi baik, jumlah dan posisi sesuai, rapi, dan bersih.</b> Selain itu tidak ada barang yang tertinggal (UPT Asrama tidak bertanggung jawab atas kerusakan atau kehilangan barang yang tertinggal). Khusus untuk kunci: diserahkan kepada pengelola pada saat keluar. Dicek dan diisi (v) oleh pengelola asrama.</p>
            <table style="width: 571px;" border="1px">
                <tbody>
                <tr>
                <td style="width: 25px;">No</td>
                <td style="width: 132px;">Fasilitas</td>
                <td style="width: 67px;">Terpenuhi</td>
                <td style="width: 76px;">Tidak Terpenuhi</td>
                <td style="width: 170px;">Keterangan *)</td>
                <td style="width: 80px;">Tanda Tangan</td>
                </tr>
                <tr>
                <td style="width: 25px;">a.</td>
                <td style="width: 132px;">Kunci</td>
                <td style="width: 67px;">&nbsp;</td>
                <td style="width: 76px;">&nbsp;</td>
                <td style="width: 170px;">Diserahkan ke pengelola</td>
                <td style="width: 80px;" rowspan="7">&nbsp;</td>
                </tr>
                <tr>
                <td style="width: 25px;">b.</td>
                <td style="width: 132px;">Bed</td>
                <td style="width: 67px;">&nbsp;</td>
                <td style="width: 76px;">&nbsp;</td>
                <td style="width: 170px;">&nbsp;</td>
                </tr>
                <tr>
                <td style="width: 25px;">c.</td>
                <td style="width: 132px;">Meja</td>
                <td style="width: 67px;">&nbsp;</td>
                <td style="width: 76px;">&nbsp;</td>
                <td style="width: 170px;">&nbsp;</td>
                </tr>
                <tr>
                <td style="width: 25px;">d.&nbsp;</td>
                <td style="width: 132px;">Kursi</td>
                <td style="width: 67px;">&nbsp;</td>
                <td style="width: 76px;">&nbsp;</td>
                <td style="width: 170px;">&nbsp;</td>
                </tr>
                <tr>
                <td style="width: 25px;">e.&nbsp;</td>
                <td style="width: 132px;">Lemari</td>
                <td style="width: 67px;">&nbsp;</td>
                <td style="width: 76px;">&nbsp;</td>
                <td style="width: 170px;">&nbsp;</td>
                </tr>
                <tr>
                <td style="width: 25px;">f.&nbsp;</td>
                <td style="width: 132px;">Lampu</td>
                <td style="width: 67px;">&nbsp;</td>
                <td style="width: 76px;">&nbsp;</td>
                <td style="width: 170px;">&nbsp;</td>
                </tr>
                <tr>
                <td style="width: 25px;">&nbsp;</td>
                <td style="width: 132px;">&nbsp;</td>
                <td style="width: 67px;">&nbsp;</td>
                <td style="width: 76px;">&nbsp;</td>
                <td style="width: 170px;">&nbsp;</td>
                </tr>
                </tbody>
            </table>
            <p>Berdasarkan pemeriksaan persyaratan di atas, maka UPT Asrama diwakili pengelola asrama menyatakan, untuk <br>
                penghuni tersebut di atas (cek (v) salah satu oleh pengelola asrama):</p>
            <p><input type="checkbox" name="pribadi"> Disetujui keluar asrama tanpa syarat</p>
            <p><input type="checkbox" name="institusi"> Disetujui keluar asrama dengan syarat (melampirkan jaminan KTM atau KTP):........................</p>
            <p>Alasan keluar bersyarat dan penjaminan KTM atau KTP: <br>
            ................................................................................................<br>
            Status pengembalian KTM atau KTP: ...................................</p>
            <div class="kop" style="margin:0px; text-align:center;">
                    <p>....................,.......................................</p>
                    <div class="row">
                        <div class="column">
                            <p><pre>Penghuni Asrama,</pre></p>
                            <br><br><br><br>
                            <p><pre>{{$user->name}}</pre></p>
                        </div>
                        <div class="column">
                            <p><pre>Pengelola Asrama</pre></p>
                            <br><br><br>
                            <p>.............................................</p>
                        </div>
                    </div>
            </div>
            <p style="font-size:9px"><pre>*) Diisi jika perlu</pre></p>
            <p style="font-size:9px"><pre>Catatan: Form keluar ini dibuat 2 rangkap (1 untuk pengelola, 1 untuk penghuni)</pre></p>
        </div>
    </body>
</html>
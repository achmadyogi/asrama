<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\User_penghuni;
use App\User;
use App\User_nim;
use App\Prodi;
use Session;
use App\Periode;
use dateTime;
use App\Daftar_asrama_non_reguler;
use App\Daftar_asrama_reguler;
use Illuminate\Support\Facades\DB;
use App\Kamar;
use App\Kamar_penghuni;
use App\Tarif;
use App\Tagihan;

class VerifikasiNonReguler extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $nonReg;
    public function __construct(daftar_asrama_non_reguler $nonReg)
    {
        $this->nonReg = $nonReg;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        // Dapatkan nama
        $user = User::find(Daftar_asrama_non_reguler::find($this->nonReg->id_daftar)->id_user);
        $nama = $user->name;
        $email = $user->email;
        // Dapatkan kamar dan asrama
        $dataKamar = DB::select("SELECT daftar_asrama_id, daftar_asrama_type, asrama, gedung, kamar, kamar_penghuni.id_kamar FROM kamar_penghuni LEFT JOIN (SELECT tempat.asrama, tempat.gedung, kamar.nama AS kamar, id_kamar FROM kamar LEFT JOIN (SELECT id_gedung, asrama.nama AS asrama, gedung.nama AS gedung FROM gedung LEFT JOIN asrama ON asrama.id_asrama = gedung.id_asrama) AS tempat ON tempat.id_gedung = kamar.id_gedung) AS set_kamar ON set_kamar.id_kamar = kamar_penghuni.id_kamar AND daftar_asrama_type = 'daftar_asrama_non_reguler' AND daftar_asrama_id = ?",[$this->nonReg->id_daftar]);
        foreach ($dataKamar as $dataKamar) {
            $kamar = $dataKamar->kamar;
            $gedung = $dataKamar->gedung;
            $asrama = $dataKamar->asrama;
        }
        // Dapatkan data tanggal
        $date = Daftar_asrama_non_reguler::find($this->nonReg->id_daftar);

        // Dapatkan data masuk
        $dateArray3 = explode('-',$date->tanggal_masuk);
        // Nama Bulan
        if($dateArray3[1] == '01'){
          $bulan = 'Januari';
        }
        if($dateArray3[1] == '02'){
          $bulan = 'Februari';
        }
        if($dateArray3[1] == '03'){
          $bulan = 'Maret';
        }
        if($dateArray3[1] == '04'){
          $bulan = 'April';
        }
        if($dateArray3[1] == '05'){
          $bulan = 'Mei';
        }
        if($dateArray3[1] == '06'){
          $bulan = 'Juni';
        }
        if($dateArray3[1] == '07'){
          $bulan = 'Juli';
        }
        if($dateArray3[1] == '08'){
          $bulan = 'Agustus';
        }
        if($dateArray3[1] == '09'){
          $bulan = 'September';
        }
        if($dateArray3[1] == '10'){
          $bulan = 'Oktober';
        }
        if($dateArray3[1] == '11'){
          $bulan = 'November';
        }
        if($dateArray3[1] == '12'){
          $bulan = 'Desember';
        }
        $masuk = $dateArray3[2]." ".$bulan." ".$dateArray3[0];
        return $this->view('email.nonRegVerification')
                    ->with(['email'=>$email,
                            'nama'=>$nama,
                            'kamar'=>$kamar,
                            'gedung'=>$gedung,
                            'asrama'=>$asrama,
                            'masuk'=>$masuk,
                            'keluar'=>$date->lama_tinggal,
                            'id'=>$this->nonReg->id_daftar]);
    }
}

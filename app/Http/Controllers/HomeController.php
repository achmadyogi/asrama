<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Berita;
use App\Pengumuman;
use App\Jadwal;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use ITBdorm;
use DormAuth;

class HomeController extends Controller
{
    //untuk menampilkan aplikasi
    public function index() {
      // Menampilkan aplikasi berita
      $berita = Berita::all()->sortByDesc("updated_at")->take(3);
      // Menampilkan aplikasi pengumuman
      $pengumuman = Pengumuman::all()->sortByDesc("updated_at")->take(4);
      // Menampilkan aplikasi jadwal deadline dan kegiatan
      $jadwal = Jadwal::all()->sortByDesc("tanggal")->take(5);

      // Fakta statistik
      $count = DB::select("SELECT daftar_asrama_reguler.id_periode, nama_periode, tanggal_selesai_tinggal, c.asrama, count(daftar_asrama_reguler.id_periode) AS value FROM daftar_asrama_reguler LEFT JOIN periodes ON periodes.id_periode = daftar_asrama_reguler.id_periode LEFT JOIN (SELECT daftar_asrama_id, daftar_asrama_type, b.id_kamar, b.id_gedung, b.id_asrama, b.asrama FROM kamar_penghuni LEFT JOIN (SELECT kamar.id_kamar, a.id_gedung, a.id_asrama, a.asrama FROM kamar LEFT JOIN (SELECT gedung.id_asrama, gedung.id_gedung, asrama.nama as asrama, gedung.nama as gedung FROM gedung LEFT JOIN asrama ON gedung.id_asrama = asrama.id_asrama) a ON a.id_gedung = kamar.id_gedung) AS b ON kamar_penghuni.id_kamar = b.id_kamar WHERE kamar_penghuni.daftar_asrama_type = 'daftar_asrama_reguler') AS c ON c.daftar_asrama_id = daftar_asrama_reguler.id_daftar WHERE verification in (5,6) GROUP BY daftar_asrama_reguler.id_periode, c.asrama ORDER BY id_periode DESC");
      $count_period = 0;
      $h = 0;
      $cp_nama = "";
      $asrama[0] = "";
      $exist = false;
      foreach ($count as $c) {
        if($c->nama_periode != $cp_nama & $count_period < 4){
          $cp_nama = $c->nama_periode;
          $cp_nama_periode[$count_period] = $c->nama_periode;
          $cp_id_periode[$count_period] = $c->id_periode;
          // Penentian aktif non-aktif
          $now = Carbon::now()->toDateString();
          $kadaluarsa = $c->tanggal_selesai_tinggal;
          if(ITBdorm::CompareDate($now, $kadaluarsa) == 1){
            $activation[$count_period] = 1;
          }else{
            $activation[$count_period] = 0;
          }
          $count_period += 1;
        }
        for($a=0;$a<sizeof($asrama);$a++){
          if($c->asrama == $asrama[$a]){
            $exist = true;
          }
        }
        if($exist == false ){
          $asrama[$h] = $c->asrama;
          $h += 1;
        }else{
          $exist = false;
        }
      }
      $o1 = 0;
      $o2 = 0;
      $o3 = 0;
      $o4 = 0;
      foreach ($count as $co) {
        for($i=0;$i<sizeof($asrama);$i++){
          if($co->asrama == $asrama[$i] && $co->id_periode == $cp_id_periode[0]){
            $asrama_1[$o1] = $co->value;
            $asrama_1n[$o1] = $i;
            $o1 += 1;
          }
          if($co->asrama == $asrama[$i] && $co->id_periode == $cp_id_periode[1]){
            $asrama_2[$o2] = $co->value;
            $asrama_2n[$o2] = $i;
            $o2 += 1;
          }
          if($co->asrama == $asrama[$i] && $co->id_periode == $cp_id_periode[2]){
            $asrama_3[$o3] = $co->value;
            $asrama_3n[$o3] = $i;
            $o3 += 1;
          }
          if($co->asrama == $asrama[$i] && $co->id_periode == $cp_id_periode[3]){
            $asrama_4[$o4] = $co->value;
            $asrama_4n[$o4] = $i;
            $o4 += 1;
          }
        }
      }
      return view('/home', ['pengumuman'=> $pengumuman,
                            'berita' => $berita,
                            'user' => DormAuth::User(),
                            'jadwal' => $jadwal,
                            'cp_nama_periode' => $cp_nama_periode,
                            'cp_id_periode' => $cp_id_periode,
                            'count_period' => $count_period,
                            'asrama' => $asrama,
                            'asrama_1' => $asrama_1,
                            'asrama_2' => $asrama_2,
                            'asrama_3' => $asrama_3,
                            'asrama_4' => $asrama_4,
                            'asrama_1n' => $asrama_1n,
                            'asrama_2n' => $asrama_2n,
                            'asrama_3n' => $asrama_3n,
                            'asrama_4n' => $asrama_4n,
                            'activation' => $activation
                          ]);
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Periode;
use App\Asrama;
use App\KamarReguler;
use Illuminate\Support\Facades\DB;
use App\DaftarAsramaReguler;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class autoAlokasiController extends Controller
{
    public function showForm() {
        if (Auth::guest()) {
          return redirect('/home');
        } else {
          $user = Auth::user();
          if(!($user->is_admin == '1' || $user->is_pengelola == '1')) {
            return redirect('/dashboard');
          }
        } 
        $daftarPeriode = Periode::where('status','buka')->get();
        $daftarAsrama = DB::table('pengelola')
                        ->where('pengelola.id_user', \Auth::id())
                        ->join('asrama', 'asrama.id_asrama', 'pengelola.id_asrama')
                        ->select('asrama.nama')
                        ->first();
        return view('autoAlokasi.form_auto_alokasi', ['daftarPeriode' => $daftarPeriode, 'daftarAsrama' => $daftarAsrama]);
    }

    public function generate(Request $request) {
        if (Auth::guest()) {
          return view('404');
        } else {
          $user = Auth::user();

          if(!($user->is_admin == '1' || $user->is_pengelola == '1')) {
            return view('404');
          }
        }
        /* parsing tanggal periode */
        $tempPeriode = Periode::where('nama', $request->periode)->first();
        $date_start = $tempPeriode->tanggal_awal;
        $date_end = $tempPeriode->tanggal_akhir;

        /* parsing asrama */
        $asrama = $request->asrama;
        $penghuni = DaftarAsramaReguler::where('status', 'Diterima')
                                        ->where('tanggal_masuk', $date_start)
                                        ->where('tanggal_keluar', $date_end)
                                        ->where('asrama', $asrama)
                                        ->get();

        $listKamar = DB::table('asrama')
                         ->where('asrama.nama', $asrama)
                         ->join('gedung', 'gedung.id_asrama', '=', 'asrama.id_asrama')
                         ->join('kamar', 'kamar.id_gedung', '=', 'gedung.id_gedung')
                         ->select('kamar.id_kamar','asrama.nama as namaAsrama', 'gedung.nama as namaGedung', 'kamar.nama', 'kamar.kapasitas', 'kamar.gender')
                         ->where('kamar.status', '=', 'Reguler')
                         ->get();

        foreach($penghuni as $item){
          $item->teralokasi = 0;
        }



        foreach ($listKamar as $itemKamar) {
            Log::info('Kamar:  '.$itemKamar->nama);
            foreach($penghuni as $itemPenghuni){
                Log::info('Pendaftar ke-:  '.$itemPenghuni->id_daftar);
                $jumlahpenghunikamar = DB::table('kamar_reguler')
                                       ->where('kamar_reguler.id_kamar', $itemKamar->id_kamar)
                                       ->where('kamar_reguler.tanggal_awal', '<=', $date_start)
                                       ->select('kamar_reguler.id_pendaftaran_reguler')
                                       ->get();

                if(($jumlahpenghunikamar == null || $jumlahpenghunikamar->count() < $itemKamar->kapasitas) && $itemPenghuni->teralokasi == 0){
                    if($itemKamar->gender == $itemPenghuni->jenis_kelamin){

                        $kamarReguler = new KamarReguler;
                        $kamarReguler->id_pendaftaran_reguler = $itemPenghuni->id_daftar;
                        $kamarReguler->id_kamar = $itemKamar->id_kamar;
                        $kamarReguler->tanggal_awal = $itemPenghuni->tanggal_masuk;
                        $kamarReguler->tanggal_akhir = $itemPenghuni->tanggal_keluar;
                        $kamarReguler->save();

                        $itemPenghuni->teralokasi = 1;

                        $itemPenghuni2 = DaftarAsramaReguler::where('id_daftar', $itemPenghuni->id_daftar)->first();
                        $itemPenghuni2->status = 'Teralokasi';
                        $itemPenghuni2->save();

                        Log::info('Pendaftar ke-:  '.$itemPenghuni->id_daftar.' Berhasil dialokasi ke kamar : '.$itemKamar->nama);
                    }
                } else {
                   break 1;
                }
            }
        }
        return view('alokasi.index');
    }
}

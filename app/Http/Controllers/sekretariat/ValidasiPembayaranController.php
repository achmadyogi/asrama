<?php

namespace App\Http\Controllers\sekretariat;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use App\User_penghuni;
use App\User;
use App\User_nim;
use App\Prodi;
use App\Penghuni;
use Session;
use App\Http\Controllers\Traits\initialDashboard;
use App\Http\Controllers\Traits\tanggalWaktu;
use App\Http\Controllers\Traits\tanggal;
use App\Http\Controllers\Traits\editPeriode;
use App\Http\Controllers\Traits\currency;
use App\Http\Controllers\Traits\PembayaranPenghuniReguler;
use App\Periode;
use dateTime;
use Carbon\Carbon;
use App\Daftar_asrama_non_reguler;
use App\Daftar_asrama_reguler;
use Illuminate\Support\Facades\DB;
use App\Kamar;
use App\Kamar_penghuni;
use App\Pembayaran;
use App\Tarif;
use App\Tagihan;
use App\Penangguhan;
use Illuminate\Support\Facades\Input;

class ValidasiPembayaranController extends Controller
{
    use initialDashboard;
    use tanggalWaktu;
    use tanggal;
    use editPeriode;
    use currency;
    use PembayaranPenghuniReguler;

    public function IndexReguler() {
        if(Pembayaran::where(['is_accepted' => 0])->count() > 0) {
            $pay_reg = DB::select("
                SELECT id_daftar, id, periodes.id_periode, periodes.nama_periode, email, name, foto_profil, status_beasiswa, nomor_transaksi, jumlah_bayar, tanggal_bayar, bank_asal, nama_pengirim, id_pembayaran, jenis_pembayaran, file, bayar.id_tagihan, jumlah_tagihan, is_accepted, registrasi, nim, jenis_kelamin, wil.kamar, wil.gedung, wil.asrama FROM daftar_asrama_reguler 
                LEFT JOIN users ON users.id = daftar_asrama_reguler.id_user 
                LEFT JOIN periodes ON periodes.id_periode = daftar_asrama_reguler.id_periode 
                LEFT JOIN 
                (
                    select pembayaran.id_pembayaran, nomor_transaksi, jumlah_bayar, tanggal_bayar, bank_asal, nama_pengirim, jenis_pembayaran, file, tagihan.id_tagihan, tagihan.daftar_asrama_id, tagihan.daftar_asrama_type, jumlah_tagihan, is_accepted from tagihan 
                    LEFT JOIN pembayaran ON tagihan.id_tagihan = pembayaran.id_tagihan
                ) as bayar ON bayar.daftar_asrama_id = daftar_asrama_reguler.id_daftar AND bayar.daftar_asrama_type = 'Daftar_asrama_reguler' 
                LEFT JOIN user_nim ON user_nim.id_user = daftar_asrama_reguler.id_user 
                LEFT JOIN user_penghuni ON user_penghuni.id_user = daftar_asrama_reguler.id_user 
                LEFT JOIN 
                (
                    select kamar_penghuni.daftar_asrama_id, kamar_penghuni.daftar_asrama_type, tempat.id_kamar, tempat.id_gedung, tempat.id_asrama, tempat.kamar, tempat.gedung, tempat.asrama from kamar_penghuni 
                    LEFT JOIN 
                    (
                        select kamar.id_kamar, kamar.nama as kamar, fasil.id_asrama, fasil.id_gedung, asrama, gedung from kamar 
                        LEFT JOIN 
                        (
                            select asrama.id_asrama, asrama.nama as asrama, gedung.id_gedung, gedung.nama as gedung from gedung 
                            LEFT JOIN asrama ON asrama.id_asrama = gedung.id_asrama
                        ) as fasil ON fasil.id_gedung = kamar.id_gedung
                    ) as tempat ON tempat.id_kamar = kamar_penghuni.id_kamar
                ) as wil ON wil.daftar_asrama_id = daftar_asrama_reguler.id_daftar AND wil.daftar_asrama_type = 'Daftar_asrama_reguler' 
                WHERE daftar_asrama_reguler.verification in (1,5,6) AND bayar.is_accepted = 0");
            $h = 0;
            //dd($pay_reg);
            foreach ($pay_reg as $reg) {
                if($h <= 9){
                    $tanggalBayar[$h] = $this->date($reg->tanggal_bayar);
                    $jumlahBayar[$h] = $this->getCurrency($reg->jumlah_bayar); 
                    $h += 1;
                }else{
                    $h += 1;
                }
            }
            
        } else {
            $pay_reg = 0;
            $tanggalBayar = 0;
            $jumlahBayar = 0;
            $h = 0;
        }
        Session::flash('menu','sekretariat/validasi_pembayaran');
        return view('dashboard.sekretariat.validasiPembayaranReguler', $this->getEditPeriode())->with(['bayar_reguler' => $pay_reg,
                 'tanggal_bayar' => $tanggalBayar,
                 'jumlah_bayar' => $jumlahBayar,
                 'h' => $h]);
    }

    public function nextPrev(Request $request){
        $count = $request->count;
        if(Pembayaran::where(['is_accepted' => 0])->count() > 0) {
            $pay_reg = DB::select("
                SELECT id_daftar, id, periodes.id_periode, periodes.nama_periode, email, name, foto_profil, status_beasiswa, nomor_transaksi, jumlah_bayar, tanggal_bayar, bank_asal, nama_pengirim, id_pembayaran, jenis_pembayaran, file, bayar.id_tagihan, jumlah_tagihan, is_accepted, registrasi, nim, jenis_kelamin, wil.kamar, wil.gedung, wil.asrama FROM daftar_asrama_reguler 
                LEFT JOIN users ON users.id = daftar_asrama_reguler.id_user 
                LEFT JOIN periodes ON periodes.id_periode = daftar_asrama_reguler.id_periode 
                LEFT JOIN 
                (
                    select pembayaran.id_pembayaran, nomor_transaksi, jumlah_bayar, tanggal_bayar, bank_asal, nama_pengirim, jenis_pembayaran, file, tagihan.id_tagihan, tagihan.daftar_asrama_id, tagihan.daftar_asrama_type, jumlah_tagihan, is_accepted from tagihan 
                    LEFT JOIN pembayaran ON tagihan.id_tagihan = pembayaran.id_tagihan
                ) as bayar ON bayar.daftar_asrama_id = daftar_asrama_reguler.id_daftar AND bayar.daftar_asrama_type = 'Daftar_asrama_reguler' 
                LEFT JOIN user_nim ON user_nim.id_user = daftar_asrama_reguler.id_user 
                LEFT JOIN user_penghuni ON user_penghuni.id_user = daftar_asrama_reguler.id_user 
                LEFT JOIN 
                (
                    select kamar_penghuni.daftar_asrama_id, kamar_penghuni.daftar_asrama_type, tempat.id_kamar, tempat.id_gedung, tempat.id_asrama, tempat.kamar, tempat.gedung, tempat.asrama from kamar_penghuni 
                    LEFT JOIN 
                    (
                        select kamar.id_kamar, kamar.nama as kamar, fasil.id_asrama, fasil.id_gedung, asrama, gedung from kamar 
                        LEFT JOIN 
                        (
                            select asrama.id_asrama, asrama.nama as asrama, gedung.id_gedung, gedung.nama as gedung from gedung 
                            LEFT JOIN asrama ON asrama.id_asrama = gedung.id_asrama
                        ) as fasil ON fasil.id_gedung = kamar.id_gedung
                    ) as tempat ON tempat.id_kamar = kamar_penghuni.id_kamar
                ) as wil ON wil.daftar_asrama_id = daftar_asrama_reguler.id_daftar AND wil.daftar_asrama_type = 'Daftar_asrama_reguler' 
                WHERE daftar_asrama_reguler.verification in (1,5,6) AND bayar.is_accepted = 0");
            $h = 0;
            $c = 0;
            //dd($pay_reg);
            foreach ($pay_reg as $reg) {
                if($h >= $count && $h <= $count+9){
                    $tanggalBayar[$h] = $this->date($reg->tanggal_bayar);
                    $jumlahBayar[$h] = $this->getCurrency($reg->jumlah_bayar); 
                    $h += 1;
                    $c += 1;
                }else{
                    $h += 1;
                }
            }
            
        } else {
            $pay_reg = 0;
            $tanggalBayar = 0;
            $h = 0;
            $c = 0;
        }
        return view('dashboard.sekretariat.validasiPembayaranReguler', $this->getEditPeriode())->with(['bayar_reguler' => $pay_reg,
                 'tanggal_bayar' => $tanggalBayar,
                 'jumlah_bayar' => $jumlahBayar,
                 'c' => $c,
                 'h' => $h,
                 'count' => $count]);
    }

    public function SubmitPembayaranReguler(Request $request) {
        // Pemeriksaan pembayaran untuk disetujui
        $pembayaran = Pembayaran::find($request->id_pembayaran);
        if(isset($request->bukti_pembayaran)) {
            $pembayaran->is_accepted = 1;
        }
        $pembayaran->save();

        Session::flash('status2','Pembayaran berhasil diverifikasi.');
        Session::flash('menu','sekretariat/validasi_pembayaran');
        return redirect()->route('validasi_pembayaran');
    }

    public function SubmitPenangguhanReguler(Request $request) {
        // input kelengkapan data penghuni
        $penghuni = new Penghuni();
        $penghuni->daftar_asrama_id = $request->id_daftar;
        $penghuni->daftar_asrama_type = 'Daftar_asrama_reguler';
        if (isset($request->surat_perjanjian)) {
            $penghuni->surat_perjanjian = 1;
        } else {
            $penghuni->surat_perjanjian = 0;
        }
        if(isset($request->ktm)) {
            $penghuni->ktm = 1;
        } else {
            $penghuni->ktm = 0;
        }
        $penghuni->keterangan = $request->keterangan;
        $penghuni->save();

        // Input data kelengkapan syarat penangguhan
        $penangguhan = Penangguhan::find($request->id_penangguhan);
        if(isset($request->sktm)) {
            $penangguhan->is_sktm = 1;
        } else {
            $penangguhan->is_sktm = 0;
        }
        if(isset($request->formulir_penangguhan)) {
            $penangguhan->formulir_penangguhan = 1;
        } else {
            $penangguhan->formulir_penangguhan = 0;
        }
        $penangguhan->save();

        // Keterangan penangguhan pada tabel pembayaran
        $pembayaran = Pembayaran::find($request->id_pembayaran);
        $pembayaran->is_accepted = 2;
        $pembayaran->save();

        // Penghuni telah dinyatakan daftar ulang
        $daftar_reguler = Daftar_asrama_reguler::find($request->id_daftar);
        $daftar_reguler->verification = 5;
        $daftar_reguler->save();

        Session::flash('status2','Penangguhan Telah diverifikasi, mahasiswa telah resmi menjadi penghuni asrama');
        Session::flash('menu','sekretariat/validasi_pembayaran');
        return redirect()->route('validasi_pembayaran');
    }

    public function tolakPembayaran(Request $request){
        // Ambil data penolakan
        $id_daftar = $request->id_daftar;
        $id_bayar = $request->id_pembayaran;
        $catatan = $request->catatan_validator;

        // Masukkan ke tabel pembayaran
        $bayar = Pembayaran::find($id_bayar);
        $bayar->is_accepted = 2; // ditolak
        $bayar->catatan = $catatan;
        $bayar->save();

        Session::flash('status2','Pembayaran berhasil ditolak.');
        Session::flash('menu','sekretariat/validasi_pembayaran');
        return redirect()->route('validasi_pembayaran');
    }
}
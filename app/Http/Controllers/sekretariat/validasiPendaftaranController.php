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
use Session;
use App\Http\Controllers\Traits\initialDashboard;
use App\Http\Controllers\Traits\tanggalWaktu;
use App\Http\Controllers\Traits\tanggal;
use App\Http\Controllers\Traits\editPeriode;
use App\Http\Controllers\Traits\pendaftaranPenghuni;
use App\Periode;
use dateTime;
use Carbon\Carbon;
use App\Daftar_asrama_non_reguler;
use App\Daftar_asrama_reguler;
use Illuminate\Support\Facades\DB;
use App\Kamar;
use App\Kamar_penghuni;
use App\Tarif;
use App\Tagihan;

class validasiPendaftaranController extends Controller
{
    use initialDashboard;
	use tanggalWaktu;
	use tanggal;
	use editPeriode;
    use pendaftaranPenghuni;

    public function index(){
    	Session::flash('menu','sekretariat/validasi_pendaftaran');
    	return view('dashboard.sekretariat.validasiPendaftaran', $this->getEditPeriode())->with($this->getPendaftaranPenghuni());
    }

    protected function inboundNonReg(Request $request){
        $this->Validate($request, [
            'tanggal_masuk' => 'required|date',
            'lama_tinggal' => 'required|numeric',
        ]);

        // GENERATE KAMAR
        // memeriksa apakah id daftar sudah tersedia di kamar penghuni
        if(Kamar_penghuni::where(['daftar_asrama_id'=>$request->id_daftar,'daftar_asrama_type'=>'daftar_asrama_non_reguler'])->count() < 1){
            // Mendapatkan informasi yang dibutuhkan
            $daftarNonReg = Daftar_asrama_non_reguler::find(['id_daftar' => $request->id_daftar])->take(1);
            foreach ($daftarNonReg as $daftarNon) {
                $difable = $daftarNon->is_difable;
                $preference = $daftarNon->preference;
                $kelamin = $daftarNon->user_penghuni->jenis_kelamin;
                $tempo = $daftarNon->tempo;
                $lama = $daftarNon->lama_tinggal;
                $lokasi = $daftarNon->lokasi_asrama;
            }
            // Parameter 1 - Kamar untuk penghuni non reguler (v)
            $kamarNonReguler = DB::select("SELECT asrama.id_asrama, asrama.lokasi_asrama, gedung.id_gedung, room.id_kamar, room.id_gedung, room.nama, kapasitas, status, room.gender, which_user, room.is_difable, idKamar, id_checkout, id_user, id_daftar FROM gedung 
                LEFT JOIN asrama ON gedung.id_asrama = asrama.id_asrama 
                RIGHT JOIN (SELECT kamar.id_kamar, kamar.id_gedung, kamar.nama, kapasitas, status, kamar.gender, which_user, kamar.is_difable, idKamar, id_checkout, id_user, id_daftar FROM kamar 
                    LEFT JOIN (SELECT id_kamar as idKamar, id_checkout, id_user, id_daftar FROM kamar_penghuni 
                    LEFT JOIN (SELECT id_checkout, id_user, id_daftar FROM daftar_asrama_non_reguler 
                        LEFT JOIN checkout ON checkout.daftar_asrama_id = daftar_asrama_non_reguler.id_daftar AND checkout.daftar_asrama_type = 'Daftar_asrama_non_reguler') AS nonReguler ON kamar_penghuni.daftar_asrama_id = nonReguler.id_daftar AND kamar_penghuni.daftar_asrama_type = 'Daftar_asrama_non_reguler') AS kamarNonReguler ON kamar.id_kamar = kamarNonReguler.idKamar) AS room ON room.id_gedung = gedung.id_gedung WHERE room.which_user = 3 AND asrama.lokasi_asrama = ?",[$lokasi]);
            $a = 0;
            foreach ($kamarNonReguler as $kamar) {
                // Parameter 2 - Periksa disabilitas
                if($kamar->is_difable == $difable){
                    // Parameter 3 - Periksa kamar apakah dapat dihuni atau tidak
                    if($kamar->status == 1){
                        // Parameter 4 - Periksa Gender
                        if($kamar->gender == $kelamin){
                            // Periksa preferensi
                            if($preference == 1){
                                // Kalo dia pengen sendiri, harus cari kamar yang isi dua biar hemat
                                if($kamar->kapasitas == 2){
                                    // Periksa apakah kamar masih dihuni penghuni sebelumnya
                                    $cekKamar = DB::select("SELECT kamar_penghuni.id_kamar, kamar_penghuni.daftar_asrama_id, kamar_penghuni.daftar_asrama_type, checkout.id_checkout FROM kamar_penghuni LEFT JOIN checkout ON checkout.daftar_asrama_id = kamar_penghuni.daftar_asrama_id AND checkout.daftar_asrama_type = kamar_penghuni.daftar_asrama_type WHERE kamar_penghuni.id_kamar = :id_kamar AND checkout.id_checkout = NULL",[$kamar->id_kamar]);
                                    // hitung penghuni dalam kamar tersebut
                                    $hit = 0;
                                    foreach ($cekKamar as $ck) {
                                        $hit += 1;
                                    }
                                    // ambil kamarnya jika isinya nggak ada
                                    if($hit == 0){
                                        $collect_id_kamar[$a] = $kamar->id_kamar;
                                        $kapasitas_kamar[$a] = $kamar->kapasitas;
                                        $a += 1;
                                    }
                                }
                            }elseif($preference == 2){
                                // Kalo dia pengen berdua, harus cari kamar yang isi dua
                                if($kamar->kapasitas == 2){
                                    // Periksa apakah kamar masih dihuni penghuni sebelumnya
                                    $cekKamar = DB::select("SELECT kamar_penghuni.id_kamar, kamar_penghuni.daftar_asrama_id, kamar_penghuni.daftar_asrama_type, checkout.id_checkout FROM kamar_penghuni LEFT JOIN checkout ON checkout.daftar_asrama_id = kamar_penghuni.daftar_asrama_id AND checkout.daftar_asrama_type = kamar_penghuni.daftar_asrama_type WHERE kamar_penghuni.id_kamar = :id_kamar AND checkout.id_checkout = NULL",[$kamar->id_kamar]);
                                    // hitung penghuni dalam kamar tersebut
                                    $hit = 0;
                                    foreach ($cekKamar as $ck) {
                                        $hit += 1;
                                    }
                                    // ambil kamarnya jika isinya nggak ada
                                    if($hit < 2){
                                        $collect_id_kamar[$a] = $kamar->id_kamar;
                                        $kapasitas_kamar[$a] = $kamar->kapasitas;
                                        $a += 1;
                                    }
                                }
                            }elseif($preference == 3){
                                // Kalo dia pengen bertiga, harus cari kamar yang isi tiga
                                if($kamar->kapasitas == 3){
                                    // Periksa apakah kamar masih dihuni penghuni sebelumnya
                                    $cekKamar = DB::select("SELECT kamar_penghuni.id_kamar, kamar_penghuni.daftar_asrama_id, kamar_penghuni.daftar_asrama_type, checkout.id_checkout FROM kamar_penghuni LEFT JOIN checkout ON checkout.daftar_asrama_id = kamar_penghuni.daftar_asrama_id AND checkout.daftar_asrama_type = kamar_penghuni.daftar_asrama_type WHERE kamar_penghuni.id_kamar = :id_kamar AND checkout.id_checkout = NULL",[$kamar->id_kamar]);
                                    // hitung penghuni dalam kamar tersebut
                                    $hit = 0;
                                    foreach ($cekKamar as $ck) {
                                        $hit += 1;
                                    }
                                    // ambil kamarnya jika isinya nggak ada
                                    if($hit < 3){
                                        $collect_id_kamar[$a] = $kamar->id_kamar;
                                        $kapasitas_kamar[$a] = $kamar->kapasitas;
                                        $a += 1;
                                    }
                                }
                            }
                        }
                    }
                }
            }
            // Ambil satu kamar jika pilihan setidaknya ada satu, dan jika tidak ada pilihan akan dikembalikan
            if($a - 1 != 0){
                $pick_kamar = array_rand($collect_id_kamar,1);
            }else{
                Session::flash('menu','sekretariat/validasi_pendaftaran');
                Session::flash('status1','Pilihan kamar sudah habis atau tidak tersedia untuk kategori ini. Silahkan ganti rencana tinggal pendaftar.');
                return view('dashboard.sekretariat.validasiPendaftaran', $this->getEditPeriode())->with($this->getPendaftaranPenghuni());
            }

            // GENERATE TAGIHAN
            // Ambil id gedung
            $id_kamar = DB::select("SELECT asrama.id_asrama, bangunan.id_gedung, bangunan.id_kamar FROM asrama RIGHT JOIN (SELECT kamar.id_kamar, gedung.id_gedung, gedung.id_asrama FROM kamar LEFT JOIN gedung ON kamar.id_gedung = gedung.id_gedung) AS bangunan ON bangunan.id_asrama = asrama.id_asrama WHERE bangunan.id_kamar = ?",[$collect_id_kamar[$pick_kamar]]);
            foreach ($id_kamar as $kamar) {
                $id_k = $kamar->id_gedung;
            }
            // Ambil tarif
            $tarif = DB::select('SELECT * FROM tarif WHERE id_asrama = :id_asrama AND tempo = :tempo AND kapasitas_kamar = :kap', ['id_asrama'=>$id_k,'tempo'=>$request->tempo, 'kap'=>$kapasitas_kamar[$pick_kamar]]);       
            foreach ($tarif as $tarif){
                $sarjana = $tarif->tarif_sarjana;
                $pasca_sarjana = $tarif->tarif_pasca_sarjana;
                $international = $tarif->tarif_international;
                $umum = $tarif->tarif_umum;
            }
            // Periksa pendaftar apakah S1, S2, S3, atau umum
            $strata = DB::select("SELECT strata, prodi, id_daftar, id FROM prodi RIGHT JOIN (SELECT user_nim.id_prodi AS prodi, id_daftar, id FROM user_nim RIGHT JOIN (SELECT id_daftar, id FROM daftar_asrama_non_reguler LEFT JOIN users ON daftar_asrama_non_reguler.id_user = users.id) AS penghuni ON penghuni.id = user_nim.id_user) AS nim ON nim.prodi = prodi.id_prodi WHERE nim.id_daftar = ?",[$request->id_daftar]);
            foreach($strata as $strata){
                $stra = $strata->strata;
            }
            if($stra == 1){
                // Dapatkan harga tarif
                $satuan_tagihan = $sarjana;
            }elseif($stra == 2 || $stra == 9){
                // Dapatkan harga tarif
                $satuan_tagihan = $pasca_sarjana;
            }elseif($stra == 3){
                // Dapatkan harga tarif
                $satuan_tagihan = $international;
            }else{
                // Dapatkan harga tarif
                $satuan_tagihan = $umum;
            }
            // Hitung total tagihan
            if($satuan_tagihan == NULL){
                if($umum != NULL){
                    if($preference == 1){
                        $tagihan_total = $umum*$request->lama_tinggal*$kapasitas_kamar[$pick_kamar];
                    }else{
                        $tagihan_total = $umum*$request->lama_tinggal;
                    }
                }else{
                    Session::flash('status1','Kamar tidak tersedia atau tarif tidak tersedia.');
                    return view('dashboard.sekretariat.validasiPendaftaran', $this->getEditPeriode())->with($this->getPendaftaranPenghuni());
                }
            }
            else{
                if($preference == 1){
                    $tagihan_total = $satuan_tagihan*$request->lama_tinggal*$kapasitas_kamar[$pick_kamar];
                }else{
                    $tagihan_total = $satuan_tagihan*$request->lama_tinggal;
                }
            }
            // Masukkan tagihan ke database
            Tagihan::create([
                    'daftar_asrama_id' => $request->id_daftar,
                    'daftar_asrama_type' => 'daftar_asrama_non_reguler',
                    'jumlah_tagihan' => $tagihan_total
                    ]);

            // Isi table kamar penghuni
            $kamar_penghuni_baru = Kamar_penghuni::create([
                                    'daftar_asrama_id' => $request->id_daftar,
                                    'daftar_asrama_type' => 'Daftar_asrama_non_reguler',
                                    'id_kamar' => $collect_id_kamar[$pick_kamar]
                                    ]);

            // Update verification untuk disetujui
            $setuju = Daftar_asrama_non_reguler::find($request->id_daftar);
            $setuju->verification = 1;
            $setuju->tanggal_masuk = $request->tanggal_masuk;
            $setuju->lama_tinggal = $request->lama_tinggal;
            $setuju->tempo = $request->tempo;
            $setuju->save();

            Session::flash('status2','Verifikasi berhasil dilakukan. Proses selanjutnya adalah pembayaran untuk rencana tinggal yang sudah disetujui.');
            Session::flash('menu','sekretariat/validasi_pendaftaran');
            return view('dashboard.sekretariat.validasiPendaftaran', $this->getEditPeriode())->with($this->getPendaftaranPenghuni());
        }else{
            Session::flash('status1','Penghuni sudah terdaftar memiliki kamar.');
            return view('dashboard.sekretariat.validasiPendaftaran', $this->getEditPeriode())->with($this->getPendaftaranPenghuni());
        }
    }
}

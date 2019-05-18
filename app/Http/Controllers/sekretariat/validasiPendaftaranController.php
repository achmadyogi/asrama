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
use App\Blacklist;
use Session;
use App\Http\Controllers\Traits\initialDashboard;
use App\Http\Controllers\Traits\tanggalWaktu;
use App\Http\Controllers\Traits\tanggal;
use App\Http\Controllers\Traits\editPeriode;
use App\Http\Controllers\Traits\pendaftaranPenghuniNonReguler;
use App\Http\Controllers\Traits\pendaftaranPenghuniReguler;
use App\Http\Controllers\Traits\currency;
use App\Periode;
use dateTime;
use Carbon\Carbon;
use App\Daftar_asrama_non_reguler;
use App\Daftar_asrama_reguler;
use Illuminate\Support\Facades\DB;
use App\Kamar;
use App\Asrama;
use App\Gedung;
use App\Kamar_penghuni;
use App\Tarif;
use App\Tagihan;
use App\Checkout;
use Mail;
use Illuminate\Support\Facades\Input;
use App\Mail\VerifikasiReguler;
use App\Mail\VerifikasiNonReguler;
use App\Mail\waitingListEmail;
use App\Mail\PengumumanCalonPenghuniAsramaITB;
use App\Mail\PenerimaanNonReguler;
use App\Mail\WaitingListNonReguler;
use App\Mail\PengumumanCalonPenghuniNonReguler;

class validasiPendaftaranController extends Controller
{
    use initialDashboard;
	use tanggalWaktu;
	use tanggal;
	use editPeriode;
    use pendaftaranPenghuniNonReguler;
    use pendaftaranPenghuniReguler;
    use currency;

    // ------- REGULER ------- //
    public function indexReguler(){
        Session::flash('menu','sekretariat/validasi_pendaftaran_reguler');
        return view('dashboard.sekretariat.validasiPendaftaranReguler', $this->getEditPeriode())->with($this->getPendaftaranPenghuniReguler());
    }
    
    public function AjaxGedung(Request $request) {
        $asrama_id = $request->id_asrama;
        $gedung = Gedung::where('id_asrama', '=', $asrama_id)->get();
        return response()->json($gedung);
    }

    public function AjaxKamar(Request $request) {
        $gedung_id = $request->id_gedung;
        $kamar = Kamar::where('id_gedung', '=', $gedung_id)->get();
        return response()->json($kamar);
    }
    
    public function AjaxLanjutPeriode(Request $request) {
        $id_user = $request->id_user;
        $data_kamar = DB::select('SELECT asrama.id_asrama, asrama.nama as asrama, gedung.id_gedung, gedung.nama as gedung, kamar.id_kamar, kamar.nama as kamar FROM daftar_asrama_reguler, kamar_penghuni, kamar, gedung, asrama WHERE
                                  daftar_asrama_reguler.id_daftar = kamar_penghuni.daftar_asrama_id AND kamar_penghuni.id_kamar = kamar.id_kamar AND kamar.id_gedung = gedung.id_gedung
                                  AND gedung.id_asrama = asrama.id_asrama AND daftar_asrama_reguler.id_user = ? AND daftar_asrama_reguler.verification = 5',[$id_user]);
        return response()->json($data_kamar);
    }

    // Alokasi Otomatis Pendaftaran Reguler
    protected function inboundReg(Request $request){
        // Pemeriksaan total kamar
        $pengisi = DB::select("SELECT id_kamar, count(id_kamar) FROM daftar_asrama_reguler LEFT JOIN kamar_penghuni ON daftar_asrama_reguler.id_daftar = kamar_penghuni.daftar_asrama_id AND daftar_asrama_type = 'daftar_asrama_reguler' WHERE verification IN (1,5) AND id_kamar = ? GROUP BY id_kamar", [$request->id_kamar]);
        $kap = 0;
        foreach ($pengisi as $k) {
            $kap += 1;
        }
        if($kap >= Kamar::find($request->id_kamar)->kapasitas){
            Session::flash('status1','Kamar sudah penuh, kemungkinan terdapat verifikasi di tempat lain sehingga terdahului terisi. Silahkan lakukan verifikasi ulang');
            Session::flash('menu','sekretariat/validasi_pendaftaran');
            return redirect()->route('validasi_pendaftaran_reguler', $this->getEditPeriode())->with($this->getPendaftaranPenghuniReguler());
        }
        // Masukkan tagihan ke database
        Tagihan::create([
                'daftar_asrama_id' => $request->id_daftar,
                'daftar_asrama_type' => 'daftar_asrama_reguler',
                'jumlah_tagihan' => $request->tagihan_total
                ]);

        // Isi table kamar penghuni
        $kamar_penghuni_baru = Kamar_penghuni::create([
                                'daftar_asrama_id' => $request->id_daftar,
                                'daftar_asrama_type' => 'Daftar_asrama_reguler',
                                'id_kamar' => $request->id_kamar
                                ]);

        // Update verification untuk disetujui
        $setuju = Daftar_asrama_reguler::find($request->id_daftar);
        $setuju->verification = 1;
        $setuju->tanggal_masuk = $request->tanggal_masuk_reg;
        $setuju->save();

        // Update is penghuni jadi 1
        $is_penghuni = User::find(Daftar_asrama_reguler::find($request->id_daftar)->id_user);
        $is_penghuni->is_penghuni = 1;
        $is_penghuni->save();
        // Kirim email ke penghuni yang sudah terverifikasi
        $getID = User::find(Daftar_asrama_reguler::find($request->id_daftar)->id_user);
        Mail::to($getID->email)->send(new VerifikasiReguler(Daftar_asrama_reguler::find($request->id_daftar)));

        // Buat session untuk report
        Session::flash('status2','Verifikasi berhasil dilakukan. Proses selanjutnya adalah pembayaran untuk rencana tinggal yang sudah disetujui.');
        Session::flash('menu','sekretariat/validasi_pendaftaran');
        return redirect()->route('validasi_pendaftaran_reguler', $this->getEditPeriode())->with($this->getPendaftaranPenghuniReguler());
    }

    // Pemeriksaan ketersediaan alokasi kamar baru
    public function alokasi_reg(Request $request){
        // Memastikan calon penghuni tidak sedang diterima atau berstatus aktif di asrama
        $id_user = Daftar_asrama_reguler::find($request->id_daftar)->id_user;

        // Tidak berstatus diterima atau aktif di pendaftaran reguler
        $tinggal = DB::select("SELECT id_checkout, id, id_daftar FROM daftar_asrama_reguler LEFT JOIN checkout ON checkout.daftar_asrama_id = daftar_asrama_reguler.id_daftar AND checkout.daftar_asrama_type = 'daftar_asrama_reguler' LEFT JOIN users ON users.id = daftar_asrama_reguler.id_user WHERE daftar_asrama_reguler.verification IN (1,5) AND daftar_asrama_reguler.id_user = ?",[$id_user]);
        foreach ($tinggal as $tinggal) {
            if($tinggal->id_checkout == NULL){
                $message = 'Penghuni bersangkutan masih berstatus tinggal di asrama dan belum keluar. Tunggu hingga checkout atau batalkan pendaftaran.';
                return view('dashboard.sekretariat.ajax.alokasi_reg', ['message' => $message]);
            }
        }

        // Memastikan calon penghuni sudah tidak memiliki tanggungan keuangan lagi.
        $tanggungan = DB::select("SELECT bill_detail.id_user, SUM(bill_detail.kurangan) as total_kurangan FROM (SELECT bill.id_user, bill.id_daftar, bill.verification, bill.jumlah_tagihan, SUM(jumlah_bayar) as total_bayar, bill.jumlah_tagihan - SUM(jumlah_bayar) AS kurangan FROM pembayaran LEFT JOIN (SELECT id_user, id_daftar, verification, id_tagihan, jumlah_tagihan FROM daftar_asrama_reguler LEFT JOIN tagihan ON tagihan.daftar_asrama_id = daftar_asrama_reguler.id_daftar AND tagihan.daftar_asrama_type = 'daftar_asrama_reguler') AS bill ON bill.id_tagihan = pembayaran.id_tagihan WHERE verification IN (5,6) AND is_accepted = 1 GROUP BY pembayaran.id_tagihan) bill_detail WHERE id_user = ? GROUP BY bill_detail.id_user", [$id_user]);
        foreach ($tanggungan as $t) {
            if($t->total_kurangan > 0){
                $message = 'Calon penghuni masih memiliki tanggungan pembayaran yang belum diselesaikan. Penerimaan hanya bisa dilakukan apabila seluruh tagihan sudah dipenuhi pembayarannya.';
                return view('dashboard.sekretariat.ajax.alokasi_reg', ['message' => $message]);
            }
        }

        // GENERATE KAMAR
         // memeriksa apakah id daftar sudah tersedia di kamar penghuni
        if(Kamar_penghuni::where(['daftar_asrama_id'=>$request->id_daftar,'daftar_asrama_type'=>'daftar_asrama_reguler'])->count() < 1){
            // Mendapatkan informasi yang dibutuhkan
            $preference = $request->preference;
            $daftarReg = Daftar_asrama_reguler::find(['id_daftar' => $request->id_daftar])->take(1);
            foreach ($daftarReg as $daftar) {
                $kelamin = $daftar->user_penghuni->jenis_kelamin;
                if($daftar->is_international == 1){
                    $which_user = 2;
                }else{
                    $which_user = 1; // Jadi reguler biasa
                }
                $lokasi = $daftar->lokasi_asrama;
            }
            /* 
                Mengambil kamar berfilter berikut
                1. lokasi asrama (obligatory),
                2. status (obligatory),
                3. gender (obligatory),
                5. kapasitas kamar (optional) -> bila preference sendiri diarahkan ke kapasitas berdua (khusus mahasiswa internasional. Mahasiswa reguler tidak boleh sendirian.)
            */
            $kamarReguler = DB::select("SELECT kamar.nama AS kamar, id_kamar, kapasitas, status, gender, which_user, is_difable, build.lokasi_asrama FROM kamar LEFT JOIN (SELECT id_gedung, lokasi_asrama FROM gedung LEFT JOIN asrama ON asrama.id_asrama = gedung.id_asrama) AS build ON kamar.id_gedung = build.id_gedung WHERE status = 1 AND gender = ? AND build.lokasi_asrama = ? AND which_user = ?",[$kelamin, $lokasi, $which_user]);
            $a = 0;
            foreach ($kamarReguler as $kamar) {
                // Periksa preferensi
                if($preference == 2 || $preference == 1){
                    // Kalo dia pengen berdua, harus cari kamar yang isi dua
                    if($kamar->kapasitas == 2){
                        // Periksa apakah kamar masih dihuni penghuni sebelumnya
                        $cekKamar = DB::select("SELECT id_kamar, count(id_kamar) as total FROM daftar_asrama_reguler LEFT JOIN kamar_penghuni ON daftar_asrama_reguler.id_daftar = kamar_penghuni.daftar_asrama_id AND daftar_asrama_type = 'daftar_asrama_reguler' WHERE verification IN (1,5) AND id_kamar = ? GROUP BY id_kamar",[$kamar->id_kamar]);
                        // hitung penghuni dalam kamar tersebut
                        $hit = 0;
                        foreach ($cekKamar as $ck) {
                            $hit = $ck->total;
                        }
                        // ambil kamarnya jika isinya belum penuh
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
                        $cekKamar = DB::select("SELECT id_kamar, count(id_kamar) as total FROM daftar_asrama_reguler LEFT JOIN kamar_penghuni ON daftar_asrama_reguler.id_daftar = kamar_penghuni.daftar_asrama_id AND daftar_asrama_type = 'daftar_asrama_reguler' WHERE verification IN (1,5) AND id_kamar = ? GROUP BY id_kamar",[$kamar->id_kamar]);
                        // hitung penghuni dalam kamar tersebut
                        $hit2 = 0;
                        foreach ($cekKamar as $ck) {
                            $hit2 = $ck->total;
                        }
                        // ambil kamarnya jika isinya belum penuh
                        if($hit2 < 3){
                            $collect_id_kamar[$a] = $kamar->id_kamar;
                            $kapasitas_kamar[$a] = $kamar->kapasitas;
                            $a += 1;
                        }
                    }
                }
            }

            // Ambil satu kamar jika pilihan setidaknya ada satu, dan jika tidak ada pilihan akan dikembalikan
            if($a > 0){
                $pick_kamar = array_rand($collect_id_kamar,1);
            }else{
                $message = 'Kamar tidak tersedia untuk kategori calon penghuni.<br>
                <ol>
                    <li>Bila calon penghuni merupakan penyandang disabilitas, gunakan alokasi manual untuk menempatkan dikamar yang sesuai</li>
                    <li>Bila calon penghuni merupakan mahasiswa internasional, maka kamar tersebut saat ini sudah habis. Gunakan alokasi manual untuk menempatkannya di kamar reguler yang di sediakan untuk penghuni internasional.</li>
                    <li>Ganti preferensi kamar berdua menjadi bertiga atau sebaliknya karena ketersediaan kamar sudah habis untuk preferensi yang diminta.</li>
                </ol>
                ';
                return view('dashboard.sekretariat.ajax.alokasi_reg', ['message' => $message]);
            }

            // GENERATE TAGIHAN
            // Ambil id gedung
            $id_kamar = DB::select("SELECT asrama.id_asrama, bangunan.id_gedung, bangunan.id_kamar FROM asrama RIGHT JOIN (SELECT kamar.id_kamar, gedung.id_gedung, gedung.id_asrama FROM kamar LEFT JOIN gedung ON kamar.id_gedung = gedung.id_gedung) AS bangunan ON bangunan.id_asrama = asrama.id_asrama WHERE bangunan.id_kamar = ?",[$collect_id_kamar[$pick_kamar]]);
            foreach ($id_kamar as $kamar) {
                $id_k = $kamar->id_asrama;
            }
            // Ambil tarif
            $tarif = DB::select("SELECT * FROM tarif WHERE id_asrama = :id_asrama AND tempo = 'bulanan' AND kapasitas_kamar = :kap", ['id_asrama'=>$id_k, 'kap'=>$kapasitas_kamar[$pick_kamar]]);       
            foreach ($tarif as $tarif){
                $sarjana = $tarif->tarif_sarjana;
                $pasca_sarjana = $tarif->tarif_pasca_sarjana;
                $international = $tarif->tarif_international;
                $umum = $tarif->tarif_umum;
            }
            // Periksa pendaftar apakah S1, S2, S3, atau umum
            $strata = DB::select("SELECT strata, prodi, id_daftar, id FROM prodi RIGHT JOIN (SELECT user_nim.id_prodi AS prodi, id_daftar, id FROM user_nim RIGHT JOIN (SELECT id_daftar, id FROM daftar_asrama_reguler LEFT JOIN users ON daftar_asrama_reguler.id_user = users.id) AS penghuni ON penghuni.id = user_nim.id_user) AS nim ON nim.prodi = prodi.id_prodi WHERE nim.id_daftar = ?",[$request->id_daftar]);
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
                    $tagihan_total = $umum*5;
                }else{
                    $message = 'Kamar tidak tersedia atau tarif tidak tersedia.';
                    return view('dashboard.sekretariat.ajax.alokasi_reg', ['message' => $message]);
                }
            }
            else{
                $tagihan_total = $satuan_tagihan*5;
            }
            // Lemparkan variable
            $kamarVar = Kamar::find($collect_id_kamar[$pick_kamar]);
            $gedungVar = Gedung::find($kamarVar->id_gedung);
            $asramaVar = Asrama::find($gedungVar->id_asrama);
            // cari kapasitas kamar
            $pengisi = DB::select("SELECT id_kamar, count(id_kamar) as total FROM daftar_asrama_reguler LEFT JOIN kamar_penghuni ON daftar_asrama_reguler.id_daftar = kamar_penghuni.daftar_asrama_id AND daftar_asrama_type = 'daftar_asrama_reguler' WHERE verification IN (1,5) AND id_kamar = ? GROUP BY id_kamar", [$collect_id_kamar[$pick_kamar]]);
            $kap = 0;
            foreach ($pengisi as $k) {
                $kap += $k->total;
            }
            return view('dashboard.sekretariat.ajax.alokasi_reg', ['jumlah_tagihan'=> $this->getCurrency($tagihan_total), 'kamarVar' => $kamarVar, 'gedungVar' => $gedungVar, 'asramaVar' => $asramaVar, 'preference' => $preference, 'kap' => $kap, 'real_tagihan' => $tagihan_total, 'id_daftar' => $request->id_daftar, 'preference' => $preference, 'id_user' => Daftar_asrama_reguler::find($request->id_daftar)->id_user, 'tanggal_masuk_reg' => $request->tanggal_masuk_reg]);
            return view('dashboard.sekretariat.ajax.alokasi_reg', ['message' => $message]);
        }else{
            $message = 'Penghuni sudah terdaftar memiliki kamar.';
            return view('dashboard.sekretariat.ajax.alokasi_reg', ['message' => $message]);
        }
    }

    // Pemeriksaan ketersediaan alokasi kamar lama
    public function alokasi_reg_lama_matic(Request $request){
        // mengambil id user
        $id_user = Daftar_asrama_reguler::find($request->id_daftar)->id_user;

        // Menolak penghuni yang masih berstatus aktif
        if(Daftar_asrama_reguler::where(['id_user' => $id_user, 'verification' => 5])->count() > 0){
            $message = "Penghuni masih bersatus aktif tinggal di asrama. Pastikan penghuni ini sudah checkout untuk bisa diverifikasi di kepenghunian baru.";
            return view('dashboard.sekretariat.ajax.alokasi_reg_lama_matic', ['message' => $message]);
        }

        // Memeriksa apakah dia termasuk penghuni lama
        if(Daftar_asrama_reguler::where(['id_user' => $id_user, 'verification' => 6])->count() == 0){
            $message = "Calon penghuni merupakan penghuni baru. Lakukan alokasi untuk kamar baru.";
            return view('dashboard.sekretariat.ajax.alokasi_reg_lama_matic', ['message' => $message]);
        }

        // Menampilkan data alokasi kamar
        $collect_id_daftar = Daftar_asrama_reguler::where(['id_user' => $id_user, 'verification' => 6])->get();

        // Dapatkan id kamar
        $a = 0;
        foreach ($collect_id_daftar as $c) {
            $collect_id_kamar = Kamar_penghuni::where(['daftar_asrama_id' => $c->id_daftar, 'daftar_asrama_type' => 'daftar_asrama_reguler'])->get();
            $id_daftar_collection[$a] = $c->id_daftar;
            foreach ($collect_id_kamar as $ck) {
                $id_kamar_collection[$a] = $ck->id_kamar;
            }
            $a += 1;
        }

        // Dapatkan data kamar
        $id_kamar = array_rand($id_kamar_collection, 1);
        $dataKamar = Kamar::find($id_kamar_collection[$id_kamar]);
        $dataGedung = Gedung::find($dataKamar->id_gedung);
        $dataAsrama = Asrama::find($dataGedung->id_asrama);
        $dataPeriode = Periode::find(Daftar_asrama_reguler::find($id_daftar_collection[$id_kamar])->id_periode);

        // Dapatkan data tagihan
            // Ambil tarif
            if(Tarif::where(['id_asrama' => $dataGedung->id_asrama, 'tempo' => 'bulanan', 'kapasitas_kamar' => $dataKamar->kapasitas])->count() == 0){
                $message = 'Tidak ada tarif untuk kamar ini. Lakukan verifikasi secara manual atau pindahkan ke kamar baru.';
                return view('dashboard.sekretariat.ajax.alokasi_reg_lama_matic', ['message' => $message]);
            }else{
                $tarif = Tarif::where(['id_asrama' => $dataGedung->id_asrama, 'tempo' => 'bulanan', 'kapasitas_kamar' => $dataKamar->kapasitas])->get();     
                foreach ($tarif as $tarif){
                    $sarjana = $tarif->tarif_sarjana;
                    $pasca_sarjana = $tarif->tarif_pasca_sarjana;
                    $international = $tarif->tarif_international;
                    $umum = $tarif->tarif_umum;
                }
            }
            
            // Periksa pendaftar apakah S1, S2, S3, atau umum
            $strata = DB::select("SELECT strata, prodi, id_daftar, id FROM prodi RIGHT JOIN (SELECT user_nim.id_prodi AS prodi, id_daftar, id FROM user_nim RIGHT JOIN (SELECT id_daftar, id FROM daftar_asrama_reguler LEFT JOIN users ON daftar_asrama_reguler.id_user = users.id) AS penghuni ON penghuni.id = user_nim.id_user) AS nim ON nim.prodi = prodi.id_prodi WHERE nim.id_daftar = ?",[$request->id_daftar]);
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
                    $tagihan_total = $umum*5;
                }else{
                    $message = 'Kamar tidak tersedia atau tarif tidak tersedia.';
                    return view('dashboard.sekretariat.ajax.alokasi_reg_lama_matic', ['message' => $message]);
                }
            }
            else{
                $tagihan_total = $satuan_tagihan*5;
            }

        // cari kapasitas kamar
        $pengisi = DB::select("SELECT id_kamar, count(id_kamar) as total FROM daftar_asrama_reguler LEFT JOIN kamar_penghuni ON daftar_asrama_reguler.id_daftar = kamar_penghuni.daftar_asrama_id AND daftar_asrama_type = 'daftar_asrama_reguler' WHERE verification IN (1,5) AND id_kamar = ? GROUP BY id_kamar", [$dataKamar->id_kamar]);
        $kap = 0;
        foreach ($pengisi as $k) {
            $kap += $k->total;
        }

        return view('dashboard.sekretariat.ajax.alokasi_reg_lama_matic', ['jumlah_tagihan'=> $this->getCurrency($tagihan_total), 'real_tagihan' => $tagihan_total, 'dataKamar' => $dataKamar, 'dataGedung' => $dataGedung, 'dataAsrama' => $dataAsrama, 'kap' => $kap, 'id_daftar' => $request->id_daftar, 'preference' => $request->preference, 'difable'=> $request->difable, 'tanggal_masuk_reg' => $request->tanggal_masuk_reg, 'id_user' => Daftar_asrama_reguler::find($request->id_daftar)->id_user, 'dataPeriode' => $dataPeriode]);

    }

    // Alokasi Manual Pendaftaran Reguler
    public function AlokasiManualReguler(Request $request) {
        // GENERATE KAMAR
        //Memeriksa apakah verifikasi merupakan pindah periode atau verifikasi baru
        if($request->cek_lanjut == 1) {
            //Mendapatkan data periode sebelumnya
            $user_old = DB::select('SELECT * FROM daftar_asrama_reguler WHERE id_user = ? AND verification = 5',[$request->id_user]);
            // memeriksa apakah id daftar sudah tersedia di kamar penghuni
            if(Kamar_penghuni::where(['daftar_asrama_id'=>$request->id_daftar,'daftar_asrama_type'=>'daftar_asrama_reguler'])->count() < 1){
                //Mengubah jenis checkout di table checkout menjadi 2
                $user_checkout = new Checkout();
                $user_checkout->daftar_asrama_id = $user_old[0]->id_daftar;
                $user_checkout->daftar_asrama_type = 'daftar_asrama_reguler';
                $user_checkout->jenis_checkout = 1;
                $user_checkout->alasan_checkout = "Checkout akhir periode, untuk lanjut periode";
                $user_checkout->tanggal_masuk = $user_old[0]->tanggal_masuk;
                $user_checkout->tanggal_keluar = Carbon::now();
                $user_checkout->save();

                //Mengubah verification di daftar_asrama_reguler menjadi 6
                $update_pendaftaran = Daftar_asrama_reguler::find($user_old[0]->id_daftar);
                $update_pendaftaran->verification = 6;
                $update_pendaftaran->save();
            
                // Masukkan tagihan ke database
                $tagihan = new Tagihan();
                $tagihan->daftar_asrama_id = $request->id_daftar;
                $tagihan->daftar_asrama_type = 'daftar_asrama_reguler';
                if($request->tagihan == 1) {
                    $tagihan->jumlah_tagihan = 1500000;
                } elseif($request->tagihan == 2) {
                    $tagihan->jumlah_tagihan = 2250000;
                } elseif($request->tagihan == 3) {
                    $tagihan->jumlah_tagihan = 0;
                } else {
                    $tagihan->jumlah_tagihan = $request->tagihan_lain;
                }
                $tagihan->save();
    
                // Isi table kamar penghuni
                $kamar_penghuni_baru = Kamar_penghuni::create([
                                        'daftar_asrama_id' => $request->id_daftar,
                                        'daftar_asrama_type' => 'Daftar_asrama_reguler',
                                        'id_kamar' => $request->kamar,
                                        ]);
    
                // Update verification untuk disetujui
                $setuju = Daftar_asrama_reguler::find($request->id_daftar);
                $setuju->verification = 1;
                $setuju->tanggal_masuk = $request->tanggal_masuk_reg;
                $setuju->save();
    
                // Update is penghuni jadi 1
                $is_penghuni = User::find(Daftar_asrama_reguler::find($request->id_daftar)->id_user);
                $is_penghuni->is_penghuni = 1;
                $is_penghuni->save();
                // Kirim email ke penghuni yang sudah terverifikasi
                $getID = User::find(Daftar_asrama_reguler::find($request->id_daftar)->id_user);
                Mail::to($getID->email)->send(new VerifikasiReguler(Daftar_asrama_reguler::find($request->id_daftar)));
    
                // Buat session untuk report
                Session::flash('status2','Verifikasi berhasil dilakukan. Proses selanjutnya adalah pembayaran untuk rencana tinggal yang sudah disetujui.');
                Session::flash('menu','sekretariat/validasi_pendaftaran');
                return redirect()->route('validasi_pendaftaran_reguler', $this->getEditPeriode())->with($this->getPendaftaranPenghuniReguler());
            }else{
                Session::flash('status1','Penghuni sudah terdaftar memiliki kamar.');
                return redirect()->route('validasi_pendaftaran_reguler', $this->getEditPeriode())->with($this->getPendaftaranPenghuniReguler());
            }
        } else {
            // memeriksa apakah id daftar sudah tersedia di kamar penghuni
            if(Kamar_penghuni::where(['daftar_asrama_id'=>$request->id_daftar,'daftar_asrama_type'=>'daftar_asrama_reguler'])->count() < 1){
            
                // Masukkan tagihan ke database
                $tagihan = new Tagihan();
                $tagihan->daftar_asrama_id = $request->id_daftar;
                $tagihan->daftar_asrama_type = 'daftar_asrama_reguler';
                if($request->tagihan == 1) {
                    $tagihan->jumlah_tagihan = 1500000;
                } elseif($request->tagihan == 2) {
                    $tagihan->jumlah_tagihan = 2250000;
                } elseif($request->tagihan == 3) {
                    $tagihan->jumlah_tagihan = 0;
                } else {
                    $tagihan->jumlah_tagihan = $request->tagihan_lain;
                }
                $tagihan->save();
    
                // Isi table kamar penghuni
                $kamar_penghuni_baru = Kamar_penghuni::create([
                                        'daftar_asrama_id' => $request->id_daftar,
                                        'daftar_asrama_type' => 'Daftar_asrama_reguler',
                                        'id_kamar' => $request->kamar,
                                        ]);
    
                // Update verification untuk disetujui
                $setuju = Daftar_asrama_reguler::find($request->id_daftar);
                $setuju->verification = 1;
                $setuju->tanggal_masuk = $request->tanggal_masuk_reg;
                $setuju->save();
    
                // Update is penghuni jadi 1
                $is_penghuni = User::find(Daftar_asrama_reguler::find($request->id_daftar)->id_user);
                $is_penghuni->is_penghuni = 1;
                $is_penghuni->save();
                // Kirim email ke penghuni yang sudah terverifikasi
                $getID = User::find(Daftar_asrama_reguler::find($request->id_daftar)->id_user);
                Mail::to($getID->email)->send(new VerifikasiReguler(Daftar_asrama_reguler::find($request->id_daftar)));
    
                // Buat session untuk report
                Session::flash('status2','Verifikasi berhasil dilakukan. Proses selanjutnya adalah pembayaran untuk rencana tinggal yang sudah disetujui.');
                Session::flash('menu','sekretariat/validasi_pendaftaran');
                return redirect()->route('validasi_pendaftaran_reguler', $this->getEditPeriode())->with($this->getPendaftaranPenghuniReguler());
            }else{
                Session::flash('status1','Penghuni sudah terdaftar memiliki kamar.');
                return redirect()->route('validasi_pendaftaran_reguler', $this->getEditPeriode())->with($this->getPendaftaranPenghuniReguler());
            }
        }
    }

    // Pendaftaran Reguler terblacklist
    public function blacklist(Request $request) {
        $blacklist = Daftar_asrama_reguler::find($request->id_daftar);
        $blacklist->verification = 3;
        $blacklist->save();
        Blacklist::create([
            'id_user' => $request->id_user,
            'alasan' => $request->alasan
            ]); 
       
        Session::flash('status2','Penghuni berhasil di blacklist.');
        return redirect()->route('validasi_pendaftaran_reguler', $this->getEditPeriode())->with($this->getPendaftaranPenghuniReguler());
    }

    // Waiting list untuk reguler
    public function waitingList(Request $request){
        $id_user = $request->id_daftar;
        $list = Daftar_asrama_reguler::find($request->id_daftar);
        $list->verification = 4;
        $list->save();

        // Kirim email ke penghuni yang sudah terverifikasi
        $getID = User::find(Daftar_asrama_reguler::find($request->id_daftar)->id_user);
        Mail::to($getID->email)->send(new waitingListEmail(Daftar_asrama_reguler::find($request->id_daftar)));

        Session::flash('status2','Pendaftaran penghuni berhasil untuk dimasukkan dalam daftar waiting list.');
        return redirect()->route('validasi_pendaftaran_reguler', $this->getEditPeriode())->with($this->getPendaftaranPenghuniReguler());
    }

    // Pendaftaran Reguler ditolak
    public function taklolos(Request $request){
        $id_user = $request->id_daftar;
        $list = Daftar_asrama_reguler::find($request->id_daftar);
        $list->verification = 7;
        $list->save();

        // Kirim email ke penghuni yang sudah terverifikasi
        $getID = User::find(Daftar_asrama_reguler::find($request->id_daftar)->id_user);
        Mail::to($getID->email)->send(new PengumumanCalonPenghuniAsramaITB(Daftar_asrama_reguler::find($request->id_daftar)));

        Session::flash('status2','Pendaftaran penghuni berhasil untuk dimasukkan dalam daftar waiting list.');
        return redirect()->route('validasi_pendaftaran_reguler', $this->getEditPeriode())->with($this->getPendaftaranPenghuniReguler());
    }

    // ------- NON REGULER ------- //
    public function indexNonReguler(){
        Session::flash('menu','sekretariat/validasi_pendaftaran');
        return view('dashboard.sekretariat.validasiPendaftaranNonReguler', $this->getEditPeriode())->with($this->getPendaftaranPenghuniNonReguler());
    }

    // Alokasi Otomatis Pendaftaran Non Reguler
    protected function inboundNonReg(Request $request){
        $this->Validate($request, [
            'tanggal_masuk' => 'required|date',
            'lama_tinggal' => 'required|numeric',
        ]);

        // GENERATE KAMAR
        // Memastikan calon penghuni sedang tidak dalam kontrak tinggal di asrama
        $id_user = Daftar_asrama_non_reguler::find($request->id_daftar)->id_user;
        $tinggal = DB::select("SELECT id_checkout, id, id_daftar FROM daftar_asrama_non_reguler LEFT JOIN checkout ON checkout.daftar_asrama_id = daftar_asrama_non_reguler.id_daftar AND checkout.daftar_asrama_type = 'daftar_asrama_non_reguler' LEFT JOIN users ON users.id = daftar_asrama_non_reguler.id_user WHERE daftar_asrama_non_reguler.verification = 5 AND daftar_asrama_non_reguler.id_user = ? ORDER BY daftar_asrama_non_reguler.id_daftar ASC",[$id_user]);
        foreach ($tinggal as $tinggal) {
            if($tinggal->id_checkout == NULL){
                Session::flash('menu','sekretariat/validasi_pendaftaran');
                Session::flash('status1','Penghuni bersangkutan masih berstatus tinggal di asrama dan belum keluar. Tunggu hingga checkout atau batalkan pendaftaran.');
                return redirect()->route('validasi_pendaftaran', $this->getEditPeriode())->with($this->getPendaftaranPenghuniReguler());
            }
        }

        // memeriksa apakah id daftar sudah tersedia di kamar penghuni
        if(Kamar_penghuni::where(['daftar_asrama_id'=>$request->id_daftar,'daftar_asrama_type'=>'daftar_asrama_non_reguler'])->count() < 1){
            // Mendapatkan informasi yang dibutuhkan
            $daftarNonReg = Daftar_asrama_non_reguler::find(['id_daftar' => $request->id_daftar])->take(1);
            foreach ($daftarNonReg as $daftarNon) {
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
                if($kamar->is_difable == $request->difable){
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
                                    // ambil kamarnya jika isinya belum penuh
                                    if($hit < 2){
                                        // Periksa apakah penghuni yang sudah ada itu merupakan penghuni yang memilih sendirian
                                        $ifAlone = DB::select("SELECT id_kamar, daftar_asrama_id, daftar_asrama_type, id_daftar, preference FROM kamar_penghuni LEFT JOIN daftar_asrama_non_reguler ON id_daftar = daftar_asrama_id AND daftar_asrama_type = 'daftar_asrama_non_reguler' WHERE id_kamar = ? AND preference = ?",[$kamar->id_kamar, 1]);
                                        $alone = 0;
                                        foreach ($ifAlone as $ifAlone) {
                                            if($ifAlone->preference == 1){
                                                $alone += 1;
                                            }
                                        }
                                        if($alone == 0){
                                            $collect_id_kamar[$a] = $kamar->id_kamar;
                                            $kapasitas_kamar[$a] = $kamar->kapasitas;
                                            $a += 1;
                                        }
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
                                    // ambil kamarnya jika isinya belum penuh
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

            //dd($daftarNonReg);
            // Ambil satu kamar jika pilihan setidaknya ada satu, dan jika tidak ada pilihan akan dikembalikan
            if($a != 0){
                $pick_kamar = array_rand($collect_id_kamar,1);
            }else{
                Session::flash('menu','sekretariat/validasi_pendaftaran');
                Session::flash('status1','Pilihan kamar sudah habis atau tidak tersedia untuk kategori ini. Silahkan ganti rencana tinggal pendaftar.');
                return redirect()->route('validasi_pendaftaran', $this->getEditPeriode())->with($this->getPendaftaranPenghuniReguler());
            }

            // GENERATE TAGIHAN
            // Ambil id gedung
            $id_kamar = DB::select("SELECT asrama.id_asrama, bangunan.id_gedung, bangunan.id_kamar FROM asrama RIGHT JOIN (SELECT kamar.id_kamar, gedung.id_gedung, gedung.id_asrama FROM kamar LEFT JOIN gedung ON kamar.id_gedung = gedung.id_gedung) AS bangunan ON bangunan.id_asrama = asrama.id_asrama WHERE bangunan.id_kamar = ?",[$collect_id_kamar[$pick_kamar]]);
            foreach ($id_kamar as $kamar) {
                $id_k = $kamar->id_asrama;
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
                    return redirect()->route('validasi_pendaftaran', $this->getEditPeriode())->with($this->getPendaftaranPenghuniReguler());
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

            // Update is penghuni jadi 1
            $is_penghuni = User::find(Daftar_asrama_non_reguler::find($request->id_daftar)->id_user);
            $is_penghuni->is_penghuni = 1;
            $is_penghuni->save();
            // Kirim email ke penghuni yang sudah terverifikasi
            $getID = User::find(Daftar_asrama_non_reguler::find($request->id_daftar)->id_user);
            Mail::to($getID->email)->send(new VerifikasiNonReguler(Daftar_asrama_non_reguler::find($request->id_daftar)));

            // Buat session untuk report
            Session::flash('status2','Verifikasi berhasil dilakukan. Proses selanjutnya adalah pembayaran untuk rencana tinggal yang sudah disetujui.');
            Session::flash('menu','sekretariat/validasi_pendaftaran');
            return redirect()->route('validasi_pendaftaran', $this->getEditPeriode())->with($this->getPendaftaranPenghuniReguler());
        }else{
            Session::flash('status1','Penghuni sudah terdaftar memiliki kamar.');
            return redirect()->route('validasi_pendaftaran', $this->getEditPeriode())->with($this->getPendaftaranPenghuniReguler());
        }
    }

    // Alokasi manual non reguler
    public function alokasiManualNonReguler(Request $request){
        // memeriksa apakah penghuni sedang menjadi penghuni aktif atau tidak
        $idUser =Daftar_asrama_non_reguler::find($request->id_daftar)->id_user;
        $availability = Daftar_asrama_non_reguler::where(['id_user' => $idUser, 'verification' => 1])->count();
        if($availability == 0){
            // memeriksa apakah id daftar sudah tersedia di kamar penghuni
            if(Kamar_penghuni::where(['daftar_asrama_id'=>$request->id_daftar,'daftar_asrama_type'=>'daftar_asrama_non_reguler'])->count() < 1){
            // Masukkan tagihan ke database
                Tagihan::create([
                    'daftar_asrama_id' => $request->id_daftar,
                    'daftar_asrama_type' => 'daftar_asrama_non_reguler',
                    'jumlah_tagihan' => $request->tagihan,
                    ]);

                // Isi table kamar penghuni
                $kamar_penghuni_baru = Kamar_penghuni::create([
                                        'daftar_asrama_id' => $request->id_daftar,
                                        'daftar_asrama_type' => 'Daftar_asrama_non_reguler',
                                        'id_kamar' => $request->id_kamar,
                                        ]);

                // Update verification untuk disetujui
                $setuju = Daftar_asrama_non_reguler::find($request->id_daftar);
                $setuju->verification = 1;
                $setuju->tanggal_masuk = $request->tanggal_masuk;
                $setuju->is_difable = $request->disabilitas;
                $setuju->save();

                // Update is penghuni jadi 1
                $penghuni = User::find(Daftar_asrama_non_reguler::find($request->id_daftar)->id_user);
                $penghuni->is_penghuni = 1;
                $penghuni->save();
                // Kirim email ke penghuni yang sudah terverifikasi
                $getID = User::find(Daftar_asrama_non_reguler::find($request->id_daftar)->id_user);
                Mail::to($getID->email)->send(new PenerimaanNonReguler(Daftar_asrama_non_reguler::find($request->id_daftar)));

                // Buat session untuk report
                Session::flash('status2','Verifikasi berhasil dilakukan. Proses selanjutnya adalah pembayaran untuk rencana tinggal yang sudah disetujui.');
                Session::flash('menu','sekretariat/validasi_pendaftaran');
                return redirect()->back();
            }else{
                Session::flash('status1','Penghuni sudah terdaftar memiliki kamar.');
                return redirect()->back();
            }
        }else{
            Session::flash('status1','Penghuni masih berstatus aktif atau sudah diterima di periode lain. Untuk bisa memverifikasi pendaftarannya, penghuni tersebut harus checkout terlebih dahulu.');
            return redirect()->back();
        }
    }

    // Pendaftaran Reguler terblacklist
    public function blacklistNon(Request $request) {
        $blacklist = Daftar_asrama_non_reguler::find($request->id_daftar);
        $blacklist->verification = 3;
        $blacklist->save();
        Blacklist::create([
            'id_user' => $request->id_user,
            'alasan' => $request->alasan
            ]); 
       
        Session::flash('status2','Penghuni berhasil di blacklist.');
        return redirect()->route('validasi_pendaftaran_non_reguler');
    }

    // Waiting list untuk reguler
    public function waitingListNon(Request $request){
        $id_user = $request->id_daftar;
        $list = Daftar_asrama_non_reguler::find($request->id_daftar);
        $list->verification = 4;
        $list->save();

        // Kirim email ke penghuni yang sudah terverifikasi
        $getID = User::find(Daftar_asrama_non_reguler::find($request->id_daftar)->id_user);
        Mail::to($getID->email)->send(new WaitingListNonReguler(Daftar_asrama_non_reguler::find($request->id_daftar)));

        Session::flash('status2','Pendaftaran penghuni berhasil untuk dimasukkan dalam daftar waiting list.');
        return redirect()->route('validasi_pendaftaran_non_reguler');
    }

    // Pendaftaran Reguler ditolak
    public function taklolosNon(Request $request){
        $id_user = $request->id_daftar;
        $list = Daftar_asrama_non_reguler::find($request->id_daftar);
        $list->verification = 7;
        $list->save();

        // Kirim email ke penghuni yang sudah terverifikasi
        $getID = User::find(Daftar_asrama_non_reguler::find($request->id_daftar)->id_user);
        Mail::to($getID->email)->send(new PengumumanCalonPenghuniNonReguler(Daftar_asrama_non_reguler::find($request->id_daftar)));

        Session::flash('status2','Pendaftaran penghuni berhasil untuk dimasukkan dalam daftar waiting list.');
        return redirect()->route('validasi_pendaftaran_non_reguler');
    }
}

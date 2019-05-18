<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\initialDashboard;
use Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Checkout;
use App\Daftar_asrama_reguler;
use App\Http\Controllers\Traits\editPeriode;
use App\Http\Controllers\Traits\tanggalWaktu;
use App\Http\Controllers\Traits\tanggal;
use dateTime;
use DormAuth;

class CheckoutController extends Controller
{
    use initialDashboard;
    use editPeriode;
    use tanggalWaktu;
	use tanggal;
    //Fungsi untuk menampilkan form pengajuan keluar di penghuni
    public function FormPengajuanKeluar() {
        Session::flash('menu','penghuni/pengajuan_keluar');
        $id = DormAuth::User()->id;
        $daftar = DB::select('SELECT id_daftar, verification from daftar_asrama_reguler where id_user = ?',[$id]);
        $daftar_non = DB::select('SELECT id_daftar, verification from daftar_asrama_non_reguler where id_user = ?',[$id]);
        if(sizeof($daftar) != 0) {
            $id_daftar = array('id_daftar'=>$daftar[sizeof($daftar)-1]->id_daftar);
            $verif_reg = array('verif_reg'=>$daftar[sizeof($daftar)-1]->verification);
        } else {
            $id_daftar = array('id_daftar'=>0);
            $verif_reg = array('verif_reg'=>0);
        }
        if(sizeof($daftar_non) != 0) {
            $id_daftar_non = array('id_daftar_non'=>$daftar_non[sizeof($daftar_non)-1]->id_daftar);
            $verif_non_reg = array('verif_non_reg'=>$daftar_non[sizeof($daftar_non)-1]->verification);
        } else {
            $verif_non_reg = array('verif_non_reg'=>0);
            $id_daftar_non = array('id_daftar_non'=>0);
        }
        $name = $this->getInitialDashboard();
        $newInitialDashboard = array_merge($name, $id_daftar, $id_daftar_non, $verif_reg, $verif_non_reg);
        return view('dashboard.penghuni.formPengajuanKeluar', $newInitialDashboard);
    }

    public function SavePengajuanKeluar(Request $request) {

        $checkout = DB::select('SELECT * FROM checkout WHERE daftar_asrama_id = ? AND jenis_checkout = 3',[$request->id_daftar]);
       
        //Menambahkan user ke tabel checkout
        if(count($checkout)==0) {
            $user_checkout = new Checkout();
            $user_checkout->daftar_asrama_id = $request->id_daftar;
            $user_checkout->daftar_asrama_type = $request->daftar_asrama_type;
            $user_checkout->jenis_checkout = 3;
            $user_checkout->alasan_checkout = $request->alasan;
            $user_checkout->tanggal_masuk = $request->tanggal_masuk;
            $user_checkout->tanggal_keluar = $request->tanggal_keluar;
            $user_checkout->save();

            Session::flash('status2','Pengajuan permintaan keluar asrama telah dikirim ke admin');
            Session::flash('menu','penghuni/pengajuan_keluar');
            $id = DormAuth::User()->id;
            $daftar = DB::select('SELECT id_daftar, verification from daftar_asrama_reguler where id_user = ?',[$id]);
            $daftar_non = DB::select('SELECT id_daftar, verification from daftar_asrama_non_reguler where id_user = ?',[$id]);
           if(sizeof($daftar) != 0) {
                $id_daftar = array('id_daftar'=>$daftar[sizeof($daftar)-1]->id_daftar);
                $verif_reg = array('verif_reg'=>$daftar[sizeof($daftar)-1]->verification);
            } else {
                $id_daftar = array('id_daftar'=>0);
                $verif_reg = array('verif_reg'=>0);
            }
            if(sizeof($daftar_non) != 0) {
                $id_daftar_non = array('id_daftar_non'=>$daftar_non[sizeof($daftar_non)-1]->id_daftar);
                $verif_non_reg = array('verif_non_reg'=>$daftar_non[sizeof($daftar_non)-1]->verification);
            } else {
                $verif_non_reg = array('verif_non_reg'=>0);
                $id_daftar_non = array('id_daftar_non'=>0);
            }
            $name = $this->getInitialDashboard();
            $newInitialDashboard = array_merge($name, $id_daftar, $id_daftar_non, $verif_reg, $verif_non_reg);
            return redirect()->route('form_pengajuan_keluar', $newInitialDashboard);
        } else {
            Session::flash('status1','Anda sudah mengajukan permintaan keluar asrama');
            Session::flash('menu','penghuni/pengajuan_keluar');
            $id = DormAuth::User()->id;
            $daftar = DB::select('SELECT id_daftar, verification from daftar_asrama_reguler where id_user = ?',[$id]);
            $daftar_non = DB::select('SELECT id_daftar, verification from daftar_asrama_non_reguler where id_user = ?',[$id]);
            if(sizeof($daftar) != 0) {
                $id_daftar = array('id_daftar'=>$daftar[sizeof($daftar)-1]->id_daftar);
                $verif_reg = array('verif_reg'=>$daftar[sizeof($daftar)-1]->verification);
            } else {
                $id_daftar = array('id_daftar'=>0);
                $verif_reg = array('verif_reg'=>0);
            }
            if(sizeof($daftar_non) != 0) {
                $id_daftar_non = array('id_daftar_non'=>$daftar_non[sizeof($daftar_non)-1]->id_daftar);
                $verif_non_reg = array('verif_non_reg'=>$daftar_non[sizeof($daftar_non)-1]->verification);
            } else {
                $verif_non_reg = array('verif_non_reg'=>0);
                $id_daftar_non = array('id_daftar_non'=>0);
            }
            $name = $this->getInitialDashboard();
            $newInitialDashboard = array_merge($name, $id_daftar, $id_daftar_non, $verif_reg, $verif_non_reg);
            return redirect()->route('form_pengajuan_keluar', $newInitialDashboard);
        }
        
    }

    public function ListPengajuanKeluarReguler() {
        Session::flash('menu','admin/list_pengajuan_keluar');
        $checkout = DB::select('SELECT checkout.id_checkout, users.name, checkout.daftar_asrama_type, checkout.daftar_asrama_id, checkout.tanggal_keluar, daftar_asrama_reguler.asrama, checkout.alasan_checkout, users.email FROM users, checkout, daftar_asrama_reguler WHERE users.id = daftar_asrama_reguler.id_user AND checkout.daftar_asrama_id = daftar_asrama_reguler.id_daftar AND jenis_checkout = 3 AND daftar_asrama_type = "daftar_asrama_reguler"');        
        return view('dashboard.admin.listPengajuanKeluarReguler', $this->getEditPeriode())->with(['checkout'=>$checkout]);
    }

    public function AcceptPengajuanKeluarReguler(Request $request) {
        Session::flash('status2','Verifikasi pengajuan keluar berhasil dilakukan.');
        Session::flash('menu','admin/list_pengajuan_keluar');

         //Mengubah jenis checkout di table checkout menjadi 2
        $save_checkout = Checkout::find($request->id_checkout);
        $save_checkout->catatan_checkout = $request->catatan_keluar;
        $save_checkout->tanggal_keluar = $request->tanggal_keluar;
        $save_checkout->jenis_checkout = 2;
        $save_checkout->save();

        //Mengubah verification di daftar_asrama_reguler menjadi 6
        $update_pendaftaran = Daftar_asrama_reguler::find($request->id_daftar);
        $update_pendaftaran->verification = 6;
        $update_pendaftaran->save();

        $checkout = DB::select('SELECT checkout.id_checkout, users.name, checkout.daftar_asrama_type, checkout.daftar_asrama_id, checkout.tanggal_keluar, daftar_asrama_reguler.asrama, checkout.alasan_checkout, users.email FROM users, checkout, daftar_asrama_reguler WHERE users.id = daftar_asrama_reguler.id_user AND checkout.daftar_asrama_id = daftar_asrama_reguler.id_daftar AND jenis_checkout = 3 AND daftar_asrama_type = "daftar_asrama_reguler"');        
        return redirect()->route('list_pengajuan_keluar', $this->getEditPeriode())->with(['checkout'=>$checkout]);
    }

    public function RejectPengajuanKeluarReguler(Request $request) {
        Session::flash('status2','Verifikasi pengajuan keluar berhasil ditolak.');
        Session::flash('menu','admin/list_pengajuan_keluar');
        $save_checkout = Checkout::find($request->id_checkout);
        $save_checkout->jenis_checkout = 4;
        $save_checkout->save();
        $checkout = DB::select('SELECT checkout.id_checkout, users.name, checkout.daftar_asrama_type, checkout.daftar_asrama_id, checkout.tanggal_keluar, daftar_asrama_reguler.asrama, checkout.alasan_checkout, users.email FROM users, checkout, daftar_asrama_reguler WHERE users.id = daftar_asrama_reguler.id_user AND checkout.daftar_asrama_id = daftar_asrama_reguler.id_daftar AND jenis_checkout = 3 AND daftar_asrama_type = "daftar_asrama_reguler"');        
        return redirect()->route('list_pengajuan_keluar', $this->getEditPeriode())->with(['checkout'=>$checkout]);
    }

    public function AcceptPengajuanKeluarNonReguler(Request $request) {
        Session::flash('status2','Verifikasi pengajuan keluar berhasil dilakukan.');
        Session::flash('menu','admin/list_pengajuan_keluar');

         //Mengubah jenis checkout di table checkout menjadi 2
        $save_checkout = Checkout::find($request->id_checkout);
        $save_checkout->catatan_checkout = $request->catatan_keluar;
        $save_checkout->tanggal_keluar = $request->tanggal_keluar;
        $save_checkout->jenis_checkout = 2;
        $save_checkout->save();

        //Mengubah verification di daftar_asrama_reguler menjadi 6
        $update_pendaftaran = Daftar_asrama_non_reguler::find($request->id_daftar);
        $update_pendaftaran->verification = 6;
        $update_pendaftaran->save();

        $checkout = DB::select('SELECT checkout.id_checkout, users.name, checkout.daftar_asrama_type, checkout.daftar_asrama_id, checkout.tanggal_keluar, daftar_asrama_reguler.asrama, checkout.alasan_checkout, users.email FROM users, checkout, daftar_asrama_reguler WHERE users.id = daftar_asrama_reguler.id_user AND checkout.daftar_asrama_id = daftar_asrama_reguler.id_daftar AND jenis_checkout = 3 AND daftar_asrama_type = "daftar_asrama_reguler"');        
        return redirect()->route('list_pengajuan_keluar', $this->getEditPeriode())->with(['checkout'=>$checkout]);
    }

    public function RejectPengajuanKeluarNonReguler(Request $request) {
        Session::flash('status2','Verifikasi pengajuan keluar berhasil ditolak.');
        Session::flash('menu','admin/list_pengajuan_keluar');
        $save_checkout = Checkout::find($request->id_checkout);
        $save_checkout->jenis_checkout = 4;
        $save_checkout->save();
        $checkout = DB::select('SELECT checkout.id_checkout, users.name, checkout.daftar_asrama_type, checkout.daftar_asrama_id, checkout.tanggal_keluar, daftar_asrama_reguler.asrama, checkout.alasan_checkout, users.email FROM users, checkout, daftar_asrama_reguler WHERE users.id = daftar_asrama_reguler.id_user AND checkout.daftar_asrama_id = daftar_asrama_reguler.id_daftar AND jenis_checkout = 3 AND daftar_asrama_type = "daftar_asrama_reguler"');        
        return redirect()->route('list_pengajuan_keluar', $this->getEditPeriode())->with(['checkout'=>$checkout]);
    }

    public function HalamanCheckoutOtomatis() {
        Session::flash('menu','admin/checkout_otomatis');
        $var_filter_periode = DB::select('SELECT * FROM periodes');
        $var_filter_asrama = DB::select('SELECT * FROM asrama');
        $var_filter_gedung = DB::select('SELECT * FROM gedung');
        $filter_periode = 0;
        $filter_asrama = 0;
        $filter_gedung = 0;
        $data = 0;
        return view('dashboard.admin.halamanCheckoutOtomatis', $this->getEditPeriode())->with(['filter_periode' => $var_filter_periode,
                                                                                                   'filter_asrama' => $var_filter_asrama,
                                                                                                   'filter_gedung' => $var_filter_gedung,
                                                                                                   'var_periode' => $filter_periode,
                                                                                                    'var_asrama' => $filter_asrama,
                                                                                                    'var_gedung' => $filter_gedung,
                                                                                                   'data' => $data]);
    }

    public function FilterCheckoutOtomatis(Request $request) {
        $var_filter_periode = DB::select('SELECT * FROM periodes ');
        $var_filter_asrama = DB::select('SELECT * FROM asrama');
        $var_filter_gedung = DB::select('SELECT * FROM gedung');
        
        //Variabel untuk filter agar tidak hilang saat refresh
        $filter_periode = $request->periode;
        $filter_asrama = $request->asrama;
        $filter_gedung = $request->gedung;
        $filter_penghuni = $request->penghuni;
        if(isset($request->periode)&&isset($request->asrama)&&isset($request->gedung)){
            if($request->penghuni == 0) {
                $data = DB::select('SELECT daftar_asrama_reguler.id_daftar, daftar_asrama_reguler.tanggal_masuk, users.name, asrama.nama as asrama, gedung.nama as gedung, kamar.nama as kamar FROM users, daftar_asrama_reguler, kamar, gedung, asrama, kamar_penghuni 
                                    WHERE users.id = daftar_asrama_reguler.id_user AND daftar_asrama_reguler.id_daftar = kamar_penghuni.daftar_asrama_id
                                    AND kamar_penghuni.id_kamar = kamar.id_kamar AND kamar.id_gedung = gedung.id_gedung AND gedung.id_asrama = asrama.id_asrama
                                    AND daftar_asrama_reguler.id_periode = ? AND daftar_asrama_reguler.verification = 5 AND asrama.id_asrama = ? AND gedung.id_gedung = ? ORDER BY kamar.nama',[$request->periode,$request->asrama,$request->gedung]);
            } else {
                $data = DB::select('SELECT daftar_asrama_non_reguler.id_daftar, daftar_asrama_reguler.tanggal_masuk ,users.name, asrama.nama as asrama, gedung.nama as gedung, kamar.nama as kamar FROM users, daftar_asrama_non_reguler, kamar, gedung, asrama, kamar_penghuni 
                                    WHERE users.id = daftar_asrama_reguler.id_user AND daftar_asrama_reguler.id_daftar = kamar_penghuni.daftar_asrama_id
                                    AND kamar_penghuni.id_kamar = kamar.id_kamar AND kamar.id_gedung = gedung.id_gedung AND gedung.id_asrama = asrama.id_asrama
                                    AND asrama.id_asrama = ? AND daftar_asrama_non_reguler.verification = 5 AND gedung.id_gedung = ? ORDER BY kamar.nama',[$request->asrama,$request->gedung]);         
            }    
        } else {
            Session::flash('menu','admin/checkout_otomatis');
            Session::flash('status1','Tolong isi semua filter');
            return redirect()->route('halaman_checkout_otomatis', $this->getEditPeriode())->with(['filter_periode' => $var_filter_periode,
                                                                                                    'filter_asrama' => $var_filter_asrama,
                                                                                                    'filter_gedung' => $var_filter_gedung,
                                                                                                    'var_periode' => $filter_periode,
                                                                                                    'var_asrama' => $filter_asrama,
                                                                                                    'var_gedung' => $filter_gedung,
                                                                                                    'var_penghuni' => $filter_penghuni,]);
        }

        if(isset($request->id_penghuni)) {
            //Mengganti status penghuni menjadi checkout
            if($filter_penghuni == 0) {
                //Mengubah verification di daftar_asrama_reguler menjadi 6
                $update_pendaftaran = Daftar_asrama_reguler::find($request->id_penghuni);
                $update_pendaftaran->verification = 6;
                $update_pendaftaran->save();
            } else {
                //Mengubah verification di daftar_asrama_reguler menjadi 6
                $update_pendaftaran = Daftar_asrama_non_reguler::find($request->id_penghuni);
                $update_pendaftaran->verification = 6;
                $update_pendaftaran->save();
            }

            $checkout = DB::select('SELECT * FROM checkout WHERE daftar_asrama_id = ? AND jenis_checkout = 1',[$request->id_penghuni]);
            
            if(count($checkout)==0) {
                $save_checkout = new Checkout();
                $save_checkout->daftar_asrama_id = $request->id_penghuni;
                if($filter_penghuni == 0) {
                    $save_checkout->daftar_asrama_type = "daftar_asrama_reguler";
                }else {
                    $save_checkout->daftar_asrama_type = "daftar_asrama_non_reguler";
                } 
                $save_checkout->jenis_checkout = 1;
                $save_checkout->alasan_checkout = "-";
                $save_checkout->tanggal_masuk = $request->tanggal_masuk;
                $save_checkout->tanggal_keluar = Carbon::now();
                $save_checkout->save();
            }else {
                Session::flash('menu','admin/checkout_otomatis');
                return view('dashboard.admin.halamanCheckoutOtomatis', $this->getEditPeriode())->with(['filter_periode' => $var_filter_periode,
                                                                                                        'filter_asrama' => $var_filter_asrama,
                                                                                                        'filter_gedung' => $var_filter_gedung,
                                                                                                        'var_periode' => $filter_periode,
                                                                                                        'var_asrama' => $filter_asrama,
                                                                                                        'var_gedung' => $filter_gedung,
                                                                                                        'var_penghuni' => $filter_penghuni,
                                                                                                        'data' => $data]);
            }
        }
        // Session::flash('status2','Checkout berhasil dilakukan');
        Session::flash('menu','admin/checkout_otomatis');
        return view('dashboard.admin.halamanCheckoutOtomatis', $this->getEditPeriode())->with(['filter_periode' => $var_filter_periode,
                                                                                                'filter_asrama' => $var_filter_asrama,
                                                                                                'filter_gedung' => $var_filter_gedung,
                                                                                                'var_periode' => $filter_periode,
                                                                                                'var_asrama' => $filter_asrama,
                                                                                                'var_gedung' => $filter_gedung,
                                                                                                'var_penghuni' => $filter_penghuni,
                                                                                                'data' => $data]);
    }

    public function TombolCheckoutOtomatis(Request $request) {

        //Variabel untuk filter agar tidak hilang saat refresh
        $filter_periode = $request->periode;
        $filter_asrama = $request->asrama;
        $filter_gedung = $request->gedung;
        $filter_penghuni = $request->penghuni;
        if($request->penghuni == 0) {
            $data = DB::select('SELECT daftar_asrama_reguler.id_daftar, daftar_asrama_reguler.tanggal_masuk, users.name, asrama.nama as asrama, gedung.nama as gedung, kamar.nama as kamar FROM users, daftar_asrama_reguler, kamar, gedung, asrama, kamar_penghuni 
                                WHERE users.id = daftar_asrama_reguler.id_user AND daftar_asrama_reguler.id_daftar = kamar_penghuni.daftar_asrama_id
                                AND kamar_penghuni.id_kamar = kamar.id_kamar AND kamar.id_gedung = gedung.id_gedung AND gedung.id_asrama = asrama.id_asrama
                                AND daftar_asrama_reguler.id_periode = ? AND daftar_asrama_reguler.verification = 5 AND asrama.id_asrama = ? AND gedung.id_gedung = ? ORDER BY kamar.nama',[$request->periode,$request->asrama,$request->gedung]);
        } else {
            $data = DB::select('SELECT daftar_asrama_non_reguler.id_daftar, daftar_asrama_reguler.tanggal_masuk ,users.name, asrama.nama as asrama, gedung.nama as gedung, kamar.nama as kamar FROM users, daftar_asrama_non_reguler, kamar, gedung, asrama, kamar_penghuni 
                                WHERE users.id = daftar_asrama_reguler.id_user AND daftar_asrama_reguler.id_daftar = kamar_penghuni.daftar_asrama_id
                                AND kamar_penghuni.id_kamar = kamar.id_kamar AND kamar.id_gedung = gedung.id_gedung AND gedung.id_asrama = asrama.id_asrama
                                AND asrama.id_asrama = ? AND daftar_asrama_non_reguler.verification = 5 AND gedung.id_gedung = ? ORDER BY kamar.nama',[$request->asrama,$request->gedung]);         
        }

        //dd($data);
        foreach($data as $data) {
            //Mengganti status penghuni menjadi checkout
            if($filter_penghuni == 0) {
                //Mengubah verification di daftar_asrama_reguler menjadi 6
                $update_pendaftaran = Daftar_asrama_reguler::find($data->id_daftar);
                $update_pendaftaran->verification = 6;
                $update_pendaftaran->save();
            } else {
                //Mengubah verification di daftar_asrama_reguler menjadi 6
                $update_pendaftaran = Daftar_asrama_non_reguler::find($data->id_daftar);
                $update_pendaftaran->verification = 6;
                $update_pendaftaran->save();
            }


            $save_checkout = new Checkout();
            $save_checkout->daftar_asrama_id = $data->id_daftar;
            if($filter_penghuni == 0) {
                $save_checkout->daftar_asrama_type = "daftar_asrama_reguler";
            }else {
                $save_checkout->daftar_asrama_type = "daftar_asrama_non_reguler";
            } 
            $save_checkout->jenis_checkout = 1;
            $save_checkout->alasan_checkout = "-";
            $save_checkout->tanggal_masuk = $data->tanggal_masuk;
            $save_checkout->tanggal_keluar = Carbon::now();
            $save_checkout->save();
        }    

        Session::flash('menu','admin/checkout_otomatis');
        Session::flash('status1','Checkout otomatis berhasil dilakukan. Silahkan periksa di tabel checkout');
        return redirect()->route('halaman_checkout_otomatis');
    }

    public function PeriksaCheckout() {
        Session::flash('menu','admin/periksa_checkout');
        $var_filter_periode = DB::select('SELECT * FROM periodes');
        $var_filter_asrama = DB::select('SELECT * FROM asrama');
        $var_filter_gedung = DB::select('SELECT * FROM gedung');
        $filter_periode = 0;
        $filter_asrama = 0;
        $filter_gedung = 0;
        $data = 0;
        Session::flash('menu','admin/daftar_checkout');
        return view('dashboard.admin.halamanCheckoutOtomatis', $this->getEditPeriode())->with(['filter_periode' => $var_filter_periode,
                                                                                                   'filter_asrama' => $var_filter_asrama,
                                                                                                   'filter_gedung' => $var_filter_gedung,
                                                                                                   'var_periode' => $filter_periode,
                                                                                                    'var_asrama' => $filter_asrama,
                                                                                                    'var_gedung' => $filter_gedung,
                                                                                                   'data' => $data]);
    }


}

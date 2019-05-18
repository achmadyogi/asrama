<?php

namespace App\Http\Controllers\eksternal;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\DB;
use App\Daftar_asrama_reguler;
use App\Daftar_asrama_non_reguler;
use App\User_nim;
use App\User_penghuni;
use App\Asrama;
use App\Next_periode;
use App\Periode;
use App\Blacklist;
use App\Keluar_asrama;
use App\kerusakan_kamar;
use App\Pengelola;
use App\Http\Controllers\Traits\initialDashboard;
use Session;
use App\Http\Controllers\Traits\tanggal;
use DormAuth;



class PendaftaranEksternalController extends Controller
{
    use initialDashboard;

    public function PendaftaranMahasiswaAsing() {
        return view('dashboard.eksternal.formPendaftaranIro', $this->getInitialDashboard());
    }

    public function SavePendaftaranMahasiswaAsing(Request $request) {
        if ($request->pendaftaran == "reguler")
        {
            $user = new User();
            $user->name = $request->nama;
            $user->username = $request->pasport;
            $user->email = $request->pasport;
            $user->password = bcrypt("asramaitb");
            $user->verification = 1;
            $user->is_penghuni = 0;
            $user->is_pengelola = 0;
            $user->is_sekretariat = 0;
            $user->is_pimpinan = 0;
            $user->is_admin = 0;
            $user->is_keuangan = 0;
            $user->is_eksternal = 0;
            $user->save();

            $userPenghuni = new User_penghuni();
            $userPenghuni->id_user = $user->id;
            $userPenghuni->jenis_kelamin = $request->kelamin;
            $userPenghuni->nomor_identitas = $request->pasport;
            $userPenghuni->jenis_identitas = "Passport";
            $userPenghuni->alamat = "-";
            $userPenghuni->tempat_lahir = "-";
            $userPenghuni->kota ="-";
            $userPenghuni->propinsi ="-";
            $userPenghuni->negara = $request->negara;
            $userPenghuni->kodepos = "-";
            $userPenghuni->agama = "-";
            $userPenghuni->pekerjaan ="-";
            $userPenghuni->warga_negara = $request->negara;
            $userPenghuni->telepon = "-";
            $userPenghuni->kontak_darurat = "-";
            $userPenghuni->save();

            $daftar = new Daftar_asrama_reguler();
            $daftar->id_periode = 1;
            $daftar->id_user = $user->id;
            $daftar->preference = $request->preference;
            $daftar->lokasi_asrama = "-";
            $daftar->verification = 0;
            $daftar->status_beasiswa = $request->tujuan_tinggal;
            $daftar->kampus_mahasiswa = "-";
            $daftar->has_penyakit = 0;
            $daftar->ket_penyakit = "-";
            $daftar->is_difable = 0;
            $daftar->ket_difable = "-";
            $daftar->is_international = 1;
            $daftar->tanggal_masuk = $request->tanggal_masuk;
            $daftar->save();
        } else {
            $user = new User();
            $user->name = $request->nama;
            $user->username = $request->pasport;
            $user->email = $request->pasport;
            $user->password = bcrypt("asramaitb");
            $user->verification = 1;
            $user->is_penghuni = 0;
            $user->is_pengelola = 0;
            $user->is_sekretariat = 0;
            $user->is_pimpinan = 0;
            $user->is_admin = 0;
            $user->is_keuangan = 0;
            $user->is_eksternal = 0;
            $user->save();

            $userPenghuni = new User_penghuni();
            $userPenghuni->id_user = $user->id;
            $userPenghuni->jenis_kelamin = $request->kelamin;
            $userPenghuni->nomor_identitas = $request->pasport;
            $userPenghuni->jenis_identitas = "Passport";
            $userPenghuni->tempat_lahir = "-";
            $userPenghuni->alamat = "-";
            $userPenghuni->kota ="-";
            $userPenghuni->propinsi ="-";
            $userPenghuni->negara = $request->negara;
            $userPenghuni->kodepos = "-";
            $userPenghuni->agama = "-";
            $userPenghuni->pekerjaan ="-";
            $userPenghuni->warga_negara = $request->negara;
            $userPenghuni->telepon = "-";
            $userPenghuni->kontak_darurat = "-";
            $userPenghuni->save();

            $daftar = new Daftar_asrama_non_reguler();
            $daftar->id_user = $user->id;
            $daftar->tujuan_tinggal = $request->tujuan_tinggal;
            $daftar->preference = $request->preference;
            $daftar->lokasi_asrama = "-";
            $daftar->verification = 0;
            $daftar->is_difable = 0;
            $daftar->tanggal_masuk = $request->tanggal_masuk;
            $daftar->tempo = $request->tempo;
            $daftar->lama_tinggal = $request->jumlah;
            $daftar->jenis_penghuni = 1;
            $daftar->save();

        }
        
        Session::flash('status2','Penghuni Berhasil Ditambahkan');
		Session::flash('menu','pendaftaran_mahasiswa_asing');
        return view('dashboard.eksternal.formPendaftaranIro', $this->getInitialDashboard());
    }

    public function CekPendaftaranMahasiswaAsing() {
        
        $periode = Periode::all();

        return view('dashboard.eksternal.cekPendaftaranIro', $this->getInitialDashboard())->with([
                                                                                                  'periode' => $periode]);

    }

    public function TabelCekAsing(Request $request){
        $periode = Periode::all();
        $jalur = $request->jalur;
      
        if($jalur == 'reguler'){
            $asing_non_reguler = 0;
             $asing_reguler = DB::select("SELECT users.id,users.name,user_penghuni.nomor_identitas,user_penghuni.negara,daftar_asrama_reguler.status_beasiswa,daftar_asrama_reguler.verification from daftar_asrama_reguler,users,user_penghuni WHERE users.id = user_penghuni.id_user AND users.id = daftar_asrama_reguler.id_user AND is_international = 1");
            
            // Menghitung total pembayaran dan memasukkan dalam variable
            $c = 0;
            foreach ($asing_reguler as $asing_reg) {
                $b_id[$c] = $asing_reg->id;
                $b_name[$c] = $asing_reg->name;
                $b_identitas[$c] = $asing_reg->nomor_identitas;
                $b_asal_negara[$c] = $asing_reg->negara;
                $b_program[$c] = $asing_reg->status_beasiswa;
                $b_status[$c] = $asing_reg->verification;
                $c += 1;
            }

            // Periksa apakah ada data
            if($c == 0){
               
                $b_id = 0;
                $b_name = 0;
                $b_identitas = 0;
                $b_asal_negara = 0;
                $b_program = 0;
                $b_status = 0;
            }
        }else{
            $asing_reguler = 0;
            $id_periode = "";
            $asing_non_reguler = DB::select("SELECT users.id,users.name,user_penghuni.nomor_identitas,user_penghuni.negara,daftar_asrama_non_reguler.tujuan_tinggal,daftar_asrama_non_reguler.verification from daftar_asrama_non_reguler ,users,user_penghuni WHERE users.id = user_penghuni.id_user AND users.id = daftar_asrama_non_reguler.id_user AND jenis_penghuni = 1");
            // Menghitung total pembayaran dan memasukkan dalam variable
            $c = 0;
            foreach ($asing_non_reguler as $asing_non_reg) {
                $b_id[$c] = $asing_non_reg->id;
                $b_name[$c] = $asing_non_reg->name;
                $b_identitas[$c] = $asing_non_reg->nomor_identitas;
                $b_asal_negara[$c] = $asing_non_reg->negara;
                $b_program[$c] = $asing_non_reg->tujuan_tinggal;
                $b_status[$c] = $asing_non_reg->verification;
                $c += 1;
            }

            // Periksa apakah ada data
            if($c == 0){
                $b_id = 0;
                $b_name = 0;
                $b_identitas = 0;
                $b_asal_negara = 0;
                $b_program = 0;
                $b_status = 0;
            }
        }
    	
    	session::flash('menu', 'pembayaran_penghuni');
    	return view('dashboard.eksternal.cekPendaftaranIro', $this->getInitialDashboard())
    			->with([
                    'b_id' => $b_id,
                    'b_name' => $b_name,
                    'asing_reguler' => $asing_reguler,
                    'asing_non_reguler' => $asing_non_reguler,
                    'jalur' => $jalur,
                    'b_identitas' => $b_identitas,
                    'b_asal_negara' => $b_asal_negara,
                    'c' => $c,
                    'periode'=>$periode,
                    'status'=>$b_status,
                    'b_program' => $b_program,
    			]);
    }
}

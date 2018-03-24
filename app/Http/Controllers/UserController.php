<?php

namespace App\Http\Controllers;

use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use App\Prodi;
use App\Fakultas;
use App\User;
use App\Model_Checkout_Reguler;
use App\UserPenghuni;
use App\UserNIM;
use Illuminate\Http\Request;
use App\DaftarAsramaReguler;
use App\Periode;
use App\KamarReguler;

class UserController extends Controller
{
    /**
     * Show the edit penghuni info page
     *
     * @return \Illuminate\Http\Response
     */
    public function edit_penghuni_info()
    {
        if (Auth::guest()) {
            return redirect('login');
        } else {
            $user_penghuni_info = Auth::user()->user_penghuni;
            $nim = Auth::user()->valid_nim;
            if (count($nim) == 0) $nim = null;
            else $nim = $nim[0];

            if ($user_penghuni_info == null) {
                return view('profile.edit_penghuni_info')
                    ->with([
                        'info_penghuni' => new UserPenghuni(),
                        'nim' => $nim,
                        ]);
            } else {
                return view('profile.edit_penghuni_info')
                    ->with([
                        'info_penghuni' => $user_penghuni_info,
                        'nim' => $nim,
                        ]);
            }
            
        }
        
    }

    /**
     * Save penghuni info to DB
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function save_penghuni_info(Request $request)
    {
        if (Auth::guest()) {
            return redirect('login');

        } else {
            $user = Auth::user();
            $user_penghuni = ($user->user_penghuni == null) ? new UserPenghuni : $user->user_penghuni;

            $user_penghuni->id_user = $user->id;
            $user_penghuni->nomor_identitas = $request->nomor_identitas;
            $user_penghuni->jenis_identitas = $request->jenis_identitas;
            $user_penghuni->tempat_lahir = $request->tempat_lahir;
            $user_penghuni->tanggal_lahir = $request->tanggal_lahir;
                   
            $user_penghuni->gol_darah = $request->gol_darah == 'Tidak tahu' ? '-' : $request->gol_darah;
            $user_penghuni->jenis_kelamin = $request->jenis_kelamin == 'Laki-laki' ? 'L' : 'P';
            $user_penghuni->alamat = $request->alamat;
            $user_penghuni->agama = $request->agama;
                   
            $user_penghuni->pekerjaan = $request->pekerjaan;
            $user_penghuni->is_bidikmisi = ($request->is_bidikmisi) ? '1' : '0';
            $user_penghuni->warga_negara = $request->warga_negara;
            $user_penghuni->telepon = $request->telepon;
            $user_penghuni->instansi = $request->instansi;
                   
            $user_penghuni->nama_ortu_wali = $request->nama_ortu_wali;
            $user_penghuni->pekerjaan_ortu_wali = $request->pekerjaan_ortu_wali;
            $user_penghuni->alamat_ortu_wali = $request->alamat_ortu_wali;
            $user_penghuni->telepon_ortu_wali = $request->telepon_ortu_wali;
                   
            $user_penghuni->kontak_darurat = $request->kontak_darurat;

            $user_penghuni->save();

            if ($request->nim) {
                $nim = $request->nim;

                $prodi_kode = substr($nim, 0, 3);
                $prodi = Prodi::where('nim_prodi', $prodi_kode)->get();
                if (count($prodi) > 0)
                    $fakultas = $prodi[0]->fakultas;
                else
                    $fakultas = null;
                
                $new_usernim = new UserNIM();
                $new_usernim->id_user = Auth::user()->id;
                $new_usernim->id_fakultas = ($fakultas)?$fakultas->id_fakultas : 0;
                $new_usernim->id_prodi = (count($prodi) > 0)? $prodi[0]->id_prodi : 0;
                $new_usernim->nim = $nim;
                $new_usernim->status_nim = ($new_usernim->id_prodi == 0) ? 0 : 1;

                $new_usernim->save();
            }

            return redirect('dashboard');
        }
    }

    /**
     * Display someone's profile
     * @param int $id_user
     * @return \Illuminate\Http\Response
     */
    public function viewprofile($id_user = 0) {
        if (Auth::guest()) {
            return redirect('login');

        } else {
            if($id_user == 0) {
                $id_user = Auth::user()->id;
            }
            $selected_user = User::find($id_user);
            if($selected_user == null) {
                return view('404');
            } else {
                return view('profile.viewprofile')
                    -> with(['selected_user' => $selected_user,
                    'allow_edit' => (Auth::user()->id == $id_user) ? true : false ]);
            }
            
        }
    }

    /**
     * Edit my profile
     * @return \Illuminate\Http\Response
     */
    public function editprofile() {
        if (Auth::guest()) {
            return redirect('login');

        } else {
            return view('profile.editprofile');
        }
    }

    /**
     * Save my profile
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function saveprofile(Request $request) {
        if (Auth::guest()) {
            return redirect('login');

        } else {
            $this->validate($request, [
                'nama' => 'required|max:255',
                'email' => [
                    'required',
                    Rule::unique('users')->ignore(Auth::user()->id),
                ],
                'password' => 'nullable|min:6|confirmed',
            ]);
            $user = Auth::user();
            $user->nama = $request->nama;
            $user->email = $request->email;
            if ($request->password)
            	$user->password = bcrypt($request->password);
            else
                $user->password = $user->password;
            
            $user->save();
            return redirect('myprofile');
        }
    }

    /**
     * Display nim management page
     * @return \Illuminate\Http\Response
     */
    public function managenim() {
        if (Auth::guest()) {
            return redirect('login');

        } else {
            $mynim = Auth::user()->user_nim;
            foreach ($mynim as $nim) {
                $nim->nama_fakultas = ($nim->id_fakultas != 0)?Fakultas::find($nim->id_fakultas)->nama:'-';
                $nim->nama_prodi = ($nim->id_prodi != 0)?Prodi::find($nim->id_prodi)->nama:'-';
                $nim->strata = ($nim->id_prodi != 0)?"S".Prodi::find($nim->id_prodi)->strata:'-';
            }
            return view('profile.managenim')
                -> with(['mynim' => $mynim]);
        }
    }

    /**
     * Add a new NIM
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function addnim(Request $request) {
        if (Auth::guest()) {
            return redirect('login');

        } else {
            $nim = Auth::user()->user_nim;
            foreach ($nim as $i) {
                $i->status_nim = 0;
                $i->save();
            }

            $nim = $request->nim;
            $new_usernim = new UserNIM();
            $new_usernim->id_user = Auth::user()->id;


            $prodi_kode = substr($nim, 0, 3);
            $prodi = Prodi::where('nim_prodi', $prodi_kode)->get();
            if (count($prodi) > 0)
                $fakultas = $prodi[0]->fakultas;
            else
                $fakultas = null;

            $new_usernim->id_fakultas = ($fakultas)?$fakultas->id_fakultas : 0;
            $new_usernim->id_prodi = (count($prodi) > 0)? $prodi[0]->id_prodi : 0;
            $new_usernim->nim = $nim;
            $new_usernim->status_nim = ($new_usernim->id_prodi == 0) ? 0 : 1;

            $new_usernim->save();

            return redirect('managenim');
        }
    }

    public function keluarPeriode() {
        $user = Auth::user();

        $daftar_asrama = DaftarAsramaReguler::where('id_user', $user->id)->orderBy('id_daftar', 'desc')->first();
        $daftar_asrama->status = 'Tidak Lanjut';
        $daftar_asrama->save();

        $checkout = new Model_Checkout_Reguler;
        $checkout->id_daftar = $daftar_asrama->id_daftar;
        $checkout->tanggal_masuk = $daftar_asrama->tanggal_masuk;
        $checkout->tanggal_keluar = $daftar_asrama->tanggal_keluar;
        $checkout->save();

        $mess = "Anda berhasil keluar dari asrama.";

        return redirect('dashboard')->with('mess', $mess);
    }

    public function lanjutPeriode($id_periode) {
        $user = Auth::user();

        $daftar_asrama = DaftarAsramaReguler::where('id_user', $user->id)->orderBy('id_daftar', 'desc')->first();
        $daftar_asrama->status = 'Lanjut ke periode berikutnya';
        $daftar_asrama->save();

        $checkout = new Model_Checkout_Reguler;
        $checkout->id_daftar = $daftar_asrama->id_daftar;
        $checkout->tanggal_masuk = $daftar_asrama->tanggal_masuk;
        $checkout->tanggal_keluar = $daftar_asrama->tanggal_keluar;
        $checkout->save();

        $daftar_asrama_reguler = new DaftarAsramaReguler();
        $daftar_asrama_reguler->id_user = $daftar_asrama->id_user;
        $daftar_asrama_reguler->nomor_identitas = $daftar_asrama->nomor_identitas;
        $daftar_asrama_reguler->jenis_identitas = $daftar_asrama->jenis_identitas;
        $daftar_asrama_reguler->tempat_lahir = $daftar_asrama->tempat_lahir;
        $daftar_asrama_reguler->tanggal_lahir = $daftar_asrama->tanggal_lahir;
        $daftar_asrama_reguler->gol_darah = $daftar_asrama->gol_darah;
        $daftar_asrama_reguler->jenis_kelamin = $daftar_asrama->jenis_kelamin;
        $daftar_asrama_reguler->alamat = $daftar_asrama->alamat;
        $daftar_asrama_reguler->agama = $daftar_asrama->agama;
        $daftar_asrama_reguler->pekerjaan = $daftar_asrama->pekerjaan;
        $daftar_asrama_reguler->is_bidikmisi = $daftar_asrama->is_bidikmisi;
        $daftar_asrama_reguler->warga_negara = $daftar_asrama->warga_negara;
        $daftar_asrama_reguler->telepon = $daftar_asrama->telepon;
        $daftar_asrama_reguler->instansi = $daftar_asrama->instansi;
        $daftar_asrama_reguler->nama_ortu_wali = $daftar_asrama->nama_ortu_wali;
        $daftar_asrama_reguler->pekerjaan_ortu_wali = $daftar_asrama->pekerjaan_ortu_wali;
        $daftar_asrama_reguler->alamat_ortu_wali = $daftar_asrama->alamat_ortu_wali;
        $daftar_asrama_reguler->telepon_ortu_wali = $daftar_asrama->telepon_ortu_wali;
        $daftar_asrama_reguler->kontak_darurat = $daftar_asrama->kontak_darurat;
        $daftar_asrama_reguler->asrama = $daftar_asrama->asrama;
        $daftar_asrama_reguler->status = 'Teralokasi';
        $daftar_asrama_reguler->status_penghuni = 'Reguler';
        $periode_lanjut = Periode::find($id_periode);
        $daftar_asrama_reguler->nama_periode = $periode_lanjut->nama;
        $daftar_asrama_reguler->tanggal_masuk = $periode_lanjut->tanggal_awal;
        $daftar_asrama_reguler->tanggal_keluar = $periode_lanjut->tanggal_akhir;
        $daftar_asrama_reguler->save();

        $id_daftar = DaftarAsramaReguler::where('id_user', $user->id)->orderBy('id_daftar', 'desc')->first()->id_daftar;

        $id_kamar = KamarReguler::where('id_pendaftaran_reguler', $daftar_asrama->id_daftar)->first()->id_kamar;
        $kamar_baru = new KamarReguler();
        $kamar_baru->id_pendaftaran_reguler = $id_daftar;
        $kamar_baru->id_kamar = $id_kamar;
        $kamar_baru->tanggal_awal = $periode_lanjut->tanggal_awal;
        $kamar_baru->tanggal_akhir = $periode_lanjut->tanggal_akhir;
        $kamar_baru->save();

        $mess = "Anda berhasil lanjut periode.";

        return redirect('dashboard')->with('mess', $mess);
    }

}

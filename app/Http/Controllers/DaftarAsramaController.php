<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Asrama;
use App\Periode;
use App\DaftarAsramaReguler;
use App\DaftarAsramaNonReguler;
use Illuminate\Http\Request;

class DaftarAsramaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function showFormReguler() {
    	if (Auth::guest()) {
            return redirect('/login');
        } 
        else {
            $user_penghuni_info = Auth::user()->user_penghuni;
            if ($user_penghuni_info->status_daftar == NULL) {
                $list_asrama = Asrama::all();
                $list_periode = Periode::where('status', 'buka')->get();

                return view('daftar_asrama.reguler')
                    ->with(['list_asrama' => $list_asrama,
                            'list_periode' => $list_periode]);
            }
            else {
                return redirect('/dashboard');
            }
        }
    }

    public function daftarReguler(Request $request) {
        $user = Auth::user();

        $user_penghuni = $user->user_penghuni;
        $user_penghuni->status_daftar = 'Reguler';
        $user_penghuni->save();

        $daftar_asrama_reguler = new DaftarAsramaReguler();
        $daftar_asrama_reguler->id_user = $user_penghuni->id_user;
        $daftar_asrama_reguler->nomor_identitas = $user_penghuni->nomor_identitas;
        $daftar_asrama_reguler->jenis_identitas = $user_penghuni->jenis_identitas;
        $daftar_asrama_reguler->tempat_lahir = $user_penghuni->tempat_lahir;
        $daftar_asrama_reguler->tanggal_lahir = $user_penghuni->tanggal_lahir;
        $daftar_asrama_reguler->gol_darah = $user_penghuni->gol_darah;
        $daftar_asrama_reguler->jenis_kelamin = $user_penghuni->jenis_kelamin;
        $daftar_asrama_reguler->alamat = $user_penghuni->alamat;
        $daftar_asrama_reguler->agama = $user_penghuni->agama;
        $daftar_asrama_reguler->pekerjaan = $user_penghuni->pekerjaan;
        $daftar_asrama_reguler->is_bidikmisi = $user_penghuni->is_bidikmisi;
        $daftar_asrama_reguler->warga_negara = $user_penghuni->warga_negara;
        $daftar_asrama_reguler->telepon = $user_penghuni->telepon;
        $daftar_asrama_reguler->instansi = $user_penghuni->instansi;
        $daftar_asrama_reguler->nama_ortu_wali = $user_penghuni->nama_ortu_wali;
        $daftar_asrama_reguler->pekerjaan_ortu_wali = $user_penghuni->pekerjaan_ortu_wali;
        $daftar_asrama_reguler->alamat_ortu_wali = $user_penghuni->alamat_ortu_wali;
        $daftar_asrama_reguler->telepon_ortu_wali = $user_penghuni->telepon_ortu_wali;
        $daftar_asrama_reguler->kontak_darurat = $user_penghuni->kontak_darurat;
        $daftar_asrama_reguler->asrama = $request->asrama;
        $daftar_asrama_reguler->status = 'Menunggu';
        $daftar_asrama_reguler->status_penghuni = 'Reguler';

        $list_periode = Periode::all();
        foreach ($list_periode as $data) {
            $periode = $data->nama . " (" . $data->tanggal_awal. " s.d. " . $data->tanggal_akhir . ")";
            echo $periode;
            if ($periode == $request->periode) {
                $daftar_asrama_reguler->nama_periode = $data->nama;
                $daftar_asrama_reguler->tanggal_masuk = $data->tanggal_awal;
                $daftar_asrama_reguler->tanggal_keluar = $data->tanggal_akhir;
            }
        }

        $daftar_asrama_reguler->save();

        return redirect('/dashboard');
    }

    public function showFormEditReguler($id_daftar) {
        $info_daftar = DaftarAsramaReguler::find($id_daftar);
        $list_asrama = Asrama::all();
        $list_periode = Periode::where('status', 'buka')->get();
        return view('daftar_asrama.edit_reguler')
                ->with(['info_daftar' => $info_daftar,
                        'list_asrama' => $list_asrama,
                        'list_periode' => $list_periode]);
    }

    public function editReguler(Request $request, $id_daftar) {
        $daftar_asrama_reguler = DaftarAsramaReguler::find($id_daftar);
        $daftar_asrama_reguler->asrama = $request->asrama;
        $list_periode = Periode::all();
        foreach ($list_periode as $data) {
            $periode = $data->nama . " (" . $data->tanggal_awal. " s.d. " . $data->tanggal_akhir . ")";
            echo $periode;
            if ($periode == $request->periode) {
                $daftar_asrama_reguler->nama_periode = $data->nama;
                $daftar_asrama_reguler->tanggal_masuk = $data->tanggal_awal;
                $daftar_asrama_reguler->tanggal_keluar = $data->tanggal_akhir;
            }
        }
        $daftar_asrama_reguler->save();

        return redirect('/dashboard');
    }

    public function deleteReguler($id_daftar) {
        $user_penghuni = Auth::user()->user_penghuni;
        $user_penghuni->status_daftar = '';
        $user_penghuni->save();

        DaftarAsramaReguler::find($id_daftar)->delete();

        return redirect('/dashboard');
    }

    public function showFormNonReguler() {
        if (Auth::guest()) {
            return redirect('/login');
        } 
        else {
            $user_penghuni_info = Auth::user()->user_penghuni;
            if ($user_penghuni_info->status_daftar == NULL) {
                $list_asrama = Asrama::all();

                return view('daftar_asrama.non_reguler')
                    ->with(['list_asrama' => $list_asrama]);
            }
            else {
                return redirect('/dashboard');
            }
        }
    }

    public function daftarNonReguler(Request $request) {
        $user = Auth::user();

        $user_penghuni = $user->user_penghuni;
        $user_penghuni->status_daftar = 'Non Reguler';
        $user_penghuni->save();

        $daftar_asrama = new DaftarAsramaNonReguler();
        $daftar_asrama->id_user = $user_penghuni->id_user;
        $daftar_asrama->nomor_identitas = $user_penghuni->nomor_identitas;
        $daftar_asrama->jenis_identitas = $user_penghuni->jenis_identitas;
        $daftar_asrama->tempat_lahir = $user_penghuni->tempat_lahir;
        $daftar_asrama->tanggal_lahir = $user_penghuni->tanggal_lahir;
        $daftar_asrama->gol_darah = $user_penghuni->gol_darah;
        $daftar_asrama->jenis_kelamin = $user_penghuni->jenis_kelamin;
        $daftar_asrama->alamat = $user_penghuni->alamat;
        $daftar_asrama->agama = $user_penghuni->agama;
        $daftar_asrama->pekerjaan = $user_penghuni->pekerjaan;
        $daftar_asrama->is_bidikmisi = $user_penghuni->is_bidikmisi;
        $daftar_asrama->warga_negara = $user_penghuni->warga_negara;
        $daftar_asrama->telepon = $user_penghuni->telepon;
        $daftar_asrama->instansi = $user_penghuni->instansi;
        $daftar_asrama->nama_ortu_wali = $user_penghuni->nama_ortu_wali;
        $daftar_asrama->pekerjaan_ortu_wali = $user_penghuni->pekerjaan_ortu_wali;
        $daftar_asrama->alamat_ortu_wali = $user_penghuni->alamat_ortu_wali;
        $daftar_asrama->telepon_ortu_wali = $user_penghuni->telepon_ortu_wali;
        $daftar_asrama->kontak_darurat = $user_penghuni->kontak_darurat;
        $daftar_asrama->asrama = $request->asrama;
        $daftar_asrama->tanggal_masuk = $request->tanggal_masuk;
        $daftar_asrama->tanggal_keluar = $request->tanggal_keluar;
        $daftar_asrama->status = 'Menunggu';
        $daftar_asrama->status_penghuni = 'Non Reguler';
        $daftar_asrama->save();

        return redirect('/dashboard');
    }

    public function showFormEditNonReguler($id_daftar) {
        $info_daftar = DaftarAsramaNonReguler::find($id_daftar);
        $list_asrama = Asrama::all();

        return view('daftar_asrama.edit_non_reguler')
                ->with(['info_daftar' => $info_daftar,
                        'list_asrama' => $list_asrama]);
    }

    public function editNonReguler(Request $request, $id_daftar) {
        $daftar_asrama = DaftarAsramaNonReguler::find($id_daftar);
        $daftar_asrama->asrama = $request->asrama;
        $daftar_asrama->tanggal_masuk = $request->tanggal_masuk;
        $daftar_asrama->tanggal_keluar = $request->tanggal_keluar;
        $daftar_asrama->save();

        return redirect('/dashboard');
    }

    public function deleteNonReguler($id_daftar) {
        $user_penghuni = Auth::user()->user_penghuni;
        $user_penghuni->status_daftar = '';
        $user_penghuni->save();
        
        DaftarAsramaNonReguler::find($id_daftar)->delete();

        return redirect('/dashboard');
    }
}

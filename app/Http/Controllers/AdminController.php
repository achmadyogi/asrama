<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\DaftarAsramaReguler;
use App\DaftarAsramaNonReguler;
use App\UserPenghuni;
use App\Periode;
use App\Model_Checkout_Reguler;
use App\User;
use App\Admin;
use App\NextPeriode;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function indexLanjutPeriode() {
        $list_next_periode = NextPeriode::all();
        foreach ($list_next_periode as $data) {
            $data->nama_periode_asal = Periode::where('id_periode', $data->periode_asal)->first()->nama;
            $data->nama_periode_akhir = Periode::where('id_periode', $data->periode_akhir)->first()->nama;
        }

        return view('perpanjang_periode.index')
                    ->with(['list_next_periode' => $list_next_periode]);
    }

    public function createFormLanjutPeriode() {
        $list_periode = Periode::all();

        return view('perpanjang_periode.form_lanjut_periode')
                ->with(['list_periode' => $list_periode]);
    }

    public function createLanjutPeriode(Request $request) {
        $next_periode = new NextPeriode();
        $list_periode = Periode::all();
        foreach ($list_periode as $data) {
            if ($data->nama == $request->periode_asal) {
                $next_periode->periode_asal = $data->id_periode;
            }
            if ($data->nama == $request->periode_akhir) {
                $next_periode->periode_akhir = $data->id_periode;
            }   
        }
        $time = DB::select(DB::raw('SELECT NOW() AS tanggal'));
        $next_periode->created_at = $time[0]->tanggal;
        $next_periode->save();

        return redirect('/manage_lanjut_periode');
    }

    public function deleteLanjutPeriode($periode_asal, $periode_akhir) {
        DB::table('next_periode')
            ->where('periode_asal', $periode_asal)
            ->where('periode_akhir', $periode_akhir)
            ->delete();

        $periode_awal = Periode::find($periode_asal);
        $daftar_asrama_reguler = DaftarAsramaReguler::where([['status', 'Menghuni'], ['tanggal_masuk', $periode_awal->tanggal_awal], ['tanggal_keluar', $periode_awal->tanggal_akhir]])->get();
        foreach ($daftar_asrama_reguler as $data) {
            $data->status = 'Tidak Lanjut';
            $data->save();
            $checkout = new Model_Checkout_Reguler;
            $checkout->id_daftar = $data->id_daftar;
            $checkout->tanggal_masuk = $data->tanggal_masuk;
            $checkout->tanggal_keluar = $data->tanggal_keluar;
            $checkout->save();
        }

        return redirect('/manage_lanjut_periode');
    }

    public function showTombolLanjutKeluar() {
        $admin = Admin::where('id', 1)->first();
        $admin->tombol_lanjut_keluar = 1;
        $admin->save();

        return redirect('dashboard');
    }

    public function hideTombolLanjutKeluar() {
        $admin = Admin::where('id', 1)->first();
        $admin->tombol_lanjut_keluar = 0;
        $admin->save();

        return redirect('dashboard');
    }

    public function accept($status, $id_daftar) {
    	if ($status == 'reguler') {
    		$daftar = DaftarAsramaReguler::where('id_daftar', $id_daftar)->first();
    		$daftar->status = 'Diterima';
    		$daftar->save();
    	}
    	else if ($status == 'non_reguler') {
    		$daftar = DaftarAsramaNonReguler::where('id_daftar', $id_daftar)->first();
    		$daftar->status = 'Diterima';
    		$daftar->save();
    	}

		return redirect('/pendaftaran');
    }

    public function formPeriodeAsal() {
        $list_periode = Periode::all();

        return view('perpanjang_periode.form_periode_asal')
            ->with(['list_periode' => $list_periode]);
    }

    public function postPeriodeAsal(Request $request) {
        return redirect('/periode_akhir/'.$request->tanggal_masuk.'/'.$request->tanggal_keluar);
    }

    public function formPeriodeAkhir($tanggal_masuk, $tanggal_keluar) {
        $list_periode = Periode::all();
        $list_reguler = DaftarAsramaReguler::where([['tanggal_masuk', $tanggal_masuk], ['tanggal_keluar', $tanggal_keluar], ['status', 'Menghuni']])->get();
        foreach ($list_reguler as $data) {
            $data->nama = User::where('id', $data->id_user)->first()->nama;
        }

        return view('perpanjang_periode.form_periode_akhir')
            ->with(['list_reguler' => $list_reguler,
                    'list_periode' => $list_periode,
                    'tanggal_masuk' => $tanggal_masuk,
                    'tanggal_keluar' => $tanggal_keluar]);
    }

    public function perpanjangPeriode(Request $request) {
        $list_reguler = DaftarAsramaReguler::where([['tanggal_masuk', $request->tgl_masuk], ['tanggal_keluar', $request->tgl_keluar], ['status', 'Menghuni']])->get();

        foreach ($list_reguler as $data) {
            $daftar_lama = DaftarAsramaReguler::find($data->id_daftar);
            $daftar_lama->status = 'Selesai';
            $daftar_lama->save();

            $daftar_baru = new DaftarAsramaReguler();
            $daftar_baru->id_user = $daftar_lama->id_user;
            $daftar_baru->nomor_identitas = $daftar_lama->nomor_identitas;
            $daftar_baru->jenis_identitas = $daftar_lama->jenis_identitas;
            $daftar_baru->tempat_lahir = $daftar_lama->tempat_lahir;
            $daftar_baru->tanggal_lahir = $daftar_lama->tanggal_lahir;
            $daftar_baru->gol_darah = $daftar_lama->gol_darah;
            $daftar_baru->jenis_kelamin = $daftar_lama->jenis_kelamin;
            $daftar_baru->alamat = $daftar_lama->alamat;
            $daftar_baru->agama = $daftar_lama->agama;
            $daftar_baru->pekerjaan = $daftar_lama->pekerjaan;
            $daftar_baru->warga_negara = $daftar_lama->warga_negara;
            $daftar_baru->telepon = $daftar_lama->telepon;
            $daftar_baru->instansi = $daftar_lama->instansi;
            $daftar_baru->nama_ortu_wali = $daftar_lama->nama_ortu_wali;
            $daftar_baru->pekerjaan_ortu_wali = $daftar_lama->pekerjaan_ortu_wali;
            $daftar_baru->alamat_ortu_wali = $daftar_lama->alamat_ortu_wali;
            $daftar_baru->telepon_ortu_wali = $daftar_lama->telepon_ortu_wali;
            $daftar_baru->kontak_darurat = $daftar_lama->kontak_darurat;
            $daftar_baru->asrama = $daftar_lama->asrama;
            $daftar_baru->tanggal_masuk = $request->tanggal_masuk;
            $daftar_baru->tanggal_keluar = $request->tanggal_keluar;
            $daftar_baru->status = 'Diterima';
            $daftar_baru->status_penghuni = 'Reguler';
            $daftar_baru->save();
        }

        return redirect('/dashboard');
    }
}

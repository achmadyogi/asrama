<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Model_Periode;
use App\Model_Keluar_Asrama_Reguler;
use App\Model_Keluar_Asrama_Non_Reguler;
use App\DaftarAsramaReguler;
use App\DaftarAsramaNonReguler;
use App\Model_Checkout_Reguler;
use App\Model_Checkout_Non_Reguler;
use App\KamarReguler;
use App\KamarNonReguler;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KeluarAsramaController extends Controller
{
    public function showFormReguler($id_pendaftaran) {
    	if (Auth::guest()) {
            return redirect('login');
        } else {
            $pendaftaran = DaftarAsramaReguler::where('id_daftar', $id_pendaftaran)
            ->where('id_user', Auth::user()->id)
            ->where('status', 'Menghuni');
            if(!$pendaftaran->first()) {
                return redirect('dashboard');
            } else {
                return view('keluar_asrama.form', [
                    'id_pendaftaran' => $id_pendaftaran,
                    'jenis_kepenghunian' => 'reguler',
                ]);   
            }
        }
    }

    public function showFormNonReguler($id_pendaftaran) {
        if (Auth::guest()) {
            return redirect('login');
        } else {
            $pendaftaran = DaftarAsramaNonReguler::where('id_daftar', $id_pendaftaran)
            ->where('id_user', Auth::user()->id)
            ->where('status', 'Menghuni');
            if(!$pendaftaran->first()) {
                return redirect('dashboard');
            } else {
                return view('keluar_asrama.form', [
                    'id_pendaftaran' => $id_pendaftaran,
                    'jenis_kepenghunian' => 'nonreguler',
                ]);   
            }
        }
    }

    public function createRequest(Request $request, $jenis_kepenghunian, $id_pendaftaran) {
        if (Auth::guest()) {
            return redirect('login');
        } else if (false ){
            //auth role penghuni
            //return redirect('home');
        } else {
            $id = Auth::user()->id;
            if (false /*request pernah dibuat*/) {
                //fetch detail request
                //SELECT * FROM keluar JOIN daftar JOIN periode WHERE id_user = $id AND end >= NOW() AND tanggal_keluar <= end
            } else {
                
                if($jenis_kepenghunian == 'reguler') {

                    $requestKeluar = new Model_Keluar_Asrama_Reguler;
                    $requestKeluar->id_pendaftaran_reguler = $id_pendaftaran;
                    $requestKeluar->tanggal_keluar = $request->tanggal_keluar;
                    $requestKeluar->alasan_keluar = $request->alasan;
                    $requestKeluar->status_keluar = 'Diajukan';
                    $requestKeluar->save();

                    $pendaftaran = DaftarAsramaReguler::where('id_daftar', $id_pendaftaran)->first();
                    $pendaftaran->status = 'Mengajukan keluar';
                    $pendaftaran->save();

                } else if($jenis_kepenghunian == 'nonreguler'){

                    $requestKeluar = new Model_Keluar_Asrama_Non_Reguler;
                    $requestKeluar->id_pendaftaran_non_reguler = $id_pendaftaran;
                    $requestKeluar->tanggal_keluar = $request->tanggal_keluar;
                    $requestKeluar->alasan_keluar = $request->alasan;
                    $requestKeluar->status_keluar = 'Diajukan';
                    $requestKeluar->save();

                    $pendaftaran = DaftarAsramaNonReguler::where('id_daftar', $id_pendaftaran)->first();
                    $pendaftaran->status = 'Mengajukan keluar';
                    $pendaftaran->save();

                }
                //masukkan request ke DB
            }
            return redirect('/dashboard');
        }
    }

    public function manageRequest(Request $request) {
        if (Auth::guest()) {
            return redirect('login');
        } else if (Auth::user()->is_sekretariat != 1){
            return view('404');
        } else {
            //fetch semua request keluar
            
            $regulerProposed = Model_Keluar_Asrama_Reguler::getProposedRequest();
            $regulerApproved = Model_Keluar_Asrama_Reguler::getApprovedRequest();
            $regulerRejected = Model_Keluar_Asrama_Reguler::getRejectedRequest();
            $nonRegulerProposed = Model_Keluar_Asrama_Non_Reguler::getProposedRequest();
            $nonRegulerApproved = Model_Keluar_Asrama_Non_Reguler::getApprovedRequest();
            $nonRegulerRejected = Model_Keluar_Asrama_Non_Reguler::getRejectedRequest();

            return view('keluar_asrama.manage', [
                'regulerProposed' => $regulerProposed, 
                'regulerApproved' => $regulerApproved, 
                'regulerRejected' => $regulerProposed, 
                'nonRegulerProposed' => $nonRegulerProposed,
                'nonRegulerApproved' => $nonRegulerApproved,
                'nonRegulerRejected' => $nonRegulerRejected,
            ]);

        }
    }

    public function processRequest(Request $request) {
        if (Auth::guest()) {
            return redirect('login');
        } else if (Auth::user()->is_sekretariat != 1){
            return view('404');
        } else {
            //update status keluar
            //fetch semua request keluar
            if ($request->kepenghunian == 'Reguler') {
                
                $requestKeluar = Model_Keluar_Asrama_Reguler::where('id_pendaftaran_reguler', $request->idPendaftaran)->first();
                $requestKeluar->status_keluar = $request->action;
                $requestKeluar->save();

                $pendaftaran = DaftarAsramaReguler::where('id_daftar', $request->idPendaftaran)->first();
                if($request->action == 'Ditolak') {
                    $pendaftaran->status = 'Menghuni';
                } else if($request->action == 'Disetujui') {
                    $pendaftaran->status = 'Disetujui keluar';

                    $checkout = Model_Checkout_Reguler::where('id_daftar', $request->idPendaftaran) -> first();
                    if ($checkout != NULL) {
                        $checkout->tanggal_keluar = $pendaftaran->tanggal_masuk; 
                        $checkout->tanggal_keluar = $requestKeluar->tanggal_keluar;
                        $checkout->save();
                    } else {
                        $checkout = new Model_Checkout_Reguler;
                        $checkout->id_daftar = $request->idPendaftaran;
                        $checkout->tanggal_masuk = $pendaftaran->tanggal_masuk;
                        $checkout->tanggal_keluar = $requestKeluar->tanggal_keluar;
                        $checkout->save();
                    }

                    

                    $updateKamar = KamarReguler::where('id_pendaftaran_reguler', $request->idPendaftaran)
                                    ->orderBy('tanggal_akhir', 'desc')->get();
                    if (count($updateKamar) > 0) {
                        $updateKamar = $updateKamar[0];
                        $updateKamar->tanggal_akhir = $requestKeluar->tanggal_keluar;
                        $updateKamar->save();
                    }
                }
                $pendaftaran->save();



            } else if ($request->kepenghunian == 'Non Reguler') {

                $requestKeluar = Model_Keluar_Asrama_Non_Reguler::where('id_pendaftaran_non_reguler', $request->idPendaftaran)->first();
                $requestKeluar->status_keluar = $request->action;
                $requestKeluar->save();

                $pendaftaran = DaftarAsramaNonReguler::where('id_daftar', $request->idPendaftaran)->first();

                if($request->action == 'Ditolak') {
                    $pendaftaran->status = 'Menghuni';
                } else if($request->action == 'Disetujui') {
                    $pendaftaran->status = 'Disetujui keluar';

                    $checkout = Model_Checkout_Non_Reguler::where('id_daftar', $request->idPendaftaran) -> first();
                    if ($checkout != NULL) {
                        $checkout->tanggal_keluar = $pendaftaran->tanggal_masuk; 
                        $checkout->tanggal_keluar = $requestKeluar->tanggal_keluar;
                        $checkout->save();
                    } else {
                        $checkout = new Model_Checkout_Non_Reguler;
                        $checkout->id_daftar = $request->idPendaftaran;
                        $checkout->tanggal_masuk = $pendaftaran->tanggal_masuk;
                        $checkout->tanggal_keluar = $requestKeluar->tanggal_keluar;
                        $checkout->save();
                    }

                    $updateKamar = KamarNonReguler::where('id_pendaftaran_non_reguler', $request->idPendaftaran)
                                    ->orderBy('tanggal_akhir', 'desc')->get();
                    if (count($updateKamar) > 0) {
                        $updateKamar = $updateKamar[0];
                        $updateKamar->tanggal_akhir = $requestKeluar->tanggal_keluar;
                        $updateKamar->save();
                    }
                }
                $pendaftaran->save();
            }
            return redirect('managerequestkeluar');
            
        }
    }
}

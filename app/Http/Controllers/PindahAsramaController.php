<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Model_Periode;
use App\Model_Pindah_Asrama_Reguler;
use App\Model_Pindah_Asrama_Non_Reguler;
use App\DaftarAsramaReguler;
use App\DaftarAsramaNonReguler;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PindahAsramaController extends Controller
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
                return view('pindah_asrama.form', [
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
                return view('pindah_asrama.form', [
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

                    $requestPindah = new Model_Pindah_Asrama_Reguler;
                    $requestPindah->id_pendaftaran_reguler = $id_pendaftaran;
                    $requestPindah->alasan_pindah = $request->alasan;
                    $requestPindah->status_pindah = 'Diajukan';
                    $requestPindah->save();

                    $pendaftaran = DaftarAsramaReguler::where('id_daftar', $id_pendaftaran)->first();
                    $pendaftaran->status = 'Menghuni/Mengajukan Pindah';
                    $pendaftaran->save();

                } else if($jenis_kepenghunian == 'nonreguler'){

                    $requestPindah = new Model_Pindah_Asrama_Non_Reguler;
                    $requestPindah->id_pendaftaran_non_reguler = $d_pendaftaran;
                    $requestPindah->alasan_pindah = $request->alasan;
                    $requestPindah->status_pindah = 'Diajukan';
                    $requestPindah->save();

                    $pendaftaran = DaftarAsramaNonReguler::where('id_daftar', $id_pendaftaran)->first();
                    $pendaftaran->status = 'Menghuni/Mengajukan Pindah';
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
        } else if (false ){
            //auth role pengelola/sekretariat
            //return redirect('home');
        } else {
            //fetch semua request keluar
            
            $regulerProposed = Model_Pindah_Asrama_Reguler::getProposedRequest();
            $regulerApproved = Model_Pindah_Asrama_Reguler::getApprovedRequest();
            $regulerRejected = Model_Pindah_Asrama_Reguler::getRejectedRequest();
            $nonRegulerProposed = Model_Pindah_Asrama_Non_Reguler::getProposedRequest();
            $nonRegulerApproved = Model_Pindah_Asrama_Non_Reguler::getApprovedRequest();
            $nonRegulerRejected = Model_Pindah_Asrama_Non_Reguler::getRejectedRequest();

            return view('pindah_asrama.manage', [
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
        } else if (false ){
            //auth role pengelola/sekretariat
            //return redirect('home');
        } else {
            //update status keluar
            //fetch semua request keluar
            if ($request->kepenghunian == 'Reguler') {
                
                $requestPindah = Model_Pindah_Asrama_Reguler::where('id_pendaftaran_reguler', $request->id_pendaftaran)->first();
                $requestPindah->status_pindah = $request->action;
                $requestPindah->save();

                $pendaftaran = DaftarAsramaReguler::where('id_daftar', $request->id_pendaftaran)->first();
                if($request->action == 'Ditolak') {
                    $pendaftaran->status = 'Menghuni';
                } else if($request->action == 'Disetujui') {
                    $pendaftaran->status = 'Diterima';
                }
                $pendaftaran->save();

            } else if ($request->kepenghunian == 'Non Reguler') {

                $requestPindah = Model_Pindah_Asrama_Non_Reguler::where('id_pendaftaran_non_reguler', $request->id_pendaftaran)->first();
                $requestPindah->status_pindah = $request->action;
                $requestPindah->save();

                $pendaftaran = DaftarAsramaReguler::where('id_daftar', $request->id_pendaftaran)->first();
                if($request->action == 'Ditolak') {
                    $pendaftaran->status = 'Menghuni';
                } else if($request->action == 'Disetujui') {
                    $pendaftaran->status = 'Diterima';
                }
                $pendaftaran->save();
            }
            return redirect('managerequestpindah');
            
        }
    }

}

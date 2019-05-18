<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Model_DownloadFile;
use App\Daftar_asrama_reguler;
use App\Daftar_asrama_non_reguler;
use App\User;
use Illuminate\Support\Facades\Auth;
use PDF;
use Session;
use App\User_nim;
use App\User_penghuni;
use Illuminate\Database\Eloquent\Builder;
use App\Prodi;
use App\Fakultas;
use dateTime;
use Carbon\Carbon;
use ITBDorm;
use DormAuth;

class DownloadController extends Controller
{  
      public function show_all_downloadable_file() {
          $downloadable = Model_DownloadFile::all();
          return view('download.download', ['downloadable'=> $downloadable]);
      }

      public function upload() {
        Session::flash('menu','upload_file');
        return view('admin.upload');
      }

      public function saveUpload(Request $request) {
        $this->Validate($request, [
          'nama' => 'required',
          'deskripsi' => 'required',
          'link' => 'required'
        ]);

        $upload = new Model_DownloadFile();
        $upload->id_user = DormAuth::User()->id;
        $upload->nama_file = $request->nama;
        $upload->deskripsi = $request->deskripsi;
        $upload->url_file = "/".$request->link;
        $upload->save();

        Session::flash('status2','File berhasil ditambahkan.');
        return redirect()->back();

      }
  
      public function IndexFile() {
        return view('download.index');
      }

      public function GenerateSuratPerjanjian() {
        $id = DormAuth::User()->id;
        $pdf = PDF::loadView('generatedFiles.SuratPerjanjian');
        return $pdf->download('SuratPerjanjian.pdf');
      }

      public function GenerateFormulirPenangguhan() {
        $pdf = PDF::loadView('generatedFiles.Penangguhan');
        return $pdf->download('FormulirPenangguhan.pdf');
      }
      
      public function GenerateFormulirKeluarAsrama(Request $request) {
        if($request->id_daftar != 0) {
          $tanggal_keluar = DB::select('SELECT tanggal_keluar FROM checkout WHERE checkout.daftar_asrama_id = ?',[$request->id_daftar]);
          if(sizeof($tanggal_keluar)!=0){
            $tanggal = array('tanggal'=>$tanggal_keluar[count($tanggal_keluar)-1]->tanggal_keluar);
            $name = $this->getInitialDashboard();
            $newInitialDashboard = array_merge($name, $tanggal);
            $pdf = PDF::loadView('generatedFiles.SuratKeluarAsrama', $newInitialDashboard);
            return $pdf->download('FormulirKeluarAsrama.pdf');
          } else {
            Session::flash('status3','Download file tidak bisa dilakukan dikarenakan Anda belum mengisi pengajuan keluar');
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
        } else {
          Session::flash('status3','Download file tidak bisa dilakukan dikarenakan akun anda belum di validasi pembayarannya');
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

      public function SuratPerjanjianNonReguler(request $request){
        $id_daftar = $request->id_daftar;
        $user = User::find(DormAuth::User()->id);
        $daftar = Daftar_asrama_non_reguler::find($id_daftar);
        $penghuni = User_penghuni::where(['id_user' => DormAuth::User()->id])->get();

        foreach ($penghuni as $p) {
          $tanggal_lahir = $this->dateTanggal($p->tanggal_lahir);
        }

        $now = Carbon::now();

        $pdf = PDF::loadView('generatedFiles.SuratPerjanjianNon', ['user' => $user, 
          'daftar' => $daftar, 
          'penghuni' => $penghuni,
          'tanggal_lahir' => $tanggal_lahir,
          'now' => $now]);
        return $pdf->download('LeaseContract.pdf');
      }
}

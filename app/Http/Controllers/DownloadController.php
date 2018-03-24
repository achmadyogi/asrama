<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Model_DownloadFile;
use App\DaftarAsramaReguler;
use Illuminate\Support\Facades\Auth;
use PDF;

use App\Prodi;
use App\Fakultas;
use App\UserPenghuni;

class DownloadController extends Controller
{
    public function download_file($id) {
      $file = Model_DownloadFile::where('id_file', $id)->select('url_file')->first();
      $file_url = (string) $file;

      $file_url = str_replace('\\\\', '\\', $file_url);
      $file_url = str_replace('\\', '', $file_url);
      $file_url = str_replace('{', '', $file_url);
      $file_url = str_replace('}', '', $file_url);
      $file_url = str_replace('""', '', $file_url);
      $file_url = str_replace('"', '', $file_url);
      $file_url = str_replace('url_file:', '', $file_url);
      //$file_url = public_path($file_url);
      $file_url = public_path() . $file_url;
      return response()->download($file_url);
      //return $file_url;
    }

    public function show_all_downloadable_file() {
        $downloadable = Model_DownloadFile::all();
        return view('download.download', ['downloadable'=> $downloadable]);
    }

    public function show_uploadform() {
        if (Auth::guest()) {
        return redirect('/home');
      } else {
        $user = Auth::user();

        if(!($user->is_admin == '1')) {
          return redirect('/dashboard');
        }
      }
        return view('download.fileUpload');
    }

    public function upload(Request $request) {
        $file = $request->file('datafile');
    		$filename = $file->getClientOriginalName();
    		$file->move(public_path("Files"), $filename);

        /* insert into database */
        $filedownload = new Model_DownloadFile();
    		$filedownload->nama_file = $request->nama;
    		$filedownload->deskripsi = $request->deskripsi;
    		$filedownload->url_file = "/Files/" . $filename;
    		$filedownload->save();

    		return redirect('/download');
    }

    public function generateDocument($id) {
        if($id == 1) {
          $regulerOrNot = DB::table('user_penghuni')->where('id_user', \Auth::id())->first();
          if ($regulerOrNot != null) {
            $regulerOrNot = $regulerOrNot->status_daftar;
            $statusReguler = null; //kalo 1 berarti reguler, 0 berarti non reguler
            if($regulerOrNot == 'Non Reguler') {
              $userData = DB::table('users')
                          ->join('daftar_asrama_non_reguler', 'users.id', '=', 'daftar_asrama_non_reguler.id_user')
                          ->select('users.nama', 'users.email', 'daftar_asrama_non_reguler.*')
                          ->where('users.id', \Auth::id())
                          ->orderBy('daftar_asrama_non_reguler.created_at', 'desc')
                          ->first();
              $nokamar = DB::table('daftar_asrama_non_reguler')
                         ->join('kamar_non_reguler', 'kamar_non_reguler.id_pendaftaran_non_reguler', 'daftar_asrama_non_reguler.id_daftar')
                         ->join('kamar', 'kamar.id_kamar', 'kamar_non_reguler.id_kamar')
                         ->select('kamar.nama')
                         ->where('daftar_asrama_non_reguler.id_user', \Auth::id())
                         ->orderBy('kamar_non_reguler.tanggal_akhir', 'desc')
                         ->first();
              $statusReguler = 0;
            }
            else if($regulerOrNot == 'Reguler') {
              $userData = DB::table('users')
                          ->join('daftar_asrama_reguler', 'users.id', '=', 'daftar_asrama_reguler.id_user')
                          ->select('users.nama', 'users.email', 'daftar_asrama_reguler.*')
                          ->where('users.id', \Auth::id())
                          ->orderBy('daftar_asrama_reguler.created_at', 'desc')
                          ->first();
              $nokamar = DB::table('daftar_asrama_reguler')
                         ->join('kamar_reguler', 'kamar_reguler.id_pendaftaran_reguler', 'daftar_asrama_reguler.id_daftar')
                         ->join('kamar', 'kamar.id_kamar', 'kamar_reguler.id_kamar')
                         ->select('kamar.nama')
                         ->where('daftar_asrama_reguler.id_user', \Auth::id())
                         ->orderBy('kamar_reguler.tanggal_akhir', 'desc')
                         ->first();
              $statusReguler = 1;
            } else {
              $file = Model_DownloadFile::where('id_file', $id)->select('url_file')->first();
              $file_url = (string) $file;

              $file_url = str_replace('\\\\', '\\', $file_url);
              $file_url = str_replace('\\', '', $file_url);
              $file_url = str_replace('{', '', $file_url);
              $file_url = str_replace('}', '', $file_url);
              $file_url = str_replace('""', '', $file_url);
              $file_url = str_replace('"', '', $file_url);
              $file_url = str_replace('url_file:', '', $file_url);
              //$file_url = public_path($file_url);
              $file_url = public_path() . $file_url;
              return response()->download($file_url);
              #return download dokumen kosong
            }
          } else {
            $file = Model_DownloadFile::where('id_file', $id)->select('url_file')->first();
            $file_url = (string) $file;

            $file_url = str_replace('\\\\', '\\', $file_url);
            $file_url = str_replace('\\', '', $file_url);
            $file_url = str_replace('{', '', $file_url);
            $file_url = str_replace('}', '', $file_url);
            $file_url = str_replace('""', '', $file_url);
            $file_url = str_replace('"', '', $file_url);
            $file_url = str_replace('url_file:', '', $file_url);
            //$file_url = public_path($file_url);
            $file_url = public_path() . $file_url;
            return response()->download($file_url);
          }
          /* penentuan jenis kelamin, karena kalo di view bakal bottleneck */
          $jeniskelamin = null;
          $datakelamin = UserPenghuni::where('id_user', \Auth::id())->first();
          if($datakelamin->jenis_kelamin == 'L') $jeniskelamin = 'Laki-laki';
          else $jeniskelamin = 'Perempuan';

          /* fakultas */
          $mynim = DB::table('user_nim')->where('user_nim.status_nim', 1)->where('id_user', \Auth::id())->get();
          if($mynim == null || $mynim->count() == 0){
            $pdf = PDF::loadView('generatedFile.SuratPerjanjian', ['data'=>(isset($userData)) ? $userData : "",
                                                                   'jeniskelamin'=>(isset($jeniskelamin)) ? $jeniskelamin : "",
                                                                   'nokamar'=>($nokamar != null) ? $nokamar->nama : ""]);
            return $pdf->download('SuratPerjanjian.pdf');
          }
          $mynim[0]->nama_fakultas = ($mynim[0]->id_fakultas != 0) ? Fakultas::find($mynim[0]->id_fakultas)->nama:'-';
          $mynim[0]->nama_prodi = ($mynim[0]->id_prodi != 0) ? Prodi::find($mynim[0]->id_prodi)->nama:'-';

          $pdf = PDF::loadView('generatedFile.SuratPerjanjian', ['data'=>(isset($userData)) ? $userData : "",
                                                                 'jeniskelamin'=>(isset($jeniskelamin)) ? $jeniskelamin : "",
                                                                 'mynim'=>(isset($mynim[0])) ? $mynim[0] : "",
                                                                 'nokamar'=>($nokamar != null) ? $nokamar->nama : ""]);
          return $pdf->download('SuratPerjanjian.pdf');
        }
        else if ($id == 2) {
          $regulerOrNot = DB::table('user_penghuni')->where('id_user', \Auth::id())->first();
          if ($regulerOrNot != null) {
            $regulerOrNot = $regulerOrNot->status_daftar;
            $statusReguler = null; //kalo 1 berarti reguler, 0 berarti non reguler
            if($regulerOrNot == 'Non Reguler') {
              $userData = DB::table('users')
                          ->join('daftar_asrama_non_reguler', 'users.id', '=', 'daftar_asrama_non_reguler.id_user')
                          ->select('users.nama', 'users.email', 'daftar_asrama_non_reguler.*')
                          ->where('users.id', \Auth::id())
                          ->orderBy('daftar_asrama_non_reguler.created_at', 'desc')
                          ->first();
              $nokamar = DB::table('daftar_asrama_non_reguler')
                         ->join('kamar_non_reguler', 'kamar_non_reguler.id_pendaftaran_non_reguler', 'daftar_asrama_non_reguler.id_daftar')
                         ->join('kamar', 'kamar.id_kamar', 'kamar_non_reguler.id_kamar')
                         ->select('kamar.nama')
                         ->where('daftar_asrama_non_reguler.id_user', \Auth::id())
                         ->orderBy('kamar_non_reguler.tanggal_akhir', 'desc')
                         ->first();
              $statusReguler = 0;
            }
            else if($regulerOrNot == 'Reguler') {
              $userData = DB::table('users')
                          ->join('daftar_asrama_reguler', 'users.id', '=', 'daftar_asrama_reguler.id_user')
                          ->select('users.nama', 'users.email', 'daftar_asrama_reguler.*')
                          ->where('users.id', \Auth::id())
                          ->orderBy('daftar_asrama_reguler.created_at', 'desc')
                          ->first();
              $nokamar = DB::table('daftar_asrama_reguler')
                         ->join('kamar_reguler', 'kamar_reguler.id_pendaftaran_reguler', 'daftar_asrama_reguler.id_daftar')
                         ->join('kamar', 'kamar.id_kamar', 'kamar_reguler.id_kamar')
                         ->select('kamar.nama')
                         ->where('daftar_asrama_reguler.id_user', \Auth::id())
                         ->orderBy('kamar_reguler.tanggal_akhir', 'desc')
                         ->first();
              $statusReguler = 1;
            } else {
              $file = Model_DownloadFile::where('id_file', $id)->select('url_file')->first();
              $file_url = (string) $file;

              $file_url = str_replace('\\\\', '\\', $file_url);
              $file_url = str_replace('\\', '', $file_url);
              $file_url = str_replace('{', '', $file_url);
              $file_url = str_replace('}', '', $file_url);
              $file_url = str_replace('""', '', $file_url);
              $file_url = str_replace('"', '', $file_url);
              $file_url = str_replace('url_file:', '', $file_url);
              //$file_url = public_path($file_url);
              $file_url = public_path() . $file_url;
              return response()->download($file_url);
              #return download dokumen kosong
            }
          } else {
            $file = Model_DownloadFile::where('id_file', $id)->select('url_file')->first();
            $file_url = (string) $file;

            $file_url = str_replace('\\\\', '\\', $file_url);
            $file_url = str_replace('\\', '', $file_url);
            $file_url = str_replace('{', '', $file_url);
            $file_url = str_replace('}', '', $file_url);
            $file_url = str_replace('""', '', $file_url);
            $file_url = str_replace('"', '', $file_url);
            $file_url = str_replace('url_file:', '', $file_url);
            //$file_url = public_path($file_url);
            $file_url = public_path() . $file_url;
            return response()->download($file_url);
            #return download dokumen kosong
          }
          /* fakultas */
          $mynim = DB::table('user_nim')->where('user_nim.status_nim', 1)->where('id_user', \Auth::id())->get();
          if($mynim == null || $mynim->count() == 0){
            $pdf = PDF::loadView('generatedFile.FormKeluar', ['data'=>$userData, 'nokamar'=>($nokamar != null) ? $nokamar->nama : ""]);
            return $pdf->download('FormKeluarAsrama.pdf');
          }
          $mynim[0]->nama_fakultas = ($mynim[0]->id_fakultas != 0) ? Fakultas::find($mynim[0]->id_fakultas)->nama:'-';
          $mynim[0]->nama_prodi = ($mynim[0]->id_prodi != 0) ? Prodi::find($mynim[0]->id_prodi)->nama:'-';

          $pdf = PDF::loadView('generatedFile.FormKeluar', ['data'=>$userData, 'mynim'=>$mynim[0], 'nokamar'=>($nokamar != null) ? $nokamar->nama : ""]);
          return $pdf->download('FormKeluarAsrama.pdf');
        }
        else if($id == 3){
          $regulerOrNot = DB::table('user_penghuni')->where('id_user', \Auth::id())->first();
          if ($regulerOrNot != null) {
            $regulerOrNot = $regulerOrNot->status_daftar;
            $statusReguler = null; //kalo 1 berarti reguler, 0 berarti non reguler
            if($regulerOrNot == 'Non Reguler') {
              $userData = DB::table('users')
                          ->join('daftar_asrama_non_reguler', 'users.id', '=', 'daftar_asrama_non_reguler.id_user')
                          ->select('users.nama', 'users.email', 'daftar_asrama_non_reguler.*')
                          ->where('users.id', \Auth::id())
                          ->orderBy('daftar_asrama_non_reguler.created_at', 'desc')
                          ->first();
              $statusReguler = 0;
            }
            else if($regulerOrNot == 'Reguler') {
              $userData = DB::table('users')
                          ->join('daftar_asrama_reguler', 'users.id', '=', 'daftar_asrama_reguler.id_user')
                          ->select('users.nama', 'users.email', 'daftar_asrama_reguler.*')
                          ->where('users.id', \Auth::id())
                          ->orderBy('daftar_asrama_reguler.created_at', 'desc')
                          ->first();
              $statusReguler = 1;
            } else {
              $file = Model_DownloadFile::where('id_file', $id)->select('url_file')->first();
              $file_url = (string) $file;

              $file_url = str_replace('\\\\', '\\', $file_url);
              $file_url = str_replace('\\', '', $file_url);
              $file_url = str_replace('{', '', $file_url);
              $file_url = str_replace('}', '', $file_url);
              $file_url = str_replace('""', '', $file_url);
              $file_url = str_replace('"', '', $file_url);
              $file_url = str_replace('url_file:', '', $file_url);
              //$file_url = public_path($file_url);
              $file_url = public_path() . $file_url;
              return response()->download($file_url);
              #return download dokumen kosong
            }
          } else {
            $file = Model_DownloadFile::where('id_file', $id)->select('url_file')->first();
            $file_url = (string) $file;

            $file_url = str_replace('\\\\', '\\', $file_url);
            $file_url = str_replace('\\', '', $file_url);
            $file_url = str_replace('{', '', $file_url);
            $file_url = str_replace('}', '', $file_url);
            $file_url = str_replace('""', '', $file_url);
            $file_url = str_replace('"', '', $file_url);
            $file_url = str_replace('url_file:', '', $file_url);
            //$file_url = public_path($file_url);
            $file_url = public_path() . $file_url;
            return response()->download($file_url);
          }
          /* fakultas */
          $mynim = DB::table('user_nim')->where('user_nim.status_nim', 1)->where('id_user', \Auth::id())->get();
          if($mynim == null || $mynim->count() == 0){
            $pdf = PDF::loadView('generatedFile.Penangguhan', ['data'=>$userData]);
            return $pdf->download('FormPengajuanPenangguhan.pdf');
          }
          $mynim[0]->nama_fakultas = ($mynim[0]->id_fakultas != 0) ? Fakultas::find($mynim[0]->id_fakultas)->nama:'-';
          $mynim[0]->nama_prodi = ($mynim[0]->id_prodi != 0) ? Prodi::find($mynim[0]->id_prodi)->nama:'-';

          $pdf = PDF::loadView('generatedFile.Penangguhan', ['data'=>$userData, 'mynim'=>$mynim[0]]);
          return $pdf->download('FormPengajuanPenangguhan.pdf');
        }
        else {
          return view('404');
        }
    }
}

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
          $downloadable = Model_DownloadFIle::all();
          return view('download.download', ['downloadable'=> $downloadable]);
      }
  
}

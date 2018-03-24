<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\DaftarAsramaReguler;
use App\DaftarAsramaNonReguler;
use App\Model_Checkout_Reguler;
use App\Model_Checkout_Non_Reguler;
use App\Asrama;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use PDF;

use App\Prodi;
use App\Fakultas;
use App\UserPenghuni;

class CheckInController extends Controller
{
    public function showList($jenisPenghuni) {
    	if (Auth::guest()) {
            return redirect('login');
        } else if (Auth::user()->is_pengelola == 0) {
            return "You're not authorized to do this action";
        } else {
            $id_asrama = DB::select('SELECT * FROM pengelola WHERE id_user = ?', array(Auth::user()->id))[0] -> id_asrama;
            $asrama = Asrama::find($id_asrama);
            if ($jenisPenghuni == 'reguler') {
                $checkin = DB::select('SELECT *
                            FROM daftar_asrama_reguler JOIN users ON daftar_asrama_reguler.id_user = users.id
                            WHERE daftar_asrama_reguler.status = "Teralokasi"
                            AND daftar_asrama_reguler.asrama = ?'
                            , array($asrama->nama));
                $checkout = DB::select('SELECT
                                checkout_reguler.id_daftar AS id_daftar,
                                users.username AS username,
                                users.nama AS nama,
                                daftar_asrama_reguler.nomor_identitas AS nomor_identitas,
                                checkout_reguler.tanggal_masuk AS tanggal_masuk,
                                checkout_reguler.tanggal_keluar AS tanggal_keluar
                            FROM daftar_asrama_reguler
                            JOIN users ON daftar_asrama_reguler.id_user = users.id
                            JOIN checkout_reguler ON checkout_reguler.id_daftar = daftar_asrama_reguler.id_daftar
                            WHERE daftar_asrama_reguler.asrama = ?'
                            , array($asrama->nama));
            } else if ($jenisPenghuni == 'nonreguler') {
                $checkin = DB::select('SELECT *
                            FROM daftar_asrama_non_reguler JOIN users ON daftar_asrama_non_reguler.id_user = users.id
                            WHERE daftar_asrama_non_reguler.status = "Teralokasi"
                            AND daftar_asrama_non_reguler.asrama = ?'
                            , array($asrama->nama));
                $checkout = DB::select('SELECT
                                checkout_non_reguler.id_daftar AS id_daftar,
                                users.username AS username,
                                users.nama AS nama,
                                daftar_asrama_non_reguler.nomor_identitas AS nomor_identitas,
                                checkout_non_reguler.tanggal_masuk AS tanggal_masuk,
                                checkout_non_reguler.tanggal_keluar AS tanggal_keluar
                            FROM daftar_asrama_non_reguler
                            JOIN users ON daftar_asrama_non_reguler.id_user = users.id
                            JOIN checkout_non_reguler ON checkout_non_reguler.id_daftar = daftar_asrama_non_reguler.id_daftar
                            WHERE daftar_asrama_non_reguler.asrama = ?'
                            , array($asrama->nama));
            } else {
                return  redirect('dashboard');
            }
            return  view('checkin.list',['listCheckIn' => $checkin, 'listCheckOut' => $checkout, 'jenis' => $jenisPenghuni]);
        }
    }

    public function showSearch($jenisPenghuni, Request $request) {
        if (Auth::guest()) {
            return redirect('login');
        } else if (Auth::user()->is_pengelola == 0) {
            return "You're not authorized to do this action";
        } else {
            $id_asrama = DB::select('SELECT * FROM pengelola WHERE id_user = ?', array(Auth::user()->id))[0] -> id_asrama;
            $asrama = Asrama::find($id_asrama);
            if ($jenisPenghuni == 'reguler') {
                $checkin = DB::select('SELECT *
                            FROM daftar_asrama_reguler JOIN users ON daftar_asrama_reguler.id_user = users.id
                            WHERE daftar_asrama_reguler.status = "Teralokasi"
                            AND daftar_asrama_reguler.asrama = ?
                            AND ((LOWER(daftar_asrama_reguler.nomor_identitas) LIKE ?)
                                OR
                                (LOWER(users.nama) LIKE ?)
                                OR
                                (LOWER(users.username) LIKE ?)
                            )'
                            , array($asrama->nama, '%'.strtolower($request->key).'%', '%'.strtolower($request->key).'%', '%'.strtolower($request->key).'%'));

                $checkout = DB::select('SELECT
                                checkout_reguler.id_daftar AS id_daftar,
                                users.username AS username,
                                users.nama AS nama,
                                daftar_asrama_reguler.nomor_identitas AS nomor_identitas,
                                checkout_reguler.tanggal_masuk AS tanggal_masuk,
                                checkout_reguler.tanggal_keluar AS tanggal_keluar
                            FROM daftar_asrama_reguler
                            JOIN users ON daftar_asrama_reguler.id_user = users.id
                            JOIN checkout_reguler ON checkout_reguler.id_daftar = daftar_asrama_reguler.id_daftar
                            WHERE daftar_asrama_reguler.asrama = ?
                            AND ((LOWER(daftar_asrama_reguler.nomor_identitas) LIKE ?)
                                OR
                                (LOWER(users.nama) LIKE ?)
                                OR
                                (LOWER(users.username) LIKE ?)
                            )'
                            , array($asrama->nama, '%'.strtolower($request->key).'%', '%'.strtolower($request->key).'%', '%'.strtolower($request->key).'%'));
            } else if ($jenisPenghuni == 'nonreguler') {
                $checkin = DB::select('SELECT *
                            FROM daftar_asrama_non_reguler JOIN users ON daftar_asrama_non_reguler.id_user = users.id
                            WHERE (
                                daftar_asrama_non_reguler.status = "Teralokasi"
                            )
                            AND daftar_asrama_non_reguler.asrama = ?
                            AND ((LOWER(daftar_asrama_non_reguler.nomor_identitas) LIKE ?)
                            OR
                            (LOWER(users.nama) LIKE ?)
                            OR
                            (LOWER(users.username) LIKE ?)
                            )'
                            , array($asrama->nama, '%'.strtolower($request->key).'%', '%'.strtolower($request->key).'%', '%'.strtolower($request->key).'%'));
                $checkout = DB::select('SELECT
                                checkout_non_reguler.id_daftar AS id_daftar,
                                users.username AS username,
                                users.nama AS nama,
                                daftar_asrama_non_reguler.nomor_identitas AS nomor_identitas,
                                checkout_non_reguler.tanggal_masuk AS tanggal_masuk,
                                checkout_non_reguler.tanggal_keluar AS tanggal_keluar
                            FROM daftar_asrama_non_reguler
                            JOIN users ON daftar_asrama_non_reguler.id_user = users.id
                            JOIN checkout_non_reguler ON checkout_non_reguler.id_daftar = daftar_asrama_non_reguler.id_daftar
                            WHERE daftar_asrama_non_reguler.asrama = ?
                            AND ((LOWER(daftar_asrama_non_reguler.nomor_identitas) LIKE ?)
                                OR
                                (LOWER(users.nama) LIKE ?)
                                OR
                                (LOWER(users.username) LIKE ?)
                            )'
                            , array($asrama->nama, '%'.strtolower($request->key).'%', '%'.strtolower($request->key).'%', '%'.strtolower($request->key).'%'));
            } else {
                return  redirect('dashboard');
            }
            return  view('checkin.list',['listCheckIn' => $checkin, 'listCheckOut' => $checkout, 'jenis' => $jenisPenghuni]);
        }
    }

    public function viewDetail($jenisPenghuni, $id_daftar) {
        if (Auth::guest()) {
            return redirect('login');
        } else if (Auth::user()->is_pengelola == 0) {
            return "You're not authorized to do this action";
        } else {
            $id_asrama = DB::select('SELECT * FROM pengelola WHERE id_user = ?', array(Auth::user()->id))[0] -> id_asrama;
            $asrama = Asrama::find($id_asrama);
            $action = 'View';
            if ($jenisPenghuni == 'reguler') {
                $pendaftaran =  DB::select('SELECT
                                    users.nama AS nama,
                                    daftar_asrama.id_daftar AS id_daftar,
                                    daftar_asrama.nomor_identitas AS nomor_identitas,
                                    daftar_asrama.jenis_identitas AS jenis_identitas,
                                    daftar_asrama.jenis_kelamin AS jenis_kelamin,
                                    daftar_asrama.pekerjaan AS pekerjaan,
                                    daftar_asrama.asrama AS asrama,
                                    daftar_asrama.status AS status,
                                    kamar.nama AS nama_kamar,
                                    gedung.nama AS nama_gedung
                                FROM
                                (SELECT * FROM daftar_asrama_reguler WHERE id_daftar = ?) AS daftar_asrama
                                JOIN users ON daftar_asrama.id_user = users.id
                                JOIN kamar_reguler ON daftar_asrama.id_daftar = kamar_reguler.id_pendaftaran_reguler
                                JOIN kamar ON kamar_reguler.id_kamar = kamar.id_kamar
                                JOIN gedung ON kamar.id_gedung = gedung.id_gedung
                                ORDER BY kamar_reguler.tanggal_akhir DESC
                                '
                            , array($id_daftar))[0];
                if ($pendaftaran->asrama != $asrama->nama) {
                    return "You're not authorized to do this action";
                }
                if ($pendaftaran->status == 'Teralokasi'){
                    $action = 'checkin';
                } else {
                    $checkout = DB::select('SELECT tanggal_masuk
                                FROM checkout_reguler
                                WHERE id_daftar = ?'
                            , array($id_daftar));
                    if (count($checkout) != 0) {
                        $action = 'checkout';
                        $pendaftaran->tanggal_masuk = $checkout[0]->tanggal_masuk;
                    }
                }
            } else if ($jenisPenghuni == 'nonreguler')  {
                $pendaftaran =  DB::select('SELECT
                                    users.nama AS nama,
                                    daftar_asrama.id_daftar AS id_daftar,
                                    daftar_asrama.nomor_identitas AS nomor_identitas,
                                    daftar_asrama.jenis_identitas AS jenis_identitas,
                                    daftar_asrama.jenis_kelamin AS jenis_kelamin,
                                    daftar_asrama.pekerjaan AS pekerjaan,
                                    daftar_asrama.asrama AS asrama,
                                    daftar_asrama.status AS status,
                                    kamar.nama AS nama_kamar,
                                    gedung.nama AS nama_gedung
                                FROM
                                (SELECT * FROM daftar_asrama_non_reguler WHERE id_daftar = ?) AS daftar_asrama
                                JOIN users ON daftar_asrama.id_user = users.id
                                JOIN kamar_non_reguler ON daftar_asrama.id_daftar = kamar_non_reguler.id_pendaftaran_non_reguler
                                JOIN kamar ON kamar_non_reguler.id_kamar = kamar.id_kamar
                                JOIN gedung ON kamar.id_gedung = gedung.id_gedung'
                            , array($id_daftar))[0];
                if ($pendaftaran->asrama != $asrama->nama) {
                    return "You're not authorized to do this action";
                }
                if ($pendaftaran->status == 'Teralokasi'){
                    $action = 'checkin';
                } else {
                    $checkout = DB::select('SELECT tanggal_masuk
                                FROM checkout_non_reguler
                                WHERE id_daftar = ?'
                            , array($id_daftar));
                    if (count($checkout) != 0) {
                        $action = 'checkout';
                        $pendaftaran->tanggal_masuk = $checkout[0]->tanggal_masuk;
                    }
                }
            } else {
                return  redirect('dashboard');
            }
            return view('checkin.detail',['pendaftaran' => $pendaftaran, 'jenis' => $jenisPenghuni, 'action' => $action,]);
        }
    }

    public function process(Request $request, $jenisPenghuni, $id_daftar) {
        if (Auth::guest()) {
            return redirect('login');
        } else if (Auth::user()->is_pengelola == 0) {
            return "You're not authorized to do this action";
        } else {
            if ($request->action == "checkin") {
                if ($jenisPenghuni == 'reguler') {
                    $pendaftaran =  DaftarAsramaReguler::where('id_daftar', $id_daftar)->first();
                    $pendaftaran -> status = 'Menghuni';
                    $pendaftaran -> save();
                    $updateUserPenghuni = UserPenghuni::where('id_user', $pendaftaran->id_user)->update(array('status_daftar'=>'Reguler'));
                } else if ($jenisPenghuni == 'nonreguler')  {

                    $pendaftaran =  DaftarAsramaNonReguler::where('id_daftar', $id_daftar)->first();
                    $pendaftaran -> status = 'Menghuni';
                    $pendaftaran -> save();

                    $checkout = new Model_Checkout_Non_Reguler;
                    $checkout->id_daftar = $pendaftaran->id_daftar;
                    $checkout->tanggal_masuk = $pendaftaran->tanggal_masuk;
                    $checkout->tanggal_keluar = $pendaftaran->tanggal_keluar;
                    $checkout -> save();

                    $updateUserPenghuni = UserPenghuni::where('id_user', $pendaftaran->id_user)->update(array('status_daftar'=>'Non Reguler'));
                } else {
                    return  redirect('dashboard');
                }
            }
            if ($request->action == "checkout"){
                if ($jenisPenghuni == 'reguler') {
                    $pendaftaran =  DaftarAsramaReguler::where('id_daftar', $id_daftar)->first();

                    if ($pendaftaran->status != 'Lanjut ke periode berikutnya') {
                        $updateUserPenghuni = UserPenghuni::where('id_user', $pendaftaran->id_user)->update(array('status_daftar'=>null));
                    }

                    $pendaftaran -> status = 'Keluar';
                    $pendaftaran -> save();
                    $deleteCheckOut = Model_Checkout_Reguler::where('id_daftar', $id_daftar) -> delete();


                } else if ($jenisPenghuni == 'nonreguler')  {
                    $pendaftaran =  DaftarAsramaNonReguler::where('id_daftar', $id_daftar)->first();
                    $pendaftaran -> status = 'Keluar';
                    $pendaftaran -> save();
                    $deleteCheckOut = Model_Checkout_Non_Reguler::where('id_daftar', $id_daftar) -> delete();
                    $updateUserPenghuni = UserPenghuni::where('id_user', $pendaftaran->id_user)->update(array('status_daftar'=>null));
                } else {
                    return redirect('dashboard');
                }
            }
            return redirect('manage/'.$jenisPenghuni.'/'.$id_daftar);
        }
    }

    public function printCheckIn($jenisPenghuni, $id_daftar) {
        if (Auth::guest()) {
          return view('404');
        } else {
          $user = Auth::user();

          if(!($user->is_admin == '1' || $user->is_pengelola == '1')) {
            return view('404');
          }
        }

        $userData = null;

        if($jenisPenghuni == 'nonreguler') {
          $userData = DB::table('users')
                      ->join('daftar_asrama_non_reguler', 'users.id', '=', 'daftar_asrama_non_reguler.id_user')
                      ->select('users.nama', 'users.email', 'daftar_asrama_non_reguler.*')
                      ->where('daftar_asrama_non_reguler.id_daftar', $id_daftar)
                      ->first();
          $nokamar = DB::table('daftar_asrama_non_reguler')
                     ->join('kamar_non_reguler', 'kamar_non_reguler.id_pendaftaran_non_reguler', 'daftar_asrama_non_reguler.id_daftar')
                     ->join('kamar', 'kamar.id_kamar', 'kamar_non_reguler.id_kamar')
                     ->select('kamar.nama')
                     ->where('daftar_asrama_non_reguler.id_daftar', $id_daftar)
                     ->orderBy('tanggal_akhir', 'desc')
                     ->first();
          $nokamar = $nokamar->nama;
          $iduser = DB::table('daftar_asrama_non_reguler') ->where('daftar_asrama_non_reguler.id_daftar', $id_daftar)
                                                           ->select('daftar_asrama_non_reguler.id_user')->first();
        }
        else {
          $userData = DB::table('users')
                      ->join('daftar_asrama_reguler', 'users.id', '=', 'daftar_asrama_reguler.id_user')
                      ->select('users.nama', 'users.email', 'daftar_asrama_reguler.*')
                      ->where('daftar_asrama_reguler.id_daftar', $id_daftar)
                      ->first();
          $nokamar = DB::table('daftar_asrama_reguler')
                     ->join('kamar_reguler', 'kamar_reguler.id_pendaftaran_reguler', 'daftar_asrama_reguler.id_daftar')
                     ->join('kamar', 'kamar.id_kamar', 'kamar_reguler.id_kamar')
                     ->select('kamar.nama')
                     ->where('daftar_asrama_reguler.id_daftar', $id_daftar)
                     ->orderBy('tanggal_akhir', 'desc')
                     ->first();
           $nokamar = $nokamar->nama;
           $iduser = DB::table('daftar_asrama_reguler') ->where('daftar_asrama_reguler.id_daftar', $id_daftar)
                                                        ->select('daftar_asrama_reguler.id_user')->first();
        }

        /* penentuan jenis kelamin, karena kalo di view bakal bottleneck */
        $jeniskelamin = null;
        $datakelamin = UserPenghuni::where('id_user', $iduser->id_user)->first();
        if($datakelamin->jenis_kelamin == 'L') $jeniskelamin = 'Laki-laki';
        else $jeniskelamin = 'Perempuan';

        /* fakultas */
        $mynim = DB::table('user_nim')->where('user_nim.status_nim', 1)->where('id_user', $iduser->id_user)->get();
        if($mynim == null || $mynim->count() == 0){
          $pdf = PDF::loadView('generatedFile.SuratPerjanjian', ['data'=>$userData, 'jeniskelamin'=>$jeniskelamin, 'nokamar'=>$nokamar]);
          return $pdf->download('SuratPerjanjian.pdf');
        } else {
          $mynim[0]->nama_fakultas = ($mynim[0]->id_fakultas != 0) ? Fakultas::find($mynim[0]->id_fakultas)->nama:'-';
          $mynim[0]->nama_prodi = ($mynim[0]->id_prodi != 0) ? Prodi::find($mynim[0]->id_prodi)->nama:'-';
          $pdf = PDF::loadView('generatedFile.SuratPerjanjian', ['data'=>$userData, 'jeniskelamin'=>$jeniskelamin, 'mynim'=>$mynim[0], 'nokamar'=>$nokamar]);
          return $pdf->download('SuratPerjanjian.pdf');
        }
    }

    public function printCheckOut($jenisPenghuni, $id_daftar) {
      if($jenisPenghuni == 'nonreguler') {
        $userData = DB::table('users')
                    ->join('daftar_asrama_non_reguler', 'users.id', '=', 'daftar_asrama_non_reguler.id_user')
                    ->select('users.nama', 'users.email', 'daftar_asrama_non_reguler.*')
                    ->where('daftar_asrama_non_reguler.id_daftar', $id_daftar)
                    ->first();
        $tanggal_keluar = DB::select('SELECT tanggal_keluar FROM checkout_non_reguler WHERE id_daftar = ?', array($id_daftar))[0]->tanggal_keluar;
        $userData->tanggal_keluar= $tanggal_keluar;
        $nokamar = DB::table('daftar_asrama_non_reguler')
                   ->join('kamar_non_reguler', 'kamar_non_reguler.id_pendaftaran_non_reguler', 'daftar_asrama_non_reguler.id_daftar')
                   ->join('kamar', 'kamar.id_kamar', 'kamar_non_reguler.id_kamar')
                   ->select('kamar.nama')
                   ->where('daftar_asrama_non_reguler.id_daftar', $id_daftar)
                   ->orderBy('tanggal_akhir', 'desc')
                   ->first();
         $nokamar = $nokamar->nama;
         $iduser = DB::table('daftar_asrama_non_reguler') ->where('daftar_asrama_non_reguler.id_daftar', $id_daftar)
                                                          ->select('daftar_asrama_non_reguler.id_user')->first();
      }
      else {
        $userData = DB::table('users')
                    ->join('daftar_asrama_reguler', 'users.id', '=', 'daftar_asrama_reguler.id_user')
                    ->select('users.nama', 'users.email', 'daftar_asrama_reguler.*')
                    ->where('daftar_asrama_reguler.id_daftar', $id_daftar)
                    ->first();
        $tanggal_keluar = DB::select('SELECT tanggal_keluar FROM checkout_reguler WHERE id_daftar = ?', array($id_daftar))[0]->tanggal_keluar;
        $userData->tanggal_keluar= $tanggal_keluar;
        $nokamar = DB::table('daftar_asrama_reguler')
                   ->join('kamar_reguler', 'kamar_reguler.id_pendaftaran_reguler', 'daftar_asrama_reguler.id_daftar')
                   ->join('kamar', 'kamar.id_kamar', 'kamar_reguler.id_kamar')
                   ->select('kamar.nama')
                   ->where('daftar_asrama_reguler.id_daftar', $id_daftar)
                   ->orderBy('tanggal_akhir', 'desc')
                   ->first();
         $nokamar = $nokamar->nama;
         $iduser = DB::table('daftar_asrama_reguler') ->where('daftar_asrama_reguler.id_daftar', $id_daftar)
                                                      ->select('daftar_asrama_reguler.id_user')->first();
      }

      /* fakultas */
      $mynim = DB::table('user_nim')->where('user_nim.status_nim', 1)->where('id_user', $iduser->id_user)->get();
      if($mynim == null || $mynim->count() == 0){
        $pdf = PDF::loadView('generatedFile.FormKeluar', ['data'=>$userData, 'nokamar'=>$nokamar]);
        return $pdf->download('FormKeluarAsrama.pdf');
      } else {
        $mynim[0]->nama_fakultas = ($mynim[0]->id_fakultas != 0) ? Fakultas::find($mynim[0]->id_fakultas)->nama:'-';
        $mynim[0]->nama_prodi = ($mynim[0]->id_prodi != 0) ? Prodi::find($mynim[0]->id_prodi)->nama:'-';
        $pdf = PDF::loadView('generatedFile.FormKeluar', ['data'=>$userData, 'mynim'=>$mynim[0], 'nokamar'=>$nokamar]);
        return $pdf->download('FormKeluarAsrama.pdf');
      }
    }
}

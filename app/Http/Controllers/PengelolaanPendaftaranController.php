<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Periode;
use App\Asrama;
use App\User;
use App\UserPenghuni;
use App\UserNIM;
use App\DaftarAsramaReguler;
use App\DaftarAsramaNonReguler;
use App\KamarReguler;
use App\KamarNonReguler;

class PengelolaanPendaftaranController extends Controller
{
	/**
     * Show the penghuni's applications
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
   		if (Auth::guest()) {
            return redirect('login');
        } else if (Auth::user()->is_pengelola == 0) {
        	return "You're not authorized to do this action";
        } else {
        	$user = Auth::user();
	    	$asrama = Asrama::find($user->pengelola->id_asrama);

	        $list_non_reguler = DaftarAsramaNonReguler::where([['status', 'Menunggu'], ['asrama', $asrama->nama]])->get();
	        foreach ($list_non_reguler as $data) {
	            $data->nama = User::where('id', $data->id_user)->first()->nama;
	        }

	        $list_nim = UserNIM::all();
	        $i = 0;
			$arrNIM = null;
	        foreach ($list_nim as $nim) {
	            $arrNIM[$i] = $nim->id_user;
	            $i++;
	        }

            $list_bidikmisi = UserPenghuni::where('is_bidikmisi', '1')->get();
            $i = 0;
            $arrBidikmisi = null;
            foreach ($list_bidikmisi as $bidikmisi) {
                $arrBidikmisi[$i] = $bidikmisi->id_user;
                $i++;
            }

	        $list_reguler = DaftarAsramaReguler::where([['status', 'Menunggu'], ['asrama', $asrama->nama]])->get();

            $list_reguler_bidikmisi = $list_reguler->whereIn('id_user', $arrBidikmisi);
            foreach ($list_reguler_bidikmisi as $data) {
                $data->nama = User::where('id', $data->id_user)->first()->nama;
                $val = UserNIM::where('id_user', $data->id_user)->get();
                if (count($val) != 0) {
                    $data->nim = UserNIM::where('id_user', $data->id_user)->orderBy('id_nim', 'desc')->first()->nim;
                }
                else {
                    $data->nim = "-";
                }
            }

	        $list_reguler_bermasalah = $list_reguler->whereNotIn('id_user', $arrNIM);
	        foreach ($list_reguler_bermasalah as $data) {
	            $data->nama = User::where('id', $data->id_user)->first()->nama;
	        }

	        $list_reguler_tidak_bermasalah = $list_reguler->whereIn('id_user', $arrNIM)->whereNotIn('id_user', $arrBidikmisi);
	        foreach ($list_reguler_tidak_bermasalah as $data) {
	            $data->nama = User::where('id', $data->id_user)->first()->nama;
	            $data->nim = UserNIM::where('id_user', $data->id_user)->orderBy('id_nim', 'desc')->first()->nim;
	        }

	        return view('pengelolaan_pendaftaran.index')
	        	-> with(['nama_asrama' => $asrama->nama,
                        'list_reguler_bidikmisi' => (isset($list_reguler_bidikmisi)) ? $list_reguler_bidikmisi : "",
	        			'list_non_reguler' => (isset($list_non_reguler)) ? $list_non_reguler : "",
	                    'list_reguler_bermasalah' => (isset($list_reguler_bermasalah)) ? $list_reguler_bermasalah : "",
	                    'list_reguler_tidak_bermasalah' => (isset($list_reguler_tidak_bermasalah)) ? $list_reguler_tidak_bermasalah : ""]);
	    }
    }

    /**
     * Accept selected
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function accept(Request $request) {
    	if (Auth::guest()) {
            return redirect('login');
        } else if (Auth::user()->is_pengelola == 0) {
        	return "You're not authorized to do this action";
        } else {
            $is_accept = ($request->action == 'accept');
            $periodes = Periode::where('status', 'Buka')->get();
            $vector_nama_periode = array();
            foreach($periodes as $periode) {
                array_push($vector_nama_periode, $periode->nama);
            }

            // VALIDASI JUMLAH YANG DI CHECK DAN JUMLAH KAMAR YG TERSEDIA
            $user = Auth::user();
            $asrama = Asrama::find($user->pengelola->id_asrama);
            $vector_id_kamars_reguler = array(); $vector_id_kamars_nonreguler = array();
            $kapasitas_asrama_reguler = 0; $kapasitas_asrama_nonreguler = 0;

            if ($asrama) {
                // Cari ID semua kamar pada asrama tsb
                $gedungs = $asrama->gedung;
                foreach($gedungs as $gedung) {
                    $kamars = $gedung->kamar;
                    foreach ($kamars as $kamar) {
                        if($kamar->status == 'Reguler') {
                            $kapasitas_asrama_reguler += $kamar->kapasitas;
                            array_push($vector_id_kamars_reguler, $kamar->id_kamar);
                        } else {
                            $kapasitas_asrama_nonreguler += $kamar->kapasitas;
                            array_push($vector_id_kamars_nonreguler, $kamar->id_kamar);
                        }
                    }
                }
            }

            // HITUNG JUMLAH KAMAR REGULER & NON REGULER YANG TERSEDIA
            $kamar_reguler = KamarReguler::whereIn('id_kamar', $vector_id_kamars_reguler)
                                        ->get(); // Untuk semua periode yang buka
            $kamar_nonreguler = KamarNonReguler::whereIn('id_kamar', $vector_id_kamars_nonreguler)
                                        ->whereDate('tanggal_akhir', '>=', date('Y-m-d'))
                                        ->get(); // Untuk semua tanggal yang belum lewat
            $used_capacity_reguler = new \stdClass();
            foreach ($vector_nama_periode as $nama_periode_kr) {
            	$used_capacity_reguler->$nama_periode_kr = 0;
            }
            foreach ($kamar_reguler as $kr) {
            	$nama_periode_kr = (string) $kr->daftar_asrama_reguler->nama_periode;
            	$used_capacity_reguler->$nama_periode_kr++;
            }
            $used_capacity_nonreguler = count($kamar_nonreguler);

            //$free_reguler = $kapasitas_asrama_reguler - $used_capacity_reguler;
            $free_nonreguler = $kapasitas_asrama_nonreguler - $used_capacity_nonreguler;

            // HITUNG JUMLAH YANG DICHECKBOX
            $list_non_reguler = DaftarAsramaNonReguler::where([['status', 'Menunggu'], ['asrama', $asrama->nama]])->get();
            $list_reguler = DaftarAsramaReguler::where([['status', 'Menunggu'], ['asrama', $asrama->nama]])->get();
            $list_nim = UserNIM::all();
            $i = 0;
            $arrNIM = null;
            foreach ($list_nim as $nim) {
                $arrNIM[$i] = $nim->id_user;
                $i++;
            }
            $list_bidikmisi = UserPenghuni::where('is_bidikmisi', '1')->get();
            $i = 0;
            $arrBidikmisi = null;
            foreach ($list_bidikmisi as $bidikmisi) {
                $arrBidikmisi[$i] = $bidikmisi->id_user;
                $i++;
            }
            $list_reguler_bermasalah = $list_reguler->whereNotIn('id_user', $arrNIM);
            $list_reguler_tidak_bermasalah = $list_reguler->whereIn('id_user', $arrNIM)->whereNotIn('id_user', $arrBidikmisi);
            $list_reguler_bidikmisi = $list_reguler->whereIn('id_user', $arrBidikmisi);

            $count_reguler = new \stdClass(); $count_nonreguler = 0;
            foreach ($vector_nama_periode as $nama_periode_kr) {
            	$count_reguler->$nama_periode_kr = 0;
            }

            foreach ($list_non_reguler as $key=>$non_reg_entry) {
                $tmp = "check_nr_".$key;
                if ($request->$tmp) {
                    $count_nonreguler++;
                }
            }
            foreach ($list_reguler_bermasalah as $key=>$reg_entry) {
                $tmp = "check_p_".$key;
                if ($request->$tmp) {
                    $nama_periode_kr = (string) $reg_entry->nama_periode;
	            	$count_reguler->$nama_periode_kr++;
	            }
            }
            foreach ($list_reguler_tidak_bermasalah as $key=>$reg_entry) {
                $tmp = "check_np_".$key;
                if ($request->$tmp) {
                    $nama_periode_kr = (string) $reg_entry->nama_periode;
	            	$count_reguler->$nama_periode_kr++;
	            }
            }
            foreach ($list_reguler_bidikmisi as $key=>$reg_entry) {
                $tmp = "check_bm_".$key;
                if ($request->$tmp) {
                    $nama_periode_kr = (string) $reg_entry->nama_periode;
	            	$count_reguler->$nama_periode_kr++;
	            }
            }

            // BANDINGKAN JUMLAH CHECKBOXES DAN FREE
            if ($is_accept) {
                $error_reguler = ''; $error_non_reguler = '';

                foreach ($vector_nama_periode as $nama_periode_kr) {
                	$free = $kapasitas_asrama_reguler - ($used_capacity_reguler->$nama_periode_kr);
                	if ($count_reguler->$nama_periode_kr > $free) {
                		$error_non_reguler = "Persetujuan reguler melebihi kapasitas asrama. Silahkan ditinjau kembali.";
                	}
                }

                if ($count_nonreguler > $free_nonreguler) {
                    $error_non_reguler = "Persetujuan non reguler melebihi kapasitas asrama. Silahkan ditinjau kembali.";
                }

                // JIKA ADA ERROR.....
                if ($error_reguler || $error_non_reguler) {
                    // ISI DULU KOMPONEN2NYA
                    foreach ($list_non_reguler as $data) {
                        $data->nama = User::where('id', $data->id_user)->first()->nama;
                    }
                    foreach ($list_reguler_bermasalah as $data) {
                        $data->nama = User::where('id', $data->id_user)->first()->nama;
                    }
                    foreach ($list_reguler_tidak_bermasalah as $data) {
                        $data->nama = User::where('id', $data->id_user)->first()->nama;
                        $data->nim = UserNIM::where('id_user', $data->id_user)->orderBy('id_nim', 'desc')->first()->nim;
                    }
                    foreach ($list_reguler_bidikmisi as $data) {
		                $data->nama = User::where('id', $data->id_user)->first()->nama;
		                $val = UserNIM::where('id_user', $data->id_user)->get();
		                if (count($val) != 0) {
		                    $data->nim = UserNIM::where('id_user', $data->id_user)->orderBy('id_nim', 'desc')->first()->nim;
		                }
		                else {
		                    $data->nim = "-";
		                }
		            }
                    return view('pengelolaan_pendaftaran.index')
                            ->with(['error_reguler' => $error_reguler,
                                'error_non_reguler' => $error_non_reguler,
                                'nama_asrama' => $asrama->nama,
                                'list_non_reguler' => (isset($list_non_reguler)) ? $list_non_reguler : "",
                                'list_reguler_bermasalah' => (isset($list_reguler_bermasalah)) ? $list_reguler_bermasalah : "",
                                'list_reguler_tidak_bermasalah' => (isset($list_reguler_tidak_bermasalah)) ? $list_reguler_tidak_bermasalah : "",
                                'list_reguler_bidikmisi' => (isset($list_reguler_bidikmisi) ? $list_reguler_bidikmisi : "")]);
                }
            }

            /*******************************************************************
             *
             *  OKAY... VALIDASI BERHASIL, PROSES SEMUA ENTRY YANG DICHECKBOX
             *
             *******************************************************************/
            // PROSES BIDIKMISI
            foreach ($list_reguler_bidikmisi as $key=>$bidikmisi_entry) {
        		$tmp = "check_bm_".$key;
        		if ($request->$tmp) {
                    $user_penghuni = UserPenghuni::where('id_user', $bidikmisi_entry->id_user)->first();
                    $user_penghuni->status_daftar = ($is_accept)? 'Reguler' : NULL;
                    $user_penghuni->save();

        			$bidikmisi_entry->status = ($is_accept)? 'Diterima' : 'Ditolak';
        			$bidikmisi_entry->save();
        		}
        	}

        	// PROSES NONREGULER
        	foreach ($list_non_reguler as $key=>$non_reg_entry) {
        		$tmp = "check_nr_".$key;
        		if ($request->$tmp) {
                    $user_penghuni = UserPenghuni::where('id_user', $non_reg_entry->id_user)->first();
                    $user_penghuni->status_daftar = ($is_accept)? 'Non Reguler' : NULL;
                    $user_penghuni->save();

        			$non_reg_entry->status = ($is_accept)? 'Diterima' : 'Ditolak';
        			$non_reg_entry->save();
        		}
        	}

            // PROSES REGULER
        	foreach ($list_reguler_bermasalah as $key=>$reg_entry) {
        		$tmp = "check_p_".$key;
        		if ($request->$tmp) {
                    $user_penghuni = UserPenghuni::where('id_user', $reg_entry->id_user)->first();
                    $user_penghuni->status_daftar = ($is_accept)? 'Reguler' : NULL;
                    $user_penghuni->save();

        			$reg_entry->status = ($is_accept)? 'Diterima' : 'Ditolak';
        			$reg_entry->save();
        		}
        	}
        	foreach ($list_reguler_tidak_bermasalah as $key=>$reg_entry) {
        		$tmp = "check_np_".$key;
        		if ($request->$tmp) {
                    $user_penghuni = UserPenghuni::where('id_user', $reg_entry->id_user)->first();
                    $user_penghuni->status_daftar = ($is_accept)? 'Reguler' : NULL;
                    $user_penghuni->save();

        			$reg_entry->status = ($is_accept)? 'Diterima' : 'Ditolak';
        			$reg_entry->save();
        		}
        	}
        	return redirect('pendaftaran');
        }
    }
}

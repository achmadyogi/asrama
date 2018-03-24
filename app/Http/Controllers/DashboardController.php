<?php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\DB;
use App\DaftarAsramaReguler;
use App\DaftarAsramaNonReguler;
use App\UserNIM;
use App\Asrama;
use App\NextPeriode;
use App\Periode;
use App\Blacklist;
use App\Model_Keluar_Asrama_Reguler;
use App\Model_Keluar_Asrama_Non_Reguler;
use App\Model_Pindah_Asrama_Reguler;
use App\Model_Pindah_Asrama_Non_Reguler;
use App\KerusakanKamar;
class DashboardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        $user->nim = (isset($user->valid_nim[0])) ? $user->valid_nim[0]->nim : "-" ;
        $user_penghuni_info = $user->user_penghuni;
        if ($user->is_penghuni == '1') {
            $des_reguler = 'Penghuni reguler adalah penghuni dengan status mahasiswa ITB. Seorang penghuni reguler hanya dapat mendaftar pada periode tertentu yang waktunya telah ditetapkan oleh pihak asrama.';
            $des_nonreguler = 'Penghuni Non Reguler terbuka bagi siapa saja yang ingin mendaftar ke asrama. Penghuni Non Reguler dapat menetapkan tanggal masuk dan tanggal keluar dari asrama sesuai keinginan sendiri.';
            $user_daftar_reguler = DB::table('daftar_asrama_reguler')
                                    ->join('kamar_reguler', 'kamar_reguler.id_pendaftaran_reguler', '=', 'daftar_asrama_reguler.id_daftar')
                                    ->select('id_daftar', 'asrama', 'id_kamar', 'tanggal_masuk', 'tanggal_keluar', 'status', 'created_at', 'status_penghuni')
                                    ->where('id_user', $user->id);
            $user_daftar_non_reguler = DB::table('daftar_asrama_non_reguler')
                                        ->join('kamar_non_reguler', 'kamar_non_reguler.id_pendaftaran_non_reguler', '=', 'daftar_asrama_non_reguler.id_daftar')
                                        ->select('id_daftar', 'asrama', 'id_kamar', 'tanggal_masuk', 'tanggal_keluar', 'status', 'created_at', 'status_penghuni')
                                        ->where('id_user', $user->id);

      			$user_daftar = DB::select('SELECT * FROM
      			(
      				SELECT *
      				FROM
      					(SELECT * FROM (SELECT id_daftar, id_user, nama, nomor_identitas, jenis_identitas, jenis_kelamin, asrama, tanggal_masuk, tanggal_keluar, status_penghuni, status
      						FROM users JOIN daftar_asrama_reguler WHERE id = id_user AND id_user = '.$user->id.') b
      						LEFT JOIN
      							(SELECT d.id_pendaftaran_reguler, created, d.id_kamar, e.nama AS nama_kamar
      								FROM
      								(
      									SELECT f.id_pendaftaran_reguler, MAX(f.created_at) as created
      									FROM kamar_reguler f JOIN kamar g ON f.id_kamar = g.id_kamar
      									GROUP BY f.id_pendaftaran_reguler
      								) kamarList
      							JOIN kamar_reguler d JOIN kamar e WHERE d.id_pendaftaran_reguler = kamarList.id_pendaftaran_reguler AND d.created_at = kamarList.created AND d.id_kamar = e.id_kamar)
      					c ON b.id_daftar = c.id_pendaftaran_reguler) a
      				UNION ALL
      				SELECT *
      				FROM
      					(SELECT * FROM (SELECT id_daftar, id_user, nama, nomor_identitas, jenis_identitas, jenis_kelamin, asrama, tanggal_masuk, tanggal_keluar, status_penghuni, status
      						FROM users JOIN daftar_asrama_non_reguler WHERE id = id_user AND id_user = '.$user->id.') b
      						LEFT JOIN
      							(SELECT d.id_pendaftaran_non_reguler, created, d.id_kamar, e.nama AS nama_kamar
      								FROM
      								(
      									SELECT f.id_pendaftaran_non_reguler, MAX(f.created_at) as created
      									FROM kamar_non_reguler f JOIN kamar g ON f.id_kamar = g.id_kamar
      									GROUP BY f.id_pendaftaran_non_reguler
      								) kamarList
      							JOIN kamar_non_reguler d JOIN kamar e WHERE d.id_pendaftaran_non_reguler = kamarList.id_pendaftaran_non_reguler AND d.created_at = kamarList.created AND d.id_kamar = e.id_kamar)
      					c ON b.id_daftar = c.id_pendaftaran_non_reguler) a
      			) userDaftar
      			ORDER BY tanggal_masuk DESC');

			      $user_daftar = collect($user_daftar);
            $last_daftar = $user_daftar->first();
            $list_next_periode = NextPeriode::all();
            $is_tombol = 0;
            $pesan_checkout = 0;
            $pesan_checkin = 0;
            foreach ($list_next_periode as $data) {
                $periode_asal = Periode::find($data->periode_asal);
                if ($last_daftar != NULL) {
                    if ($periode_asal->tanggal_awal == $last_daftar->tanggal_masuk and $periode_asal->tanggal_akhir == $last_daftar->tanggal_keluar and $last_daftar->status_penghuni == 'Reguler' and $last_daftar->status == 'Menghuni') {
                        $is_tombol = 1;
                        $tanggal_akhir = $last_daftar->tanggal_keluar;
                        $periode_lanjut = Periode::find($data->periode_akhir);
                    }
                    else if ($last_daftar->status == 'Tidak Lanjut' or $last_daftar->status == 'Disetujui keluar') {
                        $pesan_checkout = 1;
                    }
                    else if ($last_daftar->status == 'Teralokasi') {
                        $pesan_checkin = 1;
                        $is_ada_lanjut = $user_daftar->where('status', 'Lanjut ke periode berikutnya')->first();
                        if ($is_ada_lanjut) {
                            $pesan_checkout = 1;
                        }
                    }
                }
            }
        }



        if ($user->is_pengelola == '1') {
			// STATISTIK PENGELOLA DI SINI
			$asrama = DB::select('SELECT * FROM pengelola JOIN asrama
							WHERE asrama.id_asrama = pengelola.id_asrama AND pengelola.id_user = '.$user->id);
			$nama_asrama = $asrama[0]->nama;

			$tanggal = $tanggal = date("Y-m-d");

			$count_pendaftar_reguler = DaftarAsramaReguler::where([['status', '=', 'Menunggu'], ['asrama', '=', $nama_asrama]])->count();
			$count_pendaftar_non_reguler = DaftarAsramaNonReguler::where([['status', '=', 'Menunggu'], ['asrama', '=', $nama_asrama]])->count();
			$count_checkin_reguler = DaftarAsramaReguler::where([['status', '=', 'Teralokasi'], ['asrama', '=', $nama_asrama]])->count();
			$count_checkin_non_reguler = DaftarAsramaNonReguler::where([['status', '=', 'Teralokasi'], ['asrama', '=', $nama_asrama]])->count();
			$count_checkout_reguler = DB::table('checkout_reguler')
									  ->join('daftar_asrama_reguler', 'daftar_asrama_reguler.id_daftar', '=', 'checkout_reguler.id_daftar')
									  ->select('checkout_reguler.id_daftar')
									  ->where('daftar_asrama_reguler.asrama', $nama_asrama)
									  ->count();
			$count_checkout_non_reguler = DB::table('checkout_non_reguler')
									  ->join('daftar_asrama_non_reguler', 'daftar_asrama_non_reguler.id_daftar', '=', 'checkout_non_reguler.id_daftar')
									  ->select('checkout_non_reguler.id_daftar')
									  ->where('daftar_asrama_non_reguler.asrama', $nama_asrama)
									  ->count();


			$kamars = DB::select('SELECT kamar.id_kamar, kamar.id_gedung, kamar.nama, jumlahPenghuniList.jumlah_penghuni, kamar.kapasitas, kamar.gender, kamar.status
									FROM
									(
										SELECT data_penghuni.id_kamar, count(*) as jumlah_penghuni
										FROM
										(
											SELECT kamar.id_kamar, kamar.id_gedung, kamar.nama, kamar.kapasitas, kamar.gender
												FROM
												(
													SELECT kamar.id_kamar, kamar.id_gedung, kamar.nama, kamar.kapasitas, kamar.gender
													FROM asrama JOIN gedung JOIN kamar
													WHERE asrama.id_asrama = '.$asrama[0]->id_asrama.' AND asrama.id_asrama = gedung.id_asrama AND gedung.id_gedung = kamar.id_gedung
												) kamar
												JOIN
												(
													SELECT d.id_pendaftaran_reguler AS id_pendaftaran, tanggal_awal, tanggal_akhir, created, d.id_kamar, e.nama AS nama_kamar
													FROM
													(
														SELECT f.id_pendaftaran_reguler, MAX(f.created_at) as created
														FROM kamar_reguler f JOIN kamar g ON f.id_kamar = g.id_kamar
														GROUP BY f.id_pendaftaran_reguler
													) kamarList
													JOIN kamar_reguler d JOIN kamar e JOIN daftar_asrama_reguler
													WHERE d.id_pendaftaran_reguler = kamarList.id_pendaftaran_reguler AND d.id_pendaftaran_reguler = daftar_asrama_reguler.id_daftar AND d.created_at = kamarList.created AND d.id_kamar = e.id_kamar
														AND tanggal_awal <= "'.$tanggal.'" AND "'.$tanggal.'" <= tanggal_akhir
													UNION ALL
													SELECT d.id_pendaftaran_non_reguler AS id_pendaftaran, tanggal_awal, tanggal_akhir, created, d.id_kamar, e.nama AS nama_kamar
													FROM
													(
														SELECT f.id_pendaftaran_non_reguler, MAX(f.created_at) as created
														FROM kamar_non_reguler f JOIN kamar g ON f.id_kamar = g.id_kamar
														GROUP BY f.id_pendaftaran_non_reguler
													) kamarList
													JOIN kamar_non_reguler d JOIN kamar e JOIN daftar_asrama_non_reguler
													WHERE d.id_pendaftaran_non_reguler = kamarList.id_pendaftaran_non_reguler AND d.id_pendaftaran_non_reguler = daftar_asrama_non_reguler.id_daftar AND d.created_at = kamarList.created AND d.id_kamar = e.id_kamar
													AND tanggal_awal <= "'.$tanggal.'" AND "'.$tanggal.'" <= tanggal_akhir
												) penghuni
											ON kamar.id_kamar = penghuni.id_kamar
										) data_penghuni
										GROUP BY data_penghuni.id_kamar
									) jumlahPenghuniList
									RIGHT JOIN kamar ON jumlahPenghuniList.id_kamar = kamar.id_kamar
									JOIN gedung JOIN asrama
									WHERE asrama.id_asrama = '.$asrama[0]->id_asrama.' AND asrama.id_asrama = gedung.id_asrama AND gedung.id_gedung = kamar.id_gedung
								');


			$kamars = collect($kamars);

			$jumlah_penghuni = 0;
			$kamar_dihuni = 0;
			$jumlah_kamar = 0;
			foreach ($kamars as $kamar) {
				if($kamar->jumlah_penghuni > 0) {
					$kamar_dihuni++;
					$jumlah_penghuni += $kamar->jumlah_penghuni;
				}
				$jumlah_kamar++;
			}

			$kamar_rusak = DB::select("SELECT count(*) jumlah
											FROM kamar JOIN gedung JOIN asrama
											WHERE status = 'Rusak' AND asrama.id_asrama = ".$asrama[0]->id_asrama." AND asrama.id_asrama = gedung.id_asrama AND gedung.id_gedung = kamar.id_gedung");
			$kamar_rusak = collect($kamar_rusak);

			$kamar_kosong = $jumlah_kamar - $kamar_dihuni - $kamar_rusak[0]->jumlah;

			$laporan_belum_ditangani = DB::select("SELECT id_kerusakan, nama, keterangan, DATE_FORMAT(created_at, '%W, %d %M %Y %h:%i %p'), status
											FROM (SELECT id_kerusakan, kamar.nama, keterangan, created_at, kerusakan_kamar.status
												FROM kerusakan_kamar JOIN pengelola JOIN asrama JOIN gedung JOIN kamar
												WHERE asrama.id_asrama = pengelola.id_asrama AND pengelola.id_user = ".$user->id." AND asrama.id_asrama = gedung.id_asrama AND gedung.id_gedung = kamar.id_gedung AND kamar.id_kamar = kerusakan_kamar.id_kamar AND kerusakan_kamar.status = 'Belum Ditangani') a
											ORDER BY created_at DESC");
			$laporan_belum_ditangani = collect($laporan_belum_ditangani);

			$laporan = DB::select("SELECT id_kerusakan, nama, keterangan, DATE_FORMAT(created_at, '%W, %d %M %Y %h:%i %p'), status
											FROM (SELECT id_kerusakan, kamar.nama, keterangan, created_at, kerusakan_kamar.status
												FROM kerusakan_kamar JOIN pengelola JOIN asrama JOIN gedung JOIN kamar
												WHERE asrama.id_asrama = pengelola.id_asrama AND pengelola.id_user = ".$user->id." AND asrama.id_asrama = gedung.id_asrama AND gedung.id_gedung = kamar.id_gedung AND kamar.id_kamar = kerusakan_kamar.id_kamar) a
											ORDER BY created_at DESC");
			$laporan = collect($laporan);
			
            // NOTIFIKASI
            $count_request_daftar = DaftarAsramaNonReguler::where([['status', 'Menunggu'], ['asrama', $nama_asrama]])->count() + DaftarAsramaReguler::where([['status', 'Menunggu'], ['asrama', $nama_asrama]])->count();

			$count_alokasi_reguler = DB::select("SELECT id_daftar, id_user, nama, nomor_identitas, jenis_identitas, jenis_kelamin, asrama, nama_periode, tanggal_masuk, tanggal_keluar, nama_kamar
													FROM
													(SELECT * FROM (SELECT id_daftar, id_user, nama, nomor_identitas, jenis_identitas, jenis_kelamin, asrama, nama_periode, tanggal_masuk, tanggal_keluar
														FROM users JOIN daftar_asrama_reguler WHERE id = id_user AND (status = 'Diterima') AND DATE(NOW()) <= tanggal_keluar AND asrama = '".$asrama[0]->nama."') b
														LEFT JOIN
															(SELECT d.id_pendaftaran_reguler, created, d.id_kamar, e.nama AS nama_kamar
																FROM
																(
																	SELECT f.id_pendaftaran_reguler, MAX(f.created_at) as created
																	FROM kamar_reguler f JOIN kamar g ON f.id_kamar = g.id_kamar
																	GROUP BY f.id_pendaftaran_reguler
																) kamarList
															JOIN kamar_reguler d JOIN kamar e WHERE d.id_pendaftaran_reguler = kamarList.id_pendaftaran_reguler AND d.created_at = kamarList.created AND d.id_kamar = e.id_kamar)
													c ON b.id_daftar = c.id_pendaftaran_reguler) a ");
			$count_alokasi_reguler = collect($count_alokasi_reguler)->count();

			$count_alokasi_non_reguler = DB::select("SELECT id_daftar, id_user, nama, nomor_identitas, jenis_identitas, jenis_kelamin, asrama, tanggal_masuk, tanggal_keluar, nama_kamar
														FROM
														(SELECT * FROM (SELECT id_daftar, id_user, nama, nomor_identitas, jenis_identitas, jenis_kelamin, asrama, tanggal_masuk, tanggal_keluar
															FROM users JOIN daftar_asrama_non_reguler WHERE id = id_user AND (status = 'Diterima') AND DATE(NOW()) <= tanggal_keluar AND asrama = '".$asrama[0]->nama."') b
															LEFT JOIN
																(SELECT d.id_pendaftaran_non_reguler, created, d.id_kamar, e.nama AS nama_kamar
																	FROM
																	(
																		SELECT f.id_pendaftaran_non_reguler, MAX(f.created_at) as created
																		FROM kamar_non_reguler f JOIN kamar g ON f.id_kamar = g.id_kamar
																		GROUP BY f.id_pendaftaran_non_reguler
																	) kamarList
																JOIN kamar_non_reguler d JOIN kamar e WHERE d.id_pendaftaran_non_reguler = kamarList.id_pendaftaran_non_reguler AND d.created_at = kamarList.created AND d.id_kamar = e.id_kamar)
														c ON b.id_daftar = c.id_pendaftaran_non_reguler) a ");
			$count_alokasi_non_reguler = collect($count_alokasi_non_reguler)->count();
        }
        if ($user->is_sekretariat == '1') {
            $count_request_keluar = Model_Keluar_Asrama_Reguler::where('status_keluar', 'Diajukan')->count() + Model_Keluar_Asrama_Non_Reguler::where('status_keluar', 'Diajukan')->count();
            $count_request_pindah = Model_Pindah_Asrama_Reguler::getProposedRequest()->count() + Model_Pindah_Asrama_Non_Reguler::getProposedRequest()->count();
        }
        if ($user->is_admin == '1') {
            $count_user = User::all()->count();
        }
    		$is_blacklist = Blacklist::find($user->id);


        return view('dashboard')
            ->with(['user' => $user,
                    'user_penghuni_info' => $user_penghuni_info,
                    'user_daftar' => (isset($user_daftar)) ? $user_daftar : "",
                    'des_reguler' => (isset($des_reguler)) ? $des_reguler : "",
                    'des_nonreguler' => (isset($des_nonreguler)) ? $des_nonreguler : "",
                    'is_tombol' => $is_tombol,
                    'pesan_checkout' => $pesan_checkout,
                    'pesan_checkin' => $pesan_checkin,
                    'tanggal_akhir' => (isset($tanggal_akhir)) ? $tanggal_akhir : "",
                    'periode_lanjut' => (isset($periode_lanjut)) ? $periode_lanjut : "",
      							'jumlah_penghuni' => (isset($jumlah_penghuni)) ? $jumlah_penghuni : "",
      							'kamar_dihuni' => (isset($kamar_dihuni)) ? $kamar_dihuni : "",
      							'kamar_kosong' => (isset($kamar_kosong)) ? $kamar_kosong : "",
          					'is_blacklist' => (isset($is_blacklist)) ? $is_blacklist : "",
          					'kamar_rusak' => (isset($kamar_rusak)) ? $kamar_rusak : "",
          					'laporan_belum_ditangani' => (isset($laporan_belum_ditangani)) ? $laporan_belum_ditangani : "",
          					'laporan' => (isset($laporan)) ? $laporan : "",
                    'nama_asrama' => (isset($nama_asrama)) ? $nama_asrama : "",
					'count_alokasi_reguler' => (isset($count_alokasi_reguler)) ? $count_alokasi_reguler : "0",
					'count_alokasi_non_reguler' => (isset($count_alokasi_non_reguler)) ? $count_alokasi_non_reguler : "0",
                    'count_request_daftar' => (isset($count_request_daftar)) ? $count_request_daftar : "0",
                    'count_request_keluar' => (isset($count_request_keluar)) ? $count_request_keluar : "0",
                    'count_request_pindah' => (isset($count_request_pindah)) ? $count_request_pindah : "0",
                    'count_pendaftar_reguler' => (isset($count_pendaftar_reguler)) ? $count_pendaftar_reguler : "0",
                    'count_pendaftar_non_reguler' => (isset($count_pendaftar_non_reguler)) ? $count_pendaftar_non_reguler : "0",
                    'count_checkin_reguler' => (isset($count_checkin_reguler)) ? $count_checkin_reguler : '0',
                    'count_checkin_non_reguler' => (isset($count_checkin_non_reguler)) ? $count_checkin_non_reguler : '0',
                    'count_checkout_reguler' => (isset($count_checkout_reguler)) ? $count_checkout_reguler : '0',
                    'count_checkout_non_reguler' => (isset($count_checkout_non_reguler)) ? $count_checkout_non_reguler : '0',
                    'count_user' => (isset($count_user)) ? $count_user : "-"]);
    }
}

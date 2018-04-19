<?php

use Illuminate\Database\Seeder;

class AsramaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      DB::table('Asrama')->insert([
    'id_asrama'=>'1',
    'nama'=>'Asrama Internasional',
    'alamat'=>'Jalan Sangkuriang N0. 27, Kelurahan dago, Kecamatan Coblong, Kota Bandung',

    'deskripsi'=>'Asrama Internasional adalah Asrama Mahasiswa yang diperuntukan bagi Mahasiswa Luar Negeri. Memiliki 23 kamar, secara umum berkapasitas 2 orang per kamarnya, namun 2 kamar yang memiliki kapasitas 1 orang. 23 kamar ini tersebar di 2 lantai, lantai 1 berisi 11 kamar dan lantai 2 berisi 12 kamar. Fasilitas di setiap kamar secara umum sama, yang terdiri dari: meja belajar, kursi, tempat tidur, dispenser, lemari, rak sepatu, parki mobil dan motor, dan lain-lain.',
    'filename'=>'asrama internasional.PNG'
    ] );


    DB::table('Asrama')->insert([
    'id_asrama'=>'2',
    'nama'=>'Asrama Jatinangor',
    'alamat'=>'
    Jalan Let. Jen. Purn. Dr. (HC). Mashudi N0.1/ Jl. Raya  Jatinangor Km 20,75 Sumedang, Jawa Barat – Indonesia

    ',

    'deskripsi'=>'
    Asrama Jatinangor adalah asrama mahasiswa ITB terbaru yang mulai digunakan pada bulan Agustus 2012. Berbeda dengan asrama ITB lainnya yang terletak di Kota Bandung dan diluar kampus ITB, gedung ini terletak di dalam lingkungan kampus ITB - Jatinangor, di Jalan Let. Jen. Purn. Dr. (HC). Mashudi N0.1/ Jl. Raya  Jatinangor Km 20,75 Sumedang, Jawa Barat – Indonesia. Kompleks asrama ini terdiri atas 4 gedung yaitu TB1 dan TB4 untuk mahasiswa putra, sedangkan TB2 dan TB3 untuk mahasiswi putri. Tiap gedung terdiri atas 5 lantai. Lantai kedua hingga lantai kelima di setiap lantainya terdiri atas 23 kamar siap huni dan 1 ruang bersama.
    Untuk kamar di TB1 & TB2 memiliki fasilitas kamar mandi dan pantry serta disediakan masing-masing 2 tempat tidur, 2 lemari, 2 meja belajar dan 2 kursi yang diperuntukkan untuk 2 orang penghuni.
    Untuk kamar di TB3 & TB4 memiliki fasilitas kamar mandi serta disediakan masing-masing 3 tempat tidur, 3 lemari, 3 meja belajar dan 3 kursi yang diperuntukkan untuk 3 orang penghuni.
    Ruang bersama tiap gedung pada lantai dua hingga lima masing-masing memiliki fasilitas kompor, kulkas, meja dan kursi, lemari dinding, WC dan pantry.
    Saat ini fasilitas luar kamar yang terdapat di dalam kompleks asrama meliputi Mushola, KKP ITB, Kokesma ITB, WC Umum, Meja Pingpong, Selasar untuk kegiatan penghuni dan internet.',
    'filename'=>'jatinangor 2.jpg'
    ] );



         DB::table('Asrama')->insert([
           'id_asrama'=>'3',
         'nama'=>'Asrama Kanayakan (Khusus Putri)',
         'alamat'=>'
         Jalan Kanayakan Bawah No.61, Kota Bandung.',

         'deskripsi'=>'
         Asrama Kanayakan adalah asrama khusus mahasiswi ITB yang utamanya diperuntukkan bagi mahasiswi penerima beasiswa BIDIK MISI. Asrama ini terdiri dari 2 gedung yaitu gedung baru (4 lantai) dan gedung lama (3 lantai). Masing-masing diisi 2-3 Mahasiswi per kamar. Jumlah kamar di gedung lama adalah 34 kamar dan di gedung baru 35 kamar. Fasilitas yang disediakan adalah tempat tidur, meja belajar, kursi dan lemari baju.',
         'filename'=>'kanayakan 1\'.PNG'
         ] );


         DB::table('Asrama')->insert([
           'id_asrama'=>'4',
         'nama'=>'Asrama Kidang Pananjung (Khusus Putra)',
         'alamat'=>'
         Jalan Cisitu Lama VIII No.12, Kelurahan Dago, Kecamatan Coblong, Kota Bandung ',

         'deskripsi'=>'
         Asrama Kidang Pananjung adalah asrama khusus mahasiswa ITB yang diperuntukan bagi mahasiswa TPB laki-laki. Asrama ini memiliki 6 gedung. Satu gedung utama yaitu gedung A digunakan sebagai kantor dan 5 gedung lainnya (Gedung B,C,D,E,F) adalah gedung asrama. Jumlah kamar yang ada di asrama ini adalah 74 kamar dengan luas masing-masing kamar 6 x 6 m2. Fasilitas yang disediakan di dalam kamar terdiri dari 3 tempat tidur, 3 lemari pakaian, 3 meja dan kursi belajar dan 3 rak buku. Fasilitas di luar kamar adalah kamar mandi, parkir mobil dan motor.',
         'filename'=>'kidang pananjung 1.jpg'
         ] );


         DB::table('Asrama')->insert([
           'id_asrama'=>'5',
         'nama'=>'Asrama Sangkuriang Lama (A dan B)',
         'alamat'=>'
         Jalan Sangkuriang Dalam No.55, Kelurahan Dago, Kecamatan Coblong, Kota Bandung.',

         'deskripsi'=>'
         Asrama Sangkuriang adalah asrama yang diperuntukkan bagi mahasiswa ITB yang terletak di daerah Sangkuriang. Asrama Sangkuriang Lama terdiri dari 2 gedung, yaitu Gedung A untuk mahasiswa TPB Laki-laki dan Gedung B untuk mahsiswa TPB Perempuan dengan masing-masing gedung mempunyai 48 kamar (5 Lantai). Satu Kamar terdiri dari 2 mahasiswa dengan fasilitas 2 kamar mandi di dalam, 1 dapur, 1 lemari pakaian, 2 meja belajar, 2 kursi belajar, 2 spring bed, jemuran pakaian, dan listrik perkamar daya 450 watt.
         Saat ini juga telah dioperasikan 2 gedung asrama baru di Asrama Sangkuriang, yaitu Gedung C (Perempuan) dan Gedung D (laki-laki) dengan kamar berkapasitas 2-3 orang.
         Kegiatan-kegiatan yang dilakukan adalah Tutorial, Diskusi dan beberapa event lainnya yang menarik.',
         'filename'=>'sangkuriang 1.jpg'
         ] );


         DB::table('Asrama')->insert([
           'id_asrama'=>'6',
         'nama'=>'Asrama Sangkuriang Baru (C (Putri) / D (Putra)) ',
         'alamat'=>'
         Jalan Sangkuriang Dalam No.55, Kelurahan Dago, Kecamatan Coblong, Kota Bandung.',

         'deskripsi'=>'Pembangunan Asrama Tower C , Tower D dan Lanskape Asrama dimulai sejak tahun 2015 dan sudah mulai difungsikan awal tahun 2017, dengan dana dari Kementrian Risert Teknologi dan Pendidikan Tinggi (Kemenristek DIKTI).
         Peruntukan Asrama untuk :
         1. Tower C sebanyak 70 Kamar menampung 194 mahasiswa, dengan ditambah 1 (satu) kamar Petugas Asrama di Lt. 4 dan 1 (Satu) kamar di ruang security di Lt.3;<br>
         2. Tower D Sebanyak 70 Kamar menampung 202 mahasiswa, dengan ditambah 1 (satu) kamar Petugas Asrama di Lt. 4 dan 1 (satu) kamar di ruang security di Lt.3;<br>
         Total Kamar mahasiswa ada 140 kamar dan 396 mahasiswa ditambah 2 (Dua) orang petugas asrama dan 2 (Dua) orang security Jadi total keseluruhan penghuni asrama sebanyak 400 orang.
         Asrama Sangkuriang merupakan 2 gedung asrama baru di Asrama Sangkuriang, yaitu Gedung C (Perempuan) dan Gedung D (laki-laki) dengan kamar berkapasitas 2-3 orang.
         Kegiatan-kegiatan yang dilakukan adalah Tutorial, Diskusi dan beberapa event lainnya yang menarik.',
         'filename'=>'4c56ff4ce4aaf9573aa5dff913df997a.jpg'
         ] );
    }
}

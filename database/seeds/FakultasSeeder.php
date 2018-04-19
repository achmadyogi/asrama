<?php

use Illuminate\Database\Seeder;

class FakultasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	/***** FAKULTAS *****/
        DB::table('fakultas')->insert([
		            'nama' => '(FMIPA) Fakultas Matematika dan Ilmu Pengetahuan Alam',
		        ]);
		DB::table('fakultas')->insert([
		            'nama' => '(SITHS) Sekolah Ilmu dan Teknologi Hayati - Program Sains',
		        ]);
		DB::table('fakultas')->insert([
		            'nama' => '(SITHR) Sekolah Ilmu dan Teknologi Hayati - Program Rekayasa',
		        ]);
		DB::table('fakultas')->insert([
		            'nama' => '(SF) Sekolah Farmasi',
		        ]);
		DB::table('fakultas')->insert([
		            'nama' => '(FTTM) Fakultas Teknik Pertambangan dan Perminyakan',
		        ]);
		DB::table('fakultas')->insert([
		            'nama' => '(FITB) Fakultas Ilmu dan Teknologi Kebumian',
		        ]);
		DB::table('fakultas')->insert([
		            'nama' => '(FTI) Fakultas Teknologi Industri',
		        ]);
		DB::table('fakultas')->insert([
		            'nama' => '(STEI) Sekolah Teknik Elektro dan Informatika',
		        ]);
		DB::table('fakultas')->insert([
		            'nama' => '(FTMD) Fakultas Teknik Mesin dan Dirgantara',
		        ]);
		DB::table('fakultas')->insert([
		            'nama' => '(FTSL) Fakultas Teknik Sipil dan Lingkungan',
		        ]);
		DB::table('fakultas')->insert([
		            'nama' => '(SAPPK) Sekolah Arsitektur dan Perencanaan Pengembangan Kebijakan',
		        ]);
		DB::table('fakultas')->insert([
		            'nama' => '(FSRD) Fakultas Seni Rupa dan Desain',
		        ]);
		DB::table('fakultas')->insert([
		            'nama' => '(SBM) Sekolah Bisnis dan Manajemen',
		        ]);


    }
}

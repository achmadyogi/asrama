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
		            'nama' => 'Fakultas Matematika dan Ilmu Pengetahuan Alam',
		        ]);
		DB::table('fakultas')->insert([
		            'nama' => 'Sekolah Ilmu dan Teknologi Hayati',
		        ]);
		DB::table('fakultas')->insert([
		            'nama' => 'Sekolah Farmasi',
		        ]);
		DB::table('fakultas')->insert([
		            'nama' => 'Fakultas Teknik Pertambangan dan Perminyakan',
		        ]);
		DB::table('fakultas')->insert([
		            'nama' => 'Fakultas Ilmu dan Teknologi Kebumian',
		        ]);
		DB::table('fakultas')->insert([
		            'nama' => 'Fakultas Teknologi Industri',
		        ]);
		DB::table('fakultas')->insert([
		            'nama' => 'Sekolah Teknik Elektro dan Informatika',
		        ]);
		DB::table('fakultas')->insert([
		            'nama' => 'Fakultas Teknik Mesin dan Dirgantara',
		        ]);
		DB::table('fakultas')->insert([
		            'nama' => 'Fakultas Teknik Sipil dan Lingkungan',
		        ]);
		DB::table('fakultas')->insert([
		            'nama' => 'Sekolah Arsitektur',
		        ]);
		DB::table('fakultas')->insert([
		            'nama' => 'Fakultas Seni Rupa dan Desain',
		        ]);
		DB::table('fakultas')->insert([
		            'nama' => 'Sekolah Bisnis dan Manajemen',
		        ]);


    }
}

<?php

use Illuminate\Database\Seeder;

class TarifSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      // BULANAN
        DB::table('tarif')->insert([
              'id_asrama' => '4',
              'kapasitas_kamar' => '3',
              'tempo' => 'bulanan',
              'tarif_sarjana' => 300000,
              'tarif_pasca_sarjana' => NULL,
              'tarif_international' => NULL,
              'tarif_umum' => NULL,
        ]);
        DB::table('tarif')->insert([
              'id_asrama' => '5',
              'kapasitas_kamar' => '2',
              'tempo' => 'bulanan',
              'tarif_sarjana' => 450000,
              'tarif_pasca_sarjana' => NULL,
              'tarif_international' => NULL,
              'tarif_umum' => NULL,
        ]);
        DB::table('tarif')->insert([
              'id_asrama' => '6',
              'kapasitas_kamar' => '3',
              'tempo' => 'bulanan',
              'tarif_sarjana' => 300000,
              'tarif_pasca_sarjana' => NULL,
              'tarif_international' => NULL,
              'tarif_umum' => NULL,
        ]);
        DB::table('tarif')->insert([
              'id_asrama' => '6',
              'kapasitas_kamar' => '2',
              'tempo' => 'bulanan',
              'tarif_sarjana' => 450000,
              'tarif_pasca_sarjana' => 500000,
              'tarif_international' => 750000,
              'tarif_umum' => NULL,
        ]);
        DB::table('tarif')->insert([
              'id_asrama' => '3',
              'kapasitas_kamar' => '3',
              'tempo' => 'bulanan',
              'tarif_sarjana' => 300000,
              'tarif_pasca_sarjana' => NULL,
              'tarif_international' => NULL,
              'tarif_umum' => NULL,
        ]);
        DB::table('tarif')->insert([
              'id_asrama' => '1',
              'kapasitas_kamar' => '2',
              'tempo' => 'bulanan',
              'tarif_sarjana' => NULL,
              'tarif_pasca_sarjana' => NULL,
              'tarif_international' => 750000,
              'tarif_umum' => NULL,
        ]);
        DB::table('tarif')->insert([
              'id_asrama' => '2',
              'kapasitas_kamar' => '3',
              'tempo' => 'bulanan',
              'tarif_sarjana' => 30000,
              'tarif_pasca_sarjana' => NULL,
              'tarif_international' => NULL,
              'tarif_umum' => NULL,
        ]);
        DB::table('tarif')->insert([
              'id_asrama' => '2',
              'kapasitas_kamar' => '2',
              'tempo' => 'bulanan',
              'tarif_sarjana' => 450000,
              'tarif_pasca_sarjana' => 500000,
              'tarif_international' => 750000,
        ]);

        // HARIAN
        DB::table('tarif')->insert([
              'id_asrama' => '4',
              'kapasitas_kamar' => '3',
              'tempo' => 'harian',
              'tarif_sarjana' => 30000,
              'tarif_pasca_sarjana' => NULL,
              'tarif_international' => NULL,
              'tarif_umum' => 60000,
        ]);
        DB::table('tarif')->insert([
              'id_asrama' => '5',
              'kapasitas_kamar' => '2',
              'tempo' => 'harian',
              'tarif_sarjana' => 45000,
              'tarif_pasca_sarjana' => NULL,
              'tarif_international' => NULL,
              'tarif_umum' => 90000,
        ]);
        DB::table('tarif')->insert([
              'id_asrama' => '6',
              'kapasitas_kamar' => '2',
              'tempo' => 'harian',
              'tarif_sarjana' => 45000,
              'tarif_pasca_sarjana' => 50000,
              'tarif_international' => 100000,
              'tarif_umum' => 150000,
        ]);
        DB::table('tarif')->insert([
              'id_asrama' => '3',
              'kapasitas_kamar' => '3',
              'tempo' => 'harian',
              'tarif_sarjana' => 30000,
              'tarif_pasca_sarjana' => NULL,
              'tarif_international' => NULL,
              'tarif_umum' => 60000,
        ]);
        DB::table('tarif')->insert([
              'id_asrama' => '1',
              'kapasitas_kamar' => '2',
              'tempo' => 'harian',
              'tarif_sarjana' => NULL,
              'tarif_pasca_sarjana' => NULL,
              'tarif_international' => 100000,
              'tarif_umum' => 150000,
        ]);
        DB::table('tarif')->insert([
              'id_asrama' => '2',
              'kapasitas_kamar' => '3',
              'tempo' => 'harian',
              'tarif_sarjana' => 30000,
              'tarif_pasca_sarjana' => NULL,
              'tarif_international' => NULL,
              'tarif_umum' => 90000,
        ]);
        DB::table('tarif')->insert([
              'id_asrama' => '2',
              'kapasitas_kamar' => '2',
              'tempo' => 'harian',
              'tarif_sarjana' => 45000,
              'tarif_pasca_sarjana' => 50000,
              'tarif_international' => 100000,
              'tarif_umum' => 90000,
        ]);
    }
}

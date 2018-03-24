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
        DB::table('tarif')->insert([
              'jenis_penyewaan' => 'Reguler',
              'asrama' => 'Kidang Pananjung',
              'nilai_tarif_TPB_BM' => 300000,
              'nilai_tarif_TPB_NBM' => 300000,
        ]);

        DB::table('tarif')->insert([
              'jenis_penyewaan' => 'Reguler',
              'asrama' => 'Sangkuriang Lama (A dan B)',
              'nilai_tarif_TPB_BM' => 300000,
              'nilai_tarif_TPB_NBM' => 450000,
        ]);

        DB::table('tarif')->insert([
              'jenis_penyewaan' => 'Reguler',
              'asrama' => 'Sangkuriang Baru (C dan D)',
              'nilai_tarif_TPB_BM' => 300000,
              'nilai_tarif_TPB_NBM' => 450000,
              'nilai_tarif_PS' => 500000,
              'nilai_tarif_IT' => 750000,
        ]);

        DB::table('tarif')->insert([
              'jenis_penyewaan' => 'Reguler',
              'asrama' => 'Kanayakan',
              'nilai_tarif_TPB_BM' => 300000,
              'nilai_tarif_TPB_NBM' => 300000,
        ]);

        DB::table('tarif')->insert([
              'jenis_penyewaan' => 'Reguler',
              'asrama' => 'Internasional',
              'nilai_tarif_IT' => 750000,
        ]);

        DB::table('tarif')->insert([
              'jenis_penyewaan' => 'Reguler',
              'asrama' => 'Jatinangor TB 1 dan 2',
              'nilai_tarif_TPB_BM' => 300000,
              'nilai_tarif_TPB_NBM' => 450000,
              'nilai_tarif_PS' => 500000,
              'nilai_tarif_IT' => 750000,
        ]);

        DB::table('tarif')->insert([
              'jenis_penyewaan' => 'Reguler',
              'asrama' => 'Jatinangor TB 3 dan 4',
              'nilai_tarif_TPB_BM' => 300000,
              'nilai_tarif_TPB_NBM' => 450000,
              'nilai_tarif_PS' => 350000,
              'nilai_tarif_IT' => 500000,
        ]);

        // tarif Harian
        DB::table('tarif')->insert([
              'jenis_penyewaan' => 'Harian',
              'asrama' => 'Kidang Pananjung',
              'nilai_tarif_TPB_BM' => 30000,
              'nilai_tarif_TPB_NBM' => 30000,
              'nilai_tarif_PS' => 30000,
              'nilai_tarif_IT' => 100000,
              'nilai_tarif_NON' => 60000,
        ]);

        DB::table('tarif')->insert([
              'jenis_penyewaan' => 'Harian',
              'asrama' => 'Sangkuriang Lama (A dan B)',
              'nilai_tarif_TPB_BM' => 50000,
              'nilai_tarif_TPB_NBM' => 45000,
              'nilai_tarif_PS' => 45000,
              'nilai_tarif_IT' => 100000,
              'nilai_tarif_NON' => 90000,
        ]);

        DB::table('tarif')->insert([
              'jenis_penyewaan' => 'Harian',
              'asrama' => 'Sangkuriang Baru (C dan D)',
              'nilai_tarif_TPB_BM' => 50000,
              'nilai_tarif_TPB_NBM' => 50000,
              'nilai_tarif_PS' => 50000,
              'nilai_tarif_IT' => 100000,
              'nilai_tarif_NON' => 90000,
        ]);

        DB::table('tarif')->insert([
              'jenis_penyewaan' => 'Harian',
              'asrama' => 'Kanayakan',
              'nilai_tarif_TPB_BM' => 30000,
              'nilai_tarif_TPB_NBM' => 30000,
              'nilai_tarif_PS' => 30000,
              'nilai_tarif_IT' => 100000,
              'nilai_tarif_NON' => 60000,
        ]);

        DB::table('tarif')->insert([
              'jenis_penyewaan' => 'Harian',
              'asrama' => 'Internasional',
              'nilai_tarif_TPB_NBM' => 100000,
              'nilai_tarif_PS' => 100000,
              'nilai_tarif_IT' => 100000,
              'nilai_tarif_NON' => 200000,
        ]);

        DB::table('tarif')->insert([
              'jenis_penyewaan' => 'Harian',
              'asrama' => 'Jatinangor TB 1 dan 2',
              'nilai_tarif_TPB_BM' => 30000,
              'nilai_tarif_TPB_NBM' => 30000,
              'nilai_tarif_PS' => 30000,
              'nilai_tarif_IT' => 100000,
              'nilai_tarif_NON' => 60000,
        ]);

        DB::table('tarif')->insert([
              'jenis_penyewaan' => 'Harian',
              'asrama' => 'Jatinangor TB 3 dan 4',
              'nilai_tarif_TPB_BM' => 45000,
              'nilai_tarif_TPB_NBM' => 45000,
              'nilai_tarif_PS' => 45000,
              'nilai_tarif_IT' => 100000,
              'nilai_tarif_NON' => 90000,
        ]);
    }
}

<?php

use Illuminate\Database\Seeder;

class ProdiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('prodi')->insert(['nim_prodi'=>'101','nim_fakultas'=>'1','nama'=>'Matematika','strata'=>'1']);
		DB::table('prodi')->insert(['nim_prodi'=>'201','nim_fakultas'=>'1','nama'=>'Matematika','strata'=>'2']);
		DB::table('prodi')->insert(['nim_prodi'=>'301','nim_fakultas'=>'1','nama'=>'Matematika','strata'=>'3']);
		DB::table('prodi')->insert(['nim_prodi'=>'901','nim_fakultas'=>'1','nama'=>'Pengajaran Matematika','strata'=>'9']);
		DB::table('prodi')->insert(['nim_prodi'=>'102','nim_fakultas'=>'1','nama'=>'Fisika','strata'=>'1']);
		DB::table('prodi')->insert(['nim_prodi'=>'202','nim_fakultas'=>'1','nama'=>'Fisika','strata'=>'2']);
		DB::table('prodi')->insert(['nim_prodi'=>'302','nim_fakultas'=>'1','nama'=>'Fisika','strata'=>'3']);
		DB::table('prodi')->insert(['nim_prodi'=>'902','nim_fakultas'=>'1','nama'=>'Pengajaran Fisika','strata'=>'9']);
		DB::table('prodi')->insert(['nim_prodi'=>'103','nim_fakultas'=>'1','nama'=>'Astronomi','strata'=>'1']);
		DB::table('prodi')->insert(['nim_prodi'=>'203','nim_fakultas'=>'1','nama'=>'Astronomi','strata'=>'2']);
		DB::table('prodi')->insert(['nim_prodi'=>'303','nim_fakultas'=>'1','nama'=>'Astronomi','strata'=>'3']);
		DB::table('prodi')->insert(['nim_prodi'=>'105','nim_fakultas'=>'1','nama'=>'Kimia','strata'=>'1']);
		DB::table('prodi')->insert(['nim_prodi'=>'205','nim_fakultas'=>'1','nama'=>'Kimia','strata'=>'2']);
		DB::table('prodi')->insert(['nim_prodi'=>'305','nim_fakultas'=>'1','nama'=>'Kimia','strata'=>'3']);
		DB::table('prodi')->insert(['nim_prodi'=>'905','nim_fakultas'=>'1','nama'=>'Pengajaran Kimia','strata'=>'9']);
		DB::table('prodi')->insert(['nim_prodi'=>'208','nim_fakultas'=>'1','nama'=>'Aktuaria','strata'=>'2']);
		DB::table('prodi')->insert(['nim_prodi'=>'209','nim_fakultas'=>'1','nama'=>'Sains Komputasi','strata'=>'2']);
		DB::table('prodi')->insert(['nim_prodi'=>'160','nim_fakultas'=>'1','nama'=>'Tahap Tahun Pertama FMIPA','strata'=>'1']);

		DB::table('prodi')->insert(['nim_prodi'=>'104','nim_fakultas'=>'2','nama'=>'Mikrobiologi','strata'=>'1']);
		DB::table('prodi')->insert(['nim_prodi'=>'106','nim_fakultas'=>'2','nama'=>'Biologi','strata'=>'1']);
		DB::table('prodi')->insert(['nim_prodi'=>'206','nim_fakultas'=>'2','nama'=>'Biologi','strata'=>'2']);
		DB::table('prodi')->insert(['nim_prodi'=>'306','nim_fakultas'=>'2','nama'=>'Biologi','strata'=>'3']);
		DB::table('prodi')->insert(['nim_prodi'=>'211','nim_fakultas'=>'2','nama'=>'Bioteknologi','strata'=>'2']);
		DB::table('prodi')->insert(['nim_prodi'=>'112','nim_fakultas'=>'2','nama'=>'Rekayasa Hayati','strata'=>'1']);
		DB::table('prodi')->insert(['nim_prodi'=>'213','nim_fakultas'=>'2','nama'=>'Biomanajemen','strata'=>'2']);
		DB::table('prodi')->insert(['nim_prodi'=>'114','nim_fakultas'=>'2','nama'=>'Rekayasa Pertanian','strata'=>'1']);
		DB::table('prodi')->insert(['nim_prodi'=>'115','nim_fakultas'=>'2','nama'=>'Rekayasa Kehutanan','strata'=>'1']);
		DB::table('prodi')->insert(['nim_prodi'=>'119','nim_fakultas'=>'2','nama'=>'Teknologi Pasca Panen','strata'=>'1']);
		DB::table('prodi')->insert(['nim_prodi'=>'161','nim_fakultas'=>'2','nama'=>'Tahap Tahun Pertama SITH - Program Sains','strata'=>'1']);
		DB::table('prodi')->insert(['nim_prodi'=>'198','nim_fakultas'=>'2','nama'=>'Tahap Tahun Pertama SITH - Program Rekayasa','strata'=>'1']);

		DB::table('prodi')->insert(['nim_prodi'=>'107','nim_fakultas'=>'3','nama'=>'Sains dan Teknologi Farmasi','strata'=>'1']);
		DB::table('prodi')->insert(['nim_prodi'=>'207','nim_fakultas'=>'3','nama'=>'Farmasi','strata'=>'2']);
		DB::table('prodi')->insert(['nim_prodi'=>'307','nim_fakultas'=>'3','nama'=>'Farmasi','strata'=>'3']);
		DB::table('prodi')->insert(['nim_prodi'=>'907','nim_fakultas'=>'3','nama'=>'Profesi Apoteker','strata'=>'9']);
		DB::table('prodi')->insert(['nim_prodi'=>'116','nim_fakultas'=>'3','nama'=>'Farmasi Klinik dan Komunitas','strata'=>'1']);
		DB::table('prodi')->insert(['nim_prodi'=>'217','nim_fakultas'=>'3','nama'=>'Keolahragaan','strata'=>'2']);
		DB::table('prodi')->insert(['nim_prodi'=>'218','nim_fakultas'=>'3','nama'=>'Farmasi Industri','strata'=>'2']);
		DB::table('prodi')->insert(['nim_prodi'=>'162','nim_fakultas'=>'3','nama'=>'Tahap Tahun Pertama SF','strata'=>'1']);

		DB::table('prodi')->insert(['nim_prodi'=>'121','nim_fakultas'=>'4','nama'=>'Teknik Pertambangan','strata'=>'1']);
		DB::table('prodi')->insert(['nim_prodi'=>'221','nim_fakultas'=>'4','nama'=>'Rekayasa Pertambangan','strata'=>'2']);
		DB::table('prodi')->insert(['nim_prodi'=>'321','nim_fakultas'=>'4','nama'=>'Rekayasa Pertambangan','strata'=>'3']);
		DB::table('prodi')->insert(['nim_prodi'=>'122','nim_fakultas'=>'4','nama'=>'Teknik Perminyakan','strata'=>'1']);
		DB::table('prodi')->insert(['nim_prodi'=>'222','nim_fakultas'=>'4','nama'=>'Teknik Perminyakan','strata'=>'2']);
		DB::table('prodi')->insert(['nim_prodi'=>'322','nim_fakultas'=>'4','nama'=>'Teknik Perminyakan','strata'=>'3']);
		DB::table('prodi')->insert(['nim_prodi'=>'123','nim_fakultas'=>'4','nama'=>'Teknik Geofisika','strata'=>'1']);
		DB::table('prodi')->insert(['nim_prodi'=>'223','nim_fakultas'=>'4','nama'=>'Teknik Geofisika','strata'=>'2']);
		DB::table('prodi')->insert(['nim_prodi'=>'323','nim_fakultas'=>'4','nama'=>'Teknik Geofisika','strata'=>'3']);
		DB::table('prodi')->insert(['nim_prodi'=>'125','nim_fakultas'=>'4','nama'=>'Teknik Metalurgi','strata'=>'1']);
		DB::table('prodi')->insert(['nim_prodi'=>'225','nim_fakultas'=>'4','nama'=>'Teknik Metalurgi','strata'=>'2']);
		DB::table('prodi')->insert(['nim_prodi'=>'226','nim_fakultas'=>'4','nama'=>'Teknik Panas Bumi','strata'=>'2']);
		DB::table('prodi')->insert(['nim_prodi'=>'164','nim_fakultas'=>'4','nama'=>'Tahap Tahun Pertama FTTM','strata'=>'1']);

		DB::table('prodi')->insert(['nim_prodi'=>'120','nim_fakultas'=>'5','nama'=>'Teknik Geologi','strata'=>'1']);
		DB::table('prodi')->insert(['nim_prodi'=>'220','nim_fakultas'=>'5','nama'=>'Teknik Geologi','strata'=>'2']);
		DB::table('prodi')->insert(['nim_prodi'=>'320','nim_fakultas'=>'5','nama'=>'Teknik Geologi','strata'=>'3']);
		DB::table('prodi')->insert(['nim_prodi'=>'224','nim_fakultas'=>'5','nama'=>'Sains Kebumian','strata'=>'2']);
		DB::table('prodi')->insert(['nim_prodi'=>'324','nim_fakultas'=>'5','nama'=>'Sains Kebumian','strata'=>'3']);
		DB::table('prodi')->insert(['nim_prodi'=>'227','nim_fakultas'=>'5','nama'=>'Teknik Air Tanah','strata'=>'2']);
		DB::table('prodi')->insert(['nim_prodi'=>'128','nim_fakultas'=>'5','nama'=>'Meteorologi','strata'=>'1']);
		DB::table('prodi')->insert(['nim_prodi'=>'129','nim_fakultas'=>'5','nama'=>'Oseanografi','strata'=>'1']);
		DB::table('prodi')->insert(['nim_prodi'=>'151','nim_fakultas'=>'5','nama'=>'Teknik Geodesi dan Geomatika','strata'=>'1']);
		DB::table('prodi')->insert(['nim_prodi'=>'251','nim_fakultas'=>'5','nama'=>'Teknik Geodesi dan Geomatika','strata'=>'2']);
		DB::table('prodi')->insert(['nim_prodi'=>'351','nim_fakultas'=>'5','nama'=>'Teknik Geodesi dan Geomatika','strata'=>'3']);
		DB::table('prodi')->insert(['nim_prodi'=>'951','nim_fakultas'=>'5','nama'=>'Administrasi Pertanahan','strata'=>'9']);
		DB::table('prodi')->insert(['nim_prodi'=>'163','nim_fakultas'=>'5','nama'=>'Tahap Tahun Pertama FITB','strata'=>'1']);

		DB::table('prodi')->insert(['nim_prodi'=>'130','nim_fakultas'=>'6','nama'=>'Teknik Kimia','strata'=>'1']);
		DB::table('prodi')->insert(['nim_prodi'=>'230','nim_fakultas'=>'6','nama'=>'Teknik Kimia','strata'=>'2']);
		DB::table('prodi')->insert(['nim_prodi'=>'330','nim_fakultas'=>'6','nama'=>'Teknik Kimia','strata'=>'3']);
		DB::table('prodi')->insert(['nim_prodi'=>'133','nim_fakultas'=>'6','nama'=>'Teknik Fisika','strata'=>'1']);
		DB::table('prodi')->insert(['nim_prodi'=>'233','nim_fakultas'=>'6','nama'=>'Teknik Fisika','strata'=>'2']);
		DB::table('prodi')->insert(['nim_prodi'=>'333','nim_fakultas'=>'6','nama'=>'Teknik Fisika','strata'=>'3']);
		DB::table('prodi')->insert(['nim_prodi'=>'134','nim_fakultas'=>'6','nama'=>'Teknik Industri','strata'=>'1']);
		DB::table('prodi')->insert(['nim_prodi'=>'234','nim_fakultas'=>'6','nama'=>'Teknik dan Manajemen Industri','strata'=>'2']);
		DB::table('prodi')->insert(['nim_prodi'=>'334','nim_fakultas'=>'6','nama'=>'Teknik dan Manajemen Industri','strata'=>'3']);
		DB::table('prodi')->insert(['nim_prodi'=>'238','nim_fakultas'=>'6','nama'=>'Instrumentasi dan Kontrol','strata'=>'2']);
		DB::table('prodi')->insert(['nim_prodi'=>'143','nim_fakultas'=>'6','nama'=>'Teknik Pangan','strata'=>'1']);
		DB::table('prodi')->insert(['nim_prodi'=>'144','nim_fakultas'=>'6','nama'=>'Manajemen Rekayasa Industri','strata'=>'1']);
		DB::table('prodi')->insert(['nim_prodi'=>'145','nim_fakultas'=>'6','nama'=>'Teknik Bioenergi dan Kemurgi','strata'=>'1']);
		DB::table('prodi')->insert(['nim_prodi'=>'945','nim_fakultas'=>'6','nama'=>'Logistik','strata'=>'9']);
		DB::table('prodi')->insert(['nim_prodi'=>'167','nim_fakultas'=>'6','nama'=>'Tahap Tahun Pertama FTI','strata'=>'1']);

		DB::table('prodi')->insert(['nim_prodi'=>'132','nim_fakultas'=>'7','nama'=>'Teknik Elektro','strata'=>'1']);
		DB::table('prodi')->insert(['nim_prodi'=>'232','nim_fakultas'=>'7','nama'=>'Teknik Elektro','strata'=>'2']);
		DB::table('prodi')->insert(['nim_prodi'=>'332','nim_fakultas'=>'7','nama'=>'Teknik Elektro dan Informatika','strata'=>'3']);
		DB::table('prodi')->insert(['nim_prodi'=>'135','nim_fakultas'=>'7','nama'=>'Teknik Informatika','strata'=>'1']);
		DB::table('prodi')->insert(['nim_prodi'=>'235','nim_fakultas'=>'7','nama'=>'Informatika','strata'=>'2']);
		DB::table('prodi')->insert(['nim_prodi'=>'165','nim_fakultas'=>'7','nama'=>'Tahap Tahun Pertama STEI','strata'=>'1']);
		DB::table('prodi')->insert(['nim_prodi'=>'180','nim_fakultas'=>'7','nama'=>'Teknik Tenaga Listrik','strata'=>'1']);
		DB::table('prodi')->insert(['nim_prodi'=>'181','nim_fakultas'=>'7','nama'=>'Teknik Telekomunikasi','strata'=>'1']);
		DB::table('prodi')->insert(['nim_prodi'=>'182','nim_fakultas'=>'7','nama'=>'Sistem dan Teknologi Informasi','strata'=>'1']);
		DB::table('prodi')->insert(['nim_prodi'=>'183','nim_fakultas'=>'7','nama'=>'Teknik Biomedis','strata'=>'1']);

		DB::table('prodi')->insert(['nim_prodi'=>'131','nim_fakultas'=>'8','nama'=>'Teknik Mesin','strata'=>'1']);
		DB::table('prodi')->insert(['nim_prodi'=>'231','nim_fakultas'=>'8','nama'=>'Teknik Mesin','strata'=>'2']);
		DB::table('prodi')->insert(['nim_prodi'=>'331','nim_fakultas'=>'8','nama'=>'Teknik Mesin','strata'=>'3']);
		DB::table('prodi')->insert(['nim_prodi'=>'136','nim_fakultas'=>'8','nama'=>'Aeronotika dan Astronotika','strata'=>'1']);
		DB::table('prodi')->insert(['nim_prodi'=>'236','nim_fakultas'=>'8','nama'=>'Aeronotika dan Astronotika','strata'=>'2']);
		DB::table('prodi')->insert(['nim_prodi'=>'336','nim_fakultas'=>'8','nama'=>'Aeronotika dan Astronotika','strata'=>'3']);
		DB::table('prodi')->insert(['nim_prodi'=>'137','nim_fakultas'=>'8','nama'=>'Teknik Material','strata'=>'1']);
		DB::table('prodi')->insert(['nim_prodi'=>'237','nim_fakultas'=>'8','nama'=>'Ilmu dan Teknik Material','strata'=>'2']);
		DB::table('prodi')->insert(['nim_prodi'=>'337','nim_fakultas'=>'8','nama'=>'Ilmu dan Teknik Material','strata'=>'3']);
		DB::table('prodi')->insert(['nim_prodi'=>'249','nim_fakultas'=>'8','nama'=>'Ilmu dan Rekayasa Nuklir','strata'=>'2']);
		DB::table('prodi')->insert(['nim_prodi'=>'349','nim_fakultas'=>'8','nama'=>'Rekayasa Nuklir','strata'=>'3']);
		DB::table('prodi')->insert(['nim_prodi'=>'169','nim_fakultas'=>'8','nama'=>'Tahap Tahun Pertama FTMD','strata'=>'1']);

		DB::table('prodi')->insert(['nim_prodi'=>'150','nim_fakultas'=>'9','nama'=>'Teknik Sipil','strata'=>'1']);
		DB::table('prodi')->insert(['nim_prodi'=>'250','nim_fakultas'=>'9','nama'=>'Teknik Sipil','strata'=>'2']);
		DB::table('prodi')->insert(['nim_prodi'=>'350','nim_fakultas'=>'9','nama'=>'Teknik Sipil','strata'=>'3']);
		DB::table('prodi')->insert(['nim_prodi'=>'153','nim_fakultas'=>'9','nama'=>'Teknik Lingkungan','strata'=>'1']);
		DB::table('prodi')->insert(['nim_prodi'=>'253','nim_fakultas'=>'9','nama'=>'Teknik Lingkungan','strata'=>'2']);
		DB::table('prodi')->insert(['nim_prodi'=>'353','nim_fakultas'=>'9','nama'=>'Teknik Lingkungan','strata'=>'3']);
		DB::table('prodi')->insert(['nim_prodi'=>'155','nim_fakultas'=>'9','nama'=>'Teknik Kelautan','strata'=>'1']);
		DB::table('prodi')->insert(['nim_prodi'=>'255','nim_fakultas'=>'9','nama'=>'Teknik Kelautan','strata'=>'2']);
		DB::table('prodi')->insert(['nim_prodi'=>'157','nim_fakultas'=>'9','nama'=>'Rekayasa Infrastruktur Lingkungan','strata'=>'1']);
		DB::table('prodi')->insert(['nim_prodi'=>'257','nim_fakultas'=>'9','nama'=>'Pengelolaan Infrastruktur Air Bersih dan Sanitasi','strata'=>'2']);
		DB::table('prodi')->insert(['nim_prodi'=>'158','nim_fakultas'=>'9','nama'=>'Teknik dan Pengelolaan Sumber Daya Air','strata'=>'1']);
		DB::table('prodi')->insert(['nim_prodi'=>'166','nim_fakultas'=>'9','nama'=>'Tahap Tahun Pertama FTSL','strata'=>'1']);
		DB::table('prodi')->insert(['nim_prodi'=>'269','nim_fakultas'=>'9','nama'=>'Sistem dan Teknik Jalan Raya','strata'=>'2']);

		DB::table('prodi')->insert(['nim_prodi'=>'239','nim_fakultas'=>'10','nama'=>'Studi Pertahanan','strata'=>'2']);
		DB::table('prodi')->insert(['nim_prodi'=>'240','nim_fakultas'=>'10','nama'=>'Studi Pembangunan','strata'=>'2']);
		DB::table('prodi')->insert(['nim_prodi'=>'242','nim_fakultas'=>'10','nama'=>'Transportasi','strata'=>'2']);
		DB::table('prodi')->insert(['nim_prodi'=>'342','nim_fakultas'=>'10','nama'=>'Transportasi','strata'=>'3']);
		DB::table('prodi')->insert(['nim_prodi'=>'152','nim_fakultas'=>'10','nama'=>'Arsitektur','strata'=>'1']);
		DB::table('prodi')->insert(['nim_prodi'=>'252','nim_fakultas'=>'10','nama'=>'Arsitektur','strata'=>'2']);
		DB::table('prodi')->insert(['nim_prodi'=>'352','nim_fakultas'=>'10','nama'=>'Arsitektur','strata'=>'3']);
		DB::table('prodi')->insert(['nim_prodi'=>'154','nim_fakultas'=>'10','nama'=>'Perencanaan Wilayah dan Kota','strata'=>'1']);
		DB::table('prodi')->insert(['nim_prodi'=>'254','nim_fakultas'=>'10','nama'=>'Perencanaan Wilayah dan Kota','strata'=>'2']);
		DB::table('prodi')->insert(['nim_prodi'=>'354','nim_fakultas'=>'10','nama'=>'Perencanaan Wilayah dan Kota','strata'=>'3']);
		DB::table('prodi')->insert(['nim_prodi'=>'256','nim_fakultas'=>'10','nama'=>'Rancang Kota','strata'=>'2']);
		DB::table('prodi')->insert(['nim_prodi'=>'957','nim_fakultas'=>'10','nama'=>'Terapan Perencanaan Kepariwisataan','strata'=>'9']);
		DB::table('prodi')->insert(['nim_prodi'=>'289','nim_fakultas'=>'10','nama'=>'Arsitektur Lanskap','strata'=>'2']);
		DB::table('prodi')->insert(['nim_prodi'=>'199','nim_fakultas'=>'10','nama'=>'Tahap Tahun Pertama SAPPK','strata'=>'1']);

		DB::table('prodi')->insert(['nim_prodi'=>'168','nim_fakultas'=>'11','nama'=>'Tahap Tahun Pertama FSRD','strata'=>'1']);
		DB::table('prodi')->insert(['nim_prodi'=>'170','nim_fakultas'=>'11','nama'=>'Seni Rupa','strata'=>'1']);
		DB::table('prodi')->insert(['nim_prodi'=>'270','nim_fakultas'=>'11','nama'=>'Seni Rupa','strata'=>'2']);
		DB::table('prodi')->insert(['nim_prodi'=>'370','nim_fakultas'=>'11','nama'=>'Ilmu Seni Rupa dan Desain','strata'=>'3']);
		DB::table('prodi')->insert(['nim_prodi'=>'271','nim_fakultas'=>'11','nama'=>'Desain','strata'=>'2']);
		DB::table('prodi')->insert(['nim_prodi'=>'172','nim_fakultas'=>'11','nama'=>'Kriya','strata'=>'1']);
		DB::table('prodi')->insert(['nim_prodi'=>'173','nim_fakultas'=>'11','nama'=>'Desain Interior','strata'=>'1']);
		DB::table('prodi')->insert(['nim_prodi'=>'174','nim_fakultas'=>'11','nama'=>'Desain Komunikasi Visual','strata'=>'1']);
		DB::table('prodi')->insert(['nim_prodi'=>'175','nim_fakultas'=>'11','nama'=>'Desain Produk','strata'=>'1']);
		DB::table('prodi')->insert(['nim_prodi'=>'179','nim_fakultas'=>'11','nama'=>'MKDU','strata'=>'1']);

		DB::table('prodi')->insert(['nim_prodi'=>'190','nim_fakultas'=>'12','nama'=>'Manajemen','strata'=>'1']);
		DB::table('prodi')->insert(['nim_prodi'=>'290','nim_fakultas'=>'12','nama'=>'Sains Manajemen','strata'=>'2']);
		DB::table('prodi')->insert(['nim_prodi'=>'390','nim_fakultas'=>'12','nama'=>'Sains Manajemen','strata'=>'3']);
		DB::table('prodi')->insert(['nim_prodi'=>'291','nim_fakultas'=>'12','nama'=>'Administrasi Bisnis','strata'=>'2']);
		DB::table('prodi')->insert(['nim_prodi'=>'192','nim_fakultas'=>'12','nama'=>'Kewirausahaan','strata'=>'1']);
		DB::table('prodi')->insert(['nim_prodi'=>'293','nim_fakultas'=>'12','nama'=>'Administrasi Bisnis','strata'=>'2']);
		DB::table('prodi')->insert(['nim_prodi'=>'197','nim_fakultas'=>'12','nama'=>'Tahap Tahun Pertama SBM','strata'=>'1']);

    }
}

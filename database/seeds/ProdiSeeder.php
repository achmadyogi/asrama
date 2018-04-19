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
    	//FMIPA (1)
        DB::table('prodi')->insert(['id_prodi'=>'101','id_fakultas'=>'1','nama_prodi'=>'Matematika','strata'=>'1']);
		DB::table('prodi')->insert(['id_prodi'=>'201','id_fakultas'=>'1','nama_prodi'=>'Matematika','strata'=>'2']);
		DB::table('prodi')->insert(['id_prodi'=>'301','id_fakultas'=>'1','nama_prodi'=>'Matematika','strata'=>'3']);
		DB::table('prodi')->insert(['id_prodi'=>'901','id_fakultas'=>'1','nama_prodi'=>'Pengajaran Matematika','strata'=>'9']);
		DB::table('prodi')->insert(['id_prodi'=>'102','id_fakultas'=>'1','nama_prodi'=>'Fisika','strata'=>'1']);
		DB::table('prodi')->insert(['id_prodi'=>'202','id_fakultas'=>'1','nama_prodi'=>'Fisika','strata'=>'2']);
		DB::table('prodi')->insert(['id_prodi'=>'302','id_fakultas'=>'1','nama_prodi'=>'Fisika','strata'=>'3']);
		DB::table('prodi')->insert(['id_prodi'=>'902','id_fakultas'=>'1','nama_prodi'=>'Pengajaran Fisika','strata'=>'9']);
		DB::table('prodi')->insert(['id_prodi'=>'103','id_fakultas'=>'1','nama_prodi'=>'Astronomi','strata'=>'1']);
		DB::table('prodi')->insert(['id_prodi'=>'203','id_fakultas'=>'1','nama_prodi'=>'Astronomi','strata'=>'2']);
		DB::table('prodi')->insert(['id_prodi'=>'105','id_fakultas'=>'1','nama_prodi'=>'Kimia','strata'=>'1']);
		DB::table('prodi')->insert(['id_prodi'=>'205','id_fakultas'=>'1','nama_prodi'=>'Kimia','strata'=>'2']);
		DB::table('prodi')->insert(['id_prodi'=>'905','id_fakultas'=>'1','nama_prodi'=>'Pengajaran Kimia','strata'=>'9']);
		DB::table('prodi')->insert(['id_prodi'=>'208','id_fakultas'=>'1','nama_prodi'=>'Aktuaria','strata'=>'2']);
		DB::table('prodi')->insert(['id_prodi'=>'209','id_fakultas'=>'1','nama_prodi'=>'Sains Komputasi','strata'=>'2']);
		DB::table('prodi')->insert(['id_prodi'=>'160','id_fakultas'=>'1','nama_prodi'=>'Tahap Tahun Pertama FMIPA','strata'=>'1']);

		//SITHS (2)
		DB::table('prodi')->insert(['id_prodi'=>'104','id_fakultas'=>'2','nama_prodi'=>'Mikrobiologi','strata'=>'1']);
		DB::table('prodi')->insert(['id_prodi'=>'106','id_fakultas'=>'2','nama_prodi'=>'Biologi','strata'=>'1']);
		DB::table('prodi')->insert(['id_prodi'=>'206','id_fakultas'=>'2','nama_prodi'=>'Biologi','strata'=>'2']);
		DB::table('prodi')->insert(['id_prodi'=>'306','id_fakultas'=>'2','nama_prodi'=>'Biologi','strata'=>'3']);
		DB::table('prodi')->insert(['id_prodi'=>'161','id_fakultas'=>'2','nama_prodi'=>'Tahap Tahun Pertama SITH - Program Sains','strata'=>'1']);

		//SITHR (3)
		DB::table('prodi')->insert(['id_prodi'=>'211','id_fakultas'=>'3','nama_prodi'=>'Bioteknologi','strata'=>'2']);
		DB::table('prodi')->insert(['id_prodi'=>'112','id_fakultas'=>'3','nama_prodi'=>'Rekayasa Hayati','strata'=>'1']);
		DB::table('prodi')->insert(['id_prodi'=>'114','id_fakultas'=>'3','nama_prodi'=>'Rekayasa Pertanian','strata'=>'1']);
		DB::table('prodi')->insert(['id_prodi'=>'115','id_fakultas'=>'3','nama_prodi'=>'Rekayasa Kehutanan','strata'=>'1']);
		DB::table('prodi')->insert(['id_prodi'=>'119','id_fakultas'=>'3','nama_prodi'=>'Teknologi Pasca Panen','strata'=>'1']);
		DB::table('prodi')->insert(['id_prodi'=>'198','id_fakultas'=>'3','nama_prodi'=>'Tahap Tahun Pertama SITH - Program Rekayasa','strata'=>'1']);
		DB::table('prodi')->insert(['id_prodi'=>'213','id_fakultas'=>'3','nama_prodi'=>'Biomanajemen','strata'=>'2']);

		//SF (4)
		DB::table('prodi')->insert(['id_prodi'=>'107','id_fakultas'=>'4','nama_prodi'=>'Sains dan Teknologi Farmasi','strata'=>'1']);
		DB::table('prodi')->insert(['id_prodi'=>'207','id_fakultas'=>'4','nama_prodi'=>'Farmasi','strata'=>'2']);
		DB::table('prodi')->insert(['id_prodi'=>'307','id_fakultas'=>'4','nama_prodi'=>'Farmasi','strata'=>'3']);
		DB::table('prodi')->insert(['id_prodi'=>'907','id_fakultas'=>'4','nama_prodi'=>'Profesi Apoteker','strata'=>'9']);
		DB::table('prodi')->insert(['id_prodi'=>'116','id_fakultas'=>'4','nama_prodi'=>'Farmasi Klinik dan Komunitas','strata'=>'1']);
		DB::table('prodi')->insert(['id_prodi'=>'217','id_fakultas'=>'4','nama_prodi'=>'Keolahragaan','strata'=>'2']);
		DB::table('prodi')->insert(['id_prodi'=>'218','id_fakultas'=>'4','nama_prodi'=>'Farmasi Industri','strata'=>'2']);
		DB::table('prodi')->insert(['id_prodi'=>'162','id_fakultas'=>'4','nama_prodi'=>'Tahap Tahun Pertama SF','strata'=>'1']);

		//FTTM (5)
		DB::table('prodi')->insert(['id_prodi'=>'121','id_fakultas'=>'5','nama_prodi'=>'Teknik Pertambangan','strata'=>'1']);
		DB::table('prodi')->insert(['id_prodi'=>'221','id_fakultas'=>'5','nama_prodi'=>'Rekayasa Pertambangan','strata'=>'2']);
		DB::table('prodi')->insert(['id_prodi'=>'321','id_fakultas'=>'5','nama_prodi'=>'Rekayasa Pertambangan','strata'=>'3']);
		DB::table('prodi')->insert(['id_prodi'=>'122','id_fakultas'=>'5','nama_prodi'=>'Teknik Perminyakan','strata'=>'1']);
		DB::table('prodi')->insert(['id_prodi'=>'222','id_fakultas'=>'5','nama_prodi'=>'Teknik Perminyakan','strata'=>'2']);
		DB::table('prodi')->insert(['id_prodi'=>'322','id_fakultas'=>'5','nama_prodi'=>'Teknik Perminyakan','strata'=>'3']);
		DB::table('prodi')->insert(['id_prodi'=>'123','id_fakultas'=>'5','nama_prodi'=>'Teknik Geofisika','strata'=>'1']);
		DB::table('prodi')->insert(['id_prodi'=>'223','id_fakultas'=>'5','nama_prodi'=>'Teknik Geofisika','strata'=>'2']);
		DB::table('prodi')->insert(['id_prodi'=>'323','id_fakultas'=>'5','nama_prodi'=>'Teknik Geofisika','strata'=>'3']);
		DB::table('prodi')->insert(['id_prodi'=>'125','id_fakultas'=>'5','nama_prodi'=>'Teknik Metalurgi','strata'=>'1']);
		DB::table('prodi')->insert(['id_prodi'=>'225','id_fakultas'=>'5','nama_prodi'=>'Teknik Metalurgi','strata'=>'2']);
		DB::table('prodi')->insert(['id_prodi'=>'226','id_fakultas'=>'5','nama_prodi'=>'Teknik Panas Bumi','strata'=>'2']);
		DB::table('prodi')->insert(['id_prodi'=>'164','id_fakultas'=>'5','nama_prodi'=>'Tahap Tahun Pertama FTTM','strata'=>'1']);

		//FITB (6)
		DB::table('prodi')->insert(['id_prodi'=>'120','id_fakultas'=>'6','nama_prodi'=>'Teknik Geologi','strata'=>'1']);
		DB::table('prodi')->insert(['id_prodi'=>'220','id_fakultas'=>'6','nama_prodi'=>'Teknik Geologi','strata'=>'2']);
		DB::table('prodi')->insert(['id_prodi'=>'320','id_fakultas'=>'6','nama_prodi'=>'Teknik Geologi','strata'=>'3']);
		DB::table('prodi')->insert(['id_prodi'=>'224','id_fakultas'=>'6','nama_prodi'=>'Sains Kebumian','strata'=>'2']);
		DB::table('prodi')->insert(['id_prodi'=>'324','id_fakultas'=>'6','nama_prodi'=>'Sains Kebumian','strata'=>'3']);
		DB::table('prodi')->insert(['id_prodi'=>'227','id_fakultas'=>'6','nama_prodi'=>'Teknik Air Tanah','strata'=>'2']);
		DB::table('prodi')->insert(['id_prodi'=>'128','id_fakultas'=>'6','nama_prodi'=>'Meteorologi','strata'=>'1']);
		DB::table('prodi')->insert(['id_prodi'=>'129','id_fakultas'=>'6','nama_prodi'=>'Oseanografi','strata'=>'1']);
		DB::table('prodi')->insert(['id_prodi'=>'151','id_fakultas'=>'6','nama_prodi'=>'Teknik Geodesi dan Geomatika','strata'=>'1']);
		DB::table('prodi')->insert(['id_prodi'=>'251','id_fakultas'=>'6','nama_prodi'=>'Teknik Geodesi dan Geomatika','strata'=>'2']);
		DB::table('prodi')->insert(['id_prodi'=>'351','id_fakultas'=>'6','nama_prodi'=>'Teknik Geodesi dan Geomatika','strata'=>'3']);
		DB::table('prodi')->insert(['id_prodi'=>'163','id_fakultas'=>'6','nama_prodi'=>'Tahap Tahun Pertama FITB','strata'=>'1']);

		//FTI (7)
		DB::table('prodi')->insert(['id_prodi'=>'130','id_fakultas'=>'7','nama_prodi'=>'Teknik Kimia','strata'=>'1']);
		DB::table('prodi')->insert(['id_prodi'=>'230','id_fakultas'=>'7','nama_prodi'=>'Teknik Kimia','strata'=>'2']);
		DB::table('prodi')->insert(['id_prodi'=>'330','id_fakultas'=>'7','nama_prodi'=>'Teknik Kimia','strata'=>'3']);
		DB::table('prodi')->insert(['id_prodi'=>'133','id_fakultas'=>'7','nama_prodi'=>'Teknik Fisika','strata'=>'1']);
		DB::table('prodi')->insert(['id_prodi'=>'233','id_fakultas'=>'7','nama_prodi'=>'Teknik Fisika','strata'=>'2']);
		DB::table('prodi')->insert(['id_prodi'=>'333','id_fakultas'=>'7','nama_prodi'=>'Teknik Fisika','strata'=>'3']);
		DB::table('prodi')->insert(['id_prodi'=>'134','id_fakultas'=>'7','nama_prodi'=>'Teknik Industri','strata'=>'1']);
		DB::table('prodi')->insert(['id_prodi'=>'234','id_fakultas'=>'7','nama_prodi'=>'Teknik dan Manajemen Industri','strata'=>'2']);
		DB::table('prodi')->insert(['id_prodi'=>'334','id_fakultas'=>'7','nama_prodi'=>'Teknik dan Manajemen Industri','strata'=>'3']);
		DB::table('prodi')->insert(['id_prodi'=>'238','id_fakultas'=>'7','nama_prodi'=>'Instrumentasi dan Kontrol','strata'=>'2']);
		DB::table('prodi')->insert(['id_prodi'=>'143','id_fakultas'=>'7','nama_prodi'=>'Teknik Pangan','strata'=>'1']);
		DB::table('prodi')->insert(['id_prodi'=>'144','id_fakultas'=>'7','nama_prodi'=>'Manajemen Rekayasa Industri','strata'=>'1']);
		DB::table('prodi')->insert(['id_prodi'=>'145','id_fakultas'=>'7','nama_prodi'=>'Teknik Bioenergi dan Kemurgi','strata'=>'1']);
		DB::table('prodi')->insert(['id_prodi'=>'945','id_fakultas'=>'7','nama_prodi'=>'Logistik','strata'=>'9']);
		DB::table('prodi')->insert(['id_prodi'=>'167','id_fakultas'=>'7','nama_prodi'=>'Tahap Tahun Pertama FTI','strata'=>'1']);

		//STEI (8)
		DB::table('prodi')->insert(['id_prodi'=>'132','id_fakultas'=>'8','nama_prodi'=>'Teknik Elektro','strata'=>'1']);
		DB::table('prodi')->insert(['id_prodi'=>'232','id_fakultas'=>'8','nama_prodi'=>'Teknik Elektro','strata'=>'2']);
		DB::table('prodi')->insert(['id_prodi'=>'332','id_fakultas'=>'8','nama_prodi'=>'Teknik Elektro dan Informatika','strata'=>'3']);
		DB::table('prodi')->insert(['id_prodi'=>'135','id_fakultas'=>'8','nama_prodi'=>'Teknik Informatika','strata'=>'1']);
		DB::table('prodi')->insert(['id_prodi'=>'235','id_fakultas'=>'8','nama_prodi'=>'Informatika','strata'=>'2']);
		DB::table('prodi')->insert(['id_prodi'=>'165','id_fakultas'=>'8','nama_prodi'=>'Tahap Tahun Pertama STEI','strata'=>'1']);
		DB::table('prodi')->insert(['id_prodi'=>'180','id_fakultas'=>'8','nama_prodi'=>'Teknik Tenaga Listrik','strata'=>'1']);
		DB::table('prodi')->insert(['id_prodi'=>'181','id_fakultas'=>'8','nama_prodi'=>'Teknik Telekomunikasi','strata'=>'1']);
		DB::table('prodi')->insert(['id_prodi'=>'182','id_fakultas'=>'8','nama_prodi'=>'Sistem dan Teknologi Informasi','strata'=>'1']);
		DB::table('prodi')->insert(['id_prodi'=>'183','id_fakultas'=>'8','nama_prodi'=>'Teknik Biomedis','strata'=>'1']);

		//FTMD (9)
		DB::table('prodi')->insert(['id_prodi'=>'131','id_fakultas'=>'9','nama_prodi'=>'Teknik Mesin','strata'=>'1']);
		DB::table('prodi')->insert(['id_prodi'=>'231','id_fakultas'=>'9','nama_prodi'=>'Teknik Mesin','strata'=>'2']);
		DB::table('prodi')->insert(['id_prodi'=>'331','id_fakultas'=>'9','nama_prodi'=>'Teknik Mesin','strata'=>'3']);
		DB::table('prodi')->insert(['id_prodi'=>'136','id_fakultas'=>'9','nama_prodi'=>'Aeronotika dan Astronotika','strata'=>'1']);
		DB::table('prodi')->insert(['id_prodi'=>'236','id_fakultas'=>'9','nama_prodi'=>'Aeronotika dan Astronotika','strata'=>'2']);
		DB::table('prodi')->insert(['id_prodi'=>'336','id_fakultas'=>'9','nama_prodi'=>'Aeronotika dan Astronotika','strata'=>'3']);
		DB::table('prodi')->insert(['id_prodi'=>'137','id_fakultas'=>'9','nama_prodi'=>'Teknik Material','strata'=>'1']);
		DB::table('prodi')->insert(['id_prodi'=>'237','id_fakultas'=>'9','nama_prodi'=>'Ilmu dan Teknik Material','strata'=>'2']);
		DB::table('prodi')->insert(['id_prodi'=>'337','id_fakultas'=>'9','nama_prodi'=>'Ilmu dan Teknik Material','strata'=>'3']);
		DB::table('prodi')->insert(['id_prodi'=>'249','id_fakultas'=>'9','nama_prodi'=>'Ilmu dan Rekayasa Nuklir','strata'=>'2']);
		DB::table('prodi')->insert(['id_prodi'=>'349','id_fakultas'=>'9','nama_prodi'=>'Rekayasa Nuklir','strata'=>'3']);
		DB::table('prodi')->insert(['id_prodi'=>'169','id_fakultas'=>'9','nama_prodi'=>'Tahap Tahun Pertama FTMD','strata'=>'1']);

		//FTSL (10)
		DB::table('prodi')->insert(['id_prodi'=>'150','id_fakultas'=>'10','nama_prodi'=>'Teknik Sipil','strata'=>'1']);
		DB::table('prodi')->insert(['id_prodi'=>'250','id_fakultas'=>'10','nama_prodi'=>'Teknik Sipil','strata'=>'2']);
		DB::table('prodi')->insert(['id_prodi'=>'350','id_fakultas'=>'10','nama_prodi'=>'Teknik Sipil','strata'=>'3']);
		DB::table('prodi')->insert(['id_prodi'=>'153','id_fakultas'=>'10','nama_prodi'=>'Teknik Lingkungan','strata'=>'1']);
		DB::table('prodi')->insert(['id_prodi'=>'253','id_fakultas'=>'10','nama_prodi'=>'Teknik Lingkungan','strata'=>'2']);
		DB::table('prodi')->insert(['id_prodi'=>'353','id_fakultas'=>'10','nama_prodi'=>'Teknik Lingkungan','strata'=>'3']);
		DB::table('prodi')->insert(['id_prodi'=>'155','id_fakultas'=>'10','nama_prodi'=>'Teknik Kelautan','strata'=>'1']);
		DB::table('prodi')->insert(['id_prodi'=>'255','id_fakultas'=>'10','nama_prodi'=>'Teknik Kelautan','strata'=>'2']);
		DB::table('prodi')->insert(['id_prodi'=>'157','id_fakultas'=>'10','nama_prodi'=>'Rekayasa Infrastruktur Lingkungan','strata'=>'1']);
		DB::table('prodi')->insert(['id_prodi'=>'257','id_fakultas'=>'10','nama_prodi'=>'Pengelolaan Infrastruktur Air Bersih dan Sanitasi','strata'=>'2']);
		DB::table('prodi')->insert(['id_prodi'=>'158','id_fakultas'=>'10','nama_prodi'=>'Teknik dan Pengelolaan Sumber Daya Air','strata'=>'1']);
		DB::table('prodi')->insert(['id_prodi'=>'166','id_fakultas'=>'10','nama_prodi'=>'Tahap Tahun Pertama FTSL','strata'=>'1']);
		DB::table('prodi')->insert(['id_prodi'=>'269','id_fakultas'=>'10','nama_prodi'=>'Sistem dan Teknik Jalan Raya','strata'=>'2']);
		DB::table('prodi')->insert(['id_prodi'=>'950','id_fakultas'=>'10','nama_prodi'=>'Pengelolaan Sumber Daya Air (PSDA)','strata'=>'9']);

		//SAPPK (11)
		DB::table('prodi')->insert(['id_prodi'=>'240','id_fakultas'=>'11','nama_prodi'=>'Studi Pembangunan','strata'=>'2']);
		DB::table('prodi')->insert(['id_prodi'=>'242','id_fakultas'=>'11','nama_prodi'=>'Transportasi','strata'=>'2']);
		DB::table('prodi')->insert(['id_prodi'=>'342','id_fakultas'=>'11','nama_prodi'=>'Transportasi','strata'=>'3']);
		DB::table('prodi')->insert(['id_prodi'=>'152','id_fakultas'=>'11','nama_prodi'=>'Arsitektur','strata'=>'1']);
		DB::table('prodi')->insert(['id_prodi'=>'252','id_fakultas'=>'11','nama_prodi'=>'Arsitektur','strata'=>'2']);
		DB::table('prodi')->insert(['id_prodi'=>'352','id_fakultas'=>'11','nama_prodi'=>'Arsitektur','strata'=>'3']);
		DB::table('prodi')->insert(['id_prodi'=>'154','id_fakultas'=>'11','nama_prodi'=>'Perencanaan Wilayah dan Kota','strata'=>'1']);
		DB::table('prodi')->insert(['id_prodi'=>'254','id_fakultas'=>'11','nama_prodi'=>'Perencanaan Wilayah dan Kota','strata'=>'2']);
		DB::table('prodi')->insert(['id_prodi'=>'354','id_fakultas'=>'11','nama_prodi'=>'Perencanaan Wilayah dan Kota','strata'=>'3']);
		DB::table('prodi')->insert(['id_prodi'=>'256','id_fakultas'=>'11','nama_prodi'=>'Rancang Kota','strata'=>'2']);
		DB::table('prodi')->insert(['id_prodi'=>'957','id_fakultas'=>'11','nama_prodi'=>'Terapan Perencanaan Kepariwisataan','strata'=>'9']);
		DB::table('prodi')->insert(['id_prodi'=>'289','id_fakultas'=>'11','nama_prodi'=>'Arsitektur Lanskap','strata'=>'2']);
		DB::table('prodi')->insert(['id_prodi'=>'199','id_fakultas'=>'11','nama_prodi'=>'Tahap Tahun Pertama SAPPK','strata'=>'1']);

		//FSRD (12)
		DB::table('prodi')->insert(['id_prodi'=>'168','id_fakultas'=>'12','nama_prodi'=>'Tahap Tahun Pertama FSRD','strata'=>'1']);
		DB::table('prodi')->insert(['id_prodi'=>'170','id_fakultas'=>'12','nama_prodi'=>'Seni Rupa','strata'=>'1']);
		DB::table('prodi')->insert(['id_prodi'=>'270','id_fakultas'=>'12','nama_prodi'=>'Seni Rupa','strata'=>'2']);
		DB::table('prodi')->insert(['id_prodi'=>'370','id_fakultas'=>'12','nama_prodi'=>'Ilmu Seni Rupa dan Desain','strata'=>'3']);
		DB::table('prodi')->insert(['id_prodi'=>'271','id_fakultas'=>'12','nama_prodi'=>'Desain','strata'=>'2']);
		DB::table('prodi')->insert(['id_prodi'=>'172','id_fakultas'=>'12','nama_prodi'=>'Kriya','strata'=>'1']);
		DB::table('prodi')->insert(['id_prodi'=>'173','id_fakultas'=>'12','nama_prodi'=>'Desain Interior','strata'=>'1']);
		DB::table('prodi')->insert(['id_prodi'=>'174','id_fakultas'=>'12','nama_prodi'=>'Desain Komunikasi Visual','strata'=>'1']);
		DB::table('prodi')->insert(['id_prodi'=>'175','id_fakultas'=>'12','nama_prodi'=>'Desain Produk','strata'=>'1']);
		DB::table('prodi')->insert(['id_prodi'=>'179','id_fakultas'=>'12','nama_prodi'=>'MKDU','strata'=>'1']);

		//SBM (13)
		DB::table('prodi')->insert(['id_prodi'=>'190','id_fakultas'=>'12','nama_prodi'=>'Manajemen','strata'=>'1']);
		DB::table('prodi')->insert(['id_prodi'=>'290','id_fakultas'=>'12','nama_prodi'=>'Sains Manajemen','strata'=>'2']);
		DB::table('prodi')->insert(['id_prodi'=>'390','id_fakultas'=>'12','nama_prodi'=>'Sains Manajemen','strata'=>'3']);
		DB::table('prodi')->insert(['id_prodi'=>'291','id_fakultas'=>'12','nama_prodi'=>'Administrasi Bisnis','strata'=>'2']);
		DB::table('prodi')->insert(['id_prodi'=>'192','id_fakultas'=>'12','nama_prodi'=>'Kewirausahaan','strata'=>'1']);
		DB::table('prodi')->insert(['id_prodi'=>'293','id_fakultas'=>'12','nama_prodi'=>'Administrasi Bisnis','strata'=>'2']);
		DB::table('prodi')->insert(['id_prodi'=>'197','id_fakultas'=>'12','nama_prodi'=>'Tahap Tahun Pertama SBM','strata'=>'1']);

    }
}

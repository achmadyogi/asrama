<?php

use Illuminate\Database\Seeder;

class FileDownloadSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('file_download')->insert([
            'id_file'=>'1',
            'nama_file'=>'Surat Perjanjian Asrama Umum',
            'deskripsi'=>'Surat Perjanjian Masuk Asrama',
            'url_file'=>'/Files/SuratPerjanjianAsramaUmum.docx',
            ] );

        DB::table('file_download')->insert([
            'id_file'=>'2',
            'nama_file'=>'Formulir Keluar Asrama',
            'deskripsi'=>'Form Keluar Asrama',
            'url_file'=>'/Files/FormKeluarAsrama_formatumum.docx',
            ] );

        DB::table('file_download')->insert([
            'id_file'=>'3',
            'nama_file'=>'Form Pengajuan Penangguhan Pembayaran Asrama',
            'deskripsi'=>'Form Pengajuan Penangguhan Pembayaran Asrama',
            'url_file'=>'/Files/FormPengajuanPenangguhanPembayaranAsrama.docx',
            ] );
    
    }
}

<?php

use Illuminate\Database\Seeder;

class GedungSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
          DB::table('Gedung')->insert([
          'id_gedung'=>'1',
          'id_asrama'=>'1',
          'nama'=>'Gedung Internasional',
          'gender'=>'L',
          ] );
          
          DB::table('Gedung')->insert([
          'id_gedung'=>'2',
          'id_asrama'=>'2',
          'nama'=>'TB1',
          'gender'=>'L',
          ] );

          DB::table('Gedung')->insert([
          'id_gedung'=>'3',
          'id_asrama'=>'2',
          'nama'=>'TB2',
          'gender'=>'P',
          ] );

          DB::table('Gedung')->insert([
          'id_gedung'=>'4',
          'id_asrama'=>'2',
          'nama'=>'TB3',
          'gender'=>'P',
          ] );

          DB::table('Gedung')->insert([
          'id_gedung'=>'5',
          'id_asrama'=>'2',
          'nama'=>'TB4',
          'gender'=>'L',
          ] );

          DB::table('Gedung')->insert([
          'id_gedung'=>'6',
          'id_asrama'=>'3',
          'nama'=>'Gedung Lama',
          'gender'=>'P',
          ] );

          DB::table('Gedung')->insert([
          'id_gedung'=>'7',
          'id_asrama'=>'3',
          'nama'=>'Gedung Baru',
          'gender'=>'P',
          ] );

          DB::table('Gedung')->insert([
          'id_gedung'=>'8',
          'id_asrama'=>'4',
          'nama'=>'Gedung A',
          'gender'=>'P',

          ] );

          DB::table('Gedung')->insert([
          'id_gedung'=>'9',
          'id_asrama'=>'4',
          'nama'=>'Gedung B',
          'gender'=>'L',
          ] );
          DB::table('Gedung')->insert([
          'id_gedung'=>'10',
          'id_asrama'=>'4',
          'nama'=>'Gedung C',
          'gender'=>'L',
          ] );

          DB::table('Gedung')->insert([
          'id_gedung'=>'11',
          'id_asrama'=>'4',
          'nama'=>'Gedung D',
          'gender'=>'L',
          ] );

          DB::table('Gedung')->insert([
          'id_gedung'=>'12',
          'id_asrama'=>'4',
          'nama'=>'Gedung E',
          'gender'=>'L',
          ] );

          DB::table('Gedung')->insert([
          'id_gedung'=>'13',
          'id_asrama'=>'4',
          'nama'=>'Gedung F',
          'gender'=>'L',
          ] );

          DB::table('Gedung')->insert([
          'id_gedung'=>'14',

          'id_asrama'=>'5',
          'nama'=>'Sangkuriang Gedung A',
          'gender'=>'P',

          ] );

          DB::table('Gedung')->insert([
          'id_gedung'=>'15',
          'id_asrama'=>'5',
          'nama'=>'Sangkuriang Gedung B',
          'gender'=>'L',
          ] );

          DB::table('Gedung')->insert([
          'id_gedung'=>'16',
          'id_asrama'=>'6',
          'nama'=>'Sangkuriang Gedung C',
          'gender'=>'P',

          ] );

          DB::table('Gedung')->insert([
          'id_gedung'=>'17',
          'id_asrama'=>'6',
          'nama'=>'Sangkuriang Gedung D',
          'gender'=>'L',
          ] );
    }
}

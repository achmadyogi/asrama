<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(FakultasSeeder::class);
        $this->call(ProdiSeeder::class);
        $this->call(AsramaSeeder::class);
        $this->call(GedungSeeder::class);
        $this->call(KamarSeeder::class);
        $this->call(TarifSeeder::class);    
    }
}

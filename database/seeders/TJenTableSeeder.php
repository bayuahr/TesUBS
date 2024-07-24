<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TJenTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('t_jen')->insert([
            ['kode_tjen' => '1', 'nama_tjen' => 'Tunai'],
            ['kode_tjen' => '2', 'nama_tjen' => 'Kredit'],
        ]);
    }
}

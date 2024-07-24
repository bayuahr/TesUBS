<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TCustomerTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('t_customer')->insert([
            ['kode_customer' => 'C001', 'nama_customer' => 'Bayu'],
            ['kode_customer' => 'C002', 'nama_customer' => 'Aji'],
            ['kode_customer' => 'C003', 'nama_customer' => 'Hamengku'],
            ['kode_customer' => 'C004', 'nama_customer' => 'Rahmad'],
            ['kode_customer' => 'C005', 'nama_customer' => 'PT Untung Bersama Sejahtera'],
            
        ]);
    }
}

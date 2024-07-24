<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TBarangTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('t_barang')->insert([
            ['kode_barang' => 'B001', 'nama_barang' => 'EMAS 24 Karat 0.5 Gr', 'harga_barang' => 429000.00],
            ['kode_barang' => 'B002', 'nama_barang' => 'EMAS 24 Karat 1 Gr', 'harga_barang' => 809000.00],
            ['kode_barang' => 'B003', 'nama_barang' => 'EMAS 24 Karat 2 Gr', 'harga_barang' => 1567000.00],
            ['kode_barang' => 'B004', 'nama_barang' => 'EMAS 24 Karat 3 Gr', 'harga_barang' => 2329000.00],
            ['kode_barang' => 'B005', 'nama_barang' => 'EMAS 24 Karat 5 Gr', 'harga_barang' => 3865000.00],
        ]);
    }
}

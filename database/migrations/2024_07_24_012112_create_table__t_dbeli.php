<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableTDbeli extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('T_Dbeli', function (Blueprint $table) {
            $table->char('no_faktur', 6);
            $table->char('kode_barang', 10);
            $table->decimal('harga', 15, 2);
            $table->decimal('qty', 15, 2);
            $table->decimal('diskon', 15, 2);
            $table->decimal('bruto', 15, 2);
            $table->decimal('jumlah', 15, 2);

            $table->foreign('no_faktur')->references('no_faktur')->on('t_beli');
            $table->foreign('kode_barang')->references('kode_barang')->on('t_barang');

            $table->primary(['no_faktur', 'kode_barang']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('T_Dbeli');
    }
}

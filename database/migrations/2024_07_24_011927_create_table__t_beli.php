<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableTBeli extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('T_Beli', function (Blueprint $table) {
            $table->char('no_faktur', 6);
            $table->char('kode_customer', 4);
            $table->char('kode_tjen', 1);
            $table->date('tgl_faktur');
            $table->decimal('total_bruto', 15, 2);
            $table->decimal('total_diskon', 15, 2);
            $table->decimal('total_jumlah', 15, 2);
            
            $table->foreign('kode_customer')->references('kode_customer')->on('t_customer');
            $table->foreign('kode_tjen')->references('kode_tjen')->on('t_jen');
            
            $table->primary('no_faktur');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('T_Beli');
    }
}

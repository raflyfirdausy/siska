<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSkKadesTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sk_kades', function (Blueprint $table) {
            $table->increments('id')->autoIncrement();
            $table->string('nomer', 200);
            $table->text('tentang');
            $table->text('uraian');
            $table->text('diundangkan');
            $table->text('keterangan');
            $table->timestamps();
            $table->engine = 'InnoDB';
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sk_kades');
    }
}

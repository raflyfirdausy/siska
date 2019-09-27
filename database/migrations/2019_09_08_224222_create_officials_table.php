<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOfficialsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('officials', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 100);
            $table->string('nip', 30);
            $table->enum('position', [
                'kepala_desa',
                'sekretaris_desa',
                'kaur_pemerintahan',
                'kaur_umum',
                'kaur_keuangan',
                'kaur_pembangunan',
                'kaur_keamanan_dan_ketertiban',
            ]);
            $table->string('photo');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('officials');
    }
}

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRpjmTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rpjm', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title', 100);
            $table->enum('category', [
                'penyelenggaraan', 'pelaksanaan', 'pembinaan', 'pemberdayaan',
            ]);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rpjm');
    }
}

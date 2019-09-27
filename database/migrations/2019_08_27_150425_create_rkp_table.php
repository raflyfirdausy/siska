<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRkpTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rkp', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('rpjm_id');
            $table->enum('category', [
                'penyelenggaraan', 'pelaksanaan', 'pembinaan', 'pemberdayaan',
            ]);
            $table->text('description');
            $table->string('target', 100);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rkp');
    }
}

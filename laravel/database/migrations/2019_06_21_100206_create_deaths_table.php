<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDeathsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('deaths', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('resident_id');
            $table->date('date_of_death');
            $table->time('time_of_death');
            $table->enum('place_of_death', [
                'rumah_sakit', 'lainnya',
            ]);
            $table->string('cause_of_death', 30);
            $table->enum('determinant', [
                'dokter', 'perawat', 'tenaga_kesehatan', 'lainnya',
            ]);
            $table->string('reporter', 30);
            $table->enum('reporter_relation', [
                'ayah', 'ibu', 'kakak', 'paman', 'bibi',
                'kakek', 'nenek', 'keponakan', 'sepupu', 'kerabat',
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
        Schema::dropIfExists('deaths');
    }
}

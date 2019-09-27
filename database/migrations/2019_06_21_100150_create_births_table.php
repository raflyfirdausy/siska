<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBirthsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('births', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('resident_id');
            $table->unsignedInteger('family_id');
            $table->unsignedInteger('father_id');
            $table->unsignedInteger('mother_id');
            $table->unsignedInteger('weight');
            $table->unsignedInteger('height');
            $table->date('date_of_birth');
            $table->time('time_of_birth');
            $table->string('place_of_birth', 100);
            $table->unsignedInteger('child_number');
            $table->enum('labor_place', [
                'rumah_bersalin', 'lainnya',
            ]);
            $table->enum('labor_helper', [
                'dokter', 'bidan', 'dukun', 'lainnya',
            ]);
            $table->string('reporter', 30);
            $table->enum('reporter_relation', [
                'ayah', 'ibu', 'kakak', 'paman', 'bibi',
                'kakek', 'nenek', 'keponakan', 'sepupu', 'kerabat',
            ]);
            $table->string('first_witness', 30);
            $table->string('second_witness', 30);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('births');
    }
}

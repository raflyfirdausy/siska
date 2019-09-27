<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateResidentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('residents', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nik', 30);
            $table->string('name', 100);
            $table->string('birth_place', 100);
            $table->date('birthday');
            $table->enum('nationality', [
                'wna', 'wni', 'dwi'
            ]);
            $table->string('photo')->nullable();
            $table->enum('gender', [
                'male', 'female'
            ]);
            $table->enum('blood_type', [
                'a', 'ab', 'b', 'o',
                'a+', 'b+', 'a-', 'b-',
                'o+', 'o-', 'ab+', 'ab-',
            ])->nullable();
            $table->enum('religion', [
                'islam', 'kristen', 'katolik', 'hindu', 'buddha', 'konghucu', 'kepercayaan',
            ]);
            $table->enum('marriage_status', [
                'kawin', 'belum_kawin', 'cerai_hidup', 'cerai_mati',
            ]);
            $table->enum('resident_status', [
                'asli', 'pendatang', 'pindah', 'sementara'
            ]);
            $table->unsignedInteger('education_id');
            $table->unsignedInteger('occupation_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('residents');
    }
}

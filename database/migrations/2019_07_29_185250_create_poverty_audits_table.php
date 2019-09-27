<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePovertyAuditsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('poverty_audits', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('resident_id');
            $table->string('answer', 14);
            $table->enum('result', ['miskin', 'bukan_miskin']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('poverty_audits');
    }
}

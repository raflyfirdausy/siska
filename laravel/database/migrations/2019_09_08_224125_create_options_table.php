<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('options', function (Blueprint $table) {
            $table->increments('id');
            $table->string('application_name');
            $table->string('province');
            $table->string('district');
            $table->string('sub_district');
            $table->string('village');
            $table->string('village_name');
            $table->string('office_name');
            $table->text('office_address');
            $table->string('postal_code', 5);
            $table->string('logo');
            $table->string('background_image');
            $table->string('phone', 25);
            $table->string('email', 60);
            $table->text('description');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('options');
    }
}

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateApbdTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('apbd', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('rpjm_id');
            $table->enum('category', [
                'penyelenggaraan', 'pelaksanaan', 'pembinaan', 'pemberdayaan',
            ]);
            $table->unsignedBigInteger('budget');
            $table->date('start_date');
            $table->date('end_date');
            $table->unsignedInteger('participants')->nullable(); // pemberdayaan, pembinaan, pelaksanaan
            $table->unsignedInteger('building_area')->nullable(); // pelaksanaan
            $table->unsignedInteger('village_business_id')->nullable(); //pemberdayaan
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('apbd');
    }
}

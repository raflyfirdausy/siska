<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExecutionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('executions', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('rpjm_id');
            $table->enum('category', [
                'penyelenggaraan', 'pelaksanaan', 'pembinaan', 'pemberdayaan',
            ]);
            $table->unsignedInteger('budget_source_id');
            $table->enum('status', [
                'sesuai', 'tidak',
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
        Schema::dropIfExists('executions');
    }
}

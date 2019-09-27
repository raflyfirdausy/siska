<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransfersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transfers', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('resident_id');
            $table->date('date_of_transfer');
            $table->string('destination_address', 150);
            $table->enum('reason', [
                'pekerjaan', 'pendidikan',
                'keamanan', 'kesehatan', 'perumahan',
                'keluarga', 'lainnya',
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
        Schema::dropIfExists('transfers');
    }
}

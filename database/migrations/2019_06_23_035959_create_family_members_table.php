<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFamilyMembersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('family_members', function (Blueprint $table) {
            $table->increments('id');
            $table->enum('relation', [
                'kepala', 'suami', 'istri', 'anak', 'menantu', 'cucu',
                'orang_tua', 'mertua', 'famili_lain', 'pembantu', 'lainnya',
            ]);
            $table->unsignedInteger('resident_id');
            $table->unsignedInteger('family_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('family_members');
    }
}

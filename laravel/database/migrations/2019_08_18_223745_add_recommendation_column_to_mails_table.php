<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddRecommendationColumnToMailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('mails', function (Blueprint $table) {
            $table->enum('recommendation', [
                'kepala_desa',
                'sekretaris',
                'bpd', 
                'kaur_pemerintah',
                'kaur_pembangunan',
                'kaur_kesejahteraan rakyat',
                'kaur_keuangan', 
                'kaur_umum',
            ]);
            //'kepala_desa,sekretaris,bpd,kaur_pemerintah,kaur_pembanguna,kaur_kesejahteraan rakyat,kaur_keuangan, kaur_umum'
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('mails', function (Blueprint $table) {
            //
        });
    }
}

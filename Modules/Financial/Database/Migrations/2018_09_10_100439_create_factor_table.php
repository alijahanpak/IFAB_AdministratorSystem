<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreateFactorTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('tbl_factors')) {
            Schema::create('tbl_factors', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->bigInteger('fRId')->length(20)->unsigned();
                $table->bigInteger('fSId')->length(20)->unsigned();
                $table->bigInteger('fFsId')->length(20)->unsigned();
                $table->string('fSubject');
                $table->unsignedBigInteger('fAmount');
                $table->longText('fDescription');
                $table->timestamps();

                $table->foreign('fRId')
                    ->references('id')->on('tbl_requests')
                    ->onDelete('restrict')
                    ->onUpdate('cascade');

                $table->foreign('fSId')
                    ->references('id')->on('tbl_sellers')
                    ->onDelete('restrict')
                    ->onUpdate('cascade');

                $table->foreign('fFsId')
                    ->references('id')->on('tbl_factor_states')
                    ->onDelete('restrict')
                    ->onUpdate('cascade');
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        Schema::dropIfExists('tbl_factors');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreateRequestCommoditiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('tbl_request_commodities')) {
            Schema::create('tbl_request_commodities', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->bigInteger('rcRId')->length(20)->unsigned();
                $table->bigInteger('rcCId')->length(20)->unsigned();
                $table->integer('rcCount');
                $table->integer('rcExistCount')->default(0);
                $table->unsignedBigInteger('rcCostEstimation');
                $table->boolean('rcIsExist')->default(false);
                $table->longText('rcDescription')->nullable();
                $table->timestamps();

                $table->foreign('rcRId')
                    ->references('id')->on('tbl_requests')
                    ->onDelete('restrict')
                    ->onUpdate('cascade');

                $table->foreign('rcCId')
                    ->references('id')->on('tbl_commodities')
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
        Schema::dropIfExists('tbl_request_commodities');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFinancialRequestQueueTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('tbl_financial_request_queue')) {
            Schema::create('tbl_financial_request_queue', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->bigInteger('frqRId')->length(20)->unsigned();
                $table->timestamps();

                $table->foreign('frqRId')
                    ->references('id')->on('tbl_requests')
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
        Schema::dropIfExists('tbl_financial_request_queue');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}

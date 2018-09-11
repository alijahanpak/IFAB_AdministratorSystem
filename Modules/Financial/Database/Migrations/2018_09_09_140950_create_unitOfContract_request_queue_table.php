<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUnitOfContractRequestQueueTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('tbl_unitOfContract_request_queue')) {
            Schema::create('tbl_unitOfContract_request_queue', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->bigInteger('ufcrqRId')->length(20)->unsigned();
                $table->timestamps();

                $table->foreign('ufcrqRId')
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
        Schema::dropIfExists('tbl_unitOfContract_request_queue');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}

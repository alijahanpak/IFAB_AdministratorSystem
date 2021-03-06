<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAccountantRequestQueueTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('tbl_accountant_request_queue')) {
            Schema::create('tbl_accountant_request_queue', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->bigInteger('arqRId')->length(20)->unsigned();
                $table->timestamps();

                $table->foreign('arqRId')
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
        Schema::dropIfExists('tbl_accountant_request_queue');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}

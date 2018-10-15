<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRefundFactor extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('tbl_refund_factors')) {
            Schema::create('tbl_refund_factors', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->bigInteger('rfFId')->length(20)->unsigned();
                $table->bigInteger('rfRId')->length(20)->unsigned();
                $table->boolean('rfIsAccepted')->default(false);
                $table->timestamps();

                $table->foreign('rfFId')
                    ->references('id')->on('tbl_factors')
                    ->onDelete('cascade')
                    ->onUpdate('cascade');

                $table->foreign('rfRId')
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
        Schema::dropIfExists('tbl_refund_factors');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}

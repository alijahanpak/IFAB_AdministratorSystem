<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreateRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('tbl_requests')) {
            Schema::create('tbl_requests', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->bigInteger('rRsId')->length(20)->unsigned();
                $table->bigInteger('rRtId')->length(20)->unsigned();
                $table->bigInteger('rUId')->length(20)->unsigned();
                $table->bigInteger('rFyId')->length(20)->unsigned();
                $table->string('rSubject');
                $table->unsignedBigInteger('rCostEstimation');
                $table->longText('rDescription')->nullable();
                $table->longText('rFurtherDetails')->nullable();
                $table->string('rLetterNumber')->nullable();
                $table->string('rLetterDate')->nullable();
                $table->boolean('isFromRefundCosts')->default(false);
                $table->timestamps();

                $table->foreign('rUId')
                    ->references('id')->on('users')
                    ->onDelete('restrict')
                    ->onUpdate('cascade');

                $table->foreign('rRtId')
                    ->references('id')->on('tbl_request_types')
                    ->onDelete('restrict')
                    ->onUpdate('cascade');

                $table->foreign('rRsId')
                    ->references('id')->on('tbl_request_states')
                    ->onDelete('restrict')
                    ->onUpdate('cascade');

                $table->foreign('rFyId')
                    ->references('id')->on('tbl_fiscal_years')
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
        Schema::dropIfExists('tbl_requests');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}

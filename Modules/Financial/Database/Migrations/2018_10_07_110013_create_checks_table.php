<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateChecksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('tbl_checks')) {
            Schema::create('tbl_checks', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->bigInteger('cDId')->length(20)->unsigned();
                $table->bigInteger('cPdId')->length(20)->unsigned()->nullable();
                $table->bigInteger('cCvId')->length(20)->unsigned()->nullable();
                $table->bigInteger('cFyId')->length(20)->unsigned();
                $table->bigInteger('cCsId')->length(20)->unsigned();
                $table->string('cDate')->nullable();
                $table->string('cIdNumber')->nullable()->unique();
                $table->dateTime('cDeliveryDate')->nullable();
                $table->string('cPayTo')->nullable();
                $table->string('cFor')->nullable();
                $table->unsignedBigInteger('cAmount');
                $table->timestamps();

                $table->foreign('cCsId')
                    ->references('id')->on('tbl_check_states')
                    ->onDelete('restrict')
                    ->onUpdate('cascade');

                $table->foreign('cDId')
                    ->references('id')->on('tbl_drafts')
                    ->onDelete('restrict')
                    ->onUpdate('cascade');

                $table->foreign('cPdId')
                    ->references('id')->on('tbl_percentage_decreases')
                    ->onDelete('restrict')
                    ->onUpdate('cascade');

                $table->foreign('cCvId')
                    ->references('id')->on('tbl_check_verifier')
                    ->onDelete('restrict')
                    ->onUpdate('cascade');

                $table->foreign('cFyId')
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
        Schema::dropIfExists('tbl_checks');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}

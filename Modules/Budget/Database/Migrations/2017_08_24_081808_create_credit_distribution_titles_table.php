<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCreditDistributionTitlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('tbl_credit_distribution_titles')) {
            Schema::create('tbl_credit_distribution_titles', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->bigInteger('cdtUId')->length(20)->unsigned();
                $table->bigInteger('cdtBsId')->length(20)->unsigned();
                $table->bigInteger('cdtCoId')->length(20)->unsigned()->nullable();
                $table->bigInteger('cdtCdtId')->length(20)->unsigned()->nullable();
                $table->string('cdtIdNumber')->unique();
                $table->string('cdtSubject');
                $table->longText('cdtDescription')->nullable();
                $table->timestamps();

                $table->foreign('cdtUId')
                    ->references('id')->on('users')
                    ->onDelete('restrict')
                    ->onUpdate('cascade');

                $table->foreign('cdtBsId')
                    ->references('id')->on('tbl_budget_seasons')
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
        Schema::dropIfExists('tbl_credit_distribution_titles');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCreditDistributionRowsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('tbl_credit_distribution_rows')) {
            Schema::create('tbl_credit_distribution_rows', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('cdUId')->length(10)->unsigned();
                $table->string('cdSubject');
                $table->longText('cdDescription')->nullable();
                $table->timestamps();

                $table->foreign('cdUId')
                    ->references('id')->on('users')
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
        Schema::dropIfExists('tbl_credit_distribution_rows');
    }
}
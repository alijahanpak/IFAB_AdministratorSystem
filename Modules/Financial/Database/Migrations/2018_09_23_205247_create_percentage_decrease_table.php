<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePercentageDecreaseTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('tbl_percentage_decreases')) {
            Schema::create('tbl_percentage_decreases', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->bigInteger('pdPiId')->length(20)->unsigned()->nullable();
                $table->bigInteger('pdPdcId')->length(20)->unsigned();
                $table->string('pdSubject');
                $table->unsignedTinyInteger('pdPercent');
                $table->boolean('pdState')->default(true);
                $table->timestamps();

                $table->foreign('pdPiId')
                    ->references('id')->on('tbl_percentage_increases')
                    ->onDelete('restrict')
                    ->onUpdate('cascade');

                $table->foreign('pdPdcId')
                    ->references('id')->on('tbl_pd_category')
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
        Schema::dropIfExists('tbl_percentage_decreases');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}

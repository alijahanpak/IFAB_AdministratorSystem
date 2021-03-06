<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePercentageIncreaseTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('tbl_percentage_increases')) {
            Schema::create('tbl_percentage_increases', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->bigInteger('piPicId')->length(20)->unsigned();
                $table->string('piSubject');
                $table->unsignedTinyInteger('piPercent');
                $table->boolean('piState')->default(true);
                $table->timestamps();

                $table->foreign('piPicId')
                    ->references('id')->on('tbl_pi_category')
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
        Schema::dropIfExists('tbl_percentage_increases');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}

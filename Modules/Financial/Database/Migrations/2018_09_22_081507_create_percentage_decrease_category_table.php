<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePercentageDecreaseCategoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('tbl_pd_category')) {
            Schema::create('tbl_pd_category', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('pdcSubject');
                $table->boolean('pdcState')->default(true);
                $table->timestamps();
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
        Schema::dropIfExists('tbl_pd_category');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePercentageIncreaseCategoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('tbl_pi_category')) {
            Schema::create('tbl_pi_category', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('picSubject');
                $table->boolean('picState')->default(true);
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
        Schema::dropIfExists('tbl_pi_category');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}

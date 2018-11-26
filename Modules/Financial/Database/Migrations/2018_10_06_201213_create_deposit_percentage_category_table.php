<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDepositPercentageCategoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('tbl_deposit_percentage_category')) {
            Schema::create('tbl_deposit_percentage_category', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('dpcSubject');
                $table->boolean('dpcState')->default(true);
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
        Schema::dropIfExists('tbl_deposit_percentage_category');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}

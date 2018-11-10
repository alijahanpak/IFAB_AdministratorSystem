<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDepositPercentageTypeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('tbl_deposit_percentage_types')) {
            Schema::create('tbl_deposit_percentage_types', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('dptSubject');
                $table->string('dptType');
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
        Schema::dropIfExists('tbl_deposit_percentage_types');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}

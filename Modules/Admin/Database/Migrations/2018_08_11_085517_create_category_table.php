<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCategoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('tbl_categories')) {
            Schema::create('tbl_categories', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('cSubject');
                $table->string('cCategory');
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
        Schema::dropIfExists('tbl_categories');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}

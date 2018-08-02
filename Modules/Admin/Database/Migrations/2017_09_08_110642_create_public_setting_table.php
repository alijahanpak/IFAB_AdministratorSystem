<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePublicSettingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('tbl_public_setting')) {
            Schema::create('tbl_public_setting', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('psOrgName')->nullable();
                $table->string('psProvincePlanLabel')->nullable();
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
        Schema::dropIfExists('tbl_public_setting');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}

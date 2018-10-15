<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCheckFormatTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('tbl_check_formats')) {
            Schema::create('tbl_check_formats', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('cfSubject')->unique();
                $table->boolean('cfState')->defualt(true);
                $table->unsignedTinyInteger('cfDateTop');
                $table->unsignedTinyInteger('cfDateRight');
                $table->unsignedTinyInteger('cfDateWidth');
                $table->unsignedTinyInteger('cfStringDateTop');
                $table->unsignedTinyInteger('cfStringDateRight');
                $table->unsignedTinyInteger('cfStringDateWidth');
                $table->unsignedTinyInteger('cfForTop');
                $table->unsignedTinyInteger('cfForRight');
                $table->unsignedTinyInteger('cfForWidth');
                $table->unsignedTinyInteger('cfPayToTop');
                $table->unsignedTinyInteger('cfPayToRight');
                $table->unsignedTinyInteger('cfPayToWidth');
                $table->unsignedTinyInteger('cfStringAmountTop');
                $table->unsignedTinyInteger('cfStringAmountRight');
                $table->unsignedTinyInteger('cfStringAmountWidth');
                $table->unsignedTinyInteger('cfAmountTop');
                $table->unsignedTinyInteger('cfAmountRight');
                $table->unsignedTinyInteger('cfAmountWidth');
                $table->unsignedTinyInteger('cfSignatureTop');
                $table->unsignedTinyInteger('cfSignatureRight');
                $table->unsignedTinyInteger('cfSignatureWidth');
                $table->unsignedTinyInteger('cfSecondSignatureTop')->default(0);
                $table->unsignedTinyInteger('cfSecondSignatureRight')->default(0);
                $table->unsignedTinyInteger('cfSecondSignatureWidth')->default(0);
                $table->unsignedTinyInteger('cfWidth');
                $table->unsignedTinyInteger('cfHeight');
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
        Schema::dropIfExists('tbl_check_formats');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}

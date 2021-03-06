<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFiscalYearsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('tbl_fiscal_years')) {
            Schema::create('tbl_fiscal_years', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->bigInteger('fyUId')->length(20)->unsigned();
                $table->unsignedTinyInteger('fyStatus')->default(0);
                $table->string('fyLabel');
                $table->longText('fyDescription')->nullable();
                $table->timestamps();

                $table->foreign('fyUId')
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
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        Schema::dropIfExists('tbl_fiscal_years');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCapitalAssetsAllocationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('tbl_capital_assets_allocation')) {
            Schema::create('tbl_capital_assets_allocation', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->bigInteger('caaUId')->length(20)->unsigned();
                $table->bigInteger('caaCcsId')->length(20)->unsigned()->nullable();
                $table->bigInteger('caaFyId')->length(20)->unsigned()->nullable();
                $table->bigInteger('caaDtId')->length(20)->unsigned()->nullable();
                $table->bigInteger('caaFoundId')->length(20)->unsigned()->nullable();
                $table->string('caaLetterNumber')->nullable();
                $table->string('caaLetterDate')->nullable();
                $table->string('caaSymbolOfAkhza')->nullable();
                $table->string('caaDueDate')->nullable();
                $table->boolean('caaFound')->default(false);
                $table->unsignedBigInteger('caaAmount');
                $table->longText('caaDescription')->nullable();
                $table->timestamps();

                $table->foreign('caaUId')
                    ->references('id')->on('users')
                    ->onDelete('restrict')
                    ->onUpdate('cascade');

                $table->foreign('caaDtId')
                    ->references('id')->on('tbl_due_type')
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
        Schema::dropIfExists('tbl_capital_assets_allocation');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCostAllocationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('tbl_cost_allocation')) {
            Schema::create('tbl_cost_allocation', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->bigInteger('caUId')->length(20)->unsigned();
                $table->bigInteger('caCcsId')->length(20)->unsigned()->nullable();
                $table->bigInteger('caFyId')->length(20)->unsigned()->nullable();
                $table->bigInteger('caFoundId')->length(20)->unsigned()->nullable();
                $table->string('caLetterNumber')->nullable();
                $table->string('caLetterDate')->nullable();
                $table->boolean('caFound')->default(false);
                $table->unsignedBigInteger('caAmount');
                $table->longText('caDescription')->nullable();
                $table->timestamps();

                $table->foreign('caUId')
                    ->references('id')->on('users')
                    ->onDelete('restrict')
                    ->onUpdate('cascade');

                $table->foreign('caCcsId')
                    ->references('id')->on('tbl_ca_credit_source')
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
        Schema::dropIfExists('tbl_cost_allocation');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}

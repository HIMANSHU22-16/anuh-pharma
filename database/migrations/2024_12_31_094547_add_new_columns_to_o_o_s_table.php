<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('o_o_s', function (Blueprint $table) {
            $table->longText('hypothesis_investigator_01')->nullable();
            $table->longText('approval_two')->nullable();
            $table->longText('approval_three')->nullable();
            $table->longText('phase_1_result_01')->nullable();
            $table->longText('phase_1_test_result_01')->nullable();
            $table->longText('phase_1_limit_01')->nullable();
            $table->longText('phase_1_conclusion_01')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('o_o_s', function (Blueprint $table) {
            //
        });
    }
};

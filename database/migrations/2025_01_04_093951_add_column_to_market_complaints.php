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
        Schema::table('market_complaints', function (Blueprint $table) {
            //
            $table->longText('cancelled_by')->nullable();
            $table->longText('cancelled_on')->nullable();
            $table->longText('cancelledcomment')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('market_complaints', function (Blueprint $table) {
            //
        });
    }
};

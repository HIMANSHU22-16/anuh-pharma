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
            $table->longtext('moreinfo_hod_primary_by')->nullable();
            $table->longtext('moreinfo_hod_primary_on')->nullable();
            $table->longtext('moreinfo_hod_primary_comment')->nullable();
            $table->longtext('moreinfo_cqa_qahead_primary_by')->nullable();
            $table->longtext('moreinfo_cqa_qahead_primary_on')->nullable();
            $table->longtext('moreinfo_cqa_qahead_primary_comment')->nullable();
            $table->longtext('request_moreinfo_by')->nullable();
            $table->longtext('request_moreinfo_on')->nullable();
            $table->longtext('request_moreinfo_comment')->nullable();
            $table->longtext('moreinfo_phase_IA_hod_by')->nullable();
            $table->longtext('moreinfo_phase_IA_hod_on')->nullable();
            $table->longtext('moreinfo_phase_IA_hod_comment')->nullable();
            $table->longtext('moreinfo_phase_qa_review_by')->nullable();
            $table->longtext('moreinfo_phase_qa_review_on')->nullable();
            $table->longtext('moreinfo_phase_qa_review_comment')->nullable();
            $table->longtext('moreinfo_assignable_couse_by')->nullable();
            $table->longtext('moreinfo_assignable_couse_on')->nullable();
            $table->longtext('moreinfo_assignable_couse_comment')->nullable();
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

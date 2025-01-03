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
            $table->longtext('completed_by_assignable_cause')->nullable();
            $table->longtext('completed_on_assignable_cause')->nullable();
            $table->longtext('comment_under_assignable_cause')->nullable();
            $table->longtext('completed_by_phase2_A')->nullable();
            $table->longtext('completed_on_phase2_A')->nullable();
            $table->longtext('comment_phase2_A')->nullable();
            $table->longtext('completed_by_phase2_hod_review')->nullable();
            $table->longtext('completed_on_phase2_hod_review')->nullable();
            $table->longtext('comment_phase2_hod_review')->nullable();
            $table->longtext('completed_by_phase2_cqa_qa')->nullable();
            $table->longtext('completed_on_phase2_cqa_qa')->nullable();
            $table->longtext('comment_phase2_cqa_qa')->nullable();
            $table->longtext('completed_by_phase2_assignable_cause_not')->nullable();
            $table->longtext('completed_on_phase2_assignable_cause_not')->nullable();
            $table->longtext('comment_phase2_assignable_cause_not')->nullable();
            $table->longtext('completed_by_phase2_b_hod_primary')->nullable();
            $table->longtext('completed_on_phase2_b_hod_primary')->nullable();
            $table->longtext('comment_phase2_b_hod_primary')->nullable();
            $table->longtext('completed_by_phase2_b_hod_review')->nullable();
            $table->longtext('completed_on_phase2_b_hod_review')->nullable();
            $table->longtext('comment_phase2_b_hod_review')->nullable();
            $table->longtext('completed_by_phase2_b_cqa_qa_review')->nullable();
            $table->longtext('completed_on_phase2_b_cqa_qa_review')->nullable();
            $table->longtext('comment_phase2_b_cqa_qa_review')->nullable();
            $table->longtext('completed_by_phase2_b_assignable_couse_not')->nullable();
            $table->longtext('completed_on_phase2_b_assignable_couse_not')->nullable();
            $table->longtext('comment_phase2_b_assignable_couse_not')->nullable();

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

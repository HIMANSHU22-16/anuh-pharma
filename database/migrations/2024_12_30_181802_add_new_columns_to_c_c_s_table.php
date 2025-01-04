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
        Schema::table('c_c_s', function (Blueprint $table) {
            $table->longText('priority_data')->nullable();
            $table->longText('reviewer_person_value')->nullable();
            $table->longText('HOD_attachment')->nullable();
            $table->longText('risk_assessment_atch')->nullable();
            $table->longText('qa_final_to_qainital_by')->nullable();
            $table->longText('qa_final_to_qainital_on')->nullable();
            $table->longText('qa_final_to_HOD_by')->nullable();
            $table->longText('qa_final_to_HOD_on')->nullable();
            $table->longText('qa_final_to_HOD_comment')->nullable();
            $table->longText('qa_final_to_initiator_comment')->nullable();
            $table->longText('qa_final_to_initiator_by')->nullable();
            $table->longText('qa_final_to_initiator_on')->nullable();


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('c_c_s', function (Blueprint $table) {
            //
        });
    }
};

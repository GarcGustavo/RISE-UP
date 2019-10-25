<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCaseParametersTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('case_parameters', function (Blueprint $table) {
            $table->foreign('c_owner')->references('cid')->on('case');
            $table->foreign('c_group')->references('csp_id')->on('cs_parameter');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('case_parameters');
    }
}

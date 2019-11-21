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
        Schema::create('Case_Parameters', function (Blueprint $table) {
            $table->unsignedBigInteger('c_owner');
            $table->unsignedBigInteger('c_group');
            $table->foreign('c_owner')->references('cid')->on('Case');
            $table->foreign('c_group')->references('csp_id')->on('CS_Parameter');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('Case_Parameters');
    }
}

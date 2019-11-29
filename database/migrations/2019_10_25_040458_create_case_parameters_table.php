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
            $table->unsignedBigInteger('cid');
            $table->unsignedBigInteger('csp_id');
            $table->unsignedBigInteger('opt_selected')->nullable();
            $table->foreign('cid')->references('cid')->on('Case');
            $table->foreign('csp_id')->references('csp_id')->on('CS_Parameter');
            $table->foreign('opt_selected')->references('oid')->on('Option');
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

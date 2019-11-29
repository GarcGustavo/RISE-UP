<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOptionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Option', function (Blueprint $table) {
            $table->bigIncrements('oid');
            $table->unsignedBigInteger('o_parameter');
            $table->foreign('o_parameter')->references('csp_id')->on('CS_Parameter')->onDelete('cascade')->onUpdate('cascade');
            $table->string('o_content', 255);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('Option');
    }
}

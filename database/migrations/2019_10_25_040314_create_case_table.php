<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCaseTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Case', function (Blueprint $table) {
            $table->bigIncrements('cid');
            $table->string('c_title', 255);
            $table->string('c_description', 255);
            $table->string('c_thumbnail', 255);
            $table->string('c_status', 255);
            $table->date('c_date');
            $table->foreign('c_owner')->references('uid')->on('user');
            $table->foreign('c_group')->references('gid')->on('group');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('Case');
    }
}

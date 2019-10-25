<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateGroupTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Group', function (Blueprint $table) {
            $table->bigIncrement('gid');
            $table->string('g_name');
            $table->string('g_status');
            $table->date('g_creation_date');
            $table->foreign('g_owner')->references('uid')->on('user');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('Group');
    }
}

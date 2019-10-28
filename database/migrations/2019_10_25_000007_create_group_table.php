<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
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
            $table->bigIncrements('gid');
            $table->string('g_name');
            $table->string('g_status');
            $table->date('g_creation_date');
            $table->unsignedBigInteger('g_owner');
            $table->foreign('g_owner')->references('uid')->on('User');
        
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

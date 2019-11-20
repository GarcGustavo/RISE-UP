<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserGroupsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('User_Groups', function (Blueprint $table) {
            $table->unsignedBigInteger('gid');
            $table->unsignedBigInteger('uid');
            $table->foreign('gid')->references('gid')->on('Group');
            $table->foreign('uid')->references('uid')->on('User');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('User_Groups');
    }
}

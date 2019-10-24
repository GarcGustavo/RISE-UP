<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUserTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user', function (Blueprint $table) {
            $table->bigIncrements('uid');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email');
            $table->string('contact_email');
            $table->date('u_creation_date');
            $table->string('u_ban_status');
            $table->string('current_edit_cid');
            $table->foreign('u_role')->references('rid')->on('role');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('user');
    }
}

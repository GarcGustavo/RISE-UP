<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
class CreateUserTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('User', function (Blueprint $table) {
            $table->bigIncrements('uid');
            $table->string('first_name', 255);
            $table->string('last_name', 255);
            $table->string('email', 255);
            $table->string('contact_email', 255);
            $table->date('u_creation_date');
            $table->date('u_expiration_date');
            $table->boolean('u_ban_status');
            $table->boolean('u_role_upgrade_request');
            $table->unsignedBigInteger('current_edit_cid')->nullable();
            $table->unsignedBigInteger('u_role');
            $table->foreign('u_role')->references('rid')->on('Role');
            $table->softDeletes();
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        Schema::drop('User');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}

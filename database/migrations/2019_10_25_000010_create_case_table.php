<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
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
            $table->unsignedBigInteger('c_owner');
            $table->unsignedBigInteger('c_group')->nullable();
            $table->foreign('c_owner')->references('uid')->on('User');
            $table->foreign('c_group')->references('gid')->on('Group')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::drop('Case');
    }
}

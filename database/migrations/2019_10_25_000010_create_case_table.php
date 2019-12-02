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
            $table->string('c_thumbnail', 255)->nullable();
            $table->string('c_status', 255);
            $table->date('c_date');
            $table->date('c_incident_date')->nullable()->default(NULL);
            $table->unsignedBigInteger('c_owner');
            $table->unsignedBigInteger('c_group')->nullable()->default(NULL);
            $table->foreign('c_owner')->references('uid')->on('User');
            $table->foreign('c_group')->references('gid')->on('Group');
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

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Item', function (Blueprint $table) {
            $table->bigIncrements('iid');
            $table->text('i_content');
            $table->unsignedBigInteger('i_case');
            $table->unsignedBigInteger('i_type');
            $table->foreign('i_case')->references('cid')->on('Case');
            $table->foreign('i_type')->references('itt_id')->on('Item_Type');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('Item');
    }
}

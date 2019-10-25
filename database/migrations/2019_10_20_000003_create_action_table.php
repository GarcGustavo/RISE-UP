<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
class CreateActionTable extends Migration
{
   
    /**
     * Run the migrations.
     * @table action
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Action', function (Blueprint $table) {

            $table->bigIncrements('aid');
            $table->date('a_date');
            $table->foreign('a_type')->references('act_id')->on('action_type');
            $table->foreign('a_user')->references('uid')->on('user');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
     public function down()
     {
       Schema::dropIfExists('Action');
     }
}

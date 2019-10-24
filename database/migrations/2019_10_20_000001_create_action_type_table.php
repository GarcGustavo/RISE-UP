<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
class CreateActionTypeTable extends Migration
{
   
    /**
     * Run the migrations.
     * @table action_type
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->'Action_Type', function (Blueprint $table) {
          
            $table->bigIncrements('act_id');
            $table->string('act_name', 225);

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
     public function down()
     {
       Schema::dropIfExists($this->tableName);
     }
}

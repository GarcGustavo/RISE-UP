<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
class CreateRoleTable extends Migration
{
 
 
    /**
     * Run the migrations.
     * @table role
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Role', function (Blueprint $table) {
            
            $table->bigIncrements('rid');
            $table->date('r_creation_date');
            $table->string('r_name', 225);
           
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
     public function down()
     {
       Schema::dropIfExists('Role');
     }
}

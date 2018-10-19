<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUniDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('uniDetails',function(Blueprint $table){
           $table->increments('id');
           $table->string('uniNameCN');
           $table->string('debateQues1')->default(null);
           $table->string('debateQues2')->default(null);
           $table->string('debateQues3')->default(null);
           $table->dateTime('simTimeStart')->default(null);
           $table->dateTime('simTimeEnd')->default(null);
           $table->dateTime('simTimeDiff')->default(null);
           $table->dateTime('offTimeStart')->default(null);
           $table->dateTime('offTimeEnd')->default(null);
           $table->dateTime('offTimeDiff')->default(null);
           $table->boolean('drawn')->default(0);
           $table->boolean('qualified')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::dropIfExists('uniDetails');
    }
}

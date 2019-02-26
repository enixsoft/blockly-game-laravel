<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGameplayTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gameplay', function (Blueprint $table) {
            $table->increments('id');
            
            $table->string('username');
            $table->integer('category');
            $table->integer('level');
            $table->time('level_start');
            $table->integer('task');
            $table->time('task_start');
            $table->time('task_end')->nullable();
            $table->integer('task_elapsed_time')->nullable();
            $table->integer('rating')->nullable();
            $table->text('code');
            $table->string('result');           

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('gameplay');
    }
}

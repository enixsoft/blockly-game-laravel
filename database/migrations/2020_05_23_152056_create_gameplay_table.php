<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->unsignedInteger('user_id');
            $table->unsignedTinyInteger('category');
            $table->unsignedTinyInteger('level');
            $table->time('level_start');
            $table->unsignedTinyInteger('task');
            $table->time('task_start');
            $table->time('task_end')->nullable();
            $table->unsignedSmallInteger('task_elapsed_time')->nullable();
            $table->unsignedTinyInteger('rating')->nullable();
            $table->text('code');
            $table->string('result');
            $table->timestamps();

            $table->foreign('user_id')
                ->references('id')->on('users')
                ->onDelete('CASCADE');
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

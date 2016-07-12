<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->increments('id');            
            $table->string('name');
            $table->integer('user_id')->unsigned()->index();
            $table->foreign('user_id')
                ->references('id')->on('users');    
            $table->string('description')->nullable();        
            $table->enum('state', ['new', 'inprogress', 'finished'])->default('new');
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
        Schema::drop('tasks');
    }
}

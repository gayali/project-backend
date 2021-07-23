<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->id();
            $table->string('task_title');
            $table->enum('status',['Backlog','To do','Doing','Ready for review','Dev','Test','Staging','Archive','Production','Finished'])->default('Backlog');
            $table->string('branch_name');
            $table->unsignedBigInteger('reporter_user_id');
            $table->foreign("reporter_user_id")->references('id')->on('users');
            $table->unsignedBigInteger('assignee_user_id');
            $table->foreign("assignee_user_id")->references('id')->on('users');
            $table->text('description');
            $table->unsignedBigInteger('project_id');
            $table->foreign("project_id")->references('id')->on('projects');
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
        Schema::dropIfExists('tasks');
    }
}

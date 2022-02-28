<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateTaskWithSprint extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tasks', function (Blueprint $table) {
            $table->text('description')->nullable()->change();
            $table->text('start_date')->nullable()->change();
            $table->text('end_date')->nullable()->change();
            $table->unsignedBigInteger('sprint_id')->nullable();
            $table->foreign('sprint_id')->references('id')->on('sprints');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tasks', function (Blueprint $table) {
            $table->dropColumn('sprint_id');
            $table->dropForeign('sprint_id');
        });
    }
}

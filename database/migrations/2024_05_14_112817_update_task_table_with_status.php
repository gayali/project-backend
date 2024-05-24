<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateTaskTableWithStatus extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        if(Schema::hasTable('tasks')){
            if (Schema::hasColumn('tasks','status')) {
               Schema::table('tasks',  function (Blueprint $table) {
                $table->dropColumn('status');
               });

               Schema::table('tasks',  function (Blueprint $table) {
                $table->string('status');
               });

            }
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if(Schema::hasTable('tasks')){
            if (Schema::hasColumn('tasks','status')) {
               Schema::table('tasks',  function (Blueprint $table) {
                $table->dropColumn('status');
               });

               Schema::table('tasks',  function (Blueprint $table) {
                $table->enum('status',['Backlog','To do','Doing','Ready for review','Dev','Test','Staging','Archive','Production','Finished'])->default('Backlog');
               });

            }
        }

    }
}

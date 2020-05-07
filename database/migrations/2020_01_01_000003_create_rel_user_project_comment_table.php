<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRelUserProjectTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rel_user_projects', function (Blueprint $table) {
            $table->string('id',32)->primary();
            $table->bigInteger('user_id');
            $table->bigInteger('project_id');

            $table->foreign('user_id')->references('id')->on('projects');
            $table->foreign('project_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rel_user_projects');
    }
}

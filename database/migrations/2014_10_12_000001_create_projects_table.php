<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->id('id');
            $table->string('image',40)->default('project-default.png');
            $table->string('name',200);
            $table->string('initials',10)->unique();
            $table->text('description')->nullable();
            $table->bigInteger('enterprise_id')->default(0);
            $table->bigInteger('supervisor_id')->nullable();
            $table->bigInteger('status_id')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('enterprise_id')->on('enterprises')->references('id');
            $table->foreign('status_id')->on('system_class')->references('id');
            $table->foreign('supervisor_id')->on('users')->references('id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('projects');
    }
}

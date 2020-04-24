<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSystemClassTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('system_class', function (Blueprint $table) {
            $table->id('id');
            $table->string('name',50);
            $table->string('description',250)->nullable();
            $table->string('integration',50)->nullable();
            $table->bigInteger('parent_id')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('parent_id')->on('system_class')->references('id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('system_class');
    }
}

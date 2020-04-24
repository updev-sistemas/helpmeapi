<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id('id');
            $table->string('name',50);
            $table->string('photo',50)->default('user-default.png');
            $table->string('email',120)->unique();
            $table->string('username',30)->unique()->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->timestamp('last_change_password')->nullable();
            $table->string('password',512);
            $table->bigInteger('paper_id');
            $table->bigInteger('enterprise_id');
            $table->bigInteger('status_id');
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('enterprise_id')->on('enterprises')->references('id');
            $table->foreign('status_id')->on('system_class')->references('id');
            $table->foreign('paper_id')->on('system_class')->references('id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}

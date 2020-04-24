<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEnterpriseTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('enterprises', function (Blueprint $table) {
            $table->id();
            $table->string('name',200);
            $table->string('image',40)->default('enterprise-default.png');
            $table->string('document',14)->unique();
            $table->string('email',120)->unique()->nullable();
            $table->string('phone',200)->nullable();
            $table->string('address_name',200)->nullable();
            $table->string('address_district',100);
            $table->string('address_cep',20)->nullable();
            $table->string('address_city',200)->nullable();
            $table->string('address_state_uf',2)->nullable();
            $table->bigInteger('subsidiary_id')->default(0)->nullable();
            $table->bigInteger('status_id');
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('subsidiary_id')->on('enterprises')->references('id');
            $table->foreign('status_id')->on('system_class')->references('id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('enterprises');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->increments('id');
            $table->string('password');
            $table->unsignedInteger('consultant_id');
            $table->foreign('consultant_id')->references('id')->on('users');
            $table->string('name');
            $table->string('email');
            $table->string('phone');
            $table->unique(['consultant_id', 'email']);
            $table->unique(['consultant_id', 'phone']);
            $table->string('address')->nullable();
            $table->string('registered_address')->nullable();
            $table->integer('is_public_entity')->default(0);
            $table->text('nature_of_business');
            $table->text('doubts');
            $table->integer('is_verified')->default(0);
            $table->softDeletes();
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
        Schema::dropIfExists('clients');
    }
}

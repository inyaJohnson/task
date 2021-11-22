<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientSubsidiariesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('client_subsidiaries', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('consultant_id');
            $table->foreign('consultant_id')->references('id')->on('users');
            $table->unsignedInteger('client_id');
            $table->foreign('client_id')->references('id')->on('clients')->onDelete('cascade');
            $table->string('name');
            $table->integer('percentage_holding')->nullable();
            $table->string('nature');
            $table->text('nature_of_business');
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
        Schema::dropIfExists('client_subsidiaries');
    }
}

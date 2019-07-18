<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdoptRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('adopt_requests', function (Blueprint $table) {
          $table->increments('id');
          $table->bigInteger('userid')->unsigned();
          $table->bigInteger('animalID')->unsigned();
          $table->date('dateSubmitted');
          $table->enum('adoptionStatus',['Accepted', 'Rejected', 'Pending'])->default('Pending');
          $table->timestamps();
          $table->foreign('userid')->references('id')->on('users');
          $table->foreign('animalID')->references('id')->on('animals');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('adopt_requests');
    }
}

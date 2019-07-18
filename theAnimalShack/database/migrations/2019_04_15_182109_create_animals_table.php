<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAnimalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('animals', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', 32)->unique();
            $table->enum('species',['cat', 'dog', 'hamster','goldfish', 'mouse', 'other'])->default('cat');
            $table->date('dob');
            $table->string('description', 256)->nullable();
            $table->string('image', 256)->nullable();
            $table->boolean('adoptionStatus')->default('0');
            $table->bigInteger('ownerID')->nullable();
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
        Schema::dropIfExists('animals');
    }
}

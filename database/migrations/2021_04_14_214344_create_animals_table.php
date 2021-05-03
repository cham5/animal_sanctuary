<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->id();
            $table->timestamps();
            $table->string('name');
            $table->date('dob');
            $table->string('description');
            // an animal's picture can be set to null.
            $table->string('picture')->nullable();
            // enum values for availability - either Available or Unavailable.
            $table->enum('availability', ['Available', 'Unavailable']);
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

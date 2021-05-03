<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdoptionRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('adoption_requests', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->bigInteger('user_id')->unsigned();
            $table->bigInteger('animal_id')->unsigned();
            // whenever adoption requests are created, their status will automatically
            // be set to pending by default.
            $table->enum('status', ['Pending', 'Approved', 'Denied'])->default('Pending');
            // foreign keys - referencing a user and animal object.
            $table->foreign('user_id')->references('id')->on('users');
            // cascading so that when an animal entry is successfully deleted, its associated
            // adoption requests are also deleted.
            $table->foreign('animal_id')->references('id')->on('animals')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('adoption_requests');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
            $table->string('question_id', 20)->nullable();
            $table->string('answer_id', 20)->nullable();
            $table->text('content');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('question_id')
                  ->references('id')->on('questions')
                  ->onDelete('cascade');

            $table->foreign('answer_id')
                  ->references('id')->on('answers')
                  ->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('comments');
    }
}

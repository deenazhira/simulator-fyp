<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('feedback', function (Blueprint $table) {
    $table->id('feedback_id');

    $table->unsignedBigInteger('user_id');
    $table->unsignedBigInteger('trainer_id')->nullable();
    $table->unsignedBigInteger('score_id')->nullable();

    $table->text('feedback_desc');
    $table->timestamps();

    $table->foreign('user_id')
          ->references('user_id')
          ->on('users')
          ->onDelete('cascade');

    $table->foreign('trainer_id')
          ->references('trainer_id')
          ->on('trainers')
          ->onDelete('set null');

    $table->foreign('score_id')
          ->references('id') // <- match the scores PK
          ->on('scores')
          ->onDelete('set null');
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('feedback');
    }
};

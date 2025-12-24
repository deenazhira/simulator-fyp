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
    Schema::create('trainer_feedback', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('user_id');          // Who is the feedback for?
        $table->unsignedBigInteger('trainer_id');       // Who wrote it?
        $table->unsignedBigInteger('quiz_result_id');   // Which quiz is this about?

        $table->text('feedback_text');                  // The message
        $table->string('recommended_action');           // e.g., "Reattempt Simulation"

        $table->timestamps();

        // Foreign keys
        $table->foreign('user_id')->references('user_id')->on('users')->onDelete('cascade');
        $table->foreign('trainer_id')->references('user_id')->on('users')->onDelete('cascade');
        $table->foreign('quiz_result_id')->references('id')->on('quiz_results')->onDelete('cascade');
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trainer_feedback');
    }
};

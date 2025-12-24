<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void {

    Schema::create('quiz_results', function (Blueprint $table) {
        $table->id(); // Result ID

        // This links the result to a specific user
        $table->unsignedBigInteger('user_id');

        // The score (e.g., 80)
        $table->integer('score');

        // (Optional) Total questions, e.g., 10
        $table->integer('total_questions')->default(10);

        $table->timestamps(); // Created at (Date taken)

        // Foreign Key Constraint (Connects to your custom user_id)
        $table->foreign('user_id')->references('user_id')->on('users')->onDelete('cascade');
    });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quiz_results');
    }
};

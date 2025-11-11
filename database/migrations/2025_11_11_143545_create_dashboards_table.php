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
        Schema::create('dashboards', function (Blueprint $table) {
        $table->id('dash_id');
        $table->foreignId('user_id')->constrained('users', 'user_id')->onDelete('cascade');
        $table->foreignId('trainer_id')->nullable()->constrained('trainers', 'trainer_id')->onDelete('set null');
        $table->foreignId('feedback_id')->nullable()->constrained('feedback', 'feedback_id')->onDelete('set null');
        $table->string('dash_title');
        $table->text('dash_desc')->nullable();
        $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dashboards');
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
{
    Schema::create('users', function (Blueprint $table) {
        $table->id('user_id');
        $table->string('user_name');
        $table->string('user_email')->unique();
        $table->timestamp('email_verified_at')->nullable();
        $table->string('user_password');

        // UPDATE 1: Add 'trainer' and 'admin' to roles
        // 'public' = Free User
        // 'enterprise' = Paid Staff (Under a trainer)
        // 'trainer' = The Manager/Trainer
        // 'admin' = Super Admin
        $table->enum('user_role', ['public', 'enterprise', 'trainer', 'admin'])->default('public');

        // UPDATE 2: Link a user to a specific trainer
        // If I am a staff member, this ID points to my Manager.
        // If I am a Public user or a Trainer myself, this is NULL.
        $table->unsignedBigInteger('trainer_id')->nullable();

        $table->string('company_name')->nullable();
        $table->rememberToken();
        $table->timestamps();

        // Optional: Add foreign key constraint if you want strict linking
        // $table->foreign('trainer_id')->references('user_id')->on('users');
    });
}

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};

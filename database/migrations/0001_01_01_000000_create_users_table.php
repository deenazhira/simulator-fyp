<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    // In database/migrations/xxxx_create_users_table.php

public function up(): void
{
    Schema::create('users', function (Blueprint $table) {
        $table->id('user_id'); // Primary Key
        $table->string('user_name'); // Changed from 'name' to match your controller
        $table->string('user_email')->unique(); // Changed from 'email'
        $table->timestamp('email_verified_at')->nullable();
        $table->string('user_password'); // Changed from 'password'

        // 1. ROLES: 'public' (Free), 'enterprise' (Staff), 'trainer' (Manager)
        $table->enum('user_role', ['public', 'enterprise', 'trainer', 'admin'])->default('public');

        // 2. LINK: If I am staff, who is my manager? (Nullable for Public/Trainers)
        $table->unsignedBigInteger('trainer_id')->nullable();

        $table->string('company_name')->nullable();
        $table->rememberToken();
        $table->timestamps();
    });

}

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};

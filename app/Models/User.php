<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * 1. Define your custom Primary Key
     * Laravel expects 'id', but your migration has 'user_id'
     */
    protected $primaryKey = 'user_id';

    /**
     * 2. Allow Mass Assignment for your custom columns
     */
    protected $fillable = [
        'user_name',
        'user_email',
        'user_password',
        'user_role',      // 'public', 'enterprise', 'trainer'
        'company_name',
        'trainer_id',     // To link staff to trainer
    ];

    /**
     * 3. Hide the custom password column
     */
    protected $hidden = [
        'user_password',
        'remember_token',
    ];

    /**
     * 4. Casts: Map your custom password column for hashing
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'user_password' => 'hashed', // Changed from 'password' to 'user_password'
        ];
    }

    /**
     * 5. CRITICAL: Tell Laravel to look at 'user_password' for login authentication
     */
    public function getAuthPassword()
    {
        return $this->user_password;
    }

    /**
     * 6. CRITICAL: Tell Laravel to look at 'user_email' for finding users
     * This is needed for password resets and some auth checks.
     */
    public function getEmailForPasswordReset()
    {
        return $this->user_email;
    }
}


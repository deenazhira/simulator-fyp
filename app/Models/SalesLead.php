<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SalesLead extends Model
{
    protected $fillable = [
        'full_name',
        'company_name',
        'email',
        'phone',
        'role',
        'team_size',
        'message',
    ];
}

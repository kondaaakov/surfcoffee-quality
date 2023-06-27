<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UsersProfiles extends Model
{
    use HasFactory;

    protected $attributes = [

    ];

    protected $fillable = [
        'firstname', 'lastname', 'phone',
        'telegram_nickname', 'user_id',
    ];
}

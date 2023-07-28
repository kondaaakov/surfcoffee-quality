<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SecretGuest extends Model
{
    use HasFactory;

    protected $attributes = [
        'status' => 1,
    ];

    protected $fillable = [
        'name', 'phone', 'telegram_nickname', 'city', 'status',
    ];
}

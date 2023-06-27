<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $attributes = [
        'group_id' => 1,
        'active'  => true,
    ];

    protected $fillable = [
        'login', 'email',
        'phone', 'telegram_nickname',
        'firstname', 'lastname',
        'avatar', 'group_id',
        'active', 'password',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];
}

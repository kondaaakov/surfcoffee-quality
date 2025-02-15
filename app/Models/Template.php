<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Template extends Model
{
    use HasFactory;

    protected $attributes = [
        'active' => 1,
    ];

    protected $fillable = [
        'title', 'categories', 'active'
    ];
}

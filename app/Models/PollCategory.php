<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PollCategory extends Model
{
    use HasFactory;

    protected $table = 'polls_categories';

    protected $attributes = [
        'rate'   => 0,
        'result' => 0
    ];

    protected $fillable = [
        'poll_id', 'category_id', 'weight', 'rate', 'result'
    ];
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Poll extends Model
{
    use HasFactory;

    protected $attributes = [
        'closed' => 0,
    ];

    protected $fillable = [
        'template_id', 'spot_id', 'secret_guest_id', 'until_at', 'closed', 'result', 'closed_at', 'receipt', 'comment'
    ];

    protected $casts = [
        'until_at' => 'datetime:Y-m-d',
        'closed_at' => 'datetime:Y-m-d H:i:s',
    ];
}

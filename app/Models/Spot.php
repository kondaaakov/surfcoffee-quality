<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Spot extends Model
{
    use HasFactory;

    protected $attributes = [
        'active' => 1,
    ];

    protected $fillable = [
        'external_id', 'title',
        'city', 'status', 'active'
    ];

    public function rate() : string {
        $rate = $this->getRate();

        if ($rate === 0) {
            $rate = "нет оценки";
        }

        return "$rate";
    }

    private function getRate() : int {
        return DB::table('polls')->where("spot_id", $this->id)->avg('result');
    }
}

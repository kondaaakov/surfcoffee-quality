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

    public function rate($classes = '') : string {
        $rate = $this->getRate();

        if ($rate === 0) {
            $rate = "нет оценки";
        } else if ($rate >= 80) {
            $rate = "<span class='fw-bold text-success $classes'>$rate</span>";
        } else if ($rate >= 50) {
            $rate = "<span class='fw-bold text-warning $classes'>$rate</span>";
        } else {
            $rate = "<span class='fw-bold text-danger $classes'>$rate</span>";
        }

        return $rate;
    }

    private function getRate() : int {
        return DB::table('polls')->where("spot_id", $this->id)->avg('result') ?? 0;
    }
}

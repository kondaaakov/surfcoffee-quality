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

        return "<span class='fw-bold fs-4'>$rate</span>";
    }

    private function getRate() : int {
        $reviews = DB::table('secret_guests_reviews')->where(['spot_id' => $this->external_id])->get();

        if ($reviews->isNotEmpty()) {
            return 5;
        } else {
            return 0;
        }
    }
}

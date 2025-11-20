<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GambarReview extends Model
{
    protected $fillable = [
        'review_id',
        'gambar',
    ];

    public function review()
    {
        return $this->belongsTo(Review::class);
    }
}

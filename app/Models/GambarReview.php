<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GambarReview extends Model
{
    use HasFactory;
    protected $fillable = [
        'review_id',
        'gambar',
    ];

    public function review()
    {
        return $this->belongsTo(Review::class);
    }
}

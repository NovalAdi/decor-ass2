<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Alamat extends Model
{
    protected $fillable = [
        'user_id',
        'judul',
        'alamat',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

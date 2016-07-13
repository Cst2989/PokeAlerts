<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
     protected $fillable = [
        'location_title', 'city',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

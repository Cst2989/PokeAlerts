<?php

namespace App;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Alert extends Model
{
   protected $fillable = [
       'city','pokemon_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

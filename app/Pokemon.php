<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pokemon extends Model
{
     protected $fillable = [
        'name', 'filename','rarity',
    ];
}

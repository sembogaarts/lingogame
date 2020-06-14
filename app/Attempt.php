<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Attempt extends Model
{
    protected $fillable = [
        'round_id',
        'word'
    ];
}

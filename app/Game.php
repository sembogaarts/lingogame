<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    protected $fillable = [
        'user_id',
        'word_length'
    ];

    public function rounds() {
        return $this->hasMany(Round::class, 'game_id', 'id');
    }
}

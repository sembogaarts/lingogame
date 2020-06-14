<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Round extends Model
{
    protected $fillable = [
        'game_id',
        'word',
        'success',
        'finished_at'
    ];

    public function attempts() {
        return $this->hasMany(Attempt::class, 'round_id', 'id');
    }
}

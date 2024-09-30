<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MatchSquads extends Model
{
    use HasFactory;
    protected $fillable = [
        "player_id",
        "team_id",
        "match_id",
    ];

    public function player()
    {
        return $this->belongsTo(User::class, 'player_id');
    }
}

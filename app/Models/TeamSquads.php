<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TeamSquads extends Model
{
    use HasFactory;
    protected $fillable = [
        "player_id",
        "team_id",
    ] ;

    public function user()
    {
        return $this->belongsTo(User::class, 'player_id');
    }
}

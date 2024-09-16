<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MatchBattingHistory extends Model
{
    use HasFactory;
    protected $fillable = [
        'player_id',
        'match_id',
        'team_id',
        'run',
        'ball',
        'status',
    ];

    
    public function player()
    {
        return $this->belongsTo(User::class, 'player_id');
    }

    
    public function match()
    {
        return $this->belongsTo(Matches::class, 'match_id');
    }
}

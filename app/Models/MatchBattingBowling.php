<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MatchBattingBowling extends Model
{
    use HasFactory;
    protected $fillable = [
        'match_id',
        'batting_team',
        'bowling_team'
    ];

    public function battingTeam()
    {
        return $this->belongsTo(Team::class, 'batting_team');
    }

    public function bowlingTeam()
    {
        return $this->belongsTo(Team::class, 'bowling_team');
    }

    public function matches()
    {
        return $this->belongsTo(Matches::class, 'match_id');
    }
}

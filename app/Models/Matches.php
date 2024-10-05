<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Matches extends Model
{
    use HasFactory;
    protected $fillable = [
        "Tournament_id",
        "venu_id",
        "team_1",
        "team_2",
        "total_run",
        "wicket",
        "is_end",
        "match_date",
        "start_time",
    ];

    public function battingTeam()
    {
        return $this->belongsTo(Team::class, 'batting_team_id');
    }

    public function bowlingTeam()
    {
        return $this->belongsTo(Team::class, 'bowling_team_id');
    }

    public function teamOne()
    {
        return $this->belongsTo(Team::class, 'team_1');
    }

    public function teamTwo()
    {
        return $this->belongsTo(Team::class, 'team_2');
    }
}
